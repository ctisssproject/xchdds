<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30025 );
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
	action="include/bn_submit.svr.php?function=AddDc"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
	<input type="hidden" name="Vcl_BackUrl" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']).'gpdd_dc_task.php')?>"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="900" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/notify_new.gif" align="absmiddle" /><span
				class="big3"> 发起督查</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="900"
	style="margin-top: 10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">日期：</td>
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
			<td class="TableData" nowrap="nowrap" width="120">标题：</td>
			<td class="TableData fuja"><input id="Vcl_Title" name="Vcl_Title"
				size="100" maxlength="50" class="BigInput" value="" type="text"
				style="font-size: 14px; height: 20px" /></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120" style="vertical-align:top">督查组（分组）：</td>
			<td class="TableData">
			<?php 
				$o_temp=new Base_Group();
				$o_temp->PushWhere ( array ('&&', 'Type', '=', 'User' ) );
				$o_temp->PushOrder ( array ('Name', 'A' ) );
				$n_count=$o_temp->getAllCount();
				for($i=0;$i<$n_count;$i++)
				{
					echo('
				<div style="width:150px;float:left;padding-right:20px;">
					<input id="Vcl_Group_'.$o_temp->getId($i).'" name="Vcl_Group_'.$o_temp->getId($i).'" type="checkbox" style="float:left;margin-top:3px;cursor:pointer;"/><label for="Vcl_Group_'.$o_temp->getId($i).'" style="float:left;cursor:pointer;"> '.$o_temp->getName($i).'</label>
				</div>
					');
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120" style="vertical-align:top">督查组（督学）：</td>
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
					<input id="Vcl_User_'.$o_temp->getUid($i).'" name="Vcl_User_'.$o_temp->getUid($i).'" type="checkbox" style="float:left;margin-top:3px;cursor:pointer;"/><label for="Vcl_User_'.$o_temp->getUid($i).'" style="float:left;cursor:pointer;"> '.$o_temp->getName($i).'</label>
				</div>
					');
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120" style="vertical-align:top">督查对象（分组）：</td>
			<td class="TableData">
			<?php 
				$o_temp=new Base_Group();
				$o_temp->PushWhere ( array ('&&', 'Type', '=', 'Dept' ) );
				$o_temp->PushOrder ( array ('Name', 'A' ) );
				$n_count=$o_temp->getAllCount();
				for($i=0;$i<$n_count;$i++)
				{
					echo('
				<div style="width:150px;float:left;padding-right:20px;">
					<input id="Vcl_Group_'.$o_temp->getId($i).'" name="Vcl_Group_'.$o_temp->getId($i).'" type="checkbox" style="float:left;margin-top:3px;cursor:pointer;"/><label for="Vcl_Group_'.$o_temp->getId($i).'" style="float:left;cursor:pointer;"> '.$o_temp->getName($i).'</label>
				</div>
					');
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120" style="vertical-align:top">督查对象（学校）：</td>
			<td class="TableData">
				<?php 
				$o_temp=new Base_Dept();
				$o_temp->PushWhere ( array ('&&', 'ParentId', '=', 1 ) );
				$o_temp->PushOrder ( array ('Name', 'A' ) );
				$n_count=$o_temp->getAllCount();
				for($i=0;$i<$n_count;$i++)
				{
					echo('
				<div style="width:230px;float:left;padding-right:20px;">
					<input id="Vcl_Dept_'.$o_temp->getDeptId($i).'" name="Vcl_Dept_'.$o_temp->getDeptId($i).'" type="checkbox" style="float:left;margin-top:3px;cursor:pointer;"/><label for="Vcl_Dept_'.$o_temp->getDeptId($i).'" style="float:left;cursor:pointer;"> '.$o_temp->getName($i).'</label>
				</div>
					');
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"
				style="vertical-align: top;">督查内容：</td>
			<td class="TableData"><script id="editor" type="text/plain"><p style="font-family:宋体;font-size:12px;"></p></script></td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" style="padding: 10px"><textarea
				id="Vcl_Content" name="Vcl_Content" cols="1" rows="1"
				style="width: 1px; height: 1px; visibility: hidden"></textarea> <input
				value="发起" class="BigButtonA" onclick="add_zc()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="返回" class="BigButtonA" onclick="location='gpdd_zc_task.php'" type="button" /></td>
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
