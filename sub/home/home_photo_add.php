<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 69);
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
	action="include/bn_submit.svr.php?function=AddPhoto"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
<table class="TableTop" width="800" align="center">
	<tbody>
		<tr>
			<td class="left"></td>
			<td class="center subject">添加图片</td>
			<td class="right"></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock no-top-border" align="center" width="800">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">图片标题：</td>
			<td class="TableData"><input id="Vcl_Text" name="Vcl_Text"
				size="70" maxlength="50" class="BigInput"
				value="" type="text" /></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">上传图片：</td>
			<td class="TableData"><input id="Vcl_File" name="Vcl_File"
				type="file" /><br/>注：格式为：jpg，bmp，png。</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap"><input value="添加" class="BigButtonA"
				onclick="addPhoto()" type="button" /> &nbsp;&nbsp; <input
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
