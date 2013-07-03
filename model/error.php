<?php
if (!defined('VIEW_DIR')) {
	$error_reason = 'illegal request';
}
else {
	$params_count = count($route_params);
	if ($params_count === 0) {
		$error_reason = 'miss param';
	}
	else {
		$error_reason = 'error param';
	}	
}
?>