<?php
error_reporting ( 0 );
require_once 'db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
class Operate extends Bn_Basic {
	public function ZbtxProjectAdd($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Project();
			$o_table->setName($this->getPost('Name'));
			$o_table->setOwnerId($n_uid);
			$o_table->setState(0);
			$o_table->setCreateDate($this->GetDateNow());
			$o_table->setExplain($this->getPost('Explain'));
			$a_type=array();
			$o_scope=new Base_School_Type();
			$o_scope->PushOrder ( array ('Id', 'A' ) );
			for($i=0;$i<$o_scope->getAllCount();$i++)
			{
				if ($this->getPost('Scope_'.$o_scope->getId($i))=='on') {
					array_push ( $a_type, $o_scope->getId($i));
				}
			}
			if (count ( $a_type ) == 0) {
				$this->setReturn('parent.parent.parent.Dialog_Message("请选择测评对象！");');
			}
			$o_table->setScope ( json_encode ( $a_type ) );
			$o_table->Save();
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'?'.time().'\';');
	}
	public function ZbtxProjectModify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Project($this->getPost('Id'));
			$o_table->setName($this->getPost('Name'));
			$o_table->setExplain($this->getPost('Explain'));
			$a_type=array();
			$o_scope=new Base_School_Type();
			$o_scope->PushOrder ( array ('Id', 'A' ) );
			for($i=0;$i<$o_scope->getAllCount();$i++)
			{
				if ($this->getPost('Scope_'.$o_scope->getId($i))=='on') {
					array_push ( $a_type, $o_scope->getId($i));
				}
			}
			if (count ( $a_type ) == 0) {
				$this->setReturn('parent.parent.parent.Dialog_Message("请选择测评对象！");');
			}
			$o_table->setScope ( json_encode ( $a_type ) );
			$o_table->Save();
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'?'.time().'\';');
	}
	public function ZbtxProjectRelease($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Project($this->getPost('id'));
			$o_table->setReleaseDate($this->GetDate());
			$o_table->setState(1);
			$o_table->Save();
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function ZbtxProjectDelete($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Project($this->getPost('id'));
			$o_table->setIsDelete(1);
			$o_table->Save();
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	
	public function ZbtxProjectLevel1Add($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Level1();
			$o_table->setName($this->getPost('Name'));
			$o_table->setNumber($this->getPost('Number'));
			$o_table->setProjectId($this->getPost('ProjectId'));
			$o_table->Save();
			$this->ZbtxProjectLevel1Sort($o_table->getId(),$o_table->getNumber(),$o_table->getProjectId());
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'&time='.time().'\';');
	}
	public function ZbtxProjectLevel1Modify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Level1($this->getPost('Id'));
			$o_table->setName($this->getPost('Name'));
			$o_table->setNumber($this->getPost('Number'));
			$o_table->Save();
			$this->ZbtxProjectLevel1Sort($o_table->getId(),$o_table->getNumber(),$o_table->getProjectId());
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'&time='.time().'\';');
	}	
	private function ZbtxProjectLevel1Sort($n_level1_id, $n_number, $n_project_id) {
		$o_all = new Zhdd_Zbtx_Level1 ();
		$o_all->PushWhere ( array ('&&', 'Id', '<>', $n_level1_id ) );
		$o_all->PushWhere ( array ('&&', 'ProjectId', '=', $n_project_id ) );
		$o_all->PushWhere ( array ('&&', 'IsDelete', '=', 0 ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Zhdd_Zbtx_Level1 ( $o_all->getId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	public function ZbtxProjectLevel1Delete($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Level1($this->getPost('id'));
			$o_table->setIsDelete(1);
			$o_table->Save();
			$this->ZbtxProjectLevel1Sort(0,1000,$o_table->getProjectId());
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function ZbtxProjectLevel2Add($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Level2();
			$o_table->setName($this->getPost('Name'));
			$o_table->setNumber($this->getPost('Number'));
			$o_table->setLevel1Id($this->getPost('Level1Id'));
			$o_table->Save();
			$this->ZbtxProjectLevel2Sort($o_table->getId(),$o_table->getNumber(),$o_table->getLevel1Id());
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'&time='.time().'\';');
	}
	public function ZbtxProjectLevel2Modify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Level2($this->getPost('Id'));
			$o_table->setName($this->getPost('Name'));
			$o_table->setNumber($this->getPost('Number'));
			$o_table->Save();
			$this->ZbtxProjectLevel2Sort($o_table->getId(),$o_table->getNumber(),$o_table->getLevel1Id());
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'&time='.time().'\';');
	}
	private function ZbtxProjectLevel2Sort($n_level2_id, $n_number, $n_level1_id) {
		$o_all = new Zhdd_Zbtx_Level2 ();
		$o_all->PushWhere ( array ('&&', 'Id', '<>', $n_level2_id ) );
		$o_all->PushWhere ( array ('&&', 'Level1Id', '=', $n_level1_id ) );
		$o_all->PushWhere ( array ('&&', 'IsDelete', '=', 0 ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Zhdd_Zbtx_Level2 ( $o_all->getId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	public function ZbtxProjectLevel2Delete($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Level2($this->getPost('id'));
			$o_table->setIsDelete(1);
			$o_table->Save();
			$this->ZbtxProjectLevel2Sort(0,1000,$o_table->getLevel1Id());
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	private function ZbtxProjectLevel3Sort($n_level3_id, $n_number, $n_level2_id) {
		$o_all = new Zhdd_Zbtx_Level3 ();
		$o_all->PushWhere ( array ('&&', 'Id', '<>', $n_level3_id ) );
		$o_all->PushWhere ( array ('&&', 'Level2Id', '=', $n_level2_id ) );
		$o_all->PushWhere ( array ('&&', 'IsDelete', '=', 0 ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Zhdd_Zbtx_Level3 ( $o_all->getId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	public function ZbtxProjectLevel3Add($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Level3();
			$o_table->setName($this->getPost('Name'));
			$o_table->setNumber($this->getPost('Number'));
			$o_table->setScore($this->getPost('Score'));
			$o_table->setLevel2Id($this->getPost('Level2Id'));
			$o_table->Save();
			$this->ZbtxProjectLevel3Sort($o_table->getId(),$o_table->getNumber(),$o_table->getLevel2Id());
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'&time='.time().'\';');
	}
	public function ZbtxProjectLevel3Modify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Level3($this->getPost('Id'));
			$o_table->setName($this->getPost('Name'));
			$o_table->setNumber($this->getPost('Number'));
			$o_table->setScore($this->getPost('Score'));
			$o_table->Save();
			$this->ZbtxProjectLevel3Sort($o_table->getId(),$o_table->getNumber(),$o_table->getLevel2Id());
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'&time='.time().'\';');
	}
	public function ZbtxProjectLevel3Delete($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Level3($this->getPost('id'));
			$o_table->setIsDelete(1);
			$o_table->Save();
			$this->ZbtxProjectLevel3Sort(0,1000,$o_table->getLevel2Id());
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function ZbtxSchoolUploadAdd($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31002 )) {
			if ($_FILES ['Vcl_File'] ['size'] > 0) {
				mkdir ( RELATIVITY_PATH . 'userdata/zhdd', 0777 );
				mkdir ( RELATIVITY_PATH . 'userdata/zhdd/zbtx', 0777 );
				$allowpictype = array ('jpg', 'jpeg', 'pdf', 'png' );
				$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Vcl_File'] ['name'], '.' ), 1 ) ) );
				if (! in_array ( $fileext, $allowpictype )) {
					$this->setReturn('parent.parent.parent.Dialog_Message("只能上传PDF 或 图片文件！");');
				}
				sleep(1);
				$o_user_info=new Base_User_Info_View($n_uid);
				$o_table=new Zhdd_Zbtx_Doc();
				$o_table->setDeptId($o_user_info->getDeptId());
				$o_table->setOwnerId($n_uid);
				$o_table->setLevel3Id($this->getPost('Level3Id'));
				$o_table->setNumber($this->getPost('Number'));
				$o_table->setResultId($this->getPost('ResultId'));
				$o_table->setIsDelete(0);
				$o_table->setCreateDate($this->GetDateNow());
				$o_table->setFileName($_FILES ['Vcl_File'] ['name']);
				$o_table->setExplain($this->getPost('Explain'));
				$o_table->setFileType($fileext);
				$o_table->Save();
				$s_filename=$o_table->getId().'.'.$fileext;
				$o_table->setPath ( 'userdata/zhdd/zbtx/' . $s_filename );
				$o_table->Save();
				copy ( $_FILES ['Vcl_File'] ['tmp_name'], RELATIVITY_PATH . 'userdata/zhdd/zbtx/' . $s_filename );
				$this->ZbtxSchoolUploadDocSort($o_table->getDeptId(),$o_table->getNumber(),$o_table->getId(),$o_table->getLevel3Id(),$o_table->getResultId());
				$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'&time='.time().'\';');
			}else{
				$this->setReturn('parent.parent.parent.Dialog_Message("请选择上传文件！");');
			}		
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'?'.time().'\';');
	}
	public function ZbtxSchoolUploadDelete($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31002 )) {
			$o_table=new Zhdd_Zbtx_Doc($this->getPost('id'));
			$o_table->setIsDelete(1);
			$o_table->Save();
			$this->ZbtxProjectLevel2Sort($o_table->getDeptId(),1000,$o_table->getId(),$o_table->getLevel3Id(),$o_table->getResultId());
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function ZbtxSchoolUploadModify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31002 )) {
			$o_table=new Zhdd_Zbtx_Doc($this->getPost('Id'));
			$o_table->setFileName($this->getPost('FileName'));
			$o_table->setExplain($this->getPost('Explain'));
			$o_table->setNumber($this->getPost('Number'));
			$o_table->Save();
			$this->ZbtxSchoolUploadDocSort($o_table->getDeptId(),$o_table->getNumber(),$o_table->getId(),$o_table->getLevel3Id(),$o_table->getResultId());
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'&time='.time().'\';');
	}
	private function ZbtxSchoolUploadDocSort($n_dept_id, $n_number, $n_id, $n_level3_id,$n_result_id) {
		$o_all = new Zhdd_Zbtx_Doc ();
		$o_all->PushWhere ( array ('&&', 'Id', '<>', $n_id ) );
		$o_all->PushWhere ( array ('&&', 'DeptId', '=', $n_dept_id ) );
		$o_all->PushWhere ( array ('&&', 'ResultId', '=', $n_result_id ) );
		$o_all->PushWhere ( array ('&&', 'Level3Id', '=', $n_level3_id ) );
		$o_all->PushWhere ( array ('&&', 'IsDelete', '=', 0 ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Zhdd_Zbtx_Doc ( $o_all->getId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	public function ZbtxManageSchoolListClose($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Result($this->getPost('id'));
			$o_table->setState(1);
			$o_table->Save();
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function ZbtxManageSchoolListOpen($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31001 )) {
			$o_table=new Zhdd_Zbtx_Result($this->getPost('id'));
			$o_new = new Zhdd_Zbtx_Result();
			$o_new->setCreateDate($this->GetDate());
			$o_new->setOwnerId($o_table->getOwnerId());
			$o_new->setDeptId($o_table->getDeptId());
			$o_new->setProjectId($o_table->getProjectId());
			$o_new->setState(0);
			$o_new->setResult('');
			$o_new->Save();
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function AppraiseAdd($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31003 )) {
			$o_table=new Zhdd_Appraise();
			$o_table->setTitle($this->getPost('Title'));
			$o_table->setIsDeleted(0);
			$o_table->setState(0);
			$o_table->setType($this->getPost('Type'));
			$o_table->setCreateDate($this->GetDateNow());
			$o_table->setComment('');
			$a_type=array();
			$o_info=new Zhdd_Appraise_Info_Item();
			$o_info->PushWhere ( array ('&&', 'Type', '=', $this->getPost('Type')) );
			$o_info->PushOrder ( array ('Number', 'A' ) );
			for($i=0;$i<$o_info->getAllCount();$i++)
			{
				array_push ( $a_type, rawurlencode($o_info->getName($i)));
			}
			$o_table->setInfo ( json_encode ( $a_type) );
			$o_table->Save();
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'?'.time().'\';');
	}
	public function AppraiseModify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31003 )) {
			$o_table=new Zhdd_Appraise($this->getPost('Id'));
			$o_table->setTitle($this->getPost('Title'));
			$o_table->setType($this->getPost('Type'));
			$o_table->setCreateDate($this->GetDateNow());
			$a_type=array();
			$o_info=new Zhdd_Appraise_Info_Item();
			$o_info->PushWhere ( array ('&&', 'Type', '=', $this->getPost('Type')) );
			$o_info->PushOrder ( array ('Number', 'A' ) );
			for($i=0;$i<$o_info->getAllCount();$i++)
			{
				array_push ( $a_type, rawurlencode($o_info->getName($i)));
			}
			$o_table->setInfo ( json_encode ( $a_type) );
			$o_table->Save();
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'?'.time().'\';');
	}
	public function AppraiseDelete($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31003 )) {
			$o_table=new Zhdd_Appraise($this->getPost('id'));
			$o_table->setIsDeleted(1);
			$o_table->Save();
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function AppraiseSingleAdd($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31003 )) {
			$o_table=new Zhdd_Appraise_Questions();
			$o_table->setQuestion($this->getPost('Content'));
			$o_table->setAppraiseId($this->getPost('Id'));
			$o_term = new Zhdd_Appraise_Questions ();
			$o_term->PushWhere ( array ('&&', 'AppraiseId', '=', $this->getPost('Id') ) );
			$o_term->PushOrder ( array ('Number', 'A' ) );
			$n_count = $o_term->getAllCount ();
			$o_table->setNumber($n_count+1);
			$o_table->setType(1);
			$o_table->Save();
			$a_option = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I','J' );
			for($i = 0; $i < count ( $a_option ); $i ++) {
				if ($_POST ['Vcl_Option_' . $a_option [$i]] == '') {
					break;
				} else {
					$n_option = new Zhdd_Appraise_Options ();
					$n_option->setNumber ( $a_option [$i] );
					$n_option->setQuestionId ( $o_table->getId () );
					$n_option->setOption ( $_POST ['Vcl_Option_' . $a_option [$i]] );
					$n_option->Save ();
				}
			}
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function AppraiseSingleModify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31003 )) {
			$o_table=new Zhdd_Appraise_Questions($this->getPost('Id'));
			$o_table->setQuestion($this->getPost('Content'));
			$o_table->Save();
			$a_option = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I','J' );
			$n_option = new Zhdd_Appraise_Options ();
			//$n_option->DeleteOption($o_table->getItemId ());
			//$n_option='';
			$n_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_table->getId ()) );
			$n_option->PushOrder ( array ('Number', 'A' ) );
			$n_count=$n_option->getAllCount();
			for($i = 0; $i < count ( $a_option ); $i ++) {
				if ($i<$n_count)
				{
					//如果以前存在那么修改
					if ($_POST ['Vcl_Option_' . $a_option [$i]] == '') {
						//如果为空，那么删除
						$o_temp = new Zhdd_Appraise_Options ($n_option->getId($i));
						$o_temp->Deletion();
					}else{
						//如果不为空，那么修改
						$o_temp = new Zhdd_Appraise_Options ($n_option->getId($i));
						$o_temp->setOption ( $_POST ['Vcl_Option_' . $a_option [$i]] );
						$o_temp->Save ();
					}
				}else{
					//如果以前不存在那么新建
					if ($_POST ['Vcl_Option_' . $a_option [$i]] == '') {
						break;
					} else {
						$o_temp = new Zhdd_Appraise_Options ();
						$o_temp->setNumber ( $a_option [$i] );
						$o_temp->setQuestionId ( $o_table->getId () );
						$o_temp->setOption ( $_POST ['Vcl_Option_' . $a_option [$i]] );
						$o_temp->Save ();
					}
				}
			}
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function AppraiseQuestionSetNumber($n_uid) {
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31003 )) {
			$o_table = new Zhdd_Appraise_Questions($this->getPost('id') );
			$o_table->setNumber ( $this->getPost('number') );
			$o_table->Save ();
			$this->QuestionSort ( $this->getPost('id') , $this->getPost('number') , $o_table->getAppraiseId () ); //排序
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	private function QuestionSort($n_sectionid, $n_number, $n_chapterid) {
		$o_all = new Zhdd_Appraise_Questions ();
		$o_all->PushWhere ( array ('&&', 'Id', '<>', $n_sectionid ) );
		$o_all->PushWhere ( array ('&&', 'AppraiseId', '=', $n_chapterid ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Zhdd_Appraise_Questions ( $o_all->getId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	public function AppraiseQuestionDelete($n_uid) {
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31003 )) {
			$o_table = new Zhdd_Appraise_Questions($this->getPost('id') );	
			$n_appraiseid=$o_table->getAppraiseId ();
			$o_table->Deletion();
			$o_table=null;
			$this->QuestionSort ( 0, 10000 , $n_appraiseid ); //排序		
			$o_all = new Zhdd_Appraise_Options ();
			$o_all->PushWhere ( array ('&&', 'QuestionId', '=', $this->getPost('id')  ) );
			$o_all->DeletionWhere();			
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function AppraiseMultiAdd($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31003 )) {
			$o_table=new Zhdd_Appraise_Questions();
			$o_table->setQuestion($this->getPost('Content'));
			$o_table->setAppraiseId($this->getPost('Id'));
			$o_term = new Zhdd_Appraise_Questions ();
			$o_term->PushWhere ( array ('&&', 'AppraiseId', '=', $this->getPost('Id') ) );
			$o_term->PushOrder ( array ('Number', 'A' ) );
			$n_count = $o_term->getAllCount ();
			$o_table->setNumber($n_count+1);
			$o_table->setType(2);
			$o_table->Save();
			$a_option = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I','J' );
			for($i = 0; $i < count ( $a_option ); $i ++) {
				if ($_POST ['Vcl_Option_' . $a_option [$i]] == '') {
					break;
				} else {
					$n_option = new Zhdd_Appraise_Options ();
					$n_option->setNumber ( $a_option [$i] );
					$n_option->setQuestionId ( $o_table->getId () );
					$n_option->setOption ( $_POST ['Vcl_Option_' . $a_option [$i]] );
					$n_option->Save ();
				}
			}
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function AppraiseAnswerAdd($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31003 )) {
			$o_table=new Zhdd_Appraise_Questions();
			$o_table->setQuestion($this->getPost('Content'));
			$o_table->setAppraiseId($this->getPost('Id'));
			$o_term = new Zhdd_Appraise_Questions ();
			$o_term->PushWhere ( array ('&&', 'AppraiseId', '=', $this->getPost('Id') ) );
			$o_term->PushOrder ( array ('Number', 'A' ) );
			$n_count = $o_term->getAllCount ();
			$o_table->setNumber($n_count+1);
			$o_table->setType(4);
			$o_table->Save();			
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function AppraiseAnswerModify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31003 )) {
			$o_table=new Zhdd_Appraise_Questions($this->getPost('Id'));
			$o_table->setQuestion($this->getPost('Content'));			
			$o_table->Save();			
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function AppraiseRelease($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31003 )) {
			$o_table=new Zhdd_Appraise($this->getPost('id'));
			$o_table->setReleaseDate($this->GetDate());
			$o_table->setState(1);
			$o_table->Save();
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function AppraiseMakeQrcode($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31003 )) {
			//想验证学校名称是否正确。
			$o_school=new Base_Dept();
			$o_school->PushWhere ( array ('&&', 'Name', '=', $_POST ['Vcl_SchoolName']) );
			$o_school->PushWhere ( array ('&&', 'ParentId', '=',1) );
			$n_count = $o_school->getAllCount ();
			if($n_count==0)
			{
				$this->setReturn('parent.parent.parent.Dialog_Message("[ 来源学校 ] 输入有误！<br/>必须从提示中选择！");');
			}
			$o_table=new Zhdd_Appraise($this->getPost('Id'));
			//?id=11&school_id=141&info_0=%E5%88%9D%E4%B8%80%E7%8F%AD&info_1=%E8%AF%AD%E6%96%87&info_2=2014-12-12&info_3=%E4%BD%9C%E6%96%87&info_4=%E6%9D%8E%E5%B0%8F%E7%92%90
			$s_rul='id='.$this->getPost('Id');
			$s_rul.='&school_id='.$o_school->getDeptId(0);
			
			$a_vcl=json_decode($o_table->getInfo());
			for($i=0;$i<count($a_vcl);$i++)
			{
				$s_rul.='&info_'.$i.'='.rawurlencode($this->getPost ( 'Info_'.$i ));
			}
			
		}
		$this->setReturn('parent.window.open(\''.$this->getPost('Url').'appraise_manage_make_qrcode_show.php?'.$s_rul.'\',\'_blank\');
		parent.location=\''.$this->getPost('BackUrl').'\';
		');
	}
	public function AppraiseMakeQrcodeBatch($n_uid)
	{
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
		
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 31003 )) {
			if ($_FILES ['Vcl_File'] ['size'] > 0) {
				mkdir ( RELATIVITY_PATH . 'userdata/zhdd/', 0777 );
				mkdir ( RELATIVITY_PATH . 'userdata/zhdd/appraise/', 0777 );
				mkdir ( RELATIVITY_PATH . 'userdata/zhdd/appraise/input/', 0777 );
				$allowpictype = array ('xlsx');
				$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Vcl_File'] ['name'], '.' ), 1 ) ) );
				if (! in_array ( $fileext, $allowpictype )) {
					$this->setReturn('parent.parent.parent.Dialog_Message("上传文件类型为.xlsx！");');
				}				
				$filePath= RELATIVITY_PATH . 'userdata/zhdd/appraise/input/'.$this->getPost('Id').'.' . $fileext;
				copy ( $_FILES ['Vcl_File'] ['tmp_name'],$filePath);
				/*
				//获取上传的excel文件，验证学校名称是否合法
				require_once RELATIVITY_PATH . 'include/PHPExcel.php';
				$PHPReader = new PHPExcel_Reader_Excel2007 ();
				if (! $PHPReader->canRead ( $filePath )) {
					$PHPReader = new PHPExcel_Reader_Excel2007 ();
					if (! $PHPReader->canRead ( $filePath )) {
						$this->setReturn ( 'parent.parent.parent.Dialog_Error("dialog_error(\'对不起，上传失败，请与管理员联系！[001]\')");' );
						return;
					}
				}
				$PHPExcel = $PHPReader->load ( $filePath );
				$currentSheet = $PHPExcel->getSheet ( 0 );
				$allColumn = $currentSheet->getHighestColumn ();
				$allRow = $currentSheet->getHighestRow ();
				$s_shoolname=$currentSheet->getCell ('B2')->getValue ();
				//想验证学校名称是否正确。
				$o_school=new Base_Dept();
				$o_school->PushWhere ( array ('&&', 'Name', '=',$s_shoolname) );
				$o_school->PushWhere ( array ('&&', 'ParentId', '=',1) );
				$n_count = $o_school->getAllCount ();
				if($n_count==0)
				{
					$this->setReturn('parent.parent.parent.Dialog_Message("学校名称填写错误！");');
				}*/
				$this->setReturn('parent.parent.parent.Common_CloseDialog();
				parent.location=\''.$this->getPost('Url').'appraise_manage_make_qrcode_batch_pdf.php?id='.$this->getPost('Id').'\';				
				//parent.location=\''.$this->getPost('BackUrl').'\';
				');
			}else{
				$this->setReturn('parent.parent.parent.Dialog_Message("请选择上传的模版文件！");');
			}			
		}		
	}
}

?>