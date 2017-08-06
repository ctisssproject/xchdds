<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30001 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />
<link href="../../images/org/ui.dynatree.css" rel="stylesheet"
	type="text/css" />
<link href="../../theme/default/layout_left.css" rel="stylesheet"
	type="text/css" />
<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" href="../../module/DatePicker/skin/WdatePicker.css" />
<script type="text/javascript" src="../../module/DatePicker/WdatePicker.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
</head>
<body class="bodycolor">
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=RecordAdd"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="800" align="center" style="margin-top:10px"> 
	<tbody>
		<tr>
			<td><img src="../../images/notify_new.gif" align="absmiddle" /><span
				class="big3"> 添加记录</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="800" style="margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" colspan="4" nowrap="nowrap" style="font-size:14px" align="center"><strong>基本信息</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">日期：</td>
			<td class="TableData">
			<input id="Vcl_RecordDate" name="Vcl_RecordDate" size="20" maxlength="20" class="BigInput" value="" readonly="readonly" type="text" onclick="WdatePicker()"/> <span class="red">*</span>
			</td>
			<td class="TableData" nowrap="nowrap" width="60">时间：</td>
			<td class="TableData">
			<input id="Vcl_RecordTime" name="Vcl_RecordTime" size="20" maxlength="20" class="BigInput" value="" readonly="readonly" type="text" onclick="WdatePicker({dateFmt:'HH:mm'})"/> <span class="red">*</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" colspan="4" nowrap="nowrap" style="font-size:14px" align="center"><strong>来电人信息</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">姓名：</td>
			<td class="TableData">
			<input id="Vcl_Name" name="Vcl_Name" size="20" maxlength="20" class="BigInput" value="" type="text"/> <span class="red">*</span> <input class="checkbox" type="checkbox" onclick="niming(this)"/>&nbsp;匿名
			</td>
			<td class="TableData" nowrap="nowrap">性别：</td>
			<td class="TableData">
				<select name="Vcl_Sex" id="Vcl_Sex"class="BigSelect">
					<option value="男" selected="selected">男</option>
					<option value="女">女</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">来源学校：</td>
			<td class="TableData" width="400">
			<ul class="alt" id="alt1">
			</ul><input id="Vcl_SchoolName" style="width:200px;"
				name="Vcl_SchoolName" size="80" maxlength="100" class="BigInput"
				value="" type="text" onkeyup="altGet('AltGetSchool','alt1',this)" onblur="altClose()"/>
				 <span class="red">* 必须从提示中选择</span>  <input class="checkbox" type="checkbox" onclick="xinsheng(this)"/>&nbsp;新生
			</td>
			<td class="TableData" nowrap="nowrap">身份：</td>
			<td class="TableData">
				<select name="Vcl_ProfileId" id="Vcl_ProfileId" class="BigSelect">
				<option value=""></option>
					<?php 
					$o_profile=new Telephone_Profile();
					$o_profile->PushOrder ( array ('Name', 'D' ) );
					$n_count=$o_profile->getAllCount();
					for($i=0;$i<$n_count;$i++)
					{
						echo('<option value="'.$o_profile->getId($i).'">'.$o_profile->getName($i).'</option>');
					}
					?>
				</select> <span class="red">*</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">电话（邮箱）：</td>
			<td class="TableData" colspan="3">
			<input id="Vcl_Phone" name="Vcl_Phone" size="20" maxlength="20" class="BigInput" value="" type="text"/>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">反映问题类别：</td>
			<td class="TableData" colspan="3">
					<?php 
					$o_type=new Telephone_Type();
					$o_type->PushOrder ( array ('Id', 'A' ) );
					$n_count=$o_type->getAllCount();
					for($i=0;$i<$n_count;$i++)
					{
						echo('<div style="float:left;width:250px;"><input style="margin-top:3px" class="checkbox" name="Vcl_Type' . $o_type->getId($i) . '" id="Vcl_Type' . $o_type->getId($i) . '" type="checkbox"/> '.$o_type->getName($i).'</div>');
					}
					?>
			</td>
		</tr>
		<tr>
			<td class="TableData" colspan="4" nowrap="nowrap" style="font-size:14px" align="center"><strong>记录内容</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">记录：</td>
			<td class="TableData" colspan="3"><textarea class="BigInput" style="" name="Vcl_Content" id="Vcl_Content" rows="10" cols="50"></textarea> <span class="red">*</span></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">处理类型：</td>
			<td class="TableData" colspan="3"><div id="type_list"><select name="Vcl_SendType" id="Vcl_SendType" class="BigSelect" onchange="change_sendtype(this)">
					<option value="1" selected="selected">自行处理</option>
					<option value="2">转责任督学</option>
					<option value="3">转其他处理</option>
				</select></div></td>
		</tr>
		<tr id="result">
			<td class="TableData" nowrap="nowrap" width="120">处理过程及结果：</td>
			<td class="TableData" colspan="3">
			时间：<input id="Vcl_HandleDate" name="Vcl_HandleDate" size="20" maxlength="20" class="BigInput" value="<?php 
			$o_date = new DateTime ( 'Asia/Chongqing' );
			//echo($o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ));
			?>" readonly="readonly" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"/> <span class="red">*</span><br/>
			<textarea class="BigInput" style="" name="Vcl_Progress" id="Vcl_Progress"
				rows="3" cols="50"></textarea> <span class="red">*</span></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">备注：</td>
			<td class="TableData" colspan="3"><textarea class="BigInput" style="" name="Vcl_Explain" id="Vcl_Explain"
				rows="3" cols="50"></textarea></td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="4" nowrap="nowrap" height="40">
			<input value="添加" class="BigButtonA"
				onclick="submitRecordAdd()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;<input value="取消" class="BigButtonA"
				onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'" type="button" /></td>
		</tr>
	</tbody>
</table>
<br></br>
</form>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0" height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<script type="text/javascript" language="javascript">
	S_Root='../../';
    </script>
</body>
</html>
