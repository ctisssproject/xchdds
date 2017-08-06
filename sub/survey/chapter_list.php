<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 10001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';

$O_Session->ValidModuleForPage(MODULEID);
function getList() 
{
	require_once 'include/db_table.class.php';
		$o_term = new SurveySubject ();
		$o_term->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_term->PushOrder ( array ('Title', 'A' ) );
		$n_count = $o_term->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$s_record_list2='';
			$a_type=json_decode($o_term->getType ( $i ) );
			$s_type='';
			for($j=0;$j<count($a_type);$j++)
			{
				$o_survey=new SurveyType($a_type[$j]);
				$s_type.=$o_survey->getName().' ';
				
			}
			$a_scope=array('幼儿园','小学 中学','校外');
			$o_type=new SurveyItem();
			$o_type->PushWhere ( array ('&&', 'Type', '>',0) );
			$o_type->PushWhere ( array ('&&', 'SubjectId', '=',$o_term->getId($i)) );
			$o_type->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_type->PushOrder ( array ('Type', 'A' ) );
			$n_count_type=$o_type->getAllCount();
			//echo($n_count_type);
			$n_type_temp=0;
			for($j=0;$j<$n_count_type;$j++)
			{
					
					if ($n_type_temp==$o_type->getType($j))
					{
						continue;
					}else{
						$n_type_temp=$o_type->getType($j);
					}
					$o_type_temp=new SurveyItemType($n_type_temp);
					$s_record_list2 .= '
					             <tr class="TableLine1 line_'.$i.'" style="display:none">
						                <td align="center">
						                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>————'.$o_type_temp->getName().'</strong>
						                </td>
						                <td align="center">
						                     
						                </td>
						                 <td align="center">
						                     
						                </td>
						                <td align="center" nowrap="nowrap">
						                    <a href="../survey_total/total_print_empty.php?id='.$o_term->getId($i).'&type='.$n_type_temp.'" onclick="$(this).css(\'color\',\'#CCCCCC\')" target="_blank">打印</a>
						                </td>
						            </tr>';
			}
			if ($s_record_list2!='')
			{
				$s_buttom='<a href="javascript:;" class="line_b_s_'.$i.'" onclick="$(\'.line_'.$i.'\').show();$(this).hide();$(\'.line_b_h_'.$i.'\').show();">展开</a>&nbsp;&nbsp;<a style="display:none;color:red" class="line_b_h_'.$i.'" href="javascript:;" onclick="$(\'.line_'.$i.'\').hide();$(this).hide();$(\'.line_b_s_'.$i.'\').show();">收起</a>';
			}else{
				$s_buttom='';
			}
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" style="font-size:14px">
					                    <strong>' . $o_term->getTitle ( $i ) . '</strong>&nbsp;&nbsp;'.$s_buttom.'
					                </td>
					                <td align="center" >
					                    ' . $a_scope[$o_term->getScope ( $i )] . '
					                </td>
					                <td align="center" >
					                    ' . $s_type . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    <a href="javascript:;" onclick="location=\'chapter_modify.php?id='.$o_term->getId($i).'\'">修改</a>&nbsp;&nbsp;<a href="javascript:;" onclick="chapter_delete(' . $o_term->getId ( $i ) . ')">删除</a>&nbsp;&nbsp;<a href="../survey_total/total_print_empty.php?id='.$o_term->getId($i).'" onclick="$(this).css(\'color\',\'#CCCCCC\')" target="_blank">打印</a>
					                </td>
					            </tr>
			'.$s_record_list2;
		}
		$s_html = '
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    &nbsp;&nbsp;&nbsp;&nbsp;共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;个测评表
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center" >
					                    名称 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                    
					                </td>
					                <td width="100">
					                   测评范围
					                </td>
					                <td width="150">
					                   测评对象
					                </td>
					                <td align="center" width="150">
					                    操作
					                </td>
					            </tr>
					        </thead>
			        <tbody>
						' . $s_record_list . '
			        </tbody>
			    </table>
			    <br />
		
		';
		return $s_html;
	}
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
	<script type="text/javascript" src="../../js/dialog.fun.js"></script>
	<script type="text/javascript" src="js/common.fun.js"></script>
	<script type="text/javascript" src="js/function.js"></script>
</head>

<body class="bodycolor" topmargin="0" style="padding-left:10px;padding-right:10px;padding-top:10px;color:#333333">
<?php
echo (getList());
?>
<script type="text/javascript" language="javascript">
	S_Root='../../';
	parent.parent.parent.Common_CloseDialog();
    </script>
</body>
</html>
