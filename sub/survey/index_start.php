<?php
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
define ( 'RELATIVITY_PATH', '../../' );
require_once 'include/db_table.class.php';
if (isset($_GET['id'])&& $_GET['id']>0)
{
	if ($_GET['bu']==1)
	{
		$o_total=new SurveyTotalItem($_GET['id']);
		$o_subject=new SurveySubject($o_total->getSubjectId()); 
		$_GET['id']=$o_total->getSubjectId();
	}else{
		$o_subject=new SurveySubject($_GET['id']); 
	}
}else{
	echo ('<script>location=\'index.php\'</script>');
}
$o_item=new SurveyItem();
$o_item->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
$o_item->PushWhere ( array ('&&', 'SubjectId', '=', $o_subject->getId() ) );
$o_item->PushOrder ( array ('Number', 'A' ) );
$n_count=$o_item->getAllCount();

if ($o_item->getTypeId(0)==3)
{
	if ($_GET['bu']==1)
	{
		echo ('<script>location=\'index_start_score.php?bu=1&id='.$o_total->getId().'\'</script>');
	}else{
		echo ('<script>location=\'index_start_score.php?id='.$o_subject->getId().'&already='.$_GET['already'].'\'</script>');
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>西城区素质教育评价</title>
<link href="css/page.css" type="text/css" rel="stylesheet" />
<script type="text/javascript"
	src="<?php echo (RELATIVITY_PATH)?>js/jquery/jquery.min.js"></script>
<script type="text/javascript"
	src="<?php echo (RELATIVITY_PATH)?>js/common.fun.js"></script>
<script type="text/javascript"
	src="<?php echo (RELATIVITY_PATH)?>js/ajax_post.class.js"></script>
<script type="text/javascript" src="js/function.js"></script>
</head>
<body>
<form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame" enctype="multipart/form-data">
<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
<input type="hidden" name="Ajax_FunName" value="SurveySubmit"/>
<?php 
	if ($_GET['bu']==1)
	{
		?>
		<input type="hidden" name="Vcl_Bu" value="<?php echo($_GET['bu'])?>"/>
		<input type="hidden" name="Vcl_Type" value="<?php echo($o_total->getType())?>"/>
		<input type="hidden" name="Vcl_DeptId" value="<?php echo($o_total->getDeptId())?>"/>
		<?php
	}
?>
<input type="hidden" name="Vcl_Already" value="<?php echo(rawurlencode($_GET['already']))?>"/>
<input type="hidden" name="Vcl_Code" value="<?php echo(rawurlencode($_GET['code']))?>"/>
<div class="container" align="left" style="padding: 50px;">
<div class="top">
<div class="title" style="text-align: center; margin-left: 0px;">
<h2 align="center"><?php
echo ($o_subject->getTitle ())?></h2>
</div>
<?php 
for($i = 0; $i < $n_count; $i ++) {
	$o_option = new SurveyOption ();
	$o_option->PushWhere ( array ('&&', 'ItemId', '=', $o_item->getItemId ( $i ) ) );
	$o_option->PushOrder ( array ('Number', 'A' ) );
	$n_count_temp = $o_option->getAllCount ();
	$s_temp = '';
	echo('
	<div class="qcontainer">
	<div class="centent">
	<p><strong>'.$o_item->getNumber ( $i ).' . '.$o_item->getContent ( $i ).'</strong></p>
	</div>
	<div class="qbody">
	<table>
	');
	if ($o_item->getTypeId ( $i )=='1' || $o_item->getTypeId ( $i )=='2')
	{
		for($j = 0; $j < $n_count_temp; $j ++) {
			if ($o_item->getTypeId ( $i )=='1')
			{
				echo('
				<tr>
					<td>
						<div><span><input type="radio" name="Vcl_Item_'.$o_item->getItemId ( $i ).'" value="'.$o_option->getOptionId($j).'"/><label><span>'.$o_option->getNumber($j).' . '.$o_option->getContent($j).'</span></label></span></div>
					</td>
				</tr>
				');
			}else{
				echo('
				<tr>
					<td>
						<div><span><input type="checkbox" name="Vcl_Option_'.$o_option->getOptionId($j).'"/><label><span>'.$o_option->getNumber($j).' . '.$o_option->getContent($j).'</span></label></span></div>
					</td>
				</tr>
				');
			}
		}
	}else{
		echo('
				<tr>
					<td>
						<div><input type="checkbox" name="Vcl_Option_'.$o_option->getOptionId($j).'" onclick="selectNone(this)"/> 无</div>
						<div style="margin-top:15px;"><textarea id="testarea" name="Vcl_Answer_'.$o_item->getItemId ( $i ).'" cols="20" rows="2"/></textarea></div>
					</td>
				</tr>
		');
	}
	echo('
	</table>
	</div>
	
	</div>
	');
}
?>
</div>
    <div style="clear:both;padding:30px; text-align: right; font-style: italic; width: 750px; font-weight: bold;color:red"><p>完成所有题目后，请点击"提交"按钮，并不要做任何操作，耐心等待系统提示！！</p></div>
    <div style="text-align:center;">
	<input name="NextButton" id="NextButton" type="button" value="&nbsp;&nbsp;提交&nbsp;&nbsp;" onclick="submit_survey()"  class="sv_submit" />
	</div>
</div>
</form>
<script>
function submit_survey()
{
	document.getElementById('NextButton').disabled=true;
	document.getElementById('submit_form').submit();
}
function selectNone(obj)
{
	if (obj.checked){
		document.getElementById('testarea').value='无';
		document.getElementById('testarea').style.display='none';
		}else{
			document.getElementById('testarea').value='';
			document.getElementById('testarea').style.display='block';
			}
		
	}
</script>
<iframe id="submit_form_frame" name="submit_form_frame" style="display:none" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
</body>
</html>
