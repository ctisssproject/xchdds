<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 91 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
$o_user = new Base_User ($O_Session->getUid());
$o_user_info = new Base_User_Info ($O_Session->getUid());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/ajax.fun.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
</head>
<body class="bodycolor">
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=PasswordModify"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="600" align="center" style="margin-top:10px">
	<tbody>
		<tr>
			<td><img src="../../images/sms_type31.gif" align="absmiddle" /><span
				class="big3"> 修改登录密码</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="600" style="margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">用户名：</td>
			<td class="TableData">
			<?php echo($o_user->getUserName())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">真实姓名：</td>
			<td class="TableData">
			<?php echo($o_user_info->getName())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">原始密码：</td>
			<td class="TableData">
			<input id="Vcl_Password_Old" name="Vcl_Password_Old" size="21" maxlength="30" class="BigInput" value="" type="password"/>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">新密码：</td>
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
		<tr align="center">
			<td colspan="2" nowrap="nowrap" height="40" class="TableData" >
			<input value="修改密码" class="BigButtonB" onclick="passwordModifySubmit()" type="button" /></td>
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
