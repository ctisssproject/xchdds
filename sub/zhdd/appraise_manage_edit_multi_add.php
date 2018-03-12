<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 31003 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<link href="../../css/common.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/common.fun.js"></script>
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/ajax_post.class.js"></script>
	<script type="text/javascript" src="../../js/dialog.fun.js"></script>
	<script type="text/javascript" src="js/function.js"></script>

</head>
<body class="bodycolor" topmargin="0" style="padding-left:10px;padding-right:10px;padding-top:10px;color:#333333">
<form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame" enctype="multipart/form-data">
<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
<input type="hidden" name="Vcl_BackUrl" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']).'appraise_manage_edit_list.php?id='.$_GET['id'])?>"/>
<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
<input type="hidden" name="Vcl_FunName" value="AppraiseMultiAdd"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	style="margin-left:auto;margin-right:auto;min-width:800px;" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/notify_new.gif" align="absmiddle" /><span
				class="big3"> 添加多选题</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" border="0" cellpadding="3" cellspacing="0"
	style="margin-left:auto;margin-right:auto;min-width:800px;" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap"
				style="font-size: 14px; height:45px;background-color:#EEF9FF" align="center"><strong>基本信息</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">题目：</td>
			<td class="TableData"><input id="Vcl_Content" name="Vcl_Content"
				class="BigInput" maxlength="255" style="width:600px" size="16" type="text"/>
				</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">选项：</td>
			<td class="TableData"><div>A：<input id="Vcl_Option_A" name="Vcl_Option_A" value="" class="BigInput" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">B：<input id="Vcl_Option_B" name="Vcl_Option_B" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">C：<input id="Vcl_Option_C" name="Vcl_Option_C" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">D：<input id="Vcl_Option_D" name="Vcl_Option_D" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">E：<input id="Vcl_Option_E" name="Vcl_Option_E" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">F：<input id="Vcl_Option_F" name="Vcl_Option_F" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">G：<input id="Vcl_Option_G" name="Vcl_Option_G" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">H：<input id="Vcl_Option_H" name="Vcl_Option_H" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">I： <input id="Vcl_Option_I" name="Vcl_Option_I" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">J： <input id="Vcl_Option_J" name="Vcl_Option_J" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">K： <input id="Vcl_Option_K" name="Vcl_Option_K" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">L： <input id="Vcl_Option_L" name="Vcl_Option_L" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">M： <input id="Vcl_Option_M" name="Vcl_Option_M" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">N： <input id="Vcl_Option_N" name="Vcl_Option_N" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">O： <input id="Vcl_Option_O" name="Vcl_Option_O" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">P： <input id="Vcl_Option_P" name="Vcl_Option_P" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">Q： <input id="Vcl_Option_Q" name="Vcl_Option_Q" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">R： <input id="Vcl_Option_R" name="Vcl_Option_R" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">S： <input id="Vcl_Option_S" name="Vcl_Option_S" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px">T： <input id="Vcl_Option_T" name="Vcl_Option_T" class="BigInput" value="" maxlength="255" style="width:600px" type="text" /></div>
				<div style="margin-top:10px"><span class="gray">注：请按照顺序填写选项，如果中间有空行，系统将自动舍弃之后的内容。</span></div>

			</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40"><input value="提交" class="BigButtonA"
				onclick="appraise_single_add()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="返回" class="BigButtonA"
				onclick="location='<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']).'appraise_manage_edit_list.php?id='.$_GET['id'])?>'" type="button" />
				</td>
		</tr>
		
</tbody>
</table>
</form>
<iframe id="submit_form_frame" name="submit_form_frame" style="display:none" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<script type="text/javascript" language="javascript">
	S_Root='../../';
	parent.parent.parent.Common_CloseDialog();
    </script>
</body>
</html>
