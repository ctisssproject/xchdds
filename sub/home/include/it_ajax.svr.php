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
	case 'DeleteScroll' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DeleteFocus' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DeleteBigFocus' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DeletePhoto' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DeleteLink' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DeleteColumn' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DeleteFooter' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DeleteFloat' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DeleteArticle' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DeleteMessages' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'GetColumn2' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'GetTags' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ArticleAudit' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'CommentDelete' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	default :
		break;
}
echo ($S_Request);
exit ( 0 );
function ArticleAudit($n_id,$s_backurl) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->ArticleAudit ( $n_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ('goLocation');
		$O_Request->PushParameter ('http://192.168.0.8/xcdxk/sub/home/article_audit.php');
	}
	$O_Request->PushParameter ($o_operate->getResult ());
	return $O_Request->getSendXml ();
}
function DeleteScroll($a_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DeleteScroll ( $a_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'location.reload' );
	}
	return $O_Request->getSendXml ();

}
function DeleteLink($a_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DeleteLink ( $a_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'location.reload' );
	}
	return $O_Request->getSendXml ();

}
function DeleteColumn($a_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result = $o_operate->DeleteColumn ( $a_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		if ($s_result) {
			$O_Request->setFunction ( 'location.reload' );
		} else {
			$O_Request->setFunction ( 'parent.parent.Dialog_Message' );
			$O_Request->PushParameter ( '对不起，不能删除！<br>栏目中存在子栏目或文章！' );
		}
	}
	return $O_Request->getSendXml ();
}
function DeleteFooter($a_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DeleteFooter ( $a_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'location.reload' );
	}
	return $O_Request->getSendXml ();

}
function DeleteFloat($a_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DeleteFloat ( $a_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'location.reload' );
	}
	return $O_Request->getSendXml ();

}
function DeleteArticle($a_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DeleteArticle ( $a_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'location.reload' );
	}
	return $O_Request->getSendXml ();

}
function DeleteMessages($a_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DeleteMessages ( $a_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'location.reload' );
	}
	return $O_Request->getSendXml ();

}
function DeleteFocus($a_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DeleteFocus ( $a_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'location.reload' );
	}
	return $O_Request->getSendXml ();

}
function DeleteBigFocus($a_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DeleteBigFocus ( $a_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'location.reload' );
	}
	return $O_Request->getSendXml ();

}
function DeletePhoto($a_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DeletePhoto ( $a_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'location.reload' );
	}
	return $O_Request->getSendXml ();

}
function GetColumn2($a_id) {
	global $O_Session;
	global $O_Request;
	require_once 'db_table.class.php';
	//构造弹出菜单的一级栏目
	$s_column_id = 'new Array(';
	$s_column_name = 'new Array(';
	$o_column = new Home_Column ();
	$o_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
	$o_column->PushWhere ( array ('&&', 'Parent', '=', $a_id ) );
	$o_column->PushOrder ( array ('Number', 'A' ) );
	for($i = 0; $i < $o_column->getAllCount (); $i ++) {
		$s_column_id .= '\'' . $o_column->getColumnId ( $i ) . '\',';
		$s_column_name .= '\'' . $o_column->getName ( $i ) . '\',';
	}
	if ($o_column->getAllCount () > 0) {
		$s_column_id = substr ( $s_column_id, 0, strlen ( $s_column_id ) - 1 );
		$s_column_name = substr ( $s_column_name, 0, strlen ( $s_column_name ) - 1 );
	}
	$s_column_id .= ')';
	$s_column_name .= ')';
	$O_Request->setFunction ( 'setColume2' );
	$O_Request->PushParameter ( $s_column_id );
	$O_Request->PushParameter ( $s_column_name );
	return $O_Request->getSendXml ();

}
function GetTags($a_id) {
	global $O_Session;
	global $O_Request;
	require_once 'db_table.class.php';
	//构造弹出菜单的一级栏目
	$s_column_id = 'new Array(';
	$s_column_name = 'new Array(';
	$o_column = new Home_Column_Tags ();
	$o_column->PushWhere ( array ('&&', 'ColumnId', '=', $a_id ) );
	$o_column->PushOrder ( array ('Number', 'A' ) );
	for($i = 0; $i < $o_column->getAllCount (); $i ++) {
		$s_column_id .= '\'' . $o_column->getId ( $i ) . '\',';
		$s_column_name .= '\'' . $o_column->getName ( $i ) . '\',';
	}
	if ($o_column->getAllCount () > 0) {
		$s_column_id = substr ( $s_column_id, 0, strlen ( $s_column_id ) - 1 );
		$s_column_name = substr ( $s_column_name, 0, strlen ( $s_column_name ) - 1 );
	}else{
		return;
	}
	$s_column_id .= ')';
	$s_column_name .= ')';
	$O_Request->setFunction ( 'setTags' );
	$O_Request->PushParameter ( $s_column_id );
	$O_Request->PushParameter ( $s_column_name );
	return $O_Request->getSendXml ();

}
function CommentDelete($id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->CommentDelete ( $id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'location.reload' );
	}
	return $O_Request->getSendXml ();

}
?>