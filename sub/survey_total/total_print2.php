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

$o_item=new SurveyItem();
$o_item->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
$o_item->PushWhere ( array ('&&', 'SubjectId', '=',43) );
$o_item->PushOrder ( array ('Number', 'A' ) );
$n_count=$o_item->getAllCount();


$o_type=new SurveyType(5);
$o_dept=new SurveyDept(100018);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
</head>
<body>
<div style="width:640px;">
<div style="text-align:center;font-size:18px;"><?php echo($o_item->getTitle())?></div>
<div style="text-align:center;font-size:26px;font-family:黑体;margin-top:15px;"><?php echo($o_type->getName())?>问卷调查</div>
<div style="border-bottom: solid 1px #000000;overflow:hidden;margin-top:15px;"><div style="float:left;font-family:黑体;margin-left:15px;"><?php echo($o_dept->getName())?>&nbsp;&nbsp;&nbsp;&nbsp;参加问卷调查人数：<?php echo('')?> 人</div><div style="float:right; margin-right:15px;"><?php echo('2014-09-28')?></div></div>

<?php
	/*$o_option=new View_Total_Option();
	$o_option->PushWhere ( array ('&&', 'TotalId', '=',$o_subject_item->getId() ) );
	$o_option->PushOrder ( array ('Number', 'A' ) );	
	$n_count=$o_option->getAllCount();
	echo($n_count);*/
	$s_total=0;
	for($i=0;$i<$n_count;$i++)
	{
		$s_total=0;
		echo('<div style="border-bottom: solid 1px #000000;overflow:hidden;margin-top:15px;padding-left:15px;padding-right:15px;padding-bottom:15px;">');
		$s_type='';
		if ($o_item->getTypeId($i)==2)
		{
			$s_type='(多选)';
		}
		echo('<div>第 '.$o_item->getNumber($i).' 题&nbsp;&nbsp;&nbsp;&nbsp;'.$o_item->getContent($i).'&nbsp;&nbsp;'.$s_type.'</div>');
		$o_option=new SurveyOption();
		$o_option->PushWhere ( array ('&&', 'ItemId', '=',$o_item->getItemId($i) ) );
		$o_option->PushOrder ( array ('Number', 'A' ) );	
		$n_count2=$o_option->getAllCount();
		$n_sum=0;
		$s_item='';
		$s_item2='';
		for($j=0;$j<$n_count2;$j++)
		{
			$o_answer=new SurveyTotalOption();
			$o_answer->PushWhere ( array ('&&', 'OptionId', '=',$o_option->getOptionId($j) ) );
			if ($o_answer->getAllCount()>0)
			{
				$n_sum=$n_sum+$o_answer->getAllCount();
			}
			$s_item.=$o_option->getNumber($j).'.&nbsp;&nbsp;'.$o_option->getContent($j).'<br/>';
		}
		$s_total=$n_sum+$s_total;
		for($j=0;$j<$n_count2;$j++)
		{
			$o_answer=new SurveyTotalOption();
			$o_answer->PushWhere ( array ('&&', 'OptionId', '=',$o_option->getOptionId($j) ) );
			if ($o_answer->getAllCount()>0)
			{
				$s_item2.=$o_option->getNumber($j).'.&nbsp;&nbsp;'.$o_answer->getAllCount().' 人&nbsp;&nbsp;&nbsp;&nbsp;'.(floor($o_answer->getAllCount()/$n_sum*10000)/100).'%<br/>';
			}else{
				$s_item2.=$o_option->getNumber($j).'.&nbsp;&nbsp;0 人&nbsp;&nbsp;&nbsp;&nbsp;0%<br/>';
			}
			
		}
		
		echo('<div style="float:left;line-height:22px;margin-top:10px;margin-left:10px">'.$s_item.'</div>');
		echo('<div style="float:right;line-height:22px;">第'.$o_item->getNumber($i).'题：&nbsp;&nbsp;'.$s_total.' 人<br/>'.$s_item2);
		echo('</div></div>');
	}
?>

</div>

</body>
</html>
