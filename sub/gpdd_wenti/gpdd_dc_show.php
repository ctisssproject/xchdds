<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30026 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
$o_table = new GPDD_Dc($_GET['id']);
	function AilterTextArea($s_text) {
		$s_content = $s_text;
		$s_content = str_replace ( "<br/>", "\n", $s_content );
		$s_content = str_replace ( '&nbsp;', ' ', $s_content );
		return $s_content;
	}
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
<script type="text/javascript">
var S_Root='../../';
</script>
</head>
<body class="bodycolor">
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=ZcReject"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
	<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
	<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="900" align="center" style="margin-top:10px">
	<tbody>
		<tr>
			<td><img src="../../images/folder_common.gif" align="absmiddle" /><span
				class="big3"> 督查详情</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="900" style="margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>日期：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getDate())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>标题：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getTitle())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>学校名称：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getSchoolName())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80" style="vertical-align: top;"><strong>督查内容：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getContent())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80" style="vertical-align: top;"><strong>学校反馈：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getFeedback())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>反馈日期：</strong></td>
			<td class="TableData">
			<?php if($o_table->getFeedbackDate()!='0000-00-00')echo($o_table->getFeedbackDate())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>反馈人：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getFeedbackName())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80" style="vertical-align: top;"><strong>督查组审批意见：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getOwnerFeedback())?>
			</td>
		</tr>
		<?php 
		if ($o_table->getState()==3)
		{
			?>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"
				style="vertical-align: top;"><strong style="color:red">退回意见：</strong></td>
			<td class="TableData"><?php echo($o_table->getReason1())?></td>
		</tr>
			<?php
		}
		?>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>完成日期：</strong></td>
			<td class="TableData">
			<?php if($o_table->getCompletedDate()!='0000-00-00')echo($o_table->getCompletedDate())?>
			</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="4" nowrap="nowrap" height="40">
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
