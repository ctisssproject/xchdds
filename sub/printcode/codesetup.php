<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 40001 );
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
<form action="include/bn_submit.switch.php?" id="submit_form" method="post" target="submit_form_frame" enctype="multipart/form-data">
<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
<input type="hidden" name="Ajax_FunName" value="ChapterAdd"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="800" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/notify_new.gif" align="absmiddle" /><span
				class="big3"> 打印家长编号</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="800"
	style="margin-top: 10px">
	<tbody>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap"
				style="font-size: 14px; height:45px;background-color:#EEF9FF" align="center"><strong>打印信息</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">打印条数：</td>
			<td class="TableData"><input id="Vcl_Sum" name="Vcl_Sum"
				class="BigInput" size="16" maxlength="255" type="text"/>
				</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">学校编号：</td>
			<td class="TableData"><input id="Vcl_SchoolId" name="Vcl_SchoolId"
				class="BigInput" size="16" maxlength="255" type="text"/>
				</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">使用对象：</td>
			<td class="TableData">
			<select name="Vcl_Type" id="Vcl_Type">
				<option value="1">中小学家长</option>
				<option value="0">幼儿家长</option>
				<option value="2">校外学员家长</option>
			    </select>	
			</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40"><input value="打印预览" class="BigButtonB"
				onclick="review_printer()" type="button" />
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
