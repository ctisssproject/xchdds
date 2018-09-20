<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 33001 );
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
<input type="hidden" name="Vcl_BackUrl" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>appraise_manage.php"/>
<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
<input type="hidden" name="Vcl_FunName" value="<?php 
	if ($_GET['id']>0)
	{
		$o_table=new Dz_Appraise($_GET['id']);
		if ($o_table->getState()==1)
		{
			//如果已经发布，那么不能修改
			exit();
		}
		echo('AppraiseModify');
	}else{
		echo('AppraiseAdd');
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
					echo('修改');
				}else{
					echo('添加');
				}
				?></span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" style="margin-left:auto;margin-right:auto;max-width:400px;margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="160"><span style="color:red">*</span> 标题：</td>
			<td class="TableData"><input id="Vcl_Title" name="Vcl_Title"
				class="BigInput" style="width:300px;" size="16" maxlength="30" type="text" value=""/>
				</td>
		</tr>
		<tr style="display:none">
			<td class="TableData" nowrap="nowrap">类型：</td>
			<td class="TableData"><select name="Vcl_Type" id="Vcl_Type" class="BigSelect">
				<?php 
				$o_item=new Dz_Appraise_Info_Item();
				$o_item->PushOrder ( array ('Type', 'A' ) );
				$o_item->getAllCount();
				$s_type='';
				for($i=0;$i<$o_item->getAllCount();$i++)
				{
					if ($s_type!=$o_item->getType($i))
					{
						echo('<option value="'.$o_item->getType($i).'">'.$o_item->getType($i).'</option>');
						$s_type=$o_item->getType($i);
					}else{
						continue;
					}
					
				}					
				?>
			</select></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap">是否自动推荐综合评价等级：</td>
			<td class="TableData"><select name="Vcl_IsAuto" id="Vcl_IsAuto" class="BigSelect">
				<option value="0">否</option>
				<option value="1">是</option>
			</select></td>
		</tr>
		
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40"><input value="提交" class="BigButtonA"
				onclick="appraise_manage_add_submit()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="返回" class="BigButtonA" onclick="location='<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>appraise_manage.php'" type="button" />
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
		$('#Vcl_Title').val('<?php echo($o_table->getTitle())?>');
		$('#Vcl_Type').val('<?php echo($o_table->getType())?>');
		$('#Vcl_IsAuto').val('<?php echo($o_table->getIsAuto())?>');		
	<?php
	}
	?>
    </script>
</body>
</html>
