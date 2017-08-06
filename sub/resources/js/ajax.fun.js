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
    var o_obj=document.getElementById('share_'+n_id)
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
function refreshPathDirectory(n_id)
{
//debugger
    var o_obj=document.getElementById('path_'+n_id)
    nameAddBold(o_obj)
    O_Obj.push(o_obj.parentNode.parentNode)
    var a_obj=o_obj.parentNode.getElementsByTagName('img')
    a_obj[0].src='../../images/file_tree/minus.gif'
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('Directory_GetPath');
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
    try{parent.parent.Common_OpenLoading()}catch(e){}    
    openPathSend(o_obj,n_id,'MyDisk_GetPath')
}
function openPathShareRoot(o_obj,n_id)
{
    //debugger
    try{parent.parent.Common_OpenLoading()}catch(e){}  
    openPathSend(o_obj,n_id,'Share_GetRoot')
}
function openPathShare(o_obj,n_id)
{
    //debugger
    try{parent.parent.Common_OpenLoading()}catch(e){}  
    openPathSend(o_obj,n_id,'Share_GetPath')
}
function openPathDirectory(o_obj,n_id)
{
    //debugger
    try{parent.parent.Common_OpenLoading()}catch(e){}    
    openPathSend(o_obj,n_id,'Directory_GetPath')
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
        try{parent.parent.Common_CloseDialog()}catch(e){} 
        
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
        try{parent.parent.Common_CloseDialog()}catch(e){} 
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
        a_arr.push('<a id="path_'+a_id[i]+'" href="javascript:;" title="'+a_name[i]+'" style=" font-weight:normal" ondblclick="openPath(this,'+a_id[i]+')" onclick="nameAddBold(this);goTo(\'explorer.php?folderid='+a_id[i]+'\');document.getElementById(\'Vcl_FolderId\').value='+a_id[i]+';">')
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
    try{parent.parent.Common_CloseDialog()}catch(e){}    
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
        try{parent.parent.Common_CloseDialog()}catch(e){} 
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
        a_arr.push('<a id="share_'+a_id[i]+'" href="javascript:;" title="'+a_name[i]+'" style=" font-weight:normal" ondblclick="openPathShare(this,'+a_id[i]+')" onclick="nameAddBold(this);goTo(\'explorer_share.php?folderid='+a_id[i]+'\');document.getElementById(\'Vcl_FolderId\').value='+a_id[i]+';">')
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
    try{parent.parent.Common_CloseDialog()}catch(e){} 
}
function callbackOpenPathDirectory(s_name,s_id)
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
        try{parent.parent.Common_CloseDialog()}catch(e){} 
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
        a_arr.push('<img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" onclick="openPathDirectory(this,'+a_id[i]+')" />')
        a_arr.push('<img src="../../images/notify_open.gif" alt="" align="absmiddle"/>')
        a_arr.push('<a id="path_'+a_id[i]+'" href="javascript:;" title="'+a_name[i]+'" style=" font-weight:normal" ondblclick="openPathDirectory(this,'+a_id[i]+')" onclick="nameAddBold(this);goTo(\'directory_explorer.php?folderid='+a_id[i]+'\');document.getElementById(\'Vcl_FolderId\').value='+a_id[i]+';">')
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
    try{parent.parent.Common_CloseDialog()}catch(e){} 
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
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;描述：</td>')
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
    a_arr.push('				type="button" /><input style="display:none" id="Vcl_Submit" value="批量上传" class="submitButton"')
    a_arr.push('				onclick="uploadMoreFile('+n_id+')" type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
    window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=600
	N_Dialog_Width=417
	o_obj.style.top='-1000px';
	var ch = document.compatMode == "BackCompat"?document.body.clientHeight:document.documentElement.clientHeight;
    var cw = document.compatMode == "BackCompat"?document.body.clientWidth:document.documentElement.clientWidth;
    var st = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    var sl = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
    var _div=document.getElementById("master_box");
    _div.style.top=(st+100)+'px';
    _div.style.left = ((cw - N_Dialog_Width) / 2 +sl)+'px';
	//TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
}
function uploadCancel()
{
    //document.getElementById("upload_file").src="file_upload.php"
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
    Dialog_Confirm("上传文件成功！<br/>是否继续？",function (){uploadFile(n_id)});
    document.getElementById("filelist").src=document.getElementById("filelist").src
}
function searchSubmit(n_folderid)
{
    var temp=$('#Vcl_Search').val();
    if (temp.length==0 || temp=='请输入要搜索的关键字')
    {
        return;
    }
    document.getElementById('filelist').src='filelist_search.php?key='+encodeURIComponent(temp)+'&folderid='+n_folderid
    parent.parent.Common_OpenLoading();
}
function searchSubmitShare(n_folderid)
{
    var temp=$('#Vcl_Search').val();
    if (temp.length==0 || temp=='请输入要搜索的关键字')
    {
        return;
    }
    document.getElementById('filelist').src='filelist_share_search.php?key='+encodeURIComponent(temp)+'&folderid='+n_folderid
    parent.parent.Common_OpenLoading();
}

