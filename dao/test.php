<!doctype html>
<html>
<head>
<meta charset="utf-8" />
</head>
<body>
<?php
require('mysqldao.class.php');
$test = new MysqlDao();

// $gameinfo = new GameInfo(1,'ddz','斗地主');
// $test->addNewGame($gameinfo);
// $gameinfo = new GameInfo(9,'ld','雷电');
// $test->addNewGame($gameinfo);

// $svrds = new CommonSvrds('adminsvrd1.0','dbsvrd1.0','friendsvrd1.0','logsvrd1.0','propretysvrd1.0','proxysvrd1.0','roommngsvrd1.0','shopsvrd1.0','statsvrd1.0','websvrd1.0');
// $test->addNewCommonSvrds($svrds);
// $svrds = new CommonSvrds('adminsvrd2.0','dbsvrd2.0','friendsvrd2.0','logsvrd2.0','propretysvrd2.0','proxysvrd2.0','roommngsvrd2.0','shopsvrd2.0','statsvrd2.0','websvrd2.0');
// $test->addNewCommonSvrds($svrds);

// $versions = new Versions(1,'1.1','1.1','1.1',1,'斗地主升级，添加moeny限制');
// $test->addNewVersions($versions);
// $versions = new Versions(9,'1.1','1.1','1.1',1,'雷电升级，添加moeny限制');
// $test->addNewVersions($versions);
// $versions = new Versions(1,'1.2','1.2','1.2',2,'斗地主升级，添加moeny限制');
// $test->addNewVersions($versions);
// $versions = new Versions(9,'1.2','1.2','1.2',2,'雷电升级，添加moeny限制');

//var_dump($test->getGameInfo());
//var_dump($test->getGameCurrentVersionInfo(1));
//var_dump($test->getGameThisVersionInfo(1,1));
var_dump($test->getCurrentVersionInfo());
?>
</body>
</html>