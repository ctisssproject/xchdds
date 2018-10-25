<?php
error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH. 'sub/wechat/include/db_table.class.php';
require_once RELATIVITY_PATH. 'sub/zhdd/include/db_table.class.php';
class Operate extends Bn_Basic {	
	protected function ReturnMsg($s_msg,$id)
	{
		echo ('<script>parent.Common_CloseDialog();parent.Dialog_Message("'.$s_msg.'");parent.document.getElementById("Vcl_'.$id.'").focus();</script>');
		exit ( 0 );
	}
		// 计算身份证校验码，根据国家标准GB 11643-1999 
		// 将15位身份证升级到18位 
		// 18位身份证校验码有效性检查 
	public function LoadCourse($n_uid)
	{
		sleep(1);
		$a_result=array();
		if ($n_uid>0)
		{
			$o_input=new Zhdd_Appraise_Input();
			$o_input->PushWhere ( array ('&&', 'Key1', '=',$this->GetDate()) );
			if ($this->getPost('subject')!='')
			{
				$o_input->PushWhere ( array ('&&', 'Key3', '=',$this->getPost('subject')) );
			}
			$o_input->PushWhere ( array ('&&', 'Type', '=',$this->getPost('type')) );
			$o_input->PushWhere ( array ('&&', 'SchoolName', '=',$this->getPost('schoolname')) );
			for ($i=0;$i<$o_input->getAllCount();$i++)
			{
				$s_rul='id='.$o_input->getSurveyId($i);
				$s_rul.='&school_id='.$o_input->getSchoolId($i);
				$o_survey=new Zhdd_Appraise($o_input->getSurveyId($i));
				$a_vcl=json_decode($o_survey->getInfo());
				$a_item=array();
				$a_value=array();
				for($j=0;$j<count($a_vcl);$j++)
				{
					eval('$s_rul.=\'&info_\'.$j.\'=\'.rawurlencode($o_input->getKey'.($j+1).'($i));');					
					array_push($a_item, rawurldecode($a_vcl[$j]));
					eval('array_push($a_value,$o_input->getKey'.($j+1).'($i));');
				}
				$s_url='appraise_answer.php?'.$s_rul;
				$a_data=array('item'=>$a_item,'value'=>$a_value,'url'=>$s_url);
				array_push($a_result, $a_data);
			}
			echo(json_encode ($a_result));
		}else{
			echo(json_encode ($a_result));
		}
	}
}
?>