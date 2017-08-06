<?php
require_once 'db_table.class.php';
require_once 'db_view.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'include/it_basic.class.php';
class ShowPage extends It_Basic {
	protected $O_SingleUser;
	
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
		$o_tree = new Netdisk_Folder ();
		$o_tree->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_tree->PushWhere ( array ('&&', 'ParentId', '=', 0 ) );
		$o_tree->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
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
                                        <a href="javascript:;" title="我的网盘"  id="path_0" style="font-size:14px; margin-top:5px" ondblclick="openPath(this,-1)" onclick="nameAddBold(this);goTo(\'explorer.php?folderid=0\');">我的网盘
                                        </a>
                                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>
                                    </span>
                                    ' . $html . '
                                </li>
                            </ul>';
	}
	public function getShareRoot() {
		
		$o_dept1 = new Base_Dept (); //构造按部门分
		$o_dept1->PushWhere ( array ('&&', 'ParentId', '=', 0 ) );
		$o_dept1->PushOrder ( array ('Number', 'A' ) );
		$n_count1 = $o_dept1->getAllCount ();
		for($i = 0; $i < $n_count1; $i ++) {
			$html1 .= '                  <li>
                                            <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                                                <img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" onclick="openPath(this,-1)" />
                                                <img src="../../images/org/root.png" alt="" align="absmiddle"/>
                                                <a href="javascript:;" title="' . $o_dept1->getName ( $i ) . '" style=" font-weight:normal" ondblclick="openPath(this,-1)" onclick="nameAddBold(this)">
                                                    	' . $o_dept1->getName ( $i ) . '
                                                </a>
                                                <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>
                                            </span> 
                                        ';
			$o_dept2 = new Base_Dept ();
			$o_dept2->PushWhere ( array ('&&', 'ParentId', '=', $o_dept1->getDeptId ( $i ) ) );
			$o_dept2->PushOrder ( array ('Number', 'A' ) );
			$n_count2 = $o_dept2->getAllCount ();
			$html2 = '';
			for($j = 0; $j < $n_count2; $j ++) {
				$html2 .= '                  <li>
                                            <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                                                <img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" onclick="openPath(this,-1)" />
                                                <img src="../../images/org/org.png" alt="" align="absmiddle"/>
                                                <a href="javascript:;" title="' . $o_dept2->getName ( $j ) . '" style=" font-weight:normal" ondblclick="openPath(this,-1)" onclick="nameAddBold(this)">
                                                    	' . $o_dept2->getName ( $j ) . '
                                                </a>
                                                <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>
                                            </span> 
                                        ';
				$o_dept3 = new Base_Dept ();
				$o_dept3->PushWhere ( array ('&&', 'ParentId', '=', $o_dept2->getDeptId ( $j ) ) );
				$o_dept3->PushOrder ( array ('Number', 'A' ) );
				$n_count3 = $o_dept3->getAllCount ();
				$html3 = '';
				for($k = 0; $k < $n_count3; $k ++) {
					$html3 .= '                  <li>
                                            <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                                                <img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" onclick="openPath(this,-1)" />
                                                <img src="../../images/org/org.png" alt="" align="absmiddle"/>
                                                <a href="javascript:;" title="' . $o_dept3->getName ( $k ) . '" style=" font-weight:normal" ondblclick="openPath(this,-1)" onclick="nameAddBold(this)">
                                                    	' . $o_dept3->getName ( $k ) . '
                                                </a>
                                                <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>
                                            </span> 
                                        ';
					$o_user = new View_User_Dept ();
					$o_user->PushWhere ( array ('&&', 'DeptId', '=', $o_dept3->getDeptId ( $k ) ) );
					$o_user->PushWhere ( array ('&&', 'State', '=', 1 ) );
					$o_user->PushWhere ( array ('&&', 'Uid', '<>', $this->O_SingleUser->getUid() ) );
					$n_user_count = $o_user->getAllCount ();
					$html4 = '';
					for($l = 0; $l < $n_user_count; $l ++) {
						$html4 .= '              <li>
                                            <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                                                <img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" onclick="openPathShareRoot(this,' . $o_user->getUid ( $l ) . ')" />
                                                <img src="../../images/org/U01.png" alt="" align="absmiddle"/>
                                                <a id="user_'.$o_user->getUid ( $l ).'" href="javascript:;" title="' . $o_user->getName ( $l ) . '" style=" font-weight:normal" ondblclick="openPathShareRoot(this,' . $o_user->getUid ( $l ) . ')" onclick="nameAddBold(this);goTo(\'explorer_share.php?uid=' . $o_user->getUid ( $l ) . '\');">
                                                    	' . $o_user->getName ( $l ) . '
                                                </a>
                                                <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>
                                            </span>                                            
                                        </li>';
					}
					if (strlen ( $html4 ) > 0) {
						$html4 = '<ul style="display:none">' . $html4 . '</ul>';
					}
					$html3 .= $html4 . '</li>'; //第三级部门封口
				}
				
				//查找有没有用户名
				$o_user = new View_User_Dept ();
				$o_user->PushWhere ( array ('&&', 'DeptId', '=', $o_dept2->getDeptId ( $j ) ) );
				$o_user->PushWhere ( array ('&&', 'Uid', '<>', $this->O_SingleUser->getUid() ) );
				$o_user->PushWhere ( array ('&&', 'State', '=', 1 ) );
				$n_user_count = $o_user->getAllCount ();
				for($l = 0; $l < $n_user_count; $l ++) {
					$html3 .= '              <li>
                                            <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                                                <img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" onclick="openPathShareRoot(this,' . $o_user->getUid ( $l ) . ')" />
                                                <img src="../../images/org/U01.png" alt="" align="absmiddle"/>
                                                <a id="user_'.$o_user->getUid ( $l ).'" href="javascript:;" title="' . $o_user->getName ( $l ) . '" style=" font-weight:normal" ondblclick="openPathShareRoot(this,' . $o_user->getUid ( $l ) . ')" onclick="nameAddBold(this);goTo(\'explorer_share.php?uid=' . $o_user->getUid ( $l ) . '\');">
                                                    	' . $o_user->getName ( $l ) . '
                                                </a>
                                                <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>
                                            </span>                                            
                                        </li>';
				}
				if (strlen ( $html3 ) > 0) {
					$html3 = '<ul style="display:none">' . $html3 . '</ul>';
				}
				$html2 .= $html3;
			}
			$html2 .= '</li>'; //第二级部门封口
			//查找有没有用户名
			$o_user = new View_User_Dept ();
			$o_user->PushWhere ( array ('&&', 'DeptId', '=', $o_dept1->getDeptId ( $i ) ) );
			$o_user->PushWhere ( array ('&&', 'Uid', '<>', $this->O_SingleUser->getUid() ) );
			$o_user->PushWhere ( array ('&&', 'State', '=', 1 ) );
			$n_user_count = $o_user->getAllCount ();
			for($l = 0; $l < $n_user_count; $l ++) {
				$html2 .= '              <li>
                                            <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                                                <img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" onclick="openPathShareRoot(this,' . $o_user->getUid ( $l ) . ')" />
                                                <img src="../../images/org/U01.png" alt="" align="absmiddle"/>
                                                <a id="user_'.$o_user->getUid ( $l ).'" href="javascript:;" title="' . $o_user->getName ( $l ) . '" style=" font-weight:normal" ondblclick="openPathShareRoot(this,' . $o_user->getUid ( $l ) . ')" onclick="nameAddBold(this);goTo(\'explorer_share.php?uid=' . $o_user->getUid ( $l ) . '\');">
                                                    	' . $o_user->getName ( $l ) . '
                                                </a>
                                                <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>
                                            </span>                                            
                                        </li>';
			}
			if (strlen ( $html2 ) > 0) {
				$html2 = '<ul style="display:none">' . $html2 . '</ul>';
			}
			$html1 .= $html2;
			$html1 .= '</li>'; //第一级部门封口
		}
		if (strlen ( $html1 ) > 0) {
			$html1 = '<ul>' . $html1 . '</ul>';
		}
		return '             <ul class="dynatree-container" style="margin-bottom:10px; padding:0px">
                                <li>
                                    <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                                        <img src="../../images/file_tree/root.png" alt="" align="absmiddle" style="width:32px; height:32px; display:none"/>
                                        <img src="../../images/file_tree/share.png" alt="" align="absmiddle" style="width:32px; height:32px"/>
                                        <a href="javascript:;" title="共享邻居"  id="path_0" style="font-size:14px; margin-top:5px;font-weight:normal" ondblclick="openPath(this,-1)" onclick="nameAddBold(this);">共享邻居
                                        </a>
                                    </span>
                                    ' . $html1 . '
                                </li>
                            </ul>';
	}
	public function getRecycleFileList() {
		$o_tree = new Netdisk_Folder ();
		$o_tree->PushWhere ( array ('&&', 'Delete', '=', 1 ) );
		$o_tree->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_tree->PushOrder ( array ('FolderName', 'A' ) );
		$n_count = $o_tree->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$html .= '                   <tr onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
								            <td style="width:20px" class="off">
								                <input id="folder_' . ($i + 1) . '" value="' . $o_tree->getFolderId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>
								            </td>
								            <td style="width:32px" class="icon">
								                <div class="icon"><div class="img folder"></div><div></div></div>
								            </td>
								            <td>
								            ' . $o_tree->getFolderName ( $i ) . '<span style="color:#999999">&nbsp;&nbsp;&nbsp;&nbsp;目录：' . str_replace('/', '\\', $o_tree->getOriginalPath ( $i )) . '</span>
								            </td>
								            <td style="width:100px">
								               <div><a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);reduction( ' . $o_tree->getFolderId ( $i ) . ',1);">还原</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);realDeleteFolder(' . $o_tree->getFolderId ( $i ) . ');">删除</a></div>
								            </td>
								            <td style="width:140px">
								               
								            </td>
								            <td style="width:140px">
								                ' . $o_tree->getDate ( $i ) . '
								            </td>
								            <td style="width:140px">
								                ' . $o_tree->getDeleteDate ( $i ) . '
								            </td>
								        </tr>';
		
		}
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
			$html .= '                   <tr onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
								            <td style="width:20px" class="off">
								                <input id="file_' . ($i + 1) . '" value="' . $o_file->getFileId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>
								            </td>
								            <td style="width:32px" class="icon">
								                <div class="icon"><div class="img ' . $o_file->getClassName ( $i ) . '"></div><div></div></div>
								            </td>
								            <td>
								            ' . $o_file->getFilename ( $i ) . $s_keyword . '<span style="color:#999999">&nbsp;&nbsp;&nbsp;&nbsp;目录：' . str_replace('/', '\\', $o_file->getOriginalPath ( $i )) . '</span>
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
		$o_tree->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_tree->PushOrder ( array ('FolderName', 'A' ) );
		$n_count = $o_tree->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$s_share='';
			if ($o_tree->getShareUid($i)!='')
			{
				$s_share='share';
			}
			$html .= '                   <tr onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
								            <td style="width:20px" class="off">
								                <input id="folder_' . ($i + 1) . '" value="' . $o_tree->getFolderId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>
								            </td>
								            <td style="width:32px" class="icon">
								                <div class="icon" onclick="selected(this.parentNode.parentNode)" ondblclick="goIn('.$o_tree->getParentId ( $i ).','.$o_tree->getFolderId ( $i ).')"><div class="img folder"></div><div class="'.$s_share.'"></div></div>
								            </td>
								            <td>
								            ' . $o_tree->getFolderName ( $i ) . '<span></span>
								            </td>
								            <td style="width:200px">
								               <div><a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);FolderRename(' . $o_tree->getFolderId ( $i ) . ',' . $o_tree->getParentId ( $i ) . ',\'' . $o_tree->getFolderName ( $i ) . '\');" class="operate">重命名</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFolder(' . $o_tree->getFolderId ( $i ) . ');">复制</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);moveFolder(' . $o_tree->getFolderId ( $i ) . ');">移动</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);shareFile( ' . $o_tree->getFolderId ( $i ) . ',1);">共享</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);deleteFolder(' . $o_tree->getFolderId ( $i ) . ');">删除</a></div>
								            </td>
								            <td style="width:140px">
								               
								            </td>
								            <td style="width:140px">
								                ' . $o_tree->getDate ( $i ) . '
								            </td>
								        </tr>';
		
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
			$s_share='';
			if ($o_file->getShareUid($i)!='')
			{
				$s_share='share';
			}
			$s_filesize = $this->getFilesize ( $s_filesize );
			$html .= '                   <tr onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
								            <td style="width:20px" class="off">
								                <input id="file_' . ($i + 1) . '" value="' . $o_file->getFileId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>
								            </td>
								            <td style="width:32px" class="icon">
								                <div class="icon"><div class="img ' . $o_file->getClassName ( $i ) . '"></div><div class="'.$s_share.'"></div></div>
								            </td>
								            <td>
								            ' . $o_file->getFilename ( $i ) . $s_keyword . '
								            </td>
								            <td style="width:200px">
								               <div><a href="file_download.php?fileid=' . $o_file->getFileId ( $i ) . '" onclick="selected(this.parentNode.parentNode.parentNode)" target="_blank">下载</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);fileRename( ' . $o_file->getFileId ( $i ) . ',\'' . $o_file->getFilename ( $i ) . '\');">重命名</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFile(' . $o_file->getFileId ( $i ) . ');">复制</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);moveFile(' . $o_file->getFileId ( $i ) . ');">移动</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);shareFile( ' . $o_file->getFileId ( $i ) . ',0);">共享</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);deleteFile( ' . $o_file->getFileId ( $i ) . ');">删除</a></div>
								            </td>
								            <td style="width:140px">
								               ' . $s_filesize . '
								            </td>
								            <td style="width:140px">
								                ' . $o_file->getDate ( $i ) . '
								            </td>
								        </tr>';
		
		}
		return $html;
	}
	public function getShareFileList($n_folderid, $n_uid) {
		if ($n_uid>0) {
			//获取跟目录
			$o_tree = new Netdisk_Folder ();
			$o_tree->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_tree->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
			$o_tree->PushWhere ( array ('&&', 'ShareUid', 'LIKE', '%<1>' . $this->O_SingleUser->getUid () . '<1>%' ) );
			$o_tree->PushOrder ( array ('FolderName', 'A' ) );
			$n_count = $o_tree->getAllCount ();
			for($i = 0; $i < $n_count; $i ++) {
				$html .= '                   <tr onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
								            <td style="width:20px" class="off">
								                <input id="folder_' . ($i + 1) . '" value="' . $o_tree->getFolderId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>
								            </td>
								            <td style="width:32px">
								                <div class="icon" onclick="selected(this.parentNode.parentNode)" ondblclick="goInShare(-1,'.$o_tree->getFolderId ( $i ).')"><div class="img folder"></div><div></div></div>
								            </td>
								            <td>
								            ' . $o_tree->getFolderName ( $i ) . '<span></span>
								            </td>
								            <td style="width:200px">
								               <div><a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFolder(' . $o_tree->getFolderId ( $i ) . ');">复制</a></div>
								            </td>
								            <td style="width:140px">
								               
								            </td>
								            <td style="width:140px">
								                ' . $o_tree->getDate ( $i ) . '
								            </td>
								        </tr>';
			
			}
			$o_file = new View_Netdisk_File ();
			$o_file->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_file->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
			$o_file->PushWhere ( array ('&&', 'ShareUid', 'LIKE', '%<1>' . $this->O_SingleUser->getUid () . '<1>%' ) );
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
				$html .= '                   <tr onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
								            <td style="width:20px" class="off">
								                <input id="file_' . ($i + 1) . '" value="' . $o_file->getFileId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>
								            </td>
								            <td style="width:32px">
								            <div class="icon"><div class="img ' . $o_file->getClassName ( $i ) . '"></div><div></div></div>
								            </td>
								            <td>
								            ' . $o_file->getFilename ( $i ) . $s_keyword . '
								            </td>
								            <td style="width:200px">
								               <div><a href="file_download.php?fileid=' . $o_file->getFileId ( $i ) . '" onclick="selected(this.parentNode.parentNode.parentNode)" target="_blank">下载</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFile(' . $o_file->getFileId ( $i ) . ');">复制</a></div>
								            </td>
								            <td style="width:140px">
								               ' . $s_filesize . '
								            </td>
								            <td style="width:140px">
								                ' . $o_file->getDate ( $i ) . '
								            </td>
								        </tr>';
			
			}
			return $html;
		} else {
			if ($n_folderid > 0) {
				//获取子目录
				//先验证这个目录的是不是给本用户共享了。（循环验证上一级，知道id=0）如果没有共享。直接退出
				$o_tree = new Netdisk_Folder ( $n_folderid );
				$n_find = false;
				while ( $n_find === false ) {
					if (strpos ( $o_tree->getShareUid (), '<1>' . $this->O_SingleUser->getUid () . '<1>' ) === false) {
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
				$o_tree->PushWhere ( array ('&&', 'ParentId', '=', $n_folderid ) );
				$o_tree->PushOrder ( array ('FolderName', 'A' ) );
				$n_count = $o_tree->getAllCount ();
				for($i = 0; $i < $n_count; $i ++) {
					$html .= '                   <tr onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
								            <td style="width:20px" class="off">
								                <input id="folder_' . ($i + 1) . '" value="' . $o_tree->getFolderId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>
								            </td>
								            <td style="width:32px">
								               <div class="icon" onclick="selected(this.parentNode.parentNode)" ondblclick="goInShare('.$o_tree->getParentId ( $i ).','.$o_tree->getFolderId ( $i ).')"><div class="img folder"></div><div></div></div>
								            </td>
								            <td>
								            ' . $o_tree->getFolderName ( $i ) . '<span></span>
								            </td>
								            <td style="width:100px">
								               <div><a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFolder(' . $o_tree->getFolderId ( $i ) . ');">复制</a></div>
								            </td>
								            <td style="width:140px">
								               
								            </td>
								            <td style="width:140px">
								                ' . $o_tree->getDate ( $i ) . '
								            </td>
								        </tr>';
				
				}
				$o_file = new View_Netdisk_File ();
				$o_file->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_file->PushWhere ( array ('&&', 'FolderId', '=', $n_folderid ) );
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
					$html .= '                   <tr onmouseover="showButton(this)" onmouseout="hideButton(this)" onclick="selected(this)" class="off">
								            <td style="width:20px" class="off">
								                <input id="file_' . ($i + 1) . '" value="' . $o_file->getFileId ( $i ) . '" type="checkbox" onclick="selectedForCheck(this)"/>
								            </td>
								            <td style="width:32px">
								            <div class="icon"><div class="img '.$o_file->getClassName ( $i ).'"></div><div></div></div>
								            </td>
								            <td>
								            ' . $o_file->getFilename ( $i ) . $s_keyword . '
								            </td>
								            <td style="width:100px">
								               <div><a href="file_download.php?fileid=' . $o_file->getFileId ( $i ) . '" onclick="selected(this.parentNode.parentNode.parentNode)" target="_blank">下载</a>&nbsp;&nbsp;<a href="javascript:;" onclick="selected(this.parentNode.parentNode.parentNode);copyFile(' . $o_file->getFileId ( $i ) . ');">复制</a></div>
								            </td>
								            <td style="width:140px">
								               ' . $s_filesize . '
								            </td>
								            <td style="width:140px">
								                ' . $o_file->getDate ( $i ) . '
								            </td>
								        </tr>';				
				}
				return $html;
			
			}
		}
	}
}

?>