<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 73 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/it_showpage.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
$o_typenav = new ShowPage ( $O_Session->getUserObject () );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
    <link rel="stylesheet" type="text/css" href="../../theme/default/style.css" />
 <link href="../../theme/default/layout_left.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../../theme/default/bjsql.css" />

    <script type="text/javascript" src="../../js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/desktop.fun.js"></script>

</head>
<body class="bodycolor">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td id="left">
                    <div class="Big" style="padding-top: 15px; padding-bottom: 15px">
                        <img src="../../images/document/draft.gif" align="absmiddle"/>&nbsp;&nbsp;<input class="BigButtonB" onclick="document.getElementById('diary_body').src='article_add.php'" value="发布文章" type="button"/>
                    </div>
                    <?php echo($o_typenav->getColumnForArticle());?>
                </td>
                <td id="right">
                <div id="center">
                    <iframe id="diary_body" name="diary_body" src="<?php echo($o_typenav->getHomePage());?>" onload="jQuery(window).triggerHandler('resize');"
                        border="0" framespacing="0" marginheight="0" marginwidth="0" style="width: 100%;" frameborder="0"></iframe>
                </div>
                </td>
            </tr>
        </tbody>
    </table>
    <script type="text/javascript" language="javascript">
	S_Root='../../';
    </script>
</body>
</html>