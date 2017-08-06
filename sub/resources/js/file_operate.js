////////////////////////////////////////////////////////////////删除单个文件//////////////////////////////////////////////////////////////////////////////////////////
function deleteFile(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeleteFile');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.parent.Dialog_Confirm("真的要删除这个文件吗？",function (){o_ajax_request.SendRequest()});
}
//////////////////////////////////////////////////////////////////////单个文件重命名//////////////////////////////////////////////////////////////////////////////////
function submitRename()
{
    var s_temp=document.getElementById('Vcl_Filename').value
    if (s_temp.length==0)
    {
        parent.parent.parent.Dialog_Message("[ 文件名 ] 不能为空！")
        return
    }
    document.getElementById('dialog_form').submit();
}
function fileRename(n_id,s_filename,s_keyword){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=FileRename"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:380px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            文件重命名');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock" align="center" width="380">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;文件名：</td>')
    a_arr.push('			<td class="TableData"><input id="Vcl_Filename" name="Vcl_Filename"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+s_filename+'" type="text" />')
    a_arr.push('			    <input id="Vcl_FileId" name="Vcl_FileId"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_id+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;描述：</td>')
    a_arr.push('			<td class="TableData"><input id="Vcl_KeyWord" name="Vcl_KeyWord"')
    a_arr.push('				size="30" maxlength="50" class="BigInput"')
    a_arr.push('				value="'+s_keyword+'" type="text" /> (可选)</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="重命名" class="submitButton"')
    a_arr.push('				onclick="submitRename()" type="button" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
    window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=600
	N_Dialog_Width=397
	o_obj.style.top='-1000px';
	var ch = document.compatMode == "BackCompat"?document.body.clientHeight:document.documentElement.clientHeight;
    var cw = document.compatMode == "BackCompat"?document.body.clientWidth:document.documentElement.clientWidth;
    var st = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    var sl = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
    var _div=document.getElementById("master_box");
    _div.style.top=(st+30)+'px';
    _div.style.left = ((cw - N_Dialog_Width) / 2 +sl)+'px';
	//TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));    
}
//////////////////////////////////////////////////////////////////////单个文件移动//////////////////////////////////////////////////////////////////////////////////
function moveFile(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ShowMoveDialog');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.SendRequest()
}
function showMoveDialog(n_id,s_tree){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=MoveFile"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:300px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            选择要移动到的文件夹');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock" align="center" width="300">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" style="padding:10px 10px 0px 10px;"><div style="height:200px;width:300px;overflow:auto">');
    a_arr.push(s_tree)
    a_arr.push('			    <div><input id="Vcl_FileId" name="Vcl_FileId"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_id+'" type="text" style="display:none"/>')
    a_arr.push('			    <input id="Vcl_FolderId" name="Vcl_FolderId"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="0" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="1" nowrap="nowrap"><input value="移动" class="submitButton"')
    a_arr.push('				type="submit" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
    window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=600
	N_Dialog_Width=367
	o_obj.style.top='-1000px';
	var ch = document.compatMode == "BackCompat"?document.body.clientHeight:document.documentElement.clientHeight;
    var cw = document.compatMode == "BackCompat"?document.body.clientWidth:document.documentElement.clientWidth;
    var st = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    var sl = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
    var _div=document.getElementById("master_box");
    _div.style.top=(st+30)+'px';
    _div.style.left = ((cw - N_Dialog_Width) / 2 +sl)+'px';
	//TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
}
function callbackMoveFile(n_fileid,n_folderid,n_return)
{
    if (n_return==-1)
    {
        parent.parent.parent.Dialog_Error("只能将文件移动到最底层目录！")
        return
    }
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('MoveFileAndReplace');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_fileid);
    o_ajax_request.PushParameter(n_folderid);
    parent.parent.parent.Dialog_Confirm("目标目录中有相同文件名！<br>是否覆盖？",function (){o_ajax_request.SendRequest()});
}
//////////////////////////////////////////////////////////////////////单个文件复制////////////////////////////////////////////////////////////////////////////////
function copyFile(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ShowCopyDialog');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.SendRequest()
}
function showCopyDialog(n_id,s_tree){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=CopyFile"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:300px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            选择要复制到的文件夹');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock" align="center" width="300">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" style="padding:10px 10px 0px 10px;"><div style="height:200px;width:300px;overflow:auto">');
    a_arr.push(s_tree)
    a_arr.push('			    <div><input id="Vcl_FileId" name="Vcl_FileId"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_id+'" type="text" style="display:none"/>')
    a_arr.push('			    <input id="Vcl_FolderId" name="Vcl_FolderId"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="0" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="1" nowrap="nowrap"><input value="复制" class="submitButton"')
    a_arr.push('				type="submit" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
    window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=600
	N_Dialog_Width=367
	o_obj.style.top='-1000px';
	var ch = document.compatMode == "BackCompat"?document.body.clientHeight:document.documentElement.clientHeight;
    var cw = document.compatMode == "BackCompat"?document.body.clientWidth:document.documentElement.clientWidth;
    var st = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    var sl = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
    var _div=document.getElementById("master_box");
    _div.style.top=(st+30)+'px';
    _div.style.left = ((cw - N_Dialog_Width) / 2 +sl)+'px';
	//TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));   
}
function callbackCopyFile(n_fileid,n_folderid,n_return)
{
    if (n_return==-1)
    {
        parent.parent.parent.Dialog_Error("只能将文件复制到最底层目录！")
        return
    }
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('CopyFileAndReplace');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_fileid);
    o_ajax_request.PushParameter(n_folderid);
    parent.parent.parent.Dialog_Confirm("目标目录中有相同文件名！<br>是否覆盖？",function (){o_ajax_request.SendRequest()});
}
//////////////////////////////////////////////////////////////////////多个文件和文件夹复制////////////////////////////////////////////////////////////////////////////////
function copyAndMoveAll(s_str)
{
    var n_folderid='';
    var n_fileid='';
    for(var i = 1; i < 100; i++){//构建文件夹id字符串
        var o_check=document.getElementById('folder_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            n_folderid=n_folderid+o_check.value+'<1>';
        }        
    }
    if (n_folderid.length>0)
    {
        n_folderid=n_folderid.substr(0,n_folderid.length-3)
    }
    for(var i = 1; i < 100; i++){//构建文件id字符串
        var o_check=document.getElementById('file_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            n_fileid=n_fileid+o_check.value+'<1>';
        }        
    }
    if (n_fileid.length>0)
    {
        n_fileid=n_fileid.substr(0,n_fileid.length-3)
    }
    if (n_folderid=='' && n_fileid=='')
    {
        if (s_str=='copy')
        {
            parent.parent.parent.Dialog_Message('请选择要复制的文件！');
        }else{
            parent.parent.parent.Dialog_Message('请选择要移动的文件！');
        }        
        return
    } 
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ShowCopyAndMoveAllDialog');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_folderid);
    o_ajax_request.PushParameter(n_fileid);
    o_ajax_request.PushParameter(s_str);
    o_ajax_request.SendRequest()
}
function showCopyAndMoveAllDialog(n_folderid,n_fileid,s_tree,s_type){
    if (s_type=='copy')
    {
        s_str='复制'
    }else{
        s_str='移动'
    }  
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<table style="width:300px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            选择要'+s_str+'到的文件夹');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock" align="center" width="300">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" style="padding:10px 10px 0px 10px;"><div style="height:200px;width:300px;overflow:auto">');
    a_arr.push(s_tree)
    a_arr.push('			    <div><input id="Vcl_FolderId" name="Vcl_FolderId"')
    a_arr.push('				class="BigInput"')
    a_arr.push('				value="0" type="text" style="display:none"/>')
    a_arr.push('				<input id="Vcl_FileId" name="Vcl_FileId"')    
    a_arr.push('				class="BigInput"')
    a_arr.push('				value="'+n_fileid+'" type="text" style="display:none"/>')
    a_arr.push('				<input id="Vcl_Folder_Id" name="Vcl_Folder_Id"')    
    a_arr.push('				class="BigInput"')
    a_arr.push('				value="'+n_folderid+'" type="text" style="display:none"/>')
    a_arr.push('				<input id="Vcl_FileStart" name="Vcl_FileStart"')    
    a_arr.push('				class="BigInput"')
    a_arr.push('				value="0" type="text" style="display:none"/>')
    a_arr.push('			    <input id="Vcl_FolderStart" name="Vcl_FolderStart"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="0" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="1" nowrap="nowrap"><input value="'+s_str+'" class="submitButton" onclick="submitCopyAndMoveAll(2,\''+s_type+'\')"')
    a_arr.push('				type="button" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=600
	N_Dialog_Width=367
	o_obj.style.top='-1000px';
	var ch = document.compatMode == "BackCompat"?document.body.clientHeight:document.documentElement.clientHeight;
    var cw = document.compatMode == "BackCompat"?document.body.clientWidth:document.documentElement.clientWidth;
    var st = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    var sl = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
    var _div=document.getElementById("master_box");
    _div.style.top=(st+30)+'px';
    _div.style.left = ((cw - N_Dialog_Width) / 2 +sl)+'px';
	//TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
}
function submitCopyAndMoveAll(replace,type)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('CopyAndMoveAll');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(document.getElementById('Vcl_Folder_Id').value);
    o_ajax_request.PushParameter(document.getElementById('Vcl_FileId').value);
    o_ajax_request.PushParameter(document.getElementById('Vcl_FolderStart').value);
    o_ajax_request.PushParameter(document.getElementById('Vcl_FileStart').value);
    o_ajax_request.PushParameter(replace);
    o_ajax_request.PushParameter(document.getElementById('Vcl_FolderId').value);
    o_ajax_request.PushParameter(type);
    o_ajax_request.SendRequest();
}
function callbackCopyAndMoveAll(old_filename,old_size,old_date,old_class,new_filename,new_size,new_date,new_class,s_folder_id,s_file_id,n_folder_start,n_file_start,n_folderid,s_type)
{
    if (s_type=='copy')
    {
        s_str='复制'
    }else{
        s_str='移动'
    }  
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=CopyAll"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:500px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            是否替换？');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table align="center" width="500">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td stylt="margin:0px; padding:0px;">')
    a_arr.push('                                <table border="0" cellpadding="0" cellspacing="0" style="border-top:1px solid #EBEBEB" class="folder_body">')
    a_arr.push('                                    <tr class="off">')
	a_arr.push('							            <td style="width:40px" class="off">')
	a_arr.push('							                目标：')
	a_arr.push('							            </td>')
	a_arr.push('							            <td style="width:32px">')
	a_arr.push('							               <div class="icon"><div class="img '+old_class+'"></div><div></div></div>')
	a_arr.push('							            </td>')
	a_arr.push('							            <td>')
	a_arr.push(old_filename)
	a_arr.push('							            </td>')
	a_arr.push('							            <td style="width:80px">')
	a_arr.push(old_size)
	a_arr.push('							            </td>')
	a_arr.push('							            <td style="width:130px">')
	a_arr.push(old_date)
	a_arr.push('							            </td>')
	a_arr.push('							        </tr>')
	a_arr.push('                                    <tr class="off">')
	a_arr.push('							            <td class="off">')
	a_arr.push('							                '+s_str+'：')
	a_arr.push('							            </td>')
	a_arr.push('							            <td>')
	a_arr.push('							                <div class="icon"><div class="img '+new_class+'"></div><div></div></div>')
	a_arr.push('							            </td>')
	a_arr.push('							            <td>')
	a_arr.push(new_filename)
	a_arr.push('							            </td>')
	a_arr.push('							            <td>')
	a_arr.push(new_size)
	a_arr.push('							            </td>')
	a_arr.push('							            <td>')
	a_arr.push(new_date)
	a_arr.push('							            </td>')
	a_arr.push('							        </tr>')
	a_arr.push('	        		            </table>')
    a_arr.push('<input id="Vcl_FolderId" name="Vcl_FolderId"')
    a_arr.push('				class="BigInput"')
    a_arr.push('				value="'+n_folderid+'" type="text" style="display:none"/>')
    a_arr.push('				<input id="Vcl_FileId" name="Vcl_FileId"')    
    a_arr.push('				class="BigInput"')
    a_arr.push('				value="'+s_file_id+'" type="text" style="display:none"/>')
    a_arr.push('				<input id="Vcl_Folder_Id" name="Vcl_Folder_Id"')    
    a_arr.push('				class="BigInput"')
    a_arr.push('				value="'+s_folder_id+'" type="text" style="display:none"/>')
    a_arr.push('				<input id="Vcl_FileStart" name="Vcl_FileStart"')    
    a_arr.push('				class="BigInput"')
    a_arr.push('				value="'+n_file_start+'" type="text" style="display:none"/>')
    a_arr.push('			    <input id="Vcl_FolderStart" name="Vcl_FolderStart"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_folder_start+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="1" nowrap="nowrap"><input value="覆盖" class="submitButton" onclick="submitCopyAndMoveAll(1,\''+s_type+'\')"')
    a_arr.push('				type="button" /> &nbsp;&nbsp;<input value="跳过" class="submitButton" onclick="submitCopyAndMoveAll(0,\''+s_type+'\')"type="button" /> &nbsp;&nbsp;<input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
    window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=600
	N_Dialog_Width=567
	o_obj.style.top='-1000px';
	var ch = document.compatMode == "BackCompat"?document.body.clientHeight:document.documentElement.clientHeight;
    var cw = document.compatMode == "BackCompat"?document.body.clientWidth:document.documentElement.clientWidth;
    var st = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    var sl = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
    var _div=document.getElementById("master_box");
    _div.style.top=(st+30)+'px';
    _div.style.left = ((cw - N_Dialog_Width) / 2 +sl)+'px';
	//TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
}
//////////////////////////////////////////////////////////////////////批量删除文件和文件夹////////////////////////////////////////////////////////////////////////////////
function deleteAll()
{
    var n_folderid='';
    var n_fileid='';
    for(var i = 1; i < 100; i++){//构建文件夹id字符串
        var o_check=document.getElementById('folder_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            n_folderid=n_folderid+o_check.value+'<1>';
        }        
    }
    if (n_folderid.length>0)
    {
        n_folderid=n_folderid.substr(0,n_folderid.length-3)
    }
    for(var i = 1; i < 100; i++){//构建文件id字符串
        var o_check=document.getElementById('file_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            n_fileid=n_fileid+o_check.value+'<1>';
        }        
    }
    if (n_fileid.length>0)
    {
        n_fileid=n_fileid.substr(0,n_fileid.length-3)
    }
    if (n_folderid=='' && n_fileid=='')
    {
        parent.parent.parent.Dialog_Message('请选择要删除的文件！');     
        return
    } 
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeleteAll');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_folderid);
    o_ajax_request.PushParameter(n_fileid);
    parent.parent.parent.Dialog_Confirm("真的要删除这些文件吗？",function (){o_ajax_request.SendRequest()});
    
}
//////////////////////////////////////////////////////////////////////设置共享////////////////////////////////////////////////////////////////////////////////
function shareFile(n_id,n_type)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ShowShareDialog');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.PushParameter(n_type);
    o_ajax_request.SendRequest()
}
function showShareDialog(n_id,s_tree,n_type,s_recive,s_reciveid){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=ShareFile"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:550px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            共享设置');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock" align="center" width="550">')
    a_arr.push('	<tbody>')
	a_arr.push('		<tr class="TableData">')
	a_arr.push('			<td style="width: 65px" nowrap="nowrap">共享给：</td>')
	a_arr.push('			<td nowrap="nowrap"><textarea cols="60" id="Vcl_Reciver"')
	a_arr.push('				name="Vcl_Reciver" rows="4" class="BigStatic" wrap="yes"')
	a_arr.push('				readonly="readonly">'+s_recive+'</textarea><textarea')
	a_arr.push('				style="display: none" cols="60" id="Vcl_Reciver_Id"')
	a_arr.push('				name="Vcl_Reciver_Id" rows="4" class="BigStatic" wrap="yes"')
	a_arr.push('				readonly="readonly">'+s_reciveid+'</textarea><br><a')
	a_arr.push('				href="javascript:;" class="orgClear" onclick="vclClear()">清空</a>')
	a_arr.push('				<a href="javascript:;" class="orgAdd" onclick="openGroup()">添加</a>')
    a_arr.push('			    <input id="Vcl_Type" name="Vcl_Type"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_type+'" type="text" style="display:none"/>')
	a_arr.push('			    <input id="Vcl_Id" name="Vcl_Id"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_id+'" type="text" style="display:none"/></td>')
	a_arr.push('		</tr>')
	a_arr.push(s_tree)
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="确定" class="submitButton"')
    a_arr.push('				type="submit" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=600
	N_Dialog_Width=617
	o_obj.style.top='-1000px';
	var ch = document.compatMode == "BackCompat"?document.body.clientHeight:document.documentElement.clientHeight;
    var cw = document.compatMode == "BackCompat"?document.body.clientWidth:document.documentElement.clientWidth;
    var st = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    var sl = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
    var _div=document.getElementById("master_box");
    _div.style.top=(st+30)+'px';
    _div.style.left = ((cw - N_Dialog_Width) / 2 +sl)+'px';
	//TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));   
}
//////////////////////////////////////////////////////////////////////批量彻底删除文件和文件夹////////////////////////////////////////////////////////////////////////////////
function realDeleteAll()
{//彻底删除文件和文件夹
    var n_folderid='';
    var n_fileid='';
    for(var i = 1; i < 100; i++){//构建文件夹id字符串
        var o_check=document.getElementById('folder_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            n_folderid=n_folderid+o_check.value+'<1>';
        }        
    }
    if (n_folderid.length>0)
    {
        n_folderid=n_folderid.substr(0,n_folderid.length-3)
    }
    for(var i = 1; i < 100; i++){//构建文件id字符串
        var o_check=document.getElementById('file_'+i)        
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            n_fileid=n_fileid+o_check.value+'<1>';
        }        
    }
    if (n_fileid.length>0)
    {
        n_fileid=n_fileid.substr(0,n_fileid.length-3)
    }
    if (n_folderid=='' && n_fileid=='')
    {
        parent.parent.parent.Dialog_Message('请选择要彻底删除的文件！');     
        return
    } 
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('RealDeleteAll');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_folderid);
    o_ajax_request.PushParameter(n_fileid);
    parent.parent.parent.Dialog_Confirm("真的要彻底删除吗？",function (){o_ajax_request.SendRequest()});   
}
function realDeleteFile(n_id)
{//彻底删除单个文件
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('RealDeleteFile');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.parent.Dialog_Confirm("真的要彻底删除吗？",function (){o_ajax_request.SendRequest()});
}
function realDeleteFolder(n_id)
{//彻底删除单个文件夹
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('RealDeleteFolder');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.parent.Dialog_Confirm("真的要彻底删除吗？",function (){o_ajax_request.SendRequest()});
}
function clearAll()
{//彻底删除单个文件夹
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ClearAll');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    parent.parent.parent.Dialog_Confirm("真的清空回收站吗？",function (){o_ajax_request.SendRequest()});
}
function reduction(n_id,n_type)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('Reduction');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.PushParameter(n_type);
    parent.parent.parent.Dialog_Confirm("真的还原吗？",function (){o_ajax_request.SendRequest()});
}
function reductionReplace(n_id,n_type)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ReductionReplace');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.PushParameter(n_type);
    if(n_type==1)
    {
        parent.parent.parent.Dialog_Confirm("原目录有相同文件夹！<br>是否替换？",function (){o_ajax_request.SendRequest()});
    }else{
        parent.parent.parent.Dialog_Confirm("原目录有相同文件！<br>是否替换？",function (){o_ajax_request.SendRequest()});
    }
}
function reductionDefult(n_id,n_type)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ReductionDefault');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.PushParameter(n_type);
    if(n_type==1)
    {
        parent.parent.parent.Dialog_Confirm("该文件夹的父目录已经不存在！<br>系统将把文件夹还原到<br>[ 回收站还原 ] 文件夹中！<br>是否同意？",function (){o_ajax_request.SendRequest()});
    }else{
        parent.parent.parent.Dialog_Confirm("该文件的父目录已经不存在！<br>系统将把文件还原到<br>[ 回收站还原 ] 文件夹中！<br>是否同意？",function (){o_ajax_request.SendRequest()});
    }
}