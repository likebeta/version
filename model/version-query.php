<?php
$versions = false;
if (isset($route_params['params'])) {
	require_once(DAO_DIR.'/mysqldao.class.php');
	$dao = new MysqlDao();
	$page_title = '版本信息';
	$query_version = ((string)(int)($route_params['params'][0]) === $route_params['params'][0]) ? true:false;
	if ($query_version) {
		$versions = $dao->getGameVersionInfoByVersion($route_params['params'][0]);
	}
	else {
		$versions = $dao->getGameVersionInfoByName($route_params['params'][0]);
	}

	if ($versions === false) {
		$page_title = 'error';
		$error_reason = $dao->getLastError();
	}
}
else {
	$page_title = 'error';
	$error_reason = 'miss param';
}
?>