function uploadLink(n_id){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=UploadLink"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:400px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title" style="width: 380px">');
    a_arr.push('            上传链接');
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
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;文件名：</td>')
    a_arr.push('			<td class="TableData"><input id="Vcl_FileName" name="Vcl_FileName"')
    a_arr.push('				size="30" maxlength="50" class="BigInput"')
    a_arr.push('				value="" type="text" /> *</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;网址：</td>')
    a_arr.push('			<td class="TableData"><input id="Vcl_Url" name="Vcl_Url"')
    a_arr.push('				size="30" maxlength="500" class="BigInput"')
    a_arr.push('				value="" type="text"/> *</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;描述：</td>')
    a_arr.push('			<td class="TableData"><input id="Vcl_KeyWord" name="Vcl_KeyWord"')
    a_arr.push('				size="30" maxlength="50" class="BigInput"')
    a_arr.push('				value="" type="text"/> （可选）')
    a_arr.push('			    <input id="Vcl_FolderId" name="Vcl_FolderId"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_id+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input id="Vcl_Submit" value="上传" class="submitButton"')
    a_arr.push('				onclick="uploadLinkSubmit()" type="button" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
    window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=600
	N_Dialog_Width=417
	o_obj.style.top='-1000px';
	var ch = document.compatMode == "BackCompat"?document.body.clientHeight:document.documentElement.clientHeight;
    var cw = document.compatMode == "BackCompat"?document.body.clientWidth:document.documentElement.clientWidth;
    var st = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    var sl = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
    var _div=document.getElementById("master_box");
    _div.style.top=(st+100)+'px';
    _div.style.left = ((cw - N_Dialog_Width) / 2 +sl)+'px';
	//TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
}
function uploadLinkSubmit()
{
    
    parent.parent.Common_OpenLoading();
    if (document.getElementById('Vcl_FileName').value=='')
    {
        parent.parent.Dialog_Message("[ 文件名 ] 不能为空！")
        return
    }
    if (document.getElementById('Vcl_Url').value=='')
    {
        parent.parent.Dialog_Message("[ 网址 ] 不能为空！")
        return
    }
    document.getElementById('dialog_form').submit();
}
function uploadLinkSuccessCallback(n_id)
{
    Common_CloseDialog()
    Dialog_Confirm("上传链接成功！<br/>是否继续？",function (){uploadLink(n_id)});
    //document.frames('filelist').location.reload()
    document.getElementById("filelist").src=document.getElementById("filelist").src
}
function reloadPage()
{
    document.getElementById("filelist").src=document.getElementById("filelist").src
}



///////////////////////////////////////////////////////////////////////////////////批量上传文件////////////////////////////////////////////////////////////////////
function uploadMoreFile(n_id){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<table style="width:480px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title" style="width: 460px">');
    a_arr.push('            批量上传文件');
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
    a_arr.push('			<td class="TableData"><object id="vcl_flash_upload" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="470" height="270">')
	a_arr.push('			    <param name="movie" value="images/upload.swf" />')
    a_arr.push('			    <param name="quality" value="high" />')
    a_arr.push('			    <param name="wmode" value="opaque" />')
    a_arr.push('			    <param name="swfversion" value="8.0.35.0" />')
    a_arr.push('			    <param name="FlashVars" value="N_FreeSplace='+n_id+'&S_Url=http://58.128.134.32/sub/resources/include/bn_submit.svr.php?function=UpLoadPicture"/>')
    a_arr.push('			    <!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 -->')
    a_arr.push('			    <param name="expressinstall" value="../../images/expressInstall.swf" />')
    a_arr.push('			    <!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 -->')
    a_arr.push('			    <!--[if !IE]>-->')
    a_arr.push('			    <object id="vcl_flash_upload2" type="application/x-shockwave-flash" data="images/upload.swf" width="470" height="270">')
    a_arr.push('			    <!--<![endif]-->')
    a_arr.push('			    <param name="quality" value="high" />')
    a_arr.push('			    <param name="wmode" value="opaque" />')
    a_arr.push('			    <param name="swfversion" value="8.0.35.0" />	')											   
    a_arr.push('			    <param name="expressinstall" value="../../images/expressInstall.swf" />')
    a_arr.push('			    <!-- 浏览器将以下替代内容显示给使用 Flash Player 6.0 和更低版本的用户。 -->')
    a_arr.push('			    <div>')
    a_arr.push('			    如果使用批量上传功能,需要下载较新版本的 Adobe Flash Player。')
    a_arr.push('			    <br/><a href="http://www.adobe.com/go/getflashplayer"><img src="../../images/get_flash_player.gif" alt="获取 Adobe Flash Player" /></a>')
    a_arr.push('			    <p/>')
    a_arr.push('			    </div>')
    a_arr.push('			    <!--[if !IE]>-->')
    a_arr.push('			    </object>')
    a_arr.push('			    <!--<![endif]-->')
    a_arr.push('			    </object></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td nowrap="nowrap"><input')
    a_arr.push('				value="关闭" class="submitButton" onclick="uploadCancel()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=600
	N_Dialog_Width=496
	o_obj.style.top='-1000px';
	var ch = document.compatMode == "BackCompat"?document.body.clientHeight:document.documentElement.clientHeight;
    var cw = document.compatMode == "BackCompat"?document.body.clientWidth:document.documentElement.clientWidth;
    var st = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    var sl = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
    var _div=document.getElementById("master_box");
    _div.style.top=(st+50)+'px';
    _div.style.left = ((cw - N_Dialog_Width) / 2 +sl)+'px';
	//TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
	//swfobject.registerObject("vcl_flash_upload");
}