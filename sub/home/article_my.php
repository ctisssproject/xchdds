<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 95 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/it_showpage.class.php';
$O_Session->ValidModuleForPage(MODULEID);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
	<link href="../../css/common.css" rel="stylesheet" type="text/css" />
<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>
</head>
<body class="bodycolor" style="padding-top:10px">
<?php
$o_scroll = new ShowPage ( $O_Session->getUserObject ());
if (is_numeric ( $_GET ['page'] )) {
	$o_page = $_GET ['page'];
} else {
	$o_page = 1;
}
echo ($o_scroll->getArticleMy ($o_page));
?>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<div id="master_box"
	style="position: absolute; z-index: 2000; left: 0px; top: -500px;">
</div>
<script type="text/javascript" language="javascript">
	S_Root='../../';
    </script>
</body>
</html>