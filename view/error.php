<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title><?php echo defined('ERROR_TITLE') ? ERROR_TITLE:'未知错误';?></title>
</head>
<body>
<?php
	echo defined('ERROR_REASON') ? ERROR_REASON:'未知错误';
?>
<?php
	require_once('nav.php');
?>
</body>
</html>