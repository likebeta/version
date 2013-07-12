<?php
$SITE_URL = SITE_URL;
$nav_str = <<<EOF
<div class="container-fluid" id="navbar">
	<div class="row-fluid">
		<div class="span12">
			<div class="navbar navbar-inverse">
				<div class="navbar-inner">
					<div class="container-fluid">
						<a data-target=".navbar-responsive-collapse" data-toggle="collapse" class="btn btn-navbar"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a>
						<div class="nav-collapse collapse navbar-responsive-collapse">
							<ul class="nav">
								<li><a href="{$SITE_URL}">主页</a></li>
								<li><a href="{$SITE_URL}/version/current">线上版本</a></li>
								<li><a href="{$SITE_URL}/game">游戏信息</a></li>
								<li><a href="{$SITE_URL}/version">版本历史</a></li>
								<li><a href="{$SITE_URL}/version/query/ddz">斗地主版本历史</a></li>
								<li><a href="{$SITE_URL}/game/add">添加游戏</a></li>
								<li><a href="{$SITE_URL}/version/add">添加版本</a></li>
							</ul>
						</div>						
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>
EOF;
echo $nav_str;
?>