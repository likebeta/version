<?php
require_once(DAO_DIR.'/mysqldao.class.php');
$dao = new MysqlDao();
$page_title = '版本历史';
$versions = $dao->getVersionInfo();

if ($versions === false) {
	$page_title = 'error';
	$error_reason = $dao->getLastError();
}
?>