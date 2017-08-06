<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 10001 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$O_Session->ValidModuleForPage ( MODULEID );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="../../theme/default/style.css" />
 <link href="../../theme/default/layout_left.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../../theme/default/bjsql.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
    <script type="text/javascript" src="../../js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="js/common.fun.js"></script>

</head>
<body class="bodycolor">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td id="left">
                    <div class="Big" style="padding-top: 15px; padding-bottom: 15px">
                        <img src="../../images/form.gif" align="absmiddle"/>&nbsp;&nbsp;<span class="big3">测评表</span>&nbsp;
                    </div>
                     <table class="BlockTop" width="100%">
                        <tbody>
                            <tr>
                                <td class="left">
                                </td>
                                <td class="center">
                                    <a href="chapter_add.php" id="custom_folder1" class="header" target="diary_body">新建测评表</a>
                                </td>
                                <td class="right">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="BlockBottom BlockBottom_user">
                        <tbody>
                            <tr>
                                <td class="left">
                                </td>
                                <td class="center">
                                    <a href="chapter_list.php" class="header" target="diary_body">测评列表</a>
                                </td>
                                <td class="right">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td id="right">
                <div id="center">
                    <iframe id="diary_body" name="diary_body" src="chapter_list.php" onload="jQuery(window).triggerHandler('resize');"
                        border="0" framespacing="0" marginheight="0" marginwidth="0" style="width: 100%;" frameborder="0"></iframe>
                </div>
                </td>
            </tr>
        </tbody>
    </table>

</body>
</html>