<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 31003 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);
$o_survey=new Zhdd_Appraise($_GET['id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<link href="../../css/common.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/common.fun.js"></script>
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/ajax_post.class.js"></script>
	<script type="text/javascript" src="../../js/ajax.class.js"></script>
	<script type="text/javascript" src="../../js/dialog.fun.js"></script>
	<script type="text/javascript" src="js/function.js"></script>
</head>
<body class="bodycolor" topmargin="0" style="padding-left:10px;padding-right:10px;padding-top:10px;color:#333333">
<form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame" enctype="multipart/form-data">
<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
<input type="hidden" name="Vcl_BackUrl" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>appraise_manage.php"/>
<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
<input type="hidden" name="Vcl_FunName" value="AppraiseMakeQrcode"/>
<table class="small" border="0" cellpadding="3" cellspacing="0"
	style="margin-left:auto;margin-right:auto;min-width:450px;" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/edit.gif" align="absmiddle" /><span
				class="big3"> 制作评价二维码</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" style="margin-left:auto;margin-right:auto;max-width:600px;margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"><span style="color:red">*</span> 学校名称：</td>
			<td class="TableData">
				<ul class="alt" id="alt1">
				</ul><input id="Vcl_SchoolName" style="width:200px;"
				name="Vcl_SchoolName" size="80" maxlength="100" class="BigInput"
				value="" type="text" onkeyup="altGet('AltGetSchool','alt1',this)" onblur="altClose()"/>
				 <span class="red" style="color:red">必须从提示中选择</span> 
			</td>
		</tr>
		<?php 
		$a_vcl=json_decode($o_survey->getInfo());
	    for($i=0;$i<count($a_vcl);$i++)
	    {
	    	?>
	    	<tr>
				<td class="TableData" nowrap="nowrap" width="120"><?php echo(rawurldecode($a_vcl[$i]))?>：</td>
				<td class="TableData"><input name="Vcl_Info_<?php echo($i)?>"
					class="BigInput" style="width:300px;" size="16" maxlength="30" type="text" value=""/>
					</td>
			</tr>
	    	<?php
	    }
		?>
		
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" height="40"><input value="提交" class="BigButtonA"
				onclick="appraise_manage_add_submit()" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input value="返回" class="BigButtonA" onclick="location='<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>appraise_manage.php'" type="button" />
				</td>
		</tr>
		
</tbody>
</table>
</form>
<iframe id="submit_form_frame" name="submit_form_frame" style="display:none" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<script type="text/javascript" language="javascript">
	S_Root='../../';
	parent.parent.parent.Common_CloseDialog();	
    </script>
</body>
</html>
