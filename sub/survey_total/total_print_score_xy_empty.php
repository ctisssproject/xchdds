<?php
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 10001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$O_Session->ValidModuleForPage(MODULEID);
require_once RELATIVITY_PATH.'sub/survey/include/db_table.class.php';
require_once RELATIVITY_PATH.'sub/survey/include/db_view.class.php';
if (isset($_GET['id'])&& $_GET['id']>0)
{
	$o_subject_item=new SurveyTotalItem ($_GET['id']); 
	$o_subject=new SurveySubject($_GET['id']);
}else{
	exit(0);
}
//判断是否跳转到幼儿园统计


$o_item=new SurveyItem();
$o_item->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
$o_item->PushWhere ( array ('&&', 'SubjectId', '=', $o_subject->getId() ) );
$o_item->PushOrder ( array ('Number', 'A' ) );
$n_count=$o_item->getAllCount();
$o_type=new SurveyType($o_subject_item->getType());
$o_dept=new SurveyDept($o_subject_item->getDeptId());
		$total1=0;
		$total2=0;
		$total3=0;
		$sum1=0;
		$sum2=0;
		$sum3=0;
function getSumByType($o_subject_item, $o_table, $i, $n_type) {
	$o_temp = new SurveyTotalItem ();
	$o_temp->PushWhere ( array ('&&', 'SubjectId', '=', $o_subject_item->getSubjectId () ) );
	$o_temp->PushWhere ( array ('&&', 'DeptId', '=',$o_subject_item->getDeptId() ) );
	$o_temp->PushWhere ( array ('&&', 'Start', '=', $o_subject_item->getStart () ) );
	$o_temp->PushWhere ( array ('&&', 'End', '=', $o_subject_item->getEnd () ) );
	$o_temp->PushWhere ( array ('&&', 'Type', '=', $n_type ) );
	if ($o_temp->getAllCount () > 0) {
		$o_temp2=new SurveyTotalOption();
		$o_temp2->PushWhere ( array ('&&', 'TotalId', '=', $o_temp->getId(0)) );
		$o_temp2->PushWhere ( array ('&&', 'ItemId', '=', $o_table->getItemId($i)) );
		if ($o_temp2->getAllCount()>0)
		{
			echo((int)floor($o_temp2->getSum(0)/$o_temp->getSum(0)*100)/100);
			return (int)floor($o_temp2->getSum(0)/$o_temp->getSum(0)*100)/100;
		}else{
			echo ('');
			return 0;
		}
	} else {
		echo ('');
		return 0;
	}
}
function getScore($number)
{
	if ($number=='')
	{
		$number=1;
	}
	if ($number==1)
	{
		echo('<td>
			1.00～0.80
			</td>
			<td>
			0.79～0.60
			</td>
			<td>
			0.59～0
			</td>');
	}
	if ($number==2)
	{
		echo('<td>
			2～1.60
			</td>
			<td>
			1.59～1.20
			</td>
			<td>
			1.19～0
			</td>');
	}	
	if ($number==3)
	{
		echo('<td>
			3.00～2.40
			</td>
			<td>
			2.39～1.80
			</td>
			<td>
			1.79～0
			</td>');
	}
	if ($number==4)
	{
		echo('<td>
			4.00～3.20
			</td>
			<td>
			3.19～2.40
			</td>
			<td>
			2.39～0
			</td>');
	}
	if ($number==5)
	{
		echo('<td>
			5.00～4.00
			</td>
			<td>
			3.99～3.00
			</td>
			<td>
			2.99～0
			</td>');
	}
	if ($number==6)
	{
		echo('<td>
			6～5.4
			</td>
			<td>
			5.39～4.15
			</td>
			<td>
			2.49～0
			</td>');
	}
	if ($number==7)
	{
		echo('<td>
			7～6.3
			</td>
			<td>
			6.29～5.45
			</td>
			<td>
			3.69～0
			</td>');
	}
	if ($number==8)
	{
		echo('<td>
			8.00～6.40
			</td>
			<td>
			6.39～4.80
			</td>
			<td>
			4.79～0
			</td>');
	}
	if ($number==9)
	{
		echo('<td>
			9.00～7.20
			</td>
			<td>
			7.19～3.60
			</td>
			<td>
			3.59.30～0
			</td>');
	}
	if ($number==10)
	{
		echo('<td>
			10.0～8.00
			</td>
			<td>
			7.99～6.00
			</td>
			<td>
			5.99～0
			</td>');
	}
}
function getScoreSingle($o_item,$o_subject_item,$n_number,$b=FALSE)
{

	global $total1;
	global $total2;
	global $total3;
	global $sum1;
	global $sum2;
	global $sum3;
		if ($b)
		{
			$sum1=0;
			$sum2=0;
			$sum3=0;
		}
	?>
		<td style="width:20px"><?php echo($n_number)?></td>
		<td style="width:20px">
			<?php echo($o_item->getScore($n_number-1))?>
			</td>
			<?php getScore($o_item->getScore($n_number-1))?>
			<td style="width:40px;">
			<?php $n_temp=getSumByType($o_subject_item,$o_item,($n_number-1),1); $sum1=$sum1+$n_temp;$total1=$total1+$n_temp;?>
			</td>
		<td style="width:40px;">
			<?php $n_temp=getSumByType($o_subject_item,$o_item,($n_number-1),2);$sum2=$sum2+$n_temp;$total2=$total2+$n_temp;?>
			</td>
		<td style="width:40px;">
			<?php $n_temp=getSumByType($o_subject_item,$o_item,($n_number-1),3);$sum3=$sum3+$n_temp;$total3=$total3+$n_temp;?>
			</td>
	<?php
}
$o_date = new DateTime ( 'Asia/Chongqing' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div style="width: 460px;float:left">
<div style="text-align: center; font-size: 16px;"><?php echo($o_subject->getTitle())?></div>
<div
	style="margin-top: 10px; font-size: 12px; margin-left: 120px; font-family: 黑体;"><?php echo($o_date->format ( 'Y' )-3)?>-<?php echo($o_date->format ( 'Y' ))?> 学年度&nbsp;&nbsp;&nbsp;&nbsp;<?php echo($o_dept->getName())?></div>
<table class="score_table" border="0" cellpadding="0" cellspacing="0"
	style="margin-top: 10px;">
	<tr class="title">
		<td rowspan="2">一级<br />
		<br />
		指标</td>
		<td rowspan="2">二级<br />
		<br />
		指标</td>
		<td rowspan="2" style="padding-top: 10px; padding-bottom: 10px;" nowrap="nowrap">三级<br />
		指标<br />
		评价<br />
		要点</td>
		<td rowspan="2">分<br />
		<br />
		值</td>
		<td colspan="3">评价等级</td>
		<td colspan="3">评价评分</td>
	</tr>
	<tr class="title">
		<td>A</td>
		<td>B</td>
		<td>C</td>
		<td nowrap="nowrap">校长<br />
		评分</td>
		<td nowrap="nowrap">干部<br />（<?php 
			$o_temp=new SurveyTotalItem();
			$o_temp->PushWhere ( array ('&&', 'SubjectId', '=',$o_subject_item->getSubjectId() ) );
			$o_temp->PushWhere ( array ('&&', 'DeptId', '=',$o_subject_item->getDeptId() ) );
			$o_temp->PushWhere ( array ('&&', 'Start', '=',$o_subject_item->getStart() ) );
			$o_temp->PushWhere ( array ('&&', 'End', '=',$o_subject_item->getEnd() ) );
			$o_temp->PushWhere ( array ('&&', 'Type', '=',2) );
			if ($o_temp->getAllCount()>0)
			{
				echo($o_temp->getSum(0));
			}else{
				echo('');
			}
			?>人）
			</td>
		<td nowrap="nowrap">教职工<br />
			（<?php 
			$o_temp=new SurveyTotalItem();
			$o_temp->PushWhere ( array ('&&', 'SubjectId', '=',$o_subject_item->getSubjectId() ) );
			$o_temp->PushWhere ( array ('&&', 'DeptId', '=',$o_subject_item->getDeptId() ) );
			$o_temp->PushWhere ( array ('&&', 'Start', '=',$o_subject_item->getStart() ) );
			$o_temp->PushWhere ( array ('&&', 'End', '=',$o_subject_item->getEnd() ) );
			$o_temp->PushWhere ( array ('&&', 'Type', '=',3) );
			if ($o_temp->getAllCount()>0)
			{
				echo($o_temp->getSum(0));
			}else{
				echo('');
			}
			?>人）
			</td>
	</tr>
		<?php 

		//------------------------------------------------------------------------------------------------------
		?>
	<tr>
		<td rowspan="3">&nbsp;一.<br /><br />
		&nbsp;规&nbsp;<br /><br />
		&nbsp;划&nbsp;<br /><br />
		&nbsp;与&nbsp;<br /><br />
		&nbsp;计&nbsp;<br /><br />
		&nbsp;划&nbsp;</td>
		<td rowspan="1" style="padding-top:10px;padding-bottom:10px;">（一）<br />
		发展<br />
		规划<br />
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,1);?>
	</tr>
	<tr>
		<td rowspan="1" style="padding-top:10px;padding-bottom:10px;">（二）<br />
		年度<br />
		计划<br />
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,2);?>
	</tr>
	<tr>
		<td colspan="6" class="sum">《规划与计划》指标评分合计</td>
		<td>
			<?php echo('')?>
			</td>
		<td>
			<?php echo('')?>
			</td>
		<td>
			<?php echo('')?>
			</td>
	</tr>
		
	<?php 
	//------------------------------------------------------------------------------------------------------
		$sum1=0;
		$sum2=0;
		$sum3=0;
	?>
	<tr>
		<td rowspan="10">&nbsp;&nbsp;二.&nbsp;<br /><br />
		&nbsp;队&nbsp;<br /><br />&nbsp;伍&nbsp;<br /><br />&nbsp;建&nbsp;<br /><br />&nbsp;设&nbsp;
		</td>
		<td rowspan="5">（三）<br />
		干部<br />队伍<br />
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,3,true);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,4);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,5);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,6);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,7);?>
	</tr>
	<tr>
		<td rowspan="4">（四）<br />
		教师<br />队伍<br />
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,8);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,9);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,10);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,11);?>
	</tr>
		<tr>
		<td colspan="6" class="sum">《队伍建设》指标评分合计</td>
		<td>
			<?php echo('')?>
			</td>
		<td>
			<?php echo('')?>
			</td>
		<td>
			<?php echo('')?>
			</td>
	</tr>
	<tr>
		<td rowspan="9">&nbsp;&nbsp;三.&nbsp;<br /><br />
		&nbsp;管&nbsp;<br /><br />&nbsp;理&nbsp;<br /><br />&nbsp;工&nbsp;<br /><br />&nbsp;作&nbsp;
		</td>
		<td rowspan="2">（五）<br />
		组织<br />机构<br />制度<br />建设
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,12,true);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,13);?>
	</tr>
