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
<title><?php echo $page_title;?></title>
</head>
<body>
<?php
	if (isset($error_reason)) {
		echo $error_reason;
	}
	else {
		$str_echo = <<<EOF
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
EOF;
		foreach ($gameinfos as $gameinfo) {
			$str_echo .= "<tr>";
			$str_echo .= "<td>{$gameinfo->type}</td>";
			$str_echo .= "<td>{$gameinfo->name}</td>";
			$str_echo .= "<td>{$gameinfo->description}</td>";
			$str_echo .= "</tr>";
		}
		$str_echo .= <<<EOF
				</tbody>
			</table>
		</div>
	</div>
</div>
EOF;
		echo $str_echo;
	}
?>
<?php
	require_once('nav.php');
?>
</body>
</html>