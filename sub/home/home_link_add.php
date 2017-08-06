<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 70);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_view.class.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="../../css/common.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css"
	href="../../theme/default/diary.css" />
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>
</head>
<body class="bodycolor">
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=AddLink"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
<table class="TableTop" width="600" align="center">
	<tbody>
		<tr>
			<td class="left"></td>
			<td class="center subject">添加友情链接</td>
			<td class="right"></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock no-top-border" align="center" width="600">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">名称：</td>
			<td class="TableData"><input id="Vcl_Name" name="Vcl_Name"
				size="20" maxlength="20" class="BigInput"
				value="" type="text" /></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">网址：</td>
			<td class="TableData"><input id="Vcl_Url" name="Vcl_Url"
				size="50" maxlength="100" class="BigInput"
				value="" type="text" /></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">显示顺序：</td>
			<td class="TableData"><select name="Vcl_Number" id="Vcl_Number"
				class="BigSelect">
				<?php
				$o_all = new Home_NewsFocus ();
				$o_all->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_all->PushOrder ( array ('Number', 'A' ) );
				$n_count = $o_all->getAllCount ();
				for($i = 0; $i < $n_count; $i ++) {
						echo ('<option value="' . ($i + 1) . '">' . ($i + 1) . '</option>');
				}
				echo ('<option value="' . ($i + 1) . '" selected="selected">' . ($i + 1) . '</option>');
				?>
			</select></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">状态：</td>
			<td class="TableData"><select name="Vcl_State" id="Vcl_State"
				class="BigSelect"><option value="1" selected="selected">启用</option>
				<option value="0">禁用</option>
			</select></td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap"><input value="添加" class="BigButtonA"
				onclick="modifyLink()" type="button" /> &nbsp;&nbsp; <input
				value="返回" class="BigButtonA" onclick="history.go(-1);"
				type="button" /></td>
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
