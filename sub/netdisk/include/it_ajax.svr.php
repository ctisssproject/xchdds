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
	case 'MyDisk_GetPath' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'Share_GetRoot' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'Share_GetPath' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DeleteFile' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'RealDeleteFile' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'RealDeleteFolder' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DeleteAll' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'RealDeleteAll' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DeleteFolder' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ShowMoveDialog' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ShowMoveFolderDialog' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'MoveFileAndReplace' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ShowCopyDialog' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ShowShareDialog' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ShowCopyAndMoveAllDialog' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ShowCopyFolderDialog' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'CopyFileAndReplace' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'CopyFolderAndReplace' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'MoveFolderAndReplace' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'CopyAndMoveAll' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ClearAll' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'Reduction' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ReductionReplace' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ReductionDefault' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'UploadGetProgress' : 
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	default :
		break;
}
echo ($S_Request);
exit ( 0 );
function UploadGetProgress($s_key) {
	global $O_Session;
	global $O_Request;
	$status = apc_fetch('upload_'.$s_key);
	$O_Request->setFunction ( 'progressLoadingCallback' );
	$n_progress=floor(($status['current']/$status['total'])*100);
	$O_Request->PushParameter ($n_progress);
	return $O_Request->getSendXml ();
}
function MyDisk_GetPath($a_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->getFolderForMyDisk ( $a_id, $O_Session->getUid () );
	//require_once 'bn_operate.class.php';
	$O_Request->setFunction ( 'callbackOpenPath' );
	$O_Request->PushParameter ( $o_operate->getFolderName () );
	$O_Request->PushParameter ( $o_operate->getFolderId () );
	return $O_Request->getSendXml ();

}
function Share_GetRoot($n_uid) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->getFolderForShareRoot ( $n_uid, $O_Session->getUid () );
	$O_Request->setFunction ( 'callbackOpenPathShare' );
	$O_Request->PushParameter ( $o_operate->getFolderName () );
	$O_Request->PushParameter ( $o_operate->getFolderId () );
	return $O_Request->getSendXml ();

}
function Share_GetPath($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->getFolderForSharePath ( $n_id, $O_Session->getUid () );
	$O_Request->setFunction ( 'callbackOpenPathShare' );
	$O_Request->PushParameter ( $o_operate->getFolderName () );
	$O_Request->PushParameter ( $o_operate->getFolderId () );
	return $O_Request->getSendXml ();

}
function DeleteFile($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DeleteFile ( $n_id, $O_Session->getUid () );
	//require_once 'bn_operate.class.php';
	$O_Request->setFunction ( 'location.reload' );
	return $O_Request->getSendXml ();
}
function RealDeleteFile($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->RealDeleteFile ( $n_id, $O_Session->getUid () );
	//require_once 'bn_operate.class.php';
	$O_Request->setFunction ( 'location.reload' );
	return $O_Request->getSendXml ();
}
function ClearAll() {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->ClearAll ( $O_Session->getUid () );
	$O_Request->setFunction ( 'location.reload' );
	return $O_Request->getSendXml ();
}
function CopyAndMoveAll($s_folder_id, $s_file_id, $n_folder_start, $n_file_start, $b_replace, $n_folderid, $s_type) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result = $o_operate->CopyAndMoveAll ( $s_folder_id, $s_file_id, $n_folder_start, $n_file_start, $b_replace, $n_folderid, $s_type, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
		$O_Request->PushParameter ( $o_operate->getFolderId ( RELATIVITY_PATH ) );
	} else {
		if ($s_result == 1) {
			if ($s_type == 'copy') {
				$O_Request->setFunction ( 'callbackCopyFolderFinish' );
				$O_Request->PushParameter ( $o_operate->ParentId );
			} else {
				$O_Request->setFunction ( 'callbackMoveFolderFinish' );
				$O_Request->PushParameter ( $o_operate->ParentId );
				$O_Request->PushParameter ( $n_folderid );
			}
		} else if ($s_result == 2) {
			$O_Request->setFunction ( 'callbackCopyAndMoveAll' );
			$O_Request->PushParameter ( $o_operate->OldFile );
			$O_Request->PushParameter ( $o_operate->OldSize );
			$O_Request->PushParameter ( $o_operate->OldDate );
			$O_Request->PushParameter ( $o_operate->OldClass );
			$O_Request->PushParameter ( $o_operate->NewFile );
			$O_Request->PushParameter ( $o_operate->NewSize );
			$O_Request->PushParameter ( $o_operate->NewDate );
			$O_Request->PushParameter ( $o_operate->NewClass );
			$O_Request->PushParameter ( $s_folder_id );
			$O_Request->PushParameter ( $s_file_id );
			$O_Request->PushParameter ( $o_operate->FolderStart );
			$O_Request->PushParameter ( $o_operate->FileStart );
			$O_Request->PushParameter ( $n_folderid );
			$O_Request->PushParameter ( $s_type );
		} else if ($s_result == 3) {
			$O_Request->setFunction ( 'parent.parent.parent.Dialog_Error' );
			$O_Request->PushParameter ( '不能到本文件夹的子文件夹！' );
		}
	}
	return $O_Request->getSendXml ();
}
function DeleteFolder($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$n_parentid = $o_operate->DeleteFolder ( $n_id, $O_Session->getUid () );
	//require_once 'bn_operate.class.php';
	$O_Request->setFunction ( 'callbackDeleteFolder' );
	$O_Request->PushParameter ( $n_parentid );
	return $O_Request->getSendXml ();
}
function RealDeleteFolder($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$n_parentid = $o_operate->RealDeleteFolder ( $n_id, $O_Session->getUid () );
	$O_Request->setFunction ( 'location.reload' );
	return $O_Request->getSendXml ();
}
function DeleteAll($n_folderid, $n_fileid) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DeleteAll ( $n_folderid, $n_fileid, $O_Session->getUid () );
	$O_Request->setFunction ( 'callbackDeleteFolder' );
	$O_Request->PushParameter ( $o_operate->ParentId );
	return $O_Request->getSendXml ();
}
function RealDeleteAll($n_folderid, $n_fileid) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->RealDeleteAll ( $n_folderid, $n_fileid, $O_Session->getUid () );
	$O_Request->setFunction ( 'location.reload' );
	return $O_Request->getSendXml ();
}
function Reduction($n_id, $n_type) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result = $o_operate->Reduction ( $n_id, $n_type, $O_Session->getUid () );
	if ($s_result == 1) {
		if ($n_type == 1) {
			//刷新目录
			$O_Request->setFunction ( 'callbackCopyFolderFinish' );
			$O_Request->PushParameter ( $o_operate->ParentId );
		} else {
			$O_Request->setFunction ( 'location.reload' );
		}
	} else if ($s_result == 2) {
		$O_Request->setFunction ( 'reductionReplace' );
		$O_Request->PushParameter ( $n_id );
		$O_Request->PushParameter ( $n_type );
	} else if ($s_result == 3) {
		$O_Request->setFunction ( 'reductionDefult' );
		$O_Request->PushParameter ( $n_id );
		$O_Request->PushParameter ( $n_type );
	}
	return $O_Request->getSendXml ();
}
function ReductionReplace($n_id, $n_type) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->ReductionReplace ( $n_id, $n_type, $O_Session->getUid () );
	if ($n_type == 1) {
		//刷新目录
		$O_Request->setFunction ( 'callbackCopyFolderFinish' );
		$O_Request->PushParameter ( $o_operate->ParentId );
	} else {
		$O_Request->setFunction ( 'location.reload' );
	}
	return $O_Request->getSendXml ();
}
function ReductionDefault($n_id, $n_type) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->ReductionDefault ( $n_id, $n_type, $O_Session->getUid () );
	$O_Request->setFunction ( 'callbackCopyFolderFinish' );
	$O_Request->PushParameter (0);
	return $O_Request->getSendXml ();
}
function MoveFileAndReplace($n_fileid, $n_folderid) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->MoveFileAndReplace ( $n_fileid, $n_folderid, $O_Session->getUid () );
	$O_Request->setFunction ( 'location.reload' );
	return $O_Request->getSendXml ();
}
function ShowMoveDialog($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'it_showpage.class.php';
	$o_tree = new ShowPage ( $O_Session->getUserObject () );
	$html = '<div id="tree">' . $o_tree->getMyDiskRoot () . '<div>';
	$O_Request->setFunction ( 'showMoveDialog' );
	$O_Request->PushParameter ( $n_id );
	$O_Request->PushParameter ( $html );
	return $O_Request->getSendXml ();
}
function ShowMoveFolderDialog($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'it_showpage.class.php';
	$o_tree = new ShowPage ( $O_Session->getUserObject () );
	$html = '<div id="tree">' . $o_tree->getMyDiskRoot () . '<div>';
	$O_Request->setFunction ( 'showMoveFolderDialog' );
	$O_Request->PushParameter ( $n_id );
	$O_Request->PushParameter ( $html );
	return $O_Request->getSendXml ();
}
function ShowCopyDialog($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'it_showpage.class.php';
	$o_tree = new ShowPage ( $O_Session->getUserObject () );
	$html = '<div id="tree">' . $o_tree->getMyDiskRoot () . '<div>';
	$O_Request->setFunction ( 'showCopyDialog' );
	$O_Request->PushParameter ( $n_id );
	$O_Request->PushParameter ( $html );
	return $O_Request->getSendXml ();
}
function ShowCopyAndMoveAllDialog($n_folderid, $n_fileid, $s_type) {
	global $O_Session;
	global $O_Request;
	require_once 'it_showpage.class.php';
	$o_tree = new ShowPage ( $O_Session->getUserObject () );
	$html = '<div id="tree">' . $o_tree->getMyDiskRoot () . '<div>';
	$O_Request->setFunction ( 'showCopyAndMoveAllDialog' );
	$O_Request->PushParameter ( $n_folderid );
	$O_Request->PushParameter ( $n_fileid );
	$O_Request->PushParameter ( $html );
	$O_Request->PushParameter ( $s_type );
	return $O_Request->getSendXml ();
}
function ShowCopyFolderDialog($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'it_showpage.class.php';
	$o_tree = new ShowPage ( $O_Session->getUserObject () );
	$html = '<div id="tree">' . $o_tree->getMyDiskRoot () . '<div>';
	$O_Request->setFunction ( 'showCopyFolderDialog' );
	$O_Request->PushParameter ( $n_id );
	$O_Request->PushParameter ( $html );
	return $O_Request->getSendXml ();
}
function CopyFileAndReplace($n_fileid, $n_folderid) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->CopyFileAndReplace ( $n_fileid, $n_folderid, $O_Session->getUid () );
	$O_Request->setFunction ( 'location.reload' );
	return $O_Request->getSendXml ();
}
function CopyFolderAndReplace($n_folderid, $n_folderidto) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->CopyFolderAndReplace ( $n_folderid, $n_folderidto, $O_Session->getUid () );
	$O_Request->setFunction ( 'callbackCopyFolderFinish' );
	$O_Request->PushParameter ( $n_folderidto );
	return $O_Request->getSendXml ();
}
function MoveFolderAndReplace($n_folderid, $n_folderidto) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$n_parentid = $o_operate->MoveFolderAndReplace ( $n_folderid, $n_folderidto, $O_Session->getUid () );
	$O_Request->setFunction ( 'callbackMoveFolderFinish' );
	$O_Request->PushParameter ( $n_parentid );
	$O_Request->PushParameter ( $n_folderidto );
	return $O_Request->getSendXml ();
}
function ShowShareDialog($n_id, $n_type) {
	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/it_showpage.class.php';
	$o_group = new ShowPage ();
	$O_Request->setFunction ( 'showShareDialog' );
	$O_Request->PushParameter ( $n_id );
	$O_Request->PushParameter ( $o_group->getGroupForAdd ( $O_Session->getUid () ) );
	$O_Request->PushParameter ( $n_type );
	require_once 'db_table.class.php';
	if ($n_type == 1) {
		$o_folder = new Netdisk_Folder ( $n_id );
		$O_Request->PushParameter ( $o_folder->getShareUsername () );
		$s_temp = $o_folder->getShareUid ();
		if (strlen ( $s_temp ) > 0) {
			$s_temp = substr ( $s_temp, 3, strlen ( $s_temp ) );
			$s_temp = substr ( $s_temp, 0, strlen ( $s_temp ) - 3 );
		} else {
			$s_temp = '';
		}
		$O_Request->PushParameter ( $s_temp );
	} else {
		$o_file = new Netdisk_File ( $n_id );
		$O_Request->PushParameter ( $o_file->getShareUsername () );
		$s_temp = $o_file->getShareUid ();
		if (strlen ( $s_temp ) > 0) {
			$s_temp = substr ( $s_temp, 3, strlen ( $s_temp ) );
			$s_temp = substr ( $s_temp, 0, strlen ( $s_temp ) - 3 );
		} else {
			$s_temp = '';
		}
		$O_Request->PushParameter ( $s_temp );
	}
	return $O_Request->getSendXml ();
}
?>