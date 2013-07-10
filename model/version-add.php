<?php
require_once(DAO_DIR.'/mysqldao.class.php');
$page_title = '上线版本';
if (isset($_POST['games']) && isset($_POST['svrds'])) {
	$version_helper = new VersionHelper($_POST['games'],$_POST['svrds']);
	if ($version_helper->addNewVersions()) {
		$add_result = '添加成功';
	}
	else {
		$add_result = $version_helper->getLastError();
	}
}

/**
* 处理添加版本
*/
class VersionHelper
{
	private $games;
	private $svrds;
	private $error = '';
	private $commonsvrds = array('adminsvrd','dbsvrd','friendsvrd','logsvrd','propertysvrd','proxysvrd','roommngsvrd','shopsvrd','statsvrd','websvrd');
	function __construct($json_games,$json_svrds)
	{
		$this->games = json_decode($json_games);
		$this->svrds = json_decode($json_svrds);
	}

	function getLastError()
	{
		return $this->error;
	}

	private function isDataTypeOk()
	{
		foreach ($this->games as $game) {
			if (!isset($game->name) || !isset($game->so) || !isset($game->client) || !isset($game->gamesvrd) || !isset($game->comment)) {
				return false;
			}
		}

		foreach ($this->commonsvrds as $commonsvrd) {
			if (!isset($commonsvrd->name) || !isset($commonsvrd->version)) {
				return false;
			}
		}

		return true;
	}

	private function isHaveRepeat()
	{
		foreach ($this->games as $game) {
			foreach ($this->games as $inner_game) {
				if ($game->name == $inner_game->name) {
					return false;
				}
			}
		}

		foreach ($this->svrds as $svrd) {
			foreach ($this->svrds as $inner_svrd) {
				if ($svrd->name == $inner_svrd->name) {
					return false;
				}
			}
		}

		return true;
	}

	private function isGamesVersionHaveSame($current_versions)
	{
		foreach ($this->games as $gameversion) {
			foreach ($current_versions as $version) {
				if ($version->name == $gameversion->name) {
					if ($gameversion->so == $version->so && $gameversion->client == $version->client && $gameversion->gamesvrd == $version->gamesvrd) {
						return true;
					}
				}
			}
		}

		return false;
	}

	private function getGameTypeByName($gamesinfo,$name)
	{
		foreach ($gamesinfo as $gameinfo) {
			if ($gameinfo->name == $name) {
				return $gameinfo->type;
			}
		}

		return false;
	}

	function addNewVersions()
	{
		if ($this->games === false || $this->svrds === false)
		{
			$this->error = 'json data error';
			return false;
		}

		if (count($this->games) <= 0 && count($this->svrds) <= 0) {
			$this->error = 'no update';
			return false;
		}

		// 检查数据类型是否合法
		if (!$this->isDataTypeOk()) {
			$this->error = 'unlegal json data';
			return false;
		}

		// 检查数据是否重复
		if (!$this->isHaveRepeat()) {
			$this->error = 'unlegal json data';
			return false;
		}

		$dao = new MysqlDao();
		$gamesinfo = $dao->getGameInfo();
		$current_svrds = $dao->getCurrentCommonsvrdVersionInfo();
		$current_versions = $dao->getCurrentVersionInfo();

		if ($current_versions === false || $current_svrds === false || $gamesinfo === false) {
			$this->error = $dao->getLastError();
			return false;
		}

		// 检查共用数据库是否合法
		$no_commsvrds_update = count($this->svrds) ? false:true;
		if (!$no_commsvrds_update) {
			foreach ($this->svrds as $svrd) {
				if (!in_array($svrd->name, $this->commonsvrds)) {
					$this->error = 'the server '.$svrd->name.' is not exists,please add first';
					return false;
				}
			}
		}

		// 检查游戏是否合法
		$no_games_update = count($this->games) ? false:true;
		if (!$no_games_update) {
			foreach ($this->games as $game) {
				$find = false;
				foreach ($gamesinfo as $gameinfo) {
					if ($game->name === $gameinfo->name) {
						$find = true;
						break;
					}
				}
				if (!$find) {
					$this->error = 'the game '.$svrd->name.' is not exists,please add first';
					return false;
				}
			}
		}

		// 第一次需要检查公共服务器的数据是否齐全
		if ($current_svrds === true && count($svrds) != count($this->commonsvrds)) {
			$this->error = '第一次需要填写所有共用服务器的版本号';
			return false;
		}

		// 构建添加公共服务器记录
		if (!$no_commsvrds_update) {		// 有公共服务器升级
			if ($current_svrds !== true) {	// 不是第一次,需要检查版本是否真的有变动
				$have_diff = false;
				foreach ($this->games as $game) {
					if ($game->version != $current_svrds->{$game->name}) {
						$have_diff = true;
						$current_svrds->{$game->name} = $game->version;
					}
				}
				if (!$have_diff) {
					$this->error = '非法请求,公共服务器没有变动';
					return false;
				}
			}
			else {
				foreach ($this->games as $game) {
					$current_svrds->{$game->name} = $game->version;
				}
			}
		}

		$new_versions = array();
		// 构建添加版本
		if (!$no_games_update) {	// 有游戏升级
			if ($this->isGamesVersionHaveSame($current_versions) && $no_commsvrds_update) {
				$this->error = "有些游戏不需要升级";
				return false;
			}

			foreach ($this->games as $game) {
				$type = $this->getGameTypeByName($gamesinfo,$game->name);
				$new_versions[$game->name] = new Versions($type,$game->so,$game->gamesvrd,$game->client,$game->comment);
			}
		}

		if (!$no_commsvrds_update) { // 如果有公共服务器升级则所有游戏都要升级
			foreach ($current_versions as $current_version) {
				if (!isset($new_versions[$current_version->name])) {
					$new_versions[$game->name] = new Versions($current_version->type,$current_version->so,$current_version->gamesvrd,$current_version->client,'共用服务器升级');
				}
			}
		}

		// 修改数据库，使用事物保证原子性
		$dao->begin();
		if (!$no_commsvrds_update) {
			if (!$dao->addNewCommonSvrds($current_svrds)) {
				$this->error = $dao->getLastError();
				$dao->rollback();
				return false;
			}
		}

		foreach ($new_versions as $new_version) {
			if (!$dao->addNewVersions($new_version)) {
				$this->error = $dao->getLastError();
				$dao->rollback();
				return false;
			}
		}

		$dao->commit();
		return true;
	}
}
?>