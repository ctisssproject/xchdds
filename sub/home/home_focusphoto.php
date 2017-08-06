<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 67 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/it_showpage.class.php';
$O_Session->ValidModuleForPage(MODULEID);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>
</head>
<body class="bodycolor" topmargin="0">
<?php
$o_scroll = new ShowPage ( $O_Session->getUserObject ());
echo ($o_scroll->getFocusPhoto ( ));
?>
    <script>
    S_Root='../../';
    </script>
</body>
</html>