</table>
</div>
<div style="width: 460px;float:left;margin-left:30px;">
<table class="score_table" border="0" cellpadding="0" cellspacing="0"
	style="margin-top: 10px;">
	<tr>
		<td rowspan="15">&nbsp;&nbsp;三.&nbsp;<br /><br />
		&nbsp;管&nbsp;<br /><br />&nbsp;理&nbsp;<br /><br />&nbsp;工&nbsp;<br /><br />&nbsp;作&nbsp;
		</td>
		<td rowspan="7">（六）<br />
		教育<br />活动<br />管理
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,14);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,15);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,16);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,17);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,18);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,19);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,20);?>
	</tr>
	<tr>
		<td rowspan="4">（七）<br />
		管理<br />资源<br />
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,21);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,22);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,23);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,24);?>
	</tr>
	<tr>
		<td>（八）<br />
		教科研<br />管理
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,25);?>
	</tr>
	<tr>
		<td rowspan="2">（九）<br />
		安全<br />管理
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,26);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,27);?>
	</tr>
		<tr>
		<td colspan="6" class="sum">《管理工作》指标评分合计</td>
		<td>
			<?php echo('')?>
			</td>
		<td>
			<?php echo('')?>
			</td>
		<td>
			<?php echo('')?>
			</td>
	</tr>
	<?php 
	//------------------------------------------------------------------------------------------------------
		$sum1=0;
		$sum2=0;
		$sum3=0;
	?>
	<tr>
		<td rowspan="3" style="padding-top:10px;padding-bottom:10px;">&nbsp;&nbsp;四.&nbsp;<br /><br />
		&nbsp;发&nbsp;<br />&nbsp;展&nbsp;<br />&nbsp;绩&nbsp;<br />&nbsp;效&nbsp;
		</td>
		<td rowspan="1">（八）<br />
		工作<br />绩效<br />
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,28,true);?>
	</tr>
	<tr>
		<td rowspan="1">（九）<br />
		工作<br />特色
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,34);?>
	</tr>
	<tr>
		<td colspan="6" class="sum">《发展绩效》指标评分合计</td>
		<td>
			<?php echo('')?>
			</td>
		<td>
			<?php echo('')?>
			</td>
		<td>
			<?php echo('')?>
			</td>
	</tr>
	<tr>
		<td colspan="7" class="sum">评&nbsp;&nbsp;分&nbsp;&nbsp;总&nbsp;&nbsp;计</td>
		<td>
			<?php echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')?>
			</td>
		<td>
			<?php echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')?>
			</td>
		<td>
			<?php echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')?>
			</td>
	</tr>
	</table>
	<table style="width:100%">
	<tr>
	<td style="font-size:12px;text-align:right"><br/><br/>测评时间：<?php echo($o_subject_item->getStart())?><br/><br/>
	北京市西城区人民政府教育督导室
	</td>
	</tr>
	</table>
</div>
</body>
</html>