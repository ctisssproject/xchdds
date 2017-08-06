<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 79 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
if (is_numeric ( $_GET ['uid'] )) {
	$n_uid = $_GET ['uid'];
} else {
	echo ('<script type="text/javascript">location=\'user_list.php\'</script>');
	exit (0);
}
$o_user = new Base_User ($n_uid);
$o_user_info = new Base_User_Info ($n_uid);
$o_user_info_custom = new Base_User_Info_Custom ($n_uid);
$o_user_role = new Base_User_Role ($n_uid);
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
<table class="TableBlock_Editor" align="center" width="600" style="margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>基本信息</strong></td>
		</tr>
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
		<?php 
		if ($o_user->getType()==0)
		{
			echo('
				<tr>
					<td class="TableData" nowrap="nowrap" width="120">绑定手机：</td>
					<td class="TableData">
					'.$o_user_info->getPhone().'
					</td>
				</tr>
			');
		}	
		?>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">默认邮箱：</td>
			<td class="TableData">
			<?php echo($o_user_info->getEmail())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">状态：</td>
			<td class="TableData">
			<?php 
			if ($o_user->getState () == 1) {
				$s_state = '<span style="color:#42B475">启用</span>';
			} else {
				$s_state = '<span style="color:red">停用</span>';
			}
			echo ($s_state);
			?>
		</td>
		</tr>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>个人信息</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">出生日期：</td>
			<td class="TableData">
				<?php echo($o_user_info_custom->getBirthday())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">手机：</td>
			<td class="TableData">
			<?php echo($o_user_info_custom->getMobilePhone())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">座机：</td>
			<td class="TableData">
			<?php echo($o_user_info_custom->getPhone())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">其他邮箱：</td>
			<td class="TableData">
			<?php echo($o_user_info_custom->getEmail())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">QQ：</td>
			<td class="TableData">
			<?php echo($o_user_info_custom->getQQ())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>所属部门</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">部门：</td>
			<td class="TableData">
			<?php 
			$o_dept=new Single_User($n_uid);
			echo($o_dept->getDeptNameForStr());
			?>
			</td>
		</tr>
		<tr>
		<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>用户角色</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">主角色：</td>
			<td class="TableData">
			<?php 
			$o_role=new Base_Role($o_user_role->getRoleId());
			echo($o_role->getName());
			?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色1：</td>
			<td class="TableData">
			<?php 
			$o_role=new Base_Role($o_user_role->getSecRoleId1());
			echo($o_role->getName());
			?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色2：</td>
			<td class="TableData">
			<?php 
			$o_role=new Base_Role($o_user_role->getSecRoleId2());
			echo($o_role->getName());
			?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色3：</td>
			<td class="TableData">
			<?php 
			$o_role=new Base_Role($o_user_role->getSecRoleId3());
			echo($o_role->getName());
			?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色4：</td>
			<td class="TableData">
			<?php 
			$o_role=new Base_Role($o_user_role->getSecRoleId4());
			echo($o_role->getName());
			?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色5：</td>
			<td class="TableData">
			<?php 
			$o_role=new Base_Role($o_user_role->getSecRoleId5());
			echo($o_role->getName());
			?>
			</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40">
			<input value="返回" class="BigButtonA"
				onclick="history.go(-1)" type="button" /></td>
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
