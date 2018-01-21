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
				$o_table->setIsDelete(0);
				$o_table->setCreateDate($this->GetDateNow());
				$o_table->setFileName($this->getPost('FileName'));
				$o_table->setExplain($this->getPost('Explain'));
				$o_table->setFileType($fileext);
				$o_table->Save();
				$s_filename=$o_table->getId().'.'.$fileext;
				$o_table->setPath ( 'userdata/zhdd/zbtx/' . $s_filename );
				$o_table->Save();
				copy ( $_FILES ['Vcl_File'] ['tmp_name'], RELATIVITY_PATH . 'userdata/zhdd/zbtx/' . $s_filename );
				$this->ZbtxSchoolUploadDocSort($o_table->getDeptId(),$o_table->getNumber(),$o_table->getId(),$o_table->getLevel3Id());
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
			$this->ZbtxProjectLevel2Sort($o_table->getDeptId(),1000,$o_table->getId(),$o_table->getLevel3Id());
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
			$this->ZbtxSchoolUploadDocSort($o_table->getDeptId(),$o_table->getNumber(),$o_table->getId(),$o_table->getLevel3Id());
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'&time='.time().'\';');
	}
	private function ZbtxSchoolUploadDocSort($n_dept_id, $n_number, $n_id, $n_level3_id) {
		$o_all = new Zhdd_Zbtx_Doc ();
		$o_all->PushWhere ( array ('&&', 'Id', '<>', $n_id ) );
		$o_all->PushWhere ( array ('&&', 'DeptId', '=', $n_dept_id ) );
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
}

?>