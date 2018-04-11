<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 31003 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);
$o_table=new Zhdd_Appraise_Questions($_GET['id']);
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
<input type="hidden" name="Vcl_BackUrl" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']).'appraise_manage_edit_list.php?id='.$o_table->getAppraiseId())?>"/>
<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
<input type="hidden" name="Vcl_FunName" value="AppraiseSingleModify"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	style="margin-left:auto;margin-right:auto;min-width:800px;" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/edit.gif" align="absmiddle" /><span
				class="big3"> 修改单选题</span></td>
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
				class="BigInput" value="<?php echo($o_table->getQuestion())?>" style="width:600px;" size="16" maxlength="255" type="text"/>
				</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">是否必答：</td>
			<td class="TableData">
				<select name="Vcl_IsMust" id="Vcl_IsMust" class="BigSelect">
					<option value="1" selected="selected">必答</option>
					<option value="0">选答</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">选项：</td>
			<td class="TableData"><input id="Vcl_Content" name="Vcl_Content"
				class="BigInput" value="<?php echo($o_table->getQuestion())?>" style="width:600px;" size="16" maxlength="255" type="text"/>
				</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">选项：</td>
			<td class="TableData">				
			<?php
				$a_option = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I','J','K','L','M','N','O','P','Q','R','S','T' );
				$o_temp = new Zhdd_Appraise_Options ();
				$o_temp->PushWhere ( array ('&&', 'QuestionId', '=', $o_table->getId () ) );
				$o_temp->PushOrder ( array ('Number', 'A' ) );
				$n_count=$o_temp->getAllCount();
				for($i = 0; $i < count ( $a_option ); $i ++) {
					if ($i==0)
					{
						$s_style='';
					}else{
						$s_style=' style="margin-top: 10px"';
					}
					if ($i<$n_count) {	
						echo ('<div'.$s_style.'>
									'.$a_option [$i].'：<input id="Vcl_Option_'.$a_option [$i].'" name="Vcl_Option_'.$a_option [$i].'" value="'.$o_temp->getOption($i).'" class="BigInput" maxlength="255" style="width: 600px" type="text" />
							   </div>');
					} else {
						echo ('<div'.$s_style.'>
									'.$a_option [$i].'：<input id="Vcl_Option_'.$a_option [$i].'" name="Vcl_Option_'.$a_option [$i].'" value="" maxlength="255" class="BigInput" style="width: 600px" type="text" />
							   </div>');
					}
				}
				?>		<div style="margin-top:10px"><span class="gray">注：请按照顺序填写选项，如果中间有空行，系统将自动舍弃之后的内容。</span></div>

		</td>
		</tr>		
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40"><input value="提交" class="BigButtonA"
				onclick="appraise_single_add()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="返回" class="BigButtonA"
				onclick="location='<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']).'appraise_manage_edit_list.php?id='.$o_table->getAppraiseId())?>'" type="button" />
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
	$('#Vcl_IsMust').val('<?php echo($o_table->getIsMust())?>');
    </script>
</body>
</html>
