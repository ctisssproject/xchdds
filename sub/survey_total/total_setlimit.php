<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 20001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH.'sub/survey/include/db_view.class.php';
$O_Session->ValidModuleForPage(MODULEID);
$o_term = new View_Total_Item ($_GET['id']);
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
<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
<input type="hidden" name="Ajax_FunName" value="SetLimit"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="800" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/edit1.gif" align="absmiddle" /><span
				class="big3"> 设置测评上限</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="800"
	style="margin-top: 10px">
	<tbody>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap"
				style="font-size: 14px; height:45px;background-color:#EEF9FF" align="center"><strong><?php echo($o_term->getSubjectName())?></strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">测评单位：</td>
			<td class="TableData"><?php echo($o_term->getDeptName())?>
				</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">测评对象：</td>
			<td class="TableData"><?php echo($o_term->getTypeName())?>
				</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">已参与人数：</td>
			<td class="TableData"><?php echo($o_term->getSum())?>人
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">测评人数上限：</td>
			<td class="TableData"><input id="Vcl_Limit" name="Vcl_Limit"
				class="BigInput" size="16" maxlength="255" onkeyup="value=value.replace(/[^0-9]/g,'')" type="text" value="<?php echo($o_term->getLimit())?>"/> 注：如果无上限，请填写 0
				</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40"><input value="提交" class="BigButtonB"
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
	function review_printer()
	{
	    var temp=document.getElementById('Vcl_Limit').value;
	    if (temp.length==0){
	        parent.parent.Dialog_Message("[ 人数上限 ] 不能为空")
	        return
	    }
	    document.getElementById('submit_form').submit();
	    parent.parent.Common_OpenLoading()
	}
	parent.parent.parent.Common_CloseDialog();
    </script>
</body>
</html>
