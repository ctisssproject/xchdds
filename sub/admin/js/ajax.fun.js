//////////////////////////////////////////////////////////////////用户管理////////////////////////////////////////////////
function getDept2()
{
//获取相应的二级部门列表
    var n_id=document.getElementById('Vcl_Dept1').value
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('GetDept2');
    o_ajax_request.setPage('../../sub/admin/include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.SendRequest()
}
function callbackSetDept2(s_deptid,s_deptname)
{
//设置二级部门列表
    if(s_deptid=='')
    {
        //没有二级部门，清楚二级部门和三级部门
        document.getElementById('dept2').innerHTML='';
        try{
            document.getElementById('dept3').innerHTML='';
        }catch(e)
        {
        }
        return
    }
    var a_name=s_deptname.split("<1>")
    var a_id=s_deptid.split("<1>")
    var a_arr=[];
    a_arr.push('&nbsp;&nbsp;<select name="Vcl_Dept2" id="Vcl_Dept2" style="min-width:100px" class="BigSelect" onchange="getDept3()"><option value=""></option>')
    for (var i=0; i<a_name.length;i++)
    {
        a_arr.push('<option value="'+a_id[i]+'">'+a_name[i]+ '</option>');
    }
    a_arr.push('</select>')
    document.getElementById('dept2').innerHTML=a_arr.join('\n');
    try{
        document.getElementById('dept3').innerHTML='';
        }catch(e)
        {
        
        }
}
function getDept3()
{
//获取相应的二级部门列表
    var n_id=document.getElementById('Vcl_Dept2').value
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('GetDept3');
    o_ajax_request.setPage('../../sub/admin/include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.SendRequest()
}
function callbackSetDept3(s_deptid,s_deptname)
{
//设置二级部门列表
    try{
        if(s_deptid=='')
        {
            //没有二级部门，清楚二级部门和三级部门
            document.getElementById('dept3').innerHTML='';
            return
        }
        var a_name=s_deptname.split("<1>")
        var a_id=s_deptid.split("<1>")
        var a_arr=[];
        a_arr.push('&nbsp;&nbsp;<select name="Vcl_Dept3" id="Vcl_Dept3" style="min-width:100px" class="BigSelect"><option value=""></option>')
        for (var i=0; i<a_name.length;i++)
        {
            a_arr.push('<option value="'+a_id[i]+'">'+a_name[i]+ '</option>');
        }
        a_arr.push('</select>')
        document.getElementById('dept3').innerHTML=a_arr.join('\n');
    }catch(e)
    {
    }
}
function submitUserAdd()
{
    var temp=document.getElementById('Vcl_UserName').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 用户名 ] 不能为空")
        return
    }else if(temp.length>20){
        parent.parent.Dialog_Message("[ 用户名 ] 不能超过20个英文字符")
        return
    }else{
         function isDigit(str){ 
            var reg = /^[0-9a-zA-Z]*$/; 
            return reg.test(str); 
         }
         if (!isDigit(temp))
         {
            parent.parent.Dialog_Message("[ 用户名 ] 必须为英文字母或数字")
            return 
         }          
    }
    if (temp.length<4){
        parent.parent.Dialog_Message("[ 用户名 ] 不能小于4个字符")
        return
    }
    temp=document.getElementById('Vcl_Name').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 用户名 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_Password').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 密码 ] 不能为空")
        return
    }
    if (temp.length<6){
        parent.parent.Dialog_Message("[ 密码 ] 不能小于6个字符")
        return
    }
    if (temp!=document.getElementById('Vcl_Password2').value){
        parent.parent.Dialog_Message("两次输入的密码不一致")
        return
    }
    temp=document.getElementById('Vcl_Email').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 默认邮箱 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_Dept1').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 部门 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_Role0').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 主角色 ] 不能为空")
        return
    }
   document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
    
}
///////////////////////////////////////////////////////////修改用户部门
function userModifyDept(n_uid,s_username,s_name)
{    
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="../../sub/admin/include/bn_submit.svr.php?function=UserModifyDept"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:500px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            修改用户部门');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock_Editor" align="center" width="500">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="60">&nbsp;&nbsp;用户名：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push(s_username)
    a_arr.push('				</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">&nbsp;&nbsp;姓名：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push(s_name)
    a_arr.push('			    <input id="Vcl_Uid" name="Vcl_Uid"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_uid+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">&nbsp;&nbsp;部门：</td>')
    a_arr.push('			<td class="TableData"><div id="deptvcl"><div></td>')
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
	N_Dialog_Height=250
	N_Dialog_Width=517
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
	userModifyDeptGetDeptVcl(n_uid) 
}
function userModifyDeptGetDeptVcl(n_id)
{
//获取弹出对话框部门列表控件
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('UserModifyDeptGetDeptVcl');
    o_ajax_request.setPage('../../sub/admin/include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.SendRequest()
}
function callbackUserModifyDeptGetDeptVcl(s_html)
{
//获取弹出对话框部门列表控件的回调函数
try{
    document.getElementById('deptvcl').innerHTML=s_html;
    }catch(e)
    {
    }
}
///////////////////////////////////////////////////////////修改用户角色
function userModifyRole(n_uid,s_username,s_name)
{    
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="../../sub/admin/include/bn_submit.svr.php?function=UserModifyRole"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:350px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            修改用户角色');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock_Editor" align="center" width="350">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">用户名：</td>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="255">')
    a_arr.push(s_username)
    a_arr.push('				</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">姓名：</td>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">')
    a_arr.push(s_name)
    a_arr.push('			    <input id="Vcl_Uid" name="Vcl_Uid"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_uid+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr><td colspan="2" nowrap="nowrap"><div id="rolevcl"></div></td>')
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
	N_Dialog_Height=400
	N_Dialog_Width=363
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
	userModifyRoleGetRoleVcl(n_uid) 
}
function userModifyRoleGetRoleVcl(n_id)
{
//获取弹出对话框部门列表控件
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('UserModifyRoleGetRoleVcl');
    o_ajax_request.setPage('../../sub/admin/include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.SendRequest()
}
function callbackUserModifyRoleGetRoleVcl(s_html)
{
//获取弹出对话框部门列表控件的回调函数
try{
    document.getElementById('rolevcl').innerHTML=s_html;
    }catch(e)
    {
    window.alert(e)
    }
}
////////////////////////////////////////////////////////////修改用户状态
function userOpen(obj,n_uid)
{
    obj.parentNode.getElementsByTagName('span')[0].className='open_on'
    obj.parentNode.getElementsByTagName('span')[1].className='close_off'
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('UserSetState');
    o_ajax_request.setPage('../../sub/admin/include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_uid);
    o_ajax_request.PushParameter(1);
    o_ajax_request.SendRequest()
}
function userClose(obj,n_uid)
{
    obj.parentNode.getElementsByTagName('span')[0].className='open_off'
    obj.parentNode.getElementsByTagName('span')[1].className='close_on'
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('UserSetState');
    o_ajax_request.setPage('../../sub/admin/include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_uid);
    o_ajax_request.PushParameter(0);
    o_ajax_request.SendRequest()
}
////////////////////////////////////////////////////////////用户重置密码
function userResetPassword(n_uid,s_username,s_name)
{    
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="../../sub/admin/include/bn_submit.svr.php?function=UserResetPassword"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:400px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            重新设置用户登陆密码');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock_Editor" align="center" width="400">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;用户名：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push(s_username)
    a_arr.push('				</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">&nbsp;&nbsp;姓名：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push(s_name)
    a_arr.push('			    <input id="Vcl_Uid" name="Vcl_Uid"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_uid+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">&nbsp;&nbsp;密码：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('                <input id="Vcl_Password" name="Vcl_Password" size="20" maxlength="30" class="BigInput" value="" type="password"/> <span>注：密码不能小于6位。</span>')
    a_arr.push('				</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">&nbsp;&nbsp;确认密码：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('                <input id="Vcl_Password2" name="Vcl_Password2" size="20" maxlength="30" class="BigInput" value="" type="password"/>')
    a_arr.push('				</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="确认" class="submitButton"')
    a_arr.push('				onclick="submitUserResetPassword()" type="button" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=300
	N_Dialog_Width=450
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
}
function submitUserResetPassword()
{
    temp=document.getElementById('Vcl_Password').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 密码 ] 不能为空")
        return
    }
    if (temp.length<6){
        parent.parent.Dialog_Message("[ 密码 ] 不能小于6个字符")
        return
    }
    if (temp!=document.getElementById('Vcl_Password2').value){
        parent.parent.Dialog_Message("两次输入的密码不一致")
        return
    }
   document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
}
////////////////////////////////////////////////////////////修改用户信息
function userModifyInfo(n_uid,s_username,s_name,s_sex,s_email,s_am_username,s_column,s_group_id)
{    
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="../../sub/admin/include/bn_submit.svr.php?function=UserModifyInfo"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:400px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            修改用户信息');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock_Editor" align="center" width="400">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;用户名：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push(s_username)
    a_arr.push('				</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">&nbsp;&nbsp;真实姓名：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('            <input id="Vcl_Name" name="Vcl_Name" size="20" maxlength="20" class="BigInput" value="'+s_name+'" type="text"/>')
    a_arr.push('			    <input id="Vcl_Uid" name="Vcl_Uid"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_uid+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">&nbsp;&nbsp;性别：</td>')
    a_arr.push('			<td class="TableData"><select name="Vcl_Sex" id="Vcl_Sex"class="BigSelect">')
    if (s_sex=='男')
    {
        a_arr.push('			<option value="男" selected="selected">男</option>')
        a_arr.push('			<option value="女">女</option>')
    }else{
        a_arr.push('			<option value="男">男</option>')
        a_arr.push('			<option value="女" selected="selected">女</option>')
    }
    a_arr.push('				</select></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">&nbsp;&nbsp;默认邮箱：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('                <input id="Vcl_Email" name="Vcl_Email" size="20" maxlength="20" class="BigInput" value="'+s_email+'" type="text"/>')
    a_arr.push('				</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">&nbsp;&nbsp;AM用户名：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('                <input id="Vcl_Am_Username" name="Vcl_Am_Username" size="20" maxlength="20" class="BigInput" value="'+s_am_username+'" type="text"/>')
    a_arr.push('				</td>')
    a_arr.push('		</tr>')

	a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">&nbsp;&nbsp;可发布信息栏目：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('               <select name="Vcl_GroupId" id="Vcl_GroupId" style="min-width:100px" class="BigSelect"><option value="">所有栏目</option>')
	var column=JSON.parse(s_column);
	var groupid=JSON.parse(s_group_id);
	for(var i=0;i<column.length;i++)
	{
		var temp=column[i]
		if (temp[0]==groupid[0])
		{
			a_arr.push('<option value="'+temp[0]+'" selected="selected">'+temp[1]+'</option>')
		}else{
			a_arr.push('<option value="'+temp[0]+'">'+temp[1]+'</option>')
		}
		
	}
    a_arr.push('			    </select></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="保存" class="submitButton"')
    a_arr.push('				onclick="submitUserModifyInfo()" type="button" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=300
	N_Dialog_Width=450
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
}
function submitUserModifyInfo()
{
    temp=document.getElementById('Vcl_Name').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 真实姓名 ] 不能为空！")
        return
    }
    temp=document.getElementById('Vcl_Email').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 默认邮箱 ] 不能为空！")
        return
    }
   document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
}

//////////////////////////////////////////////////////////////////角色管理////////////////////////////////////////////////
function submitRoleAdd()
{
    temp=document.getElementById('Vcl_Name').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 角色名称 ] 不能为空")
        return
    }
    var s_id='';
    var a_check=document.getElementsByTagName('input')
    for (var i=0;i<a_check.length;i++)
    {
        if (a_check[i].checked==true)
        {
            s_id=s_id+'<1>' +a_check[i].value           
        }
    }
    if (s_id.length>0)
    {
        s_id=s_id.substr(3,s_id.length)
    }
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('RoleAdd');
    o_ajax_request.setPage('../../sub/admin/include/it_ajax.svr.php');
    o_ajax_request.PushParameter(document.getElementById('Vcl_Name').value);
    o_ajax_request.PushParameter(document.getElementById('Vcl_Explain').value);
    o_ajax_request.PushParameter(s_id);
    o_ajax_request.SendRequest()   
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
}
function callbackRoleAdd()
{
    parent.parent.Dialog_Success("添加角色成功！点击确定继续！")
    location.reload();
}
function roleDelete(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('RoleDelete');
    o_ajax_request.setPage('../../sub/admin/include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.parent.Dialog_Confirm("真的要删除这个角色吗？",function (){o_ajax_request.SendRequest()});
}
function roleOpenUser(obj)
{
    if (obj.getElementsByTagName('span')[0].innerHTML=='展开')
    {
        obj.getElementsByTagName('span')[0].innerHTML='收起'
        obj.getElementsByTagName('img')[0].src='images/close.png'
        obj.parentNode.getElementsByTagName('div')[0].style.display='block'
        if (obj.parentNode.getElementsByTagName('div')[0].innerHTML==''){
            //发送ajax请求
            var o_ajax_request=new AjaxRequest();
            o_ajax_request.setFunction ('RoleGetUser');
            o_ajax_request.setPage('../../sub/admin/include/it_ajax.svr.php');
            o_ajax_request.PushParameter(obj.parentNode.getElementsByTagName('div')[0].id);
            o_ajax_request.SendRequest()  
        }
    }else{
        obj.getElementsByTagName('span')[0].innerHTML='展开'
        obj.getElementsByTagName('img')[0].src='images/open.png'
        obj.parentNode.getElementsByTagName('div')[0].style.display='none'      
    }
}
function callbackRoleOpenUser(n_id,s_name)
{
    document.getElementById(n_id).innerHTML=s_name
}
///////////////////////////////////////////////////////////角色修改
function submitRoleModify(n_id)
{
    temp=document.getElementById('Vcl_Name').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 角色名称 ] 不能为空")
        return
    }
    var s_id='';
    var a_check=document.getElementsByTagName('input')
    for (var i=0;i<a_check.length;i++)
    {
        if (a_check[i].checked==true)
        {
            s_id=s_id+'<1>' +a_check[i].value           
        }
    }
    if (s_id.length>0)
    {
        s_id=s_id.substr(3,s_id.length)
    }
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('RoleModify');
    o_ajax_request.setPage('../../sub/admin/include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.PushParameter(document.getElementById('Vcl_Name').value);
    o_ajax_request.PushParameter(document.getElementById('Vcl_Explain').value);
    o_ajax_request.PushParameter(s_id);
    o_ajax_request.SendRequest()    
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
}
function callbackRoleModify()
{
    parent.parent.Dialog_Success("编辑角色权限成功！",function(){history.go(-1)})
}

//////////////////////////////////////////////////////////////////部门管理////////////////////////////////////////////////
function submitDetpAdd()
{
    var temp=document.getElementById('Vcl_Name').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 部门名称 ] 不能为空")
        return
    }
   document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
    
}
function deptDelete(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeptDelete');
    o_ajax_request.setPage('../../sub/admin/include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.parent.Dialog_Confirm("真的要删除这个部门吗？",function (){o_ajax_request.SendRequest()});
}
function deptModify(n_deptid,s_name,s_phone,s_fax,s_address,n_type,s_typelist,n_uid,s_uidlist)
{    
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="../../sub/admin/include/bn_submit.svr.php?function=DeptModify"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:400px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            修改部门信息');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock_Editor" align="center" width="400">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;部门名称：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('<input id="Vcl_Name" name="Vcl_Name" size="20" maxlength="20" class="BigInput" value="'+s_name+'" type="text"/>')
    a_arr.push('				</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">&nbsp;&nbsp;上级部门：</td>')
    a_arr.push('			<td class="TableData"><div id="deptvcl"><div></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">&nbsp;&nbsp;电话：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('<input id="Vcl_Phone" name="Vcl_Phone" size="20" maxlength="20" class="BigInput" value="'+s_phone+'" type="text"/> <span>（可选）</span>')
    a_arr.push('			    <input id="Vcl_DeptId" name="Vcl_DeptId"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_deptid+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">&nbsp;&nbsp;传真：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('<input id="Vcl_Fax" name="Vcl_Fax" size="20" maxlength="20" class="BigInput" value="'+s_fax+'" type="text"/> <span>（可选）</span>')
    a_arr.push('				</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap">&nbsp;&nbsp;地址：</td>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('<input id="Vcl_Address" name="Vcl_Address" size="20" maxlength="50" class="BigInput" value="'+s_address+'" type="text"/> <span>（可选）</span>')
    a_arr.push('				</td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="保存" class="submitButton" onclick="submitDeptModify()" type="button"/> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
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
	deptModifyDeptGetDeptVcl(n_deptid) 
}
function deptModifyDeptGetDeptVcl(n_id)
{
//获取弹出对话框部门列表控件
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeptModifyDeptGetDeptVcl');
    o_ajax_request.setPage('../../sub/admin/include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.SendRequest()
}
function callbackDeptModifyDeptGetDeptVcl(s_html)
{
//获取弹出对话框部门列表控件的回调函数
try{
    document.getElementById('deptvcl').innerHTML=s_html;
    }catch(e)
    {
    }
}
function submitDeptModify()
{
    var temp=document.getElementById('Vcl_Name').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 部门名称 ] 不能为空")
        return
    }
   document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
    
}
function showDeptModifySort(s_name,n_deptid,n_number,n_count){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="../../sub/admin/include/bn_submit.svr.php?function=DeptModifySort"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:350px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            顺序修改');
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
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;部门名称：</td>')
    a_arr.push('			<td class="TableData" width="220">')
    a_arr.push(s_name)
    a_arr.push('			    <input id="Vcl_DeptId" name="Vcl_DeptId"')
    a_arr.push('				size="15" maxlength="15" class="BigInput"')
    a_arr.push('				value="'+n_deptid+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;顺序：</td>')
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
//////////////////////////////////////////////////////////////////////////////////////模块管理///////////////////////////////////////////////////////////////////////////
function showModuleModify(s_name,n_moduleid){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="../../sub/admin/include/bn_submit.svr.php?function=ModuleModify"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:350px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            模块信息修改');
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
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">&nbsp;&nbsp;模块名称：</td>')
    a_arr.push('			<td class="TableData" width="220"><input id="Vcl_Name" name="Vcl_Name"')
    a_arr.push('				size="15" maxlength="15" class="BigInput"')
    a_arr.push('				value="'+s_name+'" type="text" />')
    a_arr.push('			    <input id="Vcl_ModuleId" name="Vcl_ModuleId"')
    a_arr.push('				size="15" maxlength="15" class="BigInput"')
    a_arr.push('				value="'+n_moduleid+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="保存" class="submitButton"')
    a_arr.push('				onclick="submitModuleModify()" type="button" /> &nbsp;&nbsp; <input')
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
function submitModuleModify()
{
    var temp=document.getElementById('Vcl_Name').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 模块名称 ] 不能为空")
        return
    }
   document.getElementById('dialog_form').submit();
    if (!is_moz){
        parent.parent.Common_OpenLoading();   
    }
    
}
//////////////////////////////////////////////////////////////////////////////////////系统设置///////////////////////////////////////////////////////////////////////////
function submitGroupAdd()
{
    var temp=document.getElementById('Vcl_Name').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 分组名称 ] 不能为空")
        return
    }
	parent.parent.Common_OpenLoading();   
   	document.getElementById('dialog_form').submit();  
}
function delete_group(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('GroupDelete');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.parent.Dialog_Confirm("真的要删除这个分组吗？",function (){o_ajax_request.SendRequest()});
}
