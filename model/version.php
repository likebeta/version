<?php
require_once(DAO_DIR.'/mysqldao.class.php');
$dao = new MysqlDao();
$versions = $dao->getVersionInfo();
if ($versions === false) {
	define('CALL_ERROR_VIEW', true);
	define('ERROR_TITLE', '数据库错误');
	define('ERROR_REASON', $dao->getLastError());
}
?>