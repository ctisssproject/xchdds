<?php
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
define ( 'RELATIVITY_PATH', '../../../' ); //定义相对路径
require_once RELATIVITY_PATH . 'include/bn_session.class.php';
$O_Session = new Session ();
$S_Function = $_GET ['function'];
switch ($S_Function) {
	case 'InfoModify' :
		InfoModify ();
		break;
	case 'ExternalInfoModify' :
		ExternalInfoModify ();
		break;
	case 'PasswordModify' :
		PasswordModify ();
		break;
	default :
		break;
}
exit ();

function InfoModify() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->InfoModify ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
			echo ('<script type="text/javascript" language="javascript">parent.parent.Dialog_Success("保存用户信息成功！")</script>');

		
	}
}
function ExternalInfoModify() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->ExternalInfoModify ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
			echo ('<script type="text/javascript" language="javascript">parent.parent.Dialog_Success("保存用户信息成功！")</script>');

		
	}
}
function PasswordModify() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result=$o_operate->PasswordModify ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if($s_result==1){
			echo ('<script type="text/javascript" language="javascript">parent.parent.Dialog_Success("修改登录密码成功！");parent.location.reload();</script>');
		}else{
			echo ('<script type="text/javascript" language="javascript">parent.parent.Dialog_Error("对不起，原始密码错误！")</script>');
		}		
	}
}
?>