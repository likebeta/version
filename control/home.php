<?php
require_once(MODEL_DIR.'/home.php');
if (defined('CALL_ERROR_VIEW')) {
	require_once(VIEW_DIR.'/error.php');	
}
else{
	require_once(VIEW_DIR.'/home.php');
}
?>