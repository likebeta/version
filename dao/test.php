<!doctype html>
<html>
<head>
<!--<meta charset="utf8" />-->
</head>
<body>
<?php
require('mysqldao.class.php');
$gameinfo = new GameInfo(1,'ddz','斗地主');
$test = new MysqlDao();
//$gametype->addNewGame($gameinfo);

$svrds = new CommonSvrds('adminsvrd1.0','dbsvrd1.0','friendsvrd1.0','logsvrd1.0','propretysvrd1.0','proxysvrd1.0','roommngsvrd1.0','shopsvrd1.0','statsvrd1.0','websvrd1.0');
//$test->addNewCommonSvrds($svrds);

$versions = new Versions(2,'release1.0_9527','release1.0_9666','release1.0_1022',1,'斗地主升级，添加moeny限制');
//$test->addNewVersions($versions);

//var_dump($test->getGameInfo());
//var_dump($test->getGameCurrentVersionInfo(1));
//var_dump($test->getGameThisVersionInfo(1,1));
var_dump($test->getCurrentVersionInfo());

?>
</body>
</html>