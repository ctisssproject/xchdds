<?php

header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
define ( 'RELATIVITY_PATH', '../../../' ); //定义相对路径
require_once RELATIVITY_PATH . 'include/bn_session.class.php';
$O_Session = new Session ();
require_once RELATIVITY_PATH . 'include/bn_ajaxrequest.class.php';
$O_Request = new AjaxRequest ( $_GET ['xml'] );
switch ($O_Request->getFunction ()) {
	case 'DeleteArticle' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	default :
		break;
}
echo ($S_Request);
exit ( 0 );

function DeleteArticle($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DeleteArticle ( $n_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'location.reload' );
	}
	return $O_Request->getSendXml ();
}
?>