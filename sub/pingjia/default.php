<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 60001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$O_Session->ValidModuleForPage(MODULEID);
if (is_numeric ( $_GET ['page'] )) {
	$o_page = $_GET ['page'];
} else {
	$o_page = 1;

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link rel="stylesheet" type="text/css"
	href="<?php echo(RELATIVITY_PATH)?>css/common.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div class="ge_table_header" style="font-size:30px;padding:50px;">
           请点击左侧导航
        </div>

<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<div id="master_box"
	style="position: absolute; z-index: 2000; left: 0px; top: -500px;">
</div>
<script type="text/javascript" language="javascript">
	S_Root='../../';
	parent.parent.Common_CloseDialog();
    </script>
</body>
</html>
