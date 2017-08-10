<?php
require_once 'db_table.class.php';
require_once 'db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
class Operate extends Bn_Basic {
	protected $Result;
	public function __construct() {
		$this->Result = TRUE;
	}
	public function ArticleAudit($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		} 
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 96 )) {
			$o_article = new Home_Article ( $n_id );
			$a = $o_article->getAudit ();
			if ($o_article->getAudit () == 1) {
				$o_article->setAudit ( 3 );
				$o_article->setVisit ( 1 );
				//$this->AddUserLog ( $n_uid, '批准了一个编号为：' . $o_article->getArticleId () . '的门户文章。' );
				//$this->SubWaitReadForHome ( $o_article->getAuditUid () );
				$o_article->Save ();
			}
		}
	} 
	public function ArticleReturn($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 96 )) {
			$o_article = new Home_Article ( $_POST ['Vcl_ArticleId'] );
			if ($o_article->getAudit () == 1) {
				$o_article->setAudit ( 2 );
				$o_article->setUnauditReason ( $this->AilterTextArea ( $_POST ['Vcl_Reason'] ) );
				$o_article->Save ();
				//$this->SendRemind ( $n_uid, $o_article->getUid (), '对不起，您提交的门户文章，因：“' . $this->AilterTextArea ( $_POST ['Vcl_Reason'] ) . '”原因，被管理员退回，请您及时处理！' );
				//$this->AddUserLog ( $n_uid, '批准了一个编号为：' . $o_article->getArticleId () . '的门户文章。' );
				$this->SubWaitReadForHome ( $o_article->getAuditUid () );
			}
		}
	}
	public function DeleteScroll($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 66 )) {
			$a_id = explode ( "<1>", $n_id );
			for($i = 0; $i < count ( $a_id ); $i ++) {
				$o_article = new Home_Article ( $a_id [$i] );
				$o_article->setScroll ( 0 );
				$o_article->Save ();
			}
		}
	}
	public function DeleteLink($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70 )) {
			$a_id = explode ( "<1>", $n_id );
			for($i = 0; $i < count ( $a_id ); $i ++) {
				$o_article = new Home_Link ( $a_id [$i] );
				$o_article->setDelete ( 1 );
				$o_article->Save ();
			}
		}
	}
	public function DeleteColumn($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 72 )) {
			$o_column = new Home_Article ();
			$o_column->PushWhere ( array ('&&', 'ColumnId', '=', $n_id ) );
			$o_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			if ($o_column->getAllCount () > 0) {
				return false;
			}
			$o_column = new Home_Column ();
			$o_column->PushWhere ( array ('&&', 'Parent', '=', $n_id ) );
			$o_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			if ($o_column->getAllCount () > 0) {
				return false;
			}
			$o_column = new Home_Column ( $n_id );
			if ($o_column->getAllowDelete () == 0) {
				return true;
			}
			$o_column->setDelete ( 1 );
			$o_column->Save ();
			$this->ColumnSortForDelete ( $o_column->getParent () );
			//删除栏目后需要修复首页显示的
			$o_index = new View_Home_Indexcolumn ();
			$o_index->PushWhere ( array ('&&', 'ColumnId', '=', $n_id ) );
			$n_count = $o_index->getAllCount ();
			if ($n_count > 0) {
				//说明首页显示里有，需要修正
				if ($o_column->getParent () > 0) {
					//说明是二级栏目，那么就把首页显示给他的父栏目
					$o_index2 = new Home_Indexcolumn ( $o_index->getIndexcolumnId ( 0 ) );
					$o_index2->setColumnId ( $o_column->getParent () );
					$o_index2->Save ();
				} else {
					//说明是一级栏目，那么就把首页显示给第一个一级栏目
					$o_column = new Home_Column ();
					$o_column->PushWhere ( array ('&&', 'Parent', '=', 0 ) );
					$o_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
					$o_column->getAllCount ();
					$o_index2 = new Home_Indexcolumn ( $o_index->getIndexcolumnId ( 0 ) );
					$o_index2->setColumnId ( $o_column->getColumnId ( 0 ) );
					$o_index2->Save ();
				}
			}
			return true;
		}
	}
	private function ColumnSortForDelete($n_parent) {
		$o_focus = new Home_Column ();
		$o_focus->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_focus->PushWhere ( array ('&&', 'Parent', '=', $n_parent ) );
		$o_focus->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_focus->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_temp = new Home_Column ( $o_focus->getColumnId ( $i ) );
			$o_temp->setNumber ( $i + 1 );
			$o_temp->Save ();
		}
	}
	
	public function DeleteFooter($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 71 )) {
			$a_id = explode ( "<1>", $n_id );
			for($i = 0; $i < count ( $a_id ); $i ++) {
				$o_article = new Home_Article_Footer ( $a_id [$i] );
				$o_article->setDelete ( 1 );
				$o_article->Save ();
			}
		}
	}
	public function DeleteFloat($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70 )) {
			$a_id = explode ( "<1>", $n_id );
			for($i = 0; $i < count ( $a_id ); $i ++) {
				$o_article = new Home_Float ( $a_id [$i] );
				$o_article->Deletion();
			}
		}
	}
	public function DeleteArticle($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 73 )) {
			$b_isadmin = $o_user->ValidModule ( 73 );
			$a_id = explode ( "<1>", $n_id );
			for($i = 0; $i < count ( $a_id ); $i ++) {
				$o_article = new Home_Article ( $a_id [$i] );
				if (($o_article->getUid () == $n_uid && $o_article->getVisit () == 0) || $b_isadmin) {
					//是自己的文章,并且是从未审核过,或者是管理员,都可删掉			
					$o_article->setDelete ( 1 );
					$o_article->Save ();
					if ($o_article->getAudit () == 1) {
						$this->SubWaitReadForHome ( $o_article->getAuditUid () );
					}
				}
			}
		}
	}
	public function DeleteMessages($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 731 )) {
			$b_isadmin = $o_user->ValidModule ( 731 );
			$a_id = explode ( "<1>", $n_id );
			for($i = 0; $i < count ( $a_id ); $i ++) {
				$o_article = new Home_Messages( $a_id [$i] );
					//是自己的文章,并且是从未审核过,或者是管理员,都可删掉			
					$o_article->setDelete ( 1 );
					$o_article->Save ();
			}
		}
	}
	public function MoveArticle($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 73 )) {//必须为管理员才批量移动文章
			$a_id = explode ( "<1>", $_POST ['Vcl_ArticleId'] );
			if ($_POST ['Vcl_ColumnId'] == '') {
				$s_columnid = $_POST ['Vcl_Parent'];
			} else {
				$s_columnid = $_POST ['Vcl_ColumnId'];
			}
			for($i = 0; $i < count ( $a_id ); $i ++) {
				$o_article = new Home_Article ( $a_id [$i] );
				$o_article->setColumnId ( $s_columnid );
				$o_article->Save ();
			}
		}
	}
	public function DeleteFocus($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 67 )) {
			$a_id = explode ( "<1>", $n_id );
			for($i = 0; $i < count ( $a_id ); $i ++) {
				$o_article = new Home_NewsFocus ( $a_id [$i] );
				$o_article->setDelete ( 1 );
				$o_article->Save ();
			}
			$this->FocusSortForDelete ();
		}
	}
	public function DeleteBigFocus($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 66 )) {
			$a_id = explode ( "<1>", $n_id );
			for($i = 0; $i < count ( $a_id ); $i ++) {
				$o_article = new Home_Focus ( $a_id [$i] );
				$o_article->Deletion ();
				$o_article=null;
			}
			$this->BigFocusSortForDelete ();
		}
	}
	public function DeletePhoto($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 69 )) {
			$a_id = explode ( "<1>", $n_id );
			for($i = 0; $i < count ( $a_id ); $i ++) {
				$o_article = new Home_Photo ( $a_id [$i] );
				unlink ( RELATIVITY_PATH . 'sub/home/'.$o_article->getPath() );
				$o_article->Deletion();
			}
		}
	}
	private function FocusSortForDelete() {
		$o_focus = new Home_NewsFocus ();
		$o_focus->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_focus->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_focus->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_temp = new Home_NewsFocus ( $o_focus->getFocusId ( $i ) );
			$o_temp->setNumber ( $i + 1 );
			$o_temp->Save ();
		}
	}
	private function BigFocusSortForDelete() {
		$o_focus = new Home_Focus ();
		$o_focus->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_focus->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_temp = new Home_Focus ( $o_focus->getFocusId ( $i ) );
			$o_temp->setNumber ( $i + 1 );
			$o_temp->Save ();
		}
	}
	public function AddScroll($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 66 )) {
			$o_article = new Home_Article ( $_POST ['Vcl_ArticleId'] );
			if ($o_article->getTitle () == false) {
				return false;
			} else {
				$o_article->setScroll ( 1 );
				$o_article->Save ();
				return true;
			}
		}
	}
	public function ModifyIndexColumn($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 68 )) {
			$o_column = new Home_Indexcolumn ( $_POST ['Vcl_IndexcolumnId'] );
			if ($_POST ['Vcl_ColumnId'] == '') {
				$o_column->setColumnId ( $_POST ['Vcl_Parent'] );
			} else {
				$o_column->setColumnId ( $_POST ['Vcl_ColumnId'] );
			}
			$o_column->Save ();
			return true;
		}
	}
	public function ModifyFocus($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 67 )) {
			$o_focus = new Home_NewsFocus ( $_POST ['Vcl_FocusId'] );
			if ($o_focus->getArticleId () == false) {
				return TRUE;
			}
			$o_focus->setArticleId ( $_POST ['Vcl_ArticleId'] );
			$o_focus->setTitle ( $_POST ['Vcl_Title'] );
			$s_content = $_POST ['Vcl_Content'];
			$s_content = str_replace ( "\n", "<br/>", $s_content );
			$s_content = str_replace ( '  ', '&nbsp;&nbsp;', $s_content );
			$o_focus->setContent ( $s_content );
			$o_focus->setState ( $_POST ['Vcl_State'] );
			$o_focus->setNumber ( $_POST ['Vcl_Number'] );
			$o_focus->setUid ( $n_uid );
			if ($_FILES ['Vcl_File'] ['size'] > 0) {
				$allowpictype = array ('jpg', 'jpeg', 'gif', 'png' );
				$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Vcl_File'] ['name'], '.' ), 1 ) ) );
				if (! in_array ( $fileext, $allowpictype )) {
					return false;
				}
				$o_focus->setPhoto ( 'images/focus/' . $_POST ['Vcl_FocusId'] . '.' . $fileext );
				
				copy ( $_FILES ['Vcl_File'] ['tmp_name'], RELATIVITY_PATH . 'sub/home/images/focus/' . $_POST ['Vcl_FocusId'] . '.' . $fileext );
			}
			$o_focus->Save ();
			//排序
			$this->FocusSort ( $_POST ['Vcl_FocusId'], $_POST ['Vcl_Number'] );
			return true;
		}
	}
	public function ModifyBigFocus($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 66 )) {
			$o_focus = new Home_Focus ( $_POST ['Vcl_FocusId'] );
			$o_focus->setNumber ( $_POST ['Vcl_Number'] );
			if ($_FILES ['Vcl_File'] ['size'] > 0) {
				$allowpictype = array ('jpg', 'jpeg', 'gif', 'png' );
				$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Vcl_File'] ['name'], '.' ), 1 ) ) );
				if (! in_array ( $fileext, $allowpictype )) {
					return false;
				}
				copy ( $_FILES ['Vcl_File'] ['tmp_name'], RELATIVITY_PATH . 'sub/home/images/home/bigfocus' . $_POST ['Vcl_FocusId'] . '.' . $fileext );
			}
			$o_focus->Save ();
			//排序
			$this->BigFocusSort ( $_POST ['Vcl_FocusId'], $_POST ['Vcl_Number'] );
			return true;
		}

	}
	public function ModifyLink($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70 )) {
			$o_Link = new Home_Link ( $_POST ['Vcl_LinkId'] );
			if ($o_Link->getName () == false) {
				return TRUE;
			}
			$o_Link->setName ( $_POST ['Vcl_Name'] );
			$o_Link->setState ( $_POST ['Vcl_State'] );
			$o_Link->setNumber ( $_POST ['Vcl_Number'] );
			$o_Link->setUrl ( $_POST ['Vcl_Url'] );
			$o_Link->Save ();
			//排序
			$this->LinkSort ( $_POST ['Vcl_LinkId'], $_POST ['Vcl_Number'] );
			return true;
		}
	}
	public function ModifyFooter($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 71 )) {
			$o_Link = new Home_Article_Footer ( $_POST ['Vcl_ArticleId'] );
			if ($o_Link->getTitle () == false) {
				return TRUE;
			}
			$o_Link->setTitle ( $_POST ['Vcl_Title'] );
			$o_Link->setContent ( rawurldecode ( $_POST ['Vcl_Content'] ) );
			$o_date = new DateTime ( 'Asia/Chongqing' );
			$o_Link->setDate ( $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' ) );
			$o_Link->setState ( $_POST ['Vcl_State'] );
			$o_Link->setNumber ( $_POST ['Vcl_Number'] );
			$o_Link->Save ();
			//排序
			$this->FooterSort ( $_POST ['Vcl_ArticleId'], $_POST ['Vcl_Number'] );
			return true;
		}
	}
	public function AddArticle($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 95 )) {
			$o_article = new Home_Article ();
			if ($_POST ['Vcl_ColumnId'] == '') {
				$o_article->setColumnId ( $_POST ['Vcl_Parent'] );
				$o_articleId=$_POST ['Vcl_Parent'];
			} else {
				$o_article->setColumnId ( $_POST ['Vcl_ColumnId'] );
				$o_articleId=$_POST ['Vcl_ColumnId'];
			}
			$o_article->setTitle ( $_POST ['Vcl_Title'] );
			$o_article->setContent ( rawurldecode ( $_POST ['Vcl_Content'] ) );
			$o_date = new DateTime ( 'Asia/Chongqing' );
			$o_article->setDate ( $_POST ['Vcl_Date'] );
			$o_article->setLastDate ( $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' ) );
			if ($_POST ['Vcl_Home'] == 'on') {
				$o_article->setHome ( 1 );
			} else {
				$o_article->setHome ( 0 );
			}
			if ($_POST ['Vcl_Scroll'] == 'on') {
				$o_article->setScroll ( 1 );
			} else {
				$o_article->setScroll ( 0 );
			}
			$o_article->setState ( $_POST ['Vcl_State'] );
			$o_article->setIsComment (0);
			$o_article->setAudit ( 1 );
			$o_article->setAuditUid ( $_POST ['Vcl_AuditUid'] );
			$o_article->setUploadDate ($this->GetDate());
			$o_article->setUid ( $n_uid );
			$o_article->setLastUid ( $n_uid );
			$o_article->setTagId( $_POST ['Vcl_TagId'] );
			$o_article->Save ();
			//加入桌面图标提醒，加入消息提醒
			$this->AddWaitReadForHome ( $_POST ['Vcl_AuditUid'] );
			
			return $o_articleId;
		}
	}
	private function AddWaitReadForHome($n_uid) {
		$o_wait = new Home_Setup ( $n_uid );
		if ($o_wait->getWaitRead () == null) {
			$o_wait = new Home_Setup ();
			$o_wait->setUid ( $n_uid );
			$o_wait->setWaitRead ( 1 );
		} else {
			$o_wait->setWaitRead ( $o_wait->getWaitRead () + 1 );
		}
		$o_wait->Save ();
		$this->AddSysmsg ( 64, 96, '文章等待您的审核', '文章审核', $n_uid );
	}
	private function SubWaitReadForHome($n_uid) {
		$o_wait = new Home_Setup ( $n_uid );
		if ($o_wait->getWaitRead () == null) {
			$o_wait = new Home_Setup ();
			$o_wait->setUid ( $n_uid );
			$o_wait->setWaitRead ( 0 );
		} else {
			$o_wait->setWaitRead ( $o_wait->getWaitRead () - 1 );
		}
		$o_wait->Save ();
	}
	public function ModifyArticle($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		
		if ($o_user->ValidModule ( 73 )) {
			$b_modify = false; //判断文章是否已经修改，如果修改需要重新审核
			$b_modifyAuditUid = false;
			$o_article = new Home_Article ( $_POST ['Vcl_ArticleId'] );
			$o_article->setTagId( $_POST ['Vcl_TagId'] );
			if ($o_article->getUid () != $n_uid) {
				//如果编辑的文章，不是自己的，属于非法。直接退出系统
				//$this->Result = FALSE;
				//return;
			}
			if ($_POST ['Vcl_ColumnId'] == '') {
				if ($o_article->getColumnId () != $_POST ['Vcl_Parent']) {
					$b_modify = true;
				}
				$o_article->setColumnId ( $_POST ['Vcl_Parent'] );
				$n_articleid= $_POST ['Vcl_Parent'];
			} else {
				if ($o_article->getColumnId () != $_POST ['Vcl_ColumnId']) {
					$b_modify = true;
				}
				$o_article->setColumnId ( $_POST ['Vcl_ColumnId'] );
				$n_articleid=$_POST ['Vcl_ColumnId'] ;
			}
			if ($o_article->getTitle () != $_POST ['Vcl_Title']) {
				$b_modify = true;
				$o_article->setTitle ( $_POST ['Vcl_Title'] );
			}
			if ($o_article->getContent () != rawurldecode ( $_POST ['Vcl_Content'] )) {
				$b_modify = true;
				$o_article->setContent ( rawurldecode ( $_POST ['Vcl_Content'] ) );
			}
			if ($_POST ['Vcl_Home'] == 'on') {
				if ($o_article->getHome () == 0) {
					$b_modify = true;
				}
				$o_article->setHome ( 1 );
			} else {
				if ($o_article->getHome () == 1) {
					$b_modify = true;
				}
				$o_article->setHome ( 0 );
			}
			if ($_POST ['Vcl_Scroll'] == 'on') {
				if ($o_article->getScroll () == 0) {
					$b_modify = true;
				}
				$o_article->setScroll ( 1 );
			} else {
				if ($o_article->getScroll () == 1) {
					$b_modify = true;
				}
				$o_article->setScroll ( 0 );
			}
			if ($o_article->getState () != $_POST ['Vcl_State']) {
				$b_modify = true;
				$o_article->setState ( $_POST ['Vcl_State'] );
			}
			$o_article->setDate ( $_POST ['Vcl_Date'] );
			$o_article->setIsComment (0);
			if ($o_article->getAuditUid () != $_POST ['Vcl_AuditUid']) {
				$b_modifyAuditUid = TRUE;
				$b_modify = true;
				//如果Vcl_AuditUid变化了，那么从新发送桌面提醒
				$this->AddWaitReadForHome ( $_POST ['Vcl_AuditUid'] );
				if ($o_article->getAudit () == 1) {
					//说明他给以前的人，现在改变人了，所以去掉桌面提醒
					$this->SubWaitReadForHome ( $o_article->getAuditUid () );
				}
				$o_article->setAuditUid ( $_POST ['Vcl_AuditUid'] );
			}
			$o_article->setLastUid ( $n_uid );
			if ($b_modify) {
				$o_article->setAudit ( 1 );
				$o_date = new DateTime ( 'Asia/Chongqing' );
				$o_article->setLastDate ( $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' ) );
				$o_article->Save ();
			}
			return $n_articleid;
		}
	}
	public function ModifyArticleMy($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		
		if ($o_user->ValidModule ( 95 )) {
			$b_modify = false; //判断文章是否已经修改，如果修改需要重新审核
			$b_modifyAuditUid = false;
			$o_article = new Home_Article ( $_POST ['Vcl_ArticleId'] );
			$o_article->setTagId( $_POST ['Vcl_TagId'] );
			if ($o_article->getUid () != $n_uid) {
				//如果编辑的文章，不是自己的，属于非法。直接退出系统
				$this->Result = FALSE;
				return;
			}
			if ($_POST ['Vcl_ColumnId'] == '') {
				if ($o_article->getColumnId () != $_POST ['Vcl_Parent']) {
					$b_modify = true;
				}
				$o_article->setColumnId ( $_POST ['Vcl_Parent'] );
				$n_articleid= $_POST ['Vcl_Parent'];
			} else {
				if ($o_article->getColumnId () != $_POST ['Vcl_ColumnId']) {
					$b_modify = true;
				}
				$o_article->setColumnId ( $_POST ['Vcl_ColumnId'] );
				$n_articleid=$_POST ['Vcl_ColumnId'] ;
			}
			if ($o_article->getTitle () != $_POST ['Vcl_Title']) {
				$b_modify = true;
				$o_article->setTitle ( $_POST ['Vcl_Title'] );
			}
			if ($o_article->getContent () != rawurldecode ( $_POST ['Vcl_Content'] )) {
				$b_modify = true;
				$o_article->setContent ( rawurldecode ( $_POST ['Vcl_Content'] ) );
			}
			if ($_POST ['Vcl_Home'] == 'on') {
				if ($o_article->getHome () == 0) {
					$b_modify = true;
				}
				$o_article->setHome ( 1 );
			} else {
				if ($o_article->getHome () == 1) {
					$b_modify = true;
				}
				$o_article->setHome ( 0 );
			}
			if ($_POST ['Vcl_Scroll'] == 'on') {
				if ($o_article->getScroll () == 0) {
					$b_modify = true;
				}
				$o_article->setScroll ( 1 );
			} else {
				if ($o_article->getScroll () == 1) {
					$b_modify = true;
				}
				$o_article->setScroll ( 0 );
			}
			if ($o_article->getState () != $_POST ['Vcl_State']) {
				$b_modify = true;
				$o_article->setState ( $_POST ['Vcl_State'] );
			}
			
			if ($o_article->getAuditUid () != $_POST ['Vcl_AuditUid']) {
				$b_modifyAuditUid = TRUE;
				$b_modify = true;
				//如果Vcl_AuditUid变化了，那么从新发送桌面提醒
				$this->AddWaitReadForHome ( $_POST ['Vcl_AuditUid'] );
				if ($o_article->getAudit () == 1) {
					//说明他给以前的人，现在改变人了，所以去掉桌面提醒
					$this->SubWaitReadForHome ( $o_article->getAuditUid () );
				}
				$o_article->setAuditUid ( $_POST ['Vcl_AuditUid'] );
			}
			$o_article->setDate ( $_POST ['Vcl_Date'] );
			$o_article->setLastUid ( $n_uid );
			if ($b_modify) {
				if ($o_article->getAudit () != 1 && $b_modifyAuditUid == false) {
					//如果是退回,又提交了.那么再发一次桌面提醒
					$this->AddWaitReadForHome ( $_POST ['Vcl_AuditUid'] );
				}
				$o_article->setAudit ( 1 );
				$o_date = new DateTime ( 'Asia/Chongqing' );
				$o_article->setLastDate ( $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' ) );
				$o_article->Save ();
			}
			
			return $n_articleid;
		}
	}
	public function AddFooter($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 71 )) {
			$o_Link = new Home_Article_Footer ();
			$o_Link->setTitle ( $_POST ['Vcl_Title'] );
			$o_Link->setContent ( rawurldecode ( $_POST ['Vcl_Content'] ) );
			$o_date = new DateTime ( 'Asia/Chongqing' );
			$o_Link->setDate ( $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' ) );
			$o_Link->setState ( $_POST ['Vcl_State'] );
			$o_Link->setNumber ( $_POST ['Vcl_Number'] );
			$o_Link->Save ();
			//排序
			$this->FooterSort ( $o_Link->getArticleId (), $_POST ['Vcl_Number'] );
			return true;
		}
	}
	public function MessagesAudit($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 731 )) {
			$o_Link = new Home_Messages ($_POST ['Vcl_ArticleId']);
			$o_Link->setAudit ( 3 );
			$o_Link->setReturn ( rawurldecode ( $_POST ['Vcl_Content'] ) );
			$o_date = new DateTime ( 'Asia/Chongqing' );
			$o_Link->setAuditDate ( $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' ) );
			$o_Link->setAuditUid ($n_uid);
			$o_Link->Save ();
			//排序
			return true;
		}
	}	
	public function AddColumn($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 72 )) {
			$o_Link = new Home_Column ();
			$o_Link->setParent ( $_POST ['Vcl_Parent'] );
			$o_Link->setState ( $_POST ['Vcl_State'] );
			$o_Link->setNumber ( $_POST ['Vcl_Number'] );
			$o_Link->setName ( $_POST ['Vcl_Name'] );
			$o_Link->setUrl ( $_POST ['Vcl_Url'] );
			$o_Link->Save ();
			//排序
			$this->ColumnSort ( $o_Link->getParent (), $o_Link->getColumnId (), $_POST ['Vcl_Number'] );
			return true;
		}
	}
	public function AddFloat($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70 )) {
			$o_Link = new Home_Float ();
			$o_Link->setArticleId ( $_POST ['Vcl_ArticleId'] );
			$o_Link->setNumber ( $_POST ['Vcl_Number'] );
			$o_Link->Save ();
			//排序
			$this->FloatSort ( $o_Link->getFloatId (), $_POST ['Vcl_Number'] );
			return true;
		}
	}
	public function ModifyColumn($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 72 )) {
			$o_Link = new Home_Column ( $_POST ['Vcl_ColumnId'] );
			if ($o_Link->getName () == false) {
				return true;
			}
			$o_Link->setParent ( $_POST ['Vcl_Parent'] );
			$o_Link->setState ( $_POST ['Vcl_State'] );
			$o_Link->setNumber ( $_POST ['Vcl_Number'] );
			$o_Link->setName ( $_POST ['Vcl_Name'] );
			$o_Link->setUrl ( $_POST ['Vcl_Url'] );
			$o_Link->Save ();
			//排序
			$this->ColumnSort ( $o_Link->getParent (), $o_Link->getColumnId (), $_POST ['Vcl_Number'] );
			return true;
		}
	}
	public function ModifyFloat($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70 )) {
			$o_Link = new Home_Float ( $_POST ['Vcl_FloatId'] );
			$o_Link->setArticleId ( $_POST ['Vcl_ArticleId'] );
			$o_Link->setNumber ( $_POST ['Vcl_Number'] );
			$o_Link->Save ();
			//排序
			$this->FloatSort ( $o_Link->getFloatId (), $_POST ['Vcl_Number'] );
			return true;
		}
	}
	private function ColumnSort($n_parent, $n_focusid, $n_number) {
		$o_all = new Home_Column ();
		$o_all->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_all->PushWhere ( array ('&&', 'Parent', '=', $n_parent ) );
		$o_all->PushWhere ( array ('&&', 'ColumnId', '<>', $n_focusid ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Home_Column ( $o_all->getColumnId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	private function FloatSort($n_focusid, $n_number) {
		$o_all = new Home_Float ();
		$o_all->PushWhere ( array ('&&', 'FloatId', '<>', $n_focusid ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Home_Float ( $o_all->getFloatId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	public function AddLink($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 70 )) {
			$o_Link = new Home_Link ();
			$o_Link->setName ( $_POST ['Vcl_Name'] );
			$o_Link->setState ( $_POST ['Vcl_State'] );
			$o_Link->setNumber ( $_POST ['Vcl_Number'] );
			$o_Link->setUrl ( $_POST ['Vcl_Url'] );
			$o_Link->Save ();
			//排序
			$this->LinkSort ( $o_Link->getLinkId (), $_POST ['Vcl_Number'] );
			return true;
		}
	}
	public function AddFocus($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 67 )) {
			$o_focus = new Home_NewsFocus ();
			$o_focus->setArticleId ( $_POST ['Vcl_ArticleId'] );
			$o_focus->setTitle ( $_POST ['Vcl_Title'] );
			$s_content = $_POST ['Vcl_Content'];
			$s_content = str_replace ( "\n", "<br/>", $s_content );
			$s_content = str_replace ( '  ', '&nbsp;&nbsp;', $s_content );
			$o_focus->setContent ( $s_content );
			$o_focus->setState ( $_POST ['Vcl_State'] );
			$o_focus->setNumber ( $_POST ['Vcl_Number'] );
			$o_focus->setUid ( $n_uid );
			if ($_FILES ['Vcl_File'] ['size'] > 0) {
				$allowpictype = array ('jpg', 'jpeg', 'gif', 'png' );
				$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Vcl_File'] ['name'], '.' ), 1 ) ) );
				if (! in_array ( $fileext, $allowpictype )) {
					return 2;
				}
				$o_focus->Save ();
				$o_focus->setPhoto ( 'images/focus/' . $o_focus->getFocusId () . '.' . $fileext );
				$o_focus->Save ();
				copy ( $_FILES ['Vcl_File'] ['tmp_name'], RELATIVITY_PATH . 'sub/home/images/focus/' . $o_focus->getFocusId () . '.' . $fileext );
			} else {
				return 3;
			}
			//排序
			$this->FocusSort ( $o_focus->getFocusId (), $_POST ['Vcl_Number'] );
			return 1;
		}
	}
	public function AddBigFocus($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 66 )) {
			$o_focus = new Home_Focus ();
			$o_focus->setNumber ( $_POST ['Vcl_Number'] );
			if ($_FILES ['Vcl_File'] ['size'] > 0) {
				$allowpictype = array ('jpg', 'jpeg', 'gif', 'png' );
				$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Vcl_File'] ['name'], '.' ), 1 ) ) );
				if (! in_array ( $fileext, $allowpictype )) {
					return 2;
				}
				$o_focus->Save ();
				$o_focus->setPhoto ( 'images/home/bigfocus' . $o_focus->getFocusId () . '.' . $fileext );
				$o_focus->Save ();
				copy ( $_FILES ['Vcl_File'] ['tmp_name'], RELATIVITY_PATH . 'sub/home/images/home/bigfocus' . $o_focus->getFocusId () . '.' . $fileext );
			} else {
				return 3;
			}
			//排序
			$this->BigFocusSort ( $o_focus->getFocusId (), $_POST ['Vcl_Number'] );
			return 1;
		}
	}
	public function AddPhoto($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 69 )) {
			$o_focus = new Home_Photo ();
			$o_focus->setText ( $_POST ['Vcl_Text'] );
			if ($_FILES ['Vcl_File'] ['size'] > 0) {
				$allowpictype = array ('jpg', 'jpeg', 'gif', 'png' );
				$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Vcl_File'] ['name'], '.' ), 1 ) ) );
				if (! in_array ( $fileext, $allowpictype )) {
					return 2;
				}
				$o_focus->Save ();
				$o_focus->setPath ( 'images/photo/' . $o_focus->getPhotoId () . '.' . $fileext );
				$o_focus->Save ();
				copy ( $_FILES ['Vcl_File'] ['tmp_name'], RELATIVITY_PATH . 'sub/home/images/photo/' . $o_focus->getPhotoId () . '.' . $fileext );
			} else {
				return 3;
			}
			//排序
			return 1;
		}
	}
	private function FooterSort($n_focusid, $n_number) {
		$o_all = new Home_Article_Footer ();
		$o_all->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_all->PushWhere ( array ('&&', 'ArticleId', '<>', $n_focusid ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Home_Article_Footer ( $o_all->getArticleId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	private function FocusSort($n_focusid, $n_number) {
		$o_all = new Home_NewsFocus ();
		$o_all->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_all->PushWhere ( array ('&&', 'FocusId', '<>', $n_focusid ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Home_NewsFocus ( $o_all->getFocusId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	private function BigFocusSort($n_focusid, $n_number) {
		$o_all = new Home_Focus ();
		$o_all->PushWhere ( array ('&&', 'FocusId', '<>', $n_focusid ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Home_Focus ( $o_all->getFocusId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	private function LinkSort($n_linkid, $n_number) {
		$o_all = new Home_Link ();
		$o_all->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_all->PushWhere ( array ('&&', 'LinkId', '<>', $n_linkid ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Home_Link ( $o_all->getLinkId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	public function getResult() {
		return $this->Result;
	}
	public function CommentAdd($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_comment=new Home_Comment();
		$o_comment->setContent($this->AilterTextArea($_POST['Vcl_Content']));
		$o_comment->setArticleId($_POST['Vcl_ArticleId']);
		$o_comment->setUid($n_uid);
		$o_comment->setTime($this->GetDateNow());
		$o_comment->Save();
		return true;
	}
	public function CommentDelete($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		$o_comment=new Home_Comment($n_id);
		if ($o_comment->getUid==$n_uid ||$o_user->ValidModule ( 65 ))
		{
			$o_comment->Deletion();
		}
			
	}
	public function MessagesAdd($n_uid) {
		$o_comment=new Home_Messages();
		$o_comment->setContent($this->AilterTextArea($_POST['Vcl_Content']));
		$o_comment->setTitle($_POST['Vcl_Title']);
		$o_comment->setUid('访客'.rand ( 0, 9999 ));
		$o_comment->setDate($this->GetDateNow());
		$o_comment->Save();
		return true;
	}
}
?>