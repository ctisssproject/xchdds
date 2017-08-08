<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 67);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_view.class.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
if (is_numeric ( $_GET ['focusid'] )) {
	$n_columnid = $_GET ['focusid'];
	if ($n_columnid > 0) {
		$n_columnid = $_GET ['focusid'];
	} else {
		echo ('<script>location=\'home_focusphoto.php\'</script>');
		exit ( 0 );
	}
} else {
	echo ('<script>location=\'home_focusphoto.php\'</script>');
	exit ( 0 );
}
$o_focus = new Home_NewsFocus ( $n_columnid );

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
	action="include/bn_submit.svr.php?function=ModifyFocus"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
<table class="TableTop" width="800" align="center">
	<tbody>
		<tr>
			<td class="left"></td>
			<td class="center subject">修改首页焦点图片</td>
			<td class="right"></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock no-top-border" align="center" width="800">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">连接的文章编号：</td>
			<td class="TableData"><input id="Vcl_ArticleId" name="Vcl_ArticleId"
				size="20" maxlength="20" class="BigInput"
				value="<?php
				echo ($o_focus->getArticleId ())?>" type="text" /><input
				id="Vcl_FocusId" name="Vcl_FocusId" size="20" maxlength="20"
				class="BigInput" value="<?php
				echo ($o_focus->getFocusId ())?>"
				type="text" style="display: none" /></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">显示标题：</td>
			<td class="TableData"><input id="Vcl_Title" name="Vcl_Title"
				size="70" maxlength="50" class="BigInput"
				value="<?php
				echo ($o_focus->getTitle ())?>" type="text" /></td>
		</tr>		
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"
				style="vertical-align: top;">原图片：</td>
			<td class="TableData"><img
				src="<?php
				echo ($o_focus->getPhoto ())?>" alt="" width="523"
				height="330" /></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">上传新图片：</td>
			<td class="TableData"><input id="Vcl_File" name="Vcl_File"
				type="file" />&nbsp;&nbsp;如不需要修改可以不选。<br/>注：图片最佳尺寸：高：300像素，宽：300像素，格式为：jpg，bmp，png。</td>
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
					if (($i + 1) == $o_focus->getNumber ()) {
						echo ('<option value="' . ($i + 1) . '" selected="selected">' . ($i + 1) . '</option>');
					} else {
						echo ('<option value="' . ($i + 1) . '">' . ($i + 1) . '</option>');
					}
				}
				?>
			</select></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">状态：</td>
			<td class="TableData"><select name="Vcl_State" id="Vcl_State"
				class="BigSelect">
				<?php
				if ($o_focus->getState () == 1) {
					echo ('<option value="1" selected="selected">启用</option>
				<option value="0">禁用</option>');
				} else {
					echo ('<option value="1">启用</option>
				<option value="0" selected="selected">禁用</option>');
				}
				?>
			</select></td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap"><input value="保存" class="BigButtonA"
				onclick="modifyFocus()" type="button" /> &nbsp;&nbsp; <input
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
