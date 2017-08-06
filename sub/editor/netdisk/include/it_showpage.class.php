<?php
require_once RELATIVITY_PATH . 'sub/netdisk/include/db_table.class.php';
require_once RELATIVITY_PATH . 'sub/netdisk/include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/it_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
class ShowPage extends It_Basic {
	protected $O_SingleUser;
	protected $A_FolderId = array ();	
	public function __construct($o_singleUser) {
		$this->O_SingleUser = $o_singleUser;
	}	
	public function getNetDiskFileList($n_folderid) {
		$o_tree = new Netdisk_Folder();
		$o_tree->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_tree->PushWhere ( array ('&&', 'ParentId', '=', $n_folderid ) );
		$o_tree->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_tree->PushOrder ( array ('FolderName', 'A' ) );
		$n_count = $o_tree->getAllCount ();
		if ($n_folderid>0)
		{
			//查询上级目录的编号
			$o_tree2 = new Netdisk_Folder($n_folderid);
			//加入一个向上按钮			
			$html .= '
			<div class="folderoff">
	            <div style="margin-top:19px">
	                <div class="icon" ondblclick="goUp('.$o_tree2->getParentId ().')">
	                    <div class="img goup">
	                    </div>
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name" style="margin-bottom:16px">
	               <strong>返回</strong>
	            </div>
	        </div>
       ';
		}
		for($i = 0; $i < $n_count; $i ++) {
			$html .= '
			<div class="folderoff">
	            <div style="margin-top:19px">
	                <div class="icon" ondblclick="goIn(' . $o_tree->getFolderId ( $i ) . ')">
	                    <div class="img folder">
	                    </div>
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name" style="margin-bottom:16px">
	                ' . $o_tree->getFolderName ( $i ) . '
	            </div>
	        </div>
       ';
		
		}
		$o_file = new View_Netdisk_File();
		$o_file->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_file->PushWhere ( array ('&&', 'FolderId', '=', $n_folderid ) );
		$o_file->PushWhere ( array ('&&', 'ClassName', '=', 'image' ) );
		$o_file->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_file->PushOrder ( array ('Filename', 'A' ) );
		$n_count = $o_file->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			//如果是图片，双击后打开。
			$html .= '
			<div title="' . $o_file->getFilename ( $i ) . '" onclick="selected(this,\'/' .$o_file->getPath ( $i ) . '/' . $o_file->getOriginalFilename ( $i ) . '\')" class="off">
	            <div>
	                <div class="icon" style="width:100px;height:68px">
	                    <div><img src="/' .$o_file->getPath ( $i ) . '/' . $o_file->getOriginalFilename ( $i ) . '" alt="" align="absmiddle" style="width:100px; height:68px"/></div>
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name">
	                ' . $this->AilterFileName ( $o_file->getFilename ( $i ) ) . '
	            </div>

	        </div>';
		
		}
		return $html;
	}	
	private function AilterFileName($s_text) {
		$a_key = explode ( ".", $s_text );
		if (count ( $a_key ) > 1) {
			return $this->CutStr ( $a_key [0], 13 ) . '.' . $a_key [1];
		} else {
			return $this->CutStr ( $a_key [0], 13);
		}
	}
public function getNetDiskFileListForAttchment($n_folderid) {
		$o_tree = new Netdisk_Folder();
		$o_tree->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_tree->PushWhere ( array ('&&', 'ParentId', '=', $n_folderid ) );
		$o_tree->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_tree->PushOrder ( array ('FolderName', 'A' ) );
		$n_count = $o_tree->getAllCount ();
		if ($n_folderid>0)
		{
			//查询上级目录的编号
			$o_tree2 = new Netdisk_Folder($n_folderid);
			//加入一个向上按钮			
			$html .= '
			<div class="folderoff">
	            <div style="margin-top:19px">
	                <div class="icon" ondblclick="goUpAttachMent('.$o_tree2->getParentId ().')">
	                    <div class="img goup">
	                    </div>
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name" style="margin-bottom:16px">
	               <strong>返回</strong>
	            </div>
	        </div>
       ';
		}
		for($i = 0; $i < $n_count; $i ++) {
			$html .= '
			<div class="folderoff">
	            <div style="margin-top:19px">
	                <div class="icon" ondblclick="goInAttachMent(' . $o_tree->getFolderId ( $i ) . ')">
	                    <div class="img folder">
	                    </div>
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name" style="margin-bottom:16px">
	                ' . $o_tree->getFolderName ( $i ) . '
	            </div>
	        </div>
       ';
		
		}
		$o_file = new View_Netdisk_File();
		$o_file->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_file->PushWhere ( array ('&&', 'FolderId', '=', $n_folderid ) );
		$o_file->PushWhere ( array ('&&', 'ClassName', '<>', 'image' ) );
		$o_file->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_file->PushOrder ( array ('Filename', 'A' ) );
		$n_count = $o_file->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			//如果是图片，双击后打开。
			$html .= '
			<div title="/' . $o_file->getFilename ( $i ) . '" onclick="selectedFile(this,\'/sub/netdisk/file_download.php?fileid='.$o_file->getFileId ( $i ).'\',\''.$o_file->getFilename ( $i ).'\',\''.$o_file->getSuffix ( $i ).'\')" class="off">
	            <div>
	                <div class="icon" style="margin-top:19px">
	                    <div class="img '.$o_file->getClassName($i).'"></div>
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name" style="margin-bottom:16px">
	                ' . $this->AilterFileName ( $o_file->getFilename ( $i ) ) . '
	            </div>

	        </div>';
		
		}
		return $html;
	}	
	
}

?>