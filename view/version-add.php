<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<?php 
	require_once(VIEW_DIR.'/header.php');
?>
<title>添加版本</title>
<style type="text/css">
.modal-body label {
	display: inline-block;
}

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
						<th>游戏名称</th>
						<th>client版本</th>
						<th>so版本</th>
						<th>gamesvrd版本</th>
						<th>升级说明</th>
						<th>操作</th>
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
	<div class="row-fluid">
		<div class="span12">
			<table class="table table-bordered table-hover table-striped" id="basesvrds-table">
				<thead>
					<tr>						
						<th>服务器名称</th>
						<th>服务器版本</th>
						<th>操作</th>
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
			<div id="tip"></div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<div class="pull-right"><button class="btn btn-primary" id="submit">提交上线</button></div>
		</div>
	</div>
</div>

<div id="modal-containers">
	<div id="modal-container-games" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>请填写版本信息</h3>
		</div>
		<div class="modal-body">
			<label>选择游戏</label>
			<div class="btn-group">
<?php			
	$str_echo = '<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">'. $gamesinfo[0]->description .'<span class="caret"></span></a>';
	$str_echo .= '<ul class="dropdown-menu">';
	for ($i = 1; $i < count($gamesinfo); $i++) {
		$str_echo .= '<li><a href="#">'.$gamesinfo[$i]->description.'</a></li>';
	}
	$str_echo .= '</ul>';
	echo $str_echo;
?>
			</div>
			<div><input type="checkbox" id="for-client" /><label for="for-client">客户端</label><input type="text" name="client" id="client" /></div>			
			<div><input type="checkbox" id="for-so" /><label for="for-so">游戏逻辑</label><input type="text" name="so" id="so" /></div>
			<div><input type="checkbox" id="for-gamesvrd" /><label for="for-gamesvrd">gamesvrd</label><input type="text" name="gamesvrd" id="gamesvrd" /></div>
			<!-- <div class="textarea well well-small" contenteditable="true"></div> -->
			<div>
				<label>升级说明</label>
				<textarea placeholder="升级说明" id="comment" class="input-block-level"></textarea>
			</div>
			<div style="height:100px"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button> <button class="btn btn-primary" id="save-games">保存设置</button>
		</div>
	</div>

	<div id="modal-container-basesvrds" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>请填写版本信息</h3>
		</div>
		<div class="modal-body">
			<label>选择服务器</label>
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
			<div><label for="for-svrd">服务器版本</label><input type="text" name="svrd" id="svrd" /></div>
			<div style="height:200px"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button> <button class="btn btn-primary" id="save-basesvrds">保存设置</button>
		</div>
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
// var gamesinfo = {
// 	llk: {type:1,name:"llk",description:"连连看"},
// 	ddp: {type:2,name:"ddp",description:"对对碰"},
// 	zc: {type:3,name:"zc",description:"找茬"},
// 	zq: {type:4,name:"zq",description:"桌球"},
// 	hx: {type:5,name:"hx",description:"滑雪"},
// 	wkkp: {type:6,name:"wkkp",description:"悟空快跑"},
// 	ddz: {type:7,name:"ddz",description:"斗地主"},
// 	qsg: {type:8,name:"qsg",description:"切水果"},
// 	ld: {type:9,name:"ld",description:"雷电"},
// 	mj: {type:10,name:"mj",description:"麻将"}
// };

<?php
$str_echo = '';
for ($i = 0; $i < count($gamesinfo); $i++) { 
	$str_echo .= <<<EOF
{$gamesinfo[$i]->name}: {type:{$gamesinfo[$i]->type},name:"{$gamesinfo[$i]->name}",description:"{$gamesinfo[$i]->description}"},
EOF;
}
if (!empty($str_echo)) {
	$str_echo = substr($str_echo, 0, -1);
}
$str_echo = 'var gamesinfo = {'.$str_echo.'};';
echo $str_echo;
?>

