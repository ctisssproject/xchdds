function Disabled_Vcl(){
    for(var i = 0; i < document.getElementsByTagName("input").length; i++){
        document.getElementsByTagName("input")[i].disabled="disabled"
    }    
}
function Enable_Vcl(){
    for(var i = 0; i < document.getElementsByTagName("input").length; i++){
        document.getElementsByTagName("input")[i].disabled=""
    }    
}
function getExt(path) {
	return path.lastIndexOf('.') == -1 ? '' : path.substr(path.lastIndexOf('.') + 1, path.length).toLowerCase();
}
function getPath(obj){
	if (obj) {
		if (is_ie) {
			obj.select();
			// IE下取得图片的本地路径
			return document.selection.createRange().text;
			
		} else if(is_moz) {
				if (obj.files) {
					// Firefox下取得的是图片的数据
					return obj.files.item(0).getAsDataURL();
				}
				return obj.value;
		}
		return obj.value;
	}
}
var userAgent = navigator.userAgent.toLowerCase();
var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
var is_moz = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);
var is_safari = (userAgent.indexOf('webkit') != -1 || userAgent.indexOf('safari') != -1);
var S_Root='';
function Common_Logout()
{
    Common_OpenLoading()
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('Logout');
    o_ajax_request.setPage(S_Root+'include/it_ajax.svr.php');
    o_ajax_request.SendRequest();
}
function Common_Register(){
    //验证用户输入
    var s_username=document.getElementById('Vcl_UserName').value;
    var s_password1=document.getElementById('Vcl_Password1').value;
    var s_password2=document.getElementById('Vcl_Password2').value;
    var s_email=document.getElementById('Vcl_Email').value;
    var o_showtext=document.getElementById('ShowText')
    if (s_username.length==0){
        o_showtext.innerHTML="用户名不能为空"
        return
    }
    if (s_username.length<4){
        o_showtext.innerHTML="用户名不能小于4个字符"
        return
    }
    if (s_password1.length==0){
        o_showtext.innerHTML="密码不能为空"
        return
    }
    if (s_password1.length<6){
        o_showtext.innerHTML="密码不能小于6个字符"
        return
    }
    if (s_password1!=s_password2){
        o_showtext.innerHTML="两次输入的密码不一致"
        return
    }
    if (s_email.length==0){
        o_showtext.innerHTML="Email不能为空"
        return
    }
    document.getElementById('dialog_form').submit();
    if (!is_moz){
        Common_OpenLoading();   
    }
}
function Common_SubmitLoading(s_formid){
    document.getElementById(s_formid).submit();
    if (!is_moz){
        Common_OpenLoading();   
    } 
}
function Common_Refresh_Submit(){
    window.navigate('www.newcbd.cn')   
    if (!is_moz){
    //window.navigate('http://www.newcbd.cn') 
        history.go(0); 

    }else{
        location.reload()
        //window.navigate('http://www.newcbd.cn') 
    } 
}
function Common_UpdateValidCode() {
	var s_img = S_Root+'include/bn_submit.svr.php?function=ValidCode&parameter='+Math.random();		
	if(document.getElementById('validcode')) {
		document.getElementById('validcode').innerHTML='<img src="'+s_img+'" align="absmiddle" style="width:100px; height:40px">'
	}
}

