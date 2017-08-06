function addArticle(){
    if (document.getElementById ('Vcl_Date').value==''){
        parent.parent.Dialog_Message('[ 活动日期 ] 不能为空 ！');
        return
    }
	if (document.getElementById ('Vcl_Title').value==''){
        parent.parent.Dialog_Message('[ 活动主题 ] 不能为空 ！');
        return
    }
	if (document.getElementById ('Vcl_Address').value==''){
        parent.parent.Dialog_Message('[ 活动地点 ] 不能为空 ！');
        return
    }
	if (document.getElementById ('Vcl_Name').value==''){
        parent.parent.Dialog_Message('[ 联系人 ] 不能为空 ！');
        return
    }
	if (document.getElementById ('Vcl_Phone').value==''){
        parent.parent.Dialog_Message('[ 联系方式 ] 不能为空 ！');
        return
    }
	if (document.getElementById ('Vcl_Content').value==''){
        parent.parent.Dialog_Message('[ 活动简述 ] 不能为空 ！');
        return
    }
	 parent.parent.Dialog_Confirm("真的要发起活动吗？<br/>发起后将不能修改与删除。",function (){document.getElementById('dialog_form').submit();parent.parent.Common_OpenLoading(); });    
}
function join_confirm(n_id){
	var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('JoinConfirm');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要确认吗？",function (){o_ajax_request.SendRequest()}); 
}
function completed_confirm(n_id){
	var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('CompletedConfirm');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要确认吗？<br/>确认后改记录将进入历时活动。",function (){o_ajax_request.SendRequest()}); 
}
function huodong_delete(n_id){
	var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('HuodongDelete');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除吗？",function (){o_ajax_request.SendRequest()}); 
}
function feedback(){
    if (document.getElementById ('Vcl_Feedback').value==''){
        parent.parent.Dialog_Message('[ 活动反馈 ] 不能为空 ！');
        return
    }
	parent.parent.Dialog_Confirm("真的要提交活动反馈吗？",function (){document.getElementById('dialog_form').submit();parent.parent.Common_OpenLoading(); });    
}
function reply(n_id){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=Reply"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%"><input type="hidden" name="Vcl_Id" value="'+n_id+'"/>') 
    a_arr.push('<table style="width:350px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            督学答复');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock" align="center" width="350">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;是否参与：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('            <select name="Vcl_IsGo" id="Vcl_IsGo" class="BigSelect">')
	a_arr.push('            	<option value="1">参与活动</option>');
	a_arr.push('            	<option value="0">不参与</option>');
    a_arr.push('                </select>')
    a_arr.push('            </td>')
    a_arr.push('		</tr>')
	a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;备注：</td>')
    a_arr.push('			<td class="TableData"><textarea class="BigInput" style="" name="Vcl_GoReason" id="Vcl_GoReason" rows="5" cols="20"></textarea>')
    a_arr.push('            </td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="提交" class="submitButton"')
    a_arr.push('				type="submit" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=357
	N_Dialog_Width=370
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));   
}
S_Root='../../';
var Command=new Array();
Command.push("refresh_menu_notice('sub_telephone_nav_php',S_Root+'sub/telephone/include/it_ajax.svr.php');");
Command.push("refresh_menu_notice('sub_gpdd_wenti_nav_php',S_Root+'sub/gpdd_wenti/include/it_ajax.svr.php',1);");
Command.push("refresh_menu_notice('sub_gpdd_wenti_gpdd_php',S_Root+'sub/gpdd_wenti/include/it_ajax.svr.php',2);");
refresh_menu_notice('sub_gpdd_huodong_nav_php',S_Root+'sub/gpdd_huodong/include/it_ajax.svr.php');

