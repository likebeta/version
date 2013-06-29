<?php
require('config.inc.php');
class MysqlDao
{
	private $mysql = null;
	function __construct()
	{
		$this->mysql = new mysqli(DB_MYSQL_HOST,DB_MYSQL_USERNAME,DB_MYSQL_PASSWORD,DB_MYSQL_DBNAME,DB_MYSQL_PORT);
		if ($this->mysql->connect_errno)
		{
			printf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
		}
	}
	function __destruct()
	{
		if (!$this->mysql->connect_errno)
		{
			$this->mysql->close();
		}		
	}
	function addNewGame($game)
	{
		if ($this->mysql->connect_errno)
		{
			printf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}
		if (!($game instanceof GameType) || !$game->isLegal()) 
		{
			printf("param errro\n");
			return false;
		}

		$strsql = "INSERT INTO gametype VALUES($game->type,'$game->name','$game->description')";
		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			printf("Add failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}
		return true;
	}

	function addNewCommonSvrds($commonsvrds)
	{
		if ($this->mysql->connect_errno)
		{
			printf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}
		if (!($commonsvrds instanceof CommonSvrds) || !$commonsvrds->isLegal()) 
		{
			printf("param errro\n");
			return false;
		}

		$strsql = "INSERT INTO commonsvrds VALUES(NULL,'$commonsvrds->adminsvrd','$commonsvrds->dbsvrd','$commonsvrds->friendsvrd','$commonsvrds->logsvrd','$commonsvrds->propretysvrd','$commonsvrds->proxysvrd','$commonsvrds->roommngsvrd','$commonsvrds->shopsvrd','$commonsvrds->statsvrd','$commonsvrds->websvrd','$commonsvrds->time')";

		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			printf("Add failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}
		return true;
	}

	function addNewVersions($versions)
	{
		if ($this->mysql->connect_errno)
		{
			printf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}
		if (!($versions instanceof Versions) || !$versions->isLegal()) 
		{
			printf("param errro\n");
			return false;
		}

		$strsql = "INSERT INTO versions VALUES(NULL,$versions->type,'$versions->so','$versions->gamesvrd','$versions->client',$versions->commonsvrds_ver,'$versions->time','$versions->comment')";
		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			printf("Add failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}
		return true;
	}

	function getGameType($gametype)
	{
		if ($this->mysql->connect_errno)
		{
			printf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}	
		
		$strsql = "SELECT type,name,description FROM gametype where type=$gametype";
		$result = $this->mysql->query($strsql);
		if (!$result) {
			printf("query failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}
		$row = $this->mysql->fetch_assoc();
		
		return new GameType($row['type'],$row['name'],$row['description']);
	}

	function getCurrentGameInfo($gametype)
	{
		if ($this->mysql->connect_errno)
		{
			printf("Connect Error (%s) : %s\n",$this->mysql->connect_errno,$this->mysql->connect_error);
			return false;
		}

		$strsql = "SELECT ";
		$result = $this->mysql->query($strsql);
		if (!$result) 
		{
			printf("Add failed(%s): %s\n",$this->mysql->errno,$this->mysql->error);
			return false;
		}
		return true;
	}
}

/**
* addNewGame 传入类
*/
class GameType
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

	function isLegal()
	{
		return true;
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
	public $propretysvrd;
	public $proxysvrd;
	public $roommngsvrd;
	public $shopsvrd;
	public $statsvrd;
	public $websvrd;
	public $time;
	function __construct($adminsvrd,$dbsvrd,$friendsvrd,$logsvrd,$propretysvrd,$proxysvrd,$roommngsvrd,$shopsvrd,$statsvrd,$websvrd)
	{
		$this->adminsvrd = $adminsvrd;
		$this->dbsvrd = $dbsvrd;
		$this->friendsvrd = $friendsvrd;
		$this->logsvrd = $logsvrd;
		$this->propretysvrd = $propretysvrd;
		$this->proxysvrd = $proxysvrd;
		$this->roommngsvrd = $roommngsvrd;
		$this->shopsvrd = $shopsvrd;
		$this->statsvrd = $statsvrd;
		$this->websvrd = $websvrd;
		date_default_timezone_set('Asia/Shanghai');
		$this->time = date("Y-m-d H:i:s");
	}

	function isLegal()
	{
		return true;
	}
}

/**
* addNewVersion 传入类
*/
class Versions
{
	public $type;
	public $so;
	public $gamesvrd;
	public $client;
	public $commonsvrds_ver;
	public $time;
	public $comment;
	function __construct($type,$so,$gamesvrd,$client,$commonsvrds_ver,$comment)
	{
		$this->type = $type;
		$this->so = $so;
		$this->gamesvrd = $gamesvrd;
		$this->client = $client;
		$this->commonsvrds_ver = $commonsvrds_ver;
		date_default_timezone_set('Asia/Shanghai');
		$this->time = date("Y-m-d H:i:s");
		$this->comment = $comment;
	}

	function isLegal()
	{
		return true;
	}
}

/**
* getCurrentGameInfo 传出类
*/
class CurrentGameInfo
{
	
}
?>