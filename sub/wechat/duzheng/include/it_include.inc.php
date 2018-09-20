<?php
if(isset($RELATIVITY_PATH))
{
	//如果相对路径设置过，那么相对路径改为设置的值，否则用默认值
	define ( 'RELATIVITY_PATH',$RELATIVITY_PATH);
}else{	define ( 'RELATIVITY_PATH', '../../' );
}
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
?>