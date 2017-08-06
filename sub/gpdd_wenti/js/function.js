function addArticle(){
	var s_school=document.getElementById ('Vcl_SchoolId').value
    if (s_school==''){
        parent.parent.Dialog_Message('请选择 [ 学校名称 ] ！');
        return
    }
    if (document.getElementById ('Vcl_From').value==''){
        parent.parent.Dialog_Message('[ 来源 ] 不能为空 ！');
        return
    }
    document.getElementById ('Vcl_Content').value=UE.getEditor('editor').getContent()
    var s_content=document.getElementById ('Vcl_Content').value
    if (s_content.length<10){
        parent.parent.Dialog_Message('对不起 , 文章内容太少 !');
        return
    }
	 parent.parent.Dialog_Confirm("真的要发起问题吗？<br/>发起问题后将不能修改与删除。",function (){document.getElementById('dialog_form').submit();parent.parent.Common_OpenLoading(); });    
    
	  
}
function handle_feedback(){
	document.getElementById ('Vcl_Content').value=UE.getEditor('editor').getContent()
    var s_content=document.getElementById ('Vcl_Content').value
    if (s_content.length<10){
        parent.parent.Dialog_Message('对不起 , 问题内容太少 !');
        return
    }
    if (document.getElementById ('Vcl_Feedback').value==''){
        parent.parent.Dialog_Message('[ 处理内容 ] 不能为空 ！');
        return
    }
	parent.parent.Dialog_Confirm("真的要提交问题处理吗？",function (){document.getElementById('dialog_form').submit();parent.parent.Common_OpenLoading(); });    
}
function handle_arrange(n_id){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=HandleArrange"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%"><input type="hidden" name="Vcl_Id" value="'+n_id+'"/>') 
    a_arr.push('<table style="width:350px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            问题分配');
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
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;分配到：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('            <select name="Vcl_State" id="Vcl_State" class="BigSelect">')
	a_arr.push('            	<option value="2">学校处理</option>');
	a_arr.push('            	<option value="3">业务科室处理</option>');
    a_arr.push('                </select>')
    a_arr.push('            </td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="保存" class="submitButton"')
    a_arr.push('				type="submit" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=350
	N_Dialog_Width=367
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));   
}
function handle_classify(n_id){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=HandleClassify"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%"><input type="hidden" name="Vcl_Id" value="'+n_id+'"/>') 
    a_arr.push('<table style="width:350px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            问题分类');
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
    a_arr.push('			<td class="TableData" style="padding:10px;">')
    a_arr.push('            <div style="float:left;width:300px;"><input style="margin-top:3px" class="checkbox" name="Vcl_Type1" id="Vcl_Type1" type="checkbox"/> 校务管理和制度执行情况</div><div style="float:left;width:300px;"><input style="margin-top:3px" class="checkbox" name="Vcl_Type2" id="Vcl_Type2" type="checkbox"/> 招生、收费、择校情况</div><div style="float:left;width:300px;"><input style="margin-top:3px" class="checkbox" name="Vcl_Type3" id="Vcl_Type3" type="checkbox"/> 课程开设和课堂教学情况</div><div style="float:left;width:300px;"><input style="margin-top:3px" class="checkbox" name="Vcl_Type4" id="Vcl_Type4" type="checkbox"/> 学生学习、体育锻炼和课业负担情况</div><div style="float:left;width:300px;"><input style="margin-top:3px" class="checkbox" name="Vcl_Type5" id="Vcl_Type5" type="checkbox"/> 教师师德和专业发展情况</div><div style="float:left;width:300px;"><input style="margin-top:3px" class="checkbox" name="Vcl_Type6" id="Vcl_Type6" type="checkbox"/> 校园及周边安全情况，学生交通安全情况</div><div style="float:left;width:300px;"><input style="margin-top:3px" class="checkbox" name="Vcl_Type7" id="Vcl_Type7" type="checkbox"/> 食堂、食品、饮水机、宿舍卫生情况</div><div style="float:left;width:300px;"><input style="margin-top:3px" class="checkbox" name="Vcl_Type8" id="Vcl_Type8" type="checkbox"/> 校风、教风、学风建设情况</div><div style="float:left;width:300px;"><input style="margin-top:3px" class="checkbox" name="Vcl_Type9" id="Vcl_Type9" type="checkbox"/> 其他情况：<input style="margin-top:3px" class="BigInput" name="Vcl_Type_Other" id="Vcl_Type_Other" type="text"/></div>')
    a_arr.push('            </td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td nowrap="nowrap"><input value="保存" class="submitButton"')
    a_arr.push('				type="submit" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=310
	N_Dialog_Width=367
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));   
}
function handle_confirm(n_id,s_url) 
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('HandleConfirm');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
	o_ajax_request.PushParameter(s_url);
    parent.parent.Dialog_Confirm("真的要确认解决吗？",function (){o_ajax_request.SendRequest()});
}
function handle_disconfirm(n_id,s_url)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('HandleDisconfirm');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
	o_ajax_request.PushParameter(s_url);
    parent.parent.Dialog_Confirm("此操作将返回待处理状态！<br/>是否继续？",function (){o_ajax_request.SendRequest()});
}
function go_to_url(s_url)
{
	location=s_url
}

