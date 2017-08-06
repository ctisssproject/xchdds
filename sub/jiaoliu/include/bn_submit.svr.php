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
	case 'ModifyArticle' :
		ModifyArticle ();
		break;
	default :
		break;
}
exit ();
function AddArticle() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$result=$o_operate->AddArticle ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	}else{
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("发布成功！");parent.location="../post.php"</script>');
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
?>