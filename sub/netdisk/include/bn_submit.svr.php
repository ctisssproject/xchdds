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
	case 'UploadFile' :
		UploadFile ();
		break;
	case 'UploadTempFile' :
		UploadTempFile ();
		break;
	case 'FileRename' :
		FileRename ();
		break;
	case 'MoveFile' :
		MoveFile ();
		break;
	case 'MoveFolder' :
		MoveFolder ();
		break;
	case 'FolderRename' :
		FolderRename ();
		break;
	case 'CopyFile' :
		CopyFile ();
		break;
	case 'ShareFile' :
		ShareFile ();
		break;
	case 'CopyFolder' :
		CopyFolder ();
		break;
	case 'FolderNew' :
		FolderNew ();
		break;
	default :
		break;
}
exit ();
function UploadFile() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result = $o_operate->UploadFile ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.parent.uploadSuccessCallback('.$_POST ['Vcl_FolderId'] .')</script>');
	}
}
function FileRename() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result = $o_operate->FileRename ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($s_result) {
			echo ('<script type="text/javascript" language="javascript">parent.location.reload()</script>');
		} else {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.parent.Dialog_Error("已经存在相同的文件名！<br>请重新输入！")</script>');
		}
	}
}

function FolderRename() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result = $o_operate->FolderRename ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($s_result) {
			echo ('<script type="text/javascript" language="javascript">parent.callbackRenameFolder(' . $_POST ['Vcl_ParentId'] . ')</script>');
		} else {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.parent.Dialog_Error("已经存在相同的文件夹名！<br>请重新输入！")</script>');
		}
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
function FolderNew() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result = $o_operate->FolderNew ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($s_result) {
			echo ('<script type="text/javascript" language="javascript">parent.callbackRenameFolder(' . $_POST ['Vcl_ParentId'] . ')</script>');
		} else {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.parent.Dialog_Error("已经存在相同的文件夹名！<br>请重新输入！")</script>');
		}
	}
}
function MoveFile() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$s_result = $o_operate->MoveFile ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($s_result) {
			echo ('<script type="text/javascript" language="javascript">parent.location.reload()</script>');
		} else {
			echo ('<script type="text/javascript" language="javascript">parent.callbackMoveFile(' . $_POST ['Vcl_FileId'] . ',' . $_POST ['Vcl_FolderId'] . ')</script>');
		}
	}
}
function MoveFolder() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$s_result = $o_operate->MoveFolder ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($s_result == 1) {
			echo ('<script type="text/javascript" language="javascript">parent.callbackMoveFolderFinish(' . $o_operate->getFolderId () . ',' . $_POST ['Vcl_FolderId'] . ')</script>');
		} else if ($s_result == 2) {
			echo ('<script type="text/javascript" language="javascript">parent.callbackMoveFolder(' . $_POST ['Vcl_FolderIdFrom'] . ',' . $_POST ['Vcl_FolderId'] . ')</script>');
		} else if ($s_result == 3) {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.parent.Dialog_Error("不能到本文件夹的子文件夹！")</script>');
		}
	}
}
function CopyFile() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$s_result = $o_operate->CopyFile ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($s_result) {
			echo ('<script type="text/javascript" language="javascript">parent.Common_CloseDialog()</script>');
		} else {
			echo ('<script type="text/javascript" language="javascript">parent.callbackCopyFile(' . $_POST ['Vcl_FileId'] . ',' . $_POST ['Vcl_FolderId'] . ')</script>');
		}
	}
}
function ShareFile() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result = $o_operate->ShareFile ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($s_result) {
			echo ('<script type="text/javascript" language="javascript">parent.location.reload()</script>');
		} else {
			echo ('<script type="text/javascript" language="javascript">parent.Common_CloseDialog();parent.parent.parent.parent.Dialog_Error("父文件夹已经设置共享！<br>不能重复设置共享！")</script>');
		}
	
	}
}
function CopyFolder() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$s_result = $o_operate->CopyFolder ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($s_result == 1) {
			echo ('<script type="text/javascript" language="javascript">parent.callbackCopyFolderFinish(' . $_POST ['Vcl_FolderId'] . ')</script>');
		} else if ($s_result == 2) {
			echo ('<script type="text/javascript" language="javascript">parent.callbackCopyFolder(' . $_POST ['Vcl_FolderIdFrom'] . ',' . $_POST ['Vcl_FolderId'] . ')</script>');
		} else if ($s_result == 3) {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.parent.Dialog_Error("不能到本文件夹的子文件夹！")</script>');
		}
	}
}
?>