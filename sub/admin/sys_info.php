<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 88 );
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
<link type="text/css" rel="stylesheet" href="../../module/DatePicker/skin/WdatePicker.css" />
<script type="text/javascript" src="../../module/DatePicker/WdatePicker.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
</head>
<body class="bodycolor">
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=UserAdd"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="600" align="center" style="margin-top:10px">
	<tbody>
		<tr>
			<td><img src="../../images/wm.png" align="absmiddle" /><span
				class="big3"> 系统设置</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="600" style="margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>基本信息</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">用户名：</td>
			<td class="TableData">
			<input id="Vcl_UserName" name="Vcl_UserName" size="20" maxlength="20" class="BigInput" value="" type="text"/> <span>注：用户名必须大约4位的英文字母或数字。</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">真实姓名：</td>
			<td class="TableData">
			<input id="Vcl_Name" name="Vcl_Name" size="20" maxlength="20" class="BigInput" value="" type="text"/>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">性别：</td>
			<td class="TableData">
				<select name="Vcl_State" id="Vcl_State"class="BigSelect">
					<option value="男" selected="selected">男</option>
					<option value="女">女</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">密码：</td>
			<td class="TableData">
			<input id="Vcl_Password" name="Vcl_Password" size="21" maxlength="30" class="BigInput" value="" type="password"/> <span>注：密码不能小于6位。</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">确认密码：</td>
			<td class="TableData">
			<input id="Vcl_Password2" name="Vcl_Password2" size="21" maxlength="30" class="BigInput" value="" type="password"/>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">默认邮箱：</td>
			<td class="TableData">
			<input id="Vcl_Email" name="Vcl_Email" size="20" maxlength="20" class="BigInput" value="" type="text"/> <span>注：系统默认发送邮件的邮箱，必须为易邮邮箱。</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">状态：</td>
			<td class="TableData"><select name="Vcl_State" id="Vcl_State"
				class="BigSelect">
				<option value="1" selected="selected">启用</option>
				<option value="0">停用</option>
			</select></td>
		</tr>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>个人信息</strong><span style="font-size:12px">（可让用户自己填写）</span></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">出生日期：</td>
			<td class="TableData">
				<input id="Vcl_Birthday" name="Vcl_Birthday" size="20" readonly="readonly" maxlength="20" class="BigInput" value="" onclick="WdatePicker()" type="text" /> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">手机：</td>
			<td class="TableData">
			<input id="Vcl_MobilePhone" name="Vcl_MobilePhone" size="20" maxlength="20" class="BigInput" value="" type="text"/> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">座机：</td>
			<td class="TableData">
			<input id="Vcl_Phone" name="Vcl_Phone" size="20" maxlength="20" class="BigInput" value="" type="text"/> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">其他邮箱：</td>
			<td class="TableData">
			<input id="Vcl_OtherEmail" name="Vcl_OtherEmail" size="20" maxlength="20" class="BigInput" value="" type="text"/> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">QQ：</td>
			<td class="TableData">
			<input id="Vcl_QQ" name="Vcl_QQ" size="20" maxlength="20" class="BigInput" value="" type="text"/> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>所属部门</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">部门：</td>
			<td class="TableData">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<select name="Vcl_Dept1" id="Vcl_Dept1" style="min-width:100px" class="BigSelect" onchange="getDept2()"><option value=""></option>
									<?php 
									//读取一级部门
									require_once RELATIVITY_PATH . 'include/db_table.class.php';
									$o_detp1=new Base_Dept();
									$o_detp1->PushWhere ( array ('&&', 'ParentId', '=', 0 ) );
									$n_count = $o_detp1->getAllCount ();
									for($i = 0; $i < $n_count; $i ++) {
										echo ('<option value="' . $o_detp1->getDeptId($i) . '">' . $o_detp1->getName($i ). '</option>');
									}
									?>
						</select>
					</td>
					<td id="dept2">
					</td>
					<td id="dept3">
					</td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
		<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>角色设置</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">主角色：</td>
			<td class="TableData">
						<select name="Vcl_Role0" id="Vcl_Role0" style="min-width:100px" class="BigSelect"><option value=""></option>
									<?php 
									//读取角色
									require_once RELATIVITY_PATH . 'include/db_table.class.php';
									$o_role=new Base_Role();
									$n_count = $o_role->getAllCount ();
									$s_select='';
									for($i = 0; $i < $n_count; $i ++) {
										$s_select.='<option value="' . $o_role->getRoleId($i) . '">' . $o_role->getName($i ). '</option>';
									}
									echo($s_select);
									?>
						</select>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色1：</td>
			<td class="TableData">
						<select name="Vcl_Role1" id="Vcl_Role1" style="min-width:100px" class="BigSelect"><option value="0"></option>
									<?php 
									echo($s_select);
									?>
						</select> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色2：</td>
			<td class="TableData">
						<select name="Vcl_Role2" id="Vcl_Role2" style="min-width:100px" class="BigSelect"><option value="0"></option>
									<?php 
									echo($s_select);
									?>
						</select> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色3：</td>
			<td class="TableData">
						<select name="Vcl_Role3" id="Vcl_Role3" style="min-width:100px" class="BigSelect"><option value="0"></option>
									<?php 
									echo($s_select);
									?>
						</select> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色4：</td>
			<td class="TableData">
						<select name="Vcl_Role4" id="Vcl_Role4" style="min-width:100px" class="BigSelect"><option value="0"></option>
									<?php 
									echo($s_select);
									?>
						</select> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色5：</td>
			<td class="TableData">
						<select name="Vcl_Role5" id="Vcl_Role5" style="min-width:100px" class="BigSelect"><option value="0"></option>
									<?php 
									echo($s_select);
									?>
						</select> <span>（可选）</span>
			</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40">
			<input value="添加" class="BigButtonA"
				onclick="submitUserAdd()" type="button" /></td>
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
