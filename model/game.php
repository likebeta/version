<?php
require_once(DAO_DIR.'/mysqldao.class.php');
$dao = new MysqlDao();
$page_title = '游戏信息';
$gameinfos = $dao->getGameInfo();
if ($gameinfos === false) {
	$page_title = 'error';
	$error_reason = $dao->getLastError();
}
?>