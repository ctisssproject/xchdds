var N_Dialog_TimeHandle=0
var N_Dialog_Width=0
var N_Dialog_Height=0
var TimeHandle=0
var O_Func
function Dialog_Error(s_message,o_func){
    var o_obj=document.getElementById('master_box');
    O_Func=o_func
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=200
	N_Dialog_Width=316
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(Dialog_GetFrame('错误提示',s_message ,0 ));	
}
function Dialog_Success(s_message,o_func){
    var o_obj=document.getElementById('master_box');
    O_Func=o_func
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=200
	N_Dialog_Width=316
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(Dialog_GetFrame('成功提示',s_message ,0 ));	
}
function Dialog_Message(s_message,o_func){
    var o_obj=document.getElementById('master_box');
    O_Func=o_func
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=200
	N_Dialog_Width=316
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(Dialog_GetFrame('系统提示',s_message ,0 ));	
}
function Dialog_Confirm(s_message,o_func){
    var o_obj=document.getElementById('master_box');
    O_Func=o_func
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=200
	N_Dialog_Width=316
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(Dialog_GetFrame('确定提示',s_message ,1 ));	
}
function Common_OpenLoading(){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<table border="0" cellspacing="0" cellpadding="0" style="width:187px; height:50px">');
    a_arr.push('<tbody>')
    a_arr.push('<tr>')
    a_arr.push('<td class="dialog_loading">');
    a_arr.push('读取中 ...');
    a_arr.push('</td>')
    a_arr.push('<td>');
    a_arr.push('<div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton" onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'"></div>')
    a_arr.push('</td>')
    a_arr.push('</tr>')
    a_arr.push('</tbody>')
    a_arr.push('</table>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=46
	N_Dialog_Width=204
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n')); 
	Disabled_Vcl()//禁用控件   
}
function Dialog_Ok_Button(){
    Common_CloseDialog()
    if(O_Func){
        O_Func();
    }
}
function stopEvent(event){//阻止一切事件执行,包括浏览器默认的事件
	event = window.event||event;
	if(!event){
		return;
	}
	event.cancelBubble = true
	event.returnValue = false;
}
function Dialog_GetFrame(s_title,s_message,n_type){
    var a_arr=[];
    var button='Common_CloseDialog()'
    if (n_type==0){
        button='Dialog_Ok_Button()'
    }
    var s_icon=''
    switch (s_title){
        case '错误提示':
            s_icon='dialog_icon_error'
            break; 
        case '成功提示':
            s_icon='dialog_icon_success'
            break; 
        case '系统提示':
            s_icon='dialog_icon_message'
            break; 
        case '确定提示':
            s_icon='dialog_icon_confirm'
            break; 
        default:	            
            s_icon='dialog_icon_message'                   
            break
    }
    a_arr.push('<table style="width: 300px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            '+s_title+'');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="'+button+'" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table style="width: 300px; height: 100px" border="0" cellspacing="0" cellpadding="0"');
    a_arr.push('    class="dialog">');
    a_arr.push('    <tr>');
    a_arr.push('        <td style="width: 30%" class="'+s_icon+'">');
    a_arr.push('            &nbsp;');
    a_arr.push('        </td>');
    a_arr.push('        <td class="dialog_message">');
    a_arr.push(s_message);
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table style="width: 300px;" border="0" cellspacing="0" cellpadding="0" class="dialog_button_table">');
    a_arr.push('    <tr>');
    a_arr.push('        <td style="text-align: center">');
    if (n_type==0){
        a_arr.push('            <input id="Vcl_Dialog_Ok" type="button" value="确定" class="submitButton" onclick="'+button+'" />');
    }else{
        a_arr.push('            <input id="Vcl_Dialog_Ok" type="button" value="确定" class="submitButton" onclick="Dialog_Ok_Button()" />');
        a_arr.push('            <input id="Vcl_Dialog_Cancel" type="button" value="取消" class="submitButton2" onclick="Common_CloseDialog()" />');
        
    }    
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
	return a_arr.join('\n')
}
function Common_CloseDialog(){
    var o_obj=document.getElementById('master_box');
    o_obj.style.top='-1000px';
    o_obj.innerHTML='';
    N_Dialog_Width=0
    N_Dialog_Height=0
    
    window.clearInterval(TimeHandle);
    window.clearInterval(N_Dialog_TimeHandle);
    Enable_Vcl()//启用控件
}
function Dialog_SetPosition(){
    var ch = document.compatMode == "BackCompat"?document.body.clientHeight:document.documentElement.clientHeight;
    var cw = document.compatMode == "BackCompat"?document.body.clientWidth:document.documentElement.clientWidth;
    var st = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    var sl = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
    var _div=document.getElementById("master_box");
    _div.style.top=((ch - N_Dialog_Height) / 2 + st)+'px';
    _div.style.left = ((cw - N_Dialog_Width) / 2 +sl)+'px';
}
function Dialog_GetBorder(s_content)
{
    var a_arr=[];
    a_arr.push('<table border="0" cellspacing="0" cellpadding="0">')
    a_arr.push('<tbody>')
    a_arr.push('<tr>')
	a_arr.push('<td width="8" height="8" class="dialog_border">');
    a_arr.push('</td>')
	a_arr.push('<td class="dialog_border">');
    a_arr.push('</td>')
	a_arr.push('<td width="8" height="8" class="dialog_border">');
    a_arr.push('</td>')
    a_arr.push('</tr>')
    a_arr.push('<tr>')
	a_arr.push('<td class="dialog_border">');
    a_arr.push('</td>')
    a_arr.push('<td style="vertical-align: top; background-color:#FFFFFF">')
    a_arr.push(s_content)    
    a_arr.push('</td>')
	a_arr.push('<td class="dialog_border">');
    a_arr.push('</td>')
    a_arr.push('</tr>')
    a_arr.push('<tr>')
	a_arr.push('<td width="8" class="dialog_border"></td>');
	a_arr.push('<td height="8" class="dialog_border"></td>');
	a_arr.push('<td width="8" class="dialog_border"></td>');
    a_arr.push('</tr>')
    a_arr.push('</tbody>')
    a_arr.push('</table>')
    return a_arr.join('\n')
}
function Dialog_GetLoginFrame(s_username){
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form" action="'+S_Root+'include/bn_submit.svr.php?function=Login"');
    a_arr.push('enctype="multipart/form-data" target="ajax_submit_frame" style="width: 450px">');
    a_arr.push('<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            用户登录');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table width="100%" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr style="vertical-align: bottom; height: 60px">');
    a_arr.push('        <td style="text-align: right; width: 22%; height: 60px; padding-bottom: 5px; ">');
    a_arr.push('            <input id="vcl_Text1" type="text" class="txt" readonly="readonly" style="border-right-style: solid;');
    a_arr.push('                border-right-width: 0px; padding-left: 5px; width: 70px;" value="用户名 　：" />');
    a_arr.push('        </td>');
    a_arr.push('        <td style="padding-bottom: 5px; ">');
    a_arr.push('            <input id="Vcl_UserName" name="Vcl_UserName" type="text" class="txt"');
    a_arr.push('                style="border-left-style: solid; border-left-width: 0px; width: 200px" maxlength="30"');
    a_arr.push('                tabindex="1" value="'+s_username+'" />');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 28%; font-size: 14px; vertical-align: middle;" rowspan="2">');
    a_arr.push('            没有帐号? <a href="javascript:Dialog_Register(\'\',\'\',\'\',\'\',\'\');" class="f_14_4">注册</a>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('    <tr style="vertical-align: top;height: 60px">');
    a_arr.push('        <td style="text-align: right; height: 60px; padding-top: 5px">');
    a_arr.push('            <input id="vcl_Text2" type="text" class="txt" readonly="readonly" style="border-right-style: solid;');
    a_arr.push('                border-right-width: 0px; padding-left: 5px; width: 70px;" value="密　码 　：" />');
    a_arr.push('        </td>');
    a_arr.push('        <td style="padding-top: 5px">');
    a_arr.push('            <input id="Vcl_Password" name="Vcl_Password" type="password" class="txt"');
    a_arr.push('                style="border-left-style: solid; border-left-width: 0px; width: 200px" maxlength="50"');
    a_arr.push('                tabindex="2" />');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" class="dialog_button_table">');
    a_arr.push('    <tr>');
    a_arr.push('        <td style="text-align: center">');
    a_arr.push('            <input id="Submit1" type="submit" value="登录" class="submitButton" onclick="javascript:Common_SubmitLoading(\'dialog_form\');" />');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('</form>');
    return a_arr.join('\n')
}
function Dialog_GetRegisterFrame(s_username,s_password,s_password2,s_email,s_code){
    
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form" action="'+S_Root+'include/bn_submit.svr.php?function=Register"');
    a_arr.push('enctype="multipart/form-data" target="ajax_submit_frame" style="width: 520px">');
    a_arr.push('<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            注册本站用户&nbsp;&nbsp;&nbsp;&nbsp;<span id="ShowText" style="color: Red; font-size:12px; font-weight:normal"></span>');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" class="dialog">');
    a_arr.push('    <tr>');
    a_arr.push('        <td style="width: 10%" rowspan="6">');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 15%">');
    a_arr.push('            用户名:');
    a_arr.push('        </td>');
    a_arr.push('        <td>');
    a_arr.push('            <input id="Vcl_UserName" name="Vcl_UserName" type="text" class="txt" tabindex="1" value="'+s_username+'" style="width:200px" maxlength="15" />');
    a_arr.push('            *');
    a_arr.push('        </td>');
    
    a_arr.push('        <td rowspan="6" style="width: 25%; font-size: 14px; vertical-align: middle;">');
    a_arr.push('            已有帐号? <a href="javascript:Dialog_Login(\'\');" class="f_14_4">登录</a>');
    a_arr.push('        </td>');
    
    a_arr.push('    </tr>');
    a_arr.push('    <tr>');
    a_arr.push('        <td style="height:70px;">');
    a_arr.push('            注册密码:');
    a_arr.push('        </td>');
    a_arr.push('        <td>');
    a_arr.push('            <input id="Vcl_Password1" name="Vcl_Password1" type="password" class="txt" onkeyup="Common_Reg_PassWord_Safe();" tabindex="2" value="'+s_password+'" style="width:200px" maxlength="50" />');
    a_arr.push('            *');
    a_arr.push('                            <div id="vcl_password1_safe_text">');
    a_arr.push('                            密码安全程度：</div>');
    a_arr.push('                        <div style="width: 200px; height: 10px; background-color: #E0E0E0; font-size: 0px;');
    a_arr.push('                            line-height: 0px">');
    a_arr.push('                            <div id="vcl_password1_safe_color" style="width: 255px; width: 0px; height: 10px;');
    a_arr.push('                                background-color: #E0E0E0; font-size: 0px; line-height: 0px">');
    a_arr.push('                            </div>');
    a_arr.push('                        </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('    <tr>');
    a_arr.push('        <td>');
    a_arr.push('            确认密码:');
    a_arr.push('        </td>');
    a_arr.push('        <td>');
    a_arr.push('            <input id="Vcl_Password2" name="Vcl_Password2" type="password" class="txt" tabindex="3" value="'+s_password2+'" style="width:200px" maxlength="50" />');
    a_arr.push('            *');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('    <tr>');
    a_arr.push('        <td>');
    a_arr.push('            Email:');
    a_arr.push('        </td>');
    a_arr.push('        <td>');
    a_arr.push('            <input id="Vcl_Email" name="Vcl_Email" type="text" class="txt" value="'+s_email+'" tabindex="4" style="width:200px" maxlength="20" />');
    a_arr.push('            *');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('    <tr>');
    a_arr.push('        <td>');
    a_arr.push('        </td>');
    a_arr.push('        <td>');
    a_arr.push('            <div id="validcode" name="validcode"></div>');
    a_arr.push('             <div>请输入上面的4位字母或数字<br/>看不清可<a href="javascript:Common_UpdateValidCode()" class="f_12_4">更换一张</a></div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('    <tr>');
    a_arr.push('        <td>');
    a_arr.push('            验证码:');
    a_arr.push('        </td>');
    a_arr.push('        <td>');
    a_arr.push('            <input id="Vcl_Code" name="Vcl_Code" type="text" class="txt" value="'+s_code+'" tabindex="5" style="width:200px" maxlength="20" />');
    a_arr.push('            *');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('    <tr>');
    a_arr.push('        <td style="height:10px;" colspan="3">');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" class="dialog_button_table">');
    a_arr.push('    <tr>');
    a_arr.push('        <td style="text-align: center">');
    a_arr.push('            <input id="Submit1" type="button" value="提交" class="submitButton" tabindex="6" onclick="Common_Register()" />');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('</form>');
    return a_arr.join('\n')
}
function Dialog_Login(s_username){
    var o_obj=document.getElementById('master_box');
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=230
	N_Dialog_Width=465
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(Dialog_GetLoginFrame(s_username));	
}
function Dialog_Register(s_username,s_password,s_password2,s_email,s_code){
    var o_obj=document.getElementById('master_box');
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=412
	N_Dialog_Width=535
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(Dialog_GetRegisterFrame(s_username,s_password,s_password2,s_email,s_code));
	var s_img = S_Root+'include/bn_submit.svr.php?function=ValidCode&parameter='+Math.random();	
	document.getElementById('validcode').innerHTML='<img src="'+s_img+'" align="absmiddle" style="width:100px; height:40px">'
}
function Common_DisplayIcon(s_content){ 
    var obj=document.getElementById('master_box');
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=243
	N_Dialog_Width=316
	obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
    var arr=[];    
    arr.push('<table style="width:100%;" border="0" cellspacing="0" cellpadding="0">')
    arr.push('    <tr>')
    arr.push('        <td class="dialog_title">选择主题图标')
    arr.push('        <span id="message_hint" style="color: Red;font-size:12px;font-weight:normal;padding-left:20px"></span></td>')
    arr.push('        <td style="width: 10%">')
    arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"')
    arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">')
    arr.push('            </div>')
    arr.push('        </td>')
    arr.push('    </tr>')
    arr.push('</table>')
    arr.push(s_content)	
    obj.innerHTML=Dialog_GetBorder(arr.join('\n'));  
}
/////////////////////////////////////////////////////////////////上传进度条
function uploadProgressBar()
{
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<table border="0" cellspacing="0" cellpadding="0" style="width:187px; height:50px">');
    a_arr.push('<tbody>')
    a_arr.push('<tr>')
    a_arr.push('<td class="dialog_progress">');
    a_arr.push('进度');
    a_arr.push('</td>')
    a_arr.push('<td>');
    a_arr.push('进度');
    a_arr.push('</td>')
    a_arr.push('<td>');
    a_arr.push('<div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton" onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'"></div>')
    a_arr.push('</td>')
    a_arr.push('</tr>')
    a_arr.push('</tbody>')
    a_arr.push('</table>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=46
	N_Dialog_Width=204
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n')); 
	Disabled_Vcl()//禁用控件   
} 