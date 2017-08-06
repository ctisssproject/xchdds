<?php
require_once 'db_table.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
class Operate extends Bn_Basic {
	protected $Result;
	public function __construct() {
		$this->Result = TRUE;
	}
	public function getResult() {
		return $this->Result;
	}
	public function AddArticle($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 50002 )) {
			$o_article = new Zhenggai_Article();
			$o_article->setTitle ( $_POST ['Vcl_Title'] );
			$o_article->setContent ( rawurldecode ( $_POST ['Vcl_Content'] ) );
			$o_date = new DateTime ( 'Asia/Chongqing' );
			$o_article->setDate ( $_POST ['Vcl_Date'] );
			$o_article->setLastDate ( $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' ) );
			$o_article->setType ( $_POST ['Vcl_Type'] );
			$o_article->setUid ($n_uid);
			$o_temp=new Base_Dept($_POST ['Vcl_DeptId']);
			$o_article->setDept ($o_temp->getName());
			$o_article->setDeptId ($_POST ['Vcl_DeptId']);
			$o_article->Save ();
			return;
		}
	}
	public function SubmitComment($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 50003 )) {
			$o_article = new Zhenggai_Article ($_POST['Vcl_ArticleId']);
			$o_article->setComment ($this->AilterTextArea($_POST['Vcl_Comment']) );
			$o_article->Save ();
			return;
		}
	}
}
?>