<?php
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 20001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$O_Session->ValidModuleForPage(MODULEID);
require_once RELATIVITY_PATH.'sub/survey/include/db_table.class.php';
require_once RELATIVITY_PATH.'sub/survey/include/db_view.class.php';
if (isset($_GET['id'])&& $_GET['id']>0)
{
	$o_subject_item=new SurveyTotalItem ($_GET['id']); 
	$o_subject=new SurveySubject($o_subject_item->getSubjectId());
}else{
	exit(0);
}
//判断是否跳转到幼儿园统计，校外
if ($o_subject->getScope()==0)
{
	echo ('<script>location=\'total_print_score_yey.php?id='.$o_subject_item->getId().'\'</script>');
}
if ($o_subject->getScope()==2)
{
	echo ('<script>location=\'total_print_score_xy.php?id='.$o_subject_item->getId().'\'</script>');
}
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
			echo (0);
			return 0;
		}
	} else {
		echo (0);
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
			3.29～2.40
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
		<td><?php echo($n_number)?></td>
		<td>
			<?php echo($o_item->getScore($n_number-1))?>
			</td>
			<?php getScore($o_item->getScore($n_number-1))?>
			<td>
			<?php $n_temp=getSumByType($o_subject_item,$o_item,($n_number-1),1); $sum1=$sum1+$n_temp;$total1=$total1+$n_temp;?>
			</td>
		<td>
			<?php $n_temp=getSumByType($o_subject_item,$o_item,($n_number-1),2);$sum2=$sum2+$n_temp;$total2=$total2+$n_temp;?>
			</td>
		<td>
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
	style="margin-top: 10px; font-size: 12px; margin-left: 120px; font-family: 黑体;"><?php echo($o_date->format ( 'Y' )-3)?>-<?php echo($o_date->format ( 'Y' ))?>学年度&nbsp;&nbsp;&nbsp;&nbsp;<?php echo($o_dept->getName())?></div>
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
				echo(0);
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
				echo(0);
			}
			?>人）
			</td>
	</tr>
		<?php 

		//------------------------------------------------------------------------------------------------------
		?>
	<tr>
		<td rowspan="3">&nbsp;一.<br /><br />
		&nbsp;发&nbsp;<br /><br />
		&nbsp;展&nbsp;<br /><br />
		&nbsp;规&nbsp;<br /><br />
		&nbsp;划&nbsp;</td>
		<td rowspan="2" style="padding-top:10px;padding-bottom:10px;">（一）<br />
		办学<br />
		思想<br />
		与<br />
		学校<br />
		规划
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,1);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,2);?>
	</tr>
	<tr>
		<td colspan="6" class="sum">《发展规划》指标评分合计</td>
		<td>
			<?php echo($sum1)?>
			</td>
		<td>
			<?php echo($sum2)?>
			</td>
		<td>
			<?php echo($sum3)?>
			</td>
	</tr>
		
	<?php 
	//------------------------------------------------------------------------------------------------------
		$sum1=0;
		$sum2=0;
		$sum3=0;
	?>
	<tr>
		<td rowspan="8">&nbsp;&nbsp;二.&nbsp;<br /><br />
		&nbsp;队&nbsp;<br /><br />&nbsp;伍&nbsp;<br /><br />&nbsp;建&nbsp;<br /><br />&nbsp;设&nbsp;
		</td>
		<td rowspan="4">（二）<br />
		干部<br />队伍<br />建设<br />
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
		<td rowspan="3">（三）<br />
		教师<br />队伍<br />建设<br />
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,7);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,8);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,9);?>
	</tr>
		<tr>
		<td colspan="6" class="sum">《队伍建设》指标评分合计</td>
		<td>
			<?php echo($sum1)?>
			</td>
		<td>
			<?php echo($sum2)?>
			</td>
		<td>
			<?php echo($sum3)?>
			</td>
	</tr>
	<tr>
		<td rowspan="22">&nbsp;&nbsp;三.&nbsp;<br /><br />
		&nbsp;各&nbsp;<br /><br />&nbsp;项&nbsp;<br /><br />&nbsp;工&nbsp;<br /><br />&nbsp;作&nbsp;<br /><br />&nbsp;管&nbsp;<br /><br />&nbsp;理&nbsp;
		</td>
		<td rowspan="5">（四）<br />
		行政<br />工作<br />
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,10,true);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,11);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,12);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,13);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,14);?>
	</tr>
	<tr>
		<td rowspan="5">（五）<br />
		德育<br />工作<br />
		</td>
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
</table>
</div>
<div style="width: 460px;float:left;margin-left:30px;">
<table class="score_table" border="0" cellpadding="0" cellspacing="0"
	style="margin-top: 10px;">
	<tr>
		<td rowspan="12">&nbsp;&nbsp;三.&nbsp;<br /><br />
		&nbsp;各&nbsp;<br /><br />&nbsp;项&nbsp;<br /><br />&nbsp;工&nbsp;<br /><br />&nbsp;作&nbsp;<br /><br />&nbsp;管&nbsp;<br /><br />&nbsp;理&nbsp;
		</td>
		<td rowspan="7">（六）<br />
		教学<br />工作<br />
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,20);?>
	</tr>
	<tr>
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
		<?php getScoreSingle($o_item,$o_subject_item,25);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,26);?>
	</tr>
	<tr>
		<td rowspan="3">（七）<br />
		体育<br />美育<br />科技<br />卫生<br />健康<br />教育<br />
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,27);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,28);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,29);?>
	</tr>
	<tr>
		<td>（八）<br />
		安全<br />工作
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,30);?>
	</tr>
		<tr>
		<td colspan="6" class="sum">《各项工作管理》指标评分合计</td>
		<td>
			<?php echo($sum1)?>
			</td>
		<td>
			<?php echo($sum2)?>
			</td>
		<td>
			<?php echo($sum3)?>
			</td>
	</tr>
	<?php 
	//------------------------------------------------------------------------------------------------------
		$sum1=0;
		$sum2=0;
		$sum3=0;
	?>
	<tr>
		<td rowspan="8" style="padding-top:10px;padding-bottom:10px;">&nbsp;&nbsp;四.&nbsp;<br /><br />
		&nbsp;发&nbsp;<br />&nbsp;展&nbsp;<br />&nbsp;绩&nbsp;<br />&nbsp;效&nbsp;<br />&nbsp;与&nbsp;<br />&nbsp;办&nbsp;<br />&nbsp;学&nbsp;<br />&nbsp;特&nbsp;<br />&nbsp;色&nbsp;
		</td>
		<td rowspan="4">（九）<br />
		学生<br />发展<br />
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,31,true);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,32);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,33);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,34);?>
	</tr>
	<tr>
		<td rowspan="3">（十）<br />
		学校<br />发展<br />和特色
		</td>
		<?php getScoreSingle($o_item,$o_subject_item,35);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,36);?>
	</tr>
	<tr>
		<?php getScoreSingle($o_item,$o_subject_item,37);?>
	</tr>
	<tr>
		<td colspan="6" class="sum">《发展绩效与办学特色》指标评分合计</td>
		<td>
			<?php echo($sum1)?>
			</td>
		<td>
			<?php echo($sum2)?>
			</td>
		<td>
			<?php echo($sum3)?>
			</td>
	</tr>
	<tr>
		<td colspan="7" class="sum">评&nbsp;&nbsp;分&nbsp;&nbsp;总&nbsp;&nbsp;计</td>
		<td>
			<?php echo($total1)?>
			</td>
		<td>
			<?php echo($total2)?>
			</td>
		<td>
			<?php echo($total3)?>
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