<?php
$SITE_URL = SITE_URL;
$header_str = <<<EOF
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--[if lt IE 9]>
<script src="{$SITE_URL}/lib/html5/html5shiv.js"></script>
<![endif]-->
<script src="{$SITE_URL}/lib/jquery/1.9.1/jquery.min.js"></script>
<script src="{$SITE_URL}/lib/bootstrap/2.3.1/js/bootstrap.min.js"></script>
<script src="{$SITE_URL}/lib/dump/1.1/jquery.dump.js"></script>
<script src="{$SITE_URL}/lib/dump/1.1/dump.js"></script>
<link href="{$SITE_URL}/lib/bootstrap/2.3.1/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<link href="{$SITE_URL}/lib/bootstrap/2.3.1/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen" />
<link href="{$SITE_URL}/view/common.css" rel="stylesheet" media="screen" />
EOF;
echo $header_str;
?>