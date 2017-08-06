<?php
error_reporting ( 0 );
require_once 'db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
class Operate extends Bn_Basic {
	public function TotalDelete($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 20001 )) {
			$o_total=new SurveyTotalItem($this->getPost('Id'));
			$o_total->Deletion();
			$o_total->DeleteOption($this->getPost('Id'));
			$o_total->DeleteAnswer($this->getPost('Id'));
		}
		$this->setReturn('parent.location.reload()');
	}
	public function SetLimit($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()'); 
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 20001 )) {
			$o_total=new SurveyTotalItem($this->getPost('Id'));
			$o_total->setLimit($this->getPost('Limit'));
			$o_total->Save();
		}
		$this->setReturn('parent.location=\''.$this->getPost('BackUrl').'\';');
	}
}

?>