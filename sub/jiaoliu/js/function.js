function addArticle(){
	var s_title=document.getElementById ('Vcl_Date').value
    if (s_title.length==0){
        parent.parent.Dialog_Message('[ 发布日期 ] 不能为空 ！');
        return
    }
    var s_title=document.getElementById ('Vcl_Title').value
    if (s_title.length==0){
        parent.parent.Dialog_Message('[ 标题 ] 不能为空 ！');
        return
    }
    var s_title=document.getElementById ('Vcl_SchoolJoin').value
    if (s_title.length==0){
        parent.parent.Dialog_Message('[ 学校参加人员 ] 不能为空 ！');
        return
    }
	var obj=$('.DuxueJoin')
	var b_selected=false;
	for(var i=0; i<obj.length; i++)
	{
		if (obj[i].checked)
		{
			b_selected=true;
		}
	}
	if (b_selected==false)
	{
		if(obj.length==0)
		{
			var s_title=document.getElementById ('Vcl_DuxueJoin').value
		    if (s_title.length==0){
		        parent.parent.Dialog_Message('[ 督学参加人员  ] 不能为空 ！');
		        return
		    }
		}else{
			parent.parent.Dialog_Message('请选择[ 督学参加人员 ]！');
        	return
		}		
	}
    document.getElementById ('Vcl_Content').value=UE.getEditor('editor').getContent()
    var s_content=document.getElementById ('Vcl_Content').value
    if (s_content.length<10){
        parent.parent.Dialog_Message('对不起 , 文章内容太少 !');
        return
    } 
    
    var s_title=document.getElementById ('Vcl_Feedback').value
    if (s_title.length==0){
        parent.parent.Dialog_Message('[ 意见建议 ] 不能为空 ！');
        return
    }
    document.getElementById('dialog_form').submit();
	parent.parent.Common_OpenLoading();   
}
function deleteArticle(n_id)
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DeleteArticle');
    o_ajax_request.setPage('include/it_ajax.svr.php');
    o_ajax_request.PushParameter(n_id);
    parent.parent.Dialog_Confirm("真的要删除文章吗？",function (){o_ajax_request.SendRequest()});
}