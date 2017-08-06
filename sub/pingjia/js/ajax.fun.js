function nameAddBold(o_obj)
{

    var a_a=document.getElementsByTagName('a')
    for (var i=0; i<a_a.length;i++)
    {
        a_a[i].style.fontWeight='normal'
    }
    o_obj.style.fontWeight='bold'
}
function openPath(o_obj,dept_id,n_year,n_month,n_day,n_time,s_page)
{
    //debugger
    openPathSend(o_obj,n_year,n_month,n_day,n_time,s_page,'GetDeptList')
}
function openReportPath(o_obj,n_date)
{
    //debugger
    openReportPathSend(o_obj,n_date,'GetReportDeptList')
}
function openReportPathSend(o_obj,n_date,s_function)
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
        o_ajax_request.PushParameter(n_date);
        o_ajax_request.setPage('include/it_ajax.svr.php');
        o_ajax_request.SendRequest()
    }
}
function openPathSend(o_obj,n_year,n_month,n_day,n_time,s_page,s_function)
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
        o_ajax_request.PushParameter(n_year);
        o_ajax_request.PushParameter(n_month);
        o_ajax_request.PushParameter(n_day);
        o_ajax_request.PushParameter(n_time);
        o_ajax_request.PushParameter(s_page);
        o_ajax_request.setPage('include/it_ajax.svr.php');
        o_ajax_request.SendRequest()
    }
}
function openPathForProperty(o_obj,dept_id,n_year,n_month,n_day,n_time,s_page)
{
    //debugger
    openPathSend(o_obj,n_year,n_month,n_day,n_time,s_page,'GetPropertyList')
}
function callbackOpenReportPath(s_name,s_id,n_date)
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
    	if (a_id[i]==100)
    	{
    		continue;
    	}
        a_arr.push('<li style="display:block">')
        a_arr.push('<span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">')
        a_arr.push('&nbsp;&nbsp;&nbsp;&nbsp;')
        a_arr.push('<img src="images/report.png" alt="" align="absmiddle"/>')
        a_arr.push('<a id="path_'+a_id[i]+'" href="javascript:;" title="'+a_name[i]+'" style=" font-weight:normal" onclick="nameAddBold(this);goTo(\'report_list.php?date='+n_date+'&deptid='+a_id[i]+'\')">')
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
function callbackOpenPath(s_name,s_id,n_year,n_month,n_day,n_time,s_page)
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
        a_arr.push('<img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" />')
        a_arr.push('<img src="images/report.png" alt="" align="absmiddle"/>')
        a_arr.push('<a id="path_'+a_id[i]+'" href="javascript:;" title="'+a_name[i]+'" style=" font-weight:normal" onclick="nameAddBold(this);goTo(\''+s_page+'?year='+n_year+'&month='+n_month+'&day='+n_day+'&time='+n_time+'&deptid='+a_id[i]+'&deptname='+a_name[i]+'\')">')
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
/////////////////////////////////////////////////////////群体发送消息
function sendMsgAll()
{
    var a_input=document.getElementsByTagName('input')
    var s_userid='';
    var s_username='';
    for(var i = 0; i < a_input.length; i++){//构建文件夹id字符串
        var o_check=a_input[i]       
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            var temp=o_check.parentNode.parentNode.getElementsByTagName('td')[2].innerHTML;
            s_userid=s_userid+o_check.value+'<1>';
            s_username=s_username+temp+'&nbsp;&nbsp;&nbsp;&nbsp;';            
        }        
    }
    if (s_userid.length>0)
    {
        s_userid=s_userid.substr(0,s_userid.length-3)
    }
    if (s_userid=='')
    {
        parent.parent.parent.Dialog_Message('亲选择要发送消息的用户！');   
        return
    }
    parent.location='address_sendmsg.php?userid='+encodeURIComponent(s_userid)+'&username='+encodeURIComponent(s_username)
    parent.parent.parent.Common_OpenLoading();
}
/////////////////////////////////////////////////////////单发消息
function sendMsg(s_userid,s_username)
{
    parent.location='address_sendmsg.php?userid='+encodeURIComponent(s_userid)+'&username='+encodeURIComponent(s_username)
    parent.parent.parent.Common_OpenLoading();
}
/////////////////////////////////////////////////////////群体发送邮件
function sendEmailAll()
{
    var a_input=document.getElementsByTagName('input')
    var s_userid='';
    var s_username='';
    for(var i = 0; i < a_input.length; i++){//构建文件夹id字符串
        var o_check=a_input[i]       
        if (o_check==null) {
            break;        
        }
        if (o_check.checked)
        {
            var temp=o_check.parentNode.parentNode.getElementsByTagName('td')[2].innerHTML;
            s_userid=s_userid+o_check.value+'<1>';
            s_username=s_username+temp+';';           
        }        
    }
    if (s_userid.length>0)
    {
        s_userid=s_userid.substr(0,s_userid.length-3)
        s_username=s_username.substr(0,s_username.length-1)
    }
    if (s_userid=='')
    {
        parent.parent.parent.Dialog_Message('亲选择要发送邮件的用户！');   
        return
    }
    parent.location='address_sendemail.php?userid='+encodeURIComponent(s_userid)+'&username='+encodeURIComponent(s_username)
    parent.parent.parent.Common_OpenLoading();
}

