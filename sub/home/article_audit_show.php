<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 96 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_view.class.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
if (is_numeric ( $_GET ['articleid'] ) && $_GET ['articleid'] > 0) {
	$n_articleid = $_GET ['articleid'];
} else {
	echo ('<script>location=\'article_audit.php\'</script>');
	exit ( 0 );
}
$o_article = new View_Home_Article ( $n_articleid );
if ($o_article->getTitle () == false || $o_article->getDelete ()==1 || $o_article->getAudit()!=1) {
	echo ('<script>location=\'article_audit.php\'</script>');
	exit ( 0 );
}
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
				class="big3"> 文章审核</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="900"
	style="margin-top: 10px">
	<tbody>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">一级栏目：</td>
			<td class="TableData">
				<?php
				if ($o_article->getParent () != 0) {
					$s_columnid = $o_article->getParent ();
				} else {
					$s_columnid = $o_article->getColumnId ();
				}
				$o_column = new Home_Column ();
				$o_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_column->PushWhere ( array ('&&', 'Parent', '=', 0 ) );
				$o_column->PushWhere ( array ('&&', 'Url', '=', '' ) );
				$o_column->PushOrder ( array ('Number', 'A' ) );
				for($i = 0; $i < $o_column->getAllCount (); $i ++) {
					if ($s_columnid == $o_column->getColumnId ( $i )) {
						echo ($o_column->getName ( $i ));
						break;
					} 
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">二级栏目：</td>
			<td class="TableData">
			<?php
			$o_column = new Home_Column ();
			$o_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_column->PushWhere ( array ('&&', 'Parent', '=', $s_columnid ) );
			$o_column->PushOrder ( array ('Number', 'A' ) );
			for($i = 0; $i < $o_column->getAllCount (); $i ++) {
				if ($o_article->getColumnId () == $o_column->getColumnId ( $i )) {
					echo ( $o_column->getName ( $i ));
				} 
			}
			?>
			</td>
		</tr>
		<?php 
		if ($o_article->getTagId()>0)
		{
			?>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">标签：</td>
			<td class="TableData">
			<?php
			$o_column = new Home_Column_Tags($o_article->getTagId());
			echo($o_column->getName());
			?>
			</td>
		</tr>	
			<?php
		}
		?>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">文章标题：</td>
			<td class="TableData fuja" align="center" style="font-size:16px;font-weight:bold"><?php
				echo ($o_article->getTitle ());
				?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120"
				style="vertical-align: top;">文章内容：</td>
			<td class="TableData"><?php
			echo($o_article->getContent () );
			?></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">状态：</td>
			<td class="TableData">
				<?php
				if ($o_article->getState () == 1) {
					echo ('<span class="green">开放</span>');
				} else {
					('<span class="red">关闭</span>');
				}
				?>
			</td>
		</tr>
		<tr class="TableControl" align="center">
			<td colspan="2" nowrap="nowrap" style="padding: 10px">
			<input type="hidden" id="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input value="退回" class="BigButtonA" onclick="showArticleReturn(<?php echo($o_article->getArticleId ())?>)" type="button" />
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input value="通过" class="BigButtonB" onclick="articleAudit(<?php echo($o_article->getArticleId ())?>)" type="button" />
			&nbsp;&nbsp;&nbsp;&nbsp;<input value="返回" class="BigButtonA"
				onclick="location='article_audit.php';" type="button" /></td>
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
