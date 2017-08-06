////////////////////////////////////////////////////////首页管理-最新动态////////////////////////////////////////////////////////////////////
function scrollSubmit()
{
    var s_temp=document.getElementById('Vcl_ArticleId').value
    if (s_temp.length==0)
    {
        parent.parent.Dialog_Message("[ 文章编号 ] 不能为空！")
        return
    }
    document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
}
function goLocation(url)
{
	//window.alert(url)
	location=url;
}
function deleteScroll()
{
    var n_id='';
    for(var i = 1; i < 100; i++){
        var o_check=document.getElementById('check_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            n_id=n_id+o_check.value+'<1>';
        }        
    }
    if (n_id=='')
    {
        parent.parent.Dialog_Message('请选择要删除的滚动！');
        return
    } 
    n_id=n_id.substr(0,n_id.length-3)
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeleteScroll');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除选择的滚动吗？",function (){o_ajax_request.SendRequest()});
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////首页管理-焦点图片////////////////////////////////////////////////////////////////////
function modifyFocus()
{
    var s_temp=document.getElementById('Vcl_ArticleId').value
    if (s_temp.length==0)
    {
        parent.parent.Dialog_Message("[ 文章编号 ] 不能为空！")
        return
    }
    var s_temp=document.getElementById('Vcl_Title').value
    if (s_temp.length==0)
    {
        parent.parent.Dialog_Message("[ 显示标题 ] 不能为空！")
        return
    }
    document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
}
function modifyBigFocus()
{
    document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
}
function deleteFocus()
{
    var n_id='';
    for(var i = 1; i < 100; i++){
        var o_check=document.getElementById('check_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            n_id=n_id+o_check.value+'<1>';
        }        
    }
    if (n_id=='')
    {
        parent.parent.Dialog_Message('请选择要删除的焦点图片！');
        return
    } 
    n_id=n_id.substr(0,n_id.length-3)
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeleteFocus');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除选择的焦点图片吗？",function (){o_ajax_request.SendRequest()});
}
function deleteBigFocus()
{
    var n_id='';
    for(var i = 1; i < 100; i++){
        var o_check=document.getElementById('check_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            n_id=n_id+o_check.value+'<1>';
        }        
    }
    if (n_id=='')
    {
        parent.parent.Dialog_Message('请选择要删除的图片！');
        return
    } 
    n_id=n_id.substr(0,n_id.length-3)
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeleteBigFocus');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除选择的图片吗？",function (){o_ajax_request.SendRequest()});
}
function addPhoto()
{
    var s_temp=document.getElementById('Vcl_Text').value
    if (s_temp.length==0)
    {
        parent.parent.Dialog_Message("[ 图片标题 ] 不能为空！")
        return
    }
    document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
}
function deletePhoto()
{
    var n_id='';
    for(var i = 1; i < 100; i++){
        var o_check=document.getElementById('check_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            n_id=n_id+o_check.value+'<1>';
        }        
    }
    if (n_id=='')
    {
        parent.parent.Dialog_Message('请选择要删除的图片！');
        return
    } 
    n_id=n_id.substr(0,n_id.length-3)
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeletePhoto');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除选择的图片吗？",function (){o_ajax_request.SendRequest()});
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////首页管理-栏目显示//////////////////////////////////////////////////
function indexcolumnSubmit()
{
    var s_temp=document.getElementById('Vcl_ColumnId').value
    if (s_temp.length==0)
    {
        parent.parent.Dialog_Message("[ 栏目编号 ] 不能为空！")
        return
    }
    document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////首页管理-友情链接////////////////////////////////////////////////////////////////////
function modifyLink()
{
    var s_temp=document.getElementById('Vcl_Name').value
    if (s_temp.length==0)
    {
        parent.parent.Dialog_Message("[ 名称 ] 不能为空！")
        return
    }
    var s_temp=document.getElementById('Vcl_Url').value
    if (s_temp.length==0)
    {
        parent.parent.Dialog_Message("[ 网址 ] 不能为空！")
        return
    }
    document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
}
function deleteLink()
{
    var n_id='';
    for(var i = 1; i < 100; i++){
        var o_check=document.getElementById('check_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            n_id=n_id+o_check.value+'<1>';
        }        
    }
    if (n_id=='')
    {
        parent.parent.Dialog_Message('请选择要删除的友情链接！');
        return
    } 
    n_id=n_id.substr(0,n_id.length-3)
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeleteLink');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除选择的友情链接吗？",function (){o_ajax_request.SendRequest()});
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////首页管理-底部栏目////////////////////////////////////////////////////////////////////
function modifyFooter()
{
    var s_temp=document.getElementById('Vcl_Title').value
    if (s_temp.length==0)
    {
        parent.parent.Dialog_Message("[ 标题 ] 不能为空！")
        return
    }
    document.getElementById ('Vcl_Content').value=UE.getEditor('editor').getContent()
    var s_content=document.getElementById ('Vcl_Content').value
    if (s_content.length<10){
        //parent.parent.Dialog_Message('对不起 , 文章内容太少 !');
        //return
    }   
    document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
}
function deleteFooter()
{
    var n_id='';
    for(var i = 1; i < 100; i++){
        var o_check=document.getElementById('check_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            n_id=n_id+o_check.value+'<1>';
        }        
    }
    if (n_id=='')
    {
        parent.parent.Dialog_Message('请选择要删除的文章！');
        return
    } 
    n_id=n_id.substr(0,n_id.length-3)
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeleteFooter');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除选择的文章吗？",function (){o_ajax_request.SendRequest()});
}
function deleteFloat()
{
    var n_id='';
    for(var i = 1; i < 100; i++){
        var o_check=document.getElementById('check_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            n_id=n_id+o_check.value+'<1>';
        }        
    }
    if (n_id=='')
    {
        parent.parent.Dialog_Message('请选择要删除的文章！');
        return
    } 
    n_id=n_id.substr(0,n_id.length-3)
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeleteFloat');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除选择的文章吗？",function (){o_ajax_request.SendRequest()});
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////栏目管理////////////////////////////////////////////////////////////
function submitColumn()
{

    var s_temp=document.getElementById('Vcl_Name').value
    if (s_temp.length==0)
    {
        parent.parent.Dialog_Message("[ 栏目名称 ] 不能为空！")
        return
    }
    document.getElementById('dialog_form').submit();
    if (!is_moz){
        Common_OpenLoading();   
    }
}
function deleteColumn(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeleteColumn');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除这个栏目吗？",function (){o_ajax_request.SendRequest()});
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////文章管理////////////////////////////////////////////////////////////
function articleAudit(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ArticleAudit');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id,document.getElementById ('Vcl_BackUrl').value);
    parent.parent.Dialog_Confirm("真的批准这篇文章吗？",function (){o_ajax_request.SendRequest()});
}
function deleteArticle()
{
    var n_id='';
    for(var i = 1; i < 100; i++){
        var o_check=document.getElementById('check_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked && o_check.value>0)
        {
            n_id=n_id+o_check.value+'<1>';
        }        
    }
    if (n_id=='')
    {
        parent.parent.Dialog_Message('请选择要删除的文章！');
        return
    } 
    n_id=n_id.substr(0,n_id.length-3)
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeleteArticle');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除选择的文章吗？",function (){o_ajax_request.SendRequest()});
}
function addArticle(){
	var s_title=document.getElementById ('Vcl_Date').value
    if (s_title.length==0){
        parent.parent.Dialog_Message('[ 发布日期 ] 不能为空 ！');
        return
    }
    var s_title=document.getElementById ('Vcl_Title').value
    if (s_title.length==0){
        parent.parent.Dialog_Message('[ 标题 ] 不能为空 ！');
        return
    }
    document.getElementById ('Vcl_Content').value=UE.getEditor('editor').getContent()
    var s_content=document.getElementById ('Vcl_Content').value
    if (s_content.length<10){
        //parent.parent.Dialog_Message('对不起 , 文章内容太少 !');
        //return
    }  
	/*  
    var s_content=document.getElementById ('Vcl_AuditUid').value
    if (s_content==0){
        parent.parent.Dialog_Message('请选择 [ 审核人 ] !');
        return
    } */
    document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    } 
}
function modifyArticle(){
	var s_title=document.getElementById ('Vcl_Date').value
    if (s_title.length==0){
        parent.parent.Dialog_Message('[ 发布日期 ] 不能为空 ！');
        return
    }
    var s_title=document.getElementById ('Vcl_Title').value
    if (s_title.length==0){
        parent.parent.Dialog_Message('[ 标题 ] 不能为空 ！');
        return
    }
    document.getElementById ('Vcl_Content').value=UE.getEditor('editor').getContent()
    var s_content=document.getElementById ('Vcl_Content').value
    if (s_content.length<10){
        //parent.parent.Dialog_Message('对不起 , 文章内容太少 !');
        //return
    }
    document.getElementById('dialog_form').submit();parent.parent.Common_OpenLoading();
}
function modifyArticleMy(){
	var s_title=document.getElementById ('Vcl_Date').value
    if (s_title.length==0){
        parent.parent.Dialog_Message('[ 发布日期 ] 不能为空 ！');
        return
    }
    var s_title=document.getElementById ('Vcl_Title').value
    if (s_title.length==0){
        parent.parent.Dialog_Message('[ 标题 ] 不能为空 ！');
        return
    }
    document.getElementById ('Vcl_Content').value=UE.getEditor('editor').getContent()
    var s_content=document.getElementById ('Vcl_Content').value
    if (s_content.length<10){
        //parent.parent.Dialog_Message('对不起 , 文章内容太少 !');
        //return
    }
    var s_content=document.getElementById ('Vcl_AuditUid').value
    if (s_content==0){
        parent.parent.Dialog_Message('请选择 [ 审核人 ] !');
        return
    } 
    parent.parent.Dialog_Confirm("修改文章后，<br>审核人将会重新审核！<br>是否继续？",function (){document.getElementById('dialog_form').submit();parent.parent.Common_OpenLoading(); });
}
function showArticleReturn(n_id)
{    
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=ArticleReturn"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:300px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            退回原因');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock_Editor" align="center" width="300">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('                <textarea name="Vcl_Reason" id="Vcl_Reason" rows="5" cols="38" class="BigInput"></textarea>')
    a_arr.push('			    <input id="Vcl_ApplyId" name="Vcl_ArticleId"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_id+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td nowrap="nowrap"><input value="确定" class="submitButton"')
    a_arr.push('				onclick="articleReturn()" type="button" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=310
	N_Dialog_Width=317
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
}
function articleReturn()
{
    var s_title=document.getElementById('Vcl_Reason').value
    if (s_title==''){
        parent.parent.Dialog_Message("[ 退回原因 ] 不能为空！")
        return
    }
    document.getElementById('dialog_form').submit()
    if (!is_moz){
        Common_OpenLoading();   
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function deleteMessages()
{
    var n_id='';
    for(var i = 1; i < 100; i++){
        var o_check=document.getElementById('check_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked && o_check.value>0)
        {
            n_id=n_id+o_check.value+'<1>';
        }        
    }
    if (n_id=='')
    {
        parent.parent.Dialog_Message('请选择要删除的留言！');
        return
    } 
    n_id=n_id.substr(0,n_id.length-3)
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeleteMessages');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除选择的留言吗？",function (){o_ajax_request.SendRequest()});
}
function messagesAudit(){
    document.getElementById ('Vcl_Content').value=UE.getEditor('editor').getContent()
    var s_content=document.getElementById ('Vcl_Content').value
    if (s_content.length<10){
        //parent.parent.Dialog_Message('对不起 , 文章内容太少 !');
        //return
    }
    document.getElementById('dialog_form').submit();parent.parent.Common_OpenLoading();
}