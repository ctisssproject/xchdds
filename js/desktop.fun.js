var N_nav1_sum=1//一级导航的个数
var A_Module=[]
var A_Number=[]
function changeNav1Tab(n_number){//一级导航切换
    //设置所有的一级导航,二级导航,和页面内容为不活动
    var o_nav1=''; 
    for(var i = 1; i < 30; i++){
        o_nav1=document.getElementById('nav1_'+i);         
        if (o_nav1==null) {
            break;
        }
        o_nav1.className='';
        var o_nav2=document.getElementById('nav2_'+i); 
        o_nav2.style.display='none';
        var content=document.getElementById('content_'+i); 
        content.style.display='none';
    }
    showNav1Tab(n_number)
}
function closeNav1Tab(n_number){//一级导航关闭
    //删除一级导航
    var o_nav1=document.getElementById('nav1_'+n_number);
    o_nav1.className='';
    o_nav1.style.display='none';
    o_nav1.innerHTML='';
    o_nav1.style.position='absolute'
    //删除二级级导航
    var o_nav2=document.getElementById('nav2_'+n_number);
    o_nav2.className='';
    o_nav2.style.display='none';
    o_nav2.innerHTML='';
    o_nav2.style.position='absolute'
    //删除二级级导航
    var o_content=document.getElementById('content_'+n_number);
    o_content.className='';
    o_content.style.display='none';
    o_content.innerHTML='';
    o_content.style.position='absolute'
    //记录模块标签的数组清除moduleid
    for(var i = 0; i < A_Number.length; i++){
        if (A_Number[i]==n_number)
        {
            A_Module[i]=''
            break
        }
    } 
    //把标签的主动权给它上一个标签
    for(var i = A_Number.length-1; i >= 0; i--){
        if (A_Module[i]!='')
        {
          showNav1Tab(A_Number[i])
          return
        }
    } 
    showNav1Tab(1)            
}
function showNav1Tab(n_number){//直接设置一级导航为活动
    var o_nav1=document.getElementById('nav1_'+n_number);
    o_nav1.className='selected'; 
    var o_nav2=document.getElementById('nav2_'+n_number); 
    o_nav2.style.display='block';
    var content=document.getElementById('content_'+n_number); 
    content.style.display='block';
    if (n_number==1)
    {
    //如果点击的是桌面，则刷新图标和系统消息
        document.getElementById('content_1_iframe').contentWindow.desktopRefresh();
        sysmsgRead()
    }
    resizeLayout()
}
function addTab(n_module_id,n_sub)
{
    //检查是否这个模块已经被打开，如果被打开了，就直接跳转过去，不在发送ajax请求
    for(var i = 0; i < A_Module.length; i++){
        if (A_Module[i]==n_module_id)
        {
            changeNav1Tab(A_Number[i])
            return
        }
    }
    Common_OpenLoading()
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('AddTab');
    o_ajax_request.setPage(S_Root+'include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_module_id);
    o_ajax_request.PushParameter(n_sub);
    o_ajax_request.SendRequest();
    A_Module.push(n_module_id);
    A_Number.push(N_nav1_sum+1)
    if (!is_moz){
        Common_OpenLoading();   
    } 
    //addTabCallBack('消息盒子','短消息<1>事务提醒','sub/sms/msg.html<1>sub/sms/rem.html')
}
function addTabForRefresh(n_module_id,n_sub)
{
    //检查是否这个模块已经被打开，如果被打开了，就直接跳转过去，不在发送ajax请求
    for(var i = 0; i < A_Module.length; i++){
        if (A_Module[i]==n_module_id)
        {
            //changeNav1Tab(A_Number[i])
            closeNav1Tab(A_Number[i])
            //return
        }
    }
    Common_OpenLoading()
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('AddTab');
    o_ajax_request.setPage(S_Root+'include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_module_id);
    o_ajax_request.PushParameter(n_sub);
    o_ajax_request.SendRequest();
    A_Module.push(n_module_id);
    A_Number.push(N_nav1_sum+1)
    if (!is_moz){
        Common_OpenLoading();   
    } 
}
function addTabCallBack(s_nav1_name,s_nav2_name,s_nav2_url,n_select)
{
	
    var a_name=[]
    if (s_nav2_name!='')
    {
        a_name=s_nav2_name.split("<1>")
    }
    var a_url=s_nav2_url.split("<1>")
    var n_number=N_nav1_sum+1
    N_nav1_sum=n_number
    //构建一级导航
    var o_tabs_container=parent.document.getElementById('tabs_container');
    var a_arr=[];
    a_arr.push('<div id="nav1_'+n_number+'">');
    a_arr.push('    <a class="tab" hidefocus="hidefocus" closable="true" href="javascript:changeNav1Tab('+n_number+');">'+s_nav1_name+'</a> ');
    a_arr.push('    <a class="close" hidefocus="hidefocus" href="javascript:closeNav1Tab('+n_number+');"></a>');
    a_arr.push('</div>');
	o_tabs_container.innerHTML=o_tabs_container.innerHTML+a_arr.join('\n')
	//构建二级导航
	var o_funcbar_left=parent.document.getElementById('funcbar_left');
    var a_arr=[];
    var s_url='';
    a_arr.push('<div style="display: none; left: 182px;" id="nav2_'+n_number+'" class="second-tabs-container">');
    //if (a_name.length>1)
    //{
        for(var i = 0; i < a_name.length; i++){
            if (i==n_select)
            {
                s_url=a_url[n_select]
            }
            var s_class='last'
            if (i==n_select)
            {
                s_class='active'
            }
            if (a_name[i]!='')
            {
				var temp=a_url[i].replace('.',"_")
                temp=temp.replace('/',"_")
                temp=temp.replace('/',"_")
                a_arr.push('    <a class="'+s_class+' '+temp+'" title="" id="nav2_'+n_number+'_'+(i+1)+'" href="javascript:changeNav2Tab('+n_number+','+(i+1)+',\''+a_url[i]+'\');"');
                a_arr.push('    hidefocus="hidefocus"><span>'+a_name[i]+'</span></a>');
            }
        }
    //}
    if (s_url=='')
    {
        s_url=a_url[0]
    }
    a_arr.push('</div>');
    o_funcbar_left.innerHTML=o_funcbar_left.innerHTML+a_arr.join('\n')
    //构建内容页面
    var o_center=parent.document.getElementById('center');
    var a_arr=[];
    a_arr.push('<iframe id="content_'+n_number+'_iframe" style="width: 100%;" src="'+s_url+'" marginwidth="0" marginheight="0" frameborder="0"');
    a_arr.push('framespacing="0" border="0" allowtransparency="true"></iframe>');
    var inputNode = document.createElement("div");
    inputNode.setAttribute("id", 'content_'+n_number);
    inputNode.setAttribute("class",'tab-panel selected');
    inputNode.setAttribute("style",'height: 100%;display:none');
    o_center.appendChild(inputNode)
    o_center=parent.document.getElementById('content_'+n_number);
    o_center.innerHTML=o_center.innerHTML+a_arr.join('\n')
    changeNav1Tab(n_number)
    Common_CloseDialog()
}
function changeNav2Tab(n_nav1,n_nav2,s_url)
{
	var temp=s_url.replace('.',"_")
    temp=temp.replace('/',"_")
    temp=temp.replace('/',"_")
    var o_nav2='';
    for(var i = 1; i < 30; i++){
        o_nav2=document.getElementById('nav2_'+n_nav1+'_'+i)        
        if (o_nav2==null) {
            break;
        }
        var temp2=o_nav2.className
        temp2=temp2.split(" ")
        if (temp2.length>1)
        {
            o_nav2.className='last '+temp2[1];
        }else{
            o_nav2.className='last';
        }
    }
    var o_nav2=document.getElementById('nav2_'+n_nav1+'_'+n_nav2)
    o_nav2.className='active '+ temp   
    goToUrl(n_nav1,s_url)
}
function goToUrl(n_number,s_url)
{
    var o_ifram=document.getElementById('content_'+n_number+'_iframe');
    o_ifram.src=s_url
}
function resizeLayout()
   {
      // 主操作区域高度
      var wWidth = (window.document.documentElement.clientWidth || window.document.body.clientWidth || window.innerHeight);
      var wHeight = (window.document.documentElement.clientHeight || window.document.body.clientHeight || window.innerHeight);
      var nHeight = $('#north').is(':visible') ? $('#north').outerHeight() : 0;
      var fHeight = $('#funcbar').is(':visible') ? $('#funcbar').outerHeight() : 0;
      var cHeight = wHeight - nHeight - fHeight - $('#south').outerHeight() - $('#taskbar').outerHeight();
      $('#center').height(cHeight);
      $("#center iframe").css({height: cHeight});
      $('#sysmsg').css({left: wWidth-250});
      $('#sysmsg').css({top: wHeight-220});
      $('#org_panel').css({left: wWidth-268});
      $('#org_panel').css({top: wHeight-445});
      try{
           if (document.getElementById('north').style.display=='none')
           {
                $('#start_menu_panel').css({top: 37});
           }else{
                $('#start_menu_panel').css({top: 115});
           }
      }catch(e)
      {
      }
/*
      if(isTouchDevice())
      {
         $('.tabs-panel:visible').height(cHeight);
         if($('.tabs-panel > iframe:visible').height() > cHeight)
            $('.tabs-panel:visible').height($('.tabs-panel > iframe:visible').height());
      }
*/
      //一级标签宽度
      var width = wWidth - $('#taskbar_left').outerWidth() - $('#taskbar_right').outerWidth();
      $('#tabs_container').width(width - $('#tabs_left_scroll').outerWidth() - $('#tabs_right_scroll').outerWidth() - 2);
      $('#taskbar_center').width(width-1);   //-1是为了兼容iPad
      $('#tabs_container').triggerHandler('_resize');
   };
 try{
    $(function(){resizeLayout();});
    $(window).resize(function(){resizeLayout();});
    $.extend({sysmsg_close:function(){$("#sysmsg").fadeOut()}});
    $.extend({sysmsg_open:function(){$("#sysmsg").fadeIn()}});
    $.extend({org_close:function(){$("#org_panel").fadeOut()}});
    $.extend({org_open:function(){$("#org_panel").fadeIn()}});
 }catch(e)
{
} 

/////////////////////////////////////////////////////////////////////////////////弹出系统消息///////////////////////////////////////////////////////////////
function sysmsgRead()
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('SysmsgRead');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.SendRequest()
}
function callbackSysmsgRead(s_parentid,s_moduleid,s_number,s_text)
{
    if (s_parentid.length==0)
    {
        return;
    }
    var a_parentid=s_parentid.split("<1>")
    var a_moduleid=s_moduleid.split("<1>")
    var a_number=s_number.split("<1>")
    var a_text=s_text.split("<1>")
    var o_div=document.getElementById('sysmsg_content')
    for (var i=0;i<a_moduleid.length;i++)
    {
        var o_divsub=document.getElementById('smg_'+a_parentid[i]+a_moduleid[i]);         
        if (o_divsub==null) {
           //直接显示
           var temp='<div id="smg_'+a_parentid[i]+a_moduleid[i]+'"><a href="javascript:;" onclick="sysmsgOnclick(this);addTabForRefresh('+a_parentid[i]+','+a_moduleid[i]+');" title="点击查看">您有<span>'+a_number[i]+'</span>条'+a_text[i]+'</a></div>'
           o_div.innerHTML=o_div.innerHTML+temp
        }else{
           //如果有,则数字加上新来的数字
           o_divsub=o_divsub.getElementsByTagName('span')[0]
           o_divsub.innerHTML=Number(o_divsub.innerHTML)+Number(a_number[i])
        }
    }
    $.sysmsg_open()
}
function sysmsgClose()
{
    var o_div=document.getElementById('sysmsg_content')
    o_div.innerHTML='';
    $.sysmsg_close()
}
function sysmsgOnclick(obj)
{
    obj.parentNode.id=''
    obj.parentNode.className='clicked'
    obj.parentNode.innerHTML=obj.innerHTML  
    var a_div=document.getElementById('sysmsg_content').getElementsByTagName('div')
    var b_id=false;
    for(var i=0;i<a_div.length;i++)
    {
        if (a_div[i].id!='')
        {
            b_id=true
            break;
        }
    }
    if (b_id==false)
    {
        sysmsgClose()
    }
}
/////////////////////////////////////////////////////////////////////////////////桌面///////////////////////////////////////////////////////////////
function desktopRefresh()
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DesktopRefresh');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.SendRequest()
}
function callbackDesktopRefresh(s_html,s_moduleid)
{
    try{
        $('#ui-sortable').html('')
        $('#master_box').html(s_html)
        if (s_moduleid.length>0)
        {
            var a_module=s_moduleid.split("<1>")
            for (var i=0;i<a_module.length;i++)
            {
                $('#master_box ul li#'+a_module[i]).appendTo('#ui-sortable')
            }
        }
        $('#ui-sortable').html( $('#ui-sortable').html()+$('#master_box ul').html())
	    $( "#ui-sortable" ).sortable();
	    $( "#ui-sortable" ).disableSelection();
        $( "#ui-sortable" ).sortable({
	        update: function() {
		        var result = $('#ui-sortable').sortable('toArray');
		        desktopSave(result);}});
		$( "#ui-sortable" ).sortable({
                start: function() {
                //停止更新
                clearInterval(N_Timeer)
                }
        });
    }catch(e){

    }    
}
function desktopSave(s_moduleid)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DesktopSave');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(s_moduleid);
    o_ajax_request.SendRequest()
    N_Timeer=setInterval('desktopRefresh()',30000);
}
/////////////////////////////////////////////////////////////////////////////////系统时间和天气///////////////////////////////////////////////////////////////
function timeRefresh()
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('TimeRefresh');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.SendRequest()
}
function callbackTimeRefresh(s_date,s_time,s_lunar)
{
    document.getElementById('date').innerHTML=s_date
    document.getElementById('time_area').innerHTML=s_time
    document.getElementById('mdate').innerHTML=s_lunar    
}
function weatherRefresh()
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('WeatherRefresh');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.SendRequest()
}
function callbackWeatherRefresh(s_stat1,s_stat2,n_tmp1,n_tem2)
{
    var o_weather=document.getElementById('weather');
    if (s_stat2==s_stat1)
    {
        document.getElementsByTagName('span')[1].innerHTML=s_stat1
        document.getElementsByTagName('img')[0].src=weatherGetImg(s_stat1)
        document.getElementsByTagName('img')[1].style.display='none'
    }else{
        document.getElementsByTagName('span')[1].innerHTML=s_stat1+'转'+s_stat2
        document.getElementsByTagName('img')[0].src=weatherGetImg(s_stat1)
        document.getElementsByTagName('img')[1].src=weatherGetImg(s_stat2)
    }
    document.getElementsByTagName('span')[2].innerHTML=n_tmp1+'℃~'+n_tem2+'℃'
    o_weather.style.display='block'
}
function weatherGetImg(s_str)
{
    switch (s_str)
    {
        case '晴':
            return S_Root+'images/weather/21x15/d00.gif';
            break
        case '多云':
            return S_Root+'images/weather/21x15/d01.gif';
            break
        case '阴':
            return S_Root+'images/weather/21x15/d02.gif';
            break
        case '阵雨':
            return S_Root+'images/weather/21x15/d03.gif';
            break
        case '雷阵雨':
            return S_Root+'images/weather/21x15/d04.gif';
            break
        case '冰雹':
            return S_Root+'images/weather/21x15/d05.gif';
            break
        case '雨夹雪':
            return S_Root+'images/weather/21x15/d06.gif';
            break
        case '小雨':
            return S_Root+'images/weather/21x15/d07.gif';
            break
        case '小到中雨':
            return S_Root+'images/weather/21x15/d08.gif';
            break
        case '中雨':
            return S_Root+'images/weather/21x15/d08.gif';
            break
        case '中到大雨':
            return S_Root+'images/weather/21x15/d9.gif';
            break
        case '大雨':
            return S_Root+'images/weather/21x15/d9.gif';
            break
        case '暴雨':
            return S_Root+'images/weather/21x15/d10.gif';
            break
        case '大暴雨':
            return S_Root+'images/weather/21x15/d11.gif';
            break
        case '特大暴雨':
            return S_Root+'images/weather/21x15/d12.gif';
            break
        case '阵雪':
            return S_Root+'images/weather/21x15/d13.gif';
            break
        case '小雪':
            return S_Root+'images/weather/21x15/d14.gif';
            break
        case '中雪':
            return S_Root+'images/weather/21x15/d15.gif';
            break
        case '大雪':
            return S_Root+'images/weather/21x15/d16.gif';
            break
        case '暴雪':
            return S_Root+'images/weather/21x15/d17.gif';
            break
        case '雾':
            return S_Root+'images/weather/21x15/d18.gif';
            break
        case '冻雨':
            return S_Root+'images/weather/21x15/d19.gif';
            break
        case '沙尘暴':
            return S_Root+'images/weather/21x15/d20.gif';
            break
        case '浮尘':
            return S_Root+'images/weather/21x15/d29.gif';
            break
        case '扬沙':
            return S_Root+'images/weather/21x15/d30.gif';
            break
        case '强沙尘暴':
            return S_Root+'images/weather/21x15/d31.gif';
            break      
        default:
            return S_Root+'images/weather/21x15/d01.gif';
            break
    }
    
}
///////////////////////////////////////////////////////////////////////////////隐藏顶部
function hideTop(o_obj)
{
    if (o_obj.className=='up')
    {
        o_obj.className=''
    }else{
        o_obj.className='up'
    }    
    $("#north").slideToggle();
    setTimeout('resizeLayout()',500)
}
/////////////////////////////////////////////////////////////////////////////////在线人数
function onlineRefresh()
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('OnlineRefresh');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.SendRequest()
}
function callbackOnlineRefresh(n_number)
{
    document.getElementById('online').getElementsByTagName('span')[0].innerHTML=n_number
    document.getElementById('online').title='在线 '+n_number+' 人'
}
/////////////////////////////////////////////////////////////////////////////////菜单显示
function menuShowNav2(obj,n_moduleid)
{
    var a_obj=obj.parentNode.parentNode.getElementsByTagName('a')
    for(var i=0;i<a_obj.length;i++)
    {
        a_obj[i].className='';
    }
    obj.className='active'
    var o_nav2=document.getElementById('menuNav2_'+n_moduleid)
    var a_obj=o_nav2.parentNode.getElementsByTagName('ul')
    for(var i=0;i<a_obj.length;i++)
    {
        a_obj[i].style.display='none';
    }
    o_nav2.style.display='block'
}
function menuShowAndHide()
{
    $('#start_menu_panel').slideToggle();
    $('#overlay_startmenu').slideToggle();
}
/////////////////////////////////////////////////////////////////////////////////消息,提醒,组织机构图标
function buttonUnreadMsg()
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ButtonUnreadMsg');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.SendRequest()
    if (!is_moz){
        Common_OpenLoading();   
    } 
}
function buttonUnreadRem()
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ButtonUnreadRem');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.SendRequest()
    if (!is_moz){
        Common_OpenLoading();   
    } 
}
function buttonGetUserInfo(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('ButtonGetUserInfo');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.SendRequest()
    if (!is_moz){
        Common_OpenLoading();   
    } 
}
function callbackButtonGetUserInfo(n_uid,s_item,s_info)
{
    var a_item=s_item.split("<1>")
    var a_info=s_info.split("<1>")
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=UserModifyInfo"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:400px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            用户信息');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock" align="center" width="400">')
    a_arr.push('	<tbody>')
    for (var i=0;i<a_item.length;i++)
    {
        a_arr.push('		<tr>')
        a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;'+a_item[i]+'：</td>')
        a_arr.push('			<td class="TableData">')
        a_arr.push('&nbsp;&nbsp;'+a_info[i])
        a_arr.push('				</td>')
        a_arr.push('		</tr>')
    }

    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="关闭" class="submitButton"')
    a_arr.push('				onclick="Common_CloseDialog()" type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=450
	N_Dialog_Width=467
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
}
function getOnlineUser()
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('GetOnlineUser');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.SendRequest()
    if (!is_moz){
        Common_OpenLoading();   
    }     
}
function getOnlineUserCallback(str)
{
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=UserModifyInfo"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:450px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            在线用户');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10px">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock" align="center" width="450">')
    a_arr.push('	<tbody>')
        a_arr.push('		<tr>')
        a_arr.push('			<td class="TableData">')
        a_arr.push(str)
        a_arr.push('				</td>')
        a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input value="关闭" class="submitButton"')
    a_arr.push('				onclick="Common_CloseDialog()" type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=450
	N_Dialog_Width=467
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
}