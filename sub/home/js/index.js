    $(function(){
        $("#KinSlideshow").KinSlideshow({
                intervalTime:5,
                moveSpeedTime:400,
                moveStyle:"left",
                titleBar:{titleBar_height:30,titleBar_bgColor:"#000000",titleBar_alpha:0.5},
                titleFont:{TitleFont_size:14,TitleFont_color:"#FFFFFF"},
                btn:{btn_bgColor:"#940000",btn_bgHoverColor:"#ECC2C3",btn_fontColor:"#FFFFFF",
                     btn_fontHoverColor:"#333333",btn_borderColor:"#940000",
                     btn_borderHoverColor:"#ECC2C3",btn_borderWidth:1,btn_bgAlpha:1}
        });
        N_FloatTimer=window.setInterval(startFloat,100)
    })
 
var N_FloatTimer=0
function startFloat()
{
    
    var ch = document.compatMode == "BackCompat"?document.body.clientHeight:document.documentElement.clientHeight;
    var cw = document.compatMode == "BackCompat"?document.body.clientWidth:document.documentElement.clientWidth;
    var st = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    var sl = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);  
    $(".float_box").css('top', (st+140)+'px'); 
    $(".float_box").css('left', (cw-304)+'px');
    if ($(".float_box").is(":hidden"))
    {
        $(".float_box").show(500); 
    }
    

}
function stopFloat()
{
    window.clearInterval(N_FloatTimer)
    $(".float_box").hide(500);  
}
function AddFavorite(sURL, sTitle) 
{ 
    try 
    { 
        window.external.addFavorite(sURL, sTitle); 
    } 
    catch (e) 
    { 
        try 
        { 
            window.sidebar.addPanel(sTitle, sURL, ""); 
        } 
        catch (e) 
        { 
            alert("加入收藏失败，请使用Ctrl+D进行添加"); 
        } 
    } 
} 
function SetHome(obj,vrl){ 
    try{ 
        obj.style.behavior='url(#default#homepage)';obj.setHomePage(vrl); 
    } 
    catch(e){ 
        if(window.netscape) { 
        try { 
            netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect"); 
        } 
        catch (e) { 
            alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。"); 
        } 
        var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch); 
        prefs.setCharPref('browser.startup.homepage',vrl); 
        } 
    } 
} 
function checkIE()
{
    var isIE = (document.all) ? true : false;
    var isIE6 = isIE && ([/MSIE (\d)\.0/i.exec(navigator.userAgent)][0][1] == 6);
    if(isIE6)
    {
        window.alert("您的IE浏览器版本过低！！\n\n为了不影响网站整体观看效果\n\n请您使用IE 8.0以上的浏览器浏览。")
    }
}
function navMenuOpen(id)
{
    for (var i=0;i<20;i++)
    {
        if (i==id)
        {
            if ($('#menu'+id).is(":hidden"))
            {
                $('#menu'+id).slideToggle()
            }
        }else{
            if ($('#menu'+id).is(":hidden"))
            {
                $('#menu'+id).slideToggle()
            }else{
                $('#menu'+i).slideToggle()
            }
            
        }

    }
}
function submitComment()
{
    var s_temp=document.getElementById('Vcl_Content').value
    if (s_temp.length==0)
    {
        window.alert("评论内容不能为空！")
        return
    }
    document.getElementById('dialog_form').submit();
}
function submitMessages()
{
    var s_temp=document.getElementById('Vcl_Title').value
    if (s_temp.length==0)
    {
        window.alert("标题内容不能为空！")
        return
    }
    var s_temp=document.getElementById('Vcl_Content').value
    if (s_temp.length==0)
    {
        window.alert("留言内容不能为空！")
        return
    }
    document.getElementById('dialog_form2').submit();
}
function submitMessagesCallback()
{
    window.alert('留言提交成功！等待管理员回复后才可查看您的留言！')
    location.reload()
}
function commentDelete(id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('CommentDelete');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(id);
    if (window.confirm("真的要删除这条评论吗？")==true)
    {
    	o_ajax_request.SendRequest()
    }
}
function submitCommentCallback()
{
    window.alert('评论发表成功！')
    location.reload()
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
function goToBookSearch(id)
{
    if (document.getElementById(id).value=='ISBN、书名、作者、出版社' || encodeURIComponent(document.getElementById(id).value)=='' )
    {
    	location='index_book.php';
        return;
    }
    var s_content='?key='+encodeURIComponent(document.getElementById(id).value)
    location='index_book.php'+s_content;
}