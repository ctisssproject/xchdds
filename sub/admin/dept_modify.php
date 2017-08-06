<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 85 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
$o_dept=new Base_Dept($_GET['id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<link type="text/css" rel="stylesheet" href="../../module/DatePicker/skin/WdatePicker.css" />
<script type="text/javascript" src="../../module/DatePicker/WdatePicker.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
</head>
<body class="bodycolor">
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=DeptModify"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
	<input type="hidden" name="Vcl_DeptId" value="<?php echo($_GET['id'])?>"/>
	<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="600" align="center" style="margin-top:10px">
	<tbody>
		<tr>
			<td><img src="../../images/flow_edit.gif" align="absmiddle" /><span
				class="big3"> 编辑部门</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="600" style="margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>部门信息</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">部门名称：</td>
			<td class="TableData">
			<input id="Vcl_Name" name="Vcl_Name" size="20" maxlength="20" class="BigInput" value="" type="text"/>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">上级部门：</td>
			<td class="TableData">
				<div id="deptvcl"></div>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">类型：</td>
			<td class="TableData">
				<select name="Vcl_Type" id="Vcl_Type">
					<option></option>
				<?php 
				$o_type=new Base_School_Type();
				$o_type->PushOrder ( array ('Id', 'A' ) );
				$n_count=$o_type->getAllCount();
				for($i=0;$i<$n_count;$i++)
				{
					if ($o_type->getId($i)==10)
					{
						echo('<option value="'.$o_type->getId($i).'" selected="selected">'.$o_type->getName($i).'</option>');
					}else{
						echo('<option value="'.$o_type->getId($i).'">'.$o_type->getName($i).'</option>');
					}
				}
				?>
			    </select>			
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">问卷识别号：</td>
			<td class="TableData">
			<input id="Vcl_SurveyNumber" name="Vcl_SurveyNumber" size="20" maxlength="20" class="BigInput" value="" type="text"/> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">责任督学：</td>
			<td class="TableData">
				<select name="Vcl_Uid" id="Vcl_Uid">
				<option value="0"></option>
				<?php 
				$o_type = new View_User_List ();
				$o_type->PushWhere ( array ('&&', 'State', '=', 1 ) );
				$o_type->PushWhere ( array ('&&', 'DeptId', '=', 138 ) );
				$o_type->PushOrder ( array ('Name', 'A' ) );
				$n_count=$o_type->getAllCount();
				for($i=0;$i<$n_count;$i++)
				{
					echo('<option value="'.$o_type->getUid($i).'">'.$o_type->getName($i).'</option>');
				}
				?>
			    </select> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">电话：</td>
			<td class="TableData">
			<input id="Vcl_Phone" name="Vcl_Phone" size="20" maxlength="20" class="BigInput" value="" type="text"/> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">传真：</td>
			<td class="TableData">
			<input id="Vcl_Fax" name="Vcl_Fax" size="20" maxlength="20" class="BigInput" value="" type="text"/> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">地址：</td>
			<td class="TableData">
			<input id="Vcl_Address" name="Vcl_Address" size="20" maxlength="50" class="BigInput" value="" type="text"/> <span>（可选）</span>
			</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40">
			<input value="修改" class="BigButtonA"
				onclick="submitDetpAdd()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
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
	deptModifyDeptGetDeptVcl(<?php echo($_GET['id']);?>) 
	document.getElementById('Vcl_Name').value='<?php echo($o_dept->getName());?>';
	document.getElementById('Vcl_SurveyNumber').value='<?php echo($o_dept->getSurveyNumber());?>';
	document.getElementById('Vcl_Type').value='<?php echo($o_dept->getType());?>';
	document.getElementById('Vcl_Uid').value='<?php echo($o_dept->getUid());?>';
	document.getElementById('Vcl_Phone').value='<?php echo($o_dept->getPhone());?>';
	document.getElementById('Vcl_Fax').value='<?php echo($o_dept->getFax());?>';
	document.getElementById('Vcl_Address').value='<?php echo($o_dept->getAddress());?>';
    </script>
</body>
</html>
