<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 20001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH.'sub/survey/include/db_table.class.php';
require_once RELATIVITY_PATH.'sub/survey/include/db_view.class.php';
$O_Session->ValidModuleForPage(MODULEID);
function getList() 
{
		$o_term = new View_Total_Item ();
		$o_term->PushWhere ( array ('&&', 'Delete', '=',0) );
		$o_term->PushOrder ( array ('Start', 'D' ) );
		$o_term->PushOrder ( array ('DeptId', 'D' ) );
		$n_count = $o_term->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$s_record_list2='';
			$o_temp=new SurveyItem();
			$o_temp->PushWhere ( array ('&&', 'SubjectId', '=',$o_term->getSubjectId ( $i )) );
			if($o_temp->getAllCount()>0 && $o_temp->getTypeId(0)!=3)
			{
				$o_type2=new SurveyType($o_term->getType($i));
				$o_type=new SurveyItemType();
				$o_type->PushWhere ( array ('&&', 'Type', '=', $o_type2->getType() ) );
				$o_type->PushOrder ( array ('Number', 'A' ) );
				$n_count_type=$o_type->getAllCount();
				for($j=0;$j<$n_count_type;$j++)
				{
				$s_record_list2 .= '
				             <tr class="TableLine1 line_'.$i.'" style="display:none">
					                <td align="center" style="font-size:14px">
					                </td>
					                <td >
					                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>' . $o_term->getSubjectName ( $i ) .'————'.$o_type->getName($j).'</strong>
					                </td>
					                <td align="center">
					                    ' . $o_term->getDeptName ( $i ) . '
					                </td>
					                <td align="center">
					                    ' . $o_term->getTypeName ( $i ) . '
					                </td>
					                <td align="center">
					                
					                </td>
					                <td align="center" nowrap="nowrap">
					                    <a href="total_print.php?id='.$o_term->getId($i).'&type='.$o_type->getId($j).'" onclick="$(this).css(\'color\',\'#CCCCCC\')" target="_blank">打印结果</a>
					                </td>
					            </tr>';
				}
			}
			if ($s_record_list2!='')
			{
				$s_pdf='';
				$s_buttom='<a href="javascript:;" class="line_b_s_'.$i.'" onclick="$(\'.line_'.$i.'\').show();$(this).hide();$(\'.line_b_h_'.$i.'\').show();">展开</a>&nbsp;&nbsp;<a style="display:none;color:red" class="line_b_h_'.$i.'" href="javascript:;" onclick="$(\'.line_'.$i.'\').hide();$(this).hide();$(\'.line_b_s_'.$i.'\').show();">收起</a>';
			}else{
				$s_buttom='';
				//是否显示导出pdf
				$o_subject_item=new SurveyTotalItem ($o_term->getId($i)); 
				$o_subject=new SurveySubject($o_subject_item->getSubjectId());
				$s_pdf='&nbsp;&nbsp;<a href="total_pdf.php?id='.$o_term->getId($i).'" onclick="$(this).css(\'color\',\'#CCCCCC\')" target="_blank">导出PDF</a>';
				if ($o_subject->getScope()==0)
				{
					$s_pdf='&nbsp;&nbsp;<a href="total_pdf_yey.php?id='.$o_term->getId($i).'" onclick="$(this).css(\'color\',\'#CCCCCC\')" target="_blank">导出PDF</a>';
				}
				if ($o_subject->getScope()==2)
				{
					$s_pdf='&nbsp;&nbsp;<a href="total_pdf_xy.php?id='.$o_term->getId($i).'" onclick="$(this).css(\'color\',\'#CCCCCC\')" target="_blank">导出PDF</a>';
				}				
			}
				$n_limit='无上限';
				if($o_term->getLimit ( $i )>0)
				{
					$n_limit=$o_term->getLimit ($i).' 人';
				}
				
				$s_record_list .= '<tr class="TableLine1">
					                <td align="center" style="font-size:14px">
					                    ' . $o_term->getStart ( $i ) . ' 至 '. $o_term->getEnd ( $i ) .'
					                </td>
					                <td>
					                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>' . $o_term->getSubjectName ( $i ) . '</strong>&nbsp;&nbsp;'.$s_buttom.'
					                </td>
					                <td align="center">
					                    ' . $o_term->getDeptName ( $i ) . '
					                </td>
					                <td align="center">
					                    ' . $o_term->getTypeName ( $i ) . '
					                </td>
					                <td align="center">
					                    ' . $o_term->getSum ( $i ) . ' 人
					                </td>
					                <td align="center">
					                    ' . $n_limit . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    <a href="total_setlimit.php?id='.$o_term->getId($i).'">设置上限</a>&nbsp;&nbsp;<a href="total_print.php?id='.$o_term->getId($i).'" onclick="$(this).css(\'color\',\'#CCCCCC\')" target="_blank">打印结果</a>'.$s_pdf.'&nbsp;&nbsp;<a style="color:red" href="javascript:;" onclick="delete_total('.$o_term->getId($i).')">删除</a>
					                </td>
					            </tr>'.$s_record_list2;
		}
		$s_html = '
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    &nbsp;&nbsp;&nbsp;&nbsp;共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;个结果
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center" width="220">
					                    测评日期 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle"> 
					                </td>
					                <td>
					                   名称
					                </td>
					                <td>
					                   测评单位
					                </td>
					                <td>
					                   测评对象
					                </td>
					                <td>
					                  参测人数
					                </td>
					                <td>
					                  上限
					                </td>
					                <td align="center" width="220">
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
	<script type="text/javascript" src="js/ajax.fun.js"></script>
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
