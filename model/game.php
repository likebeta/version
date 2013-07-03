<?php
require_once(DAO_DIR.'/mysqldao.class.php');
$dao = new MysqlDao();
$gameinfos = $dao->getGameInfo();
if ($gameinfos === false) {
	$error_reason = $dao->getLastError();
}
?>