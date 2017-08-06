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
	case 'RecordAdd' :
		RecordAdd ();
		break;
	case 'RecordModify' :
		RecordModify ();
		break;
	case 'DudaoModify' :
		DudaoModify ();
		break;
	default :
		break;
}
exit ();

function RecordAdd() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$S_Result=$o_operate->RecordAdd ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($S_Result)
		{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("添加记录成功！");parent.location.reload();</script>');
		}else{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("'.$o_operate->getResult().'")</script>');
		}		
	}
}
function RecordModify() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$S_Result=$o_operate->RecordModify ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($S_Result)
		{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("更新记录成功！");parent.location=\'' . $_POST['Vcl_BackUrl']. '\';</script>');
		}else{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("'.$o_operate->getResult().'")</script>');
		}		
	}
}
function DudaoModify() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$S_Result=$o_operate->DudaoModify ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($S_Result)
		{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("提交记录成功！");parent.location=\'' . $_POST['Vcl_BackUrl']. '\';</script>');
		}else{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("'.$o_operate->getResult().'")</script>');
		}		
	}
}
?>