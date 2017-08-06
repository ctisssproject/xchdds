
function submitRecordAdd(){
	var temp = document.getElementById('Vcl_RecordDate').value;
	if (temp.length == 0) {
		parent.parent.Dialog_Message("[ 来电日期 ] 不能为空")
		return
	}
	temp = document.getElementById('Vcl_RecordTime').value;
	if (temp.length == 0) {
		parent.parent.Dialog_Message("[ 来电时间 ] 不能为空")
		return
	}
	temp = document.getElementById('Vcl_Name').value;
	if (temp.length == 0) {
		parent.parent.Dialog_Message("[ 姓名 ] 不能为空")
		return
	}
	temp = document.getElementById('Vcl_SchoolName').value;
	if (temp.length == 0) {
		parent.parent.Dialog_Message("[ 来源学校 ] 不能为空")
		return
	}
	temp = document.getElementById('Vcl_ProfileId').value;
	if (temp.length == 0) {
		parent.parent.Dialog_Message("[ 身份 ] 不能为空")
		return
	}
	temp = document.getElementById('Vcl_Phone').value;
	if (temp.length == 0) {
		//parent.parent.Dialog_Message("[ 来电号码 ] 不能为空")
		//return
	}
	temp = document.getElementById('Vcl_Content').value;
	if (temp.length == 0) {
		parent.parent.Dialog_Message("[ 来电记录 ] 不能为空")
		return
	}
	temp = document.getElementById('Vcl_SendType').value;
	if (temp == '1') {
		temp = document.getElementById('Vcl_HandleDate').value;
		if (temp.length == 0) {
			parent.parent.Dialog_Message("[ 处理过程及结果的时间 ] 不能为空")
			return
		}
		temp = document.getElementById('Vcl_Progress').value;
		if (temp.length == 0) {
			parent.parent.Dialog_Message("[ 处理过程及结果 ] 不能为空")
			return
		}
	}
	parent.parent.Common_OpenLoading();
	document.getElementById('dialog_form').submit();
}
function submitRecordModify()
{
    var temp=document.getElementById('Vcl_RecordDate').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 来电日期 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_RecordTime').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 来电时间 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_Name').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 姓名 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_ProfileId').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 身份 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_Phone').value;
    if (temp.length==0){
        //parent.parent.Dialog_Message("[ 来电号码 ] 不能为空")
       // return
    }
    temp=document.getElementById('Vcl_Content').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 来电记录 ] 不能为空")
        return
    }
        temp=document.getElementById('Vcl_HandleDate').value;
        if (temp.length==0){
            parent.parent.Dialog_Message("[ 处理过程及结果的时间 ] 不能为空")
            return
        }
        temp=document.getElementById('Vcl_Progress').value;
        if (temp.length==0){
            parent.parent.Dialog_Message("[ 处理过程及结果 ] 不能为空")
            return
        }
	parent.parent.Common_OpenLoading();
   document.getElementById('dialog_form').submit();
}

function record_delete(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('RecordDelete');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除这条记录吗？",function (){o_ajax_request.SendRequest()});
}
function altSet(obj)
{
    obj.parentNode.parentNode.getElementsByTagName('input')[0].value=obj.innerHTML
    $('.alt').hide()
    //altClose(obj.parentNode.parentNode.getElementsByTagName('input')[0])
}
function altClose()
{
	setTimeout("$('.alt').hide()",500)    
}
function altGet(fun,id,obj)
{
	//window.alert();
    if (obj.value=='')
    {
        document.getElementById(id).style.display='none'
        return
    }
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction (fun);
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(id);
    o_ajax_request.PushParameter(obj.value);
    o_ajax_request.SendRequest()     
}
function altGetCallback(id,html)
{

    if (html=='')
    {
        document.getElementById(id).innerHTML=html
        document.getElementById(id).style.display='none'
        return
    }
    document.getElementById(id).innerHTML=html
    document.getElementById(id).style.display='block'
}
function niming(obj)
{
    if (obj.checked)
    {
        $('#Vcl_Name').val('匿名')
        $('#Vcl_Name').attr('readonly',true); 
    }else{
        $('#Vcl_Name').val('')
        $('#Vcl_Name').attr('readonly',false); 
    }
}
function xinsheng(obj)
{
    if (obj.checked)
    {
        $('#Vcl_SchoolName').val('新生')
        $('#Vcl_SchoolName').attr('readonly',true); 
		$('#type_list').html('<select name="Vcl_SendType" id="Vcl_SendType" class="BigSelect" onchange="change_sendtype(this)"><option value="1" selected="selected">自行处理</option><option value="2">转责任督学</option></select>')
    }else{
        $('#Vcl_SchoolName').val('')
        $('#Vcl_SchoolName').attr('readonly',false); 
		$('#type_list').html('<select name="Vcl_SendType" id="Vcl_SendType" class="BigSelect" onchange="change_sendtype(this)"><option value="1" selected="selected">自行处理</option><option value="2">转责任督学</option><option value="3">转协同办理</option></select>')
    }
}
function change_sendtype(obj)
{
    if (obj.value=='1')
    {
        $('#result').show()
    }else{
        $('#result').hide()
    }
}

function submitDudaoModify(status)
{
    var temp=document.getElementById('Vcl_Dd').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 督导室处理建议 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_DdQz').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 主管领导 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_Jgw').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 教工委、教委意见 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_JgwQz').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 主管领导 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_Cljg').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 最终处理结果 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_Cbr').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 承办人 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_CbDate').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 完成时间] 不能为空")
        return
    }
    document.getElementById('Vcl_Completed').value=status
    document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
}
function total_submit()
{
    var temp=document.getElementById('Vcl_Start').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 开始时间 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_End').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 结束时间 ] 不能为空")
        return
    }
    document.getElementById('dialog_form').submit();
}
function export_submit()
{
	var start=document.getElementById('Vcl_Start').value;
	var end=document.getElementById('Vcl_End').value;
    window.open('output.php?start='+start+'&end='+end,'_blank');
}
function dudao_delete(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DudaoDelete');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除这条记录吗？",function (){o_ajax_request.SendRequest()});
}
S_Root='../../';
var Command=new Array();
Command.push("refresh_menu_notice('sub_telephone_nav_php',S_Root+'sub/telephone/include/it_ajax.svr.php');");
Command.push("refresh_menu_notice('sub_gpdd_wenti_nav_php',S_Root+'sub/gpdd_wenti/include/it_ajax.svr.php',1);");
Command.push("refresh_menu_notice('sub_gpdd_wenti_gpdd_php',S_Root+'sub/gpdd_wenti/include/it_ajax.svr.php',2);");
refresh_menu_notice('sub_gpdd_huodong_nav_php',S_Root+'sub/gpdd_huodong/include/it_ajax.svr.php');




