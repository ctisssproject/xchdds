<?php
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
define ( 'RELATIVITY_PATH', '../../../' ); //定义相对路径
require_once RELATIVITY_PATH . 'include/bn_session.class.php';
$O_Session = new Session ();
require_once RELATIVITY_PATH . 'include/bn_ajaxrequest.class.php';
$O_Request = new AjaxRequest ( $_GET ['xml'] );
switch ($O_Request->getFunction ()) {
	case 'RecordDelete' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DudaoDelete' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'AltGetSchool' ://打开学期目录
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'RefreshMenuNotice' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;			
	default :
		break;
}
echo ($S_Request);
exit ( 0 );

function RecordDelete($n_id) {
	//获取二级部门列表
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result=$o_operate->RecordDelete ( $O_Session->getUid (),$n_id);
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'location.reload' );
	}
	return $O_Request->getSendXml ();
}
function DudaoDelete($n_id) {
	//获取二级部门列表
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result=$o_operate->DudaoDelete ( $O_Session->getUid (),$n_id);
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'location.reload' );
	}
	return $O_Request->getSendXml ();
}
function RefreshMenuNotice($id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$count=$o_operate->RefreshMenuNotice ($id, $O_Session->getUid () );
	$O_Request->setFunction ( 'refresh_menu_notice_callback' );	
	$O_Request->PushParameter ( $count );
	$O_Request->PushParameter ( $id );
	return $O_Request->getSendXml ();
}
function AltGetSchool($id,$value) {
	global $O_Session;
	global $O_Request;
	$O_Request->setFunction ( 'altGetCallback');
	$O_Request->PushParameter ( $id );
	$s_html='';
	$o_user=new Base_Dept();
	$o_user->PushWhere ( array ('&&', 'Name', 'LIKE', '%'.$value . '%' ) );
	$o_user->PushWhere ( array ('&&', 'ParentId', '=',1 ) );
	$n_count = $o_user->getAllCount ();
	$n_sum=0;
	$temp='';
	for($i=0;$i<$n_count;$i++)
	{
		if ($n_sum>9)
		{
			break;
		}
		if ($temp==$o_user->getName($i))
		{
			continue;
		}else{
			$s_html.='<li onclick="altSet(this)">'.$o_user->getName($i).'</li>';
			$temp=$o_user->getName($i);
			$n_sum++;
		}		
	}
	$O_Request->PushParameter ($s_html);
	return $O_Request->getSendXml ();
}
?>