   function resizeLayout()
   {
      // 主操作区域高度
      var wWidth = (window.document.documentElement.clientWidth || window.document.body.clientWidth || window.innerHeight);
      var wHeight = (window.document.documentElement.clientHeight || window.document.body.clientHeight || window.innerHeight);
      var nHeight = $('#north').is(':visible') ? $('#north').outerHeight() : 0;
      var fHeight = $('#funcbar').is(':visible') ? $('#funcbar').outerHeight() : 0;
      var cHeight = wHeight - nHeight - fHeight - $('#south').outerHeight() - $('#taskbar').outerHeight()-38;
      $('#center').height(cHeight);
      
      $("#center iframe").css({height: cHeight});

/*
      if(isTouchDevice())
      {
         $('.tabs-panel:visible').height(cHeight);
         if($('.tabs-panel > iframe:visible').height() > cHeight)
            $('.tabs-panel:visible').height($('.tabs-panel > iframe:visible').height());
      }
*/
      //一级标签宽度
   };
function showButton(obj)
 {
    a_div=obj.getElementsByTagName('div')
    if (a_div.length>1)
    {
        a_div[3].style.display='block'
    }else{
        a_div[0].style.display='block'
    }
 }
function hideButton(obj)
 {
    a_div=obj.getElementsByTagName('div')
    if (a_div.length>1)
    {
        a_div[3].style.display='none'
    }else{
        a_div[0].style.display='none'
    }
 }
function selected(obj)
 {
    if (obj.getElementsByTagName('input')[0].checked==true)
    {
        obj.className='off' 
        obj.getElementsByTagName('input')[0].checked=false 
    }else{
        obj.getElementsByTagName('input')[0].checked=true
        obj.className='on' 
    }

 }
function selectedForCheck(obj)
 {
    if (obj.checked==true)
    {
        obj.parentNode.className='off'
        obj.checked=false 
    }else{
        obj.parentNode.className='on'
        obj.checked=true 
    }
}
function selectAll(obj)
{
   if (obj.checked==true)
    {
        var a_obj=document.getElementsByTagName('input')
        for (var i=0;i<a_obj.length;i++)
        {
            a_obj[i].parentNode.parentNode.className='on'
            a_obj[i].checked=true 
        }
    }else{
        var a_obj=document.getElementsByTagName('input')
        for (var i=0;i<a_obj.length;i++)
        {
            a_obj[i].parentNode.parentNode.className='off'
            a_obj[i].checked=false 
        }
 
    }

}
function goTo(s_url){
    var o_ifram=parent.document.getElementsByTagName('frame')[1]
    try{
    o_ifram.src=s_url
    } catch(e)
    {}
    parent.parent.Common_OpenLoading();
}
function searchSubmit()
{
    var temp=$('#Vcl_Search').val();
    if (temp.length==0 || temp=='请输入要搜索的姓名...')
    {
        return;
    }
    parent.S_Key=temp
    document.getElementById('filelist').src='address_list_search.php?key='+encodeURIComponent(temp)
    parent.parent.Common_OpenLoading();
}
function buildPageButton(n_dept,n_grade,n_class,n_page,n_count,n_pagesize,page)
{
    var obj=document.getElementById('page')
    var html='';
    var n_allpage=Math.ceil(n_count/n_pagesize)
    if (n_page>1)
    {
        //显示上一页
        html='&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="goToPage(\''+page+'?dept='+n_dept+'&grade='+n_grade+'&year='+n_grade+'&class='+n_class+'&page='+(n_page-1)+'\')">上一页</a>'
    }
    if (n_page<n_allpage)
    {
        //显示下一页
        html=html+'&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="goToPage(\''+page+'?dept='+n_dept+'&grade='+n_grade+'&year='+n_grade+'&class='+n_class+'&page='+(n_page+1)+'\')">下一页</a>'
    }
    if (n_count==0)
    {
        n_page=0
    }
    //构造统计
     html=html+'&nbsp;&nbsp;&nbsp;&nbsp;<span>共'+n_count+'人  第'+n_page+'/'+n_allpage+'页</span>'
    obj.innerHTML=html    
}
function goToPage(url)
{

    var obj=document.getElementById('filelist')
    obj.src=url
}
function Common_Modify_Class_Onchange()
{
    var s_grade='';
    for (var i=0;i<document.getElementById('Vcl_Grade').options.length;i++)
    {
        if (document.getElementById('Vcl_Grade').options[i].selected)
        {
            s_grade=document.getElementById('Vcl_Grade').options[i].text
        }
    }
    document.getElementById('Vcl_ClassNameDiy').value=s_grade
    var s_class='';
    for (var i=0;i<document.getElementById('Vcl_Class').options.length;i++)
    {
        if (document.getElementById('Vcl_Class').options[i].selected)
        {
            s_class=document.getElementById('Vcl_Class').options[i].text
        }
    }
    document.getElementById('Vcl_ClassNameDiy').value=s_grade+s_class
}
function Common_Modify_Huji_City_Onchange()
{
    var o_city=document.getElementById('Vcl_H_City');
    var o_qu=document.getElementById('Vcl_H_Qu');
    var o_jiedao=document.getElementById('Vcl_H_Jiedao');
    if(o_city.value=='北京')
    {
        var o_temp=document.getElementById('h_qu')
        o_temp.style.display='block'
        var o_temp=document.getElementById('Vcl_Id')
        o_temp.className='BigInput'
        o_temp.disabled=false
        var o_temp=document.getElementById('Vcl_Check')
        o_temp.checked=false
        document.getElementById('idquality').innerHTML='<select name="Vcl_IdType" id="Vcl_IdType"><option value="">&nbsp;&nbsp;</option><option value="居民身份证">&nbsp;居民身份证/户口本&nbsp;</option><option value="护照">&nbsp;护照&nbsp;</option></select>';
    }else{
        o_jiedao.value=''
        o_qu.value=''
        var o_temp=document.getElementById('h_qu')
        o_temp.style.display='none'
        var o_temp=document.getElementById('h_jiedao')
        o_temp.style.display='none'
        var o_temp=document.getElementById('Vcl_Id')
        o_temp.className='BigInput'
        o_temp.disabled=false
        var o_temp=document.getElementById('h_id_select')
        o_temp.style.display='block'
        var o_temp=document.getElementById('Vcl_Check')
        o_temp.checked=false
        document.getElementById('idquality').innerHTML='<select name="Vcl_IdType" id="Vcl_IdType"><option value="">&nbsp;&nbsp;</option><option value="居民身份证">&nbsp;居民身份证/户口本&nbsp;</option><option value="护照">&nbsp;护照&nbsp;</option><option value="无证件">&nbsp;无证件&nbsp;</option></select>';
    }
}

