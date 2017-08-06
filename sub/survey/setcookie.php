<?php
error_reporting(0);
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
$s_temp= rawurldecode($_GET['already']);
$s_temp=str_replace('\\', '', $s_temp);
//echo($s_temp);
setcookie ( 'ALREADY', $s_temp, 0 );
?>
<script>location='<?php echo(rawurldecode($_GET['url']))?>'</script>