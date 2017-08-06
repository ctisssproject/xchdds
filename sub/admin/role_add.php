<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID',81 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
require_once 'include/it_showpage.class.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
</head>
<body class="bodycolor" style="padding-left:15px;padding-right:15px">
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="600" style="margin-top:10px">
	<tbody>
		<tr>
			<td><img src="../../images/notify_new.gif" align="absmiddle" /><span
				class="big3"> 添加角色</span>
			</td>
			<td style="text-align:right;">
			<input value="添加" class="BigButtonA"
				onclick="submitRoleAdd()" type="button" />
			</td>
		</tr>
	</tbody>
</table>
<table class="TableBlock" width="600" style="margin-top:10px;margin-bottom:10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">角色称名：</td>
			<td class="TableData">
			<input id="Vcl_Name" name="Vcl_Name" size="20" maxlength="20" class="BigInput" value="" type="text"/>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">说明：</td>
			<td class="TableData">
			<input id="Vcl_Explain" name="Vcl_Explain" size="60" maxlength="50" class="BigInput" value="" type="text"/>
			</td>
		</tr>
	</tbody>
</table>
<table class="small" border="0" cellpadding="3" cellspacing="0">
        <tbody>
            <tr class="TableContent">
<?php
$o_module = new ShowPage ( $O_Session->getUserObject ());
echo ($o_module->getRoleModuleList());
?>

            </tr>
        </tbody>
    </table>
<br></br>
<div id="master_box"
	style="position: absolute; z-index: 2000; left: 0px; top: -500px;">
</div>
<script type="text/javascript" language="javascript">
	S_Root='../../';
    </script>
</body>
</html>
