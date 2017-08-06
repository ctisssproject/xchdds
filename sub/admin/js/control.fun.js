
//////////////////////////////////////////////////////////////////角色管理////////////////////////////////////////////////
function roleSelectAllModuleRoot(obj)
{
//模块根目录全选
    var a_check=obj.parentNode.parentNode.parentNode.getElementsByTagName('input')
    if (obj.checked==true)
    {
        //全选所有子项        
        for (var i=0;i<a_check.length;i++)
        {
            a_check[i].checked=true;
        }
    }else{
        //取消所有子项
        for (var i=0;i<a_check.length;i++)
        {
            a_check[i].checked=false;
        }
    }
}
function roleSelectSubCheckParentSelect(obj)
{
//如果同级的钩子都没有勾上，父钩子也要不勾
    var b_check=false
    var a_tr=obj.parentNode.parentNode.parentNode.getElementsByTagName('tr')//获取所有的tr
    //循环
    for (var i=1;i<a_tr.length;i++)
    {
        var a_td=a_tr[i].getElementsByTagName('td')
        var a_input=a_td[0].getElementsByTagName('input')
        if (a_input[0].checked==true)
        {
            b_check=true
        }
    }
    if (b_check)
    {
        var a_input=a_tr[0].getElementsByTagName('input')
        a_input[0].checked=true
    }else{
        var a_input=a_tr[0].getElementsByTagName('input')
        a_input[0].checked=false
    }

}
function roleSelectAllModuleSub(obj)
{
//模块子目录全选
    var a_check=obj.parentNode.parentNode.getElementsByTagName('input')
    if (obj.checked==true)
    {
        //全选所有子项        
        for (var i=0;i<a_check.length;i++)
        {
            a_check[i].checked=true;
        }
    }else{
        //取消所有子项
        for (var i=0;i<a_check.length;i++)
        {
            a_check[i].checked=false;
        }
    }
    roleSelectSubCheckParentSelect(obj)

}
function roleSelectOnClick(obj)
{
    if (obj.checked==true)
    {
        //让他的父级勾选
        //并检测父级     
        var a_input=obj.parentNode.getElementsByTagName('input')
        a_input[0].checked=true;
        roleSelectSubCheckParentSelect(a_input[0])
    }else{
        //检查本级所有的钩子，如果有勾选，就什么都不做，如果都没有勾选，把父级钩子去掉，然后检测父级
        var b_check=false
        var a_input=obj.parentNode.getElementsByTagName('input')
        for (var i=1;i<a_input.length;i++)
        {
            if (a_input[i].checked==true)
            {
                b_check=true
            }
        }
        if (b_check==false)
        {
        //去掉父钩子
            a_input[0].checked=false;
            roleSelectSubCheckParentSelect(a_input[0])
        }        
    }
}