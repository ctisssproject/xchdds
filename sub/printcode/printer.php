<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 40001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/bn_session.class.php';
require_once 'include/db_table.class.php';
//$O_Session->ValidModuleForPage(MODULEID);
$file_name = 'out.html';
$S_Filename = '家长编号打印.html';
$rename = rawurlencode ( $S_Filename );
Header ( "Content-type: application/octet-stream" );
header ( 'content-type:text/html; charset=utf-8' );
Header ( "Accept-Ranges: bytes" );
Header ( "Content-Type: application/force-download" ); //强制浏览器下载
Header ( "Content-Disposition: attachment; filename=" . $rename ); //重命名文件
Header ( "Accept-Length: " . filesize ( $file_name ) ); //文件大小
	// 读取文件内容
@readfile ($file_name ); //加@不输出错误信息
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="">
body 
{
	margin:0px;
	padding:0px;
	font-size:18px;
}
table
{
	width:100%;
	}
table td
{
	padding:6px;
	border-bottom:1px #000000 dashed;
	padding-left:50px;
	}
</style>
</head>
<body>
<?php
$n_page=floor($_GET['sum']/30);
//echo($n_page);
?>
<table>
<?php 
$n_start=10000000;
$n_end=99999999;

for($i=0;$i<$_GET['sum'];$i++)
{
	$code1=rand($n_start,$n_end).rand($n_start,$n_end);
	$o_save=new SurveyCode();
	$o_save->setCode($code1);
	$o_save->setType($_GET['type']);
	$o_save->Save();
	echo('<tr><td style="width:50%">');
	echo(iconv ( 'UTF-8', 'gbk', '学校编号：'.$_GET['school'] )); 
	echo('</td><td style="width:50%">');
	echo(iconv ( 'UTF-8', 'gbk', '序列号：'.$code1 )); 
	echo('</td></tr>');
}
?>
</table>
<?php

?>
</body>
</html>