<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='选择评价表';
require_once '../header.php';
//读取
require_once RELATIVITY_PATH . 'sub/zhdd/include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
$o_bn_basic=new Bn_Basic();
//读取当前所有日期下的记录
$o_input=new Zhdd_Appraise_Input();
$o_input->PushWhere ( array ('&&', 'Key1', '=',$o_bn_basic->GetDate()) );
$o_input->PushWhere ( array ('||', 'Key1', '=',str_replace('-', '/',$o_bn_basic->GetDate())) );
$a_type=array();
$a_schoolName=array();
$a_subject=array();
for ($i=0;$i<$o_input->getAllCount();$i++)
{
	array_push($a_type, $o_input->getType($i));
	array_push($a_schoolName, $o_input->getSchoolName($i));
	if ($o_input->getType($i)!='中小学主题班（队）会')
	{
		array_push($a_subject, $o_input->getKey3($i));
	}	
}
$a_type=array_values(array_unique($a_type));
$a_schoolName=array_values(array_unique($a_schoolName));
$a_subject=array_values(array_unique($a_subject));
?>
	<script type="text/javascript" src="js/control.fun.js"></script>
	<div class="weui-cells__title">条件筛选</div>
    <div class="weui-cells">
    	<div class="weui-cell weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">日期</label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" disabled="disabled" type="text" value="<?php echo($o_bn_basic->GetDate())?>">
            </div>
        </div>
        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">类型</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select" id="Vcl_Type" onchange="changeType(this)">
                	<?php
                	for($i=0;$i<count($a_type);$i++)
                	{
                		echo('<option value="'.$a_type[$i].'">'.$a_type[$i].'</option>');
                	}
                	?>
                </select>
            </div>
        </div>
        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">学校</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select" id="Vcl_SchoolName" >
                	<?php
                	for($i=0;$i<count($a_schoolName);$i++)
                	{
                		echo('<option value="'.$a_schoolName[$i].'">'.$a_schoolName[$i].'</option>');
                	}
                	?>
                </select>
            </div>
        </div>
        <div id="subject" class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">科目</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select" id="Vcl_Subject" >
               		<option value=""></option>
                	<?php
                	for($i=0;$i<count($a_subject);$i++)
                	{
                		echo('<option value="'.$a_subject[$i].'">'.$a_subject[$i].'</option>');
                	}
                	?>
                </select>
            </div>
        </div>
    </div>
    <div style="padding:15px;">
	    <a href="javascript:;" class="weui-btn weui-btn_primary" onclick="load_course()">查找</a>
    </div>
    <div class="weui-cells__title">评价列表 （<span id="count">0</span> 个结果）</div>
		<div id="course_list">
			
        </div>
<script>
$(function () {
    $(document).scroll(function () {
	    if($(window).scrollTop()>200)
		{
			//显示置顶按钮
			$('.sss_gotop').fadeIn(300)
		}else{
			//隐藏置顶按钮
			$('.sss_gotop').fadeOut(300)
		}
    });
    changeType(document.getElementById('Vcl_Type'))
}); 
function changeType(obj)
{
	$('#Vcl_Subject').val('');
	if (obj.value=="中小学主题班（队）会")
	{
		$('#subject').hide();
	}else{
		$('#subject').show();
	}
}
//禁止分享
//document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>