<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30015 );
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
<script type="text/javascript" src="js/function.js"></script>
</head>
<body class="bodycolor">
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=RecordAdd"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="800" align="center" style="margin-top:10px">
	<tbody>
		<tr>
			<td><img src="../../images/folder_common.gif" align="absmiddle" /><span
				class="big3"> 问题信息</span></td>
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
			<td class="TableData" nowrap="nowrap" width="80"><strong>姓名：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getName())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>电话：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getPhone())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>身份：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getProfile())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>来源：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getFrom())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>学校名称：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getSchoolName())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>问题类型：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getTypeName())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>问题内容：</strong></td>
			<td class="TableData" style="vertical-align: top;">
			<?php echo($o_table->getContent())?>
			</td>
		</tr>
		<?php 
		//根据处理类型
		if($o_table->getFeedbackType()=="业务科室处理")
		{
			//显示相关信息
			require_once RELATIVITY_PATH.'sub/telephone/include/db_table.class.php';
			$o_table2=new Telephone_Info_Special($_GET['id']);
			?>
		<tr>
			<td class="TableData" nowrap="nowrap"><strong>督导室处理建议：</strong></td>
			<td class="TableData" colspan="3"><?php echo($o_table2->getDd())?><br/>
				<div style="margin-top:3px;"><strong>主管领导：</strong><?php echo($o_table2->getDdQz())?></div>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap"><strong>教工委、教委意见：</strong></td>
			<td class="TableData" colspan="3"><?php echo($o_table2->getJgw())?>
				<div style="margin-top:3px;"><strong>主管领导：</strong><?php echo($o_table2->getJgwQz())?></div>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap"><strong>最终处理结果：</strong></td>
			<td class="TableData" colspan="3"><?php echo($o_table2->getCljg())?><br/>
				<div style="margin-top:3px;"><strong>承办人：</strong><?php echo($o_table2->getCbr())?></div>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"><strong>答复情况：</strong></td>
			<td class="TableData" colspan="3"><?php echo($o_table2->getDf())?></td>
		</tr>
			<?php
		}else{
			?>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>处理内容：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getFeedback())?>
			</td>
		</tr> 
			<?php
		}
		?>
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>处理类型：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getFeedbackType())?>
			</td>
		</tr> 
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>处理时间：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getFeedbackDate())?>
			</td>
		</tr> 
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>处理人：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getFeedbackName())?>
			</td>
		</tr> 
		<tr>
			<td class="TableData" nowrap="nowrap" width="80"><strong>完成时间：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getResolveDate())?>
			</td>
		</tr>  
		<tr class="TableControl" align="center">
			<td colspan="4" nowrap="nowrap" height="40">
			<?php 
			if ($o_table->getOwnerId()==$O_Session->getUid() && $o_table->getState()==9)
			{
				?>
				<input value="确认解决" style="color:#009900" class="BigButtonB" onclick="handle_confirm(<?php echo($_GET['id'])?>,'<?php echo($_SERVER['HTTP_REFERER'])?>')" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="未解决" style="color:red" class="BigButtonB" onclick="handle_disconfirm(<?php echo($_GET['id'])?>,'<?php echo($_SERVER['HTTP_REFERER'])?>')" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<?php
			}
			?>
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
