<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30020 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$O_Session->ValidModuleForPage ( MODULEID );
$o_module=new Base_Module(MODULEID);
$o_user = new Single_User ( $O_Session->getUid() );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="../../theme/default/style.css" />
 <link href="../../theme/default/layout_left.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="../../theme/default/bjsql.css" />
     <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../js/jquery/jquery.min.js"></script>
<script type="">
function resizeLayout()
   {
      // 主操作区域高度
      var wWidth = (window.document.documentElement.clientWidth || window.document.body.clientWidth || window.innerHeight);
      var wHeight = (window.document.documentElement.clientHeight || window.document.body.clientHeight || window.innerHeight);
      var nHeight = $('#north').is(':visible') ? $('#north').outerHeight() : 0;
      var fHeight = $('#funcbar').is(':visible') ? $('#funcbar').outerHeight() : 0;
      var cHeight = wHeight - nHeight - fHeight - $('#south').outerHeight() - $('#taskbar').outerHeight()-3;
      $('#center').height(cHeight);
      $("#center iframe").css({height: cHeight});

/*
      if(isTouchDevice())
      {
         $('.tabs-panel:visible').height(cHeight);
         if($('.tabs-panel > iframe:visible').height() > cHeight)
            $('.tabs-panel:visible').height($('.tabs-panel > iframe:visible').height());
      }
*/
      //一级标签宽度
      var width = wWidth - $('#taskbar_left').outerWidth() - $('#taskbar_right').outerWidth();
      $('#tabs_container').width(width - $('#tabs_left_scroll').outerWidth() - $('#tabs_right_scroll').outerWidth() - 2);
      $('#taskbar_center').width(width-1);   //-1是为了兼容iPad
      $('#tabs_container').triggerHandler('_resize');
   };
 $(window).resize(function(){resizeLayout();});
</script>
</head>
<body class="bodycolor">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td id="left">
                    <div class="Big" style="padding-top: 15px; padding-bottom: 15px">
                        <img src="../../images/form.gif" align="absmiddle"/>&nbsp;&nbsp;<span class="big3"><?php echo($o_module->getName())?></span>&nbsp;
                    </div>
                    			<table class="BlockTop" width="100%">
			                        <tbody>
			                            <tr>
			                                <td class="left">
			                                </td>
			                                <td class="center">
			                                    <a href="javascript:;" class="header" target="diary_body">自查</a>
			                                </td>
			                                <td class="right">
			                                </td>
			                            </tr>
			                        </tbody>
			                    </table>
			        <div class="container no-bottom-border" id="emailbox_menu">
			        <?php 
			        $s_url='';
			        $o_module=new Base_Module(30021);
			        if ($o_user->ValidModule($o_module->getModuleId()))
			        {
			        	echo('<a href="'.RELATIVITY_PATH.$o_module->getPath().'" target="diary_body">
                        		自查任务
                        	</a>');
			        	if ($s_url=='')
			        	{
			        		$s_url=$o_module->getPath();
			        	}
			        }
			        $o_module=new Base_Module(30022);
			        if ($o_user->ValidModule($o_module->getModuleId()))
			        {
			        	echo('<a href="'.RELATIVITY_PATH.$o_module->getPath().'" target="diary_body">
                        		学校反馈
                        	</a>');
			        	if ($s_url=='')
			        	{
			        		$s_url=$o_module->getPath();
			        	}
			        }
			        $o_module=new Base_Module(30023);
			        if ($o_user->ValidModule($o_module->getModuleId()))
			        {
			        	echo('<a href="'.RELATIVITY_PATH.$o_module->getPath().'" target="diary_body">
                        		已完成
                        	</a>');
			        	if ($s_url=='')
			        	{
			        		$s_url=$o_module->getPath();
			        	}
			        }
			        $o_module=new Base_Module(30034);
			        if ($o_user->ValidModule($o_module->getModuleId()))
			        {
			        	echo('<a href="'.RELATIVITY_PATH.$o_module->getPath().'" target="diary_body">
                        		自查统计
                        	</a>');
			        	if ($s_url=='')
			        	{
			        		$s_url=$o_module->getPath();
			        	}
			        }
			        ?>	                     
                    </div>
                    <div class="head no-top-border"><a href="javascript:;" class="header" target="diary_body">督查</a></div>  
                    <div class="container no-bottom-border" id="emailbox_menu">
			        <?php 
			        $o_module=new Base_Module(30026);
			        if ($o_user->ValidModule($o_module->getModuleId()))
			        {
			        	echo('<a href="'.RELATIVITY_PATH.$o_module->getPath().'" target="diary_body">
                        		督查任务
                        	</a>');
			        	if ($s_url=='')
			        	{
			        		$s_url=$o_module->getPath();
			        	}
			        }
			        $o_module=new Base_Module(30027);
			        if ($o_user->ValidModule($o_module->getModuleId()))
			        {
			        	echo('<a href="'.RELATIVITY_PATH.$o_module->getPath().'" target="diary_body">
                        		学校反馈
                        	</a>');
			        	if ($s_url=='')
			        	{
			        		$s_url=$o_module->getPath();
			        	}
			        }/*
			        $o_module=new Base_Module(30028);
			        if ($o_user->ValidModule($o_module->getModuleId()))
			        {
			        	echo('<a href="'.RELATIVITY_PATH.$o_module->getPath().'" target="diary_body">
                        		责任督学汇总
                        	</a>');
			        	if ($s_url=='')
			        	{
			        		$s_url=$o_module->getPath();
			        	}
			        }*/
			        $o_module=new Base_Module(30028);
			        if ($o_user->ValidModule($o_module->getModuleId()))
			        {
			        	echo('<a href="'.RELATIVITY_PATH.$o_module->getPath().'" target="diary_body">
                        		已完成
                        	</a>');
			        	if ($s_url=='')
			        	{
			        		$s_url=$o_module->getPath();
			        	}
			        }
			        ?>	                     
                    </div>
                </td>
                <td id="right">
                <div id="center">
                    <iframe id="diary_body" name="diary_body" src="<?php echo(RELATIVITY_PATH.$s_url)?>" onload="jQuery(window).triggerHandler('resize');"
                        border="0" framespacing="0" marginheight="0" marginwidth="0" style="width: 100%;" frameborder="0"></iframe>
                </div>
                </td>
            </tr>
        </tbody>
    </table>

</body>
</html>