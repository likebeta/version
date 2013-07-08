<?php
$page_title = '添加游戏';
if (isset($_POST['gametype']) && isset($_POST['gamename']) && isset($_POST['gamedesc'])) {
	$value_error = '';
	if (!preg_match('/^[1-9][0-9]*$/', $_POST['gametype'])) {
		$value_error = ' 游戏类型';
	}

	if (!preg_match('/^[1-9a-zA-Z]+$/', $_POST['gamename'])) {
		$value_error .= ' 游戏缩写';
	}

	if (!preg_match('/^.+$/', $_POST['gamedesc'])) {
		$value_error .= ' 游戏名称';
	}

	if ($value_error === '') {
		require_once(DAO_DIR.'/mysqldao.class.php');
		$dao = new MysqlDao();
		$gameinfo = new GameInfo($_POST['gametype'],$_POST['gamename'],$_POST['gamedesc']);
		$result = $dao->addNewGame($gameinfo);
		if (!$result) {
			$add_result = $dao->getLastError();
		}
		else {
			$add_result = "添加成功";
		}
	}
	else {
		$add_result = $value_error.' 填写有误';
	}
}
?>