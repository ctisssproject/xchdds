<?php
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
class Operate extends Bn_Basic {
	protected $Result;
	protected $B_Bool=true;
	public function __construct() {
		$this->Result = TRUE;
	}
	public function getResult() {
		return $this->Result;
	}
	public function InfoModify($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 92 )) {
			$o_user_info = new Base_User_Info ( $n_uid );
			$o_user_info->setSex($_POST ['Vcl_Sex']);
			$o_user_info->setName($_POST ['Vcl_Name']);
			$o_user_info->Save();
			//用户可修改的信息
			$o_user_info_custom = new Base_User_Info_Custom ( $n_uid );
			$o_user_info_custom->setBirthday ( $_POST ['Vcl_Birthday'] );
			$o_user_info_custom->setEmail ( $_POST ['Vcl_OtherEmail'] );
			$o_user_info_custom->setPhone ( $_POST ['Vcl_Phone'] );
			$o_user_info_custom->setMobilePhone ( $_POST ['Vcl_MobilePhone'] );
			$o_user_info_custom->setQQ ( $_POST ['Vcl_QQ'] );
			$o_user_info_custom->Save ();
		}
	}
	public function ExternalInfoModify($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 92 )) {
			//用户可修改的信息
			$o_user_info = new Base_User_Info ( $n_uid );
			$o_user_info->setSex($this->IsNull($_POST ['Vcl_Sex']));
			$o_user_info->Save();
			$o_user_info_custom = new Base_User_Info_Custom ( $n_uid );
			$o_user_info_custom->setBirthday ( $this->IsNull($_POST ['Vcl_Birthday']) );
			$o_user_info_custom->setNation ( $this->IsNull($_POST ['Vcl_Nation']) );
			$o_user_info_custom->setCardId ( $this->IsNull($_POST ['Vcl_CardId']) );
			$o_user_info_custom->setTitles ( $_POST ['Vcl_Titles']);
			$o_user_info_custom->setEducation ( $this->IsNull($_POST ['Vcl_Education']) );
			$o_user_info_custom->setJob ( $this->IsNull($_POST ['Vcl_Job']) );
			$o_user_info_custom->setSubject ( $_POST ['Vcl_Subject']);
			$o_user_info_custom->setNetId ( $_POST ['Vcl_NetId']);
			$o_user_info_custom->setTeachId ( $_POST ['Vcl_TeachId']);
			$o_user_info_custom->setUnitPhone ( $_POST ['Vcl_UnitPhone']);			
			$o_user_info_custom->setQQ ( $_POST ['Vcl_QQ'] );
			if ($this->B_Bool)
			{
				$o_user_info_custom->setFinish (1);
			}else{
				$o_user_info_custom->setFinish (0);
			}
			$o_user_info_custom->Save ();
			$this->AddUserLog($n_uid, '修改个人资料。');
		}
	}
	private function IsNull($s_str)
	{
		if ($s_str=='')
		{
			$this->B_Bool=false;
		}
		return $s_str;
	}
	public function PasswordModify($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 91 )) {
			//用户可修改的信息
			$o_user = new Base_User ( $n_uid );
			if (md5 ( 'welcome ' . $_POST ['Vcl_Password_Old'] . ' to 教育城域网综合管理信息系统 !' ) == $o_user->getPassword ()) { //密码输入正确
				$o_user->setPassword ( md5 ( 'welcome ' . $_POST ['Vcl_Password'] . ' to 教育城域网综合管理信息系统 !' ) );
				$o_user->Save();
				//$this->AddUserLog($n_uid, '修改登录密码。');
				return 1;
			} else {
				return 2;
			}
		}
	}
}

?>