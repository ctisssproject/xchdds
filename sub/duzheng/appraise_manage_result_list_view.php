<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 33001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);
$o_answer= new Dz_Appraise_Answers_View($_GET['id']);
function getList() 
{
		global $o_answer;
		$o_term = new Dz_Appraise_Questions ();
		$o_term->PushWhere ( array ('&&', 'AppraiseId', '=', $o_answer->getAppraiseId() ) );
		$o_term->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_term->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			if ($o_term->getType ( $i )==1)
			{
				$s_type="单选题";
				$s_url="appraise_manage_edit_single_modify.php";
			}
			if ($o_term->getType ( $i )==2)
			{
				$s_type="多选题";
				$s_url="appraise_manage_edit_multi_modify.php";
			}
			if ($o_term->getType ( $i )==3)
			{
				$s_type="评分题";
				$s_url="appraise_manage_edit_score_modify.php";
			}
			if ($o_term->getType ( $i )==4)
			{
				$s_type="问答题";
				$s_url="appraise_manage_edit_answer_modify.php";
			}
			if ($i == 0) {
				$n_up = 1;
			} else {
				$n_up = $i;
			}
			if (($i + 2) > $n_count) {
				$n_down = $n_count;
			} else {
				$n_down = $i + 2;
			}
			$s_record_list .= '
				             <tr class="TableLine1">
				             		<td align="center" style="font-size:14px">
					                    ' . $o_term->getNumber ( $i )  . '
					                </td>
					                <td align="center" >
					                    ' . $s_type . '
					                </td>
					                <td style="font-size:14px">
					                    <strong>' . $o_term->getQuestion ( $i ) . '</strong>
					                </td>
					            </tr>
			';
			$o_temp=new Dz_Appraise_Options();
			$o_temp->PushWhere ( array ('&&', 'QuestionId', '=', $o_term->getId($i) ) );
			$o_temp->PushOrder ( array ('Number', 'A' ) );
			$n_count_temp = $o_temp->getAllCount ();
			$s_temp='';
			if ($o_term->getType ( $i )==1)
			{
				$s_flag='';
				eval('$s_value=$o_answer->getAnswer'.$o_term->getNumber($i).'();');//获取用户答案
				$s_value=str_replace('"', '', $s_value);//去掉多余的双引号
				for($j = 0; $j < $n_count_temp; $j ++) {
					$s_temp.=$o_temp->getNumber($j).'.'.$o_temp->getOption($j);
					if ($o_temp->getId($j)==$s_value)
					{
						$s_temp.='&nbsp;&nbsp;<img src="'.RELATIVITY_PATH.'images/correct.gif"/> ';
					}	
					$s_temp.='<br/>';			
				}
			}
			if ($o_term->getType ( $i )==2)
			{
				$s_flag='';
				eval('$s_value=$o_answer->getAnswer'.$o_term->getNumber($i).'();');//获取用户答案
				$s_value=str_replace('"', '', $s_value);//去掉多余的双引号
				$a_value=json_decode($s_value);
				for($j = 0; $j < $n_count_temp; $j ++) {
					$s_temp.=$o_temp->getNumber($j).'.'.$o_temp->getOption($j);
					if (in_array($o_temp->getId($j),$a_value))
					{
						$s_temp.='&nbsp;&nbsp;<img src="'.RELATIVITY_PATH.'images/correct.gif"/> ';
					}	
					$s_temp.='<br/>';			
				}
			}
			if ($o_term->getType ( $i )==4)
			{
				$s_flag='';
				eval('$s_value=$o_answer->getAnswer'.$o_term->getNumber($i).'();');//获取用户答案
				$s_value=str_replace('"', '', $s_value);//去掉多余的双引号
				$s_temp=rawurldecode($s_value);//去掉多余的双引号
			}
			$s_record_list .= '
				             <tr class="TableLine1">
				             		<td align="center" style="font-size:14px">
					                   
					                </td>
					                <td align="center" >
					                  
					                </td>
					                <td style="font-size:14px;padding-left:20px;">
					                    '.$s_temp.'
					                </td>
					            </tr>
			';
		}
		//如果包含自动计算，那么显示系统推荐
		if($o_answer->getIsAuto()==1)
		{
			$s_record_list .= '
				             <tr class="TableLine1">
				             		<td align="center" style="font-size:14px">
					
					                </td>
					                <td align="center" >
					
					                </td>
					                <td style="font-size:14px;">
					                    <strong>'.$o_answer->getSuggest().'</strong>
					                </td>
					            </tr>
			';			
		}
		//构建基本信息
		$a_vcl=json_decode($o_answer->getAppraiseInfo());
		$a_vcl2=json_decode($o_answer->getInfo());
		$s_info='';
		$s_info.='<b>学校名称：</b>'.$o_answer->getSchoolName().'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		for($i=0;$i<count($a_vcl);$i++)
		{
			$s_info.='<b>'.rawurldecode($a_vcl[$i]).'：</b>'.rawurldecode($a_vcl2[$i]).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		//$s_info.='<b>评价人：</b>'.$o_answer->getOwnerName();
		$s_html = '
			    <div style="font-size:14px;padding-top:5px;padding-bottom:5px;">&nbsp;&nbsp;'.$s_info.'</div>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center"  width="60">
					                    题号 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                    
					                </td>
					                <td width="100">
					                   题型
					                </td>
					                <td >
					                   题目
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
	<script type="text/javascript" src="js/function.js"></script>
</head>

<body class="bodycolor" topmargin="0" style="padding-left:10px;padding-right:10px;padding-top:10px;color:#333333">
<table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <div style="padding-top:0px;padding-bottom:5px;">
			    <input value="返回" class="BigButtonA" onclick="history.go(-1)" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</div>
<?php
echo (getList());
?>
<script type="text/javascript" language="javascript">
	S_Root='../../';
	$('#Vcl_Type').val('<?php echo($_GET['id'])?>');
	parent.parent.parent.Common_CloseDialog();
    </script>
</body>
</html>
