<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 10005 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);
$o_table=new SurveyType($_GET['id']);
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
<input type="hidden" name="Vcl_BackUrl" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>type.php"/>
<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
<input type="hidden" name="Ajax_FunName" value="TypeAdd"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="800" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/edit.gif" align="absmiddle" /><span
				class="big3"> 添加测评对象信息</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="800"
	style="margin-top: 10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">对象编号：</td>
			<td class="TableData"><input id="Vcl_Number" name="Vcl_Number"
				class="BigInput" style="width:300px;" size="16" maxlength="30" type="text" value=""/>
				</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">对象名称：</td>
			<td class="TableData"><input id="Vcl_Name" name="Vcl_Name"
				class="BigInput" style="width:300px;" size="16" maxlength="30" type="text" value=""/>
				</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">范围：</td>
			<td class="TableData">
			<select name="Vcl_Scope" id="Vcl_Scope">
			   <option value="0">幼儿园</option>
			   <option value="1">小学 中学</option>
			   <option value="2">校外</option>
			</select>
			</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40"><input value="提交" class="BigButtonA"
				onclick="type_submit()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="返回" class="BigButtonA"
				onclick="location='<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>type.php'" type="button" />
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
