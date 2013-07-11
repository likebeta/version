<?php
require_once(DAO_DIR.'/mysqldao.class.php');
$dao = new MysqlDao();
$gameinfos = $dao->getGameInfo();
if ($gameinfos === false) {
	define('CALL_ERROR_VIEW', true);
	define('ERROR_TITLE', '数据库错误');
	define('ERROR_REASON', $dao->getLastError());
}
?>