<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='已被评价';
require_once '../header.php';
?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-warn weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
        	<h2 class="weui-msg__title">已被评价</h2>
            <p class="weui-msg__desc">对不起，该课程已被其他督学评价，请更换！</p>
        </div>
    </div>
    <div style="padding:15px;">
		<a class="weui-btn weui-btn_primary" onclick="location='appraise.php'">确定</a>
	</div>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>