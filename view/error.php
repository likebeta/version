<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<?php 
	require_once(VIEW_DIR.'/header.php');
?>
<title><?php echo defined('ERROR_TITLE') ? ERROR_TITLE:'未知错误';?></title>
</head>
<body>
<?php
	require_once(VIEW_DIR.'/nav.php');
?>
<?php
	echo defined('ERROR_REASON') ? ERROR_REASON:'未知错误';
?>
</body>
</html>