<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30001 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_table.class.php';
require_once 'include/db_view.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
$o_table = new View_Telephone_Info ($_GET['id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<link type="text/css" rel="stylesheet" href="../../module/DatePicker/skin/WdatePicker.css" />
<script type="text/javascript" src="../../module/DatePicker/WdatePicker.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
</head>
<body class="bodycolor">
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=RecordAdd"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="800" align="center" style="margin-top:10px">
	<tbody>
		<tr>
			<td><img src="../../images/folder_common.gif" align="absmiddle" /><span
				class="big3"> 记录信息</span></td> 
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="800" style="margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" colspan="4" nowrap="nowrap" style="font-size:14px" align="center"><strong>基本信息</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"><strong>日期：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getRecordDate().' '.$o_table->getRecordTime())?>
			</td>
			<td class="TableData" nowrap="nowrap" width="120"><strong>记录人：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getUserName())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" colspan="4" nowrap="nowrap" style="font-size:14px" align="center"><strong>来电人信息</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"><strong>姓名：</strong></td>
			<td class="TableData">
			<?php echo($o_table->getName())?>
			</td>
			<td class="TableData" nowrap="nowrap" width="120"><strong>性别：</strong></td>
			<td class="TableData">
				<?php echo($o_table->getSex())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"><strong>来源学校：</strong></td>
			<td class="TableData">
				<?php echo($o_table->getSchoolName())?>
			</td>
			<td class="TableData" nowrap="nowrap" width="120"><strong>身份：</strong></td>
			<td class="TableData">
				<?php echo($o_table->getProfileName())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"><strong>电话（邮箱）：</strong></td>
			<td class="TableData" colspan="3">
			<?php echo($o_table->getPhone())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"><strong>反映问题类别：</strong></td>
			<td class="TableData" colspan="3">
					<?php 
					$a_type=$o_table->getTypeId();
					$a_type=json_decode($a_type);
					$o_type=new Telephone_Type();
					$o_type->PushOrder ( array ('Name', 'A' ) );
					$n_count=$o_type->getAllCount();
					for($i=0;$i<count($a_type);$i++)
					{
						$o_type=new Telephone_Type($a_type[$i]);
						echo($o_type->getName().'<br/>');
					}
					?>
			</td>
		</tr>
		<tr>
			<td class="TableData" colspan="4" nowrap="nowrap" style="font-size:14px" align="center"><strong>记录内容</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"><strong>来电记录：</strong></td>
			<td class="TableData" colspan="3"><?php echo($o_table->getContent())?></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"><strong>处理过程及结果：</strong></td>
			<td class="TableData" colspan="3">
			<?php 
			$o_progress = new Telephone_Progress ();
			$o_progress->PushWhere ( array ('&&', 'InfoId', '=', $o_table->getId() ) );
			$n_count=$o_progress->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				$o_user=new Base_User_Info($o_progress->getUid($i));
				echo('
				时间：'.$o_progress->getDate($i).'<br/>
				内容：'.$o_progress->getContent($i).'<br/>
				登记：'.$o_user->getName().'<br/>
				<br/>
				');
			}
			?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"><strong>备注：</strong></td>
			<td class="TableData" colspan="3"><?php echo($o_table->getExplain())?></td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="4" nowrap="nowrap" height="40">
<input value="返回" class="BigButtonA"
				onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'" type="button" /></td>
		</tr>
	</tbody>
</table>
<br></br>
</form>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0" height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<script type="text/javascript" language="javascript">
	S_Root='../../';
    </script>
</body>
</html>
