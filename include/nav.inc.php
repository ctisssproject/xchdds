<?php
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$O_Session->ValidModuleForPage ( MODULEID );
$o_module=new Base_Module(MODULEID);
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
                    <?php 
                    $s_html='';
                    $s_rul='';//保存最终的右边的页面
                    
                    //循环制作导航菜单
                    $o_user = new Single_User ( $O_Session->getUid() );
                    $o_module=new Base_Module();
                    $o_module->PushWhere ( array ('&&', 'ParentModuleId', '=', MODULEID ) );
                    $o_module->PushOrder ( array ('Module', 'A' ) );
                    $n_count=$o_module->getAllCount();
                    $s_sum=0;
                    for($i = 0; $i < $n_count; $i ++) {
                    	$b_end=false;
                    	if ($o_user->ValidModule($o_module->getModuleId($i))==false)
                    	{
                    		continue;
                    	}
                    	//判断下一个是否是最后一个，并且是否有权限
                    	if(($i + 1) == ($n_count-1))
                    	{
	                    	if ($o_user->ValidModule($o_module->getModuleId($i+1))==false)
	                    	{
	                    		$b_end=true;
	                    	}
                    	}else{
                    		//如果不是最后一个，判断下面的是否还有权限
                    		$j=$i + 1;
                    		for($j=$i+1;$j<$n_count;$j++)
                    		{
	                    		if ($o_user->ValidModule($o_module->getModuleId($j))==false)
		                    	{
		                    		$b_end=true;
		                    	}else{
		                    		$b_end=false;
		                    		break;
		                    	}
                    		}
                    	}
						if ($s_sum == 0) {
							$s_rul = RELATIVITY_PATH. $o_module->getPath ( $i );
							$s_html .= '
			                     <table class="BlockTop" width="100%">
			                        <tbody>
			                            <tr>
			                                <td class="left">
			                                </td>
			                                <td class="center">
			                                    <a href="'.RELATIVITY_PATH. $o_module->getPath ( $i ) . '" class="header" target="diary_body">' . $o_module->getName ( $i ) . '</a>
			                                </td>
			                                <td class="right">
			                                </td>
			                            </tr>
			                        </tbody>
			                    </table>
							';
						} else if (($i + 1) == $n_count || $b_end) {
							$s_html .= '
			                    <table class="BlockBottom no-top-border" >
			                        <tbody>
			                            <tr>
			                                <td class="left">
			                                </td>
			                                <td class="center">
			                                    <a href="'.RELATIVITY_PATH. $o_module->getPath ( $i ) . '" class="header" target="diary_body">' . $o_module->getName ( $i ) . '</a>
			                                </td>
			                                <td class="right">
			                                </td>
			                            </tr>
			                        </tbody>
			                    </table>
							';
						} else if ($s_sum == 1) {
							$s_html .= '
			                    <div class="head no-top-border"><a href="'.RELATIVITY_PATH. $o_module->getPath ( $i ) . '" class="header" target="diary_body">' . $o_module->getName ( $i ) . '</a></div>
							';
						} else {
							$s_html .= '
			                    <div class="head"><a href="'.RELATIVITY_PATH. $o_module->getPath ( $i ) . '" class="header" target="diary_body">' . $o_module->getName ( $i ) . '</a></div>			                    
							';
						}
						$s_sum++;
					}
                    echo($s_html);
                    ?>
                </td>
                <td id="right">
                <div id="center">
                    <iframe id="diary_body" name="diary_body" src="<?php echo($s_rul)?>" onload="jQuery(window).triggerHandler('resize');"
                        border="0" framespacing="0" marginheight="0" marginwidth="0" style="width: 100%;" frameborder="0"></iframe>
                </div>
                </td>
            </tr>
        </tbody>
    </table>

</body>
</html>