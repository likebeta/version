<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<?php 
	require_once(VIEW_DIR.'/header.php');
?>
<title><?php echo $page_title;?></title>
<style type="text/css">
/*label {
	display: inline-block;
}*/
#gamesinfo,#svrdsinfo {
	display: none;
}
fieldset {
	margin: 10px 0;
}
.row fieldset input {
	display: inline-block;
	margin-right: 10px;
}
#game-update .dropdown-toggle,#commonsvrd-update .dropdown-toggle {
	width: 90px;
}
</style>
</head>
<body>
<?php
	require_once(VIEW_DIR.'/nav.php');
?>
<div class="container-fluid">
	<div class="row-fluid" id="game-update">
		<div class="span12">
			<div class="page-header">
				<h3>游戏升级</h3>
			</div>
			<div class="well well-small">
				<span>选择：</span>
				<div class="btn-group">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">连连看<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">对对碰</a></li>
						<li><a href="#">美女找茬</a></li>
						<li><a href="#">桌球</a></li>
						<li><a href="#">滑雪</a></li>
						<li><a href="#">悟空快跑</a></li>
						<li><a href="#">斗地主</a></li>
						<li><a href="#">切水果</a></li>
						<li><a href="#">雷电</a></li>
						<li><a href="#">麻将</a></li>
					</ul>
				</div>
				<a id="modal-games" href="#modal-container-games" role="button" class="btn btn-primary" data-toggle="modal">添加</a>
				<div id="modal-container-games" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3>请填写版本信息</h3>
					</div>
					<div class="modal-body">
						<label for="client">客户端：</label><input type="text" name="client" id="client" />
						<label for="so">游戏逻辑：</label><input type="text" name="so" id="so" />
						<label for="gamesvrd">gamesvrd：</label><input type="text" name="gamesvrd" id="gamesvrd" />
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button> <button class="btn btn-primary" id="save-games">保存设置</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid" id="commonsvrd-update">
		<div class="span12">
			<div class="page-header">
				<h3>共用服务器升级</h3>
			</div>
			<div class="well well-small">
				<span>选择：</span>
				<div class="btn-group">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">adminsvrd<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">dbsvrd</a></li>
						<li><a href="#">friendsvrd</a></li>
						<li><a href="#">logsvrd</a></li>
						<li><a href="#">propertysvrd</a></li>
						<li><a href="#">proxysvrd</a></li>
						<li><a href="#">roommngsvrd</a></li>
						<li><a href="#">shopsvrd</a></li>
						<li><a href="#">statsvrd</a></li>
						<li><a href="#">websvrd</a></li>
					</ul>
				</div>
				<a id="modal-svrds" href="#modal-container-svrds" role="button" class="btn btn-primary" data-toggle="modal">添加</a>
				<div id="modal-container-svrds" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3>标题栏</h3>
					</div>
					<div class="modal-body">
						<p>显示信息</p>
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button> <button class="btn btn-primary" id="save-svrds">保存设置</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="well well-small">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<span>斗地主</span>
	</div>
	<div id="tip"></div>
</div>
<?php
// if (isset($_POST['games']) && isset($_POST['svrds'])) {
// 	$games = json_decode($_POST['games']);
// 	$svrds = json_decode($_POST['svrds']);
// 	var_dump($_POST);
// 	var_dump($games);
// 	var_dump($svrds);
// 	exit();
// }
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#game-update ul.dropdown-menu li a').click(function(){
		var thisText = $(this).text();
		$(this).text(getSelectedText('#game-update'));
		setSelectedText('#game-update',thisText);
		showItem.nodeValue = thisText;
	});

	$('#commonsvrd-update ul.dropdown-menu li a').click(function(){
		var thisText = $(this).text();
		$(this).text(getSelectedText('#commonsvrd-update'));
		setSelectedText('#commonsvrd-update',thisText);
		showItem.nodeValue = thisText;
	});

	$('#save-games').click(function(){
		var text = getSelectedText('#game-update');
		var client = $('#client').val();
		var so = $('#so').val();
		var gamesvrd = $('#gamesvrd').val();
		$('#modal-container-games').modal('hide');
	});


	var games=[];
	var commonsvrds=[];
	games.push({"name": "ddz","so": "1.5","client": "1.3","gamesvrd": "1.6","comment": "fuck you"});
	games.push({"name": "llk","so": "1.2","client": "1.6","gamesvrd": "1.7","comment": "fuck you"});
	commonsvrds.push({"name": "dbsvrd","version": "2.3"});
	commonsvrds.push({"name": "proxysvrd","version": "3.3"});

	var form = new Object();
	form.games = JSON.stringify(games);
	form.svrds = JSON.stringify(commonsvrds);
	$.post('./add',form,function(data){
		$('#tip').html(makeTip(data.desc,data.result));
	},'json');
});

function getSelectedText(id){
	return $(id + ' .dropdown-toggle')[0].firstChild.nodeValue;
}

function setSelectedText(id,value){
	return $(id + ' .dropdown-toggle')[0].firstChild.nodeValue = value;
}

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