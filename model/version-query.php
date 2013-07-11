<?php
$versions = false;
if (isset($route_params['params'])) {
	require_once(DAO_DIR.'/mysqldao.class.php');
	$dao = new MysqlDao();
	$versions = $dao->getGameVersionInfoByName($route_params['params'][0]);
	if ($versions === false) {
		define('CALL_ERROR_VIEW', true);
		define('ERROR_TITLE', '数据库错误');
		define('ERROR_REASON', $dao->getLastError());
	}
	$page_title = $route_params['params'][0].'版本历史';
}
else {
	define('CALL_ERROR_VIEW', true);
	define('ERROR_TITLE', '查询错误');
	define('ERROR_REASON', '缺少参数');
}
?>