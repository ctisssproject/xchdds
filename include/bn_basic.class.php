<?php
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/it_systext.class.php';
class Bn_Basic {
	protected $B_Operate = false;
	protected $S_ErrorReasion; //出错提示
	protected $B_Success = true;
	protected $S_Content = '';
	protected $S_Title = '';
	protected $N_Uid;
	protected $S_UserName;
	protected $N_RoleId;
	protected $S_UserPhoto;
	protected function getPost($s_key) {
		if ($_GET[$s_key]=='')
		{
			$s_str=$this->FilterUserInput($_POST ['Vcl_' . $s_key]);
			if ($s_key=='Name' ||$s_key=='Company' ||$s_key=='DeptJob' ||$s_key=='Phone' ||$s_key=='Email')
			{
				$s_str=str_replace('"', '', $s_str);
				$s_str=str_replace(',', '', $s_str);
				$s_str=str_replace(' ', '', $s_str);
				//$s_str=$this->FilterEmoji($s_str);
			}
			return $s_str;
		}
		$s_str=$this->FilterUserInput($_GET[$s_key]);
		if ($s_key=='Name' ||$s_key=='Company' ||$s_key=='DeptJob' ||$s_key=='Phone' ||$s_key=='Email')
		{
			$s_str=str_replace('"', '', $s_str);
			$s_str=str_replace(',', '', $s_str);
			$s_str=str_replace(' ', '', $s_str);
			//$s_str=$this->FilterEmoji($s_str);
		}
		return $s_str;
	}	
	public function FilterUserInput($string) {
		//过滤< > />
		$string=str_replace('<', '', $string);
		$string=str_replace('>', '', $string);
		$string=str_replace('/>', '', $string);
		return $string;
	}
	protected function setEncode($s_value)
	{
		return rawurlencode($s_value);
	}
	protected function setReturn($s_script) {
		echo ('<script>' . $s_script . ';parent.clearParameter();</script>');
		exit ( 0 );
	}
	public function getErrorReasion() {
		return $this->S_ErrorReasion;
	}
	protected function RemoveArrayRepeatValue($a_arr) {
		$tempArray = array ();
		foreach ( $a_arr as $one ) {
			$tempArray [$one] = true;
		
		}
		$arr = array_keys ( $tempArray );
		return $arr;
	}
	public function getSuccess() {
		return $this->B_Success;
	}
	protected function fileext($filename) {
		return strtolower ( trim ( substr ( strrchr ( $filename, '.' ), 1 ) ) );
	}
	public function getIPLoc_sina($queryIP) {
		$url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=' . $queryIP;
		$ch = curl_init ( $url );
		curl_setopt ( $ch, CURLOPT_ENCODING, 'utf8' );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true ); // 获取数据返回 
		$location = curl_exec ( $ch );
		$location = json_decode ( $location );
		curl_close ( $ch );
		$loc = "";
		if ($location === FALSE)
			return "";
		if (empty ( $location->desc )) {
			$loc = $location->city;
			$full_loc = $location->province . $location->city . $location->district . $location->isp;
		} else {
			$loc = $location->desc;
		}
		return $loc;
	}
	public function FileSize($n_filesize) {
		return $this->getFilesize ( $n_filesize );
	}
	protected function getFilesize($n_filesize) {
		if ($n_filesize >= (1024 * 1024)) {
			$n_filesize = $n_filesize / (1024 * 1024);
			$n_filesize = round ( $n_filesize, 2 );
			return $n_filesize . ' G';
		} else if ($n_filesize > (1024)) {
			$n_filesize = $n_filesize / 1024;
			$n_filesize = round ( $n_filesize, 2 );
			return $n_filesize . ' MB';
		} else {
			return $n_filesize . ' KB';
		}
	
	}
	protected function TimeAccount($n_time, $s_update) {
		try {
			$o_date = new DateTime ( 'Asia/Chongqing' );
			$n_nowTime = $o_date->format ( 'U' );
			$n_result = $n_nowTime - $n_time;
			if ($n_result < 60) {
				return $n_result . ' ' . SysText::Index ( '014' );
			}
			if ($n_result >= 60 && $n_result < 3600) {
				return ( int ) ($n_result / 60) . ' ' . SysText::Index ( '015' );
			}
			if ($n_result >= 3600 && $n_result < 86400) {
				return ( int ) ($n_result / 3600) . ' ' . SysText::Index ( '016' );
			}
			if ($n_result >= 86400 && $n_result < 961200) {
				return ( int ) ($n_result / 86400) . ' ' . SysText::Index ( '017' );
			}
			$a_temp = explode ( ' ', $s_update );
			$a_time = explode ( ':', $a_temp [1] );
			return $a_temp [0] . ' ' . $a_time [0] . ':' . $a_time [1];
		} catch ( exception $err ) {
			return '';
		}
	}
	protected function GetDateForText($o_date) {
		return $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' );
	}
	protected function GetTimeCut() {
		$o_date = new DateTime ( 'Asia/Chongqing' );
		return $o_date->format ( 'U' );
	}
	protected function GetDateNow() {
		$o_date = new DateTime ( 'Asia/Chongqing' );
		return $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' );
	}
	protected function GetDate() {
		$o_date = new DateTime ( 'Asia/Chongqing' );
		return $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) ;
	}
	public function SendRemind($senduid, $receiveid, $content, $record = false) {
		require_once RELATIVITY_PATH . 'sub/sms/include/db_table.class.php';
		$o_rem = new Sms_Rem ();
		$o_rem->setSenderId ( $senduid );
		$o_rem->setReceiverId ( $receiveid );
		$o_rem->setContent ( $content );
		$o_rem->setSendTime ( $this->GetDateNow () );
		if ($record) {
			$o_rem->setTransRecord ( 1 );
		}
		$o_rem->Save ();
		//添加桌面图标+1
		$this->AddWaitReadSms ( $receiveid );
		//系统提示信息添加.			
		$this->AddSysmsg ( 2, 9, '未确认的事物提醒', '未确认提醒', $receiveid );
	}
	protected function AddWaitReadSms($n_uid) {
		$o_wait = new Sms_Info ( $n_uid );
		$a = $o_wait->getWaitRead ();
		if ($o_wait->getWaitRead () == null) {
			$o_wait = new Sms_Info ();
			$o_wait->setUid ( $n_uid );
			$o_wait->setWaitRead ( 1 );
		} else {
			$o_wait->setWaitRead ( $o_wait->getWaitRead () + 1 );
		}
		$o_wait->Save ();
	}
	protected function AddSysmsg($n_parent, $n_module, $s_text, $s_type, $n_uid) {
		$o_sysmsg = new Base_System_Msg ();
		$o_sysmsg->setParentModuleId ( $n_parent );
		$o_sysmsg->setModuleId ( $n_module );
		$o_sysmsg->setText ( $s_text );
		$o_sysmsg->setUid ( $n_uid );
		$o_sysmsg->setType ( $s_type );
		$o_sysmsg->Save ();
	}
	protected function SubSysmsg($n_parent, $n_module, $n_uid) {
		$o_sysmsg = new Base_System_Msg ();
		$o_sysmsg->PushWhere ( array ('&&', 'ParentModuleId', '=', $n_parent ) );
		$o_sysmsg->PushWhere ( array ('&&', 'ModuleId', '=', $n_module ) );
		$o_sysmsg->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
		if ($o_sysmsg->getAllCount () > 0) {
			$o_sysmsg = new Base_System_Msg ( $o_sysmsg->getId ( 0 ) );
			$o_sysmsg->Deletion ();
		}
	}
	protected function SendCmccSms($s_phone,$s_content)
	{
		$o_cmcc=new Base_Cmcc();
		$o_cmcc->setPhone($s_phone);
		$o_cmcc->setContent($s_content);
		$o_cmcc->setSendTime($this->GetDateNow());
		$b_result=$o_cmcc->Save();
			//自动生成用户名	
			while ($b_result==false)
			{
				$b_result=$o_cmcc->Save();
			}
		$o_cmcc->__destruct();		
	}
	protected function AddUserLog($u_id, $s_text) //添加用户操作日志
{
		require_once RELATIVITY_PATH . 'sub/diary/include/db_table.class.php';
		$o_log = new Diary_Log ();
		$o_log->setContent ( $s_text );
		$o_log->setUid ( $u_id );
		$o_log->setDate ( $this->GetDateNow () );
		$o_log->Save ();
	}
	protected function AilterTextArea($s_text) {
		$s_content = $s_text;
		$s_content = str_replace ( "\n", "<br/>", $s_content );
		$s_content = str_replace ( "\r", "", $s_content );
		$s_content = str_replace ( "\\", "\\\\\\\\", $s_content );
		while ( ! (strpos ( $s_content, "<br/><br/>" ) === false) ) {
			$s_content = str_replace ( "<br/><br/>", "<br/>", $s_content );
		}
		$s_content = str_replace ( ' ', '&nbsp;', $s_content );
		return $s_content;
	}
	// Returns true if $string is valid UTF-8 and false otherwise. 
	protected function IsUtf8($word) {
		if (preg_match ( "/^([" . chr ( 228 ) . "-" . chr ( 233 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}){1}/", $word ) == true || preg_match ( "/([" . chr ( 228 ) . "-" . chr ( 233 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}){1}$/", $word ) == true || preg_match ( "/([" . chr ( 228 ) . "-" . chr ( 233 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}){2,}/", $word ) == true) {
			return true;
		} else {
			return false;
		}
	} // function is_utf8 
	function Is_gb2312($str) {
		for($i = 0; $i < strlen ( $str ); $i ++) {
			$oneOrd = ord ( $str [$i] );
			if ($oneOrd > 227 && $oneOrd < 234) {
				if ($i + 2 >= strlen ( $str ) - 1)
					return true;
				$twoOrd = ord ( $str [$i + 1] );
				$threeOrd = ord ( $str [$i + 2] );
				if ($twoOrd > 128 && $twoOrd < 192 && $threeOrd > 127 && $threeOrd < 192)
					return false;
				return true;
			}
		}
		return true;
	}
	protected function DeleteDir($dir) {
		//先删除目录下的文件：
		$dh = opendir ( $dir );
		while ( $file = readdir ( $dh ) ) {
			if ($file != "." && $file != "..") {
				$fullpath = $dir . "/" . $file;
				if (! is_dir ( $fullpath )) {
					unlink ( $fullpath );
				} else {
					$this->DeleteDir ( $fullpath );
				}
			}
		}
		closedir ( $dh );
		//删除当前文件夹：
		if (rmdir ( $dir )) {
			return true;
		} else {
			return false;
		}
	}
	public function setPartyerLife($n_uid,$s_content,$s_url)
	{
		require_once RELATIVITY_PATH . 'sub/party/user/include/db_table.class.php';
		$o_life=new Party_Partyer_Life();
		$o_life->setUid($n_uid);
		$o_life->setContent($s_content);
		$o_life->setUrl($s_url);
		$o_life->setDate($this->GetDateNow());
		$o_life->Save();
		$o_life->__destruct();
	}
}
?>