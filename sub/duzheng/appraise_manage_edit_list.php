<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 33001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
	require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);
function getList($id) 
{
		$o_term = new Dz_Appraise_Questions ();
		$o_term->PushWhere ( array ('&&', 'AppraiseId', '=', $id ) );
		$o_term->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_term->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$s_must='';
			if ($o_term->getIsMust($i)==1)
			{
				$s_must='<span style="color:red">*</span> ';
			}
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
				$s_type="简述题";
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
					                    ' .$s_must.$o_term->getNumber ( $i )  . '
					                </td>
					                <td align="center" >
					                    ' . $s_type . '
					                </td>
					                <td style="font-size:14px">
					                    <strong>' . $o_term->getQuestion ( $i ) . '</strong>
					                </td>
					                <td align="center" nowrap="nowrap">
					                    <a href="javascript:;" onclick="appraise_question_setnumber(' . $o_term->getId ( $i ) . ',' . $n_up . ')">上移</a>&nbsp;&nbsp;<a href="javascript:;" onclick="location=\''.$s_url.'?id='.$o_term->getId($i).'\'">修改</a>&nbsp;&nbsp;<a href="javascript:;" onclick="appraise_question_delete(' . $o_term->getId ( $i ) . ')">删除</a>&nbsp;&nbsp;<a href="javascript:;" onclick="appraise_question_setnumber(' . $o_term->getId ( $i ) . ',' . $n_down . ')">下移</a>
					                </td>
					            </tr>
			';
			$o_temp=new Dz_Appraise_Options();
			$o_temp->PushWhere ( array ('&&', 'QuestionId', '=', $o_term->getId($i) ) );
			$o_temp->PushOrder ( array ('Number', 'A' ) );
			$n_count_temp = $o_temp->getAllCount ();
			$s_temp='';
			for($j = 0; $j < $n_count_temp; $j ++) {
				$s_temp.=$o_temp->getNumber($j).'.'.$o_temp->getOption($j).'<br/>';
			}
			if ($n_count_temp==0)
			{
				continue;
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
					                <td align="center" nowrap="nowrap">
					                    
					                </td>
					            </tr>
			';
		}
		$s_html = '
			    
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
			    <div style="padding-top:5px;padding-bottom:15px;">
			    <input value="返回" class="BigButtonA" onclick="location='<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>appraise_manage.php'" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    <input value="添加单选题" class="BigButtonC" 
				onclick="location='appraise_manage_edit_single_add.php?id=<?php echo($_GET['id'])?>'" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;<input value="添加多选题" class="BigButtonC"
				onclick="location='appraise_manage_edit_multi_add.php?id=<?php echo($_GET['id'])?>'" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;<input value="添加简述题" class="BigButtonC"
				onclick="location='appraise_manage_edit_answer_add.php?id=<?php echo($_GET['id'])?>'" type="button" />
				</div>
<?php
echo (getList($_GET['id']));
?>
<script type="text/javascript" language="javascript">
	S_Root='../../';
	$('#Vcl_Type').val('<?php echo($_GET['id'])?>');
	parent.parent.parent.Common_CloseDialog();
    </script>
</body>
</html>
