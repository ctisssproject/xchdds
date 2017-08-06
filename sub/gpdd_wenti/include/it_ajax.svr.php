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
	case 'HandleConfirm' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'HandleDisconfirm' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ZcConfirm' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ZcDelete' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DcConfirm' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DcDelete' :
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
function HandleConfirm($n_id,$s_backurl) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->HandleConfirm ($O_Session->getUid (),$n_id);
	$O_Request->setFunction ( 'go_to_url' );
	$O_Request->PushParameter ($s_backurl);
	return $O_Request->getSendXml ();
}
function HandleDisconfirm($n_id,$s_backurl) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->HandleDisconfirm ($O_Session->getUid (),$n_id);
	$O_Request->setFunction ( 'go_to_url' );
	$O_Request->PushParameter ($s_backurl);
	return $O_Request->getSendXml ();
}
function ZcConfirm($n_id,$s_backurl) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->ZcConfirm ($O_Session->getUid (),$n_id);
	$O_Request->setFunction ( 'go_to_url' );
	$O_Request->PushParameter ($s_backurl);
	return $O_Request->getSendXml ();
}
function DcConfirm($n_id,$s_backurl) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DcConfirm ($O_Session->getUid (),$n_id);
	$O_Request->setFunction ( 'go_to_url' );
	$O_Request->PushParameter ($s_backurl);
	return $O_Request->getSendXml ();
}
function ZcDelete($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->ZcDelete ($O_Session->getUid (),$n_id);
	$O_Request->setFunction ( 'location.reload' );
	return $O_Request->getSendXml ();
}
function DcDelete($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DcDelete ($O_Session->getUid (),$n_id);
	$O_Request->setFunction ( 'location.reload' );
	return $O_Request->getSendXml ();
}
function RefreshMenuNotice($id,$type) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$count=$o_operate->RefreshMenuNotice ($id, $O_Session->getUid (),$type );
	$O_Request->setFunction ( 'refresh_menu_notice_callback' );	
	$O_Request->PushParameter ( $count );
	$O_Request->PushParameter ( $id );
	return $O_Request->getSendXml ();
}
?>