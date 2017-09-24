<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30010 );
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
	action="include/bn_submit.svr.php?function=AddArticle"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="900" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/notify_new.gif" align="absmiddle" /><span
				class="big3"> 发布信息</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="900"
	style="margin-top: 10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">标题：</td>
			<td class="TableData fuja"><input id="Vcl_Title" name="Vcl_Title"
				size="100" maxlength="50" class="BigInput" value="" type="text"
				style="font-size: 14px; height: 20px" /></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">发布日期：</td>
			<td class="TableData fuja"><input id="Vcl_Date" name="Vcl_Date"
				size="30" maxlength="50" class="BigInput" value="<?php 
				$o_date = new DateTime ( 'Asia/Chongqing' );
				echo ( $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) );
				//echo ( $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' ) );
			
				?>" type="text"
				style="font-size: 14px; height: 20px" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
				/></td>
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
			<td class="TableData" nowrap="nowrap" width="120">学校参加人员：</td>
			<td class="TableData fuja"><input id="Vcl_SchoolJoin" name="Vcl_SchoolJoin"
				size="100" maxlength="50" class="BigInput" value="" type="text"
				style="height: 20px" /></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120" style="vertical-align:top">督学参加人员：</td>
			<td class="TableData">
				<?php 
				$o_temp = new View_User_List ();
				$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) ); 
				$o_temp->PushWhere ( array ('&&', 'DeptId', '=', 138 ) ); 
				$o_temp->PushWhere ( array ('&&', 'Type', '=', 1 ) );
				$o_temp->PushOrder ( array ('Name', 'A' ) );
				$n_count=$o_temp->getAllCount();
				for($i=0;$i<$n_count;$i++)
				{
					echo('
				<div style="width:80px;float:left;padding-right:20px;">
					<input class="DuxueJoin" id="Vcl_DuxueJoin_'.$o_temp->getUid($i).'" name="Vcl_DuxueJoin_'.$o_temp->getUid($i).'" type="checkbox" style="float:left;margin-top:3px;cursor:pointer;"/><label for="Vcl_DuxueJoin_'.$o_temp->getUid($i).'" style="float:left;cursor:pointer;"> '.$o_temp->getName($i).'</label>
				</div>
					');
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">到校时间：</td>
			<td class="TableData fuja"><input id="Vcl_StartTime" name="Vcl_StartTime"
				size="30" maxlength="50" class="BigInput" value="" type="text"
				style="font-size: 14px; height: 20px" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
				/></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">离校时间：</td>
			<td class="TableData fuja"><input id="Vcl_EndTime" name="Vcl_EndTime"
				size="30" maxlength="50" class="BigInput" value="" type="text"
				style="font-size: 14px; height: 20px" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
				/></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">同时转其他处理：</td>
			<td class="TableData"><select name="Vcl_Transfer"
				id="Vcl_Transfer" class="BigSelect">
				<option value="0">否</option>
				<option value="1">是</option>
			</select></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"
				style="vertical-align: top;">内容纪要：</td>
			<td class="TableData"><script id="editor" type="text/plain"></script><?php
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
				rows="5" cols="100"></textarea></td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" style="padding: 10px"><textarea
				id="Vcl_Content" name="Vcl_Content" cols="1" rows="1"
				style="width: 1px; height: 1px; visibility: hidden"></textarea> <input
				value="发布" class="BigButtonA" onclick="addArticle()" type="button" />
			&nbsp;&nbsp; </td>
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
