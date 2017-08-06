<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30005);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_table.class.php';
require_once 'include/db_view.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
$o_table = new View_Telephone_Info_Special ($_GET['id']);
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
<link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />
<link href="../../images/org/ui.dynatree.css" rel="stylesheet"
	type="text/css" />
<link href="../../theme/default/layout_left.css" rel="stylesheet"
	type="text/css" />
<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" href="../../module/DatePicker/skin/WdatePicker.css" />
<script type="text/javascript" src="../../module/DatePicker/WdatePicker.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
</head>
<body class="bodycolor">
<form method="post" id="dialog_form" action="include/bn_submit.svr.php?function=DudaoModify" enctype="multipart/form-data" target="ajax_submit_frame" style="width: 100%">
	<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
	<input type="hidden" name="Vcl_Completed" id="Vcl_Completed" value="0"/>
	<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="800" align="center" style="margin-top:10px">
	<tbody>
		<tr>
			<td><img src="../../images/outbox.gif" align="absmiddle" /><span
				class="big3"> 西城区责任督学挂牌督导特殊问题办理记录单</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="800" style="margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" colspan="4" nowrap="nowrap" style="font-size:14px" align="center"><strong>基本信息</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">来电日期：</td>
			<td class="TableData">
			    <?php echo($o_table->getRecordDate().'-'.$o_table->getRecordTime());?>
			</td>
			<td class="TableData" nowrap="nowrap" width="120">记录人：</td>
			<td class="TableData">
				<?php echo($o_table->getUserName());?>
			</td>
		</tr>
		<tr>
			<td class="TableData" colspan="4" nowrap="nowrap" style="font-size:14px" align="center"><strong>信息来源</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">姓名：</td>
			<td class="TableData">
				<?php echo($o_table->getName());?>
			</td>
			<td class="TableData" nowrap="nowrap" width="120">联系电话（邮箱）：</td>
			<td class="TableData">
				<?php echo($o_table->getPhone())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">反映学校（部门）：</td>
			<td class="TableData" width="350" colspan="3">
				<?php echo($o_table->getSchoolName())?>
			</td>			
		</tr>
		<tr>
			<td class="TableData" colspan="4" nowrap="nowrap" style="font-size:14px" align="center"><strong>记录内容</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">反映情况：</td>
			<td class="TableData" colspan="3"><?php echo($o_table->getContent())?></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">督导室处理建议：</td>
			<td class="TableData" colspan="3"><textarea class="BigInput" style="" name="Vcl_Dd" id="Vcl_Dd"
				rows="4" cols="50"><?php echo(AilterTextArea($o_table->getDd()));?></textarea> <span class="red">*</span><br/>
				<div style="margin-top:3px;">主管领导：<input id="Vcl_DdQz" name="Vcl_DdQz" size="20" maxlength="20" class="BigInput" value="<?php echo($o_table->getDdQz());?>" type="text"/> <span class="red">*</span></div>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">教工委、教委意见：</td>
			<td class="TableData" colspan="3"><textarea class="BigInput" style="" name="Vcl_Jgw" id="Vcl_Jgw"
				rows="4" cols="50"><?php echo(AilterTextArea($o_table->getJgw ()));?></textarea> <span class="red">*</span><br/>
				<div style="margin-top:3px;">主管领导：<input id="Vcl_JgwQz" name="Vcl_JgwQz" size="20" maxlength="20" class="BigInput" value="<?php echo($o_table->getJgwQz());?>" type="text"/> <span class="red">*</span></div>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">最终处理结果：</td>
			<td class="TableData" colspan="3"><textarea class="BigInput" style="" name="Vcl_Cljg" id="Vcl_Cljg"
				rows="6" cols="50"><?php echo(AilterTextArea($o_table->getCljg ()));?></textarea> <span class="red">*</span><br/>
				<div style="margin-top:3px;">承办人：<input id="Vcl_Cbr" name="Vcl_Cbr" size="20" maxlength="20" class="BigInput" value="<?php echo($o_table->getCbr());?>" type="text"/> <span class="red">*</span></div>
				<div style="margin-top:3px;">完成时间：<input id="Vcl_CbDate" name="Vcl_CbDate" size="20" readonly="readonly" maxlength="20" class="BigInput" onclick="WdatePicker()" value="<?php 
				if($o_table->getCbDate()=='0000-00-00')
				{
					echo('');
				}else{
					echo($o_table->getCbDate());
				}
				?>" type="text"/> <span class="red">*</span></div>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">答复情况：</td>
			<td class="TableData" colspan="3">
				<select name="Vcl_Df" id="Vcl_Df"class="BigSelect">
					<option value="电话" selected="selected">电话</option>
					<option value="面谈">面谈</option>
					<option value="电子邮件">电子邮件</option>
					<option value="其他">其他</option>
				</select>
			</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="6" nowrap="nowrap" height="40">
			<input value="暂存" class="BigButtonA" onclick="submitDudaoModify(0)" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
			<input value="完结" class="BigButtonA" onclick="submitDudaoModify(1)" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
			<input value="返回" class="BigButtonA" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'" type="button" /></td>
		</tr>
	</tbody>
</table>
<br>
</br>
</form>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0" height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<script type="text/javascript" language="javascript">
	S_Root='../../';
	document.getElementById('Vcl_Df').value='<?php echo($o_table->getDf())?>';
    </script>
</body>
</html>
