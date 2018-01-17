<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 31001 );
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
<input type="hidden" name="Vcl_BackUrl" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>zbtx_manage_edit_list.php?id=<?php 
if ($_GET['id']>0)
{
	$o_level1=new Zhdd_Zbtx_Level1($_GET['id']);
	$s_project_id=$o_level1->getProjectId();
}else{
	$s_project_id=$_GET['project_id'];
}
echo($s_project_id);
?>"/>
<input type="hidden" name="Vcl_ProjectId" value="<?php echo($_GET['project_id'])?>"/>
<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
<input type="hidden" name="Vcl_FunName" value="<?php 
	if ($_GET['id']>0)
	{
		echo('ZbtxProjectLevel1Modify');
	}else{
		echo('ZbtxProjectLevel1Add');
	}
?>"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	style="margin-left:auto;margin-right:auto;min-width:450px;" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/edit.gif" align="absmiddle" /><span
				class="big3"> <?php 
				if ($_GET['id']>0)
				{
					echo('修改一级指标');
				}else{
					echo('添加一级指标');
				}
				?></span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" style="margin-left:auto;margin-right:auto;max-width:400px;margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"><span style="color:red">*</span> 名称：</td>
			<td class="TableData"><input id="Vcl_Name" name="Vcl_Name"
				class="BigInput" style="width:300px;" size="16" maxlength="30" type="text" value=""/>
				</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">顺序：</td>
			<td class="TableData"><select name="Vcl_Number" id="Vcl_Number" class="BigSelect">
				<?php 
				$o_table=new Zhdd_Zbtx_Level1();
				$o_table->PushWhere ( array ('&&', 'ProjectId', '=', $s_project_id) );
				$o_table->PushWhere ( array ('&&', 'IsDelete', '=', 0) );
				$o_table->PushOrder ( array ('Number', 'A' ) );
				for($i=0;$i<$o_table->getAllCount();$i++)
				{
					echo('<option value="'.($i+1).'">'.($i+1).'</option>');
				}
				if ($o_table->getAllCount()==0)
				{
					echo('<option value="1">1</option>');
				}
				if (!($_GET['id']>0) && $o_table->getAllCount()!=0)
				{
					echo('<option value="'.($i+1).'" selected="selected">'.($i+1).'</option>');
				}		
				?>
			</select></td>
		</tr>	
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40"><input value="提交" class="BigButtonA"
				onclick="zbtx_manage_level1_submit()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="返回" class="BigButtonA" onclick="location='<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>zbtx_manage_edit_list.php?id=<?php echo($s_project_id);?>'" type="button" />
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
	<?php 
	if ($_GET['id']>0)
	{
		
		?>
		$('#Vcl_Name').val('<?php echo($o_level1->getName())?>');
		$('#Vcl_Number').val('<?php echo($o_level1->getNumber())?>');
		<?php
	}
	?>
    </script>
</body>
</html>
