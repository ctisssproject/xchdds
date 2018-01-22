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