function passwordModifySubmit()
{
    temp=document.getElementById('Vcl_Password_Old').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 原始密码 ] 不能为空")
        return
    }
    temp=document.getElementById('Vcl_Password').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 新密码 ] 不能为空")
        return
    }
    if (temp.length<6){
        parent.parent.Dialog_Message("[ 新密码 ] 不能小于6个字符")
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
function info_modify_submit()
{
    temp=document.getElementById('Vcl_Name').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 真是姓名 ] 不能为空！")
        return
    }
   document.getElementById('dialog_form').submit();
   parent.parent.Common_OpenLoading();   
    
}