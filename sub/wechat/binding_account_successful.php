<?php
require_once 'include/it_include.inc.php';
$s_title='微信绑定成功';
require_once 'header.php';
?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">微信绑定成功</h2>
            <p class="weui-msg__desc">您的微信号已经成功绑定到系统后台账户，现在您可以进入服务号进行相关操作了。</p>
        </div>
    </div>
    <div style="padding:15px;">
		<a class="weui-btn weui-btn_primary" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">确定</a>
	</div>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once 'footer.php';?>