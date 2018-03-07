<?php
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'db_table.class.php';
class Operate extends Bn_Basic { 
	protected $Result;
	public $S_DeptName;
	public $S_DeptId;
	public function __construct() {
		$this->Result = TRUE;
		$this->S_DeptId = '';
		$this->S_DeptName = '';
	}
	public function getResult() {
		return $this->Result;
	}
	public function RecordAdd($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30001 )) {
			//用户基本信息
			$o_record = new Telephone_Info ();
			$o_record->setRecordDate($_POST ['Vcl_RecordDate']);
			$o_record->setRecordTime($_POST ['Vcl_RecordTime']);
			$o_record->setName($_POST ['Vcl_Name']);
			$o_record->setSex($_POST ['Vcl_Sex']);
			$o_record->setPhone($_POST ['Vcl_Phone']);
			//验证学校名称
			$o_school=new Base_Dept();
			$o_school->PushWhere ( array ('&&', 'Name', '=', $_POST ['Vcl_SchoolName']) );
			$o_school->PushWhere ( array ('&&', 'ParentId', '=',1) );
			$n_count = $o_school->getAllCount ();
			if($n_count==0)
			{
				$this->Result = '[ 来源学校 ] 输入有误！<br/>必须从提示中选择！';
				return false;
			}else{
				$o_record->setSchoolId($o_school->getDeptId(0)); 
			}		
			$o_record->setUid($n_uid);
			if ($o_school->getDeptId(0)==0 &&$_POST ['Vcl_SendType']=='2')
			{
				$this->Result = '学校名称为新生，不能转责任督学！';
				return false;
			}
			//是否是转责任督学
			if($_POST ['Vcl_SendType']=='2')
			{
				$o_record->setOwnerId($o_school->getUid(0));
				$o_temp=new Base_User_Info($o_school->getUid(0));
				$o_record->setOwnerName($o_temp->getName());
				$o_record->setState(0);
			}else{
				$o_record->setOwnerId($n_uid);
				$o_temp=new Base_User_Info($n_uid);
				$o_record->setOwnerName($o_temp->getName());
				$o_record->setState(1);
			}
			$o_record->setProfileId($_POST ['Vcl_ProfileId']);
			//验证类型
			$a_type=array();
			$o_type=new Telephone_Type();
			$n_count=$o_type->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				if ($_POST ['Vcl_Type'.$o_type->getId($i)]=='on')
				{
					array_push($a_type, $o_type->getId($i));
				}				
			}
			if (count($a_type)==0)
			{
				$this->Result = '请选择 [ 反映问题类别 ] ！';
				return false;
			}
			$o_record->setTypeId(json_encode($a_type));
			$o_record->setContent($this->AilterTextArea($_POST ['Vcl_Content']));
			$o_record->setExplain($this->AilterTextArea($_POST ['Vcl_Explain']));
			$o_record->Save();
			//记录处理过程
			/*if($_POST ['Vcl_SendType']!='2')
			{
				$o_progress = new Telephone_Progress ();
				$o_progress->setUid($n_uid);
				$o_progress->setInfoId($o_record->getId());
				$o_progress->setContent($this->AilterTextArea($_POST ['Vcl_Progress']));
				$o_progress->setDate($_POST ['Vcl_HandleDate']);
				$o_progress->Save();
			}*/
			if($_POST ['Vcl_SendType']=='3')
			{
				require_once RELATIVITY_PATH.'sub/gpdd_wenti/include/db_table.class.php';
				//转挂牌督导
				$o_user_info=new Base_User_Info_Custom($n_uid);
				$o_article=new GPDD_Wenti();
				$o_article->setName ('来电：'.$_POST ['Vcl_Name'].'<br/>接电：'.$o_user->getName());
				$o_article->setPhone ('来电：'.$_POST ['Vcl_Phone'].'<br/>接电：'.$o_user_info->getMobilePhone());
				$o_profile=new Telephone_Profile($_POST ['Vcl_ProfileId']);
				$o_article->setProfile ($o_profile->getName());
				$o_article->setOwnerId ($o_school->getUid(0));//责任督学
				$o_duxue=new Base_User_Info($o_school->getUid(0));
				$o_article->setOwnerName ($o_duxue->getName());
				$o_article->setSchoolId ($o_school->getDeptId(0));
				$o_article->setFrom ('热线电话('.$o_record->getId().')');
				$o_article->setSchoolName ($o_school->getName(0));
				$o_article->setState (0);
				$o_article->setDate ($this->GetDate());
				$o_article->setContent ($this->AilterTextArea($_POST ['Vcl_Content']));
				$o_article->Save();
			}
			return true;
		}
	}
	public function RecordDelete($n_uid,$n_id) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30001 )) {
			$o_table=new Telephone_Info($n_id);
			$o_table->Deletion();
		}
	}
	public function DudaoDelete($n_uid,$n_id) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30001 )) {
			$o_table=new Telephone_Info_Special($n_id);
			$o_table->Deletion();
		}
	}
	public function RecordModify($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30001 )) {
			//用户基本信息
			$o_record = new Telephone_Info ($_POST ['Vcl_Id']);
			$o_record->setRecordDate($_POST ['Vcl_RecordDate']);
			$o_record->setRecordTime($_POST ['Vcl_RecordTime']);
			$o_record->setName($_POST ['Vcl_Name']);
			$o_record->setSex($_POST ['Vcl_Sex']);
			$o_record->setPhone($_POST ['Vcl_Phone']);
			//验证类型
			$a_type=array();
			$o_type=new Telephone_Type();
			$n_count=$o_type->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				if ($_POST ['Vcl_Type'.$o_type->getId($i)]=='on')
				{
					array_push($a_type, $o_type->getId($i));
				}				
			}
			if (count($a_type)==0)
			{
				$this->Result = '请选择 [ 反映问题类别 ] ！';
				return false;
			}
			$o_record->setTypeId(json_encode($a_type));
			$o_record->setContent($this->AilterTextArea($_POST ['Vcl_Content']));
			$o_record->setExplain($this->AilterTextArea($_POST ['Vcl_Explain']));
			$o_record->setState(1);
			$o_record->Save();
			//记录处理过程
			$o_progress = new Telephone_Progress ();
			$o_progress->setUid($n_uid);
			$o_progress->setInfoId($o_record->getId());
			$o_progress->setContent($this->AilterTextArea($_POST ['Vcl_Progress']));
			$o_progress->setDate($_POST ['Vcl_HandleDate']);
			
			$o_progress->Save();
			return true;
		}
	}
	public function DudaoModify($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30001 )) {
			//用户基本信息
			$o_record = new Telephone_Info_Special ($_POST ['Vcl_Id']);
			$o_record->setDd($_POST ['Vcl_Dd']);
			$o_record->setDdQz($_POST ['Vcl_DdQz']);
			$o_record->setJgw($_POST ['Vcl_Jgw']);
			$o_record->setJgwQz($_POST ['Vcl_JgwQz']);
			$o_record->setCljg($_POST ['Vcl_Cljg']);
			$o_record->setCbr($_POST ['Vcl_Cbr']);
			$o_record->setCbDate($_POST ['Vcl_CbDate']);
			$o_record->setDf($_POST ['Vcl_Df']);
			$o_record->setCompleted($_POST ['Vcl_Completed']);
			$o_record->Save();
			if ($_POST ['Vcl_Completed']==1)
			{
				//说明处理完成，返回督学
				require_once RELATIVITY_PATH.'sub/gpdd_wenti/include/db_table.class.php';
				$o_table=new GPDD_Wenti($_POST ['Vcl_Id']);
				$o_table->setState(9);
				$o_table->setFeedbackType('业务科室处理');
				$o_table->setFeedbackUid($n_uid);
				$o_table->setFeedbackDate($_POST ['Vcl_CbDate']);
				$o_table->setFeedbackName($o_user->getName());
				$o_table->Save();
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
		//1. 热线电话，如果热线电话记录的处理结果为空，并且Owner是当前用户
		require_once RELATIVITY_PATH . 'sub/telephone/include/db_table.class.php';
		$o_temp=new Telephone_Info();
		$o_temp->PushWhere ( array ('&&', 'State', '=', 0) );
		$o_temp->PushWhere ( array ('&&', 'OwnerId', '=', $n_uid) );
		$n_sum=$n_sum+$o_temp->getAllCount();
		return $n_sum;
	}
}

?>