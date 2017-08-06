<?php
define ( 'RELATIVITY_PATH', '' );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link href="theme/default/index.css" rel="stylesheet" type="text/css" />
    <link href="theme/default/portal_index.css" rel="stylesheet" type="text/css" />
    <link href="css/common.css" rel="stylesheet" type="text/css" />
    <link href="css/desktop.css" rel="stylesheet" type="text/css" />
    <link href="images/org/ui.dynatree.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery/jquery-ui.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery/jquery.ui.draggable.min.js"></script>
	<script type="text/javascript" src="js/jquery/jquery.ux.borderlayout.js"></script>
	<script type="text/javascript" src="js/jquery/jquery.ui.sortable.min.js"></script>
	<script type="text/javascript" src="js/jquery/jquery.ux.simulatemouse.js"></script>
	<script type="text/javascript" src="js/jquery/jquery.ui.droppable.min.js"></script>
	<script type="text/javascript" src="js/ajax.class.js"></script>
	<script type="text/javascript" src="js/desktop.fun.js"></script>
</head>
<body class="desktop_bj">
    <div class="slidebox" style="overflow:auto">
        <div style="height: 2000px; width: 100%; position: relative; left: 0; margin-left: 0px">
            <div id="desktop" class="screen" style="left: 0px; top: 0px; position: absolute; width: 100%;
                height: 100%;">
                <ul id="ui-sortable" class="ui-sortable"></ul>
            </div>
        </div>
    </div>
    <div id="master_box" class="screen" 
	style="position: absolute; z-index: 2000; left: 0px; top: -10000px;"></div>
	<script>
	try{
	$(function(){desktopRefresh()});
	}catch(e){}
	try{
    	var N_Timeer=setInterval('desktopRefresh()',30000);//每隔30秒读一下
    }catch(e){}
	</script>
</body>

</html>