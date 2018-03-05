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
function wechat_unbinding() {
    parent.parent.Dialog_Confirm('真的要解除微信绑定吗？',function(){
    	parent.parent.Common_OpenLoading();
    	var data = 'Ajax_FunName=WechatUnbinding'; //后台方法
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	location='binding_wechat.php';      	
        })
    })
}
function wechat_get_binding_status() {
    var data = 'Ajax_FunName=WechatGetBindingStatus'; //后台方法
    $.getJSON("include/bn_submit.switch.php", data, function (json) {
    	if(json.flag==1)
		{
			var a_arr=[];
			a_arr.push('<table class="TableBlock_Editor" align="center" width="600" style="margin-top:10px">');
			a_arr.push('	<tbody>');
			a_arr.push('		<tr>');
			a_arr.push('			<td colspan="2" class="TableData" nowrap="nowrap" style="text-align:center">');
			a_arr.push('				<img style="width:50%" src="'+json.photo+'">');
			a_arr.push('			</td>');
			a_arr.push('		</tr>');
			a_arr.push('		<tr>');
			a_arr.push('			<td class="TableData" nowrap="nowrap" width="120">微信昵称：</td>');
			a_arr.push('			<td class="TableData">');
			a_arr.push(json.name);
			a_arr.push('			</td>');
			a_arr.push('		</tr>');
			a_arr.push('<tr align="center"><td colspan="2" nowrap="nowrap" height="40" class="TableData" ><input value="解除绑定" class="BigButtonB" type="button" onclick="wechat_unbinding()"/></td></tr>');
			$('#sss_form').html(a_arr.join('\n'));
			window.clearInterval(N_Timer);
		}
    })
}