<?php
require_once(DAO_DIR.'/mysqldao.class.php');
$dao = new MysqlDao();
$page_title = '版本管理平台';
$current_versions = $dao->getCurrentVersionInfo();
if ($current_versions === false) {
	$page_title = 'error';
	$error_reason = $dao->getLastError();
}
?>