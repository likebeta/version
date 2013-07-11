<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<?php 
	require_once(VIEW_DIR.'/header.php');
?>
<title>游戏信息</title>
</head>
<body>
<?php
	require_once(VIEW_DIR.'/nav.php');
?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>type</th>
						<th>name</th>
						<th>description</th>
					</tr>
				</thead>
				<tbody>
<?php
				$str_echo = '';
				foreach ($gameinfos as $gameinfo) {
					$str_echo .= "<tr>";
					$str_echo .= "<td>{$gameinfo->type}</td>";
					$str_echo .= "<td>{$gameinfo->name}</td>";
					$str_echo .= "<td>{$gameinfo->description}</td>";
					$str_echo .= "</tr>";
				}
				echo $str_echo;
?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</body>
</html>