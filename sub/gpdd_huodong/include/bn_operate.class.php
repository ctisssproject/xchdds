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
		
		if ($o_user->ValidModule ( 30018 )) {
			//先验证问题类型是否合法
			$o_article=new GPDD_Huodong();
			$o_article->setTitle ($_POST ['Vcl_Title']);
			$o_article->setOpenId ($n_uid);
			$o_article->setName ($_POST ['Vcl_Name']);
			$o_article->setPhone ($_POST ['Vcl_Phone']);
			$o_article->setAddress ($_POST ['Vcl_Address']);
			$a_dept=$o_user->getDeptId();
			$o_article->setSchoolId ($a_dept[0]);
			$o_dept=new Base_Dept($a_dept[0]);
			$o_article->setSchoolName ($o_dept->getName());
			$o_article->setDate ($_POST ['Vcl_Date']);
			$o_owner=new Base_User_Info($o_dept->getUid());
			$o_article->setOwnerName ($o_owner->getName());
			$o_article->setOwnerId ($o_dept->getUid());
			$o_article->setContent ($this->AilterTextArea($_POST ['Vcl_Content']));
			$o_article->setState (0);
			$o_article->Save();
			return true;
		}
	}
	public function Reply($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		
		if ($o_user->ValidModule ( 30018 )) {
			//先验证问题类型是否合法
			$o_article=new GPDD_Huodong($_POST ['Vcl_Id']);
			$o_article->setIsGo ($_POST ['Vcl_IsGo']);
			$o_article->setGoReason ($this->AilterTextArea($_POST ['Vcl_GoReason']));
			if($_POST ['Vcl_IsGo']==0)
			{
				$o_article->setState (2);
				if ($this->AilterTextArea($_POST ['Vcl_GoReason'])=='')
				{
					echo ('<script type="text/javascript" language="javascript">parent.window.alert(\'备注不能为空！\')</script>');
					exit(0);
				}
				
			}else{
				$o_article->setState (1);
			}
			$o_article->setIsGo ($_POST ['Vcl_IsGo']);			
			$o_article->Save();
			return true;
		}
	}	
	public function JoinConfirm($n_uid,$n_id) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		
		if ($o_user->ValidModule ( 30018 )) {
			//先验证问题类型是否合法
			$o_article=new GPDD_Huodong($n_id);
			$o_article->setState (3);			
			$o_article->Save();
			return true;
		}
	}	
	public function HuodongDelete($n_uid,$n_id) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		
		if ($o_user->ValidModule ( 30029 )) {
			//先验证问题类型是否合法
			$o_article=new GPDD_Huodong($n_id);
			$o_article->Deletion();			
			return true;
		}
	}
	public function CompletedConfirm($n_uid,$n_id) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		
		if ($o_user->ValidModule ( 30018 )) {
			//先验证问题类型是否合法
			$o_article=new GPDD_Huodong($n_id);
			$o_article->setState (10);			
			$o_article->Save();
			return true;
		}
	}	
	public function Feedback($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		
		if ($o_user->ValidModule ( 30018 )) {
			//先验证问题类型是否合法
			$o_article=new GPDD_Huodong($_POST ['Vcl_Id']);
			$o_article->setFeedback ($_POST ['Vcl_Feedback']);
			$o_article->setFeedbackDate ($this->GetDate());
			$o_article->setState (4);
			$o_article->Save();
			if($_POST['Vcl_Suifang']==1)
			{
				//添加到随访记录
				require_once RELATIVITY_PATH.'sub/jiaoliu/include/db_table.class.php';
				$o_article2 = new Jiaoliu_Article ();
				$o_article2->setTitle ( '参与《'.$o_article->getTitle().'》下校随访' );
				$o_article2->setContent ( '参与《'.$o_article->getTitle().'》的过程中，....' );
				$o_date = new DateTime ( 'Asia/Chongqing' );
				$o_article2->setDate ($this->GetDate());
				$o_article2->setType ('信息报送');
				$o_article2->setUid ($n_uid);
				$a_dept=$o_user->getDeptName();
				$o_article2->setDept ($a_dept[0]);
				$o_article2->setSchoolId ($o_article->getSchoolId());
				$o_article2->setSchoolName ($o_article->getSchoolName());
				$o_article2->Save ();
			}
			return true;
		}
	}
	public function RefreshMenuNotice($id,$n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
		$n_sum=0;
		//2. 参与活动，分四个
		require_once RELATIVITY_PATH . 'sub/gpdd_huodong/include/db_table.class.php';
		//2.1 待督学答复和等待督学反馈
		$o_temp=new GPDD_Huodong();
		$o_temp->PushWhere ( array ('&&', 'State', '=', 0) );
		$o_temp->PushWhere ( array ('&&', 'OwnerId', '=', $n_uid) );
		$o_temp->PushWhere ( array ('||', 'State', '=', 3) );
		$o_temp->PushWhere ( array ('&&', 'OwnerId', '=', $n_uid) );
		$n_sum=$n_sum+$o_temp->getAllCount();
		//2.2 等待学校确认，因为督学可以去也可以不去，和确认活动完成
		$o_temp=new GPDD_Huodong();
		$o_temp->PushWhere ( array ('&&', 'State', '=', 1) );
		$o_temp->PushWhere ( array ('&&', 'OpenId', '=', $n_uid) );
		$o_temp->PushWhere ( array ('||', 'State', '=', 2) );
		$o_temp->PushWhere ( array ('&&', 'OpenId', '=', $n_uid) );
		$o_temp->PushWhere ( array ('||', 'State', '=', 4) );
		$o_temp->PushWhere ( array ('&&', 'OpenId', '=', $n_uid) );
		$n_sum=$n_sum+$o_temp->getAllCount();
		return $n_sum;
	}
}
?>