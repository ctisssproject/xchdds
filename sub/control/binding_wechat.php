<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 93 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
$o_user = new Base_User ($O_Session->getUid());
$o_user_info = new Base_User_Info ($O_Session->getUid());
$o_user_info_custom = new Base_User_Info_Custom ($O_Session->getUid());
$o_user_role = new Base_User_Role ($O_Session->getUid());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="../../module/DatePicker/skin/WdatePicker.css" />
<script type="text/javascript" src="../../module/DatePicker/WdatePicker.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/common.fun.js"></script>
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/ajax_post.class.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
</head>
<body class="bodycolor">
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=<?php 
		if ($o_user->getType()==0)
		{
			echo('ExternalInfoModify');
		}else{
			echo('InfoModify');
		}	
		?>"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="600" align="center" style="margin-top:10px">
	<tbody>
		<tr>
			<td><img src="../../images/sms_type31.gif" align="absmiddle" /><span
				class="big3"> 微信绑定</span></td>
		</tr>
	</tbody>
</table>
					<?php 
                    //如果已经绑定，那么显示微信头像和昵称
                    $o_table=new Base_User_Wechat();
                    $o_table->PushWhere ( array ('&&', 'Uid', '=', $O_Session->getUid() ) );
                    if($o_table->getAllCount()>0)
                    {
                    	require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
                    	$o_wechat=new WX_User_Info($o_table->getWechatId(0));
                    	?>
                    	<div id="sss_form">
                    	<table class="TableBlock_Editor" align="center" width="600" style="margin-top:10px">
							<tbody>
								<tr>
									<td colspan="2" class="TableData" nowrap="nowrap" style="text-align:center"><img style="width:50%" src="<?php echo($o_wechat->getPhoto())?>"></td>
								</tr>	
								<tr>
									<td class="TableData" nowrap="nowrap" width="120">微信昵称：</td>
									<td class="TableData">
									<?php echo($o_wechat->getNickname())?>
									</td>
								</tr>		
								<tr align="center">
									<td colspan="2" nowrap="nowrap" height="40" class="TableData" >
									<input value="解除绑定" class="BigButtonB" type="button" onclick="wechat_unbinding()"/></td>
								</tr>		
							</tbody>
						</table>
						</div>
                    	<?php
                    }else{
                    	//如果未绑定，那么显示二维码
                    	?>
                    	<div id="sss_form">
                    	<table class="TableBlock_Editor" align="center" width="600" style="margin-top:10px">
							<tbody>
								<tr>
									<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>打开微信扫一扫，扫描下方二维码，绑定微信帐号</strong></td>
								</tr>
								<tr>
									<td colspan="2" class="TableData" nowrap="nowrap" style="text-align:center">
										<img style="width:50%" src="binding_wechat_qrcode.php?id=<?php echo($O_Session->getUid())?>">
									</td>
								</tr>		
								<tr align="center">
									<td colspan="2" nowrap="nowrap" height="40" class="TableData" >
									<input value="刷新" class="BigButtonA" type="button" onclick="location='binding_wechat.php'"/></td>
								</tr>		
							</tbody>
						</table> 
						</div>                   	
                    	<?php
                    }
                    ?>

<br></br>
</form>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<script type="text/javascript" language="javascript">
	S_Root='../../';
	parent.parent.parent.Common_CloseDialog();
	var N_Timer=window.setInterval(wechat_get_binding_status,5000)
    </script>
</body>
</html>