function Common_Reg_PassWord_Safe()
{
    try
    {
        var s_upper ='ABCDEFGHIJKLMNOPQRSTUVWXWZ'
        var s_lower ='abcdefghijklmnopqrstuvwxyz'
        var s_sign=' `-=\\[];\',./*-+~!@#$%^&*()_+|'
        var n_number=1;
        var o_showcolor=document.getElementById('vcl_password1_safe_color');
        var o_showtext=document.getElementById('vcl_password1_safe_text');
        var o_pass=document.getElementById('Vcl_Password1').value;
        var s_width='0px';
        var s_text='';
        var s_color='#FFFFFF';
        if (o_pass.length==0){
            o_showtext.innerHTML='密码安全程度： '+s_text;
            o_showcolor.style.width=s_width;
            o_showcolor.style.backgroundColor=s_color;
            return        
        }         

        if (o_pass.length>=12)
        {
            n_number=n_number+1;
        }
        for(var i=0;i<o_pass.length;i++)
        {
            if (s_upper.indexOf(o_pass.substr(i, 1))>-1 && o_pass.length>5){
                n_number=n_number+1;
                i=o_pass.length+1
            }
        }
        for(var i=0;i<o_pass.length;i++)
        {
            if (s_lower.indexOf(o_pass.substr(i, 1))>-1 && o_pass.length>5){
                n_number=n_number+1;
                i=o_pass.length+1
            }
        }
        for(var i=0;i<o_pass.length;i++)
        {
            if (s_sign.indexOf(o_pass.substr(i, 1))>-1 && o_pass.length>5){
                n_number=n_number+1;
                i=o_pass.length+1
            }
        }
        switch (n_number)
        {
            case 1:
                s_width='40px';
                s_text='<span style="color:#FF0000">非常弱</span>';
                s_color='#FF0000';
                break; 
            case 2:
                s_width='80px';
                s_text='<span style="color:#FF6600">比较弱</span>';
                s_color='#FF6600';
                break;
            case 3:
                s_width='120px';
                s_text='<span style="color:#0099CC">一般程度</span>';
                s_color='#0099CC';
                break; 
            case 4:
                s_width='160px';
                s_text='<span style="color:#009900">比较强</span>';
                s_color='#009900';
                break; 
            case 5:
                s_width='200px';
                s_text='<span style="color:#006600">非常强悍</span>';
                s_color='#006600';
                break; 
            default:
                break;
	    }
        o_showtext.innerHTML='密码安全程度： '+s_text;
        o_showcolor.style.width=s_width;
        o_showcolor.style.backgroundColor=s_color;
    }catch(e)
    {
    }
}
function Common_TextTotal(s_vclid,s_textid,n_number){//统计还可输入多少文字
    var o_vcl=document.getElementById(s_vclid)
    var o_output=document.getElementById(s_textid)
    var s_text=o_vcl.value;
    o_vcl.value=s_text.substring(0,n_number)
    o_output.innerHTML=n_number-s_text.length
}
function Common_ShowPage(s_site_map,s_content){  
    var o_content=document.getElementById('content');
    var o_site_map=document.getElementById('site_map');
    o_content.innerHTML=s_content;
    o_site_map.innerHTML=s_site_map;
    Common_CloseDialog()
} 
function goLoginPage(s_root)
{
    if (s_root==null)
    {
    s_root=S_Root
    }
    try
    {
        parent.parent.window.open(s_root+'index.php','_parent')
        return
    }
    catch(e)
    {
    }
    try
    {
        parent.window.open(s_root+'index.php','_parent')
        return
    }
    catch(e)
    {
    }
    try
    {
        window.open(s_root+'index.php','_parent')
        return
    }
    catch(e)
    {
    }
}
function inputTipText(o_obj,s_text)
{
    o_obj.value=s_text;
    o_obj.style.color='#8896A0';
    o_obj.onmouseover=function(){
        if(o_obj.value==s_text)
        {
            o_obj.style.color='#000000';
        }
    }
    o_obj.onmouseout=function(){
        if(o_obj.value==s_text)
        {
            o_obj.style.color='#8896A0';
        }
    }
    o_obj.onfocus=function(){
        if(o_obj.value==s_text)
        {
            o_obj.value='';
            o_obj.style.color='#000000';
        }
    }
    o_obj.onblur=function(){
        if(o_obj.value=='')
        {
            o_obj.value=s_text;
            o_obj.style.color='#8896A0';
        }
    }
}
//用于传递转换为日志的参数
var N_Year=0;
var N_Month=0;
var N_Day=0;
var S_Time=''
var S_Address='';
var S_Content='';
//-----------------------
function checkIE()
{
    var isIE = (document.all) ? true : false;
    var isIE6 = isIE && ([/MSIE (\d)\.0/i.exec(navigator.userAgent)][0][1] == 6);
    if(isIE6)
    {
        window.alert("您的IE浏览器版本过低！！\n\n为了不影响网站整体观看效果\n\n请您使用IE 8.0以上的浏览器浏览。")
    }
}
function refresh_menu_notice_callback(number,id)
{
	
    if (number==0)
    {
        var old=parent.parent.$('.'+id+' span').html();
        old='<div style="float:left"><span>'+old+'</span></div>'
        parent.parent.$('.'+id).html(old);   
    }else{
        var old=parent.parent.$('.'+id+' span').html();
        old='<div style="float:left"><span>'+old+'</span></div>'
        var html='<div class="menu_notice" style="margin-left:-14px;margin-top:1px;background-color:#FF6600;padding-top:0px;line-height:10px;padding-left:2px;padding-right:2px;padding-bottom:1px;">'+number+'</div>'
        parent.parent.$('.'+id).html(old+html);   
    }
    run_command();
}
function run_command()
{
	try{
	    if (Command.length>0)
	    {
	        for(var i=0;i<Command.length;i++)
	        {
	            if (Command[i]!='')
	            {
	                var temp=Command[i];
	                Command[i]='';
	                eval(temp)
	                break;
	            }
	        }
	    }   
	}catch(e)
    {
    }
}
function refresh_menu_notice(id,path,type)
{
    var o_ajax_request = new AjaxRequest();
    o_ajax_request.setFunction('RefreshMenuNotice');
	o_ajax_request.setPage(path);
    o_ajax_request.PushParameter(id);
	o_ajax_request.PushParameter(type);
    o_ajax_request.SendRequest(); 
}




