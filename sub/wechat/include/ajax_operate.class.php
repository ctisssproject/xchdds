<?php
error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'db_table.class.php';
class Operate extends Bn_Basic {	
	protected function ReturnMsg($s_msg,$id)
	{
		echo ('<script>parent.Common_CloseDialog();parent.Dialog_Message("'.$s_msg.'");parent.document.getElementById("Vcl_'.$id.'").focus();</script>');
		exit ( 0 );
	}
		// 计算身份证校验码，根据国家标准GB 11643-1999 
		// 将15位身份证升级到18位 
		// 18位身份证校验码有效性检查 
	public function AppraiseAnswer($n_uid)
	{
		sleep(1);
		if ($n_uid>0)
		{
			
		}else{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1001]\');' );
		}
		require_once RELATIVITY_PATH . 'sub/zhdd/include/db_table.class.php';
		$o_survey=new Zhdd_Appraise($this->getPost ( 'Id' ));		
		if($o_survey->getState()!='1')
		{
			//非法访问
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1001]\');' );
		}
		$o_stu=new Base_User_Wechat_View();
		$o_stu->PushWhere ( array ('&&', 'WechatId', '=',$n_uid) ); 
		if ($o_stu->getAllCount()==0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1002]\');' );
		}
		//开始检查基础信息是否填写
		$a_vcl=json_decode($o_survey->getInfo());
	    $a_info=array();
		for($i=0;$i<count($a_vcl);$i++)
	    {
	    	if ($this->getPost ( 'Info_'.$i )=='')
	    	{
	    		$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\''.rawurldecode($a_vcl[$i]).'不能为空！\');' );
	    	}
	    	array_push($a_info, rawurlencode($this->getPost ( 'Info_'.$i )));
	    }
		//开始记录核验选项
	    $o_question=new Zhdd_Appraise_Questions();
	    $o_question->PushWhere ( array ('&&', 'AppraiseId', '=',$o_survey->getId()) ); 
	    $o_question->PushOrder ( array ('Number','A') );   
	    $a_question_result=array();
	    for($i=0;$i<$o_question->getAllCount();$i++)
	    {
	    	if ($o_question->getType($i)==1)
	    	{
	    		//单选
	    		if ($this->getPost('Question_'.$o_question->getId($i))=='')
	    		{
	    			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'“第'.$o_question->getNumber($i).'题”未作答！\');' );
	    		}
	    		array_push($a_question_result,$this->getPost('Question_'.$o_question->getId($i)));
	    	}elseif ($o_question->getType($i)==2){
	    		//多选
	    		$a_temp=array();
	    		$o_option=new Zhdd_Appraise_Options();
	    		$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId($i)) ); 
	    		$o_option->PushOrder ( array ('Number','A') ); 
	    		for($j=0;$j<$o_option->getAllCount();$j++)
	    		{
	    			if ($this->getPost('Option_'.$o_option->getId($j))=='on')
	    			{
	    				array_push($a_temp, $o_option->getId($j));
	    			}
	    		}
	    		if (count($a_temp)==0)
	    		{
	    			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'“第'.$o_question->getNumber($i).'题”未作答！\');' );
	    		}
	    		array_push($a_question_result,$a_temp);
	    	}elseif ($o_question->getType($i)==4){
	    		//简述
	    		if ($this->getPost('Question_'.$o_question->getId($i))=='')
	    		{
	    			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'“第'.$o_question->getNumber($i).'题”未作答！\');' );
	    		}
	    		array_push($a_question_result,rawurlencode($this->getPost('Question_'.$o_question->getId($i))));
	    	}else{
	    		array_push($a_question_result,'');
	    	}
	    }
		//开始保存至答案。
		$o_answer=new Zhdd_Appraise_Answers();
		$o_answer->setAppraiseId($o_survey->getId());
		$o_answer->setSchoolId($this->getPost ( 'SchoolId' ));
		$o_answer->setUid($o_stu->getUid(0));
		$o_answer->setInfo(json_encode($a_info));
		$o_answer->setDate($this->GetDateNow());
		//根据循环结果，保存答案
		$n_column=1;
		for($i=0;$i<count($a_question_result);$i++)
		{
			eval('$o_answer->setAnswer'.$n_column.'(json_encode($a_question_result[$i]));');
			$n_column++;
		}
		if ($o_answer->Save()==false)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，服务器忙，请重试！\');' );
		}
		$this->setReturn ( "parent.location.href='".$this->getPost ( 'Url' )."appraise_answer_completed.php?id=".$o_survey->getId()."';" );
	}
	}
?>