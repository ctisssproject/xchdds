<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30012 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>

<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="js/function.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
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
	action="include/bn_submit.svr.php?function=AddArticle"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
	<input type="hidden" name="Vcl_BackUrl" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']).'from.php')?>"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="900" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/notify_new.gif" align="absmiddle" /><span
				class="big3"> 发起问题</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="900"
	style="margin-top: 10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">来源：</td>
			<td class="TableData fuja"><input id="Vcl_From" name="Vcl_From" class="BigInput" value="" type="text"/></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">学校名称：</td>
			<td class="TableData"><select name="Vcl_SchoolId" id="Vcl_SchoolId" class="BigSelect">
				<option value=""></option>
				<?php 
				$o_school=new Base_Dept();
				$o_school->PushWhere ( array ('&&', 'Uid', '=', $O_Session->getUid()) );
				$n_count = $o_school->getAllCount ();
				for($i=0;$i<$n_count;$i++)
				{
					echo('<option value="'.$o_school->getDeptId($i).'">'.$o_school->getName($i).'</option>');
				}
				?>
			</select></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">问题类别：</td>
			<td class="TableData" colspan="3">
					<?php 
					require_once RELATIVITY_PATH.'sub/telephone/include/db_table.class.php';
					$o_type=new Telephone_Type();
					$o_type->PushOrder ( array ('Id', 'A' ) );
					$n_count=$o_type->getAllCount();
					for($i=0;$i<$n_count;$i++)
					{
						if ($o_type->getId($i)==9)
						{
							echo('<div style="float:left;width:300px;"><input style="margin-top:3px" class="checkbox" name="Vcl_Type' . $o_type->getId($i) . '" id="Vcl_Type' . $o_type->getId($i) . '" type="checkbox"/> '.$o_type->getName($i).'：<input style="margin-top:3px" class="BigInput" name="Vcl_Type_Other" id="Vcl_Type_Other" type="text"/></div>');
						}else{
							echo('<div style="float:left;width:300px;"><input style="margin-top:3px" class="checkbox" name="Vcl_Type' . $o_type->getId($i) . '" id="Vcl_Type' . $o_type->getId($i) . '" type="checkbox"/> '.$o_type->getName($i).'</div>');
						}
					}
					?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"
				style="vertical-align: top;">问题内容：</td>
			<td class="TableData"><script id="editor" type="text/plain"><p style="font-family:宋体;font-size:12px;"></p></script><?php
			/*require_once RELATIVITY_PATH . 'include/it_editor.class.php';
			$o_editor = new Editor ();
			$o_editor->setHeight ( '450' );
			$o_editor->setEnable ( true );
			$o_editor->setUid ( $O_Session->getUid () );liguangjian
			//$o_editor->setContent ();
			$o_editor->setRoot ( RELATIVITY_PATH );
			$o_editor->setAllowUpload ( true );
			$o_editor->setUserObject ( $O_Session->getUserObject () );
			$s_html .= $o_editor->getEditor ();
			echo ($s_html);*/
			?></td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" style="padding: 10px"><textarea
				id="Vcl_Content" name="Vcl_Content" cols="1" rows="1"
				style="width: 1px; height: 1px; visibility: hidden"></textarea> <input
				value="发起" class="BigButtonA" onclick="addArticle()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="返回" class="BigButtonA" onclick="location='from.php'" type="button" /></td>
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
