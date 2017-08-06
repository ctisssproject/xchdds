<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 10004 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
	require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);
function getList() 
{
	require_once 'include/db_table.class.php';
		$o_term = new ViewSurveyDept ();
		$o_term->PushWhere ( array ('&&', 'Id', '>', 0 ) );
		$o_term->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_term->PushOrder ( array ('Type', 'A' ) );
		$o_term->PushOrder ( array ('Id', 'A' ) );
		$n_count = $o_term->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" style="font-size:14px">
					                    ' . $o_term->getId ( $i ) . '
					                </td>
					                <td align="center" >
					                    <strong>' . $o_term->getName ( $i ) . '</strong>
					                </td>
					                <td align="center" >
					                    ' . $o_term->getTypeName ( $i ) . '
					                </td>
					                <td align="center" >
					                    ' .$o_term->getTeacherName ( $i ) . '
					                </td>
					                <td align="center" >
					                    <a href="javascript:;" onclick="location=\'dept_modify.php?id='.$o_term->getId($i).'\'">修改</a>&nbsp;&nbsp;&nbsp;<a href="javascript:;" style="color:red" onclick="dept_delete('.$o_term->getId($i).')">禁用</a>
					                </td>
					            </tr>
			';
		}
		$s_html = '
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    &nbsp;&nbsp;&nbsp;&nbsp;共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;个单位
			                    &nbsp;&nbsp;&nbsp;&nbsp;<input value="添加单位" class="BigButtonB"
				onclick="location=\'dept_add.php\'" type="button" />
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center" width="150">
					                    单位编号 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle"> 
					                </td>
					                <td>
					                   单位名称
					                </td>
					                <td>
					                   类型
					                </td>
					                <td>
					                  责任督学
					                </td>
					                <td>
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
<?php
echo (getList());
?>
<script type="text/javascript" language="javascript">
	S_Root='../../';
	parent.parent.parent.Common_CloseDialog();
    </script>
</body>
</html>
