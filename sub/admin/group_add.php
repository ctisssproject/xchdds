<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 97 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
</head>
<body class="bodycolor">
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=GroupAdd"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
	<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="1000" align="center" style="margin-top:10px">
	<tbody>
		<tr>
			<td><img src="../../images/notify_new.gif" align="absmiddle" /><span
				class="big3"> 添加分组</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="1000" style="margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>分组信息</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"><strong>分组名称：</strong></td>
			<td class="TableData">
			<input id="Vcl_Name" name="Vcl_Name" size="20" maxlength="20" class="BigInput" value="" type="text"/>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120" style="vertical-align:top"><strong>部门成员：</strong></td>
			<td class="TableData">
				<?php 
				$o_temp=new Base_Dept();
				$o_temp->PushWhere ( array ('&&', 'ParentId', '=', 1 ) );
				$o_temp->PushOrder ( array ('Name', 'A' ) );
				$n_count=$o_temp->getAllCount();
				for($i=0;$i<$n_count;$i++)
				{
					echo('
				<div style="width:230px;float:left;padding-right:20px;">
					<input id="Vcl_Dept_'.$o_temp->getDeptId($i).'" name="Vcl_Dept_'.$o_temp->getDeptId($i).'" type="checkbox" style="float:left;margin-top:3px;cursor:pointer;"/><label for="Vcl_Dept_'.$o_temp->getDeptId($i).'" style="float:left;cursor:pointer;"> '.$o_temp->getName($i).'</label>
				</div>
					');
				}
				?>
				
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120" style="vertical-align:top"><strong>督学成员：</strong></td>
			<td class="TableData">
				<?php 
				$o_temp=new View_User_Info();
				$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
				$o_temp->PushWhere ( array ('&&', 'DeptId', '=', 138 ) );
				$o_temp->PushOrder ( array ('Name', 'A' ) );
				$n_count=$o_temp->getAllCount();
				for($i=0;$i<$n_count;$i++)
				{
					echo('
				<div style="width:80px;float:left;padding-right:20px;">
					<input id="Vcl_User_'.$o_temp->getUid($i).'" name="Vcl_User_'.$o_temp->getUid($i).'" type="checkbox" style="float:left;margin-top:3px;cursor:pointer;"/><label for="Vcl_User_'.$o_temp->getUid($i).'" style="float:left;cursor:pointer;"> '.$o_temp->getName($i).'</label>
				</div>
					');
				}
				?>
			</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40">
			<input value="添加" class="BigButtonA"
				onclick="submitGroupAdd()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="返回" class="BigButtonA" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'" type="button" /></td>
		</tr>

	</tbody>
</table>
<br></br>
</form>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<script type="text/javascript" language="javascript">
	S_Root='../../';

	
    </script>
</body>
</html>
