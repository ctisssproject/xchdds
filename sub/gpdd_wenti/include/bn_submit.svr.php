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
	case 'AddArticle' :
		AddArticle ();
		break;
	case 'AddZc' :
		AddZc ();
		break;
	case 'AddDc' :
		AddDc ();
		break;
	case 'ModifyArticle' :
		ModifyArticle ();
		break;
	case 'HandleArrange' :
		HandleArrange ();
		break;
	case 'HandleFeedback' :
		HandleFeedback ();
		break;
	case 'ZcFeedback' :
		ZcFeedback ();
		break;
	case 'DcFeedback' :
		DcFeedback ();
		break;
	case 'DcSummary' :
		DcSummary ();
		break;
	case 'ZcReject' :
		ZcReject ();
		break;
	case 'DcReject' :
		DcReject ();
		break;
	case 'DcAuditorReject' :
		DcAuditorReject ();
		break;
	case 'DcAuditorFeedback' :
		DcAuditorFeedback ();
		break;
	case 'HandleClassify' :
		HandleClassify ();
		break;
	default :
		break;
}
exit ();
function HandleArrange() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$S_Result=$o_operate->HandleArrange ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		echo ('<script type="text/javascript" language="javascript">parent.location.reload();</script>');
	}
}
function HandleFeedback() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$S_Result=$o_operate->HandleFeedback ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("提交信息成功！",function(){parent.location="'.$_POST['Vcl_BackUrl'].'"})</script>');
	}
}
function ZcFeedback() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$S_Result=$o_operate->ZcFeedback ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("提交成功！",function(){parent.location="'.$_POST['Vcl_BackUrl'].'"})</script>');
	}
}
function DcFeedback() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$S_Result=$o_operate->DcFeedback ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("提交成功！",function(){parent.location="'.$_POST['Vcl_BackUrl'].'"})</script>');
	}
}
function DcSummary() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$S_Result=$o_operate->DcSummary ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("提交成功！",function(){parent.location="'.$_POST['Vcl_BackUrl'].'"})</script>');
	}
}
function ZcReject() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$S_Result=$o_operate->ZcReject ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("退回成功！",function(){parent.location="'.$_POST['Vcl_BackUrl'].'"})</script>');
	}
}
function DcReject() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$S_Result=$o_operate->DcReject ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("退回成功！",function(){parent.location="'.$_POST['Vcl_BackUrl'].'"})</script>');
	}
}
function DcAuditorReject() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$S_Result=$o_operate->DcAuditorReject ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("退回成功！",function(){parent.location="'.$_POST['Vcl_BackUrl'].'"})</script>');
	}
}
function DcAuditorFeedback() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$S_Result=$o_operate->DcAuditorFeedback ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("审批通过！",function(){parent.location="'.$_POST['Vcl_BackUrl'].'"})</script>');
	}
}
function AddArticle() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$S_Result=$o_operate->AddArticle ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		if ($S_Result)
		{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("添加记录成功！");parent.location="'.$_POST['Vcl_BackUrl'].'";</script>');
		}else{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("'.$o_operate->getResult().'")</script>');
		}
	}
}
function HandleClassify() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$S_Result=$o_operate->HandleClassify ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		if ($S_Result)
		{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("分类成功！<br/>请到“协同办理”查看！");parent.location.reload();</script>');
		}else{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("'.$o_operate->getResult().'")</script>');
		}
	}
}
function ModifyArticle() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$result=$o_operate->ModifyArticle ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("修改成功！",function(){parent.location="'.$_POST['Vcl_BackUrl'].'"})</script>');
	}
}
function AddZc() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$S_Result=$o_operate->AddZc ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		if ($S_Result)
		{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("发起成功！");parent.location="'.$_POST['Vcl_BackUrl'].'";</script>');
		}else{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("'.$o_operate->getResult().'")</script>');
		}
	}
}
function AddDc() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$S_Result=$o_operate->AddDc ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		if ($S_Result)
		{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("发起成功！");parent.location="'.$_POST['Vcl_BackUrl'].'";</script>');
		}else{
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("'.$o_operate->getResult().'")</script>');
		}
	}
}
?>