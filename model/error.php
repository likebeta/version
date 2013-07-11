<?php
if (!defined('VIEW_DIR')) {
	define('ERROR_REASON', '非法请求');
}
else {
	$params_count = count($route_params);
	if ($params_count === 0) {
		define('ERROR_REASON', '缺少参数');
	}
	else {
		define('ERROR_REASON', '参数错误');
	}
}
?>