<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<?php 
	require_once(VIEW_DIR.'/header.php');
?>
<title>添加游戏</title>
</head>
<body>
<?php
	require_once(VIEW_DIR.'/nav.php');
?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span4"></div>
		<div class="span4">
			<div id="ajaxfrom">
				<label for="gametype">游戏类型</label>
				<input type="text" name="gametype" placeholder="7" id="gametype" />
				<label for="gamename">游戏缩写</label>
				<input type="text" name="gamename" placeholder="ddz" id="gamename" />
				<label for="gamedesc">游戏名称</label>
				<input type="text" name="gamedesc" placeholder="斗地主" id="gamedesc" />
				<br />
				<button id="addgame" class="btn btn-primary">添加</button>
				<div id="tip"></div>
			</div>
		</div>
		<div class="span4"></div>
	</div>
</div>
<script type="text/javascript">
function checkData(form){
	if (!/^[1-9][0-9]*$/.test(form.gametype)) {
		alert("游戏类型必须为自然数");
		return false;
	}
	if (!/^[0-9a-zA-Z]+$/.test(form.gamename)) {
		alert("游戏缩写只能由数字,字母组成");
		return false;
	}
	if (!/^\S+$/.test(form.gamedesc)){
		alert("游戏名称必须为空字符组成");
		return false;
	}
	return true;
}
$(document).ready(function(){
	$('#addgame').click(function(){
		var form = new Object();
		$('#gametype,#gamename,#gamedesc').each(function(){
			var key = $(this).attr('id');
			var value = $(this).val();
			form[key] = value;
		});
		if (checkData(form)){
			$.post('./add',form,function(data){
				$('#tip').html(makeTip(data.desc,data.result));
				if (data.result == 'success') {
					$('#gametype,#gamename,#gamedesc').each(function(){
						$(this).val('');
					});
				}
			},'json');
		}
	});
});

function makeTip(text,classname){
	var html = '<div class="alert alert-' + classname + '">';
	html += '<button type="button" class="close" data-dismiss="alert">×</button>';
	html += '' + text + '';
	html += '</div>';
	return html;
}
</script>
</body>
</html>