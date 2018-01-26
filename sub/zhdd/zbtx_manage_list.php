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
		$o_term = new Zhdd_Zbtx_Project();
		$o_term->PushWhere ( array ('&&', 'IsDelete', '=', 0) );
		$o_term->PushOrder ( array ('State', 'A' ) );
		$o_term->PushOrder ( array ('CreateDate', '' ) );
		$n_count = $o_term->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			//状态
			$s_state='<span style="color:#FF6600">未发布</span>';
			if ($o_term->getState($i)==1)
			{
				$s_state='<span style="color:#339900">已发布</span>';
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
			$a_button='';
			$a_add_button='';
			//根据权限 判断按钮显示，杜学科36，督学科管理员39，责任督学37
			if (have_role(39))
			{
				$a_add_button='<input value="添加" class="BigButtonB" onclick="location=\'zbtx_manage_project_modify.php\'" type="button" />';
				$a_button='<a href="javascript:;" onclick="location=\'zbtx_manage_project_modify.php?id='.$o_term->getId ( $i ).'\'">修改</a>&nbsp;&nbsp;<a href="javascript:;" onclick="location=\'zbtx_manage_edit_list.php?id='.$o_term->getId ( $i ).'\'">编辑内容</a>&nbsp;&nbsp;<a href="javascript:;" onclick="zbtx_manage_project_release('.$o_term->getId ( $i ).')">发布</a>&nbsp;&nbsp;<a style="color:red" href="javascript:;" onclick="zbtx_manage_project_delete('.$o_term->getId ( $i ).')">删除</a>';
				if($o_term->getState($i)==1)
				{
					$a_button='<a href="javascript:;" onclick="location=\'zbtx_manage_list_school.php?id='.$o_term->getId ( $i ).'\'">查看</a>';
				}
			}	
			if (have_role(36))
			{
				$a_add_button='';
				$a_button='<a href="javascript:;" onclick="location=\'zbtx_manage_project_modify.php?id='.$o_term->getId ( $i ).'\'">修改</a>&nbsp;&nbsp;<a href="javascript:;" onclick="location=\'zbtx_manage_edit_list.php?id='.$o_term->getId ( $i ).'\'">编辑内容</a>&nbsp;&nbsp;<a href="javascript:;" onclick="zbtx_manage_project_release('.$o_term->getId ( $i ).')">发布</a>';
				if($o_term->getState($i)==1)
				{
					$a_button='<a href="javascript:;" onclick="location=\'zbtx_manage_list_school.php?id='.$o_term->getId ( $i ).'\'">查看</a>';
				}
			}
			if (have_role(37))
			{
				$a_add_button='';
				$a_button='';
				if($o_term->getState($i)==1)
				{
					$a_button='<a href="javascript:;" onclick="location=\'zbtx_manage_list_school.php?id='.$o_term->getId ( $i ).'\'">查看</a>';
				}
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
			                    &nbsp;&nbsp;&nbsp;&nbsp;'.$a_add_button.'
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
