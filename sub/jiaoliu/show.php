<?php
define ( 'RELATIVITY_PATH', '../../' );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_table.class.php';
if (is_numeric ( $_GET ['id'] ) && $_GET ['id'] > 0) {
	$n_id = $_GET ['id'];
} else {
	exit ( 0 );
}
$o_article=new Jiaoliu_Article($n_id);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../css/common.css" rel="stylesheet" type="text/css" />
<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<link href="css/style.css" rel="stylesheet"
	type="text/css" />
	
<link href="../../css/editor.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/editor.fun.js"></script>
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>
</head>
<body class="bodycolor">
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="900" align="center" style="margin-top: 10px">
	<tbody>
		<tr>
			<td><img src="../../images/notify_new.gif" align="absmiddle" /><span
				class="big3"> 查看文章</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="900"
	style="margin-top: 10px">
	<tbody>		
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">标题：</td>
			<td class="TableData fuja" align="center" style="font-size:16px;font-weight:bold"><?php
				echo ($o_article->getTitle ());
				?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">发布日期：</td>
			<td class="TableData fuja"><?php
				echo ($o_article->getDate ());
				?></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">发布人：</td>
			<td class="TableData fuja"><?php
				$o_user=new Single_User($o_article->getUid ());
				echo ($o_user->getName ());
				?></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">发布单位：</td>
			<td class="TableData fuja"><?php
				echo ($o_article->getDept ());
				?></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">学校参与人员：</td>
			<td class="TableData fuja"><?php
				echo ($o_article->getSchoolJoin ());
				?></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">督学参与人员：</td>
			<td class="TableData fuja"><?php
				echo ($o_article->getDuxueJoin ());
				?></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"
				style="vertical-align: top;">内容：</td>
			<td class="TableData" style="font-size:16px;"><?php
			echo($o_article->getContent () );
			?></td>
		</tr>	
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">意见建议：</td>
			<td class="TableData fuja"><?php
				echo ($o_article->getFeedback ());
				?></td>
		</tr>	
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" style="padding: 10px"><input value="返回" class="BigButtonA"
				onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>';" type="button" /></td>
		</tr>
	</tbody>
</table>
<br></br>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<script type="text/javascript" language="javascript">
	S_Root='../../';
    </script>
<div id="master_box"
	style="position: absolute; z-index: 2000; left: 0px; top: -500px;">
</div>
</body>
</html>
