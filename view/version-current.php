<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<?php 
	require_once(VIEW_DIR.'/header.php');
?>
<title>线上版本</title>
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
						<th>name</th>
						<th>time</th>
						<th>so</th>
						<th>client</th>
						<th>gamesvrd</th>
						<th>adminsvrd</th>
						<th>dbsvrd</th>
						<th>friendsvrd</th>
						<th>logsvrd</th>
						<th>propertysvrd</th>
						<th>proxysvrd</th>
						<th>roommngsvrd</th>
						<th>shopsvrd</th>
						<th>statsvrd</th>
						<th>websvrd</th>
					</tr>
				</thead>
				<tbody>
<?php
				$str_echo = '';
				foreach ($current_versions as $version) {
					$str_echo .= "<tr>";
					$str_echo .= "<td>{$version->gameinfo->description}</td>";
					$str_echo .= "<td>{$version->versions->time}</td>";
					$str_echo .= "<td>{$version->versions->client}</td>";
					$str_echo .= "<td>{$version->versions->so}</td>";
					$str_echo .= "<td>{$version->versions->gamesvrd}</td>";
					$str_echo .= "<td>{$version->basesvrds->adminsvrd}</td>";
					$str_echo .= "<td>{$version->basesvrds->dbsvrd}</td>";
					$str_echo .= "<td>{$version->basesvrds->friendsvrd}</td>";
					$str_echo .= "<td>{$version->basesvrds->logsvrd}</td>";
					$str_echo .= "<td>{$version->basesvrds->propertysvrd}</td>";
					$str_echo .= "<td>{$version->basesvrds->proxysvrd}</td>";
					$str_echo .= "<td>{$version->basesvrds->roommngsvrd}</td>";
					$str_echo .= "<td>{$version->basesvrds->shopsvrd}</td>";
					$str_echo .= "<td>{$version->basesvrds->statsvrd}</td>";
					$str_echo .= "<td>{$version->basesvrds->websvrd}</td>";
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