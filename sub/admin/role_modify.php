<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 81 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
require_once 'include/it_showpage.class.php';
if (is_numeric ( $_GET ['roleid'] )) {
	$n_roleid = $_GET ['roleid'];
} else {
	echo ('<script type="text/javascript">location=\'role_list.php\'</script>');
	exit ( 0 );
}
$o_role = new Base_Role ( $n_roleid );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
</head>
<body class="bodycolor" style="padding-left: 15px; padding-right: 15px">
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="600" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/flow_edit.gif" align="absmiddle" /><span
				class="big3"> 编辑角色权限</span></td>
			<td style="text-align: right;"><input value="保存" class="BigButtonA"
				onclick="submitRoleModify(<?php echo($n_roleid)?>)" type="button" />&nbsp;&nbsp;<input value="返回" class="BigButtonA"
				onclick="history.go(-1)" type="button" /></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock" width="600"
	style="margin-top: 10px; margin-bottom: 10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">角色称名：</td>
			<td class="TableData"><input id="Vcl_Name" name="Vcl_Name" size="20"
				maxlength="20" class="BigInput"
				value="<?php
				echo ($o_role->getName ())?>" type="text" /></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">说明：</td>
			<td class="TableData"><input id="Vcl_Explain" name="Vcl_Explain"
				size="60" maxlength="50" class="BigInput"
				value="<?php
				echo ($o_role->getExplain ())?>" type="text" /></td>
		</tr>
	</tbody>
</table>
<table class="small" border="0" cellpadding="3" cellspacing="0">
	<tbody>
		<tr class="TableContent">
<?php
$o_module = new ShowPage ( $O_Session->getUserObject () );
echo ($o_module->getRoleModuleList ());
?>

            </tr>
	</tbody>
</table>
<br></br>
<div id="master_box"
	style="position: absolute; z-index: 2000; left: 0px; top: -500px;"></div>
<script type="text/javascript" language="javascript">
	S_Root='../../';
	<?php
	$o_right = new Base_Right ();
	$o_right->PushWhere ( array ('&&', 'RoleId', '=', $n_roleid ) );
	$n_count = $o_right->getAllCount ();
	for($i = 0; $i < $n_count; $i ++) {
		echo('document.getElementById(\'module_'.$o_right->getModuleId($i).'\').checked=true;');
	}
	?>
    </script>
</body>
</html>
