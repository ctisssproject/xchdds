<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 10005 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
	require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);
function getList() 
{
	require_once 'include/db_table.class.php';
		$o_term = new SurveyType ();
		$o_term->PushOrder ( array ('Type', 'A' ) );
		$o_term->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_term->getAllCount ();
		$a_scope=array('幼儿园','小学 中学','校外');
		for($i = 0; $i < $n_count; $i ++) {
			
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" style="font-size:14px">
					                    ' . $o_term->getNumber ( $i ) . '
					                </td>
					                <td align="center" >
					                    <strong>' . $o_term->getName ( $i ) . '</strong>
					                </td>
					                <td align="center" >
					                   ' . $a_scope[$o_term->getType ( $i )] . '
					                </td>
					                <td align="center">
					                    <a href="javascript:;" onclick="location=\'type_modify.php?id='.$o_term->getId ( $i ).'\'">修改</a>
					                </td>
					            </tr>
			';
		}
		$s_html = '
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    &nbsp;&nbsp;&nbsp;&nbsp;共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;个测评对象
			                    &nbsp;&nbsp;&nbsp;&nbsp;<input value="添加对象" class="BigButtonB"
				onclick="location=\'type_add.php\'" type="button" />
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center" width="150">
					                    对象编号 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle"> 
					                </td>
					                <td>
					                   对象名称
					                </td>
					                <td width="100">
					                   测评
					                </td>
					                <td align="center" style="width:100px;">
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
