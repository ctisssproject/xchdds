<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30007 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
if (is_numeric ( $_GET ['id'] ) && $_GET ['id'] > 0) {
	$n_articleid = $_GET ['id'];
} else {
	exit ( 0 );
}
$o_article = new Jiaoliu_Article ( $n_articleid );
if ($o_article->getTitle () == false || $o_article->getUid ()!=$O_Session->getUid() || $o_article->getDelete ()==1) {
	exit ( 0 );
}
function AilterTextArea($s_text) {
    $s_content = $s_text;
    $s_content = str_replace ( "<br/>", "\n", $s_content );
    $s_content = str_replace ( '&nbsp;', ' ', $s_content );
    return $s_content;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>

<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<script type="text/javascript" src="js/function.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" href="../../module/DatePicker/skin/WdatePicker.css"/>
        <script type="text/javascript" src="../../module/DatePicker/WdatePicker.js"></script>
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
	action="include/bn_submit.svr.php?function=ModifyArticle"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
	<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
	<input id="Vcl_ArticleId" name="Vcl_ArticleId" size="1" maxlength="50"
				class="BigInput"
				value="<?php
				echo ($o_article->getId ()); 
				?>"
				type="text" style="font-size: 14px; height: 20px; display: none" />
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="900" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/notify_new.gif" align="absmiddle" /><span
				class="big3"> 修改文章</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="900"
	style="margin-top: 10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">标题：</td>
			<td class="TableData fuja"><input id="Vcl_Title" name="Vcl_Title"
				size="100" maxlength="50" class="BigInput" value="<?php
				echo ($o_article->getTitle ());
				?>" type="text"
				style="font-size: 14px; height: 20px" /></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">发布日期：</td>
			<td class="TableData fuja"><input id="Vcl_Date" name="Vcl_Date"
				size="30" maxlength="50" class="BigInput" value="<?php
				echo ($o_article->getDate ());
				?>" type="text"
				style="font-size: 14px; height: 20px" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
				/></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">学校参加人员：</td>
			<td class="TableData fuja"><input id="Vcl_SchoolJoin" name="Vcl_SchoolJoin"
				size="100" maxlength="50" class="BigInput" value="<?php
				echo ($o_article->getSchoolJoin ());
				?>" type="text"
				style="height: 20px" /></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">督学参加人员：</td>
			<td class="TableData fuja"><input id="Vcl_DuxueJoin" name="Vcl_DuxueJoin"
				size="100" maxlength="50" class="BigInput" value="<?php
				echo ($o_article->getDuxueJoin ());
				?>" type="text"
				style="height: 20px" /></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">到校时间：</td>
			<td class="TableData fuja"><input id="Vcl_StartTime" name="Vcl_StartTime"
				size="30" maxlength="50" class="BigInput" value="<?php
				echo ($o_article->getStartTime ());
				?>" type="text"
				style="font-size: 14px; height: 20px" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
				/></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">离校时间：</td>
			<td class="TableData fuja"><input id="Vcl_EndTime" name="Vcl_EndTime"
				size="30" maxlength="50" class="BigInput" value="<?php
				echo ($o_article->getEndTime ());
				?>" type="text"
				style="font-size: 14px; height: 20px" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
				/></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">同时其他处理：</td>
			<td class="TableData"><select name="Vcl_Transfer"
				id="Vcl_Transfer" class="BigSelect">
				<option value="0">否</option>
				<option value="1">是</option>
			</select></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"
				style="vertical-align: top;">内容：</td>
			<td class="TableData"><script id="editor" type="text/plain"><?php echo($o_article->getContent ())?></script><?php
			/*require_once RELATIVITY_PATH . 'include/it_editor.class.php';
			$o_editor = new Editor ();
			$o_editor->setHeight ( '450' );
			$o_editor->setEnable ( true );
			$o_editor->setUid ( $O_Session->getUid () );
			//$o_editor->setContent ();
			$o_editor->setRoot ( RELATIVITY_PATH );
			$o_editor->setAllowUpload ( true );
			$o_editor->setUserObject ( $O_Session->getUserObject () );
			$s_html .= $o_editor->getEditor ();
			echo ($s_html);*/
			?></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"
				style="vertical-align: top;">意见建议：</td>
			<td class="TableData"><textarea class="BigInput" style="" name="Vcl_Feedback" id="Vcl_Feedback"
				rows="5" cols="100"><?php
				echo (AilterTextArea($o_article->getFeedback ()));
				?></textarea></td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" style="padding: 10px"><textarea
				id="Vcl_Content" name="Vcl_Content" cols="1" rows="1"
				style="width: 1px; height: 1px; visibility: hidden"></textarea> <input
				value="提交" class="BigButtonA" onclick="addArticle()" type="button" />
			&nbsp;&nbsp;<input value="返回" class="BigButtonA"
				onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>';" type="button" /></td>
		</tr>
	</tbody>
</table>
<br></br>

</form>
<iframe id="ajax_submit_frame_affix" name="ajax_submit_frame_affix" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
	<div id="master_box" style="position: absolute; z-index: 2000; left: 0px; top: -500px;"></div>
	
<script type="text/javascript" language="javascript">
	S_Root='../../';
	var editor = new UE.ui.Editor({ initialFrameWidth:762});
	editor.render("editor");
    </script>
</body>
</html>
