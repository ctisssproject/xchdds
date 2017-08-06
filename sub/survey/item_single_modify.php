<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 10001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);
$o_table=new SurveyItem($_GET['id']);
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
<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
<input type="hidden" name="Ajax_FunName" value="ItemSingleModify"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="800" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/edit.gif" align="absmiddle" /><span
				class="big3"> 修改单选题</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="800" style="margin-top: 10px">
	<tbody>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap"
				style="font-size: 14px; height:45px;background-color:#EEF9FF" align="center"><strong>基本信息</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">题目：</td>
			<td class="TableData"><input id="Vcl_Content" name="Vcl_Content"
				class="BigInput" value="<?php echo($o_table->getContent())?>" style="width:300px;" size="16" maxlength="255" type="text"/>
				</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">选项：</td>
			<td class="TableData">				
			<?php
				$a_option = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I','J' );
				$o_temp = new SurveyOption ();
				$o_temp->PushWhere ( array ('&&', 'ItemId', '=', $o_table->getItemId () ) );
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
									'.$a_option [$i].'：<input id="Vcl_Option_'.$a_option [$i].'" name="Vcl_Option_'.$a_option [$i].'" value="'.$o_temp->getContent($i).'" class="BigInput" maxlength="255" style="width: 600px" type="text" />
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
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">类型：</td>
			<td class="TableData">
				<select name="Vcl_Type" id="Vcl_Type">
				<?php 
				$o_object=new SurveySubject($o_table->getSubjectId());
				$a_type=json_decode($o_object->getType());
				$o_type2=new SurveyType($a_type[0]);
				$o_type=new SurveyItemType();
				$o_type->PushWhere ( array ('&&', 'Type', '=', $o_type2->getType() ) );
				$o_type->PushOrder ( array ('Number', 'A' ) );
				$n_count=$o_type->getAllCount();
				for($i=0;$i<$n_count;$i++)
				{
					echo('<option value="'.$o_type->getId($i).'">'.$o_type->getName($i).'</option>');
				}
				?>
			    </select>			
			</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40"><input value="提交" class="BigButtonA"
				onclick="item_single_add()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="返回" class="BigButtonA"
				onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'" type="button" />
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
	$('#Vcl_Type').val('<?php echo($o_table->getType())?>');
    </script>
</body>
</html>
