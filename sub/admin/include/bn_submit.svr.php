<?php
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
define ( 'RELATIVITY_PATH', '../../../' ); //定义相对路径
require_once RELATIVITY_PATH . 'include/bn_session.class.php';
$O_Session = new Session ();
$S_Function = $_GET ['function'];
switch ($S_Function) {
	case 'UserAdd' :
		UserAdd ();
		break;
	case 'UserModifyDept' :
		UserModifyDept ();
		break;
	case 'UserModifyRole' :
		UserModifyRole ();
		break;
	case 'UserResetPassword' :
		UserResetPassword ();
		break;
	case 'UserModifyInfo' :
		UserModifyInfo ();
		break;
	case 'DeptAdd' :
		DeptAdd ();
		break;
	case 'GroupAdd' :
		GroupAdd ();
		break;
	case 'GroupModify' :
		GroupModify ();
		break;
	case 'DeptModify' :
		DeptModify ();
		break;
	case 'DeptModifySort' :
		DeptModifySort ();
		break;
	case 'ModuleModify' :
		ModuleModify ();
		break;
	default :
		break;
}
exit ();

function UserAdd() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$S_Result=$o_operate->UserAdd ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($S_Result)
		{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("添加用户成功！");parent.location.reload();</script>');
		}else{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("[ 用户名 ] 有重名，请更换！")</script>');
		}		
	}
}
function UserModifyDept() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->UserModifyDept ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.location.reload();</script>');
		
	}
}
function UserResetPassword() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->UserResetPassword ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.Common_CloseDialog();parent.parent.parent.Dialog_Success("重置用户登陆密码成功！");</script>');
		
	}
}
function UserModifyRole() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->UserModifyRole ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.location.reload();</script>');
		
	}
}
function UserModifyInfo() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->UserModifyInfo ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Common_CloseDialog();parent.location.reload();</script>');		
	}
}
function DeptAdd() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$S_Result=$o_operate->DeptAdd ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($S_Result)
		{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("添加部门成功！请继续操作！");parent.location.reload();</script>');
		}else{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("'.$o_operate->getErrorReasion().'")</script>');
		}		
	}
}
function GroupAdd() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$S_Result=$o_operate->GroupAdd ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($S_Result)
		{
			echo ('<script type="text/javascript" language="javascript">parent.location="'.$_POST['Vcl_BackUrl'].'"</script>');
		}else{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("'.$o_operate->getErrorReasion().'")</script>');
		}		
	}
}
function GroupModify() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$S_Result=$o_operate->GroupModify ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($S_Result)
		{
			echo ('<script type="text/javascript" language="javascript">parent.location="'.$_POST['Vcl_BackUrl'].'"</script>');
		}else{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("'.$o_operate->getErrorReasion().'")</script>');
		}		
	}
}
function DeptModify() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$S_Result=$o_operate->DeptModify ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($S_Result)
		{
			echo ('<script type="text/javascript" language="javascript">parent.location="'.$_POST['Vcl_BackUrl'].'"</script>');
		}else{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("对不起！部门名称有重名！")</script>');
		}		
	}
}
function DeptModifySort() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->DeptModifySort ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.location.reload();</script>');	
	}
}
function ModuleModify() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$S_Result=$o_operate->ModuleModify ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Common_CloseDialog();parent.location.reload();</script>');	
	}
}
?>