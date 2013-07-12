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
.textarea{
	min-height: 30px;
	background-color: #FFF;
	word-wrap: break-word;
    overflow-x: hidden;
    overflow-y: auto;
}

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
#game-update .dropdown-toggle,#basesvrds-update .dropdown-toggle {
	width: 90px;
}

.navbar .nav>li>a {
	outline: none;
}

</style>
</head>
<body>
<?php
	require_once(VIEW_DIR.'/nav.php');
?>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container-fluid">
						<a data-target=".navbar-responsive-collapse" data-toggle="collapse" class="btn btn-navbar"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a> 
						<span class="brand">游戏升级</span>
						<div class="nav-collapse collapse navbar-responsive-collapse">
							<ul class="nav pull-right">
								<li><a id="game-del"  href="#">删除</a></li>
								<li><a href="#modal-container-games" data-toggle="modal">添加</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<table class="table table-bordered table-hover table-striped" id="games-table">
				<thead>
					<tr>
						<th><input type="checkbox" id="checkbox-all-games" /></th>
						<th>游戏名称</th>
						<th>client版本</th>
						<th>so版本</th>
						<th>gamesvrd版本</th>
						<th>升级说明</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container-fluid">
						<a data-target=".navbar-responsive-collapse" data-toggle="collapse" class="btn btn-navbar"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a> 
						<span class="brand">基础服务器升级</span>
						<div class="nav-collapse collapse navbar-responsive-collapse">
							<ul class="nav pull-right">
								<li><a id="modal-basesvrds" href="#modal-container-basesvrds" role="button" data-toggle="modal">添加</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div id="tip"></div>
		</div>
	</div>
</div>

<div id="modal-container-games" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3>请填写版本信息</h3>
	</div>
	<div class="modal-body">
		<label>选择游戏</label>
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
		<label for="client">客户端</label><input type="text" name="client" id="client" value="1.1.1.r1" />
		<label for="so">游戏逻辑</label><input type="text" name="so" id="so" value="1.1.1.r1" />
		<label for="gamesvrd">gamesvrd</label><input type="text" name="gamesvrd" id="gamesvrd" value="1.1.1.r1" />
		<!-- <div class="textarea well well-small" contenteditable="true"></div> -->
		<label>升级说明</label>
		<textarea placeholder="升级说明" id="comment">1.1.1.r1</textarea>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button> <button class="btn btn-primary" id="save-games">保存设置</button>
	</div>
</div>

<div id="modal-container-basesvrds" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3>标题栏</h3>
	</div>
	<div class="modal-body">
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
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button> <button class="btn btn-primary" id="save-basesvrds">保存设置</button>
	</div>
</div>

<?php
// if (isset($_POST['games']) && isset($_POST['basesvrds'])) {
// 	$games = json_decode($_POST['games']);
// 	$basesvrds = json_decode($_POST['basesvrds']);
// 	var_dump($_POST);
// 	var_dump($games);
// 	var_dump($basesvrds);
// 	exit();
// }
?>

<!-- <form id="test" method="post" action="./add"> 
	<input type="hidden" name="games" /> 
	<input type="hidden" name="basesvrds" /> 
</form> -->

