function load_course()
{
	Common_OpenLoading();
    var data = 'Ajax_FunName=LoadCourse'; //后台方法
    data = data + '&schoolname=' + encodeURIComponent($('#Vcl_SchoolName').val())+ '&type=' +encodeURIComponent($('#Vcl_Type').val())+ '&subject=' + encodeURIComponent($('#Vcl_Subject').val());
    $.getJSON("include/bn_submit.switch.php", data, function (json) {
	     build_course_list(json)       	
	})
}
function build_course_list(json)
{
	$('#count').html(json.length)
	var a_arr=[];
	for(var i=0;i<json.length;i++)
	{
		var data=json[i];
		a_arr.push('	<div class="weui-form-preview">');    
	    a_arr.push('        <div class="weui-form-preview__bd">');
	    //循环显示
	    var a_item=json[i].item;
	    var a_value=json[i].value;
	    for (var j=0; j<a_item.length; j++)
	    {
	    	a_arr.push('        	<div class="weui-form-preview__item">');
		    a_arr.push('                <label class="weui-form-preview__label">'+a_item[j]+'</label>');
		    a_arr.push('                <span class="weui-form-preview__value">'+a_value[j]+'</span>');
		    a_arr.push('            </div>');
	    }
	    a_arr.push('        </div>');
	    a_arr.push('        <div class="weui-form-preview__ft">');
	    a_arr.push('            <a class="weui-form-preview__btn weui-form-preview__btn_primary" href="'+json[i].url+'">开始评价</a>');
	    a_arr.push('        </div>');
	    a_arr.push('    </div>');
	    a_arr.push('    <br>');
	}
	$('#course_list').html(a_arr.join('\n'));
	Common_CloseDialog()
}