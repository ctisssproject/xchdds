<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 95 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_view.class.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
$o_user=new Base_User($O_Session->getUid());
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
				class="big3"> 发布文章</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="900"
	style="margin-top: 10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">一级栏目：</td>
			<td class="TableData"><select style="width: 200px" name="Vcl_Parent"
				id="Vcl_Parent" onchange="getColume2()" class="BigSelect">
				<?php
				$o_column = new Home_Column ();
				$o_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_column->PushWhere ( array ('&&', 'Parent', '=', 0 ) );
				$o_column->PushWhere ( array ('&&', 'Url', '=', '' ) );
				$o_column->PushOrder ( array ('Number', 'A' ) );
				$a_group=json_decode($o_user->getGroupId());
				for($i = 0; $i < $o_column->getAllCount (); $i ++) {
					if ($o_user->getGroupId()=='[]')
					{
						echo ('<option value="' . $o_column->getColumnId ( $i ) . '">' . $o_column->getName ( $i ) . '</option>');
					}else{
						if (in_array($o_column->getColumnId ( $i ), $a_group))
						{
							echo ('<option value="' . $o_column->getColumnId ( $i ) . '">' . $o_column->getName ( $i ) . '</option>');
						}
					}
				}
				?>
			</select></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">二级栏目：</td>
			<td class="TableData">
			<div id="column2"><select name="Vcl_ColumnId" id="Vcl_ColumnId"
				style="width: 200px" class="BigSelect">
				<option value=""></option>
			</select> （可选）</div>
			</td>
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
			<td class="TableData" nowrap="nowrap" width="120">文章标题：</td>
			<td class="TableData fuja"><input id="Vcl_Title" name="Vcl_Title"
				size="100" maxlength="50" class="BigInput" value="" type="text"
				style="font-size: 14px; height: 20px" /></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"
				style="vertical-align: top;">文章内容：</td>
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
			<td class="TableData" nowrap="nowrap" width="120">状态：</td>
			<td class="TableData"><select name="Vcl_State" id="Vcl_State"
				class="BigSelect">
				<option value="1" selected="selected">开放</option>
				<option value="0">关闭</option>
			</select></td>
		</tr>
		<tr style="display:none">
			<td class="TableData" nowrap="nowrap" width="120">审核人：</td>
			<td class="TableData"><select name="Vcl_AuditUid" id="Vcl_AuditUid"
				class="BigSelect">
				<option value="0" selected="selected"></option>
				<?php
				//生成有，等待审核模块的用户名
				require_once RELATIVITY_PATH . 'include/db_table.class.php';
				$o_list = new View_User_Right ();
				$o_list->PushWhere ( array ('&&', 'ModuleId', '=', 96 ) );
				$n_count = $o_list->getAllCount ();
				for($i = 0; $i < $n_count; $i ++) {
					$o_temp=new Base_User($o_list->getUid ( $i ));
					if ($o_temp->getState()==0)
					{
						continue;
					}
					echo ('<option value="' . $o_list->getUid ( $i ) . '">' . $o_list->getName ( $i ) . '</option>');
				}
				for($i = 1; $i <= 5; $i ++) {
					eval ( '$o_list = new View_User_Right_Sec' . $i . ' ();' );
					$o_list->PushWhere ( array ('&&', 'ModuleId', '=', 96 ) );
					$n_count = $o_list->getAllCount ();
					for($j = 0; $j < $n_count; $j ++) {
						$o_temp=new Base_User($o_list->getUid ( $j ));
						if ($o_temp->getState()==0)
						{
							continue;
						}
						echo ('<option value="' . $o_list->getUid ( $j ) . '">' . $o_list->getName ( $j ) . '</option>');
					}
				}
				?>
			</select></td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" style="padding: 10px"><textarea
				id="Vcl_Content" name="Vcl_Content" cols="1" rows="1"
				style="width: 1px; height: 1px; visibility: hidden"></textarea> <input
				value="发布" class="BigButtonA" onclick="addArticle()" type="button" />
			&nbsp;&nbsp; <input value="返回" class="BigButtonA"
				onclick="history.go(-1);" type="button" /></td>
		</tr>
	</tbody>
</table>
<br></br>
<input type="hidden" name="Vcl_GoBack" id="Vcl_GoBack" value="<?php 
if ($_GET['page']>=0)
{
	echo($_GET['page']);
}?>"/> 
</form>
<iframe id="ajax_submit_frame_affix" name="ajax_submit_frame_affix" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
	<div id="master_box" style="position: absolute; z-index: 2000; left: 0px; top: -500px;"></div>
	
<script type="text/javascript" language="javascript">
	S_Root='../../';
	getColume2();
	var editor = new UE.ui.Editor({ initialFrameWidth:762});
	editor.render("editor");
    </script>
</body>
</html>
