<?php
error_reporting ( 0 );
require_once 'db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
class Operate extends Bn_Basic {
					
		
	public function AppraiseAdd($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
			
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 33001 )) {
			$o_table=new Dz_Appraise();
			$o_table->setTitle($this->getPost('Title'));
			$o_table->setIsDeleted(0);
			$o_table->setState(0);
			$o_table->setType($this->getPost('Type'));
			$o_table->setCreateDate($this->GetDateNow());
			$o_table->setComment('');
			$o_table->setIsAuto($this->getPost('IsAuto'));
			$a_type=array();
			$o_info=new Dz_Appraise_Info_Item();
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
		if ($o_user->ValidModule ( 33001 )) {
			$o_table=new Dz_Appraise($this->getPost('Id'));
			$o_table->setTitle($this->getPost('Title'));
			$o_table->setType($this->getPost('Type'));
			$o_table->setCreateDate($this->GetDateNow());
			$a_type=array();
			$o_info=new Dz_Appraise_Info_Item();
			$o_info->PushWhere ( array ('&&', 'Type', '=', $this->getPost('Type')) );
			$o_info->PushOrder ( array ('Number', 'A' ) );
			for($i=0;$i<$o_info->getAllCount();$i++)
			{
				array_push ( $a_type, rawurlencode($o_info->getName($i)));
			}
			$o_table->setInfo ( json_encode ( $a_type) );
			$o_table->setIsAuto($this->getPost('IsAuto'));
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
		if ($o_user->ValidModule ( 33001 )) {
			$o_table=new Dz_Appraise($this->getPost('id'));
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
		if ($o_user->ValidModule ( 33001 )) {
			$o_table=new Dz_Appraise_Questions();
			$o_table->setQuestion($this->getPost('Content'));
			$o_table->setIsMust($this->getPost('IsMust'));
			$o_table->setAppraiseId($this->getPost('Id'));
			$o_term = new Dz_Appraise_Questions ();
			$o_term->PushWhere ( array ('&&', 'AppraiseId', '=', $this->getPost('Id') ) );
			$o_term->PushOrder ( array ('Number', 'A' ) );
			$n_count = $o_term->getAllCount ();
			$o_table->setNumber($n_count+1);
			$o_table->setType(1);
			$o_table->Save();
			$a_option = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I','J','K','L','M','N','O','P','Q','R','S','T' );
			for($i = 0; $i < count ( $a_option ); $i ++) {
				if ($_POST ['Vcl_Option_' . $a_option [$i]] == '') {
					break;
				} else {
					$n_option = new Dz_Appraise_Options ();
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
		if ($o_user->ValidModule ( 33001 )) {
			$o_table=new Dz_Appraise_Questions($this->getPost('Id'));
			$o_table->setQuestion($this->getPost('Content'));
			$o_table->setIsMust($this->getPost('IsMust'));
			$o_table->Save();
			$a_option = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I','J','K','L','M','N','O','P','Q','R','S','T' );
			$n_option = new Dz_Appraise_Options ();
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
						$o_temp = new Dz_Appraise_Options ($n_option->getId($i));
						$o_temp->Deletion();
					}else{
						//如果不为空，那么修改
						$o_temp = new Dz_Appraise_Options ($n_option->getId($i));
						$o_temp->setOption ( $_POST ['Vcl_Option_' . $a_option [$i]] );
						$o_temp->Save ();
					}
				}else{
					//如果以前不存在那么新建
					if ($_POST ['Vcl_Option_' . $a_option [$i]] == '') {
						break;
					} else {
						$o_temp = new Dz_Appraise_Options ();
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
		if ($o_user->ValidModule ( 33001 )) {
			$o_table = new Dz_Appraise_Questions($this->getPost('id') );
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
		$o_all = new Dz_Appraise_Questions ();
		$o_all->PushWhere ( array ('&&', 'Id', '<>', $n_sectionid ) );
		$o_all->PushWhere ( array ('&&', 'AppraiseId', '=', $n_chapterid ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Dz_Appraise_Questions ( $o_all->getId ( $i ) );
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
		if ($o_user->ValidModule ( 33001 )) {
			$o_table = new Dz_Appraise_Questions($this->getPost('id') );	
			$n_appraiseid=$o_table->getAppraiseId ();
			$o_table->Deletion();
			$o_table=null;
			$this->QuestionSort ( 0, 10000 , $n_appraiseid ); //排序		
			$o_all = new Dz_Appraise_Options ();
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
		if ($o_user->ValidModule ( 33001 )) {
			$o_table=new Dz_Appraise_Questions();
			$o_table->setQuestion($this->getPost('Content'));
			$o_table->setIsMust($this->getPost('IsMust'));
			$o_table->setAppraiseId($this->getPost('Id'));
			$o_term = new Dz_Appraise_Questions ();
			$o_term->PushWhere ( array ('&&', 'AppraiseId', '=', $this->getPost('Id') ) );
			$o_term->PushOrder ( array ('Number', 'A' ) );
			$n_count = $o_term->getAllCount ();
			$o_table->setNumber($n_count+1);
			$o_table->setType(2);
			$o_table->Save();
			$a_option = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I','J','K','L','M','N','O','P','Q','R','S','T' );
			for($i = 0; $i < count ( $a_option ); $i ++) {
				if ($_POST ['Vcl_Option_' . $a_option [$i]] == '') {
					break;
				} else {
					$n_option = new Dz_Appraise_Options ();
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
		if ($o_user->ValidModule ( 33001 )) {
			$o_table=new Dz_Appraise_Questions();
			$o_table->setQuestion($this->getPost('Content'));
			$o_table->setAppraiseId($this->getPost('Id'));
			$o_table->setIsMust($this->getPost('IsMust'));
			$o_term = new Dz_Appraise_Questions ();
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
		if ($o_user->ValidModule ( 33001 )) {
			$o_table=new Dz_Appraise_Questions($this->getPost('Id'));
			$o_table->setQuestion($this->getPost('Content'));	
			$o_table->setIsMust($this->getPost('IsMust'));
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
		if ($o_user->ValidModule ( 33001 )) {
			$o_table=new Dz_Appraise($this->getPost('id'));
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
		if ($o_user->ValidModule ( 33001 )) {
			//想验证学校名称是否正确。
			$o_school=new Base_Dept();
			$o_school->PushWhere ( array ('&&', 'Name', '=', $_POST ['Vcl_SchoolName']) );
			$o_school->PushWhere ( array ('&&', 'ParentId', '=',1) );
			$n_count = $o_school->getAllCount ();
			if($n_count==0)
			{
				$this->setReturn('parent.parent.parent.Dialog_Message("[ 来源学校 ] 输入有误！<br/>必须从提示中选择！");');
			}
			$o_table=new Dz_Appraise($this->getPost('Id'));
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
		if ($o_user->ValidModule ( 33001 )) {
			if ($_FILES ['Vcl_File'] ['size'] > 0) {
				mkdir ( RELATIVITY_PATH . 'userdata/duzheng/', 0777 );
				mkdir ( RELATIVITY_PATH . 'userdata/duzheng/appraise/', 0777 );
				mkdir ( RELATIVITY_PATH . 'userdata/duzheng/appraise/input/', 0777 );
				$allowpictype = array ('xlsx');
				$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Vcl_File'] ['name'], '.' ), 1 ) ) );
				if (! in_array ( $fileext, $allowpictype )) {
					$this->setReturn('parent.parent.parent.Dialog_Message("上传文件类型为.xlsx！");');
				}				
				$filePath= RELATIVITY_PATH . 'userdata/duzheng/appraise/input/'.$this->getPost('Id').'.' . $fileext;
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