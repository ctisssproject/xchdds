<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 731 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_view.class.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
if (is_numeric ( $_GET ['articleid'] ) && $_GET ['articleid'] > 0) {
	$n_articleid = $_GET ['articleid'];
} else {
	echo ('<script>location=\'article_audit.php\'</script>');
	exit ( 0 );
}
$o_article = new Home_Messages($n_articleid );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>

<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<link href="css/style.css" rel="stylesheet"
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
	action="include/bn_submit.svr.php?function=MessagesAudit"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="900" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/notify_new.gif" align="absmiddle" /><span
				class="big3"> 留言审核</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="900"
	style="margin-top: 10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">标题：</td>
			<td class="TableData" align="center" style="font-size:16px;font-weight:bold">
				<?php
				echo($o_article->getTitle ());				
				?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">日期：</td>
			<td class="TableData">
			<?php
				echo($o_article->getDate ());				
				?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">留言人：</td>
			<td class="TableData fuja"><?php
				echo ($o_article->getUid ());
				?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"
				style="vertical-align: top;">留言内容：</td>
			<td class="TableData"><?php
			echo($o_article->getContent () );
			?></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap">回复：</td>
			<td class="TableData"><script id="editor" type="text/plain"></script>

                </td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" style="padding: 10px">
			<textarea id="Vcl_Content"
				name="Vcl_Content" cols="1" rows="1"
				style="width: 1px; height: 1px; visibility: hidden"></textarea>
				<input
				id="Vcl_ArticleId" name="Vcl_ArticleId" size="1" maxlength="50"
				class="BigInput"
				value="<?php
				echo ($o_article->getArticleId ());
				?>"
				type="text" style="font-size: 14px; height: 20px; display: none" />
			<input value="提交" class="BigButtonB" onclick="messagesAudit(<?php echo($o_article->getArticleId ())?>)" type="button" />
			&nbsp;&nbsp;&nbsp;&nbsp;<input value="返回" class="BigButtonA"
				onclick="location='messages.php';" type="button" /></td>
		</tr>
	</tbody>
</table>
</form>
<br></br>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<script type="text/javascript" language="javascript">
	S_Root='../../';
	var editor = new UE.ui.Editor({ initialFrameWidth:762});
	editor.render("editor");
    </script>
<div id="master_box"
	style="position: absolute; z-index: 2000; left: 0px; top: -500px;">
</div>
</body>
</html>
