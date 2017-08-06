<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30023 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/it_showpage.class.php';
$O_Session->ValidModuleForPage(MODULEID);
if (is_numeric ( $_GET ['page'] )) {
	$o_page = $_GET ['page'];
	
} else {
	$o_page = 1;

}
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
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/function.js"></script>
<link type="text/css" rel="stylesheet" href="../../module/DatePicker/skin/WdatePicker.css"/>
<script type="text/javascript" src="../../module/DatePicker/WdatePicker.js"></script>
</head>
<body class="bodycolor" topmargin="0">
<div style="padding-left:10px;padding-right:10px;padding-top:5px">
<?php
$o_list = new ShowPage ( $O_Session->getUserObject ());
echo ($o_list->getZcCompletedList($o_page));
?>
</div>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<div id="master_box"
	style="position: absolute; z-index: 2000; left: 0px; top: -500px;">
</div>
<script type="text/javascript" language="javascript">
		function search()
		{
			if($('#Vcl_Owner').val()=='' && $('#Vcl_StartDate').val()=='' && $('#Vcl_EndDate').val()=='' && $('#Vcl_SchoolName').val()=='')
			{
				 parent.parent.Dialog_Message('请输入搜索条件 ！');
				 return;
			}
			location='gpdd_zc_completed.php?owner='+$('#Vcl_Owner').val()+'&start='+$('#Vcl_StartDate').val()+'&end='+$('#Vcl_EndDate').val()+'&schoolname='+$('#Vcl_SchoolName').val();
		}
	S_Root='../../';
    </script>
</body>
</html>
