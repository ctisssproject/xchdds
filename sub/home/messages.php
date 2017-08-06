<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 731 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$O_Session->ValidModuleForPage ( MODULEID );
require_once 'include/it_showpage.class.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
</head>
<body class="bodycolor" topmargin="0">
<?php
$o_unread = new ShowPage ( $O_Session->getUserObject ());

if (is_numeric ( $_GET ['page'] )) {
	$o_page = $_GET ['page'];
} else {
	$o_page = 1;
}
echo ($o_unread->getMessages ( $o_page ));
?>
    <script>
    S_Root='../../';
    </script>
</body>
</html>
