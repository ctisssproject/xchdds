function nameAddBold(o_obj)
{

    var a_a=document.getElementsByTagName('a')
    for (var i=0; i<a_a.length;i++)
    {
        a_a[i].style.fontWeight='normal'
    }
    o_obj.style.fontWeight='bold'
}
function refreshPath(n_id)
{
//debugger
    var o_obj=document.getElementById('path_'+n_id)
    nameAddBold(o_obj)
    O_Obj.push(o_obj.parentNode.parentNode)
    var a_obj=o_obj.parentNode.getElementsByTagName('img')
    a_obj[0].src='../../images/file_tree/minus.gif'
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('MyDisk_GetPath');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.SendRequest()
}
function refreshPathShare(n_id)
{
//debugger
    var o_obj=document.getElementById('path_'+n_id)
    nameAddBold(o_obj)
    O_Obj.push(o_obj.parentNode.parentNode)
    var a_obj=o_obj.parentNode.getElementsByTagName('img')
    a_obj[0].src='../../images/file_tree/minus.gif'
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('Share_GetPath');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.SendRequest()
}
function refreshPathShareUser(n_id)
{
//debugger
    var o_obj=document.getElementById('user_'+n_id)
    nameAddBold(o_obj)
    O_Obj.push(o_obj.parentNode.parentNode)
    var a_obj=o_obj.parentNode.getElementsByTagName('img')
    a_obj[0].src='../../images/file_tree/minus.gif'
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('Share_GetRoot');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.SendRequest()
}
function refreshPathNoBold(n_id)
{
//debugger
    var o_obj=document.getElementById('path_'+n_id)
    O_Obj.push(o_obj.parentNode.parentNode)
    var a_obj=o_obj.parentNode.getElementsByTagName('img')
    a_obj[0].src='../../images/file_tree/minus.gif'
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('MyDisk_GetPath');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.SendRequest()
}
function openPath(o_obj,n_id)
{
    //debugger
    openPathSend(o_obj,n_id,'MyDisk_GetPath')
}
function openPathShareRoot(o_obj,n_id)
{
    //debugger
    openPathSend(o_obj,n_id,'Share_GetRoot')
}
function openPathShare(o_obj,n_id)
{
    //debugger
    openPathSend(o_obj,n_id,'Share_GetPath')
}
function openPathSend(o_obj,n_id,s_function)
{
    var temp_obj=o_obj.parentNode.parentNode.getElementsByTagName('ul')
    if (temp_obj.length>0)
    {
    //如果已经有了，就隐藏否则读取子目录
        if (temp_obj[0].style.display=='none')
        {
        //如果已经隐藏，则显示，否则隐藏
            temp_obj[0].style.display='block'
            temp_obj=temp_obj[0].parentNode.getElementsByTagName('img')
            temp_obj[0].src='../../images/file_tree/minus.gif'    
        }else{
            temp_obj[0].style.display='none'
            temp_obj=temp_obj[0].parentNode.getElementsByTagName('img')
            temp_obj[0].src='../../images/file_tree/plus.gif'    
        }
    
    }else{
        O_Obj.push(o_obj.parentNode.parentNode)
        var a_obj=o_obj.parentNode.getElementsByTagName('img')
        a_obj[0].src='../../images/file_tree/minus.gif'
        a_obj[2].style.display='block'
        var o_ajax_request=new AjaxRequest();
        o_ajax_request.setFunction (s_function);
        o_ajax_request.setPage('include/it_ajax.svr.php');
        o_ajax_request.PushParameter(n_id);
        o_ajax_request.SendRequest()
    }
}
function callbackOpenPath(s_name,s_id)
{
    var o_obj=O_Obj.pop(0)
    if (s_name=='')
    {
        var temp_obj=o_obj.getElementsByTagName('ul')
        if (temp_obj.length>0)
        {
            o_obj.removeChild(temp_obj[0])
        }
        o_obj=o_obj.getElementsByTagName('span')
        o_obj=o_obj[0].getElementsByTagName('img')
        o_obj[2].style.display='none'//隐藏loading
        o_obj[0].src='../../images/file_tree/none.png'
        //o_obj[0].parentNode.innerHTML='<img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" style="display:none"/>'+o_obj[0].parentNode.innerHTML
        return
    } 
    o_obj.getElementsByTagName('span')[0].getElementsByTagName('img')[2].style.display='none'//隐藏loading
    var a_name=s_name.split("<1>")
    var a_id=s_id.split("<1>")
    var a_arr=[];
    a_arr.push('<ul>')
    for (var i=0; i<a_name.length;i++)
    {
        a_arr.push('<li style="display:block">')
        a_arr.push('<span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">')
        a_arr.push('<img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" onclick="openPath(this,'+a_id[i]+')" />')
        a_arr.push('<img src="../../images/notify_open.gif" alt="" align="absmiddle"/>')
        a_arr.push('<a id="path_'+a_id[i]+'" href="#" title="'+a_name[i]+'" style=" font-weight:normal" ondblclick="openPath(this,'+a_id[i]+')" onclick="nameAddBold(this);goTo(\'explorer.php?folderid='+a_id[i]+'\');document.getElementById(\'Vcl_FolderId\').value='+a_id[i]+';">')
        a_arr.push(a_name[i])
        a_arr.push('</a>')
        a_arr.push('<img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>')
        a_arr.push('</span>')
        a_arr.push('</li>')
    }
    a_arr.push('</ul>')
    var html=a_arr.join('\n');
    //debugger
    //window.alert(html)
    //如果已经存在UL，则先删除
    var temp_obj=o_obj.getElementsByTagName('ul')
    if (temp_obj.length>0)
    {
        o_obj.removeChild(temp_obj[0])
    }
    o_obj.innerHTML=o_obj.innerHTML+html;     
}
function callbackOpenPathShare(s_name,s_id)
{
    var o_obj=O_Obj.pop(0)
    if (s_name=='')
    {
        var temp_obj=o_obj.getElementsByTagName('ul')
        if (temp_obj.length>0)
        {
            o_obj.removeChild(temp_obj[0])
        }
        o_obj=o_obj.getElementsByTagName('span')
        o_obj=o_obj[0].getElementsByTagName('img')
        o_obj[2].style.display='none'//隐藏loading
        o_obj[0].src='../../images/file_tree/none.png'
        //o_obj[0].parentNode.innerHTML='<img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" style="display:none"/>'+o_obj[0].parentNode.innerHTML
        return
    } 
    o_obj.getElementsByTagName('span')[0].getElementsByTagName('img')[2].style.display='none'//隐藏loading
    var a_name=s_name.split("<1>")
    var a_id=s_id.split("<1>")
    var a_arr=[];
    a_arr.push('<ul>')
    for (var i=0; i<a_name.length;i++)
    {
        a_arr.push('<li style="display:block">')
        a_arr.push('<span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">')
        a_arr.push('<img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" onclick="openPathShare(this,'+a_id[i]+')" />')
        a_arr.push('<img src="../../images/notify_open.gif" alt="" align="absmiddle"/>')
        a_arr.push('<a id="path_'+a_id[i]+'" href="#" title="'+a_name[i]+'" style=" font-weight:normal" ondblclick="openPathShare(this,'+a_id[i]+')" onclick="nameAddBold(this);goTo(\'explorer_share.php?folderid='+a_id[i]+'\');document.getElementById(\'Vcl_FolderId\').value='+a_id[i]+';">')
        a_arr.push(a_name[i])
        a_arr.push('</a>')
        a_arr.push('<img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none"/>')
        a_arr.push('</span>')
        a_arr.push('</li>')
    }
    a_arr.push('</ul>')
    var html=a_arr.join('\n');
    //debugger
    //window.alert(html)
    //如果已经存在UL，则先删除
    var temp_obj=o_obj.getElementsByTagName('ul')
    if (temp_obj.length>0)
    {
        o_obj.removeChild(temp_obj[0])
    }
    o_obj.innerHTML=o_obj.innerHTML+html;  
    
}
var O_Obj=new Array()

