<?php
if (!isset($_GET['fileid']))
{
	exit(0);
}
define ( 'RELATIVITY_PATH', '../../' ); //定义相对路径
require_once RELATIVITY_PATH . 'include/bn_session.class.php';
$O_Session = new Session ();
//判断该文件是否有下载的权限
require_once 'include/db_table.class.php';

$o_file=new Netdisk_File($_GET['fileid']);
$file_name = $o_file->getOriginalFilename();
$file_dir = RELATIVITY_PATH.$o_file->getPath().'/';
$rename =  rawurlencode($o_file->getFilename());
if (!file_exists($file_dir . $file_name)) { //检查文件是否存在
echo "对不起,您要下载的文件不存在";
exit;
} else {
// 一下是php文件下载的重点
Header("Content-type: application/octet-stream");
Header("Accept-Ranges: bytes");
Header("Content-Type: application/force-download");//强制浏览器下载
Header("Content-Disposition: attachment; filename=" . $rename);//重命名文件
Header("Accept-Length: ".filesize($file_dir . $file_name));//文件大小
// 读取文件内容
@readfile($file_dir.$file_name);//加@不输出错误信息
} 
?>