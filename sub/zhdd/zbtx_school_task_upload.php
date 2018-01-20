<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 31002 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);
function getList() 
{
		require_once 'include/db_table.class.php';
		$o_term = new Zhdd_Zbtx_Level1();
		$o_term->PushWhere ( array ('&&', 'ProjectId', '=', $_GET['id']) );
		$o_term->PushWhere ( array ('&&', 'IsDelete', '=', 0) );
		$o_term->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_term->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			//一级指标
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center">
					                    ' . $o_term->getName ( $i ) . '
					                </td>
					                <td align="center" >
					                </td>
					                <td align="center" >
					                </td>
					                <td align="center" >
					                </td>
					                <td align="center" >
					                	
					                </td>
					            </tr>
			';
			$o_level2 = new Zhdd_Zbtx_Level2();
			$o_level2->PushWhere ( array ('&&', 'Level1Id', '=', $o_term->getId($i)) );
			$o_level2->PushWhere ( array ('&&', 'IsDelete', '=', 0) );
			$o_level2->PushOrder ( array ('Number', 'A' ) );
			for($j = 0; $j < $o_level2->getAllCount (); $j ++) {
				$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center">					                    
					                </td>
					                <td align="center" >
					                	' . $o_level2->getName ( $j ) . '
					                </td>
					                <td align="center" >
					                </td>
					                <td align="center" >
					                </td>
					                <td align="center" >
					                	
					                </td>
					            </tr>
				';
				$o_level3 = new Zhdd_Zbtx_Level3();
				$o_level3->PushWhere ( array ('&&', 'Level2Id', '=', $o_level2->getId($j)) );
				$o_level3->PushWhere ( array ('&&', 'IsDelete', '=', 0) );
				$o_level3->PushOrder ( array ('Number', 'A' ) );
				for($k = 0; $k < $o_level3->getAllCount (); $k ++) {
					$s_record_list .= '
					             <tr class="TableLine1">
						                <td align="center">					                    
						                </td>
						                <td align="center" >						                	
						                </td>
						                <td align="center" >
						                	' . $o_level3->getName ( $k ) . '
						                </td>
						                <td align="center" >
						                	' . $o_level3->getScore ( $k ) . '
						                </td>
						                <td align="center" >
						                	<a href="javascript:;" onclick="location=\'zbtx_manage_task_upload_add.php?id='.$o_level3->getId ( $k ).'\'">上传资料</a>
						                </td>
						            </tr>
					';
				}
			}
		}
		$s_html = '
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">			                    
				<input value="返回" class="BigButtonB"
				onclick="location=\'zbtx_school_task.php\'" type="button" style="float:right"/>
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td style="min-width:150px;">
					                    一级指标
					                </td>
					                <td style="min-width:200px;">
					                  二级指标
					                </td>
					                <td style="min-width:150px;">
					                   三级指标
					                </td>
					                <td style="min-width:150px;">
					                   分值
					                </td>
					                <td align="center" style="min-width:100px;">
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
<?php
echo (getList());
?>
<script type="text/javascript" language="javascript">
	S_Root='../../';
	parent.parent.parent.Common_CloseDialog();
    </script>
</body>
</html>
