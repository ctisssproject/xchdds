////////////////////////////////////////////////////////////////删除单个文件//////////////////////////////////////////////////////////////////////////////////////////
function deleteFolder(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeleteFolder');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.parent.Dialog_Confirm("真的要删除这个文件夹吗？",function (){o_ajax_request.SendRequest()});
}
function callbackDeleteFolder(n_parent)
{
    //parent.parent.document.getElementsByTagName('frame')[0].contentWindow.refreshPath(n_parent)
    if (n_parent==-1)
    {
        parent.parent.parent.Dialog_Error("对不起！<br/>文件夹中存在文件！<br/>不能删除！")
    }else{
        parent.location.reload();
    }
    
}
////////////////////////////////////////////////////////////////单个文件夹重命名//////////////////////////////////////////////////////////////////////////////////////////
function submitRenameFolder()
{
    var s_temp=document.getElementById('Vcl_FolderName').value
    if (s_temp.length==0)
    {
        parent.parent.parent.Dialog_Message("[ 文件夹名 ] 不能为空！")
        return
    }
    document.getElementById('dialog_form').submit();
}
function FolderRename(n_id,n_parentid,s_foldername){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=FolderRename"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:350px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('           重命名文件夹');
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
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;文件夹名：</td>')
    a_arr.push('			<td class="TableData"><input id="Vcl_FolderName" name="Vcl_FolderName"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+s_foldername+'" type="text" />')
    a_arr.push('			    <input id="Vcl_FolderId" name="Vcl_FolderId"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_id+'" type="text" style="display:none"/>')
    a_arr.push('			    <input id="Vcl_ParentId" name="Vcl_ParentId"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_parentid+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="重命名" class="submitButton"')
    a_arr.push('				onclick="submitRenameFolder()" type="button" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=320
	N_Dialog_Width=367
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));   
}
function callbackRenameFolder(n_parent)
{
    //parent.parent.document.getElementsByTagName('frame')[0].contentWindow.refreshPath(n_parent)
    parent.location.reload();
}
//////////////////////////////////////////////////////////////////////单个文件夹复制////////////////////////////////////////////////////////////////////////////////
function copyFolder(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ShowCopyFolderDialog');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.SendRequest()
}
function showCopyFolderDialog(n_id,s_tree){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=CopyFolder"')
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
    a_arr.push('			    <div><input id="Vcl_FolderIdFrom" name="Vcl_FolderIdFrom"')
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
	N_Dialog_Height=320
	N_Dialog_Width=367
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));   
}
function callbackCopyFolder(n_fileid,n_folderid)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('CopyFolderAndReplace');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_fileid);
    o_ajax_request.PushParameter(n_folderid);
    parent.parent.parent.Dialog_Confirm("目标目录中有相同文件夹！<br>是否替换？",function (){o_ajax_request.SendRequest()});
}
function callbackCopyFolderFinish(n_parent)
{
    try{
        parent.parent.document.getElementsByTagName('frame')[0].contentWindow.refreshPathNoBold(n_parent)
    }catch(e){

    }    
    try{
        parent.parent.parent.document.getElementsByTagName('frame')[0].contentWindow.refreshPathNoBold(n_parent)
    }catch(e){

    } 
    try{parent.Common_CloseDialog()}catch(e){}
    try{Common_CloseDialog()}catch(e){}
    
   // parent.location.reload();
}
//////////////////////////////////////////////////////////////////////单个文件夹移动//////////////////////////////////////////////////////////////////////////////////
function moveFolder(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ShowMoveFolderDialog');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.SendRequest()
}
function showMoveFolderDialog(n_id,s_tree){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=MoveFolder"')
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
    a_arr.push('			    <div><input id="Vcl_FolderIdFrom" name="Vcl_FolderIdFrom"')
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
	N_Dialog_Height=320
	N_Dialog_Width=367
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));   
}
function callbackMoveFolder(n_fileid,n_folderid)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('MoveFolderAndReplace');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_fileid);
    o_ajax_request.PushParameter(n_folderid);
    parent.parent.parent.Dialog_Confirm("目标目录中有相同文件夹！<br>是否替换？",function (){o_ajax_request.SendRequest()});
}
function callbackMoveFolderFinish(n_parent1,n_parent2)
{
    try{
        parent.parent.document.getElementsByTagName('frame')[0].contentWindow.refreshPath(n_parent2)
        setTimeout("parent.parent.document.getElementsByTagName('frame')[0].contentWindow.refreshPath("+n_parent1+");parent.location.reload()",800);  
    }catch(e){

    }    
    //parent.location.reload();
}
//////////////////////////////////////////////////////////////////////新建文件夹//////////////////////////////////////////////////////////////////////////////////
function FolderNew(n_parentid){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=FolderNew"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:350px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('           新建文件夹');
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
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;文件夹名：</td>')
    a_arr.push('			<td class="TableData"><input id="Vcl_FolderName" name="Vcl_FolderName"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="" type="text" />')
    a_arr.push('				<input id="Vcl_ParentId" name="Vcl_ParentId" value="'+n_parentid+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="新建" class="submitButton"')
    a_arr.push('				onclick="submitRenameFolder()" type="button" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=320
	N_Dialog_Width=367
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));   
}