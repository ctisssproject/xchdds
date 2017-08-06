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
	case 'AddScroll' :
		AddScroll ();
		break;
	case 'ModifyIndexColumn' :
		ModifyIndexColumn ();
		break;
	case 'ModifyFocus' :
		ModifyFocus ();
		break;
	case 'ModifyBigFocus' :
		ModifyBigFocus ();
		break;
	case 'ModifyLink' :
		ModifyLink ();
		break;
	case 'MoveArticle' :
		MoveArticle ();
		break;
	case 'AddColumn' :
		AddColumn ();
		break;
	case 'AddFloat' :
		AddFloat ();
		break;
	case 'ModifyColumn' :
		ModifyColumn ();
		break;
	case 'ModifyFloat' :
		ModifyFloat ();
		break;
	case 'AddPhoto' :
		AddPhoto ();
		break;
	case 'AddArticle' :
		AddArticle ();
		break;
	case 'ModifyArticle' :
		ModifyArticle ();
		break;
	case 'ModifyArticleMy' :
		ModifyArticleMy ();
		break;
	case 'ModifyFooter' :
		ModifyFooter ();
		break;
	case 'AddLink' :
		AddLink ();
		break;
	case 'AddFooter' :
		AddFooter ();
		break;
	case 'AddFocus' :
		AddFocus ();
		break;
	case 'AddBigFocus' :
		AddBigFocus ();
		break;
	case 'ArticleReturn' :
		ArticleReturn ();
		break;
	case 'CommentAdd' :
		CommentAdd ();
		break;
	case 'MessagesAdd' :
		MessagesAdd ();
		break;
	case 'MessagesAudit' :
		MessagesAudit ();
		break;
	default :
		break;
}
exit ();
function ArticleReturn() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->ArticleReturn ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.location.reload()</script>');
	}
}
function AddScroll() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$s_result = $o_operate->AddScroll ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($s_result) {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Common_CloseDialog();parent.location=\'../home_dynamic.php\'</script>');
		} else {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("文章不存在，请重新确认！")</script>');
		}
	}
}
function ModifyIndexColumn() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$o_operate->ModifyIndexColumn ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Common_CloseDialog();parent.location=\'../home_column.php\'</script>');
	}
}
function AddFocus() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$s_result = $o_operate->AddFocus ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($s_result == 1) {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("添加焦点图片成功！",function(){parent.location=\'sub/home/home_focusphoto.php\'})</script>');
		} else if ($s_result == 2) {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("图片格式错误！")</script>');
		} else {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Message("[ 上传图片  ] 不能为空！")</script>');
		}
	
	}
}
function AddBigFocus() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$s_result = $o_operate->AddBigFocus ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($s_result == 1) {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("添加图片成功！",function(){parent.location=\'sub/home/home_focus.php\'})</script>');
		} else if ($s_result == 2) {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("图片格式错误！")</script>');
		} else {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Message("[ 上传图片  ] 不能为空！")</script>');
		}
	
	}
}
function AddPhoto() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$s_result = $o_operate->AddPhoto ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($s_result == 1) {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("添加图片成功！");parent.location=\'../home_photo.php\';</script>');
		} else if ($s_result == 2) {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("图片格式错误！")</script>');
		} else {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Message("[ 上传图片  ] 不能为空！")</script>');
		}
	
	}
}
function ModifyFocus() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$s_result = $o_operate->ModifyFocus ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($s_result) {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("修改焦点图片成功！",function(){parent.location=\'sub/home/home_focusphoto.php\'})</script>');
		} else {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("图片格式错误！")</script>');
		}
	
	}
}
function ModifyBigFocus() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$s_result = $o_operate->ModifyBigFocus ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		if ($s_result) {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("修改图片成功",function(){parent.location=\'sub/home/home_focus.php\'})</script>');
		} else {
			echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Error("图片格式错误！")</script>');
		}
	
	}
}

function ModifyLink() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$o_operate->ModifyLink ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("修改友情链接成功！",function(){parent.location=\'../home_link.php\'})</script>');
	
	}
}
function ModifyFooter() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$o_operate->ModifyFooter ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("保存文章成功！");parent.location=\'../home_footer.php\'</script>');
	
	}
}
function AddFooter() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$o_operate->AddFooter ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("添加文章成功！");parent.location=\'../home_footer.php\';</script>');
	
	}
}

function AddArticle() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$result=$o_operate->AddArticle ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else if($_POST['Vcl_GoBack']==''){
		
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("发布文章成功！");parent.location=\'../article_list.php?columnid='.$result.'\'</script>');
	}else{
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("发布文章成功！");parent.location=\'../article_my.php?page='.$_POST['Vcl_GoBack'].'\'</script>');
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
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.location="'.$_POST['Vcl_BackUrl'].'";parent.parent.parent.Dialog_Success("文章修改成功！");</script>');
	
	}
}
function ModifyArticleMy() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$result=$o_operate->ModifyArticleMy ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.location="'.$_POST['Vcl_BackUrl'].'";parent.parent.parent.Dialog_Success("文章修改成功！");</script>');
	
	}
}
function AddColumn() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$o_operate->AddColumn ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.location=\'../column.php\'</script>');
	}
}
function MessagesAdd() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_operate->MessagesAdd ();
	echo ('<script type="text/javascript" language="javascript">parent.submitMessagesCallback()</script>');
}
function AddFloat() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$o_operate->AddFloat ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.location=\'../home_float.php\'</script>');
	}
}
function MoveArticle() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$o_operate->MoveArticle ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.location.reload()</script>');
	}
}
function ModifyColumn() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$o_operate->ModifyColumn ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.location=\'../column.php\'</script>');
	}
}
function ModifyFloat() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$o_operate->ModifyFloat ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.location=\'../home_float.php\'</script>');
	}
}
function AddLink() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$o_operate->AddLink ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.parent.parent.Dialog_Success("修改友情链接成功！",function(){parent.location=\'../home_link.php\'})</script>');
	
	}
}
function CommentAdd() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$s_result = $o_operate->CommentAdd ( $O_Session->getUid () );
	echo ('<script type="text/javascript" language="javascript">parent.submitCommentCallback()</script>');
}
function MessagesAudit() {
	global $O_Session;
	require_once 'bn_operate.class.php';
	$o_operate = new Operate ();
	$o_user = $O_Session->getUserObject ();
	$result=$o_operate->MessagesAudit ( $O_Session->getUid () );
	if ($o_operate->getResult () == false) {
		echo ('<script type="text/javascript" language="javascript">parent.goLoginPage(\'' . RELATIVITY_PATH . '\')</script>');
	} else {
		echo ('<script type="text/javascript" language="javascript">parent.history.go(-1);parent.parent.parent.Dialog_Success("审核留言成功！");</script>');
	
	}
}
?>