///////////////////////////////////////////////////////////////////////////////////上传文件////////////////////////////////////////////////////////////////////
function uploadFile(n_id){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=UploadFile"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:400px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title" style="width: 380px">');
    a_arr.push('            上传文件');
    a_arr.push('        </td>');
    a_arr.push('        <td>');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('       </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock" align="center" width="100%">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;文件：</td>')
    a_arr.push('			<td class="TableData"><iframe id="upload_file" style="width: 250px;height: 20px;" src="file_upload.php" marginwidth="0" marginheight="0" frameborder="0" framespacing="0" border="0" scrolling="no"></iframe></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;关键词：</td>')
    a_arr.push('			<td class="TableData"><input id="Vcl_KeyWord1" name="Vcl_KeyWord1"')
    a_arr.push('				size="30" maxlength="50" class="BigInput"')
    a_arr.push('				value="" type="text" /><input id="Vcl_KeyWord" name="Vcl_KeyWord"')
    a_arr.push('				size="30" maxlength="50" class="BigInput"')
    a_arr.push('				value="" type="text" style="display:none" /> （可选）')
    a_arr.push('			    <input id="Vcl_FolderId" name="Vcl_FolderId"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_id+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input id="Vcl_Submit" value="上传" class="submitButton"')
    a_arr.push('				onclick="uploadTempFile()" type="button" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="uploadCancel()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=350
	N_Dialog_Width=417
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n')); 
}
function uploadCancel()
{
    document.getElementById("upload_file").src="file_upload.php"
    Common_CloseDialog()
}
function uploadTempFile()
{
    document.getElementById("upload_file").contentWindow.uploadStart(document.getElementById("Vcl_FolderId").value) 
    document.getElementById("Vcl_Submit").disabled="disabled"
    document.getElementById("Vcl_KeyWord1").disabled="disabled"
}
function uploadTempFileCallback(s_text)
{
    document.getElementById("Vcl_Submit").disabled=""
    document.getElementById("Vcl_KeyWord1").disabled=""
    document.getElementById("upload_file").src="file_upload.php"
    parent.parent.Dialog_Error(s_text)
}
function uploadSubmit()
{
    document.getElementById("Vcl_KeyWord").value=document.getElementById("Vcl_KeyWord1").value
    document.getElementById('dialog_form').submit();
}
function uploadSuccessCallback(n_id)
{
    Common_CloseDialog()
    parent.parent.Dialog_Confirm("上传文件成功！<br/>是否继续？",function (){uploadFile(n_id)});
    document.getElementById("filelist").src='filelist.php?folderid='+n_id
}