<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 68);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_view.class.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
if (is_numeric ( $_GET ['indexcolumnid'] )&& $_GET ['indexcolumnid']>0) {
	$n_columnid = $_GET ['indexcolumnid'];
} else {
	echo ('<script>location=\'home_column.php\'</script>');
	exit ( 0 );
}
$o_column=new Home_Indexcolumn($n_columnid);
$a=$o_column->getColumnId();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css"
	href="../../theme/default/diary.css" />
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>
</head>
<body class="bodycolor">
<br />
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=ModifyIndexColumn"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
<table class="TableTop" width="400" align="center">
	<tbody>
		<tr>
			<td class="left"></td>
			<td class="center subject">修改首页显示的栏目</td>
			<td class="right"></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock no-top-border" align="center" width="400">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">栏目编号：</td>
			<td class="TableData"><input id="Vcl_ColumnId" name="Vcl_ColumnId"
				size="20" maxlength="20" class="BigInput"
				value="<?php echo($o_column->getColumnId())?>" type="text" />
				<input id="Vcl_IndexcolumnId" name="Vcl_IndexcolumnId"
				size="20" maxlength="20" class="BigInput"
				value="<?php echo($o_column->getIndexcolumnId())?>" type="text" style="display:none"/>
				</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap"><input value="保存"
				class="BigButtonA" onclick="indexcolumnSubmit()" type="button" />
			&nbsp;&nbsp; <input value="返回" class="BigButtonA"
				onclick="history.go(-1);" type="button" /></td>
		</tr>
	</tbody>
</table>
</form>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<script type="text/javascript" language="javascript">
	S_Root='../../';
    </script>
</body>
</html>
