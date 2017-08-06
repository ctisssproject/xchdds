
function review_printer()
{
    var temp=document.getElementById('Vcl_Sum').value;
    if (temp.length==0){
        parent.parent.Dialog_Message("[ 打印条数 ] 不能为空")
        return
    }
    var school=document.getElementById('Vcl_SchoolId').value;
    if (school.length==0){
        parent.parent.Dialog_Message("[ 学校编号 ] 不能为空")
        return
    }
    var type=document.getElementById('Vcl_Type').value;
    window.open('printer.php?sum='+temp+'&type='+type+'&school='+school,'_blank')
}
function del_allcode() {
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('DeleteAllCode');
    parent.parent.Dialog_Confirm('是否清空所有编号？',function(){o_ajax_request.SendRequest()})
}
function del_complete() {
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('DeleteComplete');
    parent.parent.Dialog_Confirm('是否删除已完成的编号？',function(){o_ajax_request.SendRequest()})
}