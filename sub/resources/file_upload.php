<?php
$id=md5(uniqid(rand(), true))
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>无标题页</title>
    <link href="../../css/common.css" rel="stylesheet" type="text/css" />
     <script type="text/javascript" src="../../js/jquery/jquery.min.js"></script>
     <script type="text/javascript" src="../../js/ajax.class.js"></script>
<style type="text/css">
.deleteButton
{
	color:#999999;
}
.deleteButton:hover
{
	color:#990000;
}
a:hover
{
	text-decoration:underline;
	}
</style>
    <script type="text/javascript">
function uploadStart(folderid)
{
	document.getElementById('Vcl_FolderId').value=folderid;
	document.getElementById('upload_form_<?php echo($id)?>').submit()
	setTimeout('getProgressLoading()',1000)
	$('div').show()
	$('#Vcl_Upload').hide()	
}
function getProgressLoading()
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('UploadGetProgress');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter($('#progress_key').val());
    o_ajax_request.SendRequest()
	}
function progressLoadingCallback(n_number)
{
    n_number=Math.round(n_number/100*200)
    clearInterval(N_TimeHandle)//启动动画前先停掉，防止重复动画
    N_TimeHandle=setInterval('progressAction('+n_number+')',40)
    if (n_number==200)
    {
        //window.alert()
    }else{
		//继续探测
    	setTimeout('getProgressLoading()',1000)
        }    
}
var N_TimeHandle=0
function progressAction(n_end)
{
	$n_old=$('#progress div').width()
	if ($n_old>=n_end)
	{
		//停止动画
		 clearInterval(N_TimeHandle)
		 if (n_end==200)
		 {
			parent.uploadSubmit();	
		 }
	}else{
		$('#progress div').width($n_old+3);
		$('#text').html(Math.floor(($n_old+3)/2)+'%');
	}
}
function uploadCancel()
{   	
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('UploadDeleteAffix');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    var s_filename=$('#Vcl_Upload').val()
    s_filename=s_filename.split('\\');
    s_filename=s_filename[s_filename.length-1]
    o_ajax_request.PushParameter(s_filename);
    o_ajax_request.SendRequest()
	parent.uploadCancel()
}
function getProgress()
{
	return $('#progress div').width();
	}
//$(function(){

//})
//$(window).unload(function(){
//  alert("Goodbye!");
//});

    </script>

</head>
<body style="background-color:White">
<form method="post" id="upload_form_<?php echo($id)?>"
	action="include/bn_submit.svr.php?function=UploadTempFile"
	enctype="multipart/form-data" target="upload_form_<?php echo($id)?>">
    <input type="hidden" name="APC_UPLOAD_PROGRESS" id="progress_key"  value="<?php echo($id)?>"/>
    <input id="Vcl_Upload" name="Vcl_Upload" type="file"/>
    <input id="Vcl_KeyWord" name="Vcl_KeyWord" size="30" maxlength="30" value="666" class="BigInput" type="text" style="display:none"/>
    <input id="Vcl_FolderId" name="Vcl_FolderId" size="30" maxlength="30" class="BigInput" type="text" style="display:none"/>
    <div style="display:none">
    <div id="progress" style="border: 1px solid #5B99CA; height: 12px; width: 200px;float:left; margin-top:3px">
        <div style="background-color: #9AC5E9; width: 0px; height: 12px;">
        </div>       
    </div> 
    <div id="text" style="float:left; padding-left:5px; vertical-align:top">0%</div>
    </div>
</form>
    <iframe id="upload_form_<?php echo($id)?>" name="upload_form_<?php echo($id)?>" width="0" height="0" marginwidth="0"
        border="0" frameborder="0" src="about:blank"></iframe>
</body>
</html>
