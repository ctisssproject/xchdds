<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 97 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$O_Session->ValidModuleForPage(MODULEID);

function getList($id) 
{
		$o_term = new Base_Group();
		$o_term->PushOrder ( array ('Id', 'A' ) );
		$n_count = $o_term->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			//先显示部门
			$s_memeber='';
			$o_temp=new View_Group_Dept_Member();
			$o_temp->PushWhere ( array ('&&', 'Type', '=', 'Dept' ) );
			$o_temp->PushWhere ( array ('&&', 'GroupId', '=', $o_term->getId($i) ) );
			$o_temp->PushOrder ( array ('Name', 'A' ) );
			for($j=0;$j<$o_temp->getAllCount();$j++)
			{
				$s_memeber.=$o_temp->getName($j).'、';
			}
			$o_temp=new View_Group_User_Member(); 
			$o_temp->PushWhere ( array ('&&', 'Type', '=', 'User' ) );
			$o_temp->PushWhere ( array ('&&', 'GroupId', '=', $o_term->getId($i) ) );
			$o_temp->PushOrder ( array ('Name', 'A' ) );
			for($j=0;$j<$o_temp->getAllCount();$j++)
			{
				$s_memeber.=$o_temp->getName($j).'、';
			}
			//去掉最后一个顿号
			if (strlen($s_memeber)>0)
			{
				$s_memeber=substr($s_memeber,0,strlen($s_memeber)-3);
			}
			$s_type='';
			if ($o_term->getType($i)=='Dept')
			{
				$s_type='学校分组';
			}else{
				$s_type='用户分组';
			}
			$s_record_list .= '
				             <tr class="TableLine1">
				             		<td align="center" style="font-size:14px">
					                   '.($i+1).'
					                </td>
					                <td align="center" >
					                  	'.$o_term->getName($i).'
					                </td>	
					                <td align="center" >
					                  '.$s_type.'
					                </td>				                
					                <td align="center" >
					                  '.$s_memeber.'
					                </td>
					                <td align="center" nowrap="nowrap">
					                    <a href="group_edit.php?id='.$o_term->getId($i).'">编辑</a>&nbsp;&nbsp;<a href="javascript:delete_group('.$o_term->getId($i).')" class="red">删除</a>
					                </td>
					            </tr>
			';
		}
		$s_html = '
			    
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center"  width="60">
					                    序号 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                    
					                </td>
					                <td width="150">
					                  分组名称
					                </td>
					                <td width="150">
					                  分组类型
					                </td>
					                <td >
					                   组内成员
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
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/common.fun.js"></script>
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/ajax_post.class.js"></script>
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/ajax.class.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
</head>

<body class="bodycolor" topmargin="0" style="padding-left:10px;padding-right:10px;padding-top:5px;color:#333333">
<div style="padding-bottom:5px;">
<a class="column_bottom_off" href="group_add.php">添加分组</a>
</div>
<?php
echo (getList());
?>
<script type="text/javascript" language="javascript">
	S_Root='../../';
	parent.parent.parent.Common_CloseDialog();
    </script>
</body>
</html>