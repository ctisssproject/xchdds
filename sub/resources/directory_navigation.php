<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 70001);
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/it_showpage.class.php';
$O_Session->ValidModuleForPage(MODULEID);
$o_tree= new ShowPage ($O_Session->getUserObject ());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link href="../../images/org/ui.dynatree.css" rel="stylesheet" type="text/css" />
    <link href="../../theme/default/layout_left.css" rel="stylesheet" type="text/css" />
    <link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/ajax.fun.js"></script>
    <script type="text/javascript" src="../../js/ajax.class.js"></script>
    <script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>
</head>
<body style="padding-top:10px">
    <table>
        <tbody>
            <tr>
                <td id="left">
                        <div id="tree">
                                    <?php echo($o_tree->getDirectoryRoot())?>
                        </div>
                </td>
            </tr>
        </tbody>
    </table>
   <input id="Vcl_FolderId" name="Vcl_FolderId"' size="30" maxlength="30" class="BigInput"' value="" type="text" style="display:none"/>
<script type="text/javascript" language="javascript">
	S_Root='../../';
	parent.parent.Common_CloseDialog()
    </script>
</body>
</html>