<script type="text/javascript">
$(document).ready(function(){
	$('#modal-container-games ul.dropdown-menu li a').click(function(event){
		event.preventDefault();
		var thisText = $(this).text();
		$(this).text(getSelectedText('#modal-container-games'));
		setSelectedText('#modal-container-games',thisText);
		showItem.nodeValue = thisText;
		
	});

	$('#modal-container-basesvrds ul.dropdown-menu li a').click(function(event){
		event.preventDefault();
		var thisText = $(this).text();
		$(this).text(getSelectedText('#modal-container-basesvrds'));
		setSelectedText('#modal-container-basesvrds',thisText);
		showItem.nodeValue = thisText;		
	});

	$('#save-games').click(function(){
		var text = getSelectedText('#modal-container-games');
		if (text == '') {
			alert("没有游戏可以添加");
			return false;			
		}
		var client = $('#client').val();
		if (!checkVersion(client)) {
			alert("客户端版本格式有误");
			return false;
		}
		var so = $('#so').val();
		if (!checkVersion(so)) {
			alert("游戏逻辑版本格式有误");
			return false;
		}
		var gamesvrd = $('#gamesvrd').val();
		if (!checkVersion(gamesvrd)) {
			alert("gamesvrd版本格式有误");
			return false;
		}
		var comment = $('#comment').val();
		if (!/^\S+$/.test(comment)) {
			alert("升级说明不能为空");
			return false;
		}
		addGameToTable(text,client,so,gamesvrd,comment);
		$('#modal-container-games').modal('hide');
		var first = $('#modal-container-games ul.dropdown-menu li a:eq(0)');
		var newText = '';
		if (first.size() > 0) {
			newText = first[0].text;
			first.remove();
		}
		setSelectedText('#modal-container-games',newText);
	});

	$('#checkbox-all-games,#checkbox-all-basesvrds').click(function() {
		var checked = $(this)[0].checked;
		console.debug(checked);
		if ($(this).attr('id') == 'checkbox-all-games'){
			var tableId = 'games-table';
		}
		else {
			var tableId = 'basesvrds-table';
		}

		
		if (!checked) {
			$('#' + tableId + ' input[type="checkbox"]').each(function(){
				$(this)[0].checked = false;
			});			
		}
		else {
			$('#' + tableId + ' input[type="checkbox"]').each(function(){
				$(this)[0].checked = true;
			});				
		}
	});
});

	var gamesinfo = {
		llk: {type:1,name:"llk",description:"连连看"},
		ddp: {type:2,name:"ddp",description:"对对碰"},
		zc: {type:3,name:"zc",description:"找茬"},
		zq: {type:4,name:"zq",description:"桌球"},
		hx: {type:5,name:"hx",description:"滑雪"},
		wkkp: {type:6,name:"wkkp",description:"悟空快跑"},
		ddz: {type:7,name:"ddz",description:"斗地主"},
		qsg: {type:8,name:"qsg",description:"切水果"},
		ld: {type:9,name:"ld",description:"雷电"},
		mj: {type:10,name:"mj",description:"麻将"}
	};

	var games = new Array();
	var basesvrds=new Array();
	// games.push({"name": "ddz","so": "1.5","client": "1.3","gamesvrd": "1.6","comment": "fuck you"});
	// games.push({"name": "llk","so": "1.2","client": "1.6","gamesvrd": "1.7","comment": "fuck you"});
	// basesvrds.push({"name": "dbsvrd","version": "2.3"});
	// basesvrds.push({"name": "proxysvrd","version": "3.3"});

	// var form = new Object();
	// form.games = JSON.stringify(games);
	// form.basesvrds = JSON.stringify(basesvrds);
	// $.post('./add',form,function(data){
	// 	$('#tip').html(makeTip(data.desc,data.result));
	// },'json');

// var games=[];
// var basesvrds=[];
// games.push({"name": "ddz","so": "1.5","client": "1.3","gamesvrd": "1.6","comment": "fuck you"});
// games.push({"name": "llk","so": "1.2","client": "1.6","gamesvrd": "1.7","comment": "fuck you"});
// basesvrds.push({"name": "dbsvrd","version": "2.3"});
// basesvrds.push({"name": "proxysvrd","version": "3.3"});
// var form = document.getElementById("test");
// form.games.value = JSON.stringify(games);
// form.basesvrds.value = JSON.stringify(basesvrds);	
// form.submit();

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

function checkVersion(ver) {
	// 3.1.56.r13124
	if (!/^([1-9][0-9]*)\.(0|([1-9][0-9]*))\.(0|([1-9][0-9]*))\.r[1-9][0-9]*$/.test(ver)){
		return false;
	}
	return true;
}

function getGameinfoByGamedesc(description) {
	for (var i in gamesinfo){
		if (typeof(gamesinfo[i]) != 'function' && gamesinfo[i].description == description) {
			return gamesinfo[i];
		}
	}
	return false;
}

function addGameToTable(game,client,so,gamesvrd,comment) {
	var id = getGameinfoByGamedesc(game).name;
	var newRow = '<tr>';
	newRow += '<td><input type="checkbox" id="' + id + '" /></td>';
	newRow += '<td>' + game + '</td>';
	newRow += '<td>' + client + '</td>';
	newRow += '<td>' + so + '</td>';
	newRow += '<td>' + gamesvrd + '</td>';
	newRow += '<td>' + comment + '</td>';
	newRow += '</tr>';
	$('#games-table tr:last').after(newRow);
}
</script>
</body>
</html>