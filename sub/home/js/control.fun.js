//////////////////////////////////////////////////////////////////////////////////////////////////////
function showAddColumn(n_parent,n_count){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=AddColumn"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:350px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            添加栏目');
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
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;栏目名称：</td>')
    a_arr.push('			<td class="TableData"><input id="Vcl_Name" name="Vcl_Name"')
    a_arr.push('				size="15" maxlength="15" class="BigInput"')
    a_arr.push('				value="" type="text" />')
    a_arr.push('			    <input id="Vcl_Parent" name="Vcl_Parent"')
    a_arr.push('				size="15" maxlength="15" class="BigInput"')
    a_arr.push('				value="'+n_parent+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;显示顺序：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('            <select name="Vcl_Number" id="Vcl_Number" class="BigSelect">')
    for(var i=1;i<=n_count;i++)
    {
        a_arr.push('            <option value="'+i+'">'+i+'</option>')
    }
     a_arr.push('            <option value="'+i+'" selected="selected">'+(n_count+1)+'</option>')
    a_arr.push('                </select>')
    a_arr.push('            </td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;状态：</td>')
    a_arr.push('			<td class="TableData"><select name="Vcl_State" id="Vcl_State"')
    a_arr.push('				class="BigSelect"><option value="1" selected="selected">启用</option>')
    a_arr.push('				<option value="0">禁用</option>')
    a_arr.push('			</select></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;外部链接地址：</td>')
    a_arr.push('			<td class="TableData"><input id="Vcl_Url" name="Vcl_Url"')
    a_arr.push('				size="15" maxlength="255" class="BigInput"')
    a_arr.push('				value="" type="text" /> （可选）</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="添加" class="submitButton"')
    a_arr.push('				onclick="submitColumn()" type="button" /> &nbsp;&nbsp; <input')
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
function showModifyColumn(n_columnid,s_name,n_parent,n_number,n_count,s_state,s_url){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=ModifyColumn"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:350px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            编辑栏目');
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
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;栏目名称：</td>')
    a_arr.push('			<td class="TableData"><input id="Vcl_Name" name="Vcl_Name"')
    a_arr.push('				size="15" maxlength="15" class="BigInput"')
    a_arr.push('				value="'+s_name+'" type="text" />')
    a_arr.push('			    <input id="Vcl_Parent" name="Vcl_Parent"')
    a_arr.push('				size="15" maxlength="15" class="BigInput"')
    a_arr.push('				value="'+n_parent+'" type="text" style="display:none"/>')
    a_arr.push('			    <input id="Vcl_ColumnId" name="Vcl_ColumnId"')
    a_arr.push('				size="15" maxlength="15" class="BigInput"')
    a_arr.push('				value="'+n_columnid+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;显示顺序：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('            <select name="Vcl_Number" id="Vcl_Number" class="BigSelect">')
    for(var i=1;i<=n_count;i++)
    {
        if (i==n_number)
        {
        a_arr.push('            <option value="'+i+'" selected="selected">'+i+'</option>')
        }else{
        a_arr.push('            <option value="'+i+'">'+i+'</option>')
        }
        
    }
    a_arr.push('                </select>')
    a_arr.push('            </td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;状态：</td>')
    a_arr.push('			<td class="TableData">')
    if (s_state==1)
    {
        a_arr.push('			    <select name="Vcl_State" id="Vcl_State"')
        a_arr.push('				class="BigSelect"><option value="1" selected="selected">启用</option>')
        a_arr.push('				<option value="0">禁用</option>')
        a_arr.push('			</select>')
    }else{
        a_arr.push('			    <select name="Vcl_State" id="Vcl_State"')
        a_arr.push('				class="BigSelect"><option value="1">启用</option>')
        a_arr.push('				<option value="0" selected="selected">禁用</option>')
        a_arr.push('			</select>')
    }
    a_arr.push('			    </td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;外部链接地址：</td>')
    a_arr.push('			<td class="TableData"><input id="Vcl_Url" name="Vcl_Url"')
    a_arr.push('				size="15" maxlength="255" class="BigInput"')
    a_arr.push('				value="'+s_url+'" type="text" /> （可选）</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="保存" class="submitButton"')
    a_arr.push('				onclick="submitColumn()" type="button" /> &nbsp;&nbsp; <input')
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

/////////////////////////////////////////////////////////////////////////////////////////////////////
function indexColume(n_id,a_columnid,a_name){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=ModifyIndexColumn"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:350px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            选择要显示的栏目');
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
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;一级栏目：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('            <select name="Vcl_Parent" id="Vcl_Parent" class="BigSelect" onchange="getColume2()">')
    for(var i=0;i<a_columnid.length;i++)
    {
        a_arr.push('            <option value="'+a_columnid[i]+'">'+a_name[i]+'</option>')
        
    }    
    a_arr.push('                </select>')
    a_arr.push('			    <input id="Vcl_IndexcolumnId" name="Vcl_IndexcolumnId"')
    a_arr.push('				size="15" maxlength="15" class="BigInput"')
    a_arr.push('				value="'+n_id+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;二级栏目：</td>')
    a_arr.push('			<td class="TableData"><div id="column2">')
    a_arr.push('            <select name="Vcl_ColumnId" id="Vcl_ColumnId" class="BigSelect">')
    a_arr.push('            <option value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>')
    a_arr.push('                </select> （可选）</div></td>')
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
	getColume2()  
}
////////////////////////////////////////////////文章管理//////////////////////////////////////////////////////
function moveArticle(a_columnid,a_name){
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
        parent.parent.Dialog_Message('请选择要移动的文章！');
        return
    } 
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=MoveArticle"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:350px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            移动文章到....');
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
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;一级栏目：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('            <select name="Vcl_Parent" id="Vcl_Parent" class="BigSelect" onchange="getColume2()">')
    for(var i=0;i<a_columnid.length;i++)
    {
        a_arr.push('            <option value="'+a_columnid[i]+'">'+a_name[i]+'</option>')
        
    }    
    a_arr.push('                </select>')
    a_arr.push('			    <input id="Vcl_ArticleId" name="Vcl_ArticleId"')
    a_arr.push('				size="15" maxlength="15" class="BigInput"')
    a_arr.push('				value="'+n_id+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;二级栏目：</td>')
    a_arr.push('			<td class="TableData"><div id="column2">')
    a_arr.push('            <select name="Vcl_ColumnId" id="Vcl_ColumnId" class="BigSelect">')
    a_arr.push('            <option value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>')
    a_arr.push('                </select> （可选）</div></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="移动" class="submitButton"')
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
	getColume2()  
}
function getColume2()
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('GetColumn2');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(document.getElementById('Vcl_Parent').value);
    document.getElementById('tags').innerHTML='';
    o_ajax_request.SendRequest()
}
function setColume2(a_columnid,a_name)
{
    eval('a_columnid='+a_columnid)
    eval('a_name='+a_name)
    var a_arr=[];
    a_arr.push('<select name="Vcl_ColumnId" id="Vcl_ColumnId" class="BigSelect" onchange="getTags()"><option value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>')
    for(var i=0;i<a_columnid.length;i++)
    {
        a_arr.push('<option value="'+a_columnid[i]+'">'+a_name[i]+'</option>')
        
    }    
    a_arr.push('</select> （可选）')
    document.getElementById('column2').innerHTML=a_arr.join('\n')
}
function getTags()
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('GetTags');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(document.getElementById('Vcl_ColumnId').value);
    document.getElementById('tags').innerHTML='';
    o_ajax_request.SendRequest()
}
function setTags(a_columnid,a_name)
{
    eval('a_columnid='+a_columnid)
    eval('a_name='+a_name)
    var a_arr=[];
    a_arr.push('标签：<select name="Vcl_TagId" id="Vcl_TagId" class="BigSelect">')
    for(var i=0;i<a_columnid.length;i++)
    {
        a_arr.push('<option value="'+a_columnid[i]+'">'+a_name[i]+'</option>')
        
    }    
    a_arr.push('</select>')
    document.getElementById('tags').innerHTML=a_arr.join('\n')
}
/////////////////////////////////////////////////////////////////////////////////////////////////////
 function selectAll(o_obj)
 {
    for(var i = 1; i < 100; i++){
        var o_check=document.getElementById('check_'+i)        
        if (o_check==null) {
            break;
        }
        if (o_obj.checked)
        {
            o_check.checked=true;
        }else{
            o_check.checked=false;
        }
    }
}
 function selectSingle()
 {
    var b_allcheck=true
     for(var i = 1; i < 100; i++){
        var o_check=document.getElementById('check_'+i)        
        if (o_check==null) {
            break;
        }
        if (o_check.checked===false)
        {
            b_allcheck=false;
            break
        }
    }
    document.getElementById('allcheck').checked=b_allcheck;
}
function goToPage(s_pagename,s_id)
{
    var n_page=document.getElementById(s_id).value
    n_page=n_page*1
    if (n_page>0)
    {
        n_page=Math.floor(n_page)
        n_page=Math.abs(n_page)
        s_temp=s_pagename.substr(s_pagename.length-3,s_pagename.length-3)
        if (s_temp=='php')
        {
        window.navigate(s_pagename+'?page='+n_page);   
        }else{
        window.navigate(s_pagename+'&page='+n_page);   
        }
              
    }else{
        document.getElementById(s_id).value=''
    }
}
function goTo(s_url){
    var o_ifram=parent.document.getElementsByTagName('iframe')[1]
    o_ifram.src=s_url
}
function checkTextCount()
{
    var s_content=document.getElementById('Vcl_Content').value
    var n_count=150-s_content.length
    if (n_count<0)
    {
        document.getElementById('Vcl_Content').value=s_content.substr(0,150)
        document.getElementById('strcount').innerHTML=0
    }else{
        document.getElementById('strcount').innerHTML=n_count
    }    
}
function sendMsgClearVcl()
{
    document.getElementById('Vcl_Content').value='';
    document.getElementById('Vcl_Reciver_Id').value='';
    document.getElementById('Vcl_Reciver').value='';
    document.getElementById('upload').innerHTML='<input id="Vcl_upload" name="Vcl_upload" type="file" />';
    o_input=document.getElementById('allname').getElementsByTagName('input')
    for(var i =0; i < o_input.length; i++)//从第三项开始循环,因为第一项和第二项是全部添加和全部删除按钮
    {
        if (o_input[i].className=='selected')
        {
            o_input[i].className='name'
        }             
    } 
    var o_dept=document.getElementById('group')
    o_dept.style.display='none'
    checkTextCount()
}
function showAddFloat(n_count){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=AddFloat"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:350px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            添加浮动文章');
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
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;文章编号：</td>')
    a_arr.push('			<td class="TableData"><input id="Vcl_ArticleId" name="Vcl_ArticleId"')
    a_arr.push('				size="15" maxlength="15" class="BigInput"')
    a_arr.push('				value="" type="text" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;显示顺序：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('            <select name="Vcl_Number" id="Vcl_Number" class="BigSelect">')
    for(var i=1;i<=n_count;i++)
    {
        a_arr.push('            <option value="'+i+'">'+i+'</option>')
    }
     a_arr.push('            <option value="'+i+'" selected="selected">'+(n_count+1)+'</option>')
    a_arr.push('                </select>')
    a_arr.push('            </td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="添加" class="submitButton"')
    a_arr.push('				onclick="submitFloat()" type="button" /> &nbsp;&nbsp; <input')
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
function submitFloat()
{

    var s_temp=document.getElementById('Vcl_ArticleId').value
    if (s_temp.length==0)
    {
        parent.parent.Dialog_Message("[ 文章编号 ] 不能为空！")
        return
    }
    document.getElementById('dialog_form').submit();
    if (!is_moz){
        Common_OpenLoading();   
    }
}
function showModifyFloat(n_floatd,n_articleid,n_number,n_count){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=ModifyFloat"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:350px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            编辑浮动文章');
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
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;文章编号：</td>')
    a_arr.push('			<td class="TableData"><input id="Vcl_ArticleId" name="Vcl_ArticleId"')
    a_arr.push('				size="15" maxlength="15" class="BigInput"')
    a_arr.push('				value="'+n_articleid+'" type="text" />')
    a_arr.push('			    <input id="Vcl_FloatId" name="Vcl_FloatId"')
    a_arr.push('				size="15" maxlength="15" class="BigInput"')
    a_arr.push('				value="'+n_floatd+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;显示顺序：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('            <select name="Vcl_Number" id="Vcl_Number" class="BigSelect">')
    for(var i=1;i<=n_count;i++)
    {
        if (i==n_number)
        {
        a_arr.push('            <option value="'+i+'" selected="selected">'+i+'</option>')
        }else{
        a_arr.push('            <option value="'+i+'">'+i+'</option>')
        }
        
    }
    a_arr.push('                </select>')
    a_arr.push('            </td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="保存" class="submitButton"')
    a_arr.push('				onclick="submitFloat()" type="button" /> &nbsp;&nbsp; <input')
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