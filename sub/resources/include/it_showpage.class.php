<?php
require_once 'db_table.class.php';
require_once 'db_view.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'include/it_basic.class.php';
class ShowPage extends It_Basic {
	protected $O_SingleUser;
	protected $A_FolderId = array ();
	public function __construct($o_singleUser) {
		$this->O_SingleUser = $o_singleUser;
		
		$this->N_PageSize = 20;
	}
	public function getTotalSpace() {
		$o_space = new Netdisk_Space ( $this->O_SingleUser->getUid () );
		return $this->getFilesize ( $o_space->getTotal () );
	}
	public function getFreeSpace() {
		$o_space = new Netdisk_Space ( $this->O_SingleUser->getUid () );
		return $this->getFilesize ( $o_space->getFree () );
	}
	public function getMyDiskRoot() {
		if ($this->O_SingleUser->ValidModule ( 70002 )==false)
		{
			return;
		}
		$o_tree = new Netdisk_Folder ();
		$o_tree->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_tree->PushWhere ( array ('&&', 'ParentId', '=', 0 ) );
		$o_tree->PushOrder ( array ('FolderName', 'A' ) );
		$n_count = $o_tree->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$html .= '                  <li>
                                            <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                                                <img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" onclick="openPath(this,' . $o_tree->getFolderId ( $i ) . ')" />
                                                <img src="../../images/notify_open.gif" alt="" align="absmiddle"/>
                                                <a id="path_' . $o_tree->getFolderId ( $i ) . '" href="javascript:;" title="' . $o_tree->getFolderName ( $i ) . '" style=" font-weight:normal" ondblclick="openPath(this,' . $o_tree->getFolderId ( $i ) . ')" onclick="nameAddBold(this);goTo(\'explorer.php?folderid=' . $o_tree->getFolderId ( $i ) . '\');document.getElementById(\'Vcl_FolderId\').value=' . $o_tree->getFolderId ( $i ) . ';">
                                                    	' . $o_tree->getFolderName ( $i ) . '
                                                </a>
                                                <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>
                                            </span>                                            
                                        </li>
                                        ';
		
		}
		if ($n_count > 0) {
			$html = '<ul>' . $html . '</ul>';
		}
		return '             <ul class="dynatree-container" style="margin-bottom:10px; padding:0px">
                                <li>
                                    <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                                        <img src="../../images/file_tree/root.png" alt="" align="absmiddle" style="width:32px; height:32px; display:none"/>
                                        <img src="../../images/file_tree/root.png" alt="" align="absmiddle" style="width:32px; height:32px"/>
                                        <a href="javascript:;" title="资料管理"  id="path_0" style="font-size:14px; margin-top:5px" ondblclick="openPath(this,-1)" onclick="nameAddBold(this);goTo(\'explorer.php?folderid=0\');">资料管理
                                        </a>
                                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>
                                    </span>
                                    ' . $html . '
                                </li>
                            </ul>';
	}
	public function getRecycle() {
		if ($this->O_SingleUser->ValidModule ( 70002 )==false)
		{
			return;
		}
		return '             <ul class="dynatree-container" style="margin-bottom:10px; padding:0px">
                                <li>
                                    <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                                        <img src="../../images/file_tree/root.png" alt="" align="absmiddle" style="width:32px; height:32px; display:none"/>
                                        <img src="../../images/file_tree/recycle.png" alt="" align="absmiddle" style="width:32px; height:32px"/>
                                        <a href="javascript:;" title="回收站" style="font-size:14px; margin-top:5px;font-weight:normal" onclick="nameAddBold(this);goTo(\'explorer_recycle.php\');">回收站
                                        </a>
                                    </span>
                                    </li>
                              </ul>';
	}
	public function getShareRoot() {
		if ($this->O_SingleUser->ValidModule ( 70002 )==true)
		{
			return;
		}
		$o_tree = new Netdisk_Folder ();
		$o_tree->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_tree->PushWhere ( array ('&&', 'ParentId', '=', 0 ) );
		$o_tree->PushOrder ( array ('FolderName', 'A' ) );
		$n_count = $o_tree->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$html .= '                  <li>
                                            <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                                                <img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" onclick="openPathShare(this,' . $o_tree->getFolderId ( $i ) . ')" />
                                                <img src="../../images/notify_open.gif" alt="" align="absmiddle"/>
                                                <a id="share_' . $o_tree->getFolderId ( $i ) . '" href="javascript:;" title="' . $o_tree->getFolderName ( $i ) . '" style=" font-weight:normal" ondblclick="openPathShare(this,' . $o_tree->getFolderId ( $i ) . ')" onclick="nameAddBold(this);goTo(\'explorer_share.php?folderid=' . $o_tree->getFolderId ( $i ) . '\');document.getElementById(\'Vcl_FolderId\').value=' . $o_tree->getFolderId ( $i ) . ';">
                                                    	' . $o_tree->getFolderName ( $i ) . '
                                                </a>
                                                <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>
                                            </span>                                            
                                        </li>
                                        ';
		
		}
		if ($n_count > 0) {
			$html = '<ul>' . $html . '</ul>';
		}
		return '             <ul class="dynatree-container" style="margin-bottom:10px; padding:0px">
                                <li>
                                    <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                                        <img src="../../images/file_tree/root.png" alt="" align="absmiddle" style="width:32px; height:32px; display:none"/>
                                        <img src="../../images/file_tree/share.png" alt="" align="absmiddle" style="width:32px; height:32px"/>
                                        <a href="javascript:;" title="资源库"  id="share_0" style="font-size:14px; margin-top:5px" ondblclick="openPathShare(this,-1)" onclick="nameAddBold(this);goTo(\'explorer_share.php?folderid=0\');">资源库
                                        </a>
                                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>
                                    </span>
                                    ' . $html . '
                                </li>
                            </ul>';
	}
	public function getRecycleFileList() {
		$o_file = new View_Netdisk_File ();
		$o_file->PushWhere ( array ('&&', 'Delete', '=', 1 ) );
		$o_file->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_file->PushOrder ( array ('Filename', 'A' ) );
		$n_count = $o_file->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$s_filesize = $o_file->getFilesize ( $i );
			if ($o_file->getKeyWord ( $i ) == '') {
				$s_keyword = '<span></span>';
			} else {
				$s_keyword = '<span style="color:#999999">&nbsp;&nbsp;&nbsp;&nbsp;' . $o_file->getKeyWord ( $i ) . '</span>';
			}
			$s_filesize = $this->getFilesize ( $s_filesize );
			$html .= '                   <tr onmouseover="showButtonLine(this)" onmouseout="hideButtonLine(this)" onclick="selected(this)" class="off">
								            <td style="width:20px" class="off">
								                <input id="file_' . ($i + 1) . '" value="' . $o_file->getFileId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>
								            </td>
								            <td style="width:32px" class="icon">
								                <div class="icon"><div class="img ' . $o_file->getClassName ( $i ) . '"></div><div></div></div>
								            </td>
								            <td>
								            ' . $o_file->getFilename ( $i ) . $s_keyword . '<span style="color:#999999">&nbsp;&nbsp;&nbsp;&nbsp;目录：' . str_replace ( '/', '\\', $o_file->getOriginalPath ( $i ) ) . '</span>
								            </td>
								            <td style="width:100px">
								               <div><a href="file_download.php?fileid=' . $o_file->getFileId ( $i ) . '" onclick="selected(this.parentNode.parentNode.parentNode)" target="_blank">下载</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);reduction( ' . $o_file->getFileId ( $i ) . ',0);">还原</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);realDeleteFile( ' . $o_file->getFileId ( $i ) . ');">删除</a></div>
								            </td>
								            <td style="width:140px">
								               ' . $s_filesize . '
								            </td>
								            <td style="width:140px">
								                ' . $o_file->getDate ( $i ) . '
								            </td>
								            <td style="width:140px">
								                ' . $o_file->getDeleteDate ( $i ) . '
								            </td>
								        </tr>';
		
		}
		return $html;
	}
	public function getMyDiskFileList($n_folderid) {
		$o_tree = new Netdisk_Folder ();
		$o_tree->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_tree->PushWhere ( array ('&&', 'ParentId', '=', $n_folderid ) );
		//$o_tree->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_tree->PushOrder ( array ('FolderName', 'A' ) );
		$n_count = $o_tree->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$html .= '
			<div class="off">
	            <div>
	                <div class="icon" ondblclick="goIn(' . $o_tree->getParentId ( $i ) . ',' . $o_tree->getFolderId ( $i ) . ')">
	                    <div class="img folder">
	                    </div>
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name">
	                ' . $o_tree->getFolderName ( $i ) . '
	            </div>
	        </div>
       ';
		
		}
		$o_file = new View_Netdisk_File ();
		$o_file->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_file->PushWhere ( array ('&&', 'FolderId', '=', $n_folderid ) );
		$o_file->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_file->PushOrder ( array ('Filename', 'A' ) );
		$n_count = $o_file->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$s_filesize = $o_file->getFilesize ( $i );
			if ($o_file->getKeyWord ( $i ) == '') {
				$s_keyword = '<span></span>';
			} else {
				$s_keyword = '<span style="color:#999999">&nbsp;&nbsp;&nbsp;&nbsp;' . $o_file->getKeyWord ( $i ) . '</span>';
			}
			$s_date = $o_file->getDate ( $i );
			$s_date = explode ( " ", $s_date );
			$s_date = $s_date [0];
			$s_filesize = $this->getFilesize ( $s_filesize );
			//如果是图片，双击后打开。
			$s_icon = '<div class="img ' . $o_file->getClassName ( $i ) . '"></div>';
			$s_float = '';
			$s_width = '';
			if ($o_file->getClassName ( $i ) == 'image') {
				$s_dbclick = 'ondblclick="window.open(\'' . RELATIVITY_PATH . $o_file->getPath ( $i ) . '/' . $o_file->getOriginalFilename ( $i ) . '\',\'_blank\');selected(this.parentNode.parentNode);"';
				$s_icon = '<div><img src="' . RELATIVITY_PATH . $o_file->getPath ( $i ) . '/' . $o_file->getOriginalFilename ( $i ) . '" alt="" align="absmiddle" style="width:120px; height:50px"/></div>';
				$s_float = ' style="float:left;"';
				$s_width = ' style="width:120px;height:50px"';
			} else if ($o_file->getPath ( $i ) == '') {
				$s_dbclick = 'ondblclick="parent.parent.parent.open(\'' . $o_file->getUrl ( $i ) . '\');selected(this.parentNode.parentNode);"';
			} else {
				$s_dbclick = 'ondblclick="window.open(\'file_download.php?fileid=' . $o_file->getFileId ( $i ) . '\',\'\',\'_blank\');selected(this.parentNode.parentNode);"';
			}
			if ($o_file->getPath ( $i ) == '') {
				$s_button = '<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);fileRename( ' . $o_file->getFileId ( $i ) . ',\'' . $o_file->getFilename ( $i ) . '\',\'' . $o_file->getKeyWord ( $i ) . '\');">编辑</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFile(' . $o_file->getFileId ( $i ) . ');">复制</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);moveFile(' . $o_file->getFileId ( $i ) . ');">移动</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);deleteFile( ' . $o_file->getFileId ( $i ) . ');">删除</a>';
			} else {
				$s_button = '<a href="file_download.php?fileid=' . $o_file->getFileId ( $i ) . '" onclick="selected(this.parentNode.parentNode.parentNode)" target="_blank">下载</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);fileRename( ' . $o_file->getFileId ( $i ) . ',\'' . $o_file->getFilename ( $i ) . '\',\'' . $o_file->getKeyWord ( $i ) . '\');">编辑</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFile(' . $o_file->getFileId ( $i ) . ');">复制</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);moveFile(' . $o_file->getFileId ( $i ) . ');">移动</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);deleteFile( ' . $o_file->getFileId ( $i ) . ');">删除</a>';
			}
			//如果是其他的，双击后下载。		
			$html .= '
			<div title="' . $o_file->getFilename ( $i ) . '" onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
	            <div' . $s_float . '>
	                <input id="file_' . ($i + 1) . '" value="' . $o_file->getFileId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>
	            </div>
	            <div>
	                <div class="icon" ' . $s_dbclick . $s_width . '>
	                    ' . $s_icon . '
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name">
	                ' . $this->AilterFileName ( $o_file->getFilename ( $i ) ) . '
	            </div>
	            <div class="file_info">
	                ' . $s_filesize . ' | ' . $s_date . ' | ' . $o_file->getUserName ( $i ) . '
	            </div>
	            <div class="button_box">
	            <div class="button">
	                ' . $s_button . '</div>
	            </div>
	        </div>';
		
		}
		return $html;
	}
	public function getShareFileList($n_folderid) {
		$o_tree = new Netdisk_Folder ();
		$o_tree->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_tree->PushWhere ( array ('&&', 'ParentId', '=', $n_folderid ) );
		//$o_tree->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_tree->PushOrder ( array ('FolderName', 'A' ) );
		$n_count = $o_tree->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$html .= '
			<div class="off">
	            <div>
	                <div class="icon" ondblclick="goInShare(' . $o_tree->getParentId ( $i ) . ',' . $o_tree->getFolderId ( $i ) . ')">
	                    <div class="img folder">
	                    </div>
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name">
	                ' . $o_tree->getFolderName ( $i ) . '
	            </div>
	        </div>
       ';
		
		}
		$o_file = new View_Netdisk_File ();
		$o_file->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_file->PushWhere ( array ('&&', 'FolderId', '=', $n_folderid ) );
		//$o_file->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_file->PushOrder ( array ('Filename', 'A' ) );
		$n_count = $o_file->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$s_filesize = $o_file->getFilesize ( $i );
			if ($o_file->getKeyWord ( $i ) == '') {
				$s_keyword = '<span></span>';
			} else {
				$s_keyword = '<span style="color:#999999">&nbsp;&nbsp;&nbsp;&nbsp;' . $o_file->getKeyWord ( $i ) . '</span>';
			}
			$s_date = $o_file->getDate ( $i );
			$s_date = explode ( " ", $s_date );
			$s_date = $s_date [0];
			$s_filesize = $this->getFilesize ( $s_filesize );
			//如果是图片，双击后打开。
			$s_icon = '<div class="img ' . $o_file->getClassName ( $i ) . '"></div>';
			$s_float = '';
			$s_width = '';
			if ($o_file->getClassName ( $i ) == 'image') {
				$s_dbclick = 'ondblclick="window.open(\'' . RELATIVITY_PATH . $o_file->getPath ( $i ) . '/' . $o_file->getOriginalFilename ( $i ) . '\',\'_blank\');selected(this.parentNode.parentNode);"';
				$s_icon = '<div><img src="' . RELATIVITY_PATH . $o_file->getPath ( $i ) . '/' . $o_file->getOriginalFilename ( $i ) . '" alt="" align="absmiddle" style="width:120px; height:50px"/></div>';
				$s_float = ' style="float:left;"';
				$s_width = ' style="width:120px;height:50px"';
			} else if ($o_file->getPath ( $i ) == '') {
				$s_dbclick = 'ondblclick="parent.parent.parent.open(\'' . $o_file->getUrl ( $i ) . '\');selected(this.parentNode.parentNode);"';
			} else {
				$s_dbclick = 'ondblclick="window.open(\'file_download.php?fileid=' . $o_file->getFileId ( $i ) . '\',\'\',\'_blank\');selected(this.parentNode.parentNode);"';
			}
			if ($o_file->getUid ( $i ) == $this->O_SingleUser->getUid ()) {
				$s_input = '<input id="file_' . ($i + 1) . '" value="' . $o_file->getFileId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>';
				$s_button = '<a href="file_download.php?fileid=' . $o_file->getFileId ( $i ) . '" onclick="selected(this.parentNode.parentNode.parentNode)" target="_blank">下载</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);fileRename( ' . $o_file->getFileId ( $i ) . ',\'' . $o_file->getFilename ( $i ) . '\',\'' . $o_file->getKeyWord ( $i ) . '\');">编辑</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFile(' . $o_file->getFileId ( $i ) . ');">复制</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);moveFile(' . $o_file->getFileId ( $i ) . ');">移动</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);deleteFile( ' . $o_file->getFileId ( $i ) . ');">删除</a>';
			} else if ($o_file->getPath ( $i ) == '') {
				$s_button = '';
				$s_input = '';
			} else {
				$s_button = '<a href="file_download.php?fileid=' . $o_file->getFileId ( $i ) . '" onclick="selected(this.parentNode.parentNode.parentNode)" target="_blank">下载</a>';
				$s_input = '';
			}
			//如果是其他的，双击后下载。
			$html .= '
			<div title="' . $o_file->getFilename ( $i ) . '" onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
	            <div' . $s_float . '>
	                ' . $s_input . '
	            </div>
	            <div>
	                <div class="icon" ' . $s_dbclick . $s_width . '>
	                    ' . $s_icon . '
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name">
	                ' . $this->AilterFileName ( $o_file->getFilename ( $i ) ) . '
	            </div>
	            <div class="file_info">
	                ' . $s_filesize . ' | ' . $s_date . ' | ' . $o_file->getUserName ( $i ) . '
	            </div>
	            <div class="button_box">
	            <div class="button">
	                ' . $s_button . '
	                </div>
	            </div>
	        </div>';
		
		}
		return $html;
	}
	public function getDirectoryRoot() {
		$o_tree = new Netdisk_Folder ();
		$o_tree->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_tree->PushWhere ( array ('&&', 'ParentId', '=', 0 ) );
		$o_tree->PushOrder ( array ('FolderName', 'A' ) );
		$n_count = $o_tree->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$html .= '                  <li>
                                            <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                                                <img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" onclick="openPathDirectory(this,' . $o_tree->getFolderId ( $i ) . ')" />
                                                <img src="../../images/notify_open.gif" alt="" align="absmiddle"/>
                                                <a id="path_' . $o_tree->getFolderId ( $i ) . '" href="javascript:;" title="' . $o_tree->getFolderName ( $i ) . '" style=" font-weight:normal" ondblclick="openPathDirectory(this,' . $o_tree->getFolderId ( $i ) . ')" onclick="nameAddBold(this);goTo(\'directory_explorer.php?folderid=' . $o_tree->getFolderId ( $i ) . '\');document.getElementById(\'Vcl_FolderId\').value=' . $o_tree->getFolderId ( $i ) . ';">
                                                    	' . $o_tree->getFolderName ( $i ) . '
                                                </a>
                                                <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>
                                            </span>                                            
                                        </li>
                                        ';
		
		}
		if ($n_count > 0) {
			$html = '<ul>' . $html . '</ul>';
		}
		return '             <ul class="dynatree-container" style="margin-bottom:10px; padding:0px">
                                <li>
                                    <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                                        <img src="../../images/file_tree/root.png" alt="" align="absmiddle" style="width:32px; height:32px; display:none"/>
                                        <img src="../../images/file_tree/share.png" alt="" align="absmiddle" style="width:32px; height:32px"/>
                                        <a href="javascript:;" title="目录管理"  id="path_0" style="font-size:14px; margin-top:5px" ondblclick="openPathDirectory(this,-1)" onclick="nameAddBold(this);goTo(\'directory_explorer.php?folderid=0\');">目录管理
                                        </a>
                                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>
                                    </span>
                                    ' . $html . '
                                </li>
                            </ul>';
	}
	public function getDirectoryFileList($n_folderid) {
		$o_tree = new Netdisk_Folder ();
		$o_tree->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_tree->PushWhere ( array ('&&', 'ParentId', '=', $n_folderid ) );
		$o_tree->PushOrder ( array ('FolderName', 'A' ) );
		$n_count = $o_tree->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			/*			$html .= '
			<div class="off">
	            <div>
	                <div class="icon" ondblclick="goIn('.$o_tree->getParentId ( $i ).','.$o_tree->getFolderId ( $i ).')">
	                    <div class="img folder">
	                    </div>
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name">
	                ' . $o_tree->getFolderName ( $i ) . '
	            </div>
	        </div>
       ';*/
			$html .= '
			<div onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
	            <div style="width:100%">
	                <input id="folder_' . ($i + 1) . '" value="' . $o_tree->getFolderId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>
	            </div>
	            <div>
	                <div class="icon" ondblclick="goInDirectory(' . $o_tree->getParentId ( $i ) . ',' . $o_tree->getFolderId ( $i ) . ')">
	                    <div class="img folder">
	                    </div>
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name">
	                ' . $o_tree->getFolderName ( $i ) . '
	            </div>
	            <div class="file_info">
	                
	            </div>
	            <div class="button_box">
	            <div class="button">
	                <a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);FolderRename(' . $o_tree->getFolderId ( $i ) . ',' . $o_tree->getParentId ( $i ) . ',\'' . $o_tree->getFolderName ( $i ) . '\');" class="operate">编辑</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);deleteFolder(' . $o_tree->getFolderId ( $i ) . ');">删除</a>
	                </div>
	            </div>
	        </div>';
		
		}
		return $html;
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
	private function AilterFileName($s_text) {
		$a_key = explode ( ".", $s_text );
		if (count ( $a_key ) > 1) {
			return $this->CutStr ( $a_key [0], 20 ) . '.' . $a_key [1];
		} else {
			return $this->CutStr ( $a_key [0], 20 );
		}
	}
	public function getMyDiskFileListSearch($s_key, $n_folderid) {
		$o_file = new View_Netdisk_File ();
		//分析关键字
		$a_key = explode ( " ", $s_key );
		//分析子目录
		array_push ( $this->A_FolderId, $n_folderid );
		$this->getSubDirectory ( $n_folderid );
		for($i = 0; $i < count ( $this->A_FolderId ); $i ++) {
			$o_file->PushWhere ( array ('||', 'Delete', '=', 0 ) );
			$o_file->PushWhere ( array ('&&', 'FolderId', '=', $this->A_FolderId [$i] ) );
			$o_file->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
			for($j = 0; $j < count ( $a_key ); $j ++) {
				$o_file->PushWhere ( array ('&&', 'Filename', 'LIKE', '%' . $a_key [$j] . '%' ) );
			}
		}
		$o_file->PushOrder ( array ('Filename', 'A' ) );
		$n_count = $o_file->getAllCount ();
		$a_fileid = array ();
		for($i = 0; $i < $n_count; $i ++) {
			array_push ( $a_fileid, $o_file->getFileId ( $i ) );
			$s_filesize = $o_file->getFilesize ( $i );
			$s_date = $o_file->getDate ( $i );
			$s_date = explode ( " ", $s_date );
			$s_date = $s_date [0];
			$s_filesize = $this->getFilesize ( $s_filesize );
			//如果是图片，双击后打开。
			$s_icon = '<div class="img ' . $o_file->getClassName ( $i ) . '"></div>';
			$s_float = '';
			$s_width = '';
			if ($o_file->getClassName ( $i ) == 'image') {
				$s_dbclick = 'ondblclick="window.open(\'' . RELATIVITY_PATH . $o_file->getPath ( $i ) . '/' . $o_file->getOriginalFilename ( $i ) . '\',\'_blank\');selected(this.parentNode.parentNode);"';
				$s_icon = '<div><img src="' . RELATIVITY_PATH . $o_file->getPath ( $i ) . '/' . $o_file->getOriginalFilename ( $i ) . '" alt="" align="absmiddle" style="width:120px; height:50px"/></div>';
				$s_float = ' style="float:left;"';
				$s_width = ' style="width:120px;height:50px"';
			} else if ($o_file->getPath ( $i ) == '') {
				$s_dbclick = 'ondblclick="parent.parent.parent.open(\'' . $o_file->getUrl ( $i ) . '\');selected(this.parentNode.parentNode);"';
			} else {
				$s_dbclick = 'ondblclick="window.open(\'file_download.php?fileid=' . $o_file->getFileId ( $i ) . '\',\'\',\'_blank\');selected(this.parentNode.parentNode);"';
			}
			if ($o_file->getPath ( $i ) == '') {
				$s_button = '<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);fileRename( ' . $o_file->getFileId ( $i ) . ',\'' . $o_file->getFilename ( $i ) . '\',\'' . $o_file->getKeyWord ( $i ) . '\');">编辑</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFile(' . $o_file->getFileId ( $i ) . ');">复制</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);moveFile(' . $o_file->getFileId ( $i ) . ');">移动</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);deleteFile( ' . $o_file->getFileId ( $i ) . ');">删除</a>';
			} else {
				$s_button = '<a href="file_download.php?fileid=' . $o_file->getFileId ( $i ) . '" onclick="selected(this.parentNode.parentNode.parentNode)" target="_blank">下载</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);fileRename( ' . $o_file->getFileId ( $i ) . ',\'' . $o_file->getFilename ( $i ) . '\',\'' . $o_file->getKeyWord ( $i ) . '\');">编辑</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFile(' . $o_file->getFileId ( $i ) . ');">复制</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);moveFile(' . $o_file->getFileId ( $i ) . ');">移动</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);deleteFile( ' . $o_file->getFileId ( $i ) . ');">删除</a>';
			}
			//如果是其他的，双击后下载。
			$html .= '
			<div title="' . $o_file->getFilename ( $i ) . '" onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
	            <div' . $s_float . '>
	                <input id="file_' . ($i + 1) . '" value="' . $o_file->getFileId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>
	            </div>
	            <div>
	                <div class="icon" ' . $s_dbclick . $s_width . '>
	                    ' . $s_icon . '
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name">
	               ' . $this->AilterFileName ( $o_file->getFilename ( $i ) ) . '
	            </div>
	            <div class="file_info">
	                ' . $s_filesize . ' | ' . $s_date . ' | ' . $o_file->getUserName ( $i ) . '
	            </div>
	            <div class="button_box">
	            <div class="button">
	                ' . $s_button . '
	            </div>
	            </div>
	        </div>';
		
		}
		$o_file = new View_Netdisk_File ();
		for($i = 0; $i < count ( $this->A_FolderId ); $i ++) {
			$o_file->PushWhere ( array ('||', 'Delete', '=', 0 ) );
			$o_file->PushWhere ( array ('&&', 'FolderId', '=', $this->A_FolderId [$i] ) );
			$o_file->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
			for($j = 0; $j < count ( $a_key ); $j ++) {
				$o_file->PushWhere ( array ('&&', 'KeyWord', 'LIKE', '%' . $a_key [$j] . '%' ) );
			}
		}
		$o_file->PushOrder ( array ('Filename', 'A' ) );
		$n_count = $o_file->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			if (in_array ( $o_file->getFileId ( $i ), $a_fileid )) {
				continue;
			}
			$s_filesize = $o_file->getFilesize ( $i );
			$s_date = $o_file->getDate ( $i );
			$s_date = explode ( " ", $s_date );
			$s_date = $s_date [0];
			$s_filesize = $this->getFilesize ( $s_filesize );
			//如果是图片，双击后打开。
			$s_icon = '<div class="img ' . $o_file->getClassName ( $i ) . '"></div>';
			$s_float = '';
			$s_width = '';
			if ($o_file->getClassName ( $i ) == 'image') {
				$s_dbclick = 'ondblclick="window.open(\'' . RELATIVITY_PATH . $o_file->getPath ( $i ) . '/' . $o_file->getOriginalFilename ( $i ) . '\',\'_blank\');selected(this.parentNode.parentNode);"';
				$s_icon = '<div><img src="' . RELATIVITY_PATH . $o_file->getPath ( $i ) . '/' . $o_file->getOriginalFilename ( $i ) . '" alt="" align="absmiddle" style="width:120px; height:50px"/></div>';
				$s_float = ' style="float:left;"';
				$s_width = ' style="width:120px;height:50px"';
			} else if ($o_file->getPath ( $i ) == '') {
				$s_dbclick = 'ondblclick="parent.parent.parent.open(\'' . $o_file->getUrl ( $i ) . '\');selected(this.parentNode.parentNode);"';
			} else {
				$s_dbclick = 'ondblclick="window.open(\'file_download.php?fileid=' . $o_file->getFileId ( $i ) . '\',\'\',\'_blank\');selected(this.parentNode.parentNode);"';
			}
			if ($o_file->getPath ( $i ) == '') {
				$s_button = '<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);fileRename( ' . $o_file->getFileId ( $i ) . ',\'' . $o_file->getFilename ( $i ) . '\',\'' . $o_file->getKeyWord ( $i ) . '\');">编辑</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFile(' . $o_file->getFileId ( $i ) . ');">复制</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);moveFile(' . $o_file->getFileId ( $i ) . ');">移动</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);deleteFile( ' . $o_file->getFileId ( $i ) . ');">删除</a>';
			} else {
				$s_button = '<a href="file_download.php?fileid=' . $o_file->getFileId ( $i ) . '" onclick="selected(this.parentNode.parentNode.parentNode)" target="_blank">下载</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);fileRename( ' . $o_file->getFileId ( $i ) . ',\'' . $o_file->getFilename ( $i ) . '\',\'' . $o_file->getKeyWord ( $i ) . '\');">编辑</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFile(' . $o_file->getFileId ( $i ) . ');">复制</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);moveFile(' . $o_file->getFileId ( $i ) . ');">移动</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);deleteFile( ' . $o_file->getFileId ( $i ) . ');">删除</a>';
			}
			//如果是其他的，双击后下载。
			$html .= '
			<div title="' . $o_file->getFilename ( $i ) . '" onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
	            <div' . $s_float . '>
	                <input id="file_' . ($i + 1) . '" value="' . $o_file->getFileId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>
	            </div>
	            <div>
	                <div class="icon" ' . $s_dbclick . $s_width . '>
	                    ' . $s_icon . '
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name">
	               ' . $this->AilterFileName ( $o_file->getFilename ( $i ) ) . '
	            </div>
	            <div class="file_info">
	                ' . $s_filesize . ' | ' . $s_date . ' | ' . $o_file->getUserName ( $i ) . '
	            </div>
	            <div class="button_box">
	            <div class="button">
	                ' . $s_button . '</div>
	            </div>
	        </div>';
		
		}
		return $html;
	}
	public function getShareFileListSearch($s_key, $n_folderid) {
		$o_file = new View_Netdisk_File ();
		//分析关键字
		$a_key = explode ( " ", $s_key );
		//分析子目录
		array_push ( $this->A_FolderId, $n_folderid );
		$this->getSubDirectory ( $n_folderid );
		for($i = 0; $i < count ( $this->A_FolderId ); $i ++) {
			$o_file->PushWhere ( array ('||', 'Delete', '=', 0 ) );
			$o_file->PushWhere ( array ('&&', 'FolderId', '=', $this->A_FolderId [$i] ) );
			//$o_file->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
			for($j = 0; $j < count ( $a_key ); $j ++) {
				$o_file->PushWhere ( array ('&&', 'Filename', 'LIKE', '%' . $a_key [$j] . '%' ) );
			}
		}
		$o_file->PushOrder ( array ('Filename', 'A' ) );
		$n_count = $o_file->getAllCount ();
		$a_fileid = array ();
		for($i = 0; $i < $n_count; $i ++) {
			array_push ( $a_fileid, $o_file->getFileId ( $i ) );
			$s_filesize = $o_file->getFilesize ( $i );
			$s_date = $o_file->getDate ( $i );
			$s_date = explode ( " ", $s_date );
			$s_date = $s_date [0];
			$s_filesize = $this->getFilesize ( $s_filesize );
			//如果是图片，双击后打开。
			$s_icon = '<div class="img ' . $o_file->getClassName ( $i ) . '"></div>';
			$s_float = '';
			$s_width = '';
			if ($o_file->getClassName ( $i ) == 'image') {
				$s_dbclick = 'ondblclick="window.open(\'' . RELATIVITY_PATH . $o_file->getPath ( $i ) . '/' . $o_file->getOriginalFilename ( $i ) . '\',\'_blank\');selected(this.parentNode.parentNode);"';
				$s_icon = '<div><img src="' . RELATIVITY_PATH . $o_file->getPath ( $i ) . '/' . $o_file->getOriginalFilename ( $i ) . '" alt="" align="absmiddle" style="width:120px; height:50px"/></div>';
				$s_float = ' style="float:left;"';
				$s_width = ' style="width:120px;height:50px"';
			} else if ($o_file->getPath ( $i ) == '') {
				$s_dbclick = 'ondblclick="parent.parent.parent.open(\'' . $o_file->getUrl ( $i ) . '\');selected(this.parentNode.parentNode);"';
			} else {
				$s_dbclick = 'ondblclick="window.open(\'file_download.php?fileid=' . $o_file->getFileId ( $i ) . '\',\'\',\'_blank\');selected(this.parentNode.parentNode);"';
			}
			//如果是其他的，双击后下载。
			if ($o_file->getUid ( $i ) == $this->O_SingleUser->getUid ()) {
				$s_input = '<input id="file_' . ($i + 1) . '" value="' . $o_file->getFileId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>';
				if ($o_file->getPath ( $i ) == '') {
					$s_button = '<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);fileRename( ' . $o_file->getFileId ( $i ) . ',\'' . $o_file->getFilename ( $i ) . '\',\'' . $o_file->getKeyWord ( $i ) . '\');">编辑</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFile(' . $o_file->getFileId ( $i ) . ');">复制</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);moveFile(' . $o_file->getFileId ( $i ) . ');">移动</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);deleteFile( ' . $o_file->getFileId ( $i ) . ');">删除</a>';
				} else {
					$s_button = '<a href="file_download.php?fileid=' . $o_file->getFileId ( $i ) . '" onclick="selected(this.parentNode.parentNode.parentNode)" target="_blank">下载</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);fileRename( ' . $o_file->getFileId ( $i ) . ',\'' . $o_file->getFilename ( $i ) . '\',\'' . $o_file->getKeyWord ( $i ) . '\');">编辑</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFile(' . $o_file->getFileId ( $i ) . ');">复制</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);moveFile(' . $o_file->getFileId ( $i ) . ');">移动</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);deleteFile( ' . $o_file->getFileId ( $i ) . ');">删除</a>';
				}
			} else {
				if ($o_file->getPath ( $i ) == '') {
					$s_button = '';
				} else {
					$s_button = '<a href="file_download.php?fileid=' . $o_file->getFileId ( $i ) . '" onclick="selected(this.parentNode.parentNode.parentNode)" target="_blank">下载</a>';
				}				
				$s_input = '';
			}
			
			$html .= '
			<div title="' . $o_file->getFilename ( $i ) . '" onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
	            <div' . $s_float . '>
	                ' . $s_input . '
	            </div>
	            <div>
	                <div class="icon" ' . $s_dbclick . $s_width . '>
	                    ' . $s_icon . '
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name">
	               ' . $this->AilterFileName ( $o_file->getFilename ( $i ) ) . '
	            </div>
	            <div class="file_info">
	                ' . $s_filesize . ' | ' . $s_date . ' | ' . $o_file->getUserName ( $i ) . '
	            </div>
	            <div class="button_box">
	            <div class="button">
	                ' . $s_button . '</div>
	            </div>
	        </div>';
		
		}
		$o_file = new View_Netdisk_File ();
		for($i = 0; $i < count ( $this->A_FolderId ); $i ++) {
			$o_file->PushWhere ( array ('||', 'Delete', '=', 0 ) );
			$o_file->PushWhere ( array ('&&', 'FolderId', '=', $this->A_FolderId [$i] ) );
			//$o_file->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
			for($j = 0; $j < count ( $a_key ); $j ++) {
				$o_file->PushWhere ( array ('&&', 'KeyWord', 'LIKE', '%' . $a_key [$j] . '%' ) );
			}
		}
		$o_file->PushOrder ( array ('Filename', 'A' ) );
		$n_count = $o_file->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			if (in_array ( $o_file->getFileId ( $i ), $a_fileid )) {
				continue;
			}
			$s_filesize = $o_file->getFilesize ( $i );
			$s_date = $o_file->getDate ( $i );
			$s_date = explode ( " ", $s_date );
			$s_date = $s_date [0];
			$s_filesize = $this->getFilesize ( $s_filesize );
			//如果是图片，双击后打开。
			$s_icon = '<div class="img ' . $o_file->getClassName ( $i ) . '"></div>';
			$s_float = '';
			$s_width = '';
			if ($o_file->getClassName ( $i ) == 'image') {
				$s_dbclick = 'ondblclick="window.open(\'' . RELATIVITY_PATH . $o_file->getPath ( $i ) . '/' . $o_file->getOriginalFilename ( $i ) . '\',\'_blank\');selected(this.parentNode.parentNode);"';
				$s_icon = '<div><img src="' . RELATIVITY_PATH . $o_file->getPath ( $i ) . '/' . $o_file->getOriginalFilename ( $i ) . '" alt="" align="absmiddle" style="width:120px; height:50px"/></div>';
				$s_float = ' style="float:left;"';
				$s_width = ' style="width:120px;height:50px';
			} else if ($o_file->getPath ( $i ) == '') {
				$s_dbclick = 'ondblclick="parent.parent.parent.open(\'' . $o_file->getUrl ( $i ) . '\');selected(this.parentNode.parentNode);"';
			} else {
				$s_dbclick = 'ondblclick="window.open(\'file_download.php?fileid=' . $o_file->getFileId ( $i ) . '\',\'\',\'_blank\');selected(this.parentNode.parentNode);"';
			}
			//如果是其他的，双击后下载。
			if ($o_file->getUid ( $i ) == $this->O_SingleUser->getUid ()) {
				$s_input = '<input id="file_' . ($i + 1) . '" value="' . $o_file->getFileId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>';
				$s_button = '<a href="file_download.php?fileid=' . $o_file->getFileId ( $i ) . '" onclick="selected(this.parentNode.parentNode.parentNode)" target="_blank">下载</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);fileRename( ' . $o_file->getFileId ( $i ) . ',\'' . $o_file->getFilename ( $i ) . '\',\'' . $o_file->getKeyWord ( $i ) . '\');">编辑</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFile(' . $o_file->getFileId ( $i ) . ');">复制</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);moveFile(' . $o_file->getFileId ( $i ) . ');">移动</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);deleteFile( ' . $o_file->getFileId ( $i ) . ');">删除</a>';
			} else {
				$s_button = '';
				$s_input = '';
			}
			$html .= '
			<div title="' . $o_file->getFilename ( $i ) . '" onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
	            <div' . $s_float . '>
	                ' . $s_input . '
	            </div>
	            <div>
	                <div class="icon" ' . $s_dbclick . $s_width . '>
	                    ' . $s_icon . '
	                    <div>
	                    </div>
	                </div>
	            </div>
	            <div class="file_name">
	               ' . $this->AilterFileName ( $o_file->getFilename ( $i ) ) . '
	            </div>
	            <div class="file_info">
	                ' . $s_filesize . ' | ' . $s_date . ' | ' . $o_file->getUserName ( $i ) . '
	            </div>
	            <div class="button_box">
	            <div class="button">
	                ' . $s_button . '</div>
	            </div>
	        </div>';
		
		}
		return $html;
	}
}

?>