<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--[if lt IE 9]>
<script src="http://localhost/lib/html5/html5shiv.js"></script>
<![endif]-->
<script src="http://localhost/lib/jquery/1.9.1/jquery.min.js"></script>
<script src="http://localhost/lib/bootstrap/2.3.1/js/bootstrap.min.js"></script>
<link href="http://localhost/lib/bootstrap/2.3.1/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<link href="http://localhost/lib/bootstrap/2.3.1/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen" />
<title>添加游戏</title>
</head>
<body>
<?php
	if (isset($error_reason)) {
		echo $error_reason;
	}
	else {
		$gametype_value = isset($_POST['gametype']) ? $_POST['gametype']:'';
		$gamename_value = isset($_POST['gamename']) ? $_POST['gamename']:'';
		$gamedesc_value = isset($_POST['gamedesc']) ? $_POST['gamedesc']:'';
		$str = <<<EOF
		<form method="post" action="./add" onsubmit="addGame(this.form);return false">
			<label for="gametype">游戏类型</label>
			<input type="text" name="gametype" placeholder="7" id="gametype" value="{$gametype_value}" />
			<label for="gamename">游戏缩写</label>
			<input type="text" name="gamename" placeholder="ddz" id="gamename" value="{$gamename_value}" />
			<label for="gamedesc">游戏名称</label>
			<input type="text" name="gamedesc" placeholder="斗地主" id="gamedesc" value="{$gamedesc_value}" />
			<br />
			<input type="submit" class="btn btn-primary" onclick="addGame(this.form);return false" />
		</form>
EOF;
		echo $str;
		if (isset($add_result)) {
			echo '<div>'.$add_result.'</div>';
		}
	}
?>
<?php
	require_once('nav.php');
?>
<script type="text/javascript">
function addGame(form){
	if (!/^[1-9][0-9]*$/.test(form.gametype.value)) {
		alert("游戏类型必须为数字");
		return false;
	}
	if (!/^[1-9a-zA-Z]+$/.test(form.gamename.value)) {
		alert("游戏缩写只能由数字,字母组成");
		return false;
	}
	if (!/^.+$/.test(form.gamedesc.value)){
		alert("游戏名称不能为空");
		return false;
	}
	form.submit();
}
</script>
</body>
</html>