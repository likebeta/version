<?php
require_once(DAO_DIR.'/mysqldao.class.php');
$dao = new MysqlDao();

if (!isset($route_params['params'])) {	// 查全部记录
	$versions = $dao->getVersionInfo();
}
elseif (count($route_params['params']) > 1) {
	$versions = false;
	if ($route_params['params'][0] === 'version') {
		$versions = $dao->getGameVersionInfoByVersion($route_params['params'][1]);
	}
}
else {
	$versions = $dao->getGameVersionInfoByName($route_params['params'][0]);
}

if ($versions === false) {
	$error_reason = $dao->getLastError();
}
?>