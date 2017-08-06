/*--------我的会议相关--------*/
function chapter_add() {

    if ($('#Vcl_Title').val() == '') {
        parent.parent.Dialog_Message('测评表名称不能为空！！')
        return;
    }
    var b=false
    for(var i=1;i<20;i++)
    {
        if ($('#Vcl_Type'+i).is(':checked'))
        {
            b=true
        }
    }
    if (b==false) {
        parent.parent.Dialog_Message('测评对象不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function change_type(obj)
{
	$('#type_0 input').attr("checked", false);
	$('#type_1 input').attr("checked", false);
	$('#type_2 input').attr("checked", false);
	$('#type_0').hide()
	$('#type_1').hide()
	$('#type_2').hide()
	
	
	if (obj.value==0)
	{
		$('#type_0').show()	
	}
	if (obj.value==1)
	{
		$('#type_1').show()	
	}
	if (obj.value==2)
	{
		$('#type_2').show()	
	}
}
function chapter_delete(id) {
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('ChapterDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm('是否确定删除这个测评表？',function(){o_ajax_request.SendRequest();parent.parent.Common_OpenLoading()})
    
}
function dept_delete(id) {
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('DeptDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm('是否确定禁用这个单位？',function(){o_ajax_request.SendRequest()})
}
function item_setnumber(id,number)
{
    parent.parent.Common_OpenLoading()
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction ('ItemSetNumber');
    o_ajax_request.setParameter('Id', id);
    o_ajax_request.setParameter('Number', number);;
    o_ajax_request.SendRequest()
}
function item_delete(id) {
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('ItemDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm('是否确定删除这道题？',function(){o_ajax_request.SendRequest();parent.parent.Common_OpenLoading()})
    
}
function item_single_add() {

    if ($('#Vcl_Content').val() == '') {
        parent.parent.Dialog_Message('题目不能为空！！')
        return;
    }
    if ($('#Vcl_Option_A').val() == '') {
        parent.parent.Dialog_Message('选项不能为空！！')
        return;
    }
    if ($('#Vcl_Type').val() == null) {
        parent.parent.Dialog_Message('类型不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function item_score_add() {

    if ($('#Vcl_Content').val() == '') {
        parent.parent.Dialog_Message('题目不能为空！！')
        return;
    }
    if ($('#Vcl_Option_A').val() == '') {
        parent.parent.Dialog_Message('选项不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function my_meeting_change_open(state,id) {
    parent.parent.Common_OpenLoading()
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('ConferenceMyChangeOpen');
    o_ajax_request.setParameter('State', state);
    o_ajax_request.setParameter('Id', id);
    o_ajax_request.SendRequest();
}
function my_meeting_change_reg(state,id) {
    parent.parent.Common_OpenLoading()
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('ConferenceMyChangeReg');
    o_ajax_request.setParameter('State', state);
    o_ajax_request.setParameter('Id', id);
    o_ajax_request.SendRequest();
}
function my_meeting_change_reg(state,id) {
    parent.parent.Common_OpenLoading()
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('ConferenceMyChangeReg');
    o_ajax_request.setParameter('State', state);
    o_ajax_request.setParameter('Id', id);
    o_ajax_request.SendRequest();
}
function my_meeting_delete(id) {
    
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('ConferenceMyDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm('是否确定删除这个会议？',function(){o_ajax_request.SendRequest();parent.parent.Common_OpenLoading()})
    
}
function add_my_meeting_area_submit() {
    if ($('#Vcl_Name').val() == '') {
        parent.parent.Dialog_Message('姓名不能为空！！')
        return;
    }
    if ($('#Vcl_Telphone').val() == '') {
        parent.parent.Dialog_Message('电话不能为空！！')
        return;
    }
    if ($('#Vcl_Address').val() == '') {
        parent.parent.Dialog_Message('地址不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function add_my_meeting_area_delete(id) {

    var o_ajax_request = new AjaxPostRequest();
    o_ajax_request.setFunction('ConferenceMyAreaDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm('是否确定删除地点？', function () { o_ajax_request.SendRequest(); parent.parent.Common_OpenLoading() })

}
function my_meeting_area_image_delete(id) {

    var o_ajax_request = new AjaxPostRequest();
    o_ajax_request.setFunction('ConferenceMyAreaImageDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm('是否确定删除这个会场？', function () { o_ajax_request.SendRequest(); parent.parent.Common_OpenLoading() })
}
function add_my_meeting_area_image_submit() {
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function add_my_meeting_speaker_submit() {
    if ($('#Vcl_Name').val() == '') {
        parent.parent.Dialog_Message('姓名不能为空！！')
        return;
    }
    if ($('#Vcl_Position').val() == '') {
        parent.parent.Dialog_Message('职务不能为空！！')
        return;
    }
    if ($('#Vcl_Company').val() == '') {
        parent.parent.Dialog_Message('公司不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function my_meeting_speaker_delete(id) {
    
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('ConferenceMySpeakerDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm('是否确定删除这个演讲人？',function(){o_ajax_request.SendRequest();parent.parent.Common_OpenLoading()})
    
}
function add_meeting_date_submit() {

    if ($('#Vcl_Title').val() == '') {
        parent.parent.Dialog_Message('名称不能为空！！')
        return;
    }
    if ($('#Vcl_Date').val() == '') {
        parent.parent.Dialog_Message('电话不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function my_meeting_date_delete(id) {
    
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('ConferenceMyDateDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm('是否确定删除这个日期？',function(){o_ajax_request.SendRequest();parent.parent.Common_OpenLoading()})

}
function my_meeting_date_agenda_delete(id) {

    var o_ajax_request = new AjaxPostRequest();
    o_ajax_request.setFunction('ConferenceMyDateAgendaDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm('是否确定删除这个日程？', function () { o_ajax_request.SendRequest(); parent.parent.Common_OpenLoading() })

}
function add_my_meeting_date_agenda_submit() {

    if ($('#Vcl_Title').val() == '') {
        parent.parent.Dialog_Message('演讲标题不能为空！！')
        return;
    }
    if ($('#Vcl_Date').val() == '') {
        parent.parent.Dialog_Message('演讲时间不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
/*---联系人相关-----*/
function add_meeting_contacter_submit() {

    if ($('#Vcl_Name').val() == '') {
        parent.parent.Dialog_Message('姓名不能为空！！')
        return;
    }
    if ($('#Vcl_Telphone').val() == '') {
        parent.parent.Dialog_Message('电话不能为空！！')
        return;
    }
    if ($('#Vcl_Email').val() == '') {
        parent.parent.Dialog_Message('邮箱不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function my_meeting_contacter_delete(id) {
    
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('ConferenceMyContacterDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm('是否确定删除这个联系人？',function(){o_ajax_request.SendRequest();parent.parent.Common_OpenLoading()})
    
}
/*---演讲人库相关-----*/
function add_speaker_submit() {
    if ($('#Vcl_Name').val() == '') {
        parent.parent.Dialog_Message('姓名不能为空！！')
        return;
    }
    if ($('#Vcl_Position').val() == '') {
        parent.parent.Dialog_Message('职务不能为空！！')
        return;
    }
    if ($('#Vcl_Company').val() == '') {
        parent.parent.Dialog_Message('公司不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function speaker_delete(id) {
    
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('ConferenceSpeakerDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm('是否确定删除这个演讲人？',function(){o_ajax_request.SendRequest();parent.parent.Common_OpenLoading()})
    
}
/*---部门相关-----*/
function add_department_submit() {
    if ($('#Vcl_Name').val() == '') {
        parent.parent.Dialog_Message('名称不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function department_delete(id) {
    
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('ConferenceDepartmentDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm('是否确定删除这个部门？',function(){o_ajax_request.SendRequest();parent.parent.Common_OpenLoading()})
    
}
/*---会议地点库相关-----*/
function add_area_submit() {
    if ($('#Vcl_Name').val() == '') {
        parent.parent.Dialog_Message('姓名不能为空！！')
        return;
    }
    if ($('#Vcl_Telphone').val() == '') {
        parent.parent.Dialog_Message('电话不能为空！！')
        return;
    }
    if ($('#Vcl_Address').val() == '') {
        parent.parent.Dialog_Message('地址不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function area_delete(id) {
    
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('ConferenceAreaDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm('是否确定删除这个地点？',function(){o_ajax_request.SendRequest();parent.parent.Common_OpenLoading()})
}
function add_area_image_submit() {
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function area_image_delete(id) {

    var o_ajax_request = new AjaxPostRequest();
    o_ajax_request.setFunction('ConferenceAreaImageDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm('是否确定删除这个会场？', function () { o_ajax_request.SendRequest(); parent.parent.Common_OpenLoading() })
}
function date_submit() {
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function type_submit() {
    if ($('#Vcl_Number').val() == '') {
        parent.parent.Dialog_Message('对象编号不能为空！！')
        return;
    }
    if ($('#Vcl_Name').val() == '') {
        parent.parent.Dialog_Message('对象名称不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function detp_add() {
    if ($('#Vcl_Name').val() == '') {
        parent.parent.Dialog_Message('单位名称不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function detp_modify() {
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
