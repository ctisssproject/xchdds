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
		if ($o_user->ValidModule ( 30007 )) {
			$o_article = new Jiaoliu_Article ();
			$o_article->setTitle ( $_POST ['Vcl_Title'] );
			$o_article->setContent ( rawurldecode ( $_POST ['Vcl_Content'] ) );
			$o_date = new DateTime ( 'Asia/Chongqing' );
			$o_article->setDate ( $_POST ['Vcl_Date'] );
			$o_article->setStartTime ( $_POST ['Vcl_StartTime'] );
			$o_article->setEndTime ( $_POST ['Vcl_EndTime'] );
			$o_article->setLastDate ( $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' ) );
			$o_article->setSchoolJoin ( $_POST ['Vcl_SchoolJoin'] );
			//构建督学名单
			$o_temp = new View_User_List ();
			$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) ); 
			$o_temp->PushWhere ( array ('&&', 'DeptId', '=', 138 ) );
			$o_temp->PushOrder ( array ('Name', 'A' ) );
			$s_duxuejoin='';
			for($i=0;$i<$o_temp->getAllCount();$i++)
			{
				if($_POST['Vcl_DuxueJoin_'.$o_temp->getUid($i)]=='on')
				{
					$s_duxuejoin.=$o_temp->getName($i).'、';
				}
			}
			$s_duxuejoin=substr($s_duxuejoin,0,strlen($s_duxuejoin)-1); 
			$o_article->setDuxueJoin ($s_duxuejoin);
			$o_article->setFeedback ($this->AilterTextArea($_POST ['Vcl_Feedback'])  );
			$o_article->setUid ($n_uid);
			$a_dept=$o_user->getDeptName();
			$o_article->setDept ($a_dept[0]);
			$o_article->setSchoolId ($_POST ['Vcl_SchoolId']);
			$o_dept=new Base_Dept($_POST ['Vcl_SchoolId']);
			$o_article->setSchoolName ($o_dept->getName());
			$o_article->Save ();
			if($_POST ['Vcl_Transfer']==1)
			{
				require_once RELATIVITY_PATH.'sub/gpdd_wenti/include/db_table.class.php';
				//转挂牌督导
				$o_user_info=new Base_User_Info_Custom($n_uid);
				$o_article2=new GPDD_Wenti();
				$o_article2->setName ($o_user->getName());
				$o_article2->setPhone ($o_user_info->getMobilePhone());
				$o_article2->setProfile ('督学');
				$o_article2->setOwnerId ($n_uid);
				$o_article2->setOwnerName ($o_user->getName());
				$o_article2->setSchoolId ($_POST ['Vcl_SchoolId']);
				$o_article2->setFrom ('下校随访('.$o_article->getId().')');
				$o_article2->setSchoolName ($o_dept->getName());
				$o_article2->setState (0);
				$o_article2->setDate ($this->GetDate());
				$o_article2->setContent ( rawurldecode ( $_POST ['Vcl_Content'] ) );
				$o_article2->Save();
				return;
			}
		}
	}
	public function ModifyArticle($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30007 )) {
			$o_article = new Jiaoliu_Article ($_POST['Vcl_ArticleId']);
			$o_article->setTitle ( $_POST ['Vcl_Title'] );
			$o_article->setContent ( rawurldecode ( $_POST ['Vcl_Content'] ) );
			$o_date = new DateTime ( 'Asia/Chongqing' );
			$o_article->setSchoolJoin ( $_POST ['Vcl_SchoolJoin'] );
			$o_article->setDuxueJoin ( $_POST ['Vcl_DuxueJoin'] );
			$o_article->setDate ( $_POST ['Vcl_Date'] );
			$o_article->setStartTime ( $_POST ['Vcl_StartTime'] );
			$o_article->setEndTime ( $_POST ['Vcl_EndTime'] );
			$o_article->setFeedback ($this->AilterTextArea($_POST ['Vcl_Feedback'])  );
			$o_article->setLastDate ( $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' ) );
			$o_article->setType ( $_POST ['Vcl_Type'] );
			$o_article->Save ();
			if($_POST ['Vcl_Transfer']==1)
			{
				require_once RELATIVITY_PATH.'sub/gpdd_wenti/include/db_table.class.php';
				//转挂牌督导
				$o_user_info=new Base_User_Info_Custom($n_uid);
				$o_article2=new GPDD_Wenti();
				$o_article2->setName ($o_user->getName());
				$o_article2->setPhone ($o_user_info->getMobilePhone());
				$o_article2->setProfile ('督学');
				$o_article2->setOwnerId ($n_uid);
				$o_article2->setOwnerName ($o_user->getName());
				$o_article2->setSchoolId ($o_article->getSchoolId());
				$o_article2->setFrom ('随访记录('.$o_article->getId().')');
				$o_article2->setSchoolName ($o_article->getSchoolName());
				$o_article2->setState (0);
				$o_article2->setDate ($this->GetDate());
				$o_article2->setContent ( rawurldecode ( $_POST ['Vcl_Content'] ) );
				$o_article2->Save();
				return;
			}
			return;
		}
	}
	public function DeleteArticle($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30007 )) {
			$o_article = new Jiaoliu_Article($n_id);
			if ($o_article->getUid () == $n_uid) 
			{	
				$o_article->Deletion();
			}
		}
	}
}
?>