function add_zc(){
    if (document.getElementById ('Vcl_Date').value==''){
        parent.parent.Dialog_Message('[ 日期 ] 不能为空 ！');
        return
    }
	if (document.getElementById ('Vcl_Title').value==''){
        parent.parent.Dialog_Message('[ 标题 ] 不能为空 ！');
        return
    }
    document.getElementById ('Vcl_Content').value=UE.getEditor('editor').getContent()
    var s_content=document.getElementById ('Vcl_Content').value
    if (s_content.length<10){
        parent.parent.Dialog_Message('对不起 , 文章内容太少 !');
        return
    }
	parent.parent.Dialog_Confirm("真的要发起督查吗？<br/>发起后将不能修改与删除。",function (){document.getElementById('dialog_form').submit();parent.parent.Common_OpenLoading(); });    
    
	  
}
function zc_reject(){
    if (document.getElementById ('Vcl_Reason').value==''){
        parent.parent.Dialog_Message('[ 退回意见 ] 不能为空 ！');
        return
    }
	parent.parent.Dialog_Confirm("真的要退回吗？",function (){document.getElementById('dialog_form').submit();parent.parent.Common_OpenLoading(); });      
}
function dc_reject(){
    if (document.getElementById ('Vcl_Reason2').value==''){
        parent.parent.Dialog_Message('[ 退回意见 ] 不能为空 ！');
        return
    }
	parent.parent.Dialog_Confirm("真的要退回吗？",function (){document.getElementById('dialog_form').submit();parent.parent.Common_OpenLoading(); });      
}
function dc_auditor_reject(){
    if (document.getElementById ('Vcl_Reason1').value==''){
        parent.parent.Dialog_Message('[ 退回意见 ] 不能为空 ！');
        return
    }
	parent.parent.Dialog_Confirm("真的要退回这个督查吗？",function (){document.getElementById('dialog_form').submit();parent.parent.Common_OpenLoading(); });      
}
function dc_auditor_feedback(){
    if (document.getElementById ('Vcl_OwnerFeedback').value==''){
        parent.parent.Dialog_Message('[ 审批通过意见 ] 不能为空 ！');
        return
    }
	parent.parent.Dialog_Confirm("真的要审批通过吗？",function (){document.getElementById('dialog_form_feedback').submit();parent.parent.Common_OpenLoading(); });      
}
function zc_feedback(){
    document.getElementById ('Vcl_Content').value=UE.getEditor('editor').getContent()
    var s_content=document.getElementById ('Vcl_Content').value
    if (s_content.length<10){
        parent.parent.Dialog_Message('对不起 , 反馈内容太少 !');
        return
    }
	parent.parent.Dialog_Confirm("真的要提交反馈吗？",function (){document.getElementById('dialog_form').submit();parent.parent.Common_OpenLoading(); });    
}
function dc_summary(){
    document.getElementById ('Vcl_Content').value=UE.getEditor('editor').getContent()
    var s_content=document.getElementById ('Vcl_Content').value
    if (s_content.length<10){
        parent.parent.Dialog_Message('对不起 , 汇总内容太少 !');
        return
    }
	parent.parent.Dialog_Confirm("真的要提交汇总结果吗？<br/>提交后督查任务将会归档，<br/>不得修改。",function (){document.getElementById('dialog_form').submit();parent.parent.Common_OpenLoading(); });    
}
function dc_feedback(){
    document.getElementById ('Vcl_Content').value=UE.getEditor('editor').getContent()
    var s_content=document.getElementById ('Vcl_Content').value
    if (s_content.length<10){
        parent.parent.Dialog_Message('对不起 , 反馈内容太少 !');
        return
    }
	parent.parent.Dialog_Confirm("真的要提交反馈吗？",function (){document.getElementById('dialog_form').submit();parent.parent.Common_OpenLoading(); });    
}
function zc_delete(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ZcDelete');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除吗？",function (){o_ajax_request.SendRequest()});
}
function zc_confirm(n_id,s_url)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ZcConfirm');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
	o_ajax_request.PushParameter(s_url);
    parent.parent.Dialog_Confirm("真的要确认完成吗？",function (){o_ajax_request.SendRequest()});
}
function dc_delete(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DcDelete');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除吗？",function (){o_ajax_request.SendRequest()});
}
function dc_confirm(n_id,s_url)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DcConfirm');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
	o_ajax_request.PushParameter(s_url);
    parent.parent.Dialog_Confirm("真的要确认完成吗？",function (){o_ajax_request.SendRequest()});
}
S_Root='../../';
var Command=new Array();
Command.push("refresh_menu_notice('sub_telephone_nav_php',S_Root+'sub/telephone/include/it_ajax.svr.php');");
Command.push("refresh_menu_notice('sub_gpdd_wenti_nav_php',S_Root+'sub/gpdd_wenti/include/it_ajax.svr.php',1);");
Command.push("refresh_menu_notice('sub_gpdd_wenti_gpdd_php',S_Root+'sub/gpdd_wenti/include/it_ajax.svr.php',2);");
refresh_menu_notice('sub_gpdd_huodong_nav_php',S_Root+'sub/gpdd_huodong/include/it_ajax.svr.php');