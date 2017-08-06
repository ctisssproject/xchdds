<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/it_showpage.class.php';
$O_Session->ValidModuleForPage(MODULEID);
if (is_numeric ( $_GET ['page'] )) {
	$o_page = $_GET ['page'];
	
} else {
	$o_page = 1;

}
setcookie ( 'ShowTable',1, 0 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet"
	type="text/css" />
<link href="../../css/common.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/dialog.fun.js"></script>
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="js/control.fun.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
</head>
<body class="bodycolor" topmargin="0">
<div style="overflow: hidden;width:100%;text-align:center;position:absolute;background-color:#F6F7F9;<?php 
if ($_COOKIE['ShowTable']==1)
{
	echo('display:none');
}
?>">
<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td style="height:500px;width:800px;vertical-align:top;padding-top:20px;font-size: 20px;color:#393939;">
			<strong style="font-size: 30px;">西城区人民政府教育督导室责任督学</strong><br/>
<strong style="font-size: 30px;">挂牌督导值班要求</strong><br/>
　　　<div style="text-align:left;">　　　为贯彻落实《教育督导条例》和《中小学校责任督学挂牌督导办法》，进一步健全我区教育督导制度，规范学校办学行为，按照《西城区中小学校责任督学挂牌督导工作实施方案（试行）》中的要求，区督导室设立督导电话热线和公共邮箱，每天安排2名责任督学值班。为做好此项工作，制定本要求。<br/>
　　　一、关于接听电话<br/>
　　　1.责任督学在规定时间内到岗值班，保持电话畅通。<br/>
　　　2.责任督学接听来电时态度诚恳、耐心细致，语言文明、严谨规范。<br/>
　　　3.责任督学要严格按照工作要求，认真填写《责任督学挂牌督导热线电话（邮件）记录》中的内容。<br/>
　　　二、关于登录邮箱<br/>
　　　4.责任督学值班时应及时登录挂牌督导公共邮箱（网址为：xichengdu<br/>
daoshi@163.com，密码：xcdd6419），查看来往邮件。<br/>
　　　5. 责任督学要严格按照工作要求，认真填写《责任督学挂牌督导热线电话（邮件）记录》中的内容。<br/>
　　　三、关于处理反映问题<br/>
　　　6.责任督学对一般性咨询问题，如了解相关情况可以直接答复；如不了解，应与学校责任督学或教委相关科室（部门）进行沟通，再依据实际情况给予答复。<br/>
　　　7.责任督学对特殊问题（如举报或投诉等），要认真整理相关内容，做好书面记录，并填写《西城区责任督学挂牌督导特殊问题办理记录单》（见附件1）。责任督学应及时将《西城区责任督学挂牌督导特殊问题办理记录单》报送到教育督导室，经督导室领导批阅后，请两委相关科室（部门）协调解决，责任督学要跟踪问题办理过程，确保问题尽早解决。
　　　</div>
　　　　<div style="text-align:right">　　　　　　　　　　　　　　　　　　　　　西城区人民政府教育督导室<br/>
　　　                                      2015年1月30日</div>　
		</td>
	</tr>
</table>
</div>
<div style="padding-left:10px;padding-right:10px;padding-top:5px">
<?php
$o_list = new ShowPage ( $O_Session->getUserObject ());
echo ($o_list->getRecordList($o_page));
?>
</div>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<div id="master_box"
	style="position: absolute; z-index: 2000; left: 0px; top: -500px;">
</div>
</body>
</html>
