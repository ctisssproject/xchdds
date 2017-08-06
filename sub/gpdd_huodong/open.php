<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30018 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>

<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<script type="text/javascript" src="js/function.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>
<link type="text/css" rel="stylesheet" href="../../module/DatePicker/skin/WdatePicker.css"/>
        <script type="text/javascript" src="../../module/DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
var S_Root='../../';
</script>
</head>
<body class="bodycolor">
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=AddArticle"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
	<input type="hidden" name="Vcl_BackUrl" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']).'list.php')?>"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="800" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/notify_new.gif" align="absmiddle" /><span
				class="big3"> 发起活动</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="800"
	style="margin-top: 10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">活动日期：</td>
			<td class="TableData fuja"><input id="Vcl_Date" name="Vcl_Date" size="20" maxlength="20" class="BigInput" value="" readonly="readonly" type="text" onclick="WdatePicker()"/> <span class="red">*</span></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">活动主题：</td>
			<td class="TableData fuja"><input id="Vcl_Title" name="Vcl_Title"
				size="80" maxlength="50" class="BigInput" value="" type="text"
				style="font-size: 14px; height: 20px" /> <span class="red">*</span></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">活动地点：</td>
			<td class="TableData fuja"><input id="Vcl_Address" name="Vcl_Address"
				size="50" maxlength="100" class="BigInput" value="" type="text"/> <span class="red">*</span></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">联系人：</td>
			<td class="TableData fuja"><input id="Vcl_Name" name="Vcl_Name"
				size="30" maxlength="100" class="BigInput" value="" type="text"/> <span class="red">*</span></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">联系电话：</td>
			<td class="TableData fuja"><input id="Vcl_Phone" name="Vcl_Phone"
				size="30" maxlength="100" class="BigInput" value="" type="text"/> <span class="red">*</span></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">活动简述：</td>
			<td class="TableData" colspan="3"><textarea class="BigInput" style="" name="Vcl_Content" id="Vcl_Content" rows="10" cols="50"></textarea> <span class="red">*</span></td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" style="padding: 10px"><input
				value="发起" class="BigButtonA" onclick="addArticle()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="返回" class="BigButtonA" onclick="location='list.php'" type="button" /></td>
		</tr>
		
	</tbody>
</table>
<br></br>

</form>
<iframe id="ajax_submit_frame_affix" name="ajax_submit_frame_affix" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
	<div id="master_box" style="position: absolute; z-index: 2000; left: 0px; top: -500px;"></div>
	
<script type="text/javascript" language="javascript">
	S_Root='../../';
    </script>
</body>
</html>
