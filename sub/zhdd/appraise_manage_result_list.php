<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 31003 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/it_showpage.class.php';
//$O_Session->ValidModuleForPage(MODULEID);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<link href="../../css/common.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../../js/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="../../js/common.fun.js"></script>
	<script type="text/javascript" src="../../js/ajax.class.js"></script>
	<script type="text/javascript" src="../../js/ajax_post.class.js"></script>
	<script type="text/javascript" src="../../js/dialog.fun.js"></script>
	<script type="text/javascript" src="js/common.fun.js"></script>
	<script type="text/javascript" src="js/function.js"></script>
	<link type="text/css" rel="stylesheet" href="../../module/DatePicker/skin/WdatePicker.css"/>
    <script type="text/javascript" src="../../module/DatePicker/WdatePicker.js"></script>
</head>

<body class="bodycolor" style="padding-top:10px">
<?php

$o_scroll = new ShowPage ( $O_Session->getUserObject ());

if (is_numeric ( $_GET ['page'] )) {
	$o_page = $_GET ['page'];
} else {
	$o_page = 1;
}

echo ($o_scroll->getAppraiseResultList ($o_page));
?>
	<script type="text/javascript" language="javascript">
		function search()
		{
			if($('#Vcl_Owner').val()=='')
			{
				 parent.parent.Dialog_Message('请输入搜索条件 ！');
				 return;
			}
			location='appraise_manage_result_list.php?owner='+$('#Vcl_Owner').val();
		}
	S_Root='../../';
	parent.parent.parent.Common_CloseDialog();
    </script>
</body>
</html>