<?php
$str_echo = '';
foreach ($current_versions as $current_version) {
	$str_echo .= <<<EOF
{$current_version->gameinfo->name}: {so:"{$current_version->versions->so}",client:"{$current_version->versions->client}",gamesvrd:"{$current_version->versions->gamesvrd}"},
EOF;
}
if (!empty($str_echo)) {
	$str_echo = substr($str_echo, 0, -1);
}
$str_echo = 'var currentGamesVersion = {'.$str_echo.'};';
echo $str_echo;
?>

<?php
$str_echo = '';

if (is_object($current_basesvrds)) {
	foreach ($current_basesvrds as $key => $value) {
	$str_echo .= $key.': "'.$value.'",';
	}
}

if (!empty($str_echo)) {
	$str_echo = substr($str_echo, 0, -1);
}
$str_echo = 'var currentBasesvrds = {'.$str_echo.'};';
echo $str_echo;
?>

var games = new Array();
var basesvrds=new Array();

$(document).ready(function(){
	$("#modal-container-games ul.dropdown-menu").click(function(event){
		if (event.target.nodeName.toLowerCase() == 'a') {
			event.preventDefault();
			var targetText = $(event.target).text();
			$(event.target).text(getSelectedText('#modal-container-games'));
			setSelectedText('#modal-container-games',targetText);
		}
	});

	$('#modal-container-basesvrds ul.dropdown-menu').click(function(event){
		if (event.target.nodeName.toLowerCase() == 'a') {
			event.preventDefault();
			var targetText = $(event.target).text();
			$(event.target).text(getSelectedText('#modal-container-basesvrds'));
			setSelectedText('#modal-container-basesvrds',targetText);
		}
	});

	$('#games-table tbody').click(function(event) {
		if (event.target.nodeName.toLowerCase() == 'a'){
			event.preventDefault();
			var desc = gamesinfo[$(event.target).attr('id')].description;
			$('#modal-container-games ul.dropdown-menu').append('<li><a href="#">' + desc + '</a></li>');
			$(event.target).parent().parent().remove();			
		}
	});

	$('#basesvrds-table tbody').click(function(event) {
		if (event.target.nodeName.toLowerCase() == 'a') {
			event.preventDefault();
			var desc = $(event.target).attr('id');
			$('#modal-container-basesvrds ul.dropdown-menu').append('<li><a href="#">' + desc + '</a></li>');
			$(event.target).parent().parent().remove();	
		}
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

	$('#save-basesvrds').click(function(){
		var text = getSelectedText('#modal-container-basesvrds');
		if (text == '') {
			alert("没有基础服务器可以添加");
			return false;		
		}
		var svrd = $('#svrd').val();
		if (!checkVersion(svrd)) {
			alert("基础服务器版本格式有误");
			return false;
		}
		addSvrdToTable(text,svrd);
		$('#modal-container-basesvrds').modal('hide');
		var first = $('#modal-container-basesvrds ul.dropdown-menu li a:eq(0)');
		var newText = '';
		if (first.size() > 0) {
			newText = first[0].text;
			first.remove();
		}
		setSelectedText('#modal-container-basesvrds',newText);
	});

	$('#submit').click(function(){
		var form = getSubmitJsonData();
		if (form) {
			$.post('./add',form,function(data){
				$('#tip').html(makeTip(data.desc,data.result));
				if (data.result == 'success') {
					$('#games-table tbody tr,#basesvrds-table tbody tr').remove();
					updateData();
				}
				$('#submit')[0].disabled = false;
			},'json');
			$('#submit')[0].disabled = true;
		}

		// var form = document.getElementById("test");
		// form.games.value = JSON.stringify(games);
		// form.basesvrds.value = JSON.stringify(basesvrds);	
		// form.submit();
	});

	$('#modal-container-games').on('show', function() {
		flushModelGames();
	});

	$('#for-client,#for-so,#for-gamesvrd').click(function(){
		var checked = $(this)[0].checked;
		var id = $(this).attr('id').replace('for-','');
		$('#' + id)[0].disabled = !checked;
	});

	$('#modal-container-basesvrds').on('show', function() {
		flushModelBasesvrd();
	});

});

function getSelectedText(id) {
	return $(id + ' .dropdown-toggle')[0].firstChild.nodeValue;
}

function setSelectedText(id,value) {
	$(id + ' .dropdown-toggle')[0].firstChild.nodeValue = value;
	if (id == '#modal-container-games') {
		flushModelGames();
	}
	else if (id == '#modal-container-basesvrds') {
		flushModelBasesvrd();
	}
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

function getCurrentVersionInfoByGamename(name) {
	if (typeof(currentGamesVersion[name]) != 'function' && currentGamesVersion[name] != undefined) {
		return currentGamesVersion[name];
	}
	return false;
}

function getBasesvrdVersion(name) {
	if (typeof(currentBasesvrds[name]) != 'function' && currentBasesvrds[name] != undefined) {
		return currentBasesvrds[name];
	}
	return false;
}

function addGameToTable(game,client,so,gamesvrd,comment) {
	var id = getGameinfoByGamedesc(game).name;
	var newRow = '<tr>';
	newRow += '<td>' + game + '</td>';
	newRow += '<td>' + client + '</td>';
	newRow += '<td>' + so + '</td>';
	newRow += '<td>' + gamesvrd + '</td>';
	newRow += '<td>' + comment + '</td>';
	newRow += '<td><a href="#" id="' + id + '">删除</a></td>';
	newRow += '</tr>';
	$('#games-table tbody').append(newRow);
}

function addSvrdToTable(text,svrd) {
	var newRow = '<tr>';
	newRow += '<td>' + text + '</td>';
	newRow += '<td>' + svrd + '</td>';
	newRow += '<td><a href="#" id="' + text+ '">删除</a></td>';
	newRow += '</tr>';
	$('#basesvrds-table tbody').append(newRow);
}

function getSubmitJsonData(){
	games = new Array();
	basesvrds = new Array();
	$('#games-table tbody tr').each(function(){
 		var desc = $(this).find('td:nth-child(1)').text();
 		var client = $(this).find('td:nth-child(2)').text();
 		var so = $(this).find('td:nth-child(3)').text();
 		var gamesvrd = $(this).find('td:nth-child(4)').text();
 		var comment = $(this).find('td:nth-child(5)').text();
 		var name = getGameinfoByGamedesc(desc).name;
 		games.push({name: name, so: so, client: client, gamesvrd: gamesvrd, comment: comment});
	});

	$('#basesvrds-table tbody tr').each(function(){
 		var name = $(this).find('td:nth-child(1)').text();
 		var version = $(this).find('td:nth-child(2)').text();
 		basesvrds.push({name: name, version: version});
	});

	if (games.length == 0 && basesvrds.length == 0){
		return false;
	}

	return {games: JSON.stringify(games), basesvrds: JSON.stringify(basesvrds)};
}

function updateData() {
	for (var i = games.length - 1; i >= 0; i--) {
		currentGamesVersion[games[i].name] = {so:games[i].so,client:games[i].client,gamesvrd:games[i].gamesvrd};
		$('#modal-container-games ul.dropdown-menu').append('<li><a href="#">' + gamesinfo[games[i].name].description + '</a></li>');
	}

	for (var i = basesvrds.length - 1; i >= 0; i--) {
		currentBasesvrds[basesvrds[i].name] = basesvrds[i].version;
		$('#modal-container-basesvrds ul.dropdown-menu').append('<li><a href="#">' + basesvrds[i].name + '</a></li>');		
	}
}

function flushModelGames(){
	$('#for-client,#for-so,#for-gamesvrd').each(function(){
			$(this)[0].checked = false;
		});
	$('#client,#so,#gamesvrd').each(function(){
		var text = getSelectedText('#modal-container-games');
		var name = getGameinfoByGamedesc(text).name;
		var current_version = getCurrentVersionInfoByGamename(name);
		if (current_version != false) {
			var id = $(this).attr('id');
			$(this).val(current_version[id]);
		}
		else {
			$(this).val('');
		}
		$(this)[0].disabled = true;
	});
}

function flushModelBasesvrd(){
	var svrd = $('#svrd');
	var text = getSelectedText('#modal-container-basesvrds');
	var basesvrdVersion = getBasesvrdVersion(text);
	if (basesvrdVersion != false) {
		svrd.val(basesvrdVersion);		
	}
	else {
		svrd.val('');
	}
}
</script>
</body>
</html>