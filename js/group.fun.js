function vclClear()
{
    document.getElementById('Vcl_Reciver').value='';
    document.getElementById('Vcl_Reciver_Id').value='';
}
function openDeptSub(s_tr,n_module_id){  //打开部门树形结构

     for(var i = 1; i < 100; i++){//遍历所有子树形。
        var o_tr=document.getElementById(s_tr+'_'+i)        
        if (o_tr==null) {
            break;
        }
        if (o_tr.style.display=='none')//当为隐藏，则显示，为显示则隐藏。
        {
            //o_tr.style.display='block'
            var o_icon=document.getElementById('dept_icon_'+n_module_id)
            o_icon.src=S_Root+"images/org/tree_on.png"
        }else{
           // o_tr.style.display='none'
            var o_icon=document.getElementById('dept_icon_'+n_module_id)
            o_icon.src=S_Root+"images/org/tree_off.png"
        }
        $('#'+s_tr+'_'+i).slideToggle();
    }
    try{
        var o_tr=document.getElementById('allname').getElementsByTagName('div')//获取所有人名列表
        for(var i = 0; i < o_tr.length; i++)//隐藏所有人名列表
        {
            o_tr[i].style.display='none';
        }
        var o_div=document.getElementById('module_'+n_module_id) //显示当前的人名列表
        o_div.style.display='block'
    }catch(e)
    {
    }     
}
function openRootDept_Dept(n_module_id)
{
    try{
        var o_tr=document.getElementById('allname_dept_').getElementsByTagName('div')//获取所有人名列表
        for(var i = 0; i < o_tr.length; i++)//隐藏所有人名列表
        {
            o_tr[i].style.display='none';
        }
        var o_div=document.getElementById('module_dept_'+n_module_id) //显示当前的人名列表
        o_div.style.display='block'
    }catch(e)
    {
    }  
}
function openDeptSub_Dept(s_tr,n_module_id){  //打开部门树形结构
     for(var i = 1; i < 100; i++){//遍历所有子树形。
        var o_tr=document.getElementById(s_tr+'_'+i)        
        if (o_tr==null) {
            break;
        }
        if (o_tr.style.display=='none')//当为隐藏，则显示，为显示则隐藏。
        {
            o_tr.style.display='block'
            var o_icon=document.getElementById('dept_icon_dept_'+n_module_id)
            o_icon.src=S_Root+"images/org/tree_on.png"
        }else{
            o_tr.style.display='none'
            var o_icon=document.getElementById('dept_icon_dept_'+n_module_id)
            o_icon.src=S_Root+"images/org/tree_off.png"
        }
    }
    try{
        var o_tr=document.getElementById('allname_dept_').getElementsByTagName('div')//获取所有人名列表
        for(var i = 0; i < o_tr.length; i++)//隐藏所有人名列表
        {
            o_tr[i].style.display='none';
        }
        var o_div=document.getElementById('module_dept_'+n_module_id) //显示当前的人名列表
        o_div.style.display='block'
    }catch(e)
    {
    }     
}
function openDept(o_obj){  //打开部门树形结构
    var o_dept=document.getElementById('dept')
    if (o_dept.style.display=='none')//当为隐藏，则显示，为显示则隐藏。
    {
        //o_dept.style.display='block'
        o_obj.className="header header-active"
    }else{
        //o_dept.style.display='none'
        o_obj.className="header"
    } 
    $("#dept").slideToggle();
//    var o_dept=document.getElementById('role')//显示部门的时候，隐藏较色
//    o_dept.style.display='none'  
}
function openRole(o_obj){//打开角色树形结构
    var o_dept=document.getElementById('role')
    if (o_dept.style.display=='none')//当为隐藏，则显示，为显示则隐藏。
    {
        //o_dept.style.display='block'
        o_obj.className="header header-active"
    }else{
        //o_dept.style.display='none'
        o_obj.className="header"
    }
    $("#role").slideToggle();
//    var o_dept=document.getElementById('dept')//显示部门的时候，隐藏较色
//    o_dept.style.display='none' 
}
function openGroup(){//打开整个添加人名的对话框
    var o_dept=document.getElementById('group')
    if (o_dept.style.display=='none')//当为隐藏，则显示，为显示则隐藏。
    {
        o_dept.parentNode.style.borderBottom='solid 1px #CCCCCC'
    }else{
        o_dept.parentNode.style.borderBottom='solid 0px #CCCCCC'
    } 
    $("#group").slideToggle();  
}
function closeGroup()
{
    var o_dept=document.getElementById('group')
    if (o_dept.style.display!='none')//当为隐藏，则显示，为显示则隐藏。
    {
        $("#group").slideToggle();
        o_dept.parentNode.style.borderBottom='solid 0px #CCCCCC'
    }
}
function openGroup_Dept(){//打开整个添加人名的对话框
    var o_dept=document.getElementById('group_dept')
    if (o_dept.style.display=='none')//当为隐藏，则显示，为显示则隐藏。
    {
        o_dept.style.display='block'
    }else{
        o_dept.style.display='none'
    }    
}
function openGroup_Role(){//打开整个添加人名的对话框
    var o_dept=document.getElementById('group_role')
    if (o_dept.style.display=='none')//当为隐藏，则显示，为显示则隐藏。
    {
        o_dept.style.display='block'
    }else{
        o_dept.style.display='none'
    }    
}
//function openDeptSub(s_id)//打开部门的子树形结构
//{
//     for(var i = 1; i < 100; i++){//遍历所有子树形。
//        var o_tr=document.getElementById('dept'+s_id+'_'+i)        
//        if (o_tr==null) {
//            break;
//        }
//        if (o_tr.style.display=='none')//当为隐藏，则显示，为显示则隐藏。
//        {
//            o_tr.style.display='block'
//        }else{
//            o_tr.style.display='none'
//        }
//    }
//}
function openDeptSubName(n_1,n_2)//打开子部门的人名列表
{
    var o_tr=document.getElementById('allname').getElementsByTagName('div')//获取所有人名列表
    for(var i = 0; i < o_tr.length; i++)//隐藏所有人名列表
    {
        o_tr[i].style.display='none';
    }
    var o_div=document.getElementById('dept'+n_1+'_'+n_2+'_name') //显示当前的人名列表
    o_div.style.display='block'
}
function openRoleName(n_id)//打开角色的人名列表
{
    var o_tr=document.getElementById('allname').getElementsByTagName('div')//获取所有人名列表
    for(var i = 0; i < o_tr.length; i++)//隐藏所有人名列表
    {
        o_tr[i].style.display='none';
    }
    var o_div=document.getElementById('rolediv_'+n_id)//显示当前的人名列表 
    o_div.style.display='block'
}
function allAddName(n_id)//全部添加所有姓名
{
    var o_input=document.getElementById(n_id).getElementsByTagName('input')//获取所有姓名的按钮对象
    for(var i = 2; i < o_input.length; i++)//从第三项开始循环,因为第一项和第二项是全部添加和全部删除按钮
    {
        if (o_input[i].id=='')
        {
            if (o_input[i].className=='name')
            {
                o_input[i].click();
            }             
            continue;       
        }
    }  
    var s_reciver=document.getElementById('Vcl_Reciver').value//获取当前文本输入框的内容
    if (s_reciver.length>0)//如果输入内容不为空则在名字的最后加入分隔符.
    {
        s_reciver=s_reciver+';';
    }
    var s_reciver_id=document.getElementById('Vcl_Reciver_Id').value//获取隐藏的保存用户ID的文本输入框内容
    if (s_reciver_id.length>0)//如果输入内容不为空则在名字的最后加入分隔符.
    {
        s_reciver_id='<1>'+s_reciver_id+'<1>'
    }
    var s_name=''
    var n_uid=''
    for(var i = 2; i < o_input.length; i++)//从第三项开始循环,因为第一项和第二项是全部添加和全部删除按钮
    {
        if (o_input[i].id=='')
        {         
            continue;       
        }
        s_name=o_input[i].value+';'//在名字后面加入分隔符   
        n_uid=o_input[i].id
        var s_role='role'+n_uid.substr(4,n_uid.length)
        var s_uid='uid_'+n_uid.substr(4,n_uid.length)
        n_uid='<1>'+n_uid.substr(4,n_uid.length)+'<1>' //去掉n_id前面的4个字符,从而获取真正的用户ID然后加上分隔符
        while (s_reciver_id.indexOf(n_uid)>=0){//查找保存用户ID的输入框是否已经存在该ID
            s_reciver_id=s_reciver_id.replace(n_uid,"<1>")//如果存在,则去掉id和去掉保存名字文本输入框的名字
            s_reciver=s_reciver.replace(s_name,"")
        }
        s_reciver=s_reciver+s_name//添加当前的名字
        s_reciver_id=s_reciver_id+n_uid.substr(3,n_uid.length)//添加当前的id
        o_input[i].className='selected'//名字的按钮因为已经添加进去了,所以变成灰色,表示添加过了.
        try{
            document.getElementById(s_uid).className='selected'
            document.getElementById(s_role).className='selected'  //把相应的角色中的名字也变成灰色
        }catch(e)
            {
            }
                   
    }
    //去掉名字输入框中最后的";"
    if (s_reciver_id.indexOf('<1>')==0)
    {
        s_reciver_id=s_reciver_id.substr(3,s_reciver_id.length)
    }
    if (s_reciver.length>0)
    {
        document.getElementById('Vcl_Reciver').value=s_reciver.substr(0,s_reciver.length-1)
    }else
    {
        document.getElementById('Vcl_Reciver').value=s_reciver
    }
    //去掉Id输入框中最后的"<1>"
    if (s_reciver_id.length>0)
    {
        document.getElementById('Vcl_Reciver_Id').value=s_reciver_id.substr(0,s_reciver_id.length-3)
    }else
    {
        document.getElementById('Vcl_Reciver_Id').value=s_reciver_id
    }
}
function allAddName_Dept(n_id)//全部添加所有姓名
{
    var o_input=document.getElementById(n_id).getElementsByTagName('input')//获取所有姓名的按钮对象 
    var s_reciver=document.getElementById('Vcl_Reciver_Dept').value//获取当前文本输入框的内容
    if (s_reciver.length>0)//如果输入内容不为空则在名字的最后加入分隔符.
    {
        s_reciver=s_reciver+';';
    }
    var s_reciver_id=document.getElementById('Vcl_Reciver_DeptId').value//获取隐藏的保存用户ID的文本输入框内容
    if (s_reciver_id.length>0)//如果输入内容不为空则在名字的最后加入分隔符.
    {
        s_reciver_id='<1>'+s_reciver_id+'<1>'
    }
    var s_name=''
    var n_uid=''
    for(var i = 2; i < o_input.length; i++)//从第三项开始循环,因为第一项和第二项是全部添加和全部删除按钮
    {
        s_name=o_input[i].value+';'//在名字后面加入分隔符   
        n_uid=o_input[i].id
        n_uid='<1>'+n_uid.substr(7,n_uid.length)+'<1>' //去掉n_id前面的4个字符,从而获取真正的用户ID然后加上分隔符
        while (s_reciver_id.indexOf(n_uid)>=0){//查找保存用户ID的输入框是否已经存在该ID
            s_reciver_id=s_reciver_id.replace(n_uid,"<1>")//如果存在,则去掉id和去掉保存名字文本输入框的名字
            s_reciver=s_reciver.replace(s_name,"")
        }
        s_reciver=s_reciver+s_name//添加当前的名字
        s_reciver_id=s_reciver_id+n_uid.substr(3,n_uid.length)//添加当前的id
        o_input[i].className='selected'//名字的按钮因为已经添加进去了,所以变成灰色,表示添加过了.                   
    }
    //去掉名字输入框中最后的";"
    if (s_reciver_id.indexOf('<1>')==0)
    {
        s_reciver_id=s_reciver_id.substr(3,s_reciver_id.length)
    }
    if (s_reciver.length>0)
    {
        document.getElementById('Vcl_Reciver_Dept').value=s_reciver.substr(0,s_reciver.length-1)
    }else
    {
        document.getElementById('Vcl_Reciver_Dept').value=s_reciver
    }
    //去掉Id输入框中最后的"<1>"
    if (s_reciver_id.length>0)
    {
        document.getElementById('Vcl_Reciver_DeptId').value=s_reciver_id.substr(0,s_reciver_id.length-3)
    }else
    {
        document.getElementById('Vcl_Reciver_DeptId').value=s_reciver_id
    }
}
function allAddName_Role(n_id)//全部添加所有姓名
{
    var o_input=document.getElementById(n_id).getElementsByTagName('input')//获取所有姓名的按钮对象 
    var s_reciver=document.getElementById('Vcl_Reciver_Role').value//获取当前文本输入框的内容
    if (s_reciver.length>0)//如果输入内容不为空则在名字的最后加入分隔符.
    {
        s_reciver=s_reciver+';';
    }
    var s_reciver_id=document.getElementById('Vcl_Reciver_RoleId').value//获取隐藏的保存用户ID的文本输入框内容
    if (s_reciver_id.length>0)//如果输入内容不为空则在名字的最后加入分隔符.
    {
        s_reciver_id='<1>'+s_reciver_id+'<1>'
    }
    var s_name=''
    var n_uid=''
    for(var i = 2; i < o_input.length; i++)//从第三项开始循环,因为第一项和第二项是全部添加和全部删除按钮
    {
        s_name=o_input[i].value+';'//在名字后面加入分隔符   
        n_uid=o_input[i].id
        n_uid='<1>'+n_uid.substr(7,n_uid.length)+'<1>' //去掉n_id前面的4个字符,从而获取真正的用户ID然后加上分隔符
        while (s_reciver_id.indexOf(n_uid)>=0){//查找保存用户ID的输入框是否已经存在该ID
            s_reciver_id=s_reciver_id.replace(n_uid,"<1>")//如果存在,则去掉id和去掉保存名字文本输入框的名字
            s_reciver=s_reciver.replace(s_name,"")
        }
        s_reciver=s_reciver+s_name//添加当前的名字
        s_reciver_id=s_reciver_id+n_uid.substr(3,n_uid.length)//添加当前的id
        o_input[i].className='selected'//名字的按钮因为已经添加进去了,所以变成灰色,表示添加过了.                   
    }
    //去掉名字输入框中最后的";"
    if (s_reciver_id.indexOf('<1>')==0)
    {
        s_reciver_id=s_reciver_id.substr(3,s_reciver_id.length)
    }
    if (s_reciver.length>0)
    {
        document.getElementById('Vcl_Reciver_Role').value=s_reciver.substr(0,s_reciver.length-1)
    }else
    {
        document.getElementById('Vcl_Reciver_Role').value=s_reciver
    }
    //去掉Id输入框中最后的"<1>"
    if (s_reciver_id.length>0)
    {
        document.getElementById('Vcl_Reciver_RoleId').value=s_reciver_id.substr(0,s_reciver_id.length-3)
    }else
    {
        document.getElementById('Vcl_Reciver_RoleId').value=s_reciver_id
    }
}
function allModule(o_obj,s_id)
{
    if (o_obj.className=='selected')
    {
       allDeleteName(s_id) 
       o_obj.className='name'
    }else{
       allAddName(s_id)
       o_obj.className='selected'
    }
}
function allDeleteName(n_id)//删除全部的名称列表中的名字,功能同上
{
    var o_input=document.getElementById(n_id).getElementsByTagName('input')
    for(var i = 2; i < o_input.length; i++)//从第三项开始循环,因为第一项和第二项是全部添加和全部删除按钮
    {
        if (o_input[i].id=='')
        {
            if (o_input[i].className=='selected')
            {
                o_input[i].click();
            }                        
            continue;       
        }
    } 
    var s_reciver=document.getElementById('Vcl_Reciver').value
    if (s_reciver.length>0)
    {
        s_reciver=s_reciver+';';
    }
    var s_reciver_id=document.getElementById('Vcl_Reciver_Id').value
    if (s_reciver_id.length>0)
    {
        s_reciver_id='<1>'+s_reciver_id+'<1>'
    }
    var s_name=''
    var n_uid=''
    for(var i = 2; i < o_input.length; i++)
    {
        if (o_input[i].id=='')
        {         
            continue;       
        }
        s_name=o_input[i].value+';'
        n_uid=o_input[i].id
        var s_role='role'+n_uid.substr(4,n_uid.length)
        var s_uid='uid_'+n_uid.substr(4,n_uid.length)
        n_uid='<1>'+n_uid.substr(4,n_uid.length)+'<1>' 
        while (s_reciver_id.indexOf(n_uid)>=0){
            s_reciver_id=s_reciver_id.replace(n_uid,"<1>")
            s_reciver=s_reciver.replace(s_name,"")
        }
        o_input[i].className='name'
        try{
            document.getElementById(s_uid).className='name'
            document.getElementById(s_role).className='name'  //把相应的角色中的名字也变成灰色
        }catch(e)
            {
            }        
    }
    if (s_reciver_id.indexOf('<1>')==0)
    {
        s_reciver_id=s_reciver_id.substr(3,s_reciver_id.length)
    }
    if (s_reciver.length>0)
    {
        document.getElementById('Vcl_Reciver').value=s_reciver.substr(0,s_reciver.length-1)
    }else
    {
        document.getElementById('Vcl_Reciver').value=s_reciver
    }
    if (s_reciver_id.length>0)
    {
        document.getElementById('Vcl_Reciver_Id').value=s_reciver_id.substr(0,s_reciver_id.length-3)
    }else
    {
        document.getElementById('Vcl_Reciver_Id').value=s_reciver_id
    }
}
function allDeleteName_Dept(n_id)//删除全部的名称列表中的名字,功能同上
{
    var o_input=document.getElementById(n_id).getElementsByTagName('input')
    var s_reciver=document.getElementById('Vcl_Reciver_Dept').value
    if (s_reciver.length>0)
    {
        s_reciver=s_reciver+';';
    }
    var s_reciver_id=document.getElementById('Vcl_Reciver_DeptId').value
    if (s_reciver_id.length>0)
    {
        s_reciver_id='<1>'+s_reciver_id+'<1>'
    }
    var s_name=''
    var n_uid=''
    for(var i = 2; i < o_input.length; i++)
    {
        s_name=o_input[i].value+';'
        n_uid=o_input[i].id
        n_uid='<1>'+n_uid.substr(7,n_uid.length)+'<1>' 
        while (s_reciver_id.indexOf(n_uid)>=0){
            s_reciver_id=s_reciver_id.replace(n_uid,"<1>")
            s_reciver=s_reciver.replace(s_name,"")
        }
        o_input[i].className='name'      
    }
    if (s_reciver_id.indexOf('<1>')==0)
    {
        s_reciver_id=s_reciver_id.substr(3,s_reciver_id.length)
    }
    if (s_reciver.length>0)
    {
        document.getElementById('Vcl_Reciver_Dept').value=s_reciver.substr(0,s_reciver.length-1)
    }else
    {
        document.getElementById('Vcl_Reciver_Dept').value=s_reciver
    }
    if (s_reciver_id.length>0)
    {
        document.getElementById('Vcl_Reciver_DeptId').value=s_reciver_id.substr(0,s_reciver_id.length-3)
    }else
    {
        document.getElementById('Vcl_Reciver_DeptId').value=s_reciver_id
    }
}
function allDeleteName_Role(n_id)//删除全部的名称列表中的名字,功能同上
{
    var o_input=document.getElementById(n_id).getElementsByTagName('input')
    var s_reciver=document.getElementById('Vcl_Reciver_Role').value
    if (s_reciver.length>0)
    {
        s_reciver=s_reciver+';';
    }
    var s_reciver_id=document.getElementById('Vcl_Reciver_RoleId').value
    if (s_reciver_id.length>0)
    {
        s_reciver_id=s_reciver_id+'<1>'
    }
    var s_name=''
    var n_uid=''
    for(var i = 2; i < o_input.length; i++)
    {
//        s_name=o_input[i].value+';'
//        n_uid=o_input[i].id
//        n_uid=n_uid.substr(7,n_uid.length)+'<1>' 
//        while (s_reciver_id.indexOf(n_uid)>=0){
//            s_reciver_id=s_reciver_id.replace(n_uid,"")
//            s_reciver=s_reciver.replace(s_name,"")
//        }
        o_input[i].className='name'      
    }
    document.getElementById('Vcl_Reciver_Role').value=''
    document.getElementById('Vcl_Reciver_RoleId').value=''
}
function addName(n_uid)//单个加入名字
{
    var o_input=document.getElementById('uid_'+n_uid)//获取保存名字和ID的控件
    var o_input_role=document.getElementById('role'+n_uid)//获取保存名字和ID的控件
    var s_reciver=document.getElementById('Vcl_Reciver').value
    if (s_reciver.length>0)
    {
        s_reciver=s_reciver+';';
    }
    var s_reciver_id=document.getElementById('Vcl_Reciver_Id').value
    if (s_reciver_id.length>0)
    {
        s_reciver_id='<1>'+s_reciver_id+'<1>'
    }
    var s_name=o_input.value+';'     
    n_uid='<1>'+n_uid+'<1>' 
    if (s_reciver_id.indexOf(n_uid)>=0){//如果存在id 则删除,按钮变亮
        s_reciver_id=s_reciver_id.replace(n_uid,"<1>")
        s_reciver=s_reciver.replace(s_name,"")
        o_input.className='name' 
        try{
            o_input_role.className='name'   //把相应的角色中的名字也变成灰色
        }catch(e)
            {
            }  
    }else{//否则,加入名字和id,按钮变暗
        s_reciver=s_reciver+s_name
        s_reciver_id=s_reciver_id+n_uid.substr(3,n_uid.length)
        o_input.className='selected'  
        try{
            o_input_role.className='selected'   //把相应的角色中的名字也变成灰色
        }catch(e)
            {
            }  
    }  
    if (s_reciver_id.indexOf('<1>')==0)
    {
        s_reciver_id=s_reciver_id.substr(3,s_reciver_id.length)
    }
    //去掉名字输入框中最后的";" 
    if (s_reciver.length>0)
    {
        document.getElementById('Vcl_Reciver').value=s_reciver.substr(0,s_reciver.length-1)
    }else
    {
        document.getElementById('Vcl_Reciver').value=s_reciver
    }
     //去掉Id输入框中最后的"<1>"
    if (s_reciver_id.length>0)
    {
        document.getElementById('Vcl_Reciver_Id').value=s_reciver_id.substr(0,s_reciver_id.length-3)
    }else
    {
        document.getElementById('Vcl_Reciver_Id').value=s_reciver_id
    }
}
function addName_Dept(n_uid)//单个加入名字
{
    var o_input=document.getElementById('deptid_'+n_uid)//获取保存名字和ID的控件
    var s_reciver=document.getElementById('Vcl_Reciver_Dept').value
    if (s_reciver.length>0)
    {
        s_reciver=s_reciver+';';
    }
    var s_reciver_id=document.getElementById('Vcl_Reciver_DeptId').value
    if (s_reciver_id.length>0)
    {
        s_reciver_id='<1>'+s_reciver_id+'<1>'
    }
    var s_name=o_input.value+';'     
    n_uid='<1>'+n_uid+'<1>' 
    if (s_reciver_id.indexOf(n_uid)>=0){//如果存在id 则删除,按钮变亮
        s_reciver_id=s_reciver_id.replace(n_uid,"<1>")
        s_reciver=s_reciver.replace(s_name,"")
        o_input.className='name' 
    }else{//否则,加入名字和id,按钮变暗
        s_reciver=s_reciver+s_name
        s_reciver_id=s_reciver_id+n_uid.substr(3,n_uid.length)
        o_input.className='selected'   
    }  
    //去掉名字输入框中最后的";" 
    if (s_reciver_id.indexOf('<1>')==0)
    {
        s_reciver_id=s_reciver_id.substr(3,s_reciver_id.length)
    }
    if (s_reciver.length>0)
    {
        document.getElementById('Vcl_Reciver_Dept').value=s_reciver.substr(0,s_reciver.length-1)
    }else
    {
        document.getElementById('Vcl_Reciver_Dept').value=s_reciver
    }
     //去掉Id输入框中最后的"<1>"
    if (s_reciver_id.length>0)
    {
        document.getElementById('Vcl_Reciver_DeptId').value=s_reciver_id.substr(0,s_reciver_id.length-3)
    }else
    {
        document.getElementById('Vcl_Reciver_DeptId').value=s_reciver_id
    }
}
function addName_Role(n_uid)//单个加入名字
{
    var o_input=document.getElementById('roleid_'+n_uid)//获取保存名字和ID的控件
    var s_reciver=document.getElementById('Vcl_Reciver_Role').value
    if (s_reciver.length>0)
    {
        s_reciver=s_reciver+';';
    }
    var s_reciver_id=document.getElementById('Vcl_Reciver_RoleId').value
    if (s_reciver_id.length>0)
    {
        s_reciver_id='<1>'+s_reciver_id+'<1>'
    }
    var s_name=o_input.value+';'     
    n_uid='<1>'+n_uid+'<1>' 
    if (s_reciver_id.indexOf(n_uid)>=0){//如果存在id 则删除,按钮变亮
        s_reciver_id=s_reciver_id.replace(n_uid,"<1>")
        s_reciver=s_reciver.replace(s_name,"")
        o_input.className='name' 
    }else{//否则,加入名字和id,按钮变暗
        s_reciver=s_reciver+s_name
        s_reciver_id=s_reciver_id+n_uid.substr(3,n_uid.length)
        o_input.className='selected'   
    }  
    if (s_reciver_id.indexOf('<1>')==0)
    {
        s_reciver_id=s_reciver_id.substr(3,s_reciver_id.length)
    }
    //去掉名字输入框中最后的";" 
    if (s_reciver.length>0)
    {
        document.getElementById('Vcl_Reciver_Role').value=s_reciver.substr(0,s_reciver.length-1)
    }else
    {
        document.getElementById('Vcl_Reciver_Role').value=s_reciver
    }
     //去掉Id输入框中最后的"<1>"
    if (s_reciver_id.length>0)
    {
        document.getElementById('Vcl_Reciver_RoleId').value=s_reciver_id.substr(0,s_reciver_id.length-3)
    }else
    {
        document.getElementById('Vcl_Reciver_RoleId').value=s_reciver_id
    }
}