function Common_Modify_Huji_Qu_Onchange()
{
    var o_qu=document.getElementById('Vcl_H_Qu');
    var o_jiedao=document.getElementById('h_jiedao');
    if (o_qu.value=='西城')
    {
        o_jiedao.style.display='block'
    }else{
        o_jiedao.style.display='none'
        var o_temp=document.getElementById('Vcl_H_Jiedao');
        o_temp.value=''
    }
}
function Common_Modify_Xian_Qu_Onchange()
{
    var o_qu=document.getElementById('Vcl_Z_Qu');
    var o_jiedao=document.getElementById('z_jiedao');
    if (o_qu.value=='西城')
    {
        o_jiedao.style.display='block'
    }else{
        o_jiedao.style.display='none'
        var o_temp=document.getElementById('Vcl_Z_Jiedao');
        o_temp.value=''
    }
}
function Common_Modify_Huji_Idselect()
{
    var o_temp=document.getElementById('Vcl_Check')
    if (o_temp.checked)
    {
        var o_temp=document.getElementById('Vcl_Id')
        o_temp.className='BigStatic'
        o_temp.disabled=true
        o_temp.value=''
    }else{
        var o_temp=document.getElementById('Vcl_Id')
        o_temp.className='BigInput'
        o_temp.disabled=false
    }
}
function Common_Modify_Info(){
    //验证用户输入
    var s_name=document.getElementById('Vcl_Name').value;
    var s_year=Number(document.getElementById('Vcl_Year').value);
    var s_month=Number(document.getElementById('Vcl_Month').value);
    var s_day=Number(document.getElementById('Vcl_Day').value);
    if (s_name.length==0){
        parent.parent.Dialog_Message("[ 幼儿姓名 ] 不能为空！")
        return
    }
    if (s_year==0||s_month==0||s_day==0){
        parent.parent.Dialog_Message("[ 出生日期 ] 不能为空！")
        return 
    }
    var s_value=document.getElementById('Vcl_Grade').value ;
    if (s_value==0){
        parent.parent.Dialog_Message("[ 年级 ] 不能为空！")
        return
    }
    var s_value=document.getElementById('Vcl_Class').value ;
    if (s_value==0){
    	parent.parent.Dialog_Message("[ 班级 ] 不能为空！")
        return
    }
    var s_value=document.getElementById('Vcl_Sex').value ;
    if (s_value==''){
    	parent.parent.Dialog_Message("请选择 [ 性别 ]")
        return
    }
    s_value=document.getElementById('Vcl_Minzu').value ;
    if (s_value==''){
    	parent.parent.Dialog_Message("请选择 [ 民族 ]")
        return
    }
    s_value=document.getElementById('Vcl_Only').value ;
    if (s_value==''){
    	parent.parent.Dialog_Message("请选择 [ 独生子女 ]")
        return
    }
     s_value=document.getElementById('Vcl_IsCanji').value ;
    if (s_value=='是'){
        s_value=document.getElementById('Vcl_CanjiType').value ;
        if(s_value=='')
        {
            parent.parent.Dialog_Message("请选择 [ 残疾幼儿类型 ]")
            return
        }        
    }
    var s_value=document.getElementById('Vcl_InTime').value ;
    if (s_value==''){
    	parent.parent.Dialog_Message("[ 入园日期 ] 不能为空！")
        return
    }
    if (s_value=='0000-00-00'){
    	parent.parent.Dialog_Message("[ 入园日期 ] 填写错误！")
        return
    }
    s_value=document.getElementById('Vcl_Nationality').value ;
    if (s_value==''){
        parent.parent.Dialog_Message("[ 国籍 ] 不能为空！")
        return
    }
    s_value=document.getElementById('Vcl_Birthplace').value ;
    if (s_value==''){
        parent.parent.Dialog_Message("[ 出生地 ] 不能为空！")
        return
    }
    s_value=document.getElementById('Vcl_IdQuality').value ;
    if (s_value==''){
        parent.parent.Dialog_Message("请选择 [ 户口性质 ]")
        return
    }
    s_value=document.getElementById('Vcl_H_City').value ;
    if (s_value==''){
    	parent.parent.Dialog_Message("请选择 [ 户籍所在地 ] 的 [省市]")
        return
    }else if(s_value=='北京'){
        s_value=document.getElementById('Vcl_H_Qu').value ;
        if(s_value=='')
        {
        	parent.parent.Dialog_Message("请选择 [ 户籍所在地 ] 的 [区]")
            return
        }else if(s_value=='西城'){
            s_value=document.getElementById('Vcl_H_Jiedao').value ;
            if (s_value=='')
            {
            	parent.parent.Dialog_Message("请选择 [ 户籍所在地 ] 的 [街道]")
                return
            }
        }        
    }
    s_value=document.getElementById('Vcl_IdType').value ;
    if (s_value==''){
        parent.parent.Dialog_Message("请选择 [ 身份证件类型 ]")
        return
    }
        s_value=document.getElementById('Vcl_H_Add').value
        if (s_value=='')
        {
        	parent.parent.Dialog_Message("[ 户籍信息 ] 的 [ 详细地址 ] <br>不能为空")
            return
        }
        var o_temp=document.getElementById('Vcl_Check')
        if (o_temp.checked==false)    
        { 
            s_value=document.getElementById('Vcl_Id').value
            if (s_value=='')
            {       
                parent.parent.Dialog_Message("[ 户籍信息 ] 的 [ 身份证号 ] <br>不能为空")
                return
            }else{
                function isDigit(str){ 
                    var reg =/^(\d{14}|\d{17})(\d|[xX])$/; 
                    return reg.test(str); 
                }
                if (!isDigit(s_value))
                {
            	    //parent.parent.Dialog_Message("[ 身份证号 ] 填写不正确")
                    //return
                } 
            }  
        }        
        s_value=document.getElementById('Vcl_Z_Qu').value ;
        if(s_value=='')
        {
        	parent.parent.Dialog_Message("请选择 [ 现住址 ] 的 [区]")
            return
        }else if(s_value=='西城'){
            s_value=document.getElementById('Vcl_Z_Jiedao').value ;
            if (s_value=='')
            {
            	parent.parent.Dialog_Message("请选择 [ 现住址 ] 的 [街道]")
                return
            }
        } 
        s_value=document.getElementById('Vcl_Z_Property').value
        if (s_value=='')
        {
        	parent.parent.Dialog_Message("[ 在京地址 ] 的 [ 居住房屋属性 ] <br>不能为空")
            return
        }
        s_value=document.getElementById('Vcl_Z_Add').value
        if (s_value=='')
        {
        	parent.parent.Dialog_Message("[ 在京地址 ] 的 [ 详细地址 ] <br>不能为空")
            return
        }
    var b_janhu=false 
    var s_guan=document.getElementById('Vcl_J1_Guanxi').value
    var s_name=document.getElementById('Vcl_J1_Name').value
    var s_danwei=document.getElementById('Vcl_J1_Danwei').value 
    var s_phone=document.getElementById('Vcl_J1_Phone').value      
    if((s_guan!='')&&(s_name!='')&&(s_danwei!='')&&(s_phone!=''))
    {
        b_janhu=true
    }else if((s_name!='')||(s_danwei!='')||(s_phone!='')){
    	parent.parent.Dialog_Message("请将监护人 [ 父亲 ] 填写完整！")
        return
    }
    s_guan=document.getElementById('Vcl_J2_Guanxi').value
    s_name=document.getElementById('Vcl_J2_Name').value
    s_danwei=document.getElementById('Vcl_J2_Danwei').value 
    s_phone=document.getElementById('Vcl_J2_Phone').value      
    if((s_guan!='')&&(s_name!='')&&(s_danwei!='')&&(s_phone!=''))
    {
        b_janhu=true
    }else if((s_name!='')||(s_danwei!='')||(s_phone!='')){
    	parent.parent.Dialog_Message("请将监护人 [ 母亲 ] 填写完整！")
        return
    }
    s_guan=document.getElementById('Vcl_J3_Guanxi').value
    s_name=document.getElementById('Vcl_J3_Name').value
    s_danwei=document.getElementById('Vcl_J3_Danwei').value 
    s_phone=document.getElementById('Vcl_J3_Phone').value      
    if((s_guan!='')&&(s_name!='')&&(s_danwei!='')&&(s_phone!=''))
    {
        b_janhu=true
    }else if((s_guan!='')||(s_name!='')||(s_danwei!='')||(s_phone!='')){
    	parent.parent.Dialog_Message("请将第三个监护人信息填写完整！")
        return
    }
    if (!b_janhu)
    {
    	parent.parent.Dialog_Message("最少要填写一个监护人信息")
            return
    }
    s_value=document.getElementById('Vcl_Bingshi').value ;
    if (s_value==''){
    	parent.parent.Dialog_Message("[ 既往病史 ] 不能为空<br>如果没有请您填写“无”")
        return
    }
    s_value=document.getElementById('Vcl_Guomin').value ;
    if (s_value==''){
    	parent.parent.Dialog_Message("[ 过敏史 ] 不能为空<br>如果没有请您填写“无”")
        return
    }
    document.getElementById('dialog_form').submit()
    if (!is_moz){
    	parent.parent.Common_OpenLoading();   
    }
}
function showNotallowApply(n_id)
{    
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=NotallowApply"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:300px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            不批准原因');
    a_arr.push('        </td>');
    a_arr.push('        <td style="width: 10%">');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('        </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock_Editor" align="center" width="300">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData">')
    a_arr.push('                <textarea name="Vcl_RejectReason" id="Vcl_RejectReason" rows="5" cols="38" class="BigInput"></textarea>')
    a_arr.push('			    <input id="Vcl_Uid" name="Vcl_Uid"')
    a_arr.push('				size="30" maxlength="30" class="BigInput"')
    a_arr.push('				value="'+n_id+'" type="text" style="display:none"/></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td nowrap="nowrap"><input value="确定" class="submitButton"')
    a_arr.push('				onclick="notallowApply()" type="button" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="Common_CloseDialog()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=350
	N_Dialog_Width=317
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n'));  
}
function notallowApply()
{
    var s_title=document.getElementById('Vcl_RejectReason').value
    if (s_title==''){
        parent.parent.Dialog_Message("[ 不批准原因 ] 不能为空！")
        return
    }
    document.getElementById('submit_form').submit()
    parent.parent.Common_OpenLoading();   
}
function Common_Modify_GetClassName(n_id)
{

    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('GetClassName');
    o_ajax_request.PushParameter(document.getElementById('Vcl_Grade').value);
    o_ajax_request.PushParameter(n_id);
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.SendRequest();
}
function Common_Modify_GetClassNameCallBack(str)
{
    document.getElementById('class').innerHTML=str
}
function outputExcel(deptid,grade,s_class)
{
    var s_deptid='?deptid='+encodeURIComponent(deptid)
    var s_grade='&grade='+encodeURIComponent(grade)
    s_class='&class='+encodeURIComponent(s_class)
     var s_parameter=s_deptid+s_grade+s_class
    Dialog_Confirm("系统将导出当前列表！<br>是否继续？",function (){window.open('output.php'+s_parameter,'_blank')});
}
function selectAll(obj)
{
   if (obj.checked==true)
    {
        var a_obj=document.getElementsByTagName('input')
        for (var i=0;i<a_obj.length;i++)
        {
            a_obj[i].checked=true 
        }
    }else{
        var a_obj=document.getElementsByTagName('input')
        for (var i=0;i<a_obj.length;i++)
        {
            a_obj[i].checked=false 
        } 
    }
}
function userResetPassword(n_uid,s_username,s_name)
{    
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form"')
    a_arr.push('	action="include/bn_submit.svr.php?function=UserResetPassword"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:400px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title">');
    a_arr.push('            重新幼儿账户登陆密码');
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
        parent.parent.parent.Dialog_Message("[ 密码 ] 不能为空")
        return
    }
    if (temp.length<6){
        parent.parent.parent.Dialog_Message("[ 密码 ] 不能小于6个字符")
        return
    }
    if (temp!=document.getElementById('Vcl_Password2').value){
        parent.parent.parent.Dialog_Message("两次输入的密码不一致")
        return
    }
    document.getElementById('dialog_form').submit();
    parent.parent.parent.Common_OpenLoading();   
}