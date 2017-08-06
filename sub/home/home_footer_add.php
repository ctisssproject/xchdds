<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 71 );
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
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript">
var S_Root='../../';
</script>
<script type="text/javascript" charset="utf-8"
	src="../editor/editor_config.js"></script>
<script type="text/javascript" charset="utf-8"
	src="../editor/editor_api.js"></script>
</head>
<body class="bodycolor">
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=AddFooter"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="900" align="center" style="margin-top:10px">
	<tbody>
		<tr>
			<td><img src="../../images/notify_new.gif" align="absmiddle" /><span
				class="big3"> 添加底部文章</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="900" style="margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">标题：</td>
			<td class="TableData"><input id="Vcl_Title" name="Vcl_Title"
				size="70" maxlength="50" class="BigInput" value="" type="text" style="font-size:14px; height:20px"/><input
				id="Vcl_ArticleId" name="Vcl_ArticleId" size="20" maxlength="20"
				class="BigInput" value="" type="text" style="display: none" /></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"
				style="vertical-align: top;">文章内容：</td>
			<td class="TableData"><script id="editor" type="text/plain"></script><textarea class="BigInput" style=""
				name="Vcl_Content" id="Vcl_Content" rows="7" cols="70" style="display: none"></textarea></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">显示顺序：</td>
			<td class="TableData"><select name="Vcl_Number" id="Vcl_Number"
				class="BigSelect">
				<?php
				$o_all = new Home_Article_Footer ();
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
				onclick="modifyFooter()" type="button" /> &nbsp;&nbsp; <input
				value="返回" class="BigButtonA" onclick="location='home_footer.php'"
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
	var editor = new UE.ui.Editor({ initialFrameWidth:762});
	editor.render("editor");
    </script>
</body>
</html>
