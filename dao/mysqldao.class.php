<?php
class MysqlDao
{
	private $mysql = null;
	private $lasterror = '';
	function __construct()
	{
		$this->mysql = new mysqli(DB_MYSQL_HOST,DB_MYSQL_USERNAME,DB_MYSQL_PASSWORD,DB_MYSQL_DBNAME,DB_MYSQL_PORT);
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

	// 获取出错原因
	function getLastError()
	{
		return $this->lasterror;
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
		$this->mysql->query('END');
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
		$this->mysql->query('END');
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
	function addNewBasesvrds($basesvrds)
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}
		if (!($basesvrds instanceof Basesvrds)) 
		{
			$this->lasterror = sprintf("param errro\n");
			return false;
		}
		date_default_timezone_set('Asia/Shanghai');
		$time = date("Y-m-d H:i:s");
		$strsql = "INSERT INTO basesvrds VALUES(NULL,'$basesvrds->adminsvrd','$basesvrds->dbsvrd','$basesvrds->friendsvrd','$basesvrds->logsvrd','$basesvrds->propertysvrd','$basesvrds->proxysvrd','$basesvrds->roommngsvrd','$basesvrds->shopsvrd','$basesvrds->statsvrd','$basesvrds->websvrd','$time')";

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

		$strsql = "SELECT MAX(version) version FROM basesvrds;";
		$result = $this->mysql->query($strsql);
		if (!$result)
		{
			$this->lasterror = sprintf("Add failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}

		$row = $result->fetch_assoc();
		$versions->basesvrds_ver = $row['version'];

		$strsql = "INSERT INTO versions VALUES(NULL,$versions->type,'$versions->so','$versions->gamesvrd','$versions->client',$versions->basesvrds_ver,'$versions->time','$versions->comment')";	
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
	function getCurrentBasesvrdsVersionInfo()
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$strsql = "SELECT * FROM basesvrds ORDER BY time DESC  LIMIT 1";
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
		return new Basesvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
	}

	// 获取某游戏当前版本信息
	function getGameCurrentVersionsInfo($gametype)
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
		$basesvrds = new Basesvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
		$versions = new Versions($row['type'],$row['so'],$row['gamesvrd'],$row['client'],$row['comment']);
		$versions->version = $row['basesvrds_ver'];
		$versions->time = $row['time'];
		$versions->version = $row['version'];

		return new GameCurrentVersionsInfo($gameinfo,$basesvrds,$versions);
	}
	// 获取某游戏某个版本信息
	function getGameThisVersionsInfo($gametype,$version)
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
		$basesvrds = new Basesvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
		$versions = new Versions($row['type'],$row['so'],$row['gamesvrd'],$row['client'],$row['comment']);
		$versions->time = $row['time'];
		$versions->version = $row['basesvrds_ver'];
		$versions->version = $row['version'];

		return new GameCurrentVersionsInfo($gameinfo,$basesvrds,$versions);
	}
	// 获取所有游戏当前版本信息
	function getCurrentVersionsInfo()
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
			$basesvrds = new Basesvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
			$versions = new Versions($row['type'],$row['so'],$row['gamesvrd'],$row['client'],$row['comment']);
			$versions->time = $row['time'];
			$versions->version = $row['basesvrds_ver'];
			$versions->version = $row['version'];
			$returns[] = new GameCurrentVersionsInfo($gameinfo,$basesvrds,$versions);
		}

		return $returns;
	}
	// 获取某游戏的版本信息
	function getGameVersionsInfoByType($gametype)
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$strsql = "SELECT * FROM gamevisioninfo WHERE type=$gametype ORDER BY version DESC";
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
			$basesvrds = new Basesvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
			$versions = new Versions($row['type'],$row['so'],$row['gamesvrd'],$row['client'],$row['comment']);
			$versions->time = $row['time'];
			$versions->version = $row['basesvrds_ver'];
			$versions->version = $row['version'];
			$returns[] = new GameCurrentVersionsInfo($gameinfo,$basesvrds,$versions);
		}

		return $returns;
	}
	// 获取某游戏的版本信息
	function getGameVersionsInfoByName($gamename)
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$strsql = "SELECT * FROM gamevisioninfo WHERE name='$gamename' ORDER BY version DESC";
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
			$basesvrds = new Basesvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
			$versions = new Versions($row['type'],$row['so'],$row['gamesvrd'],$row['client'],$row['comment']);
			$versions->time = $row['time'];
			$versions->version = $row['basesvrds_ver'];
			$versions->version = $row['version'];
			$returns[] = new GameCurrentVersionsInfo($gameinfo,$basesvrds,$versions);
		}

		return $returns;
	}
	// 获取某个版本的版本信息
	function getGameVersionsInfoByVersion($version)
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
			$basesvrds = new Basesvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
			$versions = new Versions($row['type'],$row['so'],$row['gamesvrd'],$row['client'],$row['comment']);
			$versions->time = $row['time'];
			$versions->version = $row['basesvrds_ver'];
			$versions->version = $row['version'];
			$returns[] = new GameCurrentVersionsInfo($gameinfo,$basesvrds,$versions);
		}

		return $returns;
	}
	// 获取全部游戏的所有版本信息
	function getVersionsInfo()
	{
		if ($this->mysql->connect_errno)
		{
			$this->lasterror = sprintf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$strsql = "SELECT * FROM gamevisioninfo ORDER BY type,version DESC";
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
			$basesvrds = new Basesvrds($row['adminsvrd'],$row['dbsvrd'],$row['friendsvrd'],$row['logsvrd'],$row['propertysvrd'],$row['proxysvrd'],$row['roommngsvrd'],$row['shopsvrd'],$row['statsvrd'],$row['websvrd']);
			$versions = new Versions($row['type'],$row['so'],$row['gamesvrd'],$row['client'],$row['comment']);
			$versions->time = $row['time'];
			$versions->version = $row['basesvrds_ver'];
			$versions->version = $row['version'];
			$returns[] = new GameCurrentVersionsInfo($gameinfo,$basesvrds,$versions);
		}

		return $returns;
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
* addNewBasesvrd 传入类
*/
class Basesvrds
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
	public $basesvrds_ver;
	public $time;
	public $comment;
	function __construct($type,$so,$gamesvrd,$client,$comment)
	{
		$this->version = -1;
		$this->type = $type;
		$this->so = $so;
		$this->gamesvrd = $gamesvrd;
		$this->client = $client;
//		$this->basesvrds_ver = $basesvrds_ver;
		$this->basesvrds_ver = -1;
		date_default_timezone_set('Asia/Shanghai');
		$this->time = date("Y-m-d H:i:s");
		$this->comment = $comment;
	}
}

/**
* getGameCurrentVersionsInfo 传出类
*/
class GameCurrentVersionsInfo
{
	public $gameinfo;
	public $basesvrds;
	public $versions;
	function __construct($gameinfo,$basesvrds,$versions)
	{
		$this->gameinfo = $gameinfo;
		$this->basesvrds = $basesvrds;
		$this->versions = $versions;
	}
}
?>
