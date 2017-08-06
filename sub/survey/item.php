<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 10001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
	require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);
function getList($id) 
{
		$o_term = new SurveyItem ();
		$o_term->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_term->PushWhere ( array ('&&', 'SubjectId', '=', $id ) );
		$o_term->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_term->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			if ($o_term->getTypeId ( $i )==1)
			{
				$s_type="单选题";
				$s_url="item_single_modify.php";
			}
			if ($o_term->getTypeId ( $i )==2)
			{
				$s_type="多选题";
				$s_url="item_multi_modify.php";
			}
			if ($o_term->getTypeId ( $i )==3)
			{
				$s_type="评分题";
				$s_url="item_score_modify.php";
			}
			if ($o_term->getTypeId ( $i )==4)
			{
				$s_type="问答题";
				$s_url="item_answer_modify.php";
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
			if($o_term->getScore($i)==0)
			{
				$s_score='无';
			}else{
				$s_score=$o_term->getScore($i);
			}
			$o_type=new SurveyItemType($o_term->getType( $i ));
			$s_record_list .= '
				             <tr class="TableLine1">
				             		<td align="center" style="font-size:14px">
					                    ' . $o_term->getNumber ( $i )  . '
					                </td>
					                <td align="center" >
					                    ' . $s_type . '
					                </td>
					                <td style="font-size:14px">
					                    <strong>' . $o_term->getContent ( $i ) . '</strong>
					                </td>
					                
					                <td align="center" >
					                    ' . $s_score . '
					                </td>
					                <td align="center" >
					                    ' . $o_type->getName() . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    <a href="javascript:;" onclick="item_setnumber(' . $o_term->getItemId ( $i ) . ',' . $n_up . ')">上移</a>&nbsp;&nbsp;<a href="javascript:;" onclick="location=\''.$s_url.'?id='.$o_term->getItemId($i).'\'">修改</a>&nbsp;&nbsp;<a href="javascript:;" onclick="item_delete(' . $o_term->getItemId ( $i ) . ')">删除</a>&nbsp;&nbsp;<a href="javascript:;" onclick="item_setnumber(' . $o_term->getItemId ( $i ) . ',' . $n_down . ')">下移</a>
					                </td>
					            </tr>
			';
			$o_temp=new SurveyOption();
			$o_temp->PushWhere ( array ('&&', 'ItemId', '=', $o_term->getItemId($i) ) );
			$o_temp->PushOrder ( array ('Number', 'A' ) );
			$n_count_temp = $o_temp->getAllCount ();
			$s_temp='';
			for($j = 0; $j < $n_count_temp; $j ++) {
				$s_temp.=$o_temp->getNumber($j).'.'.$o_temp->getContent($j).'<br/>';
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
					                
					                <td align="center" >
					                  
					                </td>
					                <td align="center" >
					                  
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
					                
					                <td width="40">
					                   分值
					                </td>
					                <td width="80">
					                  类型
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
<table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    <select name="Vcl_Type" id="Vcl_Type" style="font-size:16px;" onchange="location='item.php?id='+$('#Vcl_Type').val()">
			                    <?php 
			                    $o_table=new SurveySubject();
			                    $o_table->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
								$o_table->PushOrder ( array ('Title', 'A' ) );
								
								$n_count=$o_table->getAllCount();
								if ($_GET['id']>0)
								{
									
								}else{
									$_GET['id']=$o_table->getId(0);
								}
								for($i=0;$i<$n_count;$i++)
								{
									echo('<option value="'.$o_table->getId($i).'">'.$o_table->getTitle($i).'</option>');
								}
			                    ?>	
								</select>
								
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <div style="padding-top:5px;padding-bottom:15px;">
			    <input value="添加单选题" class="BigButtonC" 
				onclick="location='item_single_add.php?id=<?php echo($_GET['id'])?>'" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;<input value="添加多选题" class="BigButtonC"
				onclick="location='item_multi_add.php?id=<?php echo($_GET['id'])?>'" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;<input value="添加评分题" class="BigButtonC"
				onclick="location='item_score_add.php?id=<?php echo($_GET['id'])?>'" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;<input value="添加问答题" class="BigButtonC"
				onclick="location='item_answer_add.php?id=<?php echo($_GET['id'])?>'" type="button" />
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