//-------------带进度条的幼儿信息总数统计
 var N_Sum=0;
 var N_Total=0;
 var N_Year=0;
 var N_Month=0;
 var N_Day=0;
 var N_Time=0;
function scrollstartTotal()//--------------------1
{
    parent.parent.parent.Dialog_Confirm("是否要开始新的统计？<br/>统计时等待时间比较长，<br/>请耐心等待！",function (){scrollGetSum();parent.parent.parent.Common_OpenLoading()});
}
function scrollGetSum(str)//----------------------2
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction (S_GetSumFunction);
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.SendRequest()
}
function scrollGetSumCallback(sum,n_year,n_month,n_day,n_time)//----------------------3
{  
    N_Year=n_year;
    N_Month=n_month;
    N_Day=n_day;
    N_Time=n_time;
    N_Total=sum;
    parent.parent.parent.Common_CloseDialog()
    var o_obj=parent.parent.parent.document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=NotallowApply"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:500px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            系统正在努力统计，请您不要进行任何操作，耐心等待···');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock_Editor" align="center" width="500">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" style="padding-left:20px;">')
    a_arr.push('			    <div style="margin-top:20px;margin-bottom:10px;width:450px;height:15px;border: 1px solid #C0BFBF;"><div id="bar" style="background-color:Red;height:15px;width:0px;"></div></div>')
    a_arr.push('			    <div id="persent" style="text-align:center;margin:5px;height:20px">0%</div>')
    a_arr.push('			</td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(parent.parent.parent.N_Dialog_TimeHandle);
	parent.parent.parent.N_Dialog_Height=143
	parent.parent.parent.N_Dialog_Width=514
	o_obj.style.top='-1000px';
	parent.parent.parent.N_Dialog_TimeHandle=window.setInterval(parent.parent.parent.Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
	parent.parent.parent.setOpacity('0.5')
	startTotal()
}
function startTotal()//----------------------4
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction (S_StartTotalFunction);
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(N_Sum);
    o_ajax_request.PushParameter(N_Year);
    o_ajax_request.PushParameter(N_Month);
    o_ajax_request.PushParameter(N_Day);
    o_ajax_request.PushParameter(N_Time);
    o_ajax_request.SendRequest()
}
function startTotalCallback()//----------------------5
{
    var o_bar=parent.parent.parent.document.getElementById('bar');
    var o_persent=parent.parent.parent.document.getElementById('persent');
    N_Sum=N_Sum+1
    var n_number=Math.round(N_Sum/N_Total*450)
    o_bar.style.width=n_number+'px'
    o_persent.innerHTML=Math.round(N_Sum/N_Total*100)+'%'
    if (N_Sum>N_Total)
    {
        parent.parent.parent.Common_CloseDialog()
        parent.parent.parent.Dialog_Success('信息统计成功！',function(){parent.location.reload()});  
        
        return
    }    
    startTotal()
}
//---------------------------------------
