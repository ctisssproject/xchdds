<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 31002 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);

function getList() 
{
		global $O_Session;
		$o_user= new Base_User_Info_View($O_Session->getUid());	
		//先检查是否已经新建任务，如果没有，新建任务
		$o_result=new Zhdd_Zbtx_Result();
		$o_result->PushWhere ( array ('&&', 'DeptId', '=', $o_user->getDeptId ()) );
		$o_result->PushWhere ( array ('&&', 'ProjectId', '=', $_GET['id']) );
		$o_result->PushOrder ( array ('CreateDate', 'D' ) );
		if ($o_result->getAllCount()==0)
		{
			$o_project=new Zhdd_Zbtx_Project($_GET['id']);
			$o_result=new Zhdd_Zbtx_Result();
			$o_result->setCreateDate($o_project->getReleaseDate());
			$o_result->setOwnerId($o_user->getUid());
			$o_result->setDeptId($o_user->getDeptId());
			$o_result->setProjectId($o_project->getId());
			$o_result->Save();
		}else{
			$o_result=new Zhdd_Zbtx_Result($o_result->getId(0));
		}	
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
					                    <b>' . $o_term->getName ( $i ) . '</b>
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
					                	<b>' . $o_level2->getName ( $j ) . '</b>
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
					//判断按钮
					$s_button='';
					if ($o_result->getState()==0)
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
						                <td align="center" >
						                	'.$s_button.'
						                </td>
						            </tr>
					';
					$o_doc=new Zhdd_Zbtx_Doc();
					$o_doc->PushWhere ( array ('&&', 'Level3Id', '=', $o_level3->getId ( $k )) );
					$o_doc->PushWhere ( array ('&&', 'ResultId', '=', $o_result->getId ()) );
					$o_doc->PushWhere ( array ('&&', 'DeptId', '=', $o_user->getDeptId ()) );
					$o_doc->PushWhere ( array ('&&', 'IsDelete', '=', 0) );
					$o_doc->PushOrder ( array ('Number', 'A' ) );
					for($z=0;$z<$o_doc->getAllCount();$z++)
					{
						//判断按钮
						$s_button='';
						if ($o_result->getState()==0)
						{
							$s_button='
								<a href="javascript:;" onclick="location=\'zbtx_school_task_upload_modify.php?id='.$o_doc->getId ( $z ).'\'">修改</a>&nbsp;&nbsp;
					            <a style="color:red" href="javascript:;" onclick="zbtx_school_task_upload_delete('.$o_doc->getId ( $z ).')">删除</a>&nbsp;&nbsp;
							';
						}
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
							                <td align="center" >
							                	'.$s_button.'
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
					                <td style="width:80px;">
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
