<?php
require_once(DAO_DIR.'/mysqldao.class.php');
$dao = new MysqlDao();
$current_versions = $dao->getCurrentVersionInfo();
if ($current_versions === false) {
	$error_reason = $dao->getLastError();
}
?>