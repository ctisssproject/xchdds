<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 31001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);
$o_user_role=new Base_User_Role($O_Session->getUid());
function have_role($n_role_id)
{
	global $o_user_role;
	if ($o_user_role->getRoleId()==$n_role_id)
	{
		return true;
	}
	if ($o_user_role->getSecRoleId1()==$n_role_id)
	{
		return true;
	}
	if ($o_user_role->getSecRoleId2()==$n_role_id)
	{
		return true;
	}
	if ($o_user_role->getSecRoleId3()==$n_role_id)
	{
		return true;
	}
	if ($o_user_role->getSecRoleId4()==$n_role_id)
	{
		return true;
	}
	if ($o_user_role->getSecRoleId5()==$n_role_id)
	{
		return true;
	}
	return false;
}
function getList() 
{
		require_once 'include/db_table.class.php';
		$o_term = new Zhdd_Zbtx_Result_View();
		$o_term->PushWhere ( array ('&&', 'ProjectId', '=', $_GET['id']) );
		$o_term->PushOrder ( array ('DeptName', 'A' ) );
		$o_term->PushOrder ( array ('CreateDate', 'D' ) );
		$s_deptname='';
		for($i = 0; $i < $o_term->getAllCount (); $i ++) {
			if ($o_term->getDeptName($i)==$s_deptname)
			{
				continue;
			}
			$s_deptname=$o_term->getDeptName($i);
			//根据权限 判断按钮显示，杜学科36，督学科管理员39，责任督学37
			if (have_role(36)||have_role(39))
			{
				$s_state='<span style="color:#FF6600">已关闭</span>';
				$a_button='<a href="javascript:;" onclick="location=\'zbtx_manage_list_school_detail.php?id='.$o_term->getId($i).'\'">查看详情</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" style="color:#339900" onclick="zbtx_manage_list_school_open('.$o_term->getId ( $i ).')">开放</a>';
				if ($o_term->getResultState($i)==0)
				{
					$s_state='<span style="color:#339900">开放</span>';
					$a_button='<a href="javascript:;" onclick="location=\'zbtx_manage_list_school_detail.php?id='.$o_term->getId($i).'\'">查看详情</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" style="color:red" onclick="zbtx_manage_list_school_close('.$o_term->getId ( $i ).')">关闭</a>';
				}
			}else{
				$s_state='<span style="color:#FF6600">已关闭</span>';
				$a_button='<a href="javascript:;" onclick="location=\'zbtx_manage_list_school_detail.php?id='.$o_term->getId($i).'\'">查看详情</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="location=\'zbtx_manage_list_school_excel.php?id='.$o_term->getId($i).'\'" target="_blank">导出Excel</a>';
				if ($o_term->getResultState($i)==0)
				{
					$s_state='<span style="color:#339900">开放</span>';
				}
			}	
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" style="font-size:14px">
					                    ' . $o_term->getCreateDate ( $i ) . '
					                </td>
					                <td align="center" >
					                    <strong>' . $o_term->getDeptName ( $i ) . '</strong>
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
			                    <input value="返回" class="BigButtonB"
				onclick="location=\'zbtx_manage_list.php\'" type="button" style="float:right"/>
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
					                  学校名称
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
