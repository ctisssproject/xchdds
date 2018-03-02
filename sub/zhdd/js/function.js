function zbtx_manage_project_submit() {
    if ($('#Vcl_Name').val() == '') {
        parent.parent.Dialog_Message('标题不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function zbtx_manage_project_release(id) {
	parent.parent.Dialog_Confirm('真的要发布这个指标体系吗？<br/>发布后不能修改，请谨慎操作。',function(){
    	parent.parent.Common_OpenLoading()
    	var data = 'Ajax_FunName=ZbtxProjectRelease'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	location.reload();      	
        })
    })
}
function zbtx_manage_project_delete(id) {
	parent.parent.Dialog_Confirm('真的要删除这个指标体系吗？<br/>删除后不能恢复，请谨慎操作。',function(){
    	parent.parent.Common_OpenLoading()
    	var data = 'Ajax_FunName=ZbtxProjectDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	location.reload();      	
        })
    })
}
function zbtx_manage_level1_submit() {
    if ($('#Vcl_Name').val() == '') {
        parent.parent.Dialog_Message('名称不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function zbtx_manage_level1_delete(id) {
	parent.parent.Dialog_Confirm('真的要删除这个指标吗？<br/>删除后不能恢复，请谨慎操作。',function(){
    	parent.parent.Common_OpenLoading()
    	var data = 'Ajax_FunName=ZbtxProjectLevel1Delete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	location.reload();      	
        })
    })
}
function zbtx_manage_level2_submit() {
    if ($('#Vcl_Name').val() == '') {
        parent.parent.Dialog_Message('名称不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function zbtx_manage_level2_delete(id) {
	parent.parent.Dialog_Confirm('真的要删除这个指标吗？<br/>删除后不能恢复，请谨慎操作。',function(){
    	parent.parent.Common_OpenLoading()
    	var data = 'Ajax_FunName=ZbtxProjectLevel2Delete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	location.reload();
        })
    })
}
function zbtx_manage_level3_submit() {
    if ($('#Vcl_Name').val() == '') {
        parent.parent.Dialog_Message('名称不能为空！！')
        return;
    }
    if ($('#Vcl_Score').val() == '') {
        parent.parent.Dialog_Message('分值不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function zbtx_manage_level3_delete(id) {
	parent.parent.Dialog_Confirm('真的要删除这个指标吗？<br/>删除后不能恢复，请谨慎操作。',function(){
    	parent.parent.Common_OpenLoading()
    	var data = 'Ajax_FunName=ZbtxProjectLevel3Delete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	location.reload();
        })
    })
}
function zbtx_school_task_upload_submit() {
    if ($('#Vcl_Explain').val() == '') {
        parent.parent.Dialog_Message('说明不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function zbtx_school_task_upload_delete(id) {
	parent.parent.Dialog_Confirm('真的要删除这个文件吗？<br/>删除后不能恢复，请谨慎操作。',function(){
    	parent.parent.Common_OpenLoading()
    	var data = 'Ajax_FunName=ZbtxSchoolUploadDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	location.reload();
        })
    })
}
function zbtx_manage_list_school_close(id) {
	parent.parent.Dialog_Confirm('真的要关闭上传吗？<br/>关闭后不能恢复，请谨慎操作。',function(){
    	parent.parent.Common_OpenLoading()
    	var data = 'Ajax_FunName=ZbtxManageSchoolListClose'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	location.reload();
        })
    })
}
function zbtx_manage_list_school_open(id) {
	parent.parent.Dialog_Confirm('真的要重新开放吗？<br/>开放后，学校将重新开始上传资料。',function(){
    	parent.parent.Common_OpenLoading()
    	var data = 'Ajax_FunName=ZbtxManageSchoolListOpen'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	location.reload();
        })
    })
}
function appraise_manage_add_submit() {
    if ($('#Vcl_Name').val() == '') {
        parent.parent.Dialog_Message('标题不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function appraise_delete(id) {
	parent.parent.Dialog_Confirm('真的要删除这个评价表吗？<br/>删除后不能恢复，请谨慎操作。',function(){
    	parent.parent.Common_OpenLoading();
    	var data = 'Ajax_FunName=AppraiseDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	location.reload();
        });
    })
}
function appraise_single_add() {

    if ($('#Vcl_Content').val() == '') {
        parent.parent.Dialog_Message('题目不能为空！！')
        return;
    }
    if ($('#Vcl_Option_A').val() == '') {
        parent.parent.Dialog_Message('选项不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function appraise_answer_add() {

    if ($('#Vcl_Content').val() == '') {
        parent.parent.Dialog_Message('题目不能为空！！')
        return;
    }
    document.getElementById('submit_form').submit();
    parent.parent.Common_OpenLoading()
}
function appraise_question_setnumber(id,number)
{
    parent.parent.Common_OpenLoading();
    var data = 'Ajax_FunName=AppraiseQuestionSetNumber'; //后台方法
    data = data + '&id=' + id;
    data = data + '&number=' + number;
    $.getJSON("include/bn_submit.switch.php", data, function (json) {
      	location.reload();
    });
}
function appraise_question_delete(id) {
	parent.parent.Dialog_Confirm('真的要删除这道题吗？<br/>删除后不能恢复，请谨慎操作。',function(){
    	parent.parent.Common_OpenLoading();
    	var data = 'Ajax_FunName=AppraiseQuestionDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	location.reload();
        });
    })
}
function appraise_release(id) {
	parent.parent.Dialog_Confirm('真的要发布这个评价表吗？<br/>发布后不能修改，请谨慎操作。',function(){
    	parent.parent.Common_OpenLoading()
    	var data = 'Ajax_FunName=AppraiseRelease'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	location.reload();      	
        })
    })
}