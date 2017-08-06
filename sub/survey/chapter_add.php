<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 10001 );
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
<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
<input type="hidden" name="Ajax_FunName" value="ChapterAdd"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="800" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/notify_new.gif" align="absmiddle" /><span
				class="big3"> 添加测评表</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="800"
	style="margin-top: 10px">
	<tbody>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap"
				style="font-size: 14px; height:45px;background-color:#EEF9FF" align="center"><strong>基本信息</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">测评表名称：</td>
			<td class="TableData"><input id="Vcl_Title" name="Vcl_Title"
				class="BigInput" style="width:300px;" size="16" maxlength="255" type="text"/>
				</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">测评范围：</td>
			<td class="TableData">
			<select name="Vcl_Scope" id="Vcl_Scope" onchange="change_type(this)">
			   <option value="0">幼儿园</option>
			   <option value="1">小学 中学</option>
			   <option value="2">校外</option>
			</select>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">测评对象：</td>
			<td class="TableData">
			<div id="type_0">
			<?php 
			$o_type=new SurveyType();
			$o_type->PushWhere ( array ('&&', 'Type', '=',0) );
			$o_type->PushOrder ( array ('Id', 'A' ) );
			$n_count=$o_type->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				echo('<input id="Vcl_Type'.$o_type->getId($i).'" name="Vcl_Type'.$o_type->getId($i).'" type="checkbox" /> '.$o_type->getName($i).'&nbsp;&nbsp;&nbsp;&nbsp;');
			}
			?>
			</div>
			<div id="type_1" style="display:none">
			<?php 
			$o_type=new SurveyType();
			$o_type->PushWhere ( array ('&&', 'Type', '=',1) );
			$o_type->PushOrder ( array ('Id', 'A' ) );
			$n_count=$o_type->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				echo('<input id="Vcl_Type'.$o_type->getId($i).'" name="Vcl_Type'.$o_type->getId($i).'" type="checkbox" /> '.$o_type->getName($i).'&nbsp;&nbsp;&nbsp;&nbsp;');
			}
			?>
			</div>
			<div id="type_2" style="display:none">
			<?php 
			$o_type=new SurveyType();
			$o_type->PushWhere ( array ('&&', 'Type', '=',2) );
			$o_type->PushOrder ( array ('Id', 'A' ) );
			$n_count=$o_type->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				echo('<input id="Vcl_Type'.$o_type->getId($i).'" name="Vcl_Type'.$o_type->getId($i).'" type="checkbox" /> '.$o_type->getName($i).'&nbsp;&nbsp;&nbsp;&nbsp;');
			}
			?>
			</div>
		</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40"><input value="提交" class="BigButtonA"
				onclick="chapter_add()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="返回" class="BigButtonA"
				onclick="parent.location='<?php echo($_SERVER['HTTP_REFERER'])?>'" type="button" />
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
