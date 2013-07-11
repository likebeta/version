<?php
require_once(DAO_DIR.'/mysqldao.class.php');
$dao = new MysqlDao();
$current_versions = $dao->getCurrentVersionInfo();
if ($current_versions === false) {
	define('CALL_ERROR_VIEW', true);
	define('ERROR_TITLE', '数据库错误');
	define('ERROR_REASON', $dao->getLastError());
}
?>