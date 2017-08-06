<?php
error_reporting ( 0 );
require_once 'db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
class Operate extends Bn_Basic {
	public function ChapterAdd($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10000 )) {
			$a_type=array();
			$o_table=new SurveySubject();
			$o_table->setTitle($this->getPost('Title'));
			$o_table->setScope($this->getPost('Scope'));
			for($i = 1; $i < 20; $i ++) {
				if ($this->getPost('Type'.$i)=='on') {
					array_push ( $a_type, $i);
				}
			}
			if (count ( $a_type ) > 0) {
				$o_table->setType ( json_encode ( $a_type ) );
			}
			$o_table->Save();
		}
		$this->setReturn('parent.parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function ChapterModify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10000 )) {
			$a_type=array();
			$o_table=new SurveySubject($this->getPost('Id'));
			$o_table->setScope($this->getPost('Scope'));
			$o_table->setTitle($this->getPost('Title'));
			for($i = 1; $i < 20; $i ++) {
				if ($this->getPost('Type'.$i)=='on') {
					array_push ( $a_type, $i);
				}
			}
			if (count ( $a_type ) > 0) {
				$o_table->setType ( json_encode ( $a_type ) );
			}
			$o_table->Save();
		}
		$this->setReturn('parent.parent.location=\''.$this->getPost('BackUrl').'\';');
	}	
	public function ChapterDelete($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10000 )) {
			$o_table=new SurveySubject($this->getPost('Id'));
			$o_table->setDelete(1);
			$o_table->Save();
		}
		$this->setReturn('parent.location.reload()');
	}
	public function DeptDelete($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10000 )) {
			$o_table=new SurveyDept($this->getPost('Id'));
			$o_table->setDelete(1);
			$o_table->Save();
		}
		$this->setReturn('parent.location.reload()');
	}
	public function ItemSingleAdd($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10000 )) {
			$o_table=new SurveyItem();
			$o_table->setContent($this->getPost('Content'));
			$o_table->setSubjectId($this->getPost('Id'));
			$o_table->setType($this->getPost('Type'));
			$o_term = new SurveyItem ();
			$o_term->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_term->PushWhere ( array ('&&', 'SubjectId', '=', $this->getPost('Id') ) );
			$o_term->PushOrder ( array ('Number', 'A' ) );
			$n_count = $o_term->getAllCount ();
			$o_table->setNumber($n_count+1);
			$o_table->setTypeId(1);
			$o_table->Save();
			$a_option = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I','J' );
			for($i = 0; $i < count ( $a_option ); $i ++) {
				if ($_POST ['Vcl_Option_' . $a_option [$i]] == '') {
					break;
				} else {
					$n_option = new SurveyOption ();
					$n_option->setNumber ( $a_option [$i] );
					$n_option->setItemId ( $o_table->getItemId () );
					$n_option->setContent ( $_POST ['Vcl_Option_' . $a_option [$i]] );
					$n_option->Save ();
				}
			}
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function ItemSingleModify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10000 )) {
			$o_table=new SurveyItem($this->getPost('Id'));
			$o_table->setContent($this->getPost('Content'));
			$o_table->setType($this->getPost('Type'));
			$o_table->Save();
			$a_option = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I','J' );
			$n_option = new SurveyOption ();
			//$n_option->DeleteOption($o_table->getItemId ());
			//$n_option='';
			$n_option->PushWhere ( array ('&&', 'ItemId', '=',$o_table->getItemId ()) );
			$n_option->PushOrder ( array ('Number', 'A' ) );
			$n_count=$n_option->getAllCount();
			for($i = 0; $i < count ( $a_option ); $i ++) {
				if ($i<$n_count)
				{
					//如果以前存在那么修改
					if ($_POST ['Vcl_Option_' . $a_option [$i]] == '') {
						//如果为空，那么删除
						$o_temp = new SurveyOption ($n_option->getOptionId($i));
						$o_temp->Deletion();
					}else{
						//如果不为空，那么修改
						$o_temp = new SurveyOption ($n_option->getOptionId($i));
						$o_temp->setContent ( $_POST ['Vcl_Option_' . $a_option [$i]] );
						$o_temp->Save ();
					}
				}else{
					//如果以前不存在那么新建
					if ($_POST ['Vcl_Option_' . $a_option [$i]] == '') {
						break;
					} else {
						$o_temp = new SurveyOption ();
						$o_temp->setNumber ( $a_option [$i] );
						$o_temp->setItemId ( $o_table->getItemId () );
						$o_temp->setContent ( $_POST ['Vcl_Option_' . $a_option [$i]] );
						$o_temp->Save ();
					}
				}
			}
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function ItemSetNumber($n_uid) {
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10000 )) {
			$o_table = new SurveyItem($this->getPost('Id') );
			$o_table->setNumber ( $this->getPost('Number') );
			$o_table->Save ();
			$this->ItemSort ( $this->getPost('Id') , $this->getPost('Number') , $o_table->getSubjectId () ); //排序
		}
		$this->setReturn('parent.location.reload()');
	}
	private function ItemSort($n_sectionid, $n_number, $n_chapterid) {
		$o_all = new SurveyItem ();
		$o_all->PushWhere ( array ('&&', 'ItemId', '<>', $n_sectionid ) );
		$o_all->PushWhere ( array ('&&', 'SubjectId', '=', $n_chapterid ) );
		$o_all->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new SurveyItem ( $o_all->getItemId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	public function ItemDelete($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10000 )) {
			$o_table=new SurveyItem($this->getPost('Id'));
			$o_table->setDelete(1);
			$o_table->Save();
		}
		$this->ItemSort ( 0,10000, $o_table->getSubjectId () ); //排序
		$this->setReturn('parent.location.reload()');
	}
	public function ItemMultiAdd($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10000 )) {
			$o_table=new SurveyItem();
			$o_table->setContent($this->getPost('Content'));
			$o_table->setSubjectId($this->getPost('Id'));
			$o_table->setType($this->getPost('Type'));
			$o_term = new SurveyItem ();
			$o_term->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_term->PushWhere ( array ('&&', 'SubjectId', '=', $this->getPost('Id') ) );
			$o_term->PushOrder ( array ('Number', 'A' ) );
			$n_count = $o_term->getAllCount ();
			$o_table->setNumber($n_count+1);
			$o_table->setTypeId(2);
			$o_table->Save();
			$a_option = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I','J' );
			for($i = 0; $i < count ( $a_option ); $i ++) {
				if ($_POST ['Vcl_Option_' . $a_option [$i]] == '') {
					break;
				} else {
					$n_option = new SurveyOption ();
					$n_option->setNumber ( $a_option [$i] );
					$n_option->setItemId ( $o_table->getItemId () );
					$n_option->setContent ( $_POST ['Vcl_Option_' . $a_option [$i]] );
					$n_option->Save ();
				}
			}
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function ItemScoreAdd($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10000 )) {
			$o_table=new SurveyItem();
			$o_table->setContent($this->getPost('Content'));
			$o_table->setSubjectId($this->getPost('Id'));
			$o_table->setType($this->getPost('Type'));
			$o_term = new SurveyItem ();
			$o_term->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_term->PushWhere ( array ('&&', 'SubjectId', '=', $this->getPost('Id') ) );
			$o_term->PushOrder ( array ('Number', 'A' ) );
			$n_count = $o_term->getAllCount ();
			$o_table->setNumber($n_count+1);
			$o_table->setScore($this->getPost('Score'));
			$o_table->setTypeId(3);
			$o_table->Save();
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function ItemAnswerAdd($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10000 )) {
			$o_table=new SurveyItem();
			$o_table->setContent($this->getPost('Content'));
			$o_table->setSubjectId($this->getPost('Id'));
			$o_table->setType($this->getPost('Type'));
			$o_term = new SurveyItem ();
			$o_term->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_term->PushWhere ( array ('&&', 'SubjectId', '=', $this->getPost('Id') ) );
			$o_term->PushOrder ( array ('Number', 'A' ) );
			$n_count = $o_term->getAllCount ();
			$o_table->setNumber($n_count+1);
			$o_table->setTypeId(4);
			$o_table->Save();
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function ItemAnswerModify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10000 )) {
			$o_table=new SurveyItem($this->getPost('Id'));
			$o_table->setContent($this->getPost('Content'));
			$o_table->setType($this->getPost('Type'));
			$o_table->Save();
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function ItemScoreModify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10000 )) {
			$o_table=new SurveyItem($this->getPost('Id'));
			$o_table->setContent($this->getPost('Content'));
			$o_table->setScore($this->getPost('Score'));
			$o_table->setType($this->getPost('Type'));
			$o_table->Save();
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function SurveySubmit($n_uid)
	{
		if ($this->getPost('Bu')==1)
		{
			$n_deptid=$this->getPost('DeptId');
			$n_type=$this->getPost('Type');
		}else{
			$n_deptid=$_COOKIE ['DEPT'];
			$n_type=json_decode($_COOKIE ['TYPE']);
		}
		if ($n_deptid==6 || $n_deptid==10 || $n_deptid==16)
		{
			//如果是学生家长，需要验证序列号
			$o_code=new SurveyCode();
			$o_code->PushWhere ( array ('&&', 'Code', '=',$this->getPost('Code')) );
			$o_code->PushWhere ( array ('&&', 'State', '=',1) );
			if ($o_code->getAllCount()==0)
			{
				$this->setReturn('parent.window.alert(\'对不起，您的序列号已经失效！如有问题请联系学校工作人员。\');parent.document.getElementById("NextButton").disabled=false;');
			}
			//$o_code=new SurveyCode($o_code->getId(0));
			//$o_code->setState(0);
			//$o_code->Save();
		}			
		if (rawurldecode($this->getPost('Already'))=='')
		{
			$a_already=array(); 
		}else{
			$s_temp=rawurldecode($this->getPost('Already'));
			$s_temp=str_replace('\\', '', $s_temp);
			$a_already=json_decode($s_temp);
		}
		
		$o_setup=new SurveySetup(1);
		$n_subjectid=$this->getPost('Id');
		$o_subject=new SurveySubject($n_subjectid);
		//插入或获取统计合集
		$o_total_item = new SurveyTotalItem();
		$o_total_item->PushWhere ( array ('&&', 'Start', '=', $o_setup->getStart() ) );
		$o_total_item->PushWhere ( array ('&&', 'SubjectId', '=', $n_subjectid) );
		$o_total_item->PushWhere ( array ('&&', 'Delete', '=', 0) );
		$o_total_item->PushWhere ( array ('&&', 'Type', '=', $n_type) );
		$o_total_item->PushWhere ( array ('&&', 'DeptId', '=', $n_deptid) );
		$n_count = $o_total_item->getAllCount ();
		$n_total_id=0;
		$n_sum=1;
		$n_limit=0;
		if ($n_count==0)
		{
			$o_total_item = new SurveyTotalItem();
			$o_total_item->setStart($o_setup->getStart() );
			$o_total_item->setEnd($o_setup->getEnd() );
			$o_total_item->setDeptId($n_deptid);
			$o_total_item->setSubjectId($n_subjectid);
			$o_total_item->setType($n_type);
			//$o_total_item->setDate($this->GetDate());
			$o_total_item->Save();
			$n_total_id=$o_total_item->getId();
		}else{
			$n_total_id=$o_total_item->getId(0);
			$n_sum=$o_total_item->getSum(0)+1; 
			$n_limit=$o_total_item->getLimit(0);
		}	
		if ($n_limit>0)
		{
			if ($n_sum>$n_limit)
			{
				//超过上限，直接完成
				array_push($a_already, $n_subjectid);
				$o_type=new SurveyType($n_type);
				if ($this->getPost('Bu')==1)
				{
					$this->setReturn('parent.window.alert(\'恭喜您，已经完成所有问卷或测评 ！\');parent.window.close();');
				}else{
					$this->setReturn('parent.window.alert(\'恭喜您，已经成功提交，点击确定后返回。\');parent.location=\''.$this->getPost('Url').'setcookie.php?url='.rawurlencode ( $this->getPost('Url').'index_type.php?id='.$o_type->getNumber().'&deptid='.$n_deptid.'&already='.rawurlencode (json_encode ( $a_already ))) .'\';');
				}
			}
		}
		//开始答题
		//先判断是否完整答题
		$o_item=new SurveyItem();
		$o_item->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_item->PushWhere ( array ('&&', 'SubjectId', '=',$n_subjectid) );
		$o_item->PushOrder ( array ('Number', 'A' ) );
		$n_count=$o_item->getAllCount();
		for($i = 0; $i < $n_count; $i ++) {
			if ($o_item->getTypeId ( $i )=='1')
			{
				if ($_POST['Vcl_Item_'.$o_item->getItemId($i)]=='')	
				{
					$this->setReturn('parent.window.alert(\'您还没有完成第 '.$o_item->getNumber($i).' 题 ！\n\n请完成后再提交！\');parent.document.getElementById("NextButton").disabled=false;');
				}	
			}else if ($o_item->getTypeId ( $i )=='2'){
				$n_null=false;
				$o_option = new SurveyOption ();
				$o_option->PushWhere ( array ('&&', 'ItemId', '=', $o_item->getItemId ( $i ) ) );
				$o_option->PushOrder ( array ('Number', 'A' ) );
				$n_count_temp = $o_option->getAllCount ();
				for($j = 0; $j < $n_count_temp; $j ++) {
					if ($_POST['Vcl_Option_'.$o_option->getOptionId($j)]=='on')
					{
						$n_null=true;						
					}
				}
				if ($n_null==false)
				{
					$this->setReturn('parent.window.alert(\'您还没有完成第 '.$o_item->getNumber($i).' 题 ！\n\n请完成后再提交！\');parent.document.getElementById("NextButton").disabled=false;');
				}			
			}else if ($o_item->getTypeId ( $i )=='3'){
				$s_value=$_POST['Vcl_Item_'.$o_item->getItemId($i)];
				if ($s_value=='')	
				{
					$this->setReturn('parent.window.alert(\'请您对第 '.$o_item->getNumber($i).' 题进行评分！\n\n请完成后再提交！\');parent.document.getElementById("NextButton").disabled=false;');
				}
				if($s_value<0)
				{
					$this->setReturn('parent.window.alert(\'对不起，第 '.$o_item->getNumber($i).' 题评分不能为负数！\n\n请修改后提交！\');parent.document.getElementById("NextButton").disabled=false;');
				}
				if($s_value>$o_item->getScore ( $i ))
				{
					$this->setReturn('parent.window.alert(\'对不起，第 '.$o_item->getNumber($i).' 题评分不能超过 '.$o_item->getScore ( $i ).' 分！\n\n请修改后提交！\');parent.document.getElementById("NextButton").disabled=false;');
				}
				
			}else if ($o_item->getTypeId ( $i )=='4'){
				$s_value=$_POST['Vcl_Answer_'.$o_item->getItemId($i)];
				if ($s_value=='')	
				{
					$this->setReturn('parent.window.alert(\'请您对第 '.$o_item->getNumber($i).' 题进行填写！\n\n请完成后再提交！\');parent.document.getElementById("NextButton").disabled=false;');
				}				
			}
		}
		//开始保存答案
		for($i = 0; $i < $n_count; $i ++) {
			if ($o_item->getTypeId ( $i ) == '1') {
				$o_option = new SurveyTotalOption($n_total_id.$_POST['Vcl_Item_'.$o_item->getItemId($i)]);
				if ($o_option->getTotalId()>0)
				{
					$o_option->setSum($o_option->getSum()+1);
				}else{
					$o_option = new SurveyTotalOption();
					$o_option->setId($n_total_id.$_POST['Vcl_Item_'.$o_item->getItemId($i)]);
					$o_option->setSum(1);
				}			
				$o_option->setOptionId($_POST['Vcl_Item_'.$o_item->getItemId($i)]);
				$o_option->setTotalId($n_total_id);
				$o_option->Save();
			} else if ($o_item->getTypeId ( $i ) == '2'){
				$o_temp=new SurveyOption();
				$o_temp->PushWhere ( array ('&&', 'ItemId', '=', $o_item->getItemId($i) ) );
				$n_count_option=$o_temp->getAllCount();
				for($j=0;$j<$n_count_option;$j++)
				{
					if ($_POST['Vcl_Option_'.$o_temp->getOptionId($j)]=='on')
					{
						$o_option = new SurveyTotalOption($n_total_id.$o_temp->getOptionId($j));
						if ($o_option->getTotalId()>0)
						{
							$o_option->setSum($o_option->getSum()+1);
						}else{
							$o_option = new SurveyTotalOption();
							$o_option->setId($n_total_id.$o_temp->getOptionId($j));
							$o_option->setSum(1);
						}			
						$o_option->setOptionId($o_temp->getOptionId($j));
						$o_option->setTotalId($n_total_id);
						$o_option->Save();
					}
				}
			} else if ($o_item->getTypeId ( $i ) == '3') {
				$o_option = new SurveyTotalOption ( $n_total_id . $o_item->getItemId ( $i ) . '1234' );
				if ($o_option->getTotalId()>0) {
					$o_option->setSum ( $o_option->getSum () + $_POST['Vcl_Item_'.$o_item->getItemId($i)] );
				} else {
					$o_option = new SurveyTotalOption ();
					$o_option->setId ( $n_total_id . $o_item->getItemId ( $i ) . '1234' );
					$o_option->setSum ( $_POST['Vcl_Item_'.$o_item->getItemId($i)] );
				}
				$o_option->setItemId ( $o_item->getItemId ( $i ));
				$o_option->setTotalId ( $n_total_id );
				$o_option->Save ();
			}else if ($o_item->getTypeId ( $i ) == '4') {
				$o_option = new SurveyTotalAnswer ();
				$o_option->setAnswer ( $_POST['Vcl_Answer_'.$o_item->getItemId($i)] );
				$o_option->setItemId ( $o_item->getItemId ( $i ));
				$o_option->setTotalId ( $n_total_id );
				$o_option->Save ();
			}
		
		}
		//保存已答题
		array_push($a_already, $n_subjectid);
		//总计数
		$o_total_item = new SurveyTotalItem($n_total_id);
		$o_total_item->setSum($o_total_item->getSum()+1);
		$o_total_item->Save();
		
		$o_type=new SurveyType($n_type);
		if ($this->getPost('Bu')==1)
		{
			$this->setReturn('parent.window.alert(\'恭喜您，已经完成所有问卷或测评 ！\');parent.window.close();');
		}else{
			$this->setReturn('parent.window.alert(\'恭喜您，已经成功提交，点击确定后返回。\');parent.location=\''.$this->getPost('Url').'setcookie.php?url='.rawurlencode ( $this->getPost('Url').'index_type.php?id='.$o_type->getNumber().'&deptid='.$n_deptid.'&already='.rawurlencode (json_encode ( $a_already ))) .'\';');
		}
		
	}
	public function DateModify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10003 )) {
			$a_type=array();
			$o_table=new SurveySetup(1);
			$o_table->setStart($this->getPost('Start'));
			$o_table->setEnd($this->getPost('End'));
			$o_table->setDept($this->getPost('Dept'));
			//验证学校编号是否合法
			$a_dept=explode(',', $this->getPost('Dept'));
			for($i=0;$i<count($a_dept);$i++)
			{
				$o_temp=new SurveyDept($a_dept[$i]);
				if ($o_temp->getName()=='')
				{
					$this->setReturn('parent.parent.parent.Dialog_Message("对不起，学校编号有误！")');
				}
			}
			$o_table->Save();
		}
		$this->setReturn('parent.parent.parent.Dialog_Confirm("保存信息成功！")');
	}
	public function TypeModify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10005 )) {
			$a_type=array();
			$o_table=new SurveyType($this->getPost('Id'));
			$o_table->setNumber($this->getPost('Number'));
			$o_table->setType($this->getPost('Scope'));
			$o_table->setName($this->getPost('Name'));
			$o_table->Save();
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function TypeAdd($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10005 )) {
			$a_type=array();
			$o_table=new SurveyType();
			$o_table->setNumber($this->getPost('Number'));
			$o_table->setName($this->getPost('Name'));
			$o_table->setType($this->getPost('Scope'));
			$o_table->Save();
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function DeptAdd($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10004 )) {
			$o_table=new SurveyDept();
			$o_table->setName($this->getPost('Name'));
			$o_table->setType($this->getPost('Type'));
			$o_table->setUid($this->getPost('Uid'));
			$o_table->Save();
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
	public function DeptModify($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 10004 )) {
			$o_table=new SurveyDept($this->getPost('Id'));
			$o_table->setType($this->getPost('Type'));
			$o_table->setUid($this->getPost('Uid'));
			$o_table->Save();
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
}

?>