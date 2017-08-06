<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
header('content-type:text/html; charset=utf-8');
define('RELATIVITY_PATH', '../');//定义相对路径
require_once RELATIVITY_PATH . 'include/bn_session.class.php';
$O_Session = new Session();
$S_Function = $_GET['function'];
switch($S_Function)
{
   case 'Login':
      Login();
      break;
   case 'AmLogin':
      AmLogin();
      break;
   case 'Register':
      Register();
      break;
   case 'ValidCode':
      ValidCode();
      break;
   case 'UpLoadPicture':
      UpLoadPicture();
      break;
	case 'UploadTempFile' :
		UploadTempFile ();
		break;
	case 'UploadAffixFile' :
		UploadAffixFile ();
		break;
   default:
      break;
}
exit();
function UpLoadPicture() {
	$O_Session = new Session();
	require_once RELATIVITY_PATH . 'include/bn_user.class.php';
	$o_user = $O_Session->getUserObject ();
	$o_user->UpLoadPicture ();

}
function ValidCode()
{
   include_once RELATIVITY_PATH . 'include/it_seccode.class.php';
   $code = new seccode();
   $code->code = $_GET['parameter'];
   $code->type = 0;
   $code->background = 0;
   $code->adulterate = 1;
   $code->ttf = 1;
   $code->angle = 0;
   $code->color = 1;
   $code->size = 0;
   $code->shadow = 1;
   $code->animator = 0;
   $code->fontpath = RELATIVITY_PATH . 'images/fonts/';
   $code->datapath = RELATIVITY_PATH . 'images/';
   $code->includepath = '';
   $code->display();
}
function AmLogin()
{
   $s_username = $_POST['Vcl_UserName'];
   $s_password = $_POST['Vcl_Password'];
   require_once RELATIVITY_PATH . 'include/bn_user.class.php';
   $o_user = new Single_User();
   $s_result=$o_user->LoginIn($s_username, $s_password,'am');
   if($s_result)
   {
      echo('<script type="text/javascript" language="javascript">parent.window.open(\''.RELATIVITY_PATH.'sub/am/main.php\',\'_parent\');</script>');
   }
   else
   {
   		echo('<script>parent.loginCallBack("' . $o_user->getErrorReasion() . '")</script>');
   }
}
function Login()
{
   $s_username = $_POST['Vcl_UserName'];
   $s_password = $_POST['Vcl_Password'];
   require_once RELATIVITY_PATH . 'include/bn_user.class.php';
   $o_user = new Single_User();
   $s_result=$o_user->LoginIn($s_username, $s_password);
   if($s_result)
   {
      echo('<script type="text/javascript" language="javascript">parent.window.open(\''.RELATIVITY_PATH.'main.php\',\'_parent\');</script>');
   }
   else
   {
   		echo('<script>parent.window.alert("' . $o_user->getErrorReasion() . '")</script>');
   }
}
function Register()
{
   global $O_Session;
   require_once RELATIVITY_PATH . 'include/bn_user.class.php';
   $o_user = $O_Session->getUserObject();
   $b_submit = $o_user->Register($_POST['Vcl_UserName'], $_POST['Vcl_Password1'], $_POST['Vcl_Password2'], $_POST['Vcl_Email'], $_POST['Vcl_Code']);
   if($b_submit)
   {
      echo('<script>parent.location.reload();</script>');
   }
   else
   {
      echo('<script>
      parent.Dialog_Error("' . $o_user->getErrorReasion() . '",function(){parent.Dialog_Register("' . $_POST['Vcl_UserName'] . '","' . $_POST['Vcl_Password1'] . '","' . $_POST['Vcl_Password2'] . '","' . $_POST['Vcl_Email'] . '","")});
      </script>');
   }
}
function UploadTempFile() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$s_result = $o_operate->UploadTempFile ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else if ($s_result == 1) {
		echo ('<script type="text/javascript" language="javascript">parent.parent.uploadTempFileCallback("对不起，<br>已经存在这个文件！")</script>');
	} else if ($s_result == 2) {
		echo ('<script type="text/javascript" language="javascript">parent.parent.uploadTempFileCallback("对不起，您的空间不足！")</script>');
	}else if ($s_result == 3) {
		echo ('<script type="text/javascript" language="javascript">parent.parent.uploadTempFileCallback("对不起<br/>上传文件不能为空！")</script>');
	}else {
		echo ('');
	}
}
function UploadAffixFile() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result = $o_operate->UploadAffixFile ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.uploadAffixSuccessCallback(\''.$s_result.'\')</script>');
	}
}
?>