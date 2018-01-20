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
		$o_term = new Zhdd_Zbtx_Project();
		$o_term->PushWhere ( array ('&&', 'IsDelete', '=', 0) );
		$o_term->PushWhere ( array ('&&', 'State', '>=', 1) );
		$o_term->PushOrder ( array ('CreateDate', '' ) );
		$n_count = $o_term->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			//状态
			$s_state='<span style="color:#339900">开放</span>';
			if ($o_term->getState($i)==2)
			{
				$s_state='<span style="color:red">已关闭</span>';
			}
			//构建范围
			$s_scorp='';
			$a_scorp=json_decode($o_term->getScope($i));
			for($j=0;$j<count($a_scorp);$j++)
			{
				$o_type=new Base_School_Type($a_scorp[$j]);
				$s_scorp.=$o_type->getName();
				if (($j+1)<count($a_scorp))
				{
					$s_scorp.='、';
				}
			}
			//判断按钮
			$a_button='<a href="javascript:;" onclick="location=\'zbtx_school_task_upload.php?id='.$o_term->getId ( $i ).'\'">上传资料</a>';
			if($o_term->getState($i)==2)
			{
				$a_button='<a href="javascript:;" onclick="location=\'zbtx_manage_project_show.php?id='.$o_term->getId ( $i ).'\'">查看</a>';
			}
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" style="font-size:14px">
					                    ' . $o_term->getCreateDate ( $i ) . '
					                </td>
					                <td align="center" >
					                    <strong>' . $o_term->getName ( $i ) . '</strong>
					                </td>
					                <td align="center" >
					                   ' . $o_term->getExplain ( $i ) . '
					                </td>
					                <td align="center" >
					                   ' . $s_scorp . '
					                </td>
					                <td align="center" >
					                   ' . $s_state . '
					                </td>
					                <td align="center">
					                    '.$a_button.'
					                </td>
					            </tr>
			';
		}
		$s_html = '
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    &nbsp;&nbsp;&nbsp;&nbsp;共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;个指标体系
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td style="man-width:150px;">
					                    建立日期 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle"> 
					                </td>
					                <td style="min-width:200px;">
					                  标题
					                </td>
					                <td style="max-width:150px;">
					                   说明
					                </td>
					                <td style="max-width:150px;">
					                   测评范围
					                </td>
					                <td style="max-width:100px;">
					                   状态
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
