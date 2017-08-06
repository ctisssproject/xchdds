<?php
require_once 'db_table.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH.'sub/telephone/include/db_table.class.php';
require_once RELATIVITY_PATH.'sub/survey/include/db_table.class.php';
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
		
		if ($o_user->ValidModule ( 30012 )) {
			//先验证问题类型是否合法
			$a_type=array();
			$o_type=new Telephone_Type();
			$n_count=$o_type->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				if ($_POST ['Vcl_Type'.$o_type->getId($i)]=='on')
				{
					array_push($a_type, $o_type->getId($i));
					if ($o_type->getId($i)==9)
					{//如果选了其他，需要填写类型名称
						if ($_POST ['Vcl_Type_Other']=='')
						{
							$this->Result = '请填写其他情况！';
							return false;
						}						
					}
				}				
			}
			if (count($a_type)==0)
			{
				$this->Result = '请选择 [ 问题类别 ] ！';
				return false;
			}
			//根据类型拆分问题，注意其他编号“9”
			$o_school=new Base_Dept($_POST ['Vcl_SchoolId']);
			$o_user_info=new Base_User_Info_Custom($n_uid);
			for($i=0;$i<count($a_type);$i++)
			{
				$o_article=new GPDD_Wenti();
				$o_article->setName ($o_user->getName());
				$o_article->setPhone ($o_user_info->getMobilePhone());
				$o_article->setProfile ('督学');
				$o_article->setOwnerId ($n_uid);
				$o_article->setOwnerName ($o_user->getName());
				$o_article->setSchoolId ($_POST ['Vcl_SchoolId']);
				$o_article->setFrom ('其他：'.$_POST ['Vcl_From']);
				$o_article->setSchoolName ($o_school->getName());
				$o_article->setState (1);
				$o_article->setDate ($this->GetDate());
				$o_article->setContent ( rawurldecode ( $_POST ['Vcl_Content'] ) );
				$o_type=new Telephone_Type($a_type[$i]);
				$o_article->setTypeId($a_type[$i]);
				if ($a_type[$i]==9)
				{
					$o_article->setTypeName($o_type->getName().'：'.$_POST ['Vcl_Type_Other']);
				}else{
					$o_article->setTypeName($o_type->getName());
				}
				$o_article->Save();
			}
			return true;
		}
	}
	public function HandleClassify($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		
		if ($o_user->ValidModule ( 30012 )) {
			//先验证问题类型是否合法
			$a_type=array();
			$o_type=new Telephone_Type();
			$n_count=$o_type->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				if ($_POST ['Vcl_Type'.$o_type->getId($i)]=='on')
				{
					array_push($a_type, $o_type->getId($i));
					if ($o_type->getId($i)==9)
					{//如果选了其他，需要填写类型名称
						if ($_POST ['Vcl_Type_Other']=='')
						{
							$this->Result = '请填写其他情况！';
							return false;
						}						
					}
				}				
			}
			if (count($a_type)==0)
			{
				$this->Result = '请选择 [ 问题类别 ] ！';
				return false;
			}
			//根据类型拆分问题，注意其他编号“9”
			$o_article_old=new GPDD_Wenti($_POST ['Vcl_Id']);
			for($i=0;$i<count($a_type);$i++)
			{
				$o_article=new GPDD_Wenti();
				$o_article->setName ($o_article_old->getName());
				$o_article->setPhone ($o_article_old->getPhone());
				$o_article->setProfile ($o_article_old->getProfile());
				$o_article->setOwnerId ($o_article_old->getOwnerId());
				$o_article->setOwnerName ($o_article_old->getOwnerName());
				$o_article->setSchoolId ($o_article_old->getSchoolId());
				$o_article->setFrom ($o_article_old->getFrom());
				$o_article->setSchoolName ($o_article_old->getSchoolName());
				$o_article->setState (1);
				$o_article->setDate ($o_article_old->getDate());
				$o_article->setContent ( $o_article_old->getContent());
				$o_type=new Telephone_Type($a_type[$i]);
				$o_article->setTypeId($a_type[$i]);
				if ($a_type[$i]==9)
				{
					$o_article->setTypeName($o_type->getName().'：'.$_POST ['Vcl_Type_Other']);
				}else{
					$o_article->setTypeName($o_type->getName());
				}
				$o_article->Save();
			}
			$o_article_old->Deletion();
			return true;
		}
	}
	public function HandleArrange($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30013 )) {
			$o_type=new GPDD_Wenti($_POST ['Vcl_Id']);
			$o_type->setState($_POST ['Vcl_State']);
			$o_type->Save();
			if ($_POST ['Vcl_State']==3)
			{
				//说明是转业务科室，需要添加业务科室信息
				$o_record = new Telephone_Info_Special ();
				$o_record->setId($_POST ['Vcl_Id']);
				$o_record->setRecordDate($o_type->getDate());
				$o_record->setUid($o_type->getOwnerId());
				$o_record->setName($o_type->getName());
				$o_record->setPhone($o_type->getPhone());
				$o_record->setSchoolId($o_type->getSchoolId());
				$o_profile=new Telephone_Profile();
				$o_profile->PushWhere ( array ('&&', 'Name', '=', $o_type->getProfile()) );
				$o_profile->getAllCount();
				$o_record->setProfileId($o_profile->getId(0));
				$o_record->setContent($o_type->getContent());
				$o_record->Save();
			}
			return true;
		}
	}
	public function HandleConfirm($n_uid,$n_id) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30013 )) {
			$o_type=new GPDD_Wenti($n_id);
			$o_type->setState(10);
			$o_type->setResolveDate($this->GetDate());
			$o_type->Save();
			return true; 
		}
	}
	public function HandleDisconfirm($n_uid,$n_id) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30013 )) {
			$o_type=new GPDD_Wenti($n_id);
			$o_type->setState(1);
			$o_type->Save();
			return true;
		}
	}
	public function HandleFeedback($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30011 )) {
			$o_type=new GPDD_Wenti($_POST ['Vcl_Id']);
			$s_type='';
			switch ($o_type->getState())
			{
				case 1:
					$o_type->setFeedbackType('督学处理');
					$o_type->setState(10);//问题解决
					$o_type->setResolveDate($this->GetDate());
					break;
				case 2:
					$o_type->setFeedbackType('学校处理');
					$o_type->setState(9);//待确认
					break;
				case 3:
					$o_type->setFeedbackType('业务科室处理');
					$o_type->setState(9);//待确认
					break;
				default :
					break;
			}	
			$o_type->setFeedbackUid($n_uid);
			$o_type->setFeedbackDate($this->GetDate());
			$o_type->setFeedbackName($o_user->getName());
			$o_type->setContent ( rawurldecode ( $_POST ['Vcl_Content'] ) );
			$o_type->setFeedback($this->AilterTextArea($_POST ['Vcl_Feedback']));
			$o_type->Save();
			return true;
		}
	}
	public function ZcFeedback($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30022 )) {
			$o_type=new GPDD_Zc($_POST ['Vcl_Id']);
			$s_type='';
			$o_type->setState(2);
			$o_type->setFeedbackId($n_uid);
			$o_type->setFeedbackDate($this->GetDate());
			$o_type->setFeedbackName($o_user->getName());
			$o_type->setFeedback(rawurldecode ( $_POST ['Vcl_Content'] ));
			$o_type->Save();
			return true;
		}
	}
	public function DcFeedback($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30027 )) {
			$o_type=new GPDD_Dc($_POST ['Vcl_Id']);
			$s_type='';
			$o_type->setState(2);
			$o_type->setFeedbackId($n_uid);
			$o_type->setFeedbackDate($this->GetDate());
			$o_type->setFeedbackName($o_user->getName());
			$o_type->setFeedback(rawurldecode ( $_POST ['Vcl_Content'] ));
			$o_type->Save();
			return true;
		}
	}
	public function DcSummary($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30026 )) {
			$o_type=new GPDD_Dc_Summary($_POST ['Vcl_Id']);
			$s_type='';
			$o_type->setState(1);
			$o_type->setFeedbackUid($n_uid);
			$o_type->setFeedbackName($o_user->getName());
			$o_type->setFeedback(rawurldecode ( $_POST ['Vcl_Content'] ));
			$o_type->Save();
			return true;
		}
	}
	public function ZcReject($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30024 )) {
			$o_type=new GPDD_Zc($_POST ['Vcl_Id']);
			$s_type='';
			$o_type->setState(3);
			$o_type->setReason($this->AilterTextArea($_POST ['Vcl_Reason']));
			$o_type->Save();
			return true;
		}
	}
	public function DcReject($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30025 )) {
			$o_type=new GPDD_Dc($_POST ['Vcl_Id']);
			$s_type='';
			$o_type->setState(5);
			$o_type->setReason2($this->AilterTextArea($_POST ['Vcl_Reason2']));
			$o_type->Save();
			return true;
		}
	}
	public function DcAuditorReject($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30026 )) {
			$o_type=new GPDD_Dc($_POST ['Vcl_Id']);
			$s_type='';
			$o_type->setState(3);
			$o_type->setReason1($this->AilterTextArea($_POST ['Vcl_Reason1']));
			$o_type->Save();
			return true;
		}
	}
	public function ZcConfirm($n_uid,$id) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30024 )) {
			$o_type=new GPDD_Zc($id);
			$s_type='';
			$o_type->setState(4);
			$o_type->setCompletedDate($this->GetDate());
			$o_type->Save();
			return true;
		}
	}
	public function ZcDelete($n_uid,$id) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30030 )) {
			$o_type=new GPDD_Zc($id);
			$o_type->Deletion();
			return true;
		}
	}
	public function DcDelete($n_uid,$id) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30031 )) {
			$o_type=new GPDD_Dc($id);
			$o_type->Deletion();
			return true;
		}
	}
	public function DcConfirm($n_uid,$id) { 
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30025 )) {
			$o_type=new GPDD_Dc($id);
			$s_type='';
			$o_type->setState(6);
			$o_type->setCompletedDate($this->GetDate());
			$o_type->Save();
			//检查是否所有都是已完成如果是，将summary变为已完成
			$o_summary=new GPDD_Dc_Summary($o_type->getParentId());
			$o_type=new GPDD_Dc();
			$o_type->PushWhere ( array ('&&', 'State', '<', 6) );
			if($o_type->getAllCount()==0)
			{
				$o_summary->setState(1);
				$o_summary->Save();
			}			
			return true;
		}
	}
	public function DcAuditorFeedback($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 30026 )) {
			$o_type=new GPDD_Dc($_POST ['Vcl_Id']);
			$o_type->setState(4);
			$o_type->setOwnerFeedback($this->AilterTextArea($_POST ['Vcl_OwnerFeedback']));
			$o_type->Save();
			return true;
		}
	}
	public function AddZc($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		
		if ($o_user->ValidModule ( 30024 )) {
			//先验证问题类型是否合法
			$a_dept=array();
			//根据选中的分组，压入数组
			$o_temp=new Base_Group();
			$o_temp->PushWhere ( array ('&&', 'Type', '=', 'Dept' ) );
			$n_count=$o_temp->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				if($_POST['Vcl_Group_'.$o_temp->getId($i)]=='on')
				{
					$o_temp2=new Base_Group_Member();
					$o_temp2->PushWhere ( array ('&&', 'GroupId', '=', $o_temp->getId($i) ) );
					for($j=0;$j<$o_temp2->getAllCount();$j++)
					{
						if(!in_array($o_temp2->getUid($j), $a_dept))
						{
							array_push($a_dept, $o_temp2->getUid($j));
						}
					}
				}
			}
			//根据部门，压入数组
			$o_temp=new Base_Dept();
			$o_temp->PushWhere ( array ('&&', 'ParentId', '=', 1 ) );
			for($i=0;$i<$o_temp->getAllCount();$i++)
			{
				if($_POST['Vcl_Dept_'.$o_temp->getDeptId($i)]=='on')
				{
					if(!in_array($o_temp->getDeptId($i), $a_dept))
					{
						array_push($a_dept, $o_temp->getDeptId($i));
					}
				}
			}
			for($i=0;$i<count($a_dept);$i++)
			{
				$o_article=new GPDD_Zc();
				$o_article->setDate($_POST['Vcl_Date']);
				$o_article->setState(1);
				$o_article->setContent(rawurldecode ( $_POST ['Vcl_Content'] ));
				$o_article->setUid($n_uid);
				$o_dept=new Base_Dept($a_dept[$i]);
				$o_article->setOwnerId($o_dept->getUid());
				$o_article->setSchoolId($o_dept->getDeptId());
				$o_article->setSchoolName($o_dept->getName());		
				$o_article->setTitle($_POST['Vcl_Title']);
				$o_user_temp=new Base_User_Info($o_dept->getUid());
				$o_article->setOwnerName($o_user_temp->getName());
				$o_article->setUserName($o_user->getName());
				$o_article->Save();
			}
			return true;
		}
	}
	public function AddDc($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		
		if ($o_user->ValidModule ( 30025 )) {
			//先验证问题类型是否合法
			$a_dept=array();
			//根据选中的分组，压入数组
			$o_temp=new Base_Group();
			$o_temp->PushWhere ( array ('&&', 'Type', '=', 'Dept' ) );
			$n_count=$o_temp->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				if($_POST['Vcl_Group_'.$o_temp->getId($i)]=='on')
				{
					$o_temp2=new Base_Group_Member();
					$o_temp2->PushWhere ( array ('&&', 'GroupId', '=', $o_temp->getId($i) ) );
					for($j=0;$j<$o_temp2->getAllCount();$j++)
					{
						if(!in_array($o_temp2->getUid($j), $a_dept))
						{
							array_push($a_dept, $o_temp2->getUid($j));
						}
					}
				}
			}
			//根据部门，压入数组
			$o_temp=new Base_Dept();
			$o_temp->PushWhere ( array ('&&', 'ParentId', '=', 1 ) );
			for($i=0;$i<$o_temp->getAllCount();$i++)
			{
				if($_POST['Vcl_Dept_'.$o_temp->getDeptId($i)]=='on')
				{
					if(!in_array($o_temp->getDeptId($i), $a_dept))
					{
						array_push($a_dept, $o_temp->getDeptId($i));
					}
				}
			}
			//压入另一个数组督学名单
			$a_auditor_id=array();
			$a_auditor_name=array();
			$o_temp=new Base_Group();
			$o_temp->PushWhere ( array ('&&', 'Type', '=', 'User' ) );
			$n_count=$o_temp->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				if($_POST['Vcl_Group_'.$o_temp->getId($i)]=='on')
				{
					$o_temp2=new Base_Group_Member();
					$o_temp2->PushWhere ( array ('&&', 'GroupId', '=', $o_temp->getId($i) ) );
					for($j=0;$j<$o_temp2->getAllCount();$j++)
					{
						if(!in_array($o_temp2->getUid($j), $a_auditor_id))
						{
							$o_user_temp=new Base_User_Info($o_temp2->getUid($j));
							array_push($a_auditor_id, $o_temp2->getUid($j));
							array_push($a_auditor_name, rawurlencode($o_user_temp->getName()));
						}
					}
				}
			}
			$o_temp = new View_User_List ();
			$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) ); 
			$o_temp->PushWhere ( array ('&&', 'DeptId', '=', 138 ) );
			$o_temp->PushOrder ( array ('Name', 'A' ) );
			for($i=0;$i<$o_temp->getAllCount();$i++)
			{
				if($_POST['Vcl_User_'.$o_temp->getUid($i)]=='on')
				{
					if(!in_array($o_temp->getUid($i), $a_auditor_id))
					{
						array_push($a_auditor_id, $o_temp->getUid($i));
						array_push($a_auditor_name,  rawurlencode($o_temp->getName($i)));
					}
				}
			}			
			$o_summary=new GPDD_Dc_Summary();
			$o_summary->setDate($_POST['Vcl_Date']);
			$o_summary->setTitle($_POST['Vcl_Title']);
			$o_summary->setOwnerId(json_encode($a_auditor_id));
			$o_summary->Save();
			for($i=0;$i<count($a_dept);$i++)
			{
				$o_article=new GPDD_Dc();
				$o_article->setDate($_POST['Vcl_Date']);
				$o_article->setState(1);
				$o_article->setContent(rawurldecode ( $_POST ['Vcl_Content'] ));
				$o_article->setUid($n_uid);
				$o_dept=new Base_Dept($a_dept[$i]);
				$o_article->setOwnerId(json_encode($a_auditor_id));
				$o_article->setSchoolId($o_dept->getDeptId());
				$o_article->setSchoolName($o_dept->getName());		
				$o_article->setTitle($_POST['Vcl_Title']);
				$o_article->setOwnerName(json_encode($a_auditor_name));
				$o_article->setUserName($o_user->getName());
				$o_article->setParentId($o_summary->getId());
				$o_article->Save();
			}
			return true;
		}
	}
	public function RefreshMenuNotice($id,$n_uid,$type) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
		
		$o_user = new Single_User ( $n_uid );
		$n_sum=0;
		//3. 协同办理，分四个
		require_once RELATIVITY_PATH . 'sub/gpdd_wenti/include/db_table.class.php';
		if ($type==1)
		{
			//3.1 等待受理
			$o_temp=new GPDD_Wenti();
			$o_temp->PushWhere ( array ('&&', 'State', '=', 0) );
			$o_temp->PushWhere ( array ('&&', 'OwnerId', '=', $n_uid ) );
			$n_sum=$n_sum+$o_temp->getAllCount();
			//3.2 等待督学处理和已处理待确认
			$o_temp=new GPDD_Wenti();
			$o_temp->PushWhere ( array ('&&', 'State', '=', 1) );
			$o_temp->PushWhere ( array ('&&', 'OwnerId', '=', $n_uid ) );
			$o_temp->PushWhere ( array ('||', 'State', '=', 9) );
			$o_temp->PushWhere ( array ('&&', 'OwnerId', '=', $n_uid ) );
			$n_sum=$n_sum+$o_temp->getAllCount();
			//3.3 等待学校处理
			$o_temp=new GPDD_Wenti();
			$o_temp->PushWhere ( array ('&&', 'State', '=', 2) );		
			$a_dept=$o_user->getDeptId();//获取部门编号
			$o_temp->PushWhere ( array ('&&', 'SchoolId', '=',$a_dept[0]) );
			$n_sum=$n_sum+$o_temp->getAllCount();
			//3.4 等待业务科室处理
			$o_temp=new GPDD_Wenti();
			$o_temp->PushWhere ( array ('&&', 'State', '=', 3) );	
			if ($o_user->ValidModule(30016)==true)
			{
				$n_sum=$n_sum+$o_temp->getAllCount();
			}
			return $n_sum;
		}
		if ($type==2)
		{
			//4. 专项督导-自查
			//4.1 等待学校反馈与被退回重新反馈
			$o_temp=new GPDD_Zc();
			$o_temp->PushWhere ( array ('&&', 'State', '=', 1) );		
			$a_dept=$o_user->getDeptId();//获取部门编号
			$o_temp->PushWhere ( array ('&&', 'SchoolId', '=',$a_dept[0]) );
			$o_temp->PushWhere ( array ('||', 'State', '=', 3) );	
			$o_temp->PushWhere ( array ('&&', 'SchoolId', '=',$a_dept[0]) );
			$n_sum=$n_sum+$o_temp->getAllCount();
			//4.2 等待科室确认
			$o_temp=new GPDD_Zc();
			$o_temp->PushWhere ( array ('&&', 'State', '=', 2) );	
			if ($o_user->ValidModule(30024)==true)
			{
				$n_sum=$n_sum+$o_temp->getAllCount();
			}	
			//5. 专项督导-督查
			//5.1 等待学校反馈、退回
			$o_temp=new GPDD_Dc();
			$o_temp->PushWhere ( array ('&&', 'State', '=', 1) );
			$a_dept=$o_user->getDeptId();//获取部门编号
			$o_temp->PushWhere ( array ('&&', 'SchoolId', '=',$a_dept[0]) );
			$o_temp->PushWhere ( array ('||', 'State', '=', 3) );
			$o_temp->PushWhere ( array ('&&', 'SchoolId', '=',$a_dept[0]) );
			$n_sum=$n_sum+$o_temp->getAllCount();
			//5.2 等待督学反馈、退回
			$o_temp=new GPDD_Dc();
			$o_temp->PushWhere ( array ('&&', 'State', '=', 2) );
			$o_temp->PushWhere ( array ('&&', 'OwnerId', 'Like', '%"'.$o_user->getUid().'"%' ) );
			$o_temp->PushWhere ( array ('||', 'State', '=', 5) );
			$o_temp->PushWhere ( array ('&&', 'OwnerId', 'Like', '%"'.$o_user->getUid().'"%' ) );
			$n_sum=$n_sum+$o_temp->getAllCount();
			//5.3 等待科室归档
			$o_temp=new GPDD_Dc();
			$o_temp->PushWhere ( array ('&&', 'State', '=', 4) );
			$o_temp->PushWhere ( array ('&&', 'Uid', '=',$o_user->getUid()) );
			$n_sum=$n_sum+$o_temp->getAllCount();
			return $n_sum;
		}
	}
}
?>