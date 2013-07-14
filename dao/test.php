<!doctype html>
<html>
<head>
<meta charset="utf-8" />
</head>
<body>
<?php
require('../config.inc.php');
require('mysqldao.class.php');
$test = new MysqlDao();

$gameinfo = new GameInfo(1,"llk","连连看");
$test->addNewGame($gameinfo);
$gameinfo = new GameInfo(2,"ddp","对对碰");
$test->addNewGame($gameinfo);
$gameinfo = new GameInfo(3,"zc","找茬");
$test->addNewGame($gameinfo);
$gameinfo = new GameInfo(4,"zq","桌球");
$test->addNewGame($gameinfo);
$gameinfo = new GameInfo(5,"hx","滑雪");
$test->addNewGame($gameinfo);
$gameinfo = new GameInfo(6,"wkkp","悟空快跑");
$test->addNewGame($gameinfo);
$gameinfo = new GameInfo(7,"ddz","斗地主");
$test->addNewGame($gameinfo);
$gameinfo = new GameInfo(8,"qsg","切水果");
$test->addNewGame($gameinfo);
$gameinfo = new GameInfo(9,"ld","雷电");
$test->addNewGame($gameinfo);
$gameinfo = new GameInfo(10,"mj","麻将");
$test->addNewGame($gameinfo);

// $svrds = new Basesvrds('1.0.0.r1','1.0.0.r1','1.0.0.r1','1.0.0.r1','1.0.0.r1','1.0.0.r1','1.0.0.r1','1.0.0.r1','1.0.0.r1','1.0.0.r1');
// $test->addNewBasesvrds($svrds);
// $svrds = new Basesvrds('1.0.1.r2','1.0.1.r2','1.0.1.r2','1.0.1.r2','1.0.1.r2','1.0.1.r2','1.0.1.r2','1.0.1.r2','1.0.1.r2','1.0.1.r2');
// $test->addNewBasesvrds($svrds);

// $versions = new Versions(1,'1.1','1.1','1.1',1,'斗地主升级，添加moeny限制');
// $test->addNewVersions($versions);
// $versions = new Versions(9,'1.1','1.1','1.1',1,'雷电升级，添加moeny限制');
// $test->addNewVersions($versions);
// $versions = new Versions(1,'1.2','1.2','1.2',2,'斗地主升级，添加moeny限制');
// $test->addNewVersions($versions);
// $versions = new Versions(9,'1.2','1.2','1.2',2,'雷电升级，添加moeny限制');
// $test->addNewVersions($versions);

var_dump($test->getGameInfo());
var_dump($test->getCurrentVersionsInfo());
?>
</body>
</html>