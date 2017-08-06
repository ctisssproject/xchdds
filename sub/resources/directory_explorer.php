<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 70002);
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/db_table.class.php';
require_once 'include/it_showpage.class.php';
$O_Session->ValidModuleForPage(MODULEID);
$o_tree= new ShowPage ($O_Session->getUserObject ());
if (is_numeric( $_GET ['folderid'] )) {
	$n_folder = $_GET ['folderid'];
} else {
	$n_folder = 0;
}
$o_folder=new Netdisk_Folder($n_folder);
if ($o_folder->getFolderName()==FALSE)
{
	$s_up_button='';
}else{
	$s_up_button='<td>
                	<div class="up" onclick="goUpDirectory('.$o_folder->getParentId().')">
                	</div>
            	</td>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
	<link href="../../css/common.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../js/jquery/jquery.min.js"></script>

    <script type="text/javascript" src="../../js/jquery/jquery-ui.custom.min.js"></script>

    <script type="text/javascript" src="../../js/jquery/jquery.ui.autocomplete.min.js"></script>

    <script type="text/javascript" src="../../js/jquery/jquery.effects.bounce.min.js"></script>

    <script type="text/javascript" src="../../js/jquery/jquery.cookie.js"></script>

    <script type="text/javascript" src="../../js/jquery/jquery.plugins.js"></script>

<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="js/folder_operate.js"></script>
<script type="text/javascript" src="js/file_operate.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>

    <link rel="stylesheet" type="text/css" href="../../theme/default/diary.css" />
</head>
<body class="bodycolor" style="padding:0px; margin:0px">
    <table border="0" cellpadding="0" cellspacing="0" class="folder_top">
        <tr>
            <?php echo($s_up_button)?>
            <td>
                <div class="folder" onclick="FolderNew(<?php echo($n_folder)?>)">
                </div>
            </td>
            <td>
                <div class="copy" onclick="document.getElementById('filelist').contentWindow.copyAndMoveAll('copy')">
                </div>
            </td>
            <td style="width:90%; text-align:right; font-family:宋体">
            
            </td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="folder_title">
        <tr>
            <td>
                <input id="Checkbox1" type="checkbox" onclick="document.getElementById('filelist').contentWindow.selectAll(this)"/> 全选
            </td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" id="center" style="width: 100%">
        <tr>
            <td>
                <iframe id="filelist" src="directory_filelist.php?folderid=<?php echo($n_folder);?>" marginwidth="0" marginheight="0" frameborder="0" framespacing="0"
                    border="0" allowtransparency="true"></iframe>
            </td>
        </tr>
    </table>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<div id="master_box"
	style="position: absolute; z-index: 2000; left: 0px; top: -500px;">
</div>
    <script type="text/javascript">
    resizeLayout()
     $(window).resize(function(){resizeLayout();});
    </script>

</body>
</html>