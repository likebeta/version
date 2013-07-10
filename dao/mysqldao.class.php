<?php
class MysqlDao
{
	private $mysql = null;
	private $lasterror = '';
	function __construct()
	{
		$this->mysql = new mysqli($_ENV['DB_MYSQL_HOST'],$_ENV['DB_MYSQL_USERNAME'],$_ENV['DB_MYSQL_PASSWORD'],$_ENV['DB_MYSQL_DBNAME'],$_ENV['DB_MYSQL_PORT']);
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
		}
	}

	function __destruct()
	{
		if (!$this->mysql->connect_errno)
		{
			$this->mysql->close();
		}		
	}

	function begin()
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$this->mysql->query('BEGIN');
		return true;
	}

	function commit()
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$this->mysql->query('COMMIT');
		return true;
	}

	function rollback()
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$this->mysql->query('ROLLBACK');
		return true;
	}

	// 添加游戏
	function addNewGame($game)
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}
		if (!($game instanceof GameInfo))
		{
			$this->lasterror = sprintf("param errro\n");
			return false;
		}

		$strsql = "INSERT INTO gameinfo VALUES($game->type,'$game->name','$game->description')";
		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			$this->lasterror = sprintf("Add failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}
		return true;
	}
	// 添加共用服务器版本
	function addNewCommonSvrds($commonsvrds)
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}
		if (!($commonsvrds instanceof CommonSvrds)) 
		{
			$this->lasterror = sprintf("param errro\n");
			return false;
		}
		date_default_timezone_set('Asia/Shanghai');
		$time = date("Y-m-d H:i:s");
		$strsql = "INSERT INTO commonsvrds VALUES(NULL,'$commonsvrds->adminsvrd','$commonsvrds->dbsvrd','$commonsvrds->friendsvrd','$commonsvrds->logsvrd','$commonsvrds->propertysvrd','$commonsvrds->proxysvrd','$commonsvrds->roommngsvrd','$commonsvrds->shopsvrd','$commonsvrds->statsvrd','$commonsvrds->websvrd','$time')";

		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			$this->lasterror = sprintf("Add failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}
		return true;
	}
	// 添加版本
	function addNewVersions($versions)
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}
		if (!($versions instanceof Versions)) 
		{
			$this->lasterror = sprintf("param errro\n");
			return false;
		}

		$strsql = "SELECT MAX(version) version FROM commonsvrds;";
		$result = $this->mysql->query($strsql);
		if (!$result)
		{
			$this->lasterror = sprintf("Add failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}

		$row = $result->fetch_assoc();
		$versions->version = $row['version'];

		$strsql = "INSERT INTO versions VALUES(NULL,$versions->type,'$versions->so','$versions->gamesvrd','$versions->client',$versions->commonsvrds_ver,'$versions->time','$versions->comment')";
		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			$this->lasterror = sprintf("Add failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}
		return true;
	}
	// 获取摸个游戏或者全部游戏信息
	function getGameInfo($gametype=-1)
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}	
		
		if ($gametype == -1)
		{
			$strsql = "SELECT type,name,description FROM gameinfo";
		}
		else
		{
			$strsql = "SELECT type,name,description FROM gameinfo where type=$gametype";
		}

		$result = $this->mysql->query($strsql);
		if (!$result)
		{
			$this->lasterror = sprintf("Query failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}

		$returns = array();
		while ($row = $result->fetch_assoc())
		{
			$returns[] = new GameInfo($row['type'],$row['name'],$row['description']);
		}
		
		return $returns;
	}
	// 获取当前通用服务器版本信息
	function getCurrentCommonsvrdVersionInfo()
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$strsql = "SELECT * FROM commonsvrds ORDER BY time DESC  LIMIT 1";
		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			$this->lasterror = sprintf("Query failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}

		if ($result->num_rows != 1)
		{
			return true;
		}

		$row = $result->fetch_assoc();
		return new CommonSvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
	}

	// 获取某游戏当前版本信息
	function getGameCurrentVersionInfo($gametype)
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$strsql = "SELECT * FROM gamevisioninfo WHERE type=$gametype ORDER BY version DESC LIMIT 1";
		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			$this->lasterror = sprintf("Query failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}

		if ($result->num_rows != 1)
		{
			return true;
		}

		$row = $result->fetch_assoc();
		$gameinfo = new GameInfo($row['type'],$row['name'],$row['description']);
		$commonsvrds = new CommonSvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
		$versions = new Versions($row['type'],$row['so'],$row['gamesvrd'],$row['client'],$row['comment']);
		$versions->version = $row['commonsvrds_ver'];
		$versions->time = $row['time'];
		$versions->version = $row['version'];

		return new GameCurrentVersionInfo($gameinfo,$commonsvrds,$versions);
	}
	// 获取某游戏某个版本信息
	function getGameThisVersionInfo($gametype,$version)
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$strsql = "SELECT * FROM gamevisioninfo WHERE type=$gametype AND version=$version";
		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			$this->lasterror = sprintf("Query failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}

		if ($result->num_rows != 1)
		{
			return true;
		}

		$row = $result->fetch_assoc();
		$gameinfo = new GameInfo($row['type'],$row['name'],$row['description']);
		$commonsvrds = new CommonSvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
		$versions = new Versions($row['type'],$row['so'],$row['gamesvrd'],$row['client'],$row['comment']);
		$versions->time = $row['time'];
		$versions->version = $row['commonsvrds_ver'];
		$versions->version = $row['version'];

		return new GameCurrentVersionInfo($gameinfo,$commonsvrds,$versions);
	}
	// 获取所有游戏当前版本信息
	function getCurrentVersionInfo()
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$strsql = "SELECT * FROM gamevisioninfo WHERE version IN (SELECT MAX(version) FROM gamevisioninfo GROUP BY type)";
		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			$this->lasterror = sprintf("Query failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}

		$returns = array();
		while ($row = $result->fetch_assoc())
		{
			$gameinfo = new GameInfo($row['type'],$row['name'],$row['description']);
			$commonsvrds = new CommonSvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
			$versions = new Versions($row['type'],$row['so'],$row['gamesvrd'],$row['client'],$row['comment']);
			$versions->time = $row['time'];
			$versions->version = $row['commonsvrds_ver'];
			$versions->version = $row['version'];
			$returns[] = new GameCurrentVersionInfo($gameinfo,$commonsvrds,$versions);
		}

		return $returns;
	}
	// 获取某游戏的版本信息
	function getGameVersionInfoByType($gametype)
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$strsql = "SELECT * FROM gamevisioninfo WHERE type=$gametype";
		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			$this->lasterror = sprintf("Query failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}

		$returns = array();
		while ($row = $result->fetch_assoc())
		{
			$gameinfo = new GameInfo($row['type'],$row['name'],$row['description']);
			$commonsvrds = new CommonSvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
			$versions = new Versions($row['type'],$row['so'],$row['gamesvrd'],$row['client'],$row['comment']);
			$versions->time = $row['time'];
			$versions->version = $row['commonsvrds_ver'];
			$versions->version = $row['version'];
			$returns[] = new GameCurrentVersionInfo($gameinfo,$commonsvrds,$versions);
		}

		return $returns;
	}
	// 获取某游戏的版本信息
	function getGameVersionInfoByName($gamename)
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$strsql = "SELECT * FROM gamevisioninfo WHERE name='$gamename'";
		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			$this->lasterror = sprintf("Query failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}

		$returns = array();
		while ($row = $result->fetch_assoc())
		{
			$gameinfo = new GameInfo($row['type'],$row['name'],$row['description']);
			$commonsvrds = new CommonSvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
			$versions = new Versions($row['type'],$row['so'],$row['gamesvrd'],$row['client'],$row['comment']);
			$versions->time = $row['time'];
			$versions->version = $row['commonsvrds_ver'];
			$versions->version = $row['version'];
			$returns[] = new GameCurrentVersionInfo($gameinfo,$commonsvrds,$versions);
		}

		return $returns;
	}
	// 获取某个版本的版本信息
	function getGameVersionInfoByVersion($version)
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$strsql = "SELECT * FROM gamevisioninfo WHERE version=$version";
		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			$this->lasterror = sprintf("Query failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}

		$returns = array();
		while ($row = $result->fetch_assoc())
		{
			$gameinfo = new GameInfo($row['type'],$row['name'],$row['description']);
			$commonsvrds = new CommonSvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
			$versions = new Versions($row['type'],$row['so'],$row['gamesvrd'],$row['client'],$row['comment']);
			$versions->time = $row['time'];
			$versions->version = $row['commonsvrds_ver'];
			$versions->version = $row['version'];
			$returns[] = new GameCurrentVersionInfo($gameinfo,$commonsvrds,$versions);
		}

		return $returns;
	}
	// 获取全部游戏的所有版本信息
	function getVersionInfo()
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$strsql = "SELECT * FROM gamevisioninfo ORDER BY type";
		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			$this->lasterror = sprintf("Query failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}

		$returns = array();
		while ($row = $result->fetch_assoc())
		{
			$gameinfo = new GameInfo($row['type'],$row['name'],$row['description']);
			$commonsvrds = new CommonSvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
			$versions = new Versions($row['type'],$row['so'],$row['gamesvrd'],$row['client'],$row['comment']);
			$versions->time = $row['time'];
			$versions->version = $row['commonsvrds_ver'];
			$versions->version = $row['version'];
			$returns[] = new GameCurrentVersionInfo($gameinfo,$commonsvrds,$versions);
		}

		return $returns;
	}
	// 获取出错原因
	function getLastError()
	{
		return $this->lasterror;
	}
}

/**
* addNewGame 传入类
*/
class GameInfo
{
	public $type;
	public $name;
	public $description;
	function __construct($type,$name,$desc)
	{
		$this->type = $type;
		$this->name = $name;
		$this->description = $desc;
	}
}

/**
* addNewCommonsvrd 传入类
*/
class CommonSvrds
{
	public $adminsvrd;
	public $dbsvrd;
	public $friendsvrd;
	public $logsvrd;
	public $propertysvrd;
	public $proxysvrd;
	public $roommngsvrd;
	public $shopsvrd;
	public $statsvrd;
	public $websvrd;
//	public $time;
	function __construct($adminsvrd,$dbsvrd,$friendsvrd,$logsvrd,$propertysvrd,$proxysvrd,$roommngsvrd,$shopsvrd,$statsvrd,$websvrd)
	{
		$this->adminsvrd = $adminsvrd;
		$this->dbsvrd = $dbsvrd;
		$this->friendsvrd = $friendsvrd;
		$this->logsvrd = $logsvrd;
		$this->propertysvrd = $propertysvrd;
		$this->proxysvrd = $proxysvrd;
		$this->roommngsvrd = $roommngsvrd;
		$this->shopsvrd = $shopsvrd;
		$this->statsvrd = $statsvrd;
		$this->websvrd = $websvrd;
//		date_default_timezone_set('Asia/Shanghai');
//		$this->time = date("Y-m-d H:i:s");
	}
}

/**
* addNewVersion 传入类
*/
class Versions
{
	public $version;
	public $type;
	public $so;
	public $gamesvrd;
	public $client;
	public $commonsvrds_ver;
	public $time;
	public $comment;
	function __construct($type,$so,$gamesvrd,$client,$comment)
	{
		$this->version = -1;
		$this->type = $type;
		$this->so = $so;
		$this->gamesvrd = $gamesvrd;
		$this->client = $client;
//		$this->commonsvrds_ver = $commonsvrds_ver;
		$this->commonsvrds_ver = -1;
		date_default_timezone_set('Asia/Shanghai');
		$this->time = date("Y-m-d H:i:s");
		$this->comment = $comment;
	}
}

/**
* getGameCurrentVersionInfo 传出类
*/
class GameCurrentVersionInfo
{
	public $gameinfo;
	public $commonsvrds;
	public $versions;
	function __construct($gameinfo,$commonsvrds,$versions)
	{
		$this->gameinfo = $gameinfo;
		$this->commonsvrds = $commonsvrds;
		$this->versions = $versions;
	}
}
?>
