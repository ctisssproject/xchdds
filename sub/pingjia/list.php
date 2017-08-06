<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 60001);
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$O_Session->ValidModuleForPage(MODULEID);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link href="../../css/common.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">var S_Key='';</script>
</head>
<frameset id="mainFrameset" cols="250,*" rows="*"><frame
src="list_navigation.php" 
frameBorder="0" style="border-right: 1px solid #C0BFBF;"><frame 
src="default.php" 
frameBorder="0" style="border-left: 1px solid #C0BFBF;"><NOFRAMES></NOFRAMES></frameset>
</html>