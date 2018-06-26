<?php
define ( 'RELATIVITY_PATH', '' ); //定义相对路径
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
require_once RELATIVITY_PATH . 'include/bn_session.class.php';
$O_Session = new Session ();
if ($O_Session->Login () == true) //如果没有注册，跳转到首页
{
	echo ('<script type="text/javascript">location=\'main.php\'</script>');
	exit (0);
}
$o_date = new DateTime ( 'Asia/Chongqing' );
$n_nowTime = $o_date->format ( 'U' );
$S_Session_Id = md5 ( $_SERVER ['REMOTE_ADDR'] . $_SERVER ['HTTP_USER_AGENT'] . rand ( 0, 9999 ) . $n_nowTime );
setcookie ( 'VISITER', '', 0 );
setcookie ( 'SESSIONID', $S_Session_Id, 0 );
setcookie ( 'VALIDCODE', '', 0 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>登录</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css"
	href="templates/2010_01/index.css" />

<script type="text/javascript" src="js/dialog.fun.js"></script>
<script type="text/javascript" src="js/common.fun.js"></script>
<script type="text/javascript" src="js/ajax.class.js"></script>
<script type="text/javascript" src="js/jsbn.js"></script>
    <script type="text/javascript" src="js/prng4.js"></script>
    <script type="text/javascript" src="js/rng.js"></script>
    <script type="text/javascript" src="js/rsa.js"></script>
</head>
<body scroll="auto" style="background-color: white">

<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=Login"
	enctype="multipart/form-data" target="ajax_submit_frame">
<div id="logo">
<div id="form">
<div class="left">
<div class="user"><input class="text" name="Vcl_UserName" id="Vcl_UserName" maxlength="20"
	onmouseover="this.focus()" onfocus="this.select()" value="" type="text" /></div>
<div class="pwd"><input class="text" name="Vcl_Password" id="Vcl_Password"
	onmouseover="this.focus()" onfocus="this.select()" value=""
	type="password" /></div>
</div>
<div class="right"><input class="submit" title="登录" value=""
	type="button" onclick="cmdEncrypt()"/></div>
</div>
<div class="msg">
<div></div>
<div></div>
<div><a href="http://www.miibeian.gov.cn/" target="_blank" style="display:none">京ICP备12345678</a></div>
</div>
</div>
</form>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0"
	src="about:blank"></iframe>
<div id="master_box"
	style="position: absolute; z-index: 2000; left: 0px; top: -500px;"></div>
<script type="text/javascript" language="javascript">
			function cmdEncrypt() {
				if (document.getElementById('Vcl_Password').value!='' && document.getElementById('Vcl_Password').value!='')
				{
					var passwd = document.getElementById('Vcl_Password').value;
				    var rsa = new RSAKey();
				    var modulus = "DB1EA572B55F5D9C8ADF092F5DCC3559CFEA8CE8BB54E3A71DA9B1AFBD7D17CF80ADB224FE4EA5379BC782F41C137748D8F1B5A36AD62A127EF5E87EFB25C209A66BCEE9925CE09631BF2271E81123E93438646625080FF04F4F2CF532B077E3E390486DF40E7586F0AE522C873F33170222F46BDB6084F55DE6B7031E55DBE7";
					var exponent = "10001";
				    rsa.setPublic(modulus, exponent);
				    var res = rsa.encrypt(passwd);
				    document.getElementById('Vcl_Password').value=res
				    document.getElementById('dialog_form').submit();
				}
			}
			checkIE();
            S_Root='';
            function autoLogin(username,password,module)
            {
                var o_ajax_request=new AjaxRequest();
                o_ajax_request.setFunction ('AutoLogin');
                o_ajax_request.setPage('include/it_ajax.svr.php');
                o_ajax_request.PushParameter(username);
                o_ajax_request.PushParameter(password);
                o_ajax_request.PushParameter(module);
                o_ajax_request.SendRequest()
                }
            function autoLoginForIndex(username,password)
            {
                var o_ajax_request=new AjaxRequest();
                o_ajax_request.setFunction ('AutoLoginForIndex');
                o_ajax_request.setPage('include/it_ajax.svr.php');
                o_ajax_request.PushParameter(username);
                o_ajax_request.PushParameter(password);
                o_ajax_request.SendRequest()
                }
           	function autoLoginCallBack(module)
           	{
               	if (module>=0)
               	{
               		window.open('main.php?module='+module,'_parent')
                   	}else
                   	{
                   		Dialog_Error("对不起！<br/>用户名或密码错误！")
                       	}
           		
               	}
            <?php 
            if (isset($_GET['username']))
            {            
            	if (isset($_GET['module']))
            	{
            		//AM自动登录
            		echo('autoLogin(\''.$_GET['username'].'\',\''.$_GET['password'].'\','.$_GET['module'].');Common_OpenLoading();');
            	}else
            	{
            		//门户登录
            		echo('autoLoginForIndex(\''.$_GET['username'].'\',\''.$_GET['password'].'\');Common_OpenLoading();');
            	}	
            }
            ?>
</script>
</body>
</html>
