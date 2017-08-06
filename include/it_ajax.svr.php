<?php
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
define ( 'RELATIVITY_PATH', '../' ); //定义相对路径
require_once RELATIVITY_PATH . 'include/bn_session.class.php';
$O_Session = new Session ();
$S_Request = '';
require_once RELATIVITY_PATH . 'include/bn_ajaxrequest.class.php';
$O_Request = new AjaxRequest ( $_GET ['xml'] );
//$a=$O_Request->getFunction ();
switch ($O_Request->getFunction ()) {
	case 'Services' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'AutoLogin' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'AutoLoginForIndex' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'Logout' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'AddTab' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'SysmsgRead' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DelUpLoadPictureForEditor' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'RefreshPictureListForEditor' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DesktopRefresh' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'AmDesktopRefresh' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'TimeRefresh' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'WeatherRefresh' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'OnlineRefresh' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ButtonUnreadMsg' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ButtonUnreadRem' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'ButtonGetUserInfo' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DesktopSave' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'GetOnlineUser' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'UploadGetProgress' : 
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	default :
		break;
}
echo ($S_Request);
exit ( 0 );
function UploadGetProgress($s_key) {
	global $O_Session;
	global $O_Request;
	$status = apc_fetch('upload_'.$s_key);
	$O_Request->setFunction ( 'progressLoadingCallback' );
	$n_progress=floor(($status['current']/$status['total'])*100);
	$O_Request->PushParameter ($n_progress);
	return $O_Request->getSendXml ();
}
function TimeRefresh() {
	global $O_Session;
	global $O_Request;
	$o_date = new DateTime ( 'Asia/Chongqing' );
	$O_Request->setFunction ( 'callbackTimeRefresh' );
	$O_Request->PushParameter ( $o_date->format ( 'Y' ) . '年' . $o_date->format ( 'm' ) . '月' . $o_date->format ( 'd' ) . '日' );
	$O_Request->PushParameter ( $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) );
	require_once RELATIVITY_PATH . 'include/it_lunar.class.php';
	$lunar = new Lunar ();
	$ldate = $lunar->convertSolarToLunar ( $o_date->format ( 'Y' ), $o_date->format ( 'm' ), $o_date->format ( 'd' ) );
	$O_Request->PushParameter ('农历' .$ldate [1]. $ldate [2] );
	return $O_Request->getSendXml ();
}
function DesktopSave($s_moduleid)
{
	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DesktopSave ( $s_moduleid, $O_Session->getUid () );
}
function Services()
{
/*	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->CheckUserEmail();
	$O_Request->setFunction ( 'servicesCallback' );
	$O_Request->PushParameter ($o_operate->getText());
	return $O_Request->getSendXml ();*/
}
function OnlineRefresh() {
	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/bn_operate.class.php';
	$o_operate = new Operate ();
	$O_Request->setFunction ( 'callbackOnlineRefresh' );
	$O_Request->PushParameter ($o_operate->OnlineRefresh ());
	return $O_Request->getSendXml ();
}
function WeatherRefresh() {
	global $O_Session;
	global $O_Request;
	//获取ip
	if (getenv ( 'HTTP_CLIENT_IP' ) && strcasecmp ( getenv ( 'HTTP_CLIENT_IP' ), 'unknown' )) {
		$SA_IP = getenv ( 'HTTP_CLIENT_IP' );
	} elseif (getenv ( 'HTTP_X_FORWARDED_FOR' ) && strcasecmp ( getenv ( 'HTTP_X_FORWARDED_FOR' ), 'unknown' )) {
		$SA_IP = getenv ( 'HTTP_X_FORWARDED_FOR' );
	} elseif (getenv ( 'REMOTE_ADDR' ) && strcasecmp ( getenv ( 'REMOTE_ADDR' ), 'unknown' )) {
		$SA_IP = getenv ( 'REMOTE_ADDR' );
	} elseif (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], 'unknown' )) {
		$SA_IP = $_SERVER ['REMOTE_ADDR'];
	}
	require_once RELATIVITY_PATH . 'include/bn_operate.class.php';
	$o_operate = new Operate ();
	$city = $o_operate->getIPLoc_sina ( "$SA_IP" );
	$citycode = mb_convert_encoding ( $city, "gb2312", "utf-8" );
	$doc = new DOMDocument ();
	if (! @$doc->load ( "http://php.weather.sina.com.cn/xml.php?city=" . $citycode . "&password=DJOYnieT8234jlsK&day=0" )) {
		exit ( 0 );
	}
	$stat1 = $doc->getElementsByTagName ( "status1" )->item ( 0 )->nodeValue;
	$stat2 = $doc->getElementsByTagName ( "status2" )->item ( 0 )->nodeValue;
	$tmp1 = $doc->getElementsByTagName ( "temperature1" )->item ( 0 )->nodeValue;
	$tmp2 = $doc->getElementsByTagName ( "temperature2" )->item ( 0 )->nodeValue;
	$O_Request->setFunction ( 'callbackWeatherRefresh' );
	$O_Request->PushParameter ( $stat1 );
	$O_Request->PushParameter ( $stat2 );
	$O_Request->PushParameter ( $tmp1 );
	$O_Request->PushParameter ( $tmp2 );
	return $O_Request->getSendXml ();
}
function DesktopRefresh() {
	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/it_showpage.class.php';
	$o_iconList = new ShowPage ( $O_Session->getUserObject () );
	$O_Request->setFunction ( 'callbackDesktopRefresh' );
	$O_Request->PushParameter ( $o_iconList->getDesktop () );	
	$O_Request->PushParameter ( $o_iconList->getDesktopModuleSort ());
	return $O_Request->getSendXml ();
}
function AmDesktopRefresh() {
	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/it_showpage.class.php';
	$o_iconList = new ShowPage ( $O_Session->getUserObject () );
	$O_Request->setFunction ( 'amDesktopCallBack' );
	$O_Request->PushParameter ( $o_iconList->getAmDesktop () );	
	return $O_Request->getSendXml ();
}
function ButtonGetUserInfo($n_other_uid) {
	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->ButtonGetUserInfo ( $n_other_uid, $O_Session->getUid () );
	$O_Request->setFunction ( 'callbackButtonGetUserInfo' );
	$O_Request->PushParameter ( $n_other_uid );
	$O_Request->PushParameter ( $o_operate->getItem() );
	$O_Request->PushParameter ( $o_operate->getInfo());
	return $O_Request->getSendXml ();
}
function AutoLogin($username,$password,$module) {
	global $O_Session;
	global $O_Request;
	$O_Request->setFunction ( 'autoLoginCallBack' );
	require_once RELATIVITY_PATH . 'include/bn_user.class.php';
	$o_user =new Single_User();
	if ($o_user->AutoLogin($username, $password ))
	{
		$O_Request->PushParameter ( $module );
	}else{
		$O_Request->PushParameter ( -1 );
	}
	return $O_Request->getSendXml ();
}
function AutoLoginForIndex($username,$password) {
	global $O_Session;
	global $O_Request;
	$O_Request->setFunction ( 'autoLoginCallBack' );
	require_once RELATIVITY_PATH . 'include/bn_user.class.php';
	$o_user =new Single_User();
	if ($o_user->AutoLoginForIndex($username, $password ))
	{
		$O_Request->PushParameter ( 0);
	}else{
		$O_Request->PushParameter ( -1 );
	}
	return $O_Request->getSendXml ();
}
function Logout() {
	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/bn_user.class.php';
	$o_user = $O_Session->getUserObject ();
	$o_user->Logout ( $_COOKIE ['SESSIONID'] );
	$O_Request->setFunction ( 'parent.location.reload' );
	return $O_Request->getSendXml ();
}
function DelUpLoadPictureForEditor($n_id) {
	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/bn_user.class.php';
	$o_user = $O_Session->getUserObject ();
	$o_user->DelUpLoadPicture ( $n_id );
	$O_Request->setFunction ( 'Editor_SetPhotoFreeSplace' );
	$O_Request->PushParameter ( $o_user->getPhotoFreeSplace () );
	return $O_Request->getSendXml ();
}
function RefreshPictureListForEditor() {
	//刷新文本编辑器的图片列表
	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/bn_user.class.php';
	$o_user = $O_Session->getUserObject ();
	$s_photolist = $o_user->getPictrueListForAjax ();
	$O_Request->setFunction ( 'Editor_BulidPhotoList' );
	$O_Request->PushParameter ( $s_photolist );
	return $O_Request->getSendXml ();
}
function AddTab($n_module_id, $s_sub) {
	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->AddTab ( $n_module_id, $s_sub, $O_Session->getUid () );
	if ($o_operate->getResult ()) {
		$O_Request->setFunction ( 'addTabCallBack' );
		$O_Request->PushParameter ( $o_operate->getModuleName () );
		$O_Request->PushParameter ( $o_operate->getNav2Name () );
		$O_Request->PushParameter ( $o_operate->getNav2Url () );
		$O_Request->PushParameter ( $o_operate->getNumber () );
	} else {
		$O_Request->setFunction ( 'goLoginPage' );
	}
	return $O_Request->getSendXml ();

}
function ButtonUnreadMsg() {
	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result=$o_operate->ButtonUnreadMsg ($O_Session->getUid () );
	if ($s_result==1) {
		$O_Request->setFunction ( 'addTabForRefresh' );
		$O_Request->PushParameter (2);
		$O_Request->PushParameter (8);
	}else if ($s_result==0){
		$O_Request->setFunction ( 'Dialog_Message' );
		$O_Request->PushParameter ('您目前没有未读的短消息！');
	} else if ($o_operate->getResult ()===false){
		$O_Request->setFunction ( 'goLoginPage' );
	}
	return $O_Request->getSendXml ();

}
function ButtonUnreadRem() {
	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result=$o_operate->ButtonUnreadRem ($O_Session->getUid () );
	if ($s_result==1) {
		$O_Request->setFunction ( 'addTabForRefresh' );
		$O_Request->PushParameter (2);
		$O_Request->PushParameter (9);
	}else if ($s_result==0){
		$O_Request->setFunction ( 'Dialog_Message' );
		$O_Request->PushParameter ('您没有未确认的事物提醒！');
	} else if ($o_operate->getResult ()===false){
		$O_Request->setFunction ( 'goLoginPage' );
	}
	return $O_Request->getSendXml ();

}
function SysmsgRead() {
	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/bn_operate.class.php';
	$o_operate = new Operate ();
	if ($o_operate->SysmsgRead ( $O_Session->getUid () ) === false) {
		exit ( 0 );
	}
	if ($o_operate->getResult ()) {
		$O_Request->setFunction ( 'callbackSysmsgRead' );
		$O_Request->PushParameter ( $o_operate->getParentId () );
		$O_Request->PushParameter ( $o_operate->getModuleId () );
		$O_Request->PushParameter ( $o_operate->getNumber () );
		$O_Request->PushParameter ( $o_operate->getText () );
	} else {
		$O_Request->setFunction ( 'goLoginPage' );
	}
	return $O_Request->getSendXml ();

}
function getOnlineUser() {
	global $O_Session;
	global $O_Request;
	require_once RELATIVITY_PATH . 'include/bn_operate.class.php';
	$o_operate = new Operate ();	
	if ($o_operate->getResult ()) {
		$O_Request->setFunction ( 'getOnlineUserCallback' );
		$O_Request->PushParameter ($o_operate->getOnlineUser ($O_Session->getUid () ));
	} else {
		$O_Request->setFunction ( 'goLoginPage' );
	}
	return $O_Request->getSendXml ();

}
?>