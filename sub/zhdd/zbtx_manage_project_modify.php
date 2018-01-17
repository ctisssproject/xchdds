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
<input type="hidden" name="Vcl_BackUrl" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>zbtx_manage_list.php"/>
<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
<input type="hidden" name="Vcl_FunName" value="<?php 
	if ($_GET['id']>0)
	{
		$o_table=new Zhdd_Zbtx_Project($_GET['id']);
		if ($o_table->getState()==1)
		{
			//如果已经发布，那么不能修改
			exit();
		}
		echo('ZbtxProjectModify');
	}else{
		echo('ZbtxProjectAdd');
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
			<td class="TableData" nowrap="nowrap" width="120"><span style="color:red">*</span> 标题：</td>
			<td class="TableData"><input id="Vcl_Name" name="Vcl_Name"
				class="BigInput" style="width:300px;" size="16" maxlength="30" type="text" value=""/>
				</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">说明：</td>
			<td class="TableData"><input id="Vcl_Explain" name="Vcl_Explain"
				class="BigInput" style="width:300px;" size="16" maxlength="30" type="text" value=""/>
				</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120" style="vertical-align:top"><span style="color:red">*</span> 测评范围：</td>
			<td class="TableData">
				<?php 
				//循环范围
				$o_scope=new Base_School_Type();
				$o_scope->PushOrder ( array ('Id', 'A' ) );
				for($i=0;$i<$o_scope->getAllCount();$i++)
				{
					echo('
					<div style="width:80px;float:left;padding-right:20px;">
						<input class="DuxueJoin" id="Vcl_Scope_'.$o_scope->getId($i).'" name="Vcl_Scope_'.$o_scope->getId($i).'" type="checkbox" style="float:left;margin-top:3px;cursor:pointer;"></input><label for="Vcl_Scope_'.$o_scope->getId($i).'" style="float:left;cursor:pointer;">&nbsp;'.$o_scope->getName($i).'</label>
					</div>	
					');
				}				
				?>				
			</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40"><input value="提交" class="BigButtonA"
				onclick="zbtx_manage_project_submit()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="返回" class="BigButtonA" onclick="location='<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>zbtx_manage_list.php'" type="button" />
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
		$('#Vcl_Name').val('<?php echo($o_table->getName())?>');
		$('#Vcl_Explain').val('<?php echo($o_table->getExplain())?>');
		<?php
		//设置范围
		$a_scorp=json_decode($o_table->getScope());
		for($i=0;$i<count($a_scorp);$i++)
		{
			echo('$("#Vcl_Scope_'.$a_scorp[$i].'").attr("checked",true);');
		}
	}
	?>
    </script>
</body>
</html>
