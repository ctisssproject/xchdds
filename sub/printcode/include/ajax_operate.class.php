<?php
error_reporting ( 0 );
require_once 'db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
class Operate extends Bn_Basic {
	public function DeleteAllCode($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 40002 )) {
			$o_table=new SurveyCode();
			$o_table->DeleteAll();
		}
		$this->setReturn('parent.location.reload();');
	}
	public function DeleteComplete($n_uid)
	{
		if (! ($n_uid > 0)) {
				//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}	
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 40002 )) {
			$o_table=new SurveyCode();
			$o_table->DeleteComplete();
		}
		$this->setReturn('parent.location.reload();');
	}
}
?>