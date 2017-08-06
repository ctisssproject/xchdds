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
        <link href="../../images/org/ui.dynatree.css" rel="stylesheet" type="text/css" />
	<link href="../../css/common.css" rel="stylesheet" type="text/css" />
<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
	<link href="../../theme/default/layout_left.css" rel="stylesheet"
	type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery.plugins.js"></script>
</head>
<body class="bodycolor" style="padding:15px;">
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					            <td align="center" >
					                    项目
					                    
					                </td>
					                <td width="200">
					                   分数
					                </td>
					        </thead>
			        <tbody>
						
				             <tr class="TableLine1">
					                <td align="center" style="font-size:14px">
					                    <strong>******</strong>
					                </td>
					                <td align="center" >
					                  100
					                </td>
					            </tr>
					          
			        </tbody>
			    </table>


<script type="text/javascript" language="javascript">
	S_Root='../../';
	parent.parent.parent.Common_CloseDialog();
    </script>
</body>
</html>
