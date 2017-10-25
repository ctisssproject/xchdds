<?php
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
if (isset ( $_COOKIE ['SESSIONID'] )) {

} else {
	echo ('<script>location=\'' . RELATIVITY_PATH . 'index.php\'+\'?url=\'+document.location</script>');
	exit ( 0 );
}
require_once RELATIVITY_PATH.'sub/home/include/db_table.class.php';
require_once RELATIVITY_PATH.'sub/home/include/db_view.class.php';
$s_title='北京市西城区人民政府教育督导室';
function get_page_button_for_column($s_filename,$n_all_count, $n_page_size = 20, $n_page = 1)
{
	if (fmod ( $n_all_count, $n_page_size ) == 0) {
			$n_page_count = floor ( $n_all_count / $n_page_size );
		} else {
			$n_page_count = floor ( $n_all_count / $n_page_size ) + 1;
		}
		if ($n_page_count <= 1) {
			//return '';
		}
		//$s_pagebutton .= ' 共 ' . $n_all_count . ' 篇&nbsp;&nbsp;&nbsp;&nbsp;第 ' . $n_page . ' / ' . $n_page_count . ' </span>页&nbsp;&nbsp;';
		if ($n_page > 1) {
			$s_pagebutton .= '<div class="page_btn" onclick="location=\'' . $s_filename . 'page=' . ($n_page - 1) . '\'" title="上一页">上一页</div>';
		} else {
			//$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;上一页';
		}
		for($i=1;$i<=$n_page_count;$i++)
		{
			$s_class='';
			if ($i==$n_page)
			{
				$s_class=' no_btn_on';
			}
			$s_pagebutton .= '<div class="no_btn'.$s_class.'" onclick="location=\'' . $s_filename . 'page=' . ($i) . '\'" title="第'.$i.'页">'.$i.'</div>';
		}
		if ($n_page < $n_page_count) {
			$s_pagebutton .= '<div class="page_btn" onclick="location=\'' . $s_filename . 'page=' . ($n_page + 1) . '\'" title="下一页">下一页</div>';
		} else {
			//$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;下一页';
		}
		return $s_pagebutton;	
}
function get_highline_content($s_content,$s_key,$n_sum)
{
	$s_content=str_replace('&nbsp;', '', $s_content);
	$s_content=str_replace(' ', '', $s_content);
	$s_content=str_replace('	', '', $s_content);
	$s_content=strip_tags($s_content);
	$a_content=explode($s_key, $s_content);
	if (count($a_content)>1)
	{
		$n_len=rand ( 10,50 );
		$s_content=mb_substr($a_content[0],mb_strlen($a_content[0],'utf-8')-$n_len,$n_len,'utf-8');
		$s_content.='<span style="color: #ed0000;">'.$s_key.'</span>'.$a_content[1];
	}
	return cut_str($s_content,$n_sum);
}
function cut_str($string, $length) {
	preg_match_all ( "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $info );
	for($i = 0; $i < count ( $info [0] ); $i ++) {
		$wordscut .= $info [0] [$i];
		$j = ord ( $info [0] [$i] ) > 127 ? $j + 2 : $j + 1;
		if ($j > $length - 3) {
			return $wordscut . " ...";
		}
	}
	return join ( '', $info [0] );
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo($s_title)?></title>
	<meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="css/public.css" />
    <link type="text/css" rel="stylesheet" href="css/web_style.css" />
    <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
    <script type="text/javascript">
        var b = false;
        $(function () {
            var len = $(".menu_list").length - 1;
            for (i = 1; i <= len ;i++){
                var m_pos = $(".menu_list").eq(i).position(),
                    sec_menu_l = ($(".menu_list").eq(i).outerWidth()) / 2 + m_pos.left,
                    third_menu_w = ($(".menu_list").eq(i).children(".child_menu").children("ul").outerWidth())/2,
                    third_pos = sec_menu_l - third_menu_w;
                
                $(".menu_list").eq(i).children(".child_menu").css("left", -m_pos.left);

                if (third_pos<0) {
                    $(".menu_list").eq(i).children(".child_menu").children("ul").css("left", "0px");
                } else {
                    $(".menu_list").eq(i).children(".child_menu").children("ul").css("left", third_pos);
                }
            }
            var o = 0;
            $(".link_btn").click(function () {
                if (o == 0) {
                    $(".link_div").addClass("open");
                    o = 1;
                } else {
                    $(".link_div").removeClass("open");
                    o = 0;
                }
            });
        });
    </script>
</head>
<body>
    <div align="center">
        <div class="head_box">
            <div class="head_div">
                <div class="top_box">
                    <h2>欢迎访问北京市西城区人民政府教育督导室！</h2>
                    <h3>关于我们</h3>
                    <h3>网站声明</h3>
                    <h3 onclick="location='<?php echo(RELATIVITY_PATH)?>login.php'">平台登录</h3>﻿﻿
                </div>
            </div>
            <div class="head_logo">
                <img class="f_l" alt="" src="images/logo_1.png" />
                <img class="f_r" alt="" src="images/logo_2.png" />
            </div>
        </div>
        <div class="menu_box" align="center">
            <div class="menu_div">
                <div class="menu_list" onclick="location='index.php'">首页</div>
                <?php 
                //读取栏目，构建导航菜单
                $o_column=new Home_Column();
                $o_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
				$o_column->PushWhere ( array ('&&', 'Parent', '=', 0) );
				$o_column->PushWhere ( array ('&&', 'State', '=', 1 ) );
				$o_column->PushWhere ( array ('&&', 'ColumnId', '>', 1 ) );
				$o_column->PushWhere ( array ('&&', 'ColumnId', '<',9 ) );
				$o_column->PushOrder ( array ('Number', 'A' ) );
				for($i=0;$i<$o_column->getAllCount();$i++)
				{
					$s_onclick='';
					//判断该栏目有没有子栏目，如果有没有子栏目，那么点击进入栏目页面
					$o_sub_column=new Home_Column();
					$o_sub_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
					$o_sub_column->PushWhere ( array ('&&', 'Parent', '=', $o_column->getColumnId($i)) );
					$o_sub_column->PushWhere ( array ('&&', 'State', '=', 1 ) );
					$o_sub_column->PushOrder ( array ('Number', 'A' ) );
					if ($o_sub_column->getAllCount()==0)
					{
						$s_onclick=' onclick="location=\'index_article_list.php?id='.$o_column->getColumnId($i).'\'"';						
					}
					echo('<div class="menu_list"'.$s_onclick.'>'.$o_column->getName($i));
					//构建子栏目
					$s_sub_column='';
					for($j=0;$j<$o_sub_column->getAllCount();$j++)
					{
						//如果是责任督学，那么添加“挂牌督导”，并手动将子菜单写成“责任督学”和“督学责任区”
						if ($o_sub_column->getColumnId($j)==25)
						{
							$s_sub_column.='
								<li>
	                                <div class="sec_menu_div">
                                    <h2>挂牌督导</h2>                                    
									<h3 onclick="location=\'index_article_list.php?id=25\'">责任督学</h3>							
									<h3 onclick="location=\'index_article_list.php?id=26\'">督学责任区</h3>								
	                                </div>
	                            </li>
							';
							continue;						
						}
						if ($o_sub_column->getColumnId($j)==26)
						{
							continue;					
						}
						//--------------------------------------------
						//判断有没有三级栏目，如果有，那么构建三级栏目菜单，如果没有，那么本栏目按钮可以点击
						$o_sub_sub_column=new Home_Column();
						$o_sub_sub_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
						$o_sub_sub_column->PushWhere ( array ('&&', 'Parent', '=', $o_sub_column->getColumnId($j)) );
						$o_sub_sub_column->PushWhere ( array ('&&', 'State', '=', 1 ) );
						$o_sub_sub_column->PushOrder ( array ('Number', 'A' ) );
						$s_sub_sub_column='';
						for($k=0;$k<$o_sub_sub_column->getAllCount();$k++)
						{
							$s_sub_sub_column.='
								<h3 onclick="location=\'index_article_list.php?id='.$o_sub_sub_column->getColumnId($k).'\'">'.$o_sub_sub_column->getName($k).'</h3>
							';
						}
						if ($o_sub_sub_column->getAllCount()==0)
						{
							$s_sub_sub_column='
								<h3 onclick="location=\'index_article_list.php?id='.$o_sub_column->getColumnId($j).'\'">'.$o_sub_column->getName($j).'</h3>
							';
						}						
						$s_sub_column.='
							<li>
                                <div class="sec_menu_div">
                                    <h2>'.$o_sub_column->getName($j).'</h2>
                                    '.$s_sub_sub_column.'
                                </div>
                            </li>
						';
					}
					if ($o_sub_column->getAllCount()>0)
					{
						echo('
						<div class="child_menu">
	                        <ul>
	                            '.$s_sub_column.'
	                        </ul>
	                    </div>
						');
					}
					echo('</div>');
				}
                ?>
                <div class="search_box">
                    <input id="Vcl_KeySearchArticle" type="text" value="<?php echo($_GET['key'])?>" placeholder="搜索..."/>
                    <div class="search_btn" onclick="search_article()">
                        <img alt="" src="images/search.png" />
                    </div>
                </div>
            </div>
        </div>
        <script>
        $(function(){
        	$('#Vcl_KeySearchArticle').keypress(function(event){  
        	    var keycode = (event.keyCode ? event.keyCode : event.which);  
        	    if(keycode == '13'){  
        	    	search_article()   
        	    }  
        	});
        })
        function search_article()
        {
        	var id='Vcl_KeySearchArticle';
        	if (document.getElementById(id).value=='')
        	{
            	return;
            }
            location='index_search.php?key='+encodeURIComponent(document.getElementById(id).value);
        }
        </script>