<?php
require_once 'db_table.class.php';
require_once 'db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
class Operate extends Bn_Basic {
	protected $Result;
	private $FolderName;
	private $FolderId;
	public $FolderStart;
	public $FileStart;
	public $OldFile;
	public $OldSize;
	public $OldDate;
	public $OldClass;
	public $NewFile;
	public $NewSize;
	public $NewDate;
	public $NewClass;
	public $ParentId;
	protected $A_FolderId = array ();
	public function UploadTempFile($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		$this->DeleteDir ( RELATIVITY_PATH . 'userdata/' . md5 ( $o_user->getUserName () ) . '/resources/netdisk_temp' ); //删除临时文件	
		mkdir ( RELATIVITY_PATH . 'userdata/' . md5 ( $o_user->getUserName () ) . '/resources', 0700 );
		mkdir ( RELATIVITY_PATH . 'userdata/' . md5 ( $o_user->getUserName () ) . '/resources/netdisk_temp', 0700 );
		
		if ($_FILES ['Vcl_Upload'] ['size'] > 0) {
			//查找有无重复文件
			$o_file = new Netdisk_File ();
			$o_file->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$a = $_POST ['Vcl_FolderId'];
			$o_file->PushWhere ( array ('&&', 'FolderId', '=', $_POST ['Vcl_FolderId'] ) );
			$o_file->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
			$o_file->PushWhere ( array ('&&', 'Filename', '=', $_FILES ['Vcl_Upload'] ['name'] ) );
			if ($o_file->getAllCount () > 0) {
				return 1;
			}
			move_uploaded_file ( $_FILES ["Vcl_Upload"] ["tmp_name"], RELATIVITY_PATH . 'userdata/' . md5 ( $o_user->getUserName () ) . '/resources/netdisk_temp/' . iconv ( 'UTF-8', 'gb2312', $_FILES ['Vcl_Upload'] ['name'] ) );
		} else {
			return 3;
		}
	}
	private function ValidShareForFolder($n_folderid, $n_uid) {
		//验证文件夹是否共享
		$o_tree = new Netdisk_Folder ( $n_folderid );
		$n_find = false;
		while ( $n_find === false ) {
			if (strpos ( $o_tree->getShareUid (), '<1>' . $n_uid . '<1>' ) === false) {
				if ($o_tree->getParentId () == 0) {
					break;
				}
				$o_tree = new Netdisk_Folder ( $o_tree->getParentId () );
			} else {
				return true;
			}
		}
		return false;
	}
	public function ValidShare($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			return true;
		} else {
			return FALSE;
		}
	
	}
	public function getFolderName() {
		return $this->FolderName;
	}
	public function __construct() {
		$this->Result = TRUE;
	}
	public function getFolderId() {
		return $this->FolderId;
	}
	public function FileRename($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			$o_file = new Netdisk_File ( $_POST ['Vcl_FileId'] );
			if ($o_file->getUid () == $n_uid) {
				//检测有无重名
				$o_file_2 = new Netdisk_File ();
				$o_file_2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_file_2->PushWhere ( array ('&&', 'FolderId', '=', $o_file->getFolderId () ) );
				$o_file_2->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
				$o_file_2->PushWhere ( array ('&&', 'Filename', '=', $_POST ['Vcl_Filename'] ) );
				$o_file_2->PushWhere ( array ('&&', 'FileId', '<>', $_POST ['Vcl_FileId'] ) );
				if ($o_file_2->getAllCount () > 0) {
					return FALSE;
				}
				$a_array = explode ( ".", $_POST ['Vcl_Filename'] );
				$o_file->setFilename ( $_POST ['Vcl_Filename'] );
				$o_file->setKeyWord ( $_POST ['Vcl_KeyWord'] );
				if (count ( $a_array ) > 1) {
					$o_type = new Netdisk_Type ();
					$o_type->PushWhere ( array ('&&', 'Suffix', '=', $a_array [1] ) );
					if ($o_type->getAllCount () > 0) {
						$o_file->setSuffix ( $o_type->getSuffix ( 0 ) );
					} else {
						$o_file->setSuffix ( 'other' );
					}
				} else {
					$o_file->setSuffix ( 'other' );
				}
				$o_file->Save ();
				return true;
			
		//文件名和后缀分开
			}
			return true;
		}
	}
	public function FolderRename($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70002 )) {
			$o_file = new Netdisk_Folder ( $_POST ['Vcl_FolderId'] );
			//检测有无重名
			$o_file_2 = new Netdisk_Folder ();
			$o_file_2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_file_2->PushWhere ( array ('&&', 'ParentId', '=', $o_file->getParentId () ) );
			$o_file_2->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
			$o_file_2->PushWhere ( array ('&&', 'FolderName', '=', $_POST ['Vcl_FolderName'] ) );
			$o_file_2->PushWhere ( array ('&&', 'FolderId', '<>', $_POST ['Vcl_FolderId'] ) );
			if ($o_file_2->getAllCount () > 0) {
				return FALSE;
			}
			$o_file->setFolderName ( $_POST ['Vcl_FolderName'] );
			$o_file->Save ();
			return true;
			
			//文件名和后缀分开
			return true;
		}
	}
	public function UploadFile($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		mkdir ( RELATIVITY_PATH . 'userdata/' . md5 ( $o_user->getUserName () ), 0700 );
		mkdir ( RELATIVITY_PATH . 'userdata/' . md5 ( $o_user->getUserName () ) . '/resources', 0700 );
		if ($o_user->ValidModule ( 70001 )) {
			$o_file = new Netdisk_Folder ( $_POST ['Vcl_FolderId'] );
			$dir = RELATIVITY_PATH . 'userdata/' . md5 ( $o_user->getUserName () ) . '/resources/netdisk_temp';
			$dh = opendir ( $dir );
			while ( $file = readdir ( $dh ) ) {
				if ($file != "." && $file != "..") {
					$fullpath = $dir . "/" . $file;
					if (! is_dir ( $fullpath )) {
						$o_path = md5 ( $file . $n_uid . rand ( 0, 9999 ) . $this->GetTimeCut () );
						mkdir ( RELATIVITY_PATH . 'userdata/' . md5 ( $o_user->getUserName () ) . '/resources', 0700 );
						mkdir ( RELATIVITY_PATH . 'userdata/' . md5 ( $o_user->getUserName () ) . '/resources/' . $o_path, 0700 );
						$filename = iconv ( 'gb2312', 'UTF-8', $file );
						$fileext = strtolower ( trim ( substr ( strrchr ( $filename, '.' ), 1 ) ) );
						$o_filename = md5 ( $filename ) . '.' . $fileext;
						$o_to = RELATIVITY_PATH . 'userdata/' . md5 ( $o_user->getUserName () ) . '/resources/' . $o_path . '/' . $o_filename;
						//计算网盘空间
						$filesize = floor ( filesize ( $fullpath ) / 1024 );
						//在数据库中保存文件信息
						$o_file = new Netdisk_File ();
						$o_file->setFilename ( $filename );
						$o_file->setOriginalFilename ( $o_filename );
						$o_file->setFilesize ( $filesize );
						$o_path = 'userdata/' . md5 ( $o_user->getUserName () ) . '/resources/' . $o_path;
						$o_file->setPath ( $o_path );
						//设置文件后缀信息
						$o_suffix = new Netdisk_Type ( $fileext );
						if ($o_suffix->getClassName () == false) {
							$o_file->setSuffix ( 'other' );
						} else {
							$o_file->setSuffix ( $fileext );
						}
						$o_file->setDate ( $this->GetDateNow () );
						$o_file->setUid ( $n_uid );
						$s_keyword = $_POST ['Vcl_KeyWord'];
						$s_keyword = str_replace ( "\n", "<br/>", $s_keyword );
						$s_keyword = str_replace ( '  ', '&nbsp;&nbsp;', $s_keyword );
						$o_file->setKeyWord ( $s_keyword );
						$o_file->setFolderId ( $_POST ['Vcl_FolderId'] );
						$o_file->Save ();
						rename ( $fullpath, $o_to );
						break;
					}
				}
			}
			closedir ( $dh );
			$this->DeleteDir ( $dir ); //删除临时文件	
		}
	}
	public function UploadLink($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			$o_file = new Netdisk_Folder ( $_POST ['Vcl_FolderId'] );
			
			//在数据库中保存文件信息
			$o_file = new Netdisk_File ();
			$o_file->setFilename ( $_POST ['Vcl_FileName'] );
			$o_file->setOriginalFilename ( $_POST ['Vcl_FileName'] );
			$o_file->setFilesize ( 0 );
			$o_file->setPath ( '' );
			//设置文件后缀信息
			$o_suffix = new Netdisk_Type ( 'html' );
			if ($o_suffix->getClassName () == false) {
				$o_file->setSuffix ( 'other' );
			} else {
				$o_file->setSuffix ( 'html' );
			}
			$o_file->setDate ( $this->GetDateNow () );
			$o_file->setUrl ( $_POST ['Vcl_Url'] );
			$o_file->setUid ( $n_uid );
			$s_keyword = $_POST ['Vcl_KeyWord'];
			$s_keyword = str_replace ( "\n", "<br/>", $s_keyword );
			$s_keyword = str_replace ( '  ', '&nbsp;&nbsp;', $s_keyword );
			$o_file->setKeyWord ( $s_keyword );
			$o_file->setFolderId ( $_POST ['Vcl_FolderId'] );
			$o_file->Save ();
		
		}
	}
	public function FolderNew($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70002 )) {
			$o_file = new Netdisk_Folder ( $_POST ['Vcl_ParentId'] );
			//检测有无重名
			$o_file_2 = new Netdisk_Folder ();
			$o_file_2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_file_2->PushWhere ( array ('&&', 'ParentId', '=', $_POST ['Vcl_ParentId'] ) );
			$o_file_2->PushWhere ( array ('&&', 'FolderName', '=', $_POST ['Vcl_FolderName'] ) );
			if ($o_file_2->getAllCount () > 0) {
				return FALSE;
			}
			$o_file = new Netdisk_Folder ();
			$o_file->setFolderName ( $_POST ['Vcl_FolderName'] );
			$o_date = new DateTime ( 'Asia/Chongqing' );
			$o_file->setDate ( $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' ) );
			$o_file->setUid ( $n_uid );
			$o_file->setParentId ( $_POST ['Vcl_ParentId'] );
			$o_file->Save ();
			return true;
			
			//文件名和后缀分开
			return true;
		}
	}
	public function MoveFile($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			$o_file = new Netdisk_File ( $_POST ['Vcl_FileId'] );
			if ($o_file->getUid () == $n_uid) {
				//检测目录
				$o_root = new Netdisk_Folder ();
				$o_root->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_root->PushWhere ( array ('&&', 'ParentId', '=', $_POST ['Vcl_FolderId'] ) );
				if ($o_root->getAllCount () > 0) {
					return - 1;
				}
				//检测有无重名
				$o_file_2 = new Netdisk_File ();
				$o_file_2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_file_2->PushWhere ( array ('&&', 'FileId', '<>', $_POST ['Vcl_FileId'] ) );
				$o_file_2->PushWhere ( array ('&&', 'FolderId', '=', $_POST ['Vcl_FolderId'] ) );
				$o_file_2->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
				$o_file_2->PushWhere ( array ('&&', 'Filename', '=', $o_file->getFilename () ) );
				if ($o_file_2->getAllCount () > 0) {
					return 0;
				}
				$o_file->setFolderId ( $_POST ['Vcl_FolderId'] );
				$o_file->Save ();
				return 1;
			
		//文件名和后缀分开
			}
			return 1;
		}
	}
	public function MoveFileAndReplace($n_fileid, $n_folderid, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			$o_file = new Netdisk_File ( $n_fileid );
			if ($o_file->getUid () == $n_uid) {
				//检测有无重名
				$o_file_2 = new Netdisk_File ();
				$o_file_2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_file_2->PushWhere ( array ('&&', 'FolderId', '=', $n_folderid ) );
				$o_file_2->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
				$o_file_2->PushWhere ( array ('&&', 'FileId', '<>', $n_fileid ) );
				$o_file_2->PushWhere ( array ('&&', 'Filename', '=', $o_file->getFilename () ) );
				$n_count = $o_file_2->getAllCount ();
				for($i = 0; $i < $n_count; $i ++) {
					$this->RealDeleteSingleFile ( $o_file_2->getFileId ( $i ) );
				}
				$o_file->setFolderId ( $n_folderid );
				$o_file->setDelete ( 0 );
				$o_file->Save ();
			}
		}
	}
	public function CopyFile($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			$o_file = new Netdisk_File ( $_POST ['Vcl_FileId'] );
			if ($o_file->getUid () == $n_uid) {
				//检测目录
				$o_root = new Netdisk_Folder ();
				$o_root->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_root->PushWhere ( array ('&&', 'ParentId', '=', $_POST ['Vcl_FolderId'] ) );
				if ($o_root->getAllCount () > 0) {
					return - 1;
				}
				//检测有无重名
				$o_file_2 = new Netdisk_File ();
				$o_file_2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_file_2->PushWhere ( array ('&&', 'FolderId', '=', $_POST ['Vcl_FolderId'] ) );
				$o_file_2->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
				$o_file_2->PushWhere ( array ('&&', 'Filename', '=', $o_file->getFilename () ) );
				if ($o_file_2->getAllCount () > 0) {
					return 0;
				}
				$this->CopySingleFile ( $o_file, $_POST ['Vcl_FolderId'], null, $n_uid );
				return 1;
			
		//文件名和后缀分开
			}
			return 1;
		}
	}
	public function ShareFile($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			//检测有无重名
			if ($_POST ['Vcl_Type'] == 1) {
				//文件夹共享
				$o_folder = new Netdisk_Folder ( $_POST ['Vcl_Id'] );
				if ($o_folder->getUid () == $n_uid) {
					//判断该文件夹的父文件夹是否有共享，有共享就不能再设置共享
					if ($o_folder->getParentId () != 0) {
						$o_tree = new Netdisk_Folder ( $o_folder->getParentId () );
						$n_find = false;
						while ( $n_find === false ) {
							if ($o_tree->getShareUid () == '') {
								if ($o_tree->getParentId () == 0) {
									break;
								}
								$o_tree = new Netdisk_Folder ( $o_tree->getParentId () );
							} else {
								return false;
							}
						}
					}
					//
					if ($_POST ['Vcl_Reciver'] == '') {
						$o_folder->setShareUsername ( '' );
						$o_folder->setShareUid ( '' );
					} else {
						$o_folder->setShareUsername ( $_POST ['Vcl_Reciver'] );
						$o_folder->setShareUid ( '<1>' . $_POST ['Vcl_Reciver_Id'] . '<1>' );
					}
					if ($_POST ['Vcl_Reciver_Id'] != '') {
						//发送事物提醒
						$a_uid = explode ( "<1>", $_POST ['Vcl_Reciver_Id'] );
						for($i = 0; $i < count ( $a_uid ); $i ++) {
							$this->SendRemind ( $n_uid, $a_uid [$i], '给您共享了一个名为 “' . $o_folder->getFolderName () . '” 的文件夹，请您查收！' );
						}
					}
					
					$o_folder->Save ();
				}
			} else {
				//文件共享
				$o_file = new Netdisk_File ( $_POST ['Vcl_Id'] );
				if ($o_file->getUid () == $n_uid) {
					//判断该文件的父文件夹是否有共享，有共享就不能再设置共享
					if ($o_file->getFolderId () > 0) {
						$o_tree = new Netdisk_Folder ( $o_file->getFolderId () );
						$n_find = false;
						while ( $n_find === false ) {
							if ($o_tree->getShareUid () == '') {
								if ($o_tree->getParentId () == 0) {
									break;
								}
								$o_tree = new Netdisk_Folder ( $o_tree->getParentId () );
							} else {
								return false;
							}
						}
					}
					//
					if ($_POST ['Vcl_Reciver'] == '') {
						$o_file->setShareUsername ( '' );
						$o_file->setShareUid ( '' );
					} else {
						$o_file->setShareUsername ( $_POST ['Vcl_Reciver'] );
						$o_file->setShareUid ( '<1>' . $_POST ['Vcl_Reciver_Id'] . '<1>' );
					}
					if ($_POST ['Vcl_Reciver_Id'] != '') {
						//发送事物提醒
						$a_uid = explode ( "<1>", $_POST ['Vcl_Reciver_Id'] );
						for($i = 0; $i < count ( $a_uid ); $i ++) {
							$this->SendRemind ( $n_uid, $a_uid [$i], '给您共享了一个名为 “' . $o_file->getFilename () . '” 的文件，请您查收！' );
						}
					}
					$o_file->Save ();
				}
			}
			return true;
		}
	}
	public function MoveFolder($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			$o_file = new Netdisk_Folder ( $_POST ['Vcl_FolderIdFrom'] );
			$this->FolderId = $o_file->getParentId ();
			if ($o_file->getUid () == $n_uid) {
				//验证目标文件夹是否在源文件夹中。
				

				if ($_POST ['Vcl_FolderId'] == $_POST ['Vcl_FolderIdFrom']) {
					return 3;
				}
				$o_file_2 = new Netdisk_Folder ( $_POST ['Vcl_FolderId'] );
				while ( $o_file_2->getParentId () != 0 ) {
					if ($o_file_2->getParentId () == $_POST ['Vcl_FolderIdFrom']) {
						return 3;
					}
					$o_file_2 = new Netdisk_Folder ( $o_file_2->getParentId () );
				}
				if ($o_file->getParentId () == $_POST ['Vcl_FolderId']) {
					return 1;
				}
				//检测有无重名
				$o_file_2 = new Netdisk_Folder ();
				$o_file_2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_file_2->PushWhere ( array ('&&', 'ParentId', '=', $_POST ['Vcl_FolderId'] ) );
				$o_file_2->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
				$o_file_2->PushWhere ( array ('&&', 'FolderName', '=', $o_file->getFolderName () ) );
				if ($o_file_2->getAllCount () > 0) {
					return 2;
				}
				//复制文件夹，要包含里面所有的子文件夹和文件	
				$o_file->setParentId ( $_POST ['Vcl_FolderId'] );
				$o_file->Save ();
				return 1;
			}
			//文件名和后缀分开
			return true;
		}
	}
	public function CopyAndMoveAll($s_folder_id, $s_file_id, $n_folder_start, $n_file_start, $b_replace, $n_folderid, $s_type, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70002 ) || $o_user->ValidModule ( 70001 )) {
			if ($s_folder_id != '') {
				$a_folder_id = explode ( "<1>", $s_folder_id );
			} else {
				$a_folder_id = Array ();
			}
			if ($s_file_id != '') {
				$a_file_id = explode ( "<1>", $s_file_id );
			} else {
				$a_file_id = Array ();
			}
			for($n_folder_start; $n_folder_start < count ( $a_folder_id ); $n_folder_start ++) {
				//复制文件夹
				$o_file = new Netdisk_Folder ( $a_folder_id [$n_folder_start] );
				$this->ParentId = $o_file->getParentId ();
				//验证目标文件夹是否在源文件夹中。
				if ($a_folder_id [$n_folder_start] == $n_folderid) {
					return 3;
				}
				$o_file_2 = new Netdisk_Folder ( $n_folderid );
				while ( $o_file_2->getParentId () != 0 ) {
					if ($o_file_2->getParentId () == $a_folder_id [$n_folder_start]) {
						return 3;
					}
					$o_file_2 = new Netdisk_Folder ( $o_file_2->getParentId () );
				}
				if ($o_file->getParentId () == $n_folderid && $o_file->getUId () == $n_uid) {
					return 1;
				}
				//检测有无重名
				$o_file_2 = new Netdisk_Folder ();
				$o_file_2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_file_2->PushWhere ( array ('&&', 'ParentId', '=', $n_folderid ) );
				//$o_file_2->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
				$o_file_2->PushWhere ( array ('&&', 'FolderName', '=', $o_file->getFolderName () ) );
				$n_count = $o_file_2->getAllCount ();
				if ($n_count > 0) {
					if ($b_replace == 0) {
						continue;
					} else if ($b_replace == 2) {
						$this->FolderStart = $n_folder_start;
						$this->FileStart = $n_file_start;
						$this->OldFile = $o_file_2->getFolderName ( 0 );
						$this->OldSize = '';
						$this->OldDate = $o_file_2->getDate ( 0 );
						$this->OldClass = 'folder';
						$this->NewFile = $o_file->getFolderName ();
						$this->NewSize = '';
						$this->NewDate = $o_file->getDate ();
						$this->NewClass = 'folder';
						return 2;
					} else if ($b_replace == 1) {
						for($i = 0; $i < $n_count; $i ++) {
							$this->RealDeleteSingleFolder ( $o_file_2->getFolderId ( $i ) );
						}
					}
				}
				$b_replace = 2;
				//复制文件夹，要包含里面所有的子文件夹和文件
				if ($s_type == 'copy') {
					$o_file_3 = new Netdisk_Folder ();
					$o_file_3->setFolderName ( $o_file->getFolderName () );
					$o_file_3->setDate ( $o_file->getDate () );
					$o_file_3->setUid ( $n_uid );
					$o_file_3->setParentId ( $n_folderid );
					$o_file_3->Save ();
					$n_folderid2 = $o_file_3->getFolderId ();
					$this->CopyFolderForDigui ( $a_folder_id [$n_folder_start], $n_folderid2, $n_uid );
				} else {
					$o_file->setParentId ( $n_folderid );
					//计算网盘空间
					$o_space = new Netdisk_Space ( $n_uid );
					$o_space->setFree ( $o_space->getFree () - $o_file->getFilesize () );
					$o_space->setUse ( $o_space->getUse () + $o_file->getFilesize () );
					$o_space->Save ();
					/////////////////
					$o_file->Save ();
				}
			
			}
			for($n_file_start; $n_file_start < count ( $a_file_id ); $n_file_start ++) {
				$o_file = new Netdisk_File ( $a_file_id [$n_file_start] );
				$this->ParentId = $o_file->getFolderId ();
				if ($o_file->getUid () == $n_uid || $this->ValidShare ( $a_file_id [$n_file_start], $n_uid )) {
					//检测有无重名
					$o_file_2 = new View_Netdisk_File ();
					$o_file_2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
					$o_file_2->PushWhere ( array ('&&', 'FolderId', '=', $n_folderid ) );
					$o_file_2->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
					$o_file_2->PushWhere ( array ('&&', 'Filename', '=', $o_file->getFilename () ) );
					$n_count = $o_file_2->getAllCount ();
					if ($n_count > 0) {
						if ($b_replace == 0) {
							continue;
						} else if ($b_replace == 2) {
							$this->FolderStart = $n_folder_start;
							$this->FileStart = $n_file_start;
							$this->OldFile = $o_file_2->getFilename ( 0 );
							$this->OldSize = $this->getFilesize ( $o_file_2->getFilesize ( 0 ) );
							$this->OldDate = $o_file_2->getDate ( 0 );
							$this->OldClass = $o_file_2->getClassName ( 0 );
							$this->NewFile = $o_file->getFilename ();
							$this->NewSize = $this->getFilesize ( $o_file->getFilesize () );
							$this->NewDate = $o_file->getDate ();
							$this->NewClass = $o_file_2->getClassName ( 0 );
							return 2;
						} else if ($b_replace == 1) {
							for($i = 0; $i < $n_count; $i ++) {
								$this->RealDeleteSingleFile ( $o_file_2->getFileId ( $i ) );
							}
						}
					}
					if ($s_type == 'copy') {
						$this->CopySingleFile ( $o_file, $n_folderid, null, $n_uid );
					} else {
						$o_file->setFolderId ( $n_folderid );
						$o_file->Save ();
					}
				}
				$b_replace = 2;
			}
			return 1;
		}
	}
	public function CopyFolder($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			$o_file = new Netdisk_Folder ( $_POST ['Vcl_FolderIdFrom'] );
			if ($o_file->getUid () == $n_uid || $this->ValidShare ( $_POST ['Vcl_FolderIdFrom'], $n_uid )) {
				//验证目标文件夹是否在源文件夹中。
				

				if ($_POST ['Vcl_FolderId'] == $_POST ['Vcl_FolderIdFrom']) {
					return 3;
				}
				$o_file_2 = new Netdisk_Folder ( $_POST ['Vcl_FolderId'] );
				while ( $o_file_2->getParentId () != 0 ) {
					if ($o_file_2->getParentId () == $_POST ['Vcl_FolderIdFrom']) {
						return 3;
					}
					$o_file_2 = new Netdisk_Folder ( $o_file_2->getParentId () );
				}
				if ($o_file->getParentId () == $_POST ['Vcl_FolderId'] && $o_file->getUId () == $n_uid) {
					//如果是原级文件夹，并且是自己的文件夹。则直接完成。
					return 1;
				}
				//检测有无重名
				$o_file_2 = new Netdisk_Folder ();
				$o_file_2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_file_2->PushWhere ( array ('&&', 'ParentId', '=', $_POST ['Vcl_FolderId'] ) );
				$o_file_2->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
				$o_file_2->PushWhere ( array ('&&', 'FolderName', '=', $o_file->getFolderName () ) );
				if ($o_file_2->getAllCount () > 0) {
					return 2;
				}
				//复制文件夹，要包含里面所有的子文件夹和文件	
				$n_fromid = $_POST ['Vcl_FolderIdFrom'];
				$n_toid = $_POST ['Vcl_FolderId'];
				$o_file_3 = new Netdisk_Folder ();
				$o_file_3->setFolderName ( $o_file->getFolderName () );
				$o_file_3->setDate ( $o_file->getDate () );
				$o_file_3->setUid ( $n_uid );
				$o_file_3->setParentId ( $_POST ['Vcl_FolderId'] );
				$o_file_3->Save ();
				$n_folderid = $o_file_3->getFolderId ();
				$this->CopyFolderForDigui ( $_POST ['Vcl_FolderIdFrom'], $n_folderid, $n_uid );
				return 1;
			}
			//文件名和后缀分开
			return true;
		}
	}
	private function CopyFolderForDigui($old, $new, $n_uid) { //递归复制文件夹和文件
		$o_folder = new Netdisk_Folder ();
		$o_folder->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_folder->PushWhere ( array ('&&', 'ParentId', '=', $old ) );
		//$o_folder->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
		$n_count_folder = $o_folder->getAllCount ();
		//先把文件复制号
		$o_file = new Netdisk_File ();
		$o_file->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_file->PushWhere ( array ('&&', 'FolderId', '=', $old ) );
		//$o_file->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
		$n_count_file = $o_file->getAllCount ();
		for($i = 0; $i < $n_count_file; $i ++) {
			//$this->CopySingleFile ( $o_file, $new, $i, $n_uid );
		}
		for($i = 0; $i < $n_count_folder; $i ++) { //拷贝文件夹，然后递归
			$new_2 = $this->CopySingleFolder ( $o_folder, $new, $i, $n_uid );
			$old_2 = $o_folder->getFolderId ( $i );
			$this->CopyFolderForDigui ( $old_2, $new_2, $n_uid );
		}
	}
	private function CopySingleFile($o_from, $n_folderid, $i = NULL, $n_uid) {
		$o_file_3 = new Netdisk_File ();
		$o_file_3->setFilename ( $o_from->getFilename ( $i ) );
		$o_file_3->setOriginalFilename ( $o_from->getOriginalFilename ( $i ) );
		$o_file_3->setFilesize ( $o_from->getFilesize ( $i ) );
		$o_file_3->setDate ( $o_from->getDate ( $i ) );
		$o_file_3->setUid ( $n_uid );
		$o_file_3->setKeyWord ( $o_from->getKeyWord ( $i ) );
		$o_file_3->setPath ( $o_from->getPath ( $i ) );
		$o_file_3->setCrc ( $o_from->getCrc ( $i ) );
		$o_file_3->setSuffix ( $o_from->getSuffix ( $i ) );
		$o_file_3->setFolderId ( $n_folderid );
		$o_file_3->Save ();
		//计算网盘空间
		$o_space = new Netdisk_Space ( $n_uid );
		$o_space->setFree ( $o_space->getFree () - $o_from->getFilesize ( $i ) );
		$o_space->setUse ( $o_space->getUse () + $o_from->getFilesize ( $i ) );
		$o_space->Save ();
	
		/////////////////
	}
	private function CopySingleFolder($o_from, $o_folderid, $i, $n_uid) {
		$o_file_3 = new Netdisk_Folder ();
		$o_file_3->setFolderName ( $o_from->getFolderName ( $i ) );
		$o_file_3->setDate ( $o_from->getDate ( $i ) );
		$o_file_3->setUid ( $n_uid );
		$o_file_3->setParentId ( $o_folderid );
		$o_file_3->Save ();
		return $o_file_3->getFolderId ();
	}
	public function CopyFileAndReplace($n_fileid, $n_folderid, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			$o_file = new Netdisk_File ( $n_fileid );
			if ($o_file->getUid () == $n_uid || $this->ValidShare ( $n_fileid, $n_uid )) {
				//检测有无重名
				$o_file_2 = new Netdisk_File ();
				$o_file_2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_file_2->PushWhere ( array ('&&', 'FolderId', '=', $n_folderid ) );
				$o_file_2->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
				$o_file_2->PushWhere ( array ('&&', 'Filename', '=', $o_file->getFilename () ) );
				$n_count = $o_file_2->getAllCount ();
				for($i = 0; $i < $n_count; $i ++) {
					$o_file_3 = new Netdisk_File ( $o_file_2->getFileId ( $i ) );
					$o_file_3->setDelete ( 1 );
					$o_file_3->setDeleteDate ( $this->GetDateNow () );
					$o_file_3->setOriginalPath ( $this->getOriginalPath ( $o_file_2->getFolderId ( $i ) ) );
					$o_file_3->Save ();
				}
				$o_file_3 = new Netdisk_File ();
				$o_file_3->setFilename ( $o_file->getFilename () );
				$o_file_3->setOriginalFilename ( $o_file->getOriginalFilename () );
				$o_file_3->setFilesize ( $o_file->getFilesize () );
				$o_file_3->setDate ( $o_file->getDate () );
				$o_file_3->setUid ( $n_uid );
				$o_file_3->setKeyWord ( $o_file->getKeyWord () );
				$o_file_3->setPath ( $o_file->getPath () );
				$o_file_3->setCrc ( $o_file->getCrc () );
				$o_file_3->setSuffix ( $o_file->getSuffix () );
				$o_file_3->setFolderId ( $n_folderid );
				$o_file_3->Save ();
				//计算网盘空间
				$o_space = new Netdisk_Space ( $n_uid );
				$o_space->setFree ( $o_space->getFree () - $o_file->getFilesize () );
				$o_space->setUse ( $o_space->getUse () + $o_file->getFilesize () );
				$o_space->Save ();
			
		/////////////////
			}
		}
	}
	private function getOriginalPath($n_id) {
		$s_path = '';
		while ( $n_id > 0 ) {
			$o_folder = new Netdisk_Folder ( $n_id );
			$s_path = '&nbsp;/&nbsp;' . $o_folder->getFolderName () . $s_path;
			$n_id = $o_folder->getParentId ();
		}
		return $s_path;
	}
	public function CopyFolderAndReplace($n_folderid, $n_folderidto, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			$o_file = new Netdisk_Folder ( $n_folderid );
			if ($o_file->getUid () == $n_uid || $this->ValidShare ( $n_folderid, $n_uid )) {
				if ($o_file->getParentId () == $n_folderidto && $o_file->getUid () == $n_uid) {
					return;
				}
				//检测有无重名
				$o_file_2 = new Netdisk_Folder ();
				$o_file_2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_file_2->PushWhere ( array ('&&', 'ParentId', '=', $n_folderidto ) );
				$o_file_2->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
				$o_file_2->PushWhere ( array ('&&', 'FolderName', '=', $o_file->getFolderName () ) );
				$n_count = $o_file_2->getAllCount ();
				for($i = 0; $i < $n_count; $i ++) {
					$this->RealDeleteSingleFolder ( $o_file_2->getFolderId ( $i ) );
				}
				$o_file_3 = new Netdisk_Folder ();
				$o_file_3->setFolderName ( $o_file->getFolderName () );
				$o_file_3->setDate ( $o_file->getDate () );
				$o_file_3->setUid ( $n_uid );
				$o_file_3->setParentId ( $n_folderidto );
				$o_file_3->Save ();
				$n_new = $o_file_3->getFolderId ();
				$this->CopyFolderForDigui ( $n_folderid, $n_new, $n_uid );
			}
		}
	}
	public function MoveFolderAndReplace($n_folderid, $n_folderidto, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			$o_file = new Netdisk_Folder ( $n_folderid );
			$n_parentid = $o_file->getParentId ();
			if ($o_file->getUid () == $n_uid) {
				if ($o_file->getParentId () == $n_folderidto && $o_file->getDelete () == 0) {
					return;
				}
				//检测有无重名
				$o_file_2 = new Netdisk_Folder ();
				$o_file_2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_file_2->PushWhere ( array ('&&', 'ParentId', '=', $n_folderidto ) );
				$o_file_2->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
				$o_file_2->PushWhere ( array ('&&', 'FolderName', '=', $o_file->getFolderName () ) );
				$n_count = $o_file_2->getAllCount ();
				for($i = 0; $i < $n_count; $i ++) {
					$this->RealDeleteSingleFolder ( $o_file_2->getFolderId ( $i ) );
				}
				$o_file->setParentId ( $n_folderidto );
				$o_file->setDelete ( 0 );
				$o_file->Save ();
				return $n_parentid;
			}
		}
	}
	private function RealDeleteSingleFolder($n_folder_id) { //彻底删除文件夹
		$o_folder = new Netdisk_Folder ( $n_folder_id ); //先删除这个文件夹的记录
		$o_folder->Deletion ();
		$o_folder = new Netdisk_Folder ();
		//$o_folder->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_folder->PushWhere ( array ('&&', 'ParentId', '=', $n_folder_id ) );
		$n_count_folder = $o_folder->getAllCount ();
		//先把文件复制号
		$o_file = new Netdisk_File ();
		//$o_file->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_file->PushWhere ( array ('&&', 'FolderId', '=', $n_folder_id ) );
		$n_count_file = $o_file->getAllCount ();
		for($i = 0; $i < $n_count_file; $i ++) {
			$this->RealDeleteSingleFile ( $o_file->getFileId ( $i ) );
		}
		for($i = 0; $i < $n_count_folder; $i ++) { //删除文件夹，然后递归
			$this->RealDeleteSingleFolder ( $o_folder->getFolderId ( $i ) );
		}
	}
	private function RealDeleteSingleFile($n_file_id) { //彻底删除文件
		$o_file = new Netdisk_File ( $n_file_id );
		if ($o_file->getPath () != '') {
			$o_file2 = new Netdisk_File ();
			//查找其他记录有没有利用到这个实际文件，如果有，只删除记录，不删除文件。
			$o_file2->PushWhere ( array ('&&', 'Path', '=', $o_file->getPath () ) );
			$o_file2->PushWhere ( array ('&&', 'FileId', '<>', $n_file_id ) );
			$n_count_file = $o_file2->getAllCount ();
			if ($n_count_file == 0) {
				//删除实际文件
				$this->DeleteDir ( RELATIVITY_PATH . $o_file->getPath () );
			}
		
		//计算网盘空间
		//$o_space = new Netdisk_Space ( $o_file->getUid () );
		//$o_space->setFree ( $o_space->getFree () + $o_file->getFilesize () );
		//$o_space->setUse ( $o_space->getUse () - $o_file->getFilesize () );
		//$o_space->Save ();
		/////////////////
		}
		$o_file->Deletion ();
	}
	public function getFolderForMyDisk($parent_id) {
		$o_tree = new Netdisk_Folder ();
		$o_tree->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_tree->PushWhere ( array ('&&', 'ParentId', '=', $parent_id ) );
		$o_tree->PushOrder ( array ('FolderName', 'A' ) );
		$n_count = $o_tree->getAllCount ();
		$this->FolderName = '';
		$this->FolderId = '';
		for($i = 0; $i < $n_count; $i ++) {
			$this->FolderName .= $o_tree->getFolderName ( $i ) . '<1>';
			$this->FolderId .= $o_tree->getFolderId ( $i ) . '<1>';
		}
		if ($n_count > 0) {
			$this->FolderName = substr ( $this->FolderName, 0, count ( $this->FolderName ) - 4 );
			$this->FolderId = substr ( $this->FolderId, 0, count ( $this->FolderId ) - 4 );
		}
	
	}
	public function getFolderForSharePath($n_id, $n_uid) {
		$o_tree = new Netdisk_Folder ( $n_id );
		$n_find = false;
		while ( $n_find === false ) {
			if (strpos ( $o_tree->getShareUid (), '<1>' . $n_uid . '<1>' ) === false) {
				if ($o_tree->getParentId () == 0) {
					break;
				}
				$o_tree = new Netdisk_Folder ( $o_tree->getParentId () );
			} else {
				$n_find = true;
			}
		}
		if ($n_find === false) {
			return;
		}
		$o_tree = new Netdisk_Folder ();
		$o_tree->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_tree->PushWhere ( array ('&&', 'ParentId', '=', $n_id ) );
		$o_tree->PushOrder ( array ('FolderName', 'A' ) );
		$n_count = $o_tree->getAllCount ();
		$this->FolderName = '';
		$this->FolderId = '';
		for($i = 0; $i < $n_count; $i ++) {
			$this->FolderName .= $o_tree->getFolderName ( $i ) . '<1>';
			$this->FolderId .= $o_tree->getFolderId ( $i ) . '<1>';
		}
		if ($o_tree->getAllCount () > 0) {
			$this->FolderName = substr ( $this->FolderName, 0, count ( $this->FolderName ) - 4 );
			$this->FolderId = substr ( $this->FolderId, 0, count ( $this->FolderId ) - 4 );
		}
	}
	public function getFolderForShareRoot($n_share_uid, $n_uid) {
		$o_tree = new Netdisk_Folder ();
		$o_tree->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_tree->PushWhere ( array ('&&', 'Uid', '=', $n_share_uid ) );
		$o_tree->PushWhere ( array ('&&', 'ShareUid', 'LIKE', '%<1>' . $n_uid . '<1>%' ) );
		$o_tree->PushOrder ( array ('FolderName', 'A' ) );
		$n_count = $o_tree->getAllCount ();
		$this->FolderName = '';
		$this->FolderId = '';
		for($i = 0; $i < $n_count; $i ++) {
			$this->FolderName .= $o_tree->getFolderName ( $i ) . '<1>';
			$this->FolderId .= $o_tree->getFolderId ( $i ) . '<1>';
		}
		if ($o_tree->getAllCount () > 0) {
			$this->FolderName = substr ( $this->FolderName, 0, count ( $this->FolderName ) - 4 );
			$this->FolderId = substr ( $this->FolderId, 0, count ( $this->FolderId ) - 4 );
		}
	}
	public function DeleteFile($n_fileid, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			$o_file = new Netdisk_File ( $n_fileid );
			if ($o_file->getUid () == $n_uid) {
				$o_file->setDelete ( 1 );
				$o_file->setDeleteDate ( $this->GetDateNow () );
				$o_file->setOriginalPath ( $this->getOriginalPath ( $o_file->getFolderId () ) );
				$o_file->Save ();
			}
		}
	}
	private function getSubDirectory($n_folderid) {
		$o_dir = new Netdisk_Folder ();
		$o_dir->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_dir->PushWhere ( array ('&&', 'ParentId', '=', $n_folderid ) );
		$n_count = $o_dir->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			array_push ( $this->A_FolderId, $o_dir->getFolderId ( $i ) );
			$this->getSubDirectory ( $o_dir->getFolderId ( $i ) );
		}
	}
	public function DeleteFolder($n_fileid, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70002 )) {
			//检测有无文件
			$o_file = new Netdisk_File ();
			$this->getSubDirectory ( $n_fileid );
			array_push ( $this->A_FolderId, $n_fileid );
			for($i = 0; $i < count ( $this->A_FolderId ); $i ++) {
				
				$o_file->PushWhere ( array ('||', 'Delete', '=', 0 ) );
				$o_file->PushWhere ( array ('&&', 'FolderId', '=', $this->A_FolderId [$i] ) );
			}
			if ($o_file->getAllCount () > 0) {
				return - 1;
			}
			$o_folder = new Netdisk_Folder ( $n_fileid );
			$n_parentid = $o_folder->getParentId ();
			$this->RealDeleteFolder ( $n_fileid, $n_uid );
			/*			$o_folder = new Netdisk_Folder ( $n_fileid );
			if ($o_folder->getUid () == $n_uid) {
				$o_folder->setDelete ( 1 );
				$o_folder->setDeleteDate ( $this->GetDateNow () );
				$o_folder->setOriginalPath ( $this->getOriginalPath ( $o_folder->getParentId () ) );
				$o_folder->Save ();
			}*/
		}
		return $n_parentid;
	}
	public function RealDeleteFolder($n_fileid, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70002 )) {
			$o_file = new Netdisk_Folder ( $n_fileid );
			$this->RealDeleteSingleFolder ( $n_fileid );
		}
	}
	public function RealDeleteFile($n_fileid, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			$o_file = new Netdisk_File ( $n_fileid );
			if ($o_file->getUid () == $n_uid) {
				$this->RealDeleteSingleFile ( $n_fileid );
			}
		}
	}
	public function ClearAll($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			//清空已删除的文件夹
			$o_tree = new Netdisk_Folder ();
			$o_tree->PushWhere ( array ('&&', 'Delete', '=', 1 ) );
			$o_tree->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
			$n_count = $o_tree->getAllCount ();
			for($i = 0; $i < $n_count; $i ++) {
				$this->RealDeleteSingleFolder ( $o_tree->getFolderId ( $i ) );
			}
			//清空已删除的文件
			$o_file = new View_Netdisk_File ();
			$o_file->PushWhere ( array ('&&', 'Delete', '=', 1 ) );
			$o_file->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
			$n_count = $o_file->getAllCount ();
			for($i = 0; $i < $n_count; $i ++) {
				$this->RealDeleteSingleFile ( $o_file->getFileId ( $i ) );
			}
		}
	}
	public function getResult() {
		return $this->Result;
	}
	public function DeleteAll($s_folder_id, $s_file_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			if ($s_folder_id != '') {
				$a_folder_id = explode ( "<1>", $s_folder_id );
			} else {
				$a_folder_id = Array ();
			}
			if ($s_file_id != '') {
				$a_file_id = explode ( "<1>", $s_file_id );
			} else {
				$a_file_id = Array ();
			}
			for($i = 0; $i < count ( $a_folder_id ); $i ++) {
				//复制文件夹
				$o_folder = new Netdisk_Folder ( $a_folder_id [$i] );
				$o_folder->setDelete ( 1 );
				$o_folder->setDeleteDate ( $this->GetDateNow () );
				$o_folder->setOriginalPath ( $this->getOriginalPath ( $o_folder->getParentId () ) );
				$o_folder->Save ();
				$this->ParentId = $o_folder->getParentId ();
			}
			for($i = 0; $i < count ( $a_file_id ); $i ++) {
				$o_file = new Netdisk_File ( $a_file_id [$i] );
				$o_file->setDelete ( 1 );
				$o_file->setDeleteDate ( $this->GetDateNow () );
				$o_file->setOriginalPath ( $this->getOriginalPath ( $o_file->getFolderId () ) );
				$o_file->Save ();
				$this->ParentId = $o_file->getFolderId ();
			}
		}
	}
	public function RealDeleteAll($s_folder_id, $s_file_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			if ($s_folder_id != '') {
				$a_folder_id = explode ( "<1>", $s_folder_id );
			} else {
				$a_folder_id = Array ();
			}
			if ($s_file_id != '') {
				$a_file_id = explode ( "<1>", $s_file_id );
			} else {
				$a_file_id = Array ();
			}
			for($i = 0; $i < count ( $a_folder_id ); $i ++) {
				//删除文件夹
				$this->RealDeleteFolder ( $a_folder_id [$i], $n_uid );
			}
			for($i = 0; $i < count ( $a_file_id ); $i ++) {
				$this->RealDeleteFile ( $a_file_id [$i], $n_uid );
			}
		}
	}
	public function Reduction($n_id, $n_type, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			if ($n_type == 1) {
				//还原文件夹
				$o_folder = new Netdisk_Folder ( $n_id );
				//查找有无相同文件夹
				$o_folder2 = new Netdisk_Folder ();
				$o_folder2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_folder2->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
				$o_folder2->PushWhere ( array ('&&', 'ParentId', '=', $o_folder->getParentId () ) );
				$o_folder2->PushWhere ( array ('&&', 'FolderName', '=', $o_folder->getFolderName () ) );
				$n_count = $o_folder2->getAllCount ();
				if ($n_count > 0) {
					//存在相同文件夹，是否替换
					return 2;
				}
				//检验是否父文件夹已经删除
				if ($o_folder->getParentId () > 0) {
					$o_folder2 = $o_folder;
					do {
						$o_folder2 = new Netdisk_Folder ( $o_folder2->getParentId () );
						if ($o_folder2->getFolderName () === false) {
							//父文件夹已经删除，是否还原到“回收站还原”文件夹中
							return 3;
						}
						if ($o_folder2->getDelete () == 1) {
							//父文件夹已经删除，是否还原到“回收站还原”文件夹中
							return 3;
						}
					} while ( $o_folder2->getParentId () > 0 );
				}
				//开始还原
				$o_folder->setDelete ( 0 );
				$o_folder->Save ();
				$this->ParentId = $o_folder->getParentId ();
			} else {
				//还原文件
				$o_file = new Netdisk_File ( $n_id );
				//查找有无相同文件夹
				$o_file2 = new Netdisk_File ();
				$o_file2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_file2->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
				$o_file2->PushWhere ( array ('&&', 'FolderId', '=', $o_file->getFolderId () ) );
				$o_file2->PushWhere ( array ('&&', 'Filename', '=', $o_file->getFilename () ) );
				$n_count = $o_file2->getAllCount ();
				if ($n_count > 0) {
					//存在相同文件，是否替换
					return 2;
				}
				//检验是否父文件夹已经删除
				if ($o_file->getFolderId () > 0) {
					$o_folder2 = new Netdisk_Folder ( $o_file->getFolderId () );
					while ( $o_folder2->getParentId () > 0 ) {
						if ($o_folder2->getFolderName () === false) {
							//父文件夹已经删除，是否还原到“回收站还原”文件夹中
							return 3;
						}
						if ($o_folder2->getDelete () == 1) {
							//父文件夹已经删除，是否还原到“回收站还原”文件夹中
							return 3;
						}
						$o_folder2 = new Netdisk_Folder ( $o_folder2->getParentId () );
					}
				}
				//开始还原
				$o_file->setDelete ( 0 );
				$o_file->Save ();
			}
			return 1;
		}
	}
	public function ReductionReplace($n_id, $n_type, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			if ($n_type == 1) {
				// 还原替换文件夹
				$o_file = new Netdisk_Folder ( $n_id );
				$this->MoveFolderAndReplace ( $n_id, $o_file->getParentId (), $n_uid );
				$this->ParentId = $o_file->getParentId ();
			} else {
				//还原替换文件
				$o_file = new Netdisk_File ( $n_id );
				$this->MoveFileAndReplace ( $n_id, $o_file->getFolderId (), $n_uid );
			}
		
		}
	}
	public function ReductionDefault($n_id, $n_type, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70001 )) {
			//判断存不存在“回收站还原”文件夹，如果不存在，新建并读取folderid，如果存在直接读取folderid，
			$o_folder = new Netdisk_Folder ();
			$o_folder = new Netdisk_Folder ();
			$o_folder->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_folder->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
			$o_folder->PushWhere ( array ('&&', 'ParentId', '=', 0 ) );
			$o_folder->PushWhere ( array ('&&', 'FolderName', '=', '回收站还原' ) );
			if ($o_folder->getAllCount () > 0) {
				//直接读取
				$n_folderid = $o_folder->getFolderId ( 0 );
			} else {
				//新建
				$o_folder = new Netdisk_Folder ();
				$o_folder->setFolderName ( '回收站还原' );
				$o_folder->setDate ( $this->GetDateNow () );
				$o_folder->setUid ( $n_uid );
				$o_folder->setParentId ( 0 );
				$o_folder->Save ();
				$n_folderid = $o_folder->getFolderId ();
			}
			if ($n_type == 1) {
				// 还原替换文件夹
				$o_file = new Netdisk_Folder ( $n_id );
				$this->MoveFolderAndReplace ( $n_id, $n_folderid, $n_uid );
			
		//如果还有相同的名称，不提示，直接覆盖
			} else {
				//还原替换文件
				$o_file = new Netdisk_File ( $n_id );
				$this->MoveFileAndReplace ( $n_id, $n_folderid, $n_uid );
			
		//如果还有相同的名称，不提示，直接覆盖
			}
		
		}
	}
	public function getFolderForDirectory($parent_id) {
		$o_tree = new Netdisk_Folder ();
		$o_tree->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_tree->PushWhere ( array ('&&', 'ParentId', '=', $parent_id ) );
		$o_tree->PushOrder ( array ('FolderName', 'A' ) );
		$n_count = $o_tree->getAllCount ();
		$this->FolderName = '';
		$this->FolderId = '';
		for($i = 0; $i < $n_count; $i ++) {
			$this->FolderName .= $o_tree->getFolderName ( $i ) . '<1>';
			$this->FolderId .= $o_tree->getFolderId ( $i ) . '<1>';
		}
		if ($n_count > 0) {
			$this->FolderName = substr ( $this->FolderName, 0, count ( $this->FolderName ) - 4 );
			$this->FolderId = substr ( $this->FolderId, 0, count ( $this->FolderId ) - 4 );
		}
	
	}
	public function UpLoadPicture($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		//验证上传图片的大小不能大于2MB		
		if ($o_user->ValidModule ( 70001 )) {
			$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Filedata'] ['name'], '.' ), 1 ) ) );
			mkdir ( RELATIVITY_PATH . 'userdata/' . md5 ( $o_user->getUserName () ), 0700 );
			mkdir ( RELATIVITY_PATH . 'userdata/' . md5 ( $o_user->getUserName () ) . '/resources', 0700 );
			$o_path = md5 ( $_FILES ['Filedata'] ['name'] . $n_uid . rand ( 0, 9999 ) . $this->GetTimeCut () );
			mkdir ( RELATIVITY_PATH . 'userdata/' . md5 ( $o_user->getUserName () ) . '/resources/' . $o_path, 0700 );
			$filename = $_FILES ['Filedata'] ['name'];
			$fileext = strtolower ( trim ( substr ( strrchr ( $filename, '.' ), 1 ) ) );
			$o_filename = md5 ( $filename ) . '.' . $fileext;
			$o_to = RELATIVITY_PATH . 'userdata/' . md5 ( $o_user->getUserName () ) . '/resources/' . $o_path . '/' . $o_filename;
			//计算网盘空间
			$filesize = floor ( $_FILES ['Filedata'] ['size'] / 1024 );
			//在数据库中保存文件信息
			$o_file = new Netdisk_File ();
			$o_file->setFilename ( $filename );
			$o_file->setOriginalFilename ( $o_filename );
			$o_file->setFilesize ( $filesize );
			$o_path = 'userdata/' . md5 ( $o_user->getUserName () ) . '/resources/' . $o_path;
			$o_file->setPath ( $o_path );
			//设置文件后缀信息
			$o_suffix = new Netdisk_Type ( $fileext );
			if ($o_suffix->getClassName () == false) {
				$o_file->setSuffix ( 'other' );
			} else {
				$o_file->setSuffix ( $fileext );
			}
			$o_file->setDate ( $this->GetDateNow () );
			$o_file->setUid ( $n_uid );
			
			$o_file->setFolderId ( $_COOKIE ['FOLDERID'] );
			$o_file->Save ();
			copy ( $_FILES ['Filedata'] ['tmp_name'], $o_to );
		}
	}
}

?>