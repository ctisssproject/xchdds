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
	case 'JoinConfirm' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'CompletedConfirm' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'HuodongDelete' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'RefreshMenuNotice' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;	
	default :
		break;
}
echo ($S_Request);
exit ( 0 );

function JoinConfirm($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->JoinConfirm ($O_Session->getUid (),$n_id);
	$O_Request->setFunction ( 'location.reload' );
	return $O_Request->getSendXml ();
}
function CompletedConfirm($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->CompletedConfirm ($O_Session->getUid (),$n_id);
	$O_Request->setFunction ( 'location.reload' );
	return $O_Request->getSendXml ();
}
function HuodongDelete($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->HuodongDelete ($O_Session->getUid (),$n_id);
	$O_Request->setFunction ( 'location.reload' );
	return $O_Request->getSendXml ();
}
function RefreshMenuNotice($id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$count=$o_operate->RefreshMenuNotice ($id, $O_Session->getUid () );
	$O_Request->setFunction ( 'refresh_menu_notice_callback' );	
	$O_Request->PushParameter ( $count );
	$O_Request->PushParameter ( $id );
	return $O_Request->getSendXml ();
}
?>