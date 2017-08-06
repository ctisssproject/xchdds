<?php
define ( 'RELATIVITY_PATH', '' );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/it_showpage.class.php';
$o_menu = new ShowPage ( $O_Session->getUserObject () );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>西城区人民政府教育督导室  督学科信息管理平台</title>

<link href="theme/default/index.css" rel="stylesheet" type="text/css" />
<link href="theme/default/style.css" rel="stylesheet" type="text/css" />
<link href="theme/default/tree.css" rel="stylesheet" type="text/css" />
<link href="css/common.css" rel="stylesheet" type="text/css" />
<link href="css/ui.css" rel="stylesheet" type="text/css" />
<link href="css/group.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/group.fun.js"></script>
<script type="text/javascript" src="js/jquery/jquery.min.js"></script>

<script type="text/javascript" src="js/jquery/jquery-ui.custom.min.js"></script>

<script type="text/javascript"
	src="js/jquery/jquery.ui.autocomplete.min.js"></script>

<script type="text/javascript"
	src="js/jquery/jquery.effects.bounce.min.js"></script>

<script type="text/javascript" src="js/jquery/jquery.cookie.js"></script>

<script type="text/javascript" src="js/jquery/jquery.plugins.js"></script>
<script type="text/javascript" src="js/desktop.fun.js"></script>
<script type="text/javascript" src="js/ajax.class.js"></script>
<script type="text/javascript" src="js/dialog.fun.js"></script>
<script type="text/javascript" src="js/common.fun.js"></script>

</head>
<body>
<div id="north">
<div id="north_left">
<table border="0" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>&nbsp;&nbsp;西城区人民政府教育督导室&nbsp;&nbsp;督学科信息管理平台</td>
		</tr>
	</tbody>
</table>
</div>
<div id="north_right">
<div id="datetime">
<div id="time_area"></div>
<div id="date"></div>
<div id="mdate"></div>
</div>
<div style="display: none" id="weather"><span class="city" title="北京">北京</span>
<img src="images/weather/4.gif" align="absMiddle" /> <img
	src="images/weather/8.gif" align="absMiddle" /> <span class="weather"></span>
<span class="temperature"></span></div>
</div>
</div>
<div id="taskbar">
<div id="taskbar_left"><a id="start_menu" hidefocus="hidefocus"
	href="javascript:;" onclick="menuShowAndHide()"></a></div>
<div id="taskbar_center" style="width: 800px;">
<div id="tabs_left_scroll"></div>
<div id="tabs_container" style="width: 800px;">
<div id="nav1_1" class="selected"><a class="tab" hidefocus="hidefocus"
	closable="true" href="javascript:changeNav1Tab(1);">
&nbsp;我的桌面&nbsp;&nbsp;</a></div>
</div>
<div id="tabs_right_scroll"></div>
</div>
<div id="taskbar_right" style="width: 125px"><a id="person_info"
	style="display: none" href="javascript:;"
	onclick="document.getElementById('content_1_iframe').src='desktop.php'"
	hidefocus="hidefocus" title="控制面板"></a> <a id="person_info"
	href="javascript:;" onclick="addTab(90,0)" hidefocus="hidefocus"
	title="控制面板"></a> <a id="logout" href="javascript:;"
	onclick="Dialog_Confirm('确定要注销登录吗？',function (){location='index.php?loginout=true'});"
	hidefocus="hidefocus" title="注销登录"></a> <a id="hide_topbar"
	href="javascript:;" onclick="hideTop(this)" hidefocus="hidefocus"
	title="隐藏顶部"></a></div>
</div>
<div id="funcbar">
<div id="funcbar_left">
<div id="nav2_1" style="display: none; left: 182px;"
	class="second-tabs-container"></div>
</div>
</div>
<div id="center" style="height: 2000px">
<div id="content_1" class="tab-panel selected" style="height: 2000px"><iframe
	id="content_1_iframe" style="width: 100%; height: 2000px"
	src="desktop.php" marginwidth="0" marginheight="0" frameborder="0"
	framespacing="0" border="0" allowtransparency="true"></iframe></div>
</div>
<div id="south" style="height:0px;">
<?php
echo ($o_menu->getMenu ());
?>
<div style="display: none;" id="overlay_startmenu"
	onclick="menuShowAndHide()"></div>

</div>
<div id="sysmsg">
<table border="0" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td class="t_l"></td>
			<td class="t_c">
			<div>系统提示</div>
			<div class="close" title="关闭" onclick="sysmsgClose()"></div>
			</td>
			<td class="t_r"></td>
		</tr>
		<tr>
			<td class="c_l"></td>
			<td class="content">
			<div id="sysmsg_content"></div>
			</td>
			<td class="c_r"></td>
		</tr>
		<tr>
			<td width="8" class="d_l"></td>
			<td height="8" class="d_c"></td>
			<td width="8" class="d_r"></td>
		</tr>
	</tbody>
</table>
</div>
<div style="display: none; top: 29px;" id="org_panel" class="ipanel">
<div class="head">
<div class="left"><a class="active" id="user_online_tab" class=""
	hidefocus="hidefocus"><span>组织</span></a></div>
<div class="right"><a href="javascript:;" onclick="ActiveUserTab(this)"
	hidefocus="hidefocus"></a></div>
</div>
<div class="center">
<div class="top">
<div style="display: block;" id="user_online">
<div id="orgTree0">
<ul style="margin: 0px; padding: 0px">
	<li class="dynatree-lastsib"><span
		class="dynatree-node dynatree-folder dynatree-expanded dynatree-lastsib dynatree-exp-el dynatree-ico-ef">
	<img src="images/org/root.png" alt="" align="absMiddle" /><a href="#"
		style="font-size: 12px; color: black; font-weight: bold;"
		class="dynatree-title" title="组织结构"> 组织结构</a></span>
	<ul class="dynatree-container dynatree-no-connector">
		<li class="dynatree-lastsib">
                             <?php
																													echo ($o_menu->getGroupForDesktop ());
																													?>
                             </li>
	</ul>
	</li>
</ul>
</div>
</div>
</div>
<div class="bottom"><a class="btn-white-b" href="javascript:;"
	onclick="$.org_close();" hidefocus="hidefocus"> 关闭</a></div>
</div>
<div class="foot">
<div class="left"></div>
<div class="right"></div>
</div>
<div class="corner"></div>
</div>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<div id="master_box"
	style="position: absolute; z-index: 2000; left: 0px; top: -500px;"></div>
<script>
	S_Root='';
	try{
    	$(function(){sysmsgRead();timeRefresh();weatherRefresh();});
	}catch(e){
		}
	//weatherRefresh();
	setInterval('weatherRefresh()',600000);
    setInterval('sysmsgRead()',30000);
    setInterval('timeRefresh()',60000);
    setInterval('resizeLayout()',5000); 
    <?php
				if (isset ( $_GET ['module'] ) && $_GET ['module'] > 0) {
					echo ('addTabForRefresh(' . $_GET ['module'] . ',0);');
				}
				?>  
        
    </script>

</body>
</html>