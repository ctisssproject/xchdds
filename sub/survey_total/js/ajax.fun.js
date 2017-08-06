function delete_total(id)
{
    var o_ajax_request=new AjaxPostRequest();
    o_ajax_request.setFunction('TotalDelete');
    o_ajax_request.setParameter('Id', id);
    parent.parent.Dialog_Confirm("真的要删除这条记录吗？",function (){o_ajax_request.SendRequest()});
}