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
	case 'GetDept2' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'GetDept3' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'UserModifyDeptGetDeptVcl' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DeptModifyDeptGetDeptVcl' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'UserModifyRoleGetRoleVcl' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'UserSetState' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'RoleAdd' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'RoleModify' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'RoleDelete' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'RoleGetUser' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'DeptDelete' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	case 'GroupDelete' :
		$s_command = '$S_Request=' . $O_Request->getCommand ( '$O_Request' );
		eval ( $s_command );
		break;
	default :
		break;
}
echo ($S_Request);
exit ( 0 );
function GetDept2($n_id) {
	//获取二级部门列表
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->GetSubDept ( $n_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'callbackSetDept2' );
		$O_Request->PushParameter ( $o_operate->S_DeptId );
		$O_Request->PushParameter ( $o_operate->S_DeptName );
	}
	return $O_Request->getSendXml ();
}
function GetDept3($n_id) {
	//获取二级部门列表
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->GetSubDept ( $n_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'callbackSetDept3' );
		$O_Request->PushParameter ( $o_operate->S_DeptId );
		$O_Request->PushParameter ( $o_operate->S_DeptName );
	}
	return $O_Request->getSendXml ();
}
function UserModifyDeptGetDeptVcl($n_id) {
	//获取二级部门列表
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$O_Request->setFunction ( 'callbackUserModifyDeptGetDeptVcl' );
	$O_Request->PushParameter ( $o_operate->UserModifyDeptGetDeptVcl ( $n_id, $O_Session->getUid () ));
	return $O_Request->getSendXml ();
}
function DeptModifyDeptGetDeptVcl($n_id) {
	//获取二级部门列表
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$O_Request->setFunction ( 'callbackDeptModifyDeptGetDeptVcl' );
	$O_Request->PushParameter ( $o_operate->DeptModifyDeptGetDeptVcl ( $n_id, $O_Session->getUid () ));
	return $O_Request->getSendXml ();
}
function UserModifyRoleGetRoleVcl($n_id) {
	//获取二级部门列表
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$O_Request->setFunction ( 'callbackUserModifyRoleGetRoleVcl' );
	$O_Request->PushParameter ( $o_operate->UserModifyRoleGetRoleVcl ( $n_id, $O_Session->getUid () ));
	return $O_Request->getSendXml ();
}
function UserSetState($n_id,$n_state) {
	//获取二级部门列表
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->UserSetState ( $n_id,$n_state, $O_Session->getUid () );
}
function RoleAdd($n_name,$n_exlain,$s_id) {
	//获取二级部门列表
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->RoleAdd ($n_name,$n_exlain,$s_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'callbackRoleModify' );
	}
	return $O_Request->getSendXml ();
}
function RoleModify($n_id,$n_name,$n_exlain,$s_id) {
	//获取二级部门列表
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->RoleModify ($n_id, $n_name,$n_exlain,$s_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'callbackRoleModify' );
	}
	return $O_Request->getSendXml ();
}
function RoleDelete($n_id) {
	//获取二级部门列表
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result=$o_operate->RoleDelete ( $n_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		if ($s_result){
			$O_Request->setFunction ( 'location.reload' );
		}else{
			$O_Request->setFunction ( 'parent.parent.parent.Dialog_Error' );
			$O_Request->PushParameter ( '对不起，<br>有用户使用这个角色！');
		}		
	}
	return $O_Request->getSendXml ();
}
function GroupDelete($n_id) {
	//获取二级部门列表
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$s_result=$o_operate->GroupDelete ( $n_id, $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		$O_Request->setFunction ( 'goLoginPage' );
	} else {
		$O_Request->setFunction ( 'location.reload' );		
	}
	return $O_Request->getSendXml ();
}
function RoleGetUser($n_id) {
	//获取二级部门列表
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$O_Request->setFunction ( 'callbackRoleOpenUser' );
	$O_Request->PushParameter ( $n_id);
	$O_Request->PushParameter ( $o_operate->RoleGetUser ( $n_id, $O_Session->getUid () ));
	return $O_Request->getSendXml ();
}
function DeptDelete($n_id) {
	global $O_Session;
	global $O_Request;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$S_Result=$o_operate->DeptDelete ( $n_id,$O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($S_Result==1)
		{
			$O_Request->setFunction ( 'location.reload' );
		}else if ($S_Result==2){
			$O_Request->setFunction ( 'parent.parent.parent.Dialog_Error' );
			$O_Request->PushParameter ( '对不起！<br>不能删除有子部门的部门！');
		}else if ($S_Result==3){
			$O_Request->setFunction ( 'parent.parent.parent.Dialog_Error' );
			$O_Request->PushParameter ( '对不起！部门中有用户！<br>不能删除部门！');
		}				
	}
	return $O_Request->getSendXml ();
}
?>