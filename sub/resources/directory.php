<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 70002);
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/it_showpage.class.php';
$O_Session->ValidModuleForPage(MODULEID);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link href="../../css/common.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />

</head>
<frameset id="mainFrameset" cols="200,*" rows="*"><frame
src="directory_navigation.php" 
frameBorder="0" style="border-right: 1px solid #C0BFBF;"><frame 
src="directory_explorer.php" 
frameBorder="0" style="border-left: 1px solid #C0BFBF;"><NOFRAMES></NOFRAMES></frameset>
</html>