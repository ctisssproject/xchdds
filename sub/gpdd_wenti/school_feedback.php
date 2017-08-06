<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30014 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
$o_table = new GPDD_Wenti($_GET['id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />

<link type="text/css" rel="stylesheet" href="../../module/DatePicker/skin/WdatePicker.css" />
<script type="text/javascript" src="../../module/DatePicker/WdatePicker.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/function.js"></script>
</head> 
<body class="bodycolor">
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=HandleFeedback"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
	<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
	<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="800" align="center" style="margin-top:10px">
	<tbody>
		<tr>
			<td><img src="../../images/folder_common.gif" align="absmiddle" /><span
				class="big3"> 协同办理</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="800" style="margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>日期：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getDate())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>学校名称：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getSchoolName())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>问题内容：</strong></td>
			<td class="TableData" style="vertical-align: top;">
			<?php echo($o_table->getContent())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>来源：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getFrom())?>
			</td>
		</tr>
		
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>问题类型：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getTypeName())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>状态：</strong></td>
			<td class="TableData">
			<?php 
			$s_state='';
			switch ($o_table->getState())
			{
				case 1:
					$s_state='<span style="color:#FF6600">等待处理</span>';
					break;
				case 2:
					$s_state='<span style="color:#FF6600">等待学校处理</span>';
					break;
				case 3:
					$s_state='<span style="color:#FF6600">等待业务科室处理</span>';
					break;
				default :
					break;
			}	
			echo($s_state)?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap"><strong>处理内容：</strong></td>
			<td class="TableData" colspan="3">
				<textarea class="BigInput" style="" name="Vcl_Feedback" id="Vcl_Feedback" rows="10" cols="50"></textarea>
			</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="4" nowrap="nowrap" height="40">
				<input value="提交" class="BigButtonA" onclick="handle_feedback()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="返回" class="BigButtonA" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'" type="button" />
			</td>
		</tr>
	</tbody>
</table>
<br></br>
</form>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0" height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<script type="text/javascript" language="javascript">
	S_Root='../../';
    </script>
</body>
</html>
