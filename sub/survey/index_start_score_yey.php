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

if ($o_item->getTypeId(0)!=3)
{
	echo ('<script>location=\'index.php\'</script>');
}
?>
<?php 
function OutputItem($n_start,$n_end)
{
	global $o_item;
	global $n_count;
	$n_start=$n_start-1;
	$n_end=$n_end-1;
	if ($n_end>$n_count)
	{
		//return ;
	}
	for($i = $n_start; $i <= $n_end; $i ++) {
		if ($o_item->getNumber ( $i )=='')
		{
			return; 
		}
		if ($o_item->getTypeId($i)!=3)
		{
			continue;
		}
		echo('
		<div class="qcontainer">
		<div class="centent">
		<p>'.$o_item->getNumber ( $i ).' . '.$o_item->getContent ( $i ).'</p>
		</div>
		<div class="qbody">
		<table>
		<tr>
					<td width="325">
						<div style="padding-top:10px;"><span>分值：'.$o_item->getScore ( $i ).' </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>评分： </span><span><input style="font-size:14px;width:30px;" type="text" maxlength="4" name="Vcl_Item_'.$o_item->getItemId ( $i ).'" value="" onkeyup="value=value.replace(/[^0-9.]/g,\'\')"/></span></div>
					</td>
		</tr>
		</table>
		</div>
		
		</div>
		');
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
<input type="hidden" name="Vcl_Already" value="<?php echo(rawurlencode($_GET['already']))?>"/>
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
<div class="container" align="left" style="padding: 50px;">
<div class="top">
<div class="title" style="text-align: center; margin-left: 0px;">
<h2 align="center"><?php
echo ($o_subject->getTitle ())?></h2>
</div>
<table style="border: 1px dotted #CCCCCC; margin-top:30px;display:none">
          <tr height="25">
             <th align="center"width="158">分值</th>
             <th align="center" width="160">A级</th>
             <th align="center" width="160">B级</th>
             <th align="center" width="160">C级</th>
             <th align="center" width="158">D级</th>
          </tr>
          <tr>
             <th align="center"width="160">1</th>
             <td align="center" width="160">1.00-0.90</td>
             <td align="center" width="160">0.89-0.75</td>
             <td align="center" width="160">0.74-0.60</td>
             <td align="center" width="160">0.60-0.00</td>
          </tr>
          <tr> 
             <th align="center"width="160">2</th>
             <td align="center" width="160">2.00-1.80</td>
             <td align="center" width="160">1.79-1.50</td>
             <td align="center" width="160">1.49-1.20</td>
             <td align="center" width="160">1.19-0.00</td>
          </tr>
          <tr>
              <th align="center"width="160">3</th>
             <td align="center" width="160">3.00-2.70</td>
             <td align="center" width="160">2.69-2.25</td>
             <td align="center" width="160">2.24-1.80</td>
             <td align="center" width="160">1.79-0.00</td>
          </tr>
          <tr>
             <th align="center"width="160">4</th>
             <td align="center" width="160">4.00-3.60</td>
             <td align="center" width="160">3.59-3.00</td>
             <td align="center" width="160">2.99-2.40</td>
             <td align="center" width="160">2.39-0.00</td>
          </tr>
          <tr>
             <th align="center"width="160">5</th>
             <td align="center" width="160">5.00-4.50</td>
             <td align="center" width="160">4.49-3.75</td>
             <td align="center" width="160">3.74-3.00</td>
             <td align="center" width="160">2.99-0.00</td>
          </tr>
          <tr>
             <th align="center"width="160">6</th>
             <td align="center" width="160">6.00-5.40</td>
             <td align="center" width="160">5.39-4.15</td>
             <td align="center" width="160">4.14-2.50</td>
             <td align="center" width="160">2.49-0.00</td>
          </tr>
          <tr>
             <th align="center"width="160">7</th>
             <td align="center" width="160">7.00-6.30</td>
             <td align="center" width="160">6.29-5.45</td>
             <td align="center" width="160">5.44-3.70</td>
             <td align="center" width="160">3.69-0.00</td>
          </tr>
          <tr>
             <th align="center"width="160">8</th>
             <td align="center" width="160">8.00-7.20</td>
             <td align="center" width="160">7.19-6.35</td>
             <td align="center" width="160">6.34-4.30</td>
             <td align="center" width="160">4.29-0.00</td>
          </tr>
        </table>
        <br/>
        <br/>
  	<div class="centent">
		<p><strong>一、发展规划</strong></p>
	</div>
	<div class="centent" style="padding-top:35px;padding-left:15px;">
		<p><strong>(一) 办学思想与学校规划</strong></p>
	</div>    
	<?php 
	OutputItem(1,3);
	?>  
	<div class="centent" style="margin-top:40px;">
		<p><strong>二、队伍建设</strong></p>
	</div>
	<div class="centent" style="padding-top:35px;padding-left:15px;">
		<p><strong>(二) 干部队伍建设</strong></p>
	</div>    
	<?php 
	OutputItem(4,7);
	?> 
	<div class="centent" style="padding-top:35px;padding-left:15px;">
		<p><strong>(三) 教职工队伍建设</strong></p>
	</div>    
	<?php 
	OutputItem(8,12);
	?> 
	<div class="centent" style="margin-top:40px;">
		<p><strong>三、各项工作管理</strong></p>
	</div>
	<div class="centent" style="padding-top:35px;padding-left:15px;">
		<p><strong>(四) 保教工作</strong></p>
	</div>
	<?php 
	OutputItem(13,21);
	?>
	<div class="centent" style="padding-top:35px;padding-left:15px;">
		<p><strong>(五) 卫生保健工作</strong></p>
	</div>
	<?php 
	OutputItem(22,27);
	?>
	<div class="centent" style="padding-top:35px;padding-left:15px;">
		<p><strong>(六) 后勤工作</strong></p>
	</div>
	<?php 
	OutputItem(28,31);
	?>
	<div class="centent" style="padding-top:35px;padding-left:15px;">
		<p><strong>(七) 安全工作</strong></p>
	</div>
	<?php 
	OutputItem(32,32);
	?>
	<div class="centent" style="margin-top:40px;">
		<p><strong>四、发展绩效</strong></p>
	</div>
	<div class="centent" style="padding-top:35px;padding-left:15px;">
		<p><strong>(八) 幼儿发展水平</strong></p>
	</div>
	<?php 
	OutputItem(33,33);
	?>
	<div class="centent" style="padding-top:35px;padding-left:15px;">
		<p><strong>(九) 园所发展水平</strong></p>
	</div>
	<?php 
	OutputItem(34,35);
	?>
</div>
    <div style="clear:both;padding:30px; text-align: right; font-style: italic; width: 750px; font-weight: bold;color:red"><p>完成所有打分，请点击"提交"按钮，并不要做任何操作，耐心等待系统提示！！</p></div>
    <div style="text-align:center;">
	<input name="NextButton" id="NextButton" type="button" value="&nbsp;&nbsp;提交&nbsp;&nbsp;" onclick="document.getElementById('submit_form').submit();"  class="sv_submit" />
	</div>
</div>
</form>
<iframe id="submit_form_frame" name="submit_form_frame" style="display:none" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
</body>
</html>
