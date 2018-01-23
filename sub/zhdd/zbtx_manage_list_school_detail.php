<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 31001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);

function getList() 
{
		$o_result=new Zhdd_Zbtx_Result($_GET['id']);
		$o_term = new Zhdd_Zbtx_Level1();
		$o_term->PushWhere ( array ('&&', 'ProjectId', '=', $o_result->getProjectId()) );
		$o_term->PushWhere ( array ('&&', 'IsDelete', '=', 0) );
		$o_term->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_term->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			//一级指标
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center">
					                    <b>' . $o_term->getName ( $i ) . '</b>
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
					                	<b>' . $o_level2->getName ( $j ) . '</b>
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
					//判断按钮
					$s_button='';
					if ($o_result->getState(0)==0)
					{
						$s_button='
							<a href="javascript:;" onclick="location=\'zbtx_school_task_upload_add.php?id='.$o_level3->getId ( $k ).'\'">上传资料</a>
						';
					}
					$s_record_list .= '
					             <tr class="TableLine1">
						                <td align="center">					                    
						                </td>
						                <td align="center" >						                	
						                </td>
						                <td>
						                	' . $o_level3->getName ( $k ) . '
						                </td>
						                <td align="center" >
						                	' . $o_level3->getScore ( $k ) . '
						                </td>
						            </tr>
					';
					$o_doc=new Zhdd_Zbtx_Doc();
					$o_doc->PushWhere ( array ('&&', 'Level3Id', '=', $o_level3->getId ( $k )) );
					$o_doc->PushWhere ( array ('&&', 'ResultId', '=', $o_result->getId ()) );
					$o_doc->PushWhere ( array ('&&', 'IsDelete', '=', 0) );
					$o_doc->PushOrder ( array ('Number', 'A' ) );
					for($z=0;$z<$o_doc->getAllCount();$z++)
					{
						$s_record_list .= '
						             <tr class="TableLine1">
							                <td align="center">		
							                		                    
							                </td>
							                <td align="center" >						                	
							                </td>
							                <td>
							                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.RELATIVITY_PATH.$o_doc->getPath($z).'" target="_blank">'.$o_doc->getExplain($z).'</a>
							                </td>
							                <td align="center" >
							                	
							                </td>
							            </tr>
						';	
					}					
				}
			}
		}
		$s_html = '
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">			                    
				<input value="返回" class="BigButtonB"
				onclick="location=\'zbtx_manage_list_school.php?id='.$o_result->getProjectId().'\'" type="button" style="float:right"/>
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
					                <td style="width:80px;">
					                   分值
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
