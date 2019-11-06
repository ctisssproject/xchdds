<?php
define ( 'RELATIVITY_PATH', '../../' );
require_once 'index_header.php';
function get_week($date){
        //强制转换日期格式
    $date_str=date('Y-m-d',strtotime($date));    
    //封装成数组
    $arr=explode("-", $date_str);     
    //参数赋值
    //年
    $year=$arr[0];         
        //月，输出2位整型，不够2位右对齐
    $month=sprintf('%02d',$arr[1]);         
        //日，输出2位整型，不够2位右对齐
    $day=sprintf('%02d',$arr[2]);         
    //时分秒默认赋值为0；
    $hour = $minute = $second = 0;            
    //转换成时间戳
    $strap = mktime($hour,$minute,$second,$month,$day,$year);        
    //获取数字型星期几
    $number_wk=date("w",$strap);         
    //自定义星期数组
    $weekArr=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");     
    //获取数字对应的星期
    return $weekArr[$number_wk];
}
?>
<script type="text/javascript" src="js/slick/slick.js"></script>
<link type="text/css" rel="stylesheet" href="css/slick.css" />
<link type="text/css" rel="stylesheet" href="css/slick-theme.css" />
<script type="text/javascript">
        $(function () {
            $(".news_img_box").slick({
                dots: true,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 3000,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: true
            });
        });
</script>
        <div class="page_body" align="left">
            <div class="index_top">
                <!--新闻列表-->
                <div class="new_box">
                <?php 
                    //获取工作动态的文章
                    $o_temp=new Home_Article();
					$o_temp->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
					$o_temp->PushWhere ( array ('&&', 'Audit', '=', 3) );
					$o_temp->PushWhere ( array ('&&', 'ColumnId', '=', 2) );
					$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
					$o_temp->PushOrder ( array ('Date', 'D' ) );
					$o_temp->setStartLine ( 0 ); //起始记录
					$o_temp->setCountLine (8);
					$o_temp->getAllCount ();
					if ($o_temp->getCount ()>0)
					{
						echo('
						<div class="newest_div" onclick="location=\'index_article.php?id='.$o_temp->getArticleId(0).'\'">
                        	<img alt="" src="images/nes_icon.png" />
	                        '.$o_temp->getTitle(0).'
	                    </div>
						');
					}else{
						echo('
						<div class="newest_div">
                        	<img alt="" src="images/nes_icon.png" />
	                        &nbsp;
	                    </div>
						');
					}		
                ?>
                	
                    
                    <div class="news_list_content">
                        <div class="news_img_box">
                        <?php 
                        $o_temp2=new Home_NewsFocus();
                        $o_temp2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
						$o_temp2->PushOrder ( array ('Number', 'A' ) );
						$n_count=$o_temp2->getAllCount();
						for($i=0;$i<$n_count;$i++)
						{
							if ($i>3)
							{
								break;
							}
							echo('
							<div class="news_img_div" onclick="location=\'index_article.php?id='.$o_temp2->getArticleId($i).'\'">
                                <img alt="" src="'.$o_temp2->getPhoto($i).'" />
                                <h2>'.$o_temp2->getTitle($i).'</h2>
                            </div>
							');
						}
                        ?>
                        </div>
                        <div class="news_list_div">
                            <ul>
                            <?php 
                            for($i=1;$i<$o_temp->getCount ();$i++)
							{
								echo('
								<li>
		                            <div class="dot"></div>
		                            <h2 onclick="location=\'index_article.php?id='.$o_temp->getArticleId($i).'\'">'.$o_temp->getTitle($i).'</h2>
		                            <h3>'.$o_temp->getDate($i).'</h3>
		                       </li>
								');
							}
                            ?>                             
                            </ul>
                            <div class="more_btn" onclick="location='index_article_list.php?id=2'">
                                更多
                            </div>
                        </div>
                    </div>
                </div>
                <!--通知公告-->
                <div class="inform_box">
                <?php 
                $o_table=new Home_Column(1);
                $o_date = new DateTime ( 'Asia/Chongqing' );
                $a_week=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
                ?>
                    <h2><?php echo($o_table->getName())?><span><?php echo($o_date->format ( 'Y' ))?>年<?php echo((int)$o_date->format ( 'm' ))?>月<?php echo((int)$o_date->format ( 'd' ))?>日，<?php echo(get_week($o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' )))?></span></h2>
                    <div class="inform_list">
                        <ul>
                        <?php 
	                        $o_temp=new Home_Article();
							$o_temp->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
							$o_temp->PushWhere ( array ('&&', 'Audit', '=', 3) );
							$o_temp->PushWhere ( array ('&&', 'ColumnId', '=', $o_table->getColumnId() ) );
							$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
							$o_temp->PushOrder ( array ('Date', 'D' ) );
							$o_temp->setStartLine ( 0 ); //起始记录
							$o_temp->setCountLine (9);
							$o_temp->getAllCount ();
							$n_count = $o_temp->getCount ();
							for($i=0;$i<$n_count;$i++)
							{
								echo('
								<li onclick="location=\'index_article.php?id='.$o_temp->getArticleId($i).'\'">'.$o_temp->getTitle($i).'</li>
								');
							}
                        ?>                       
                        </ul>
                    </div>
                </div>
            </div>
            <div class="index_mid">
            	<?php
            	$o_table=new Home_Column(4);//督学工作
            	?>
                <div class="category_list_box category_left">
                    <div class="category_list_title">
                        <img alt="" src="images/list_point_icon.png" />
                        <h2><?php echo($o_table->getName())?></h2>
                        <div class="more_btn" onclick="location='index_article_list.php?id=<?php echo($o_table->getColumnId())?>'">更多</div>
                    </div>
                    <ul>
                    	<?php 
	                        $o_temp=new Home_Article();
							$o_temp->PushWhere ( array ('||', 'Delete', '=', 0 ) );
							$o_temp->PushWhere ( array ('&&', 'Audit', '=', 3) );
							$o_temp->PushWhere ( array ('&&', 'ColumnId', '=', $o_table->getColumnId() ) );
							$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
							$o_column=new Home_Column();
							$o_column->PushWhere ( array ('||', 'Parent', '=', $o_table->getColumnId() ) );
							for($i=0;$i<$o_column->getAllCount();$i++)
							{
								$o_temp->PushWhere ( array ('||', 'Delete', '=', 0 ) );
								$o_temp->PushWhere ( array ('&&', 'Audit', '=', 3) );
								$o_temp->PushWhere ( array ('&&', 'ColumnId', '=', $o_column->getColumnId($i) ) );
								$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
							}
							$o_temp->PushOrder ( array ('Date', 'D' ) );
							$o_temp->getAllCount();
							for($i=0;$i<7;$i++)
							{
								if ($i>=$o_temp->getAllCount())
								{
									break;
								}
								echo('
								<li onclick="location=\'index_article.php?id='.$o_temp->getArticleId($i).'\'">
		                            <div class="dot"></div>
		                            <h2>'.$o_temp->getTitle($i).'</h2>
		                        </li>
								');
							}
                        ?>                       
                    </ul>
                    <?php 
                    //读取督学工作下的所有文章，然后显示最新的有图片的文章
                    for($i=0;$i<$o_temp->getAllCount();$i++)
                    {
                    	$s_content=$o_temp->getContent($i);
                    	$a_img=explode('<img', $s_content);
                    	if (count($a_img)>1)
                    	{
                    		$a_img=explode('src="', $a_img[1]);
                    		$a_img=explode('"', $a_img[1]);
                    		if (count(explode('.gif', $a_img[0]))<=1)
                    		{
                    			//如果是小图标，那么跳过
                    			echo('
	                    		<div class="category_img" onclick="location=\'index_article.php?id='.$o_temp->getArticleId($i).'\'">
			                        <img alt="" src="'.$a_img[0].'" />
			                        <h2>'.$o_temp->getTitle($i).'</h2>
			                    </div>
	                    		');
	                    		break;
                    		}               		
                    	}
                    }
                    ?>
                </div>
                <?php
            	$o_table=new Home_Column(5);//督政工作
            	?>
                <div class="category_list_box category_right">
                    <div class="category_list_title">
                        <img alt="" src="images/list_point_icon.png" />
                        <h2><?php echo($o_table->getName())?></h2>
                        <div class="more_btn" onclick="location='index_article_list.php?id=<?php echo($o_table->getColumnId())?>'">更多</div>
                    </div>
                    <ul>
                        <?php 
	                        $o_temp=new Home_Article();
							$o_temp->PushWhere ( array ('||', 'Delete', '=', 0 ) );
							$o_temp->PushWhere ( array ('&&', 'Audit', '=', 3) );
							$o_temp->PushWhere ( array ('&&', 'ColumnId', '=', $o_table->getColumnId() ) );
							$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
							$o_column=new Home_Column();
							$o_column->PushWhere ( array ('||', 'Parent', '=', $o_table->getColumnId() ) );
							for($i=0;$i<$o_column->getAllCount();$i++)
							{
								$o_temp->PushWhere ( array ('||', 'Delete', '=', 0 ) );
								$o_temp->PushWhere ( array ('&&', 'Audit', '=', 3) );
								$o_temp->PushWhere ( array ('&&', 'ColumnId', '=', $o_column->getColumnId($i) ) );
								$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
							}
							$o_temp->PushOrder ( array ('Date', 'D' ) );
							$o_temp->getAllCount();
							for($i=0;$i<7;$i++)
							{
								if ($i>=$o_temp->getAllCount())
								{
									break;
								}
								echo('
								<li onclick="location=\'index_article.php?id='.$o_temp->getArticleId($i).'\'">
		                            <div class="dot"></div>
		                            <h2>'.$o_temp->getTitle($i).'</h2>
		                        </li>
								');
							}
                        ?>
                    </ul>
                    <?php 
                    //读取督学工作下的所有文章，然后显示最新的有图片的文章
                    for($i=0;$i<$o_temp->getAllCount();$i++)
                    {
                    	$s_content=$o_temp->getContent($i);
                    	$a_img=explode('<img', $s_content);
                    	if (count($a_img)>1)
                    	{
                    		$a_img=explode('src="', $a_img[1]);
                    		$a_img=explode('"', $a_img[1]);
                    		if (count(explode('.gif', $a_img[0]))<=1)
                    		{
                    			//如果是小图标，那么跳过
                    			echo('
	                    		<div class="category_img" onclick="location=\'index_article.php?id='.$o_temp->getArticleId($i).'\'">
			                        <img alt="" src="'.$a_img[0].'" />
			                        <h2>'.$o_temp->getTitle($i).'</h2>
			                    </div>
	                    		');
	                    		break;
                    		}               		
                    	}
                    }
                    ?>
                </div>
                <div class="open_government">
                    <img class="government_title" alt="" src="images/government_img.jpg" />
                    <div class="government_btn_box">
                        <div class="government_btn" onclick="location='<?php echo(currentPath())?>../../sub/survey/'">督导问卷调查</div>
                        <div class="government_btn" style="border:0px;">&nbsp;</div>
                        <div class="government_btn" style="border:0px;">&nbsp;</div>
                        <div class="government_btn" style="border:0px;">&nbsp;</div>
                    </div>
                    <div class="qr_code_box">
                        <img alt="" src="images/QR_code.jpg" />
                        <div class="qr_code_text">
                            <h2>微信公众号</h2>
                            <h3>扫一扫</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="index_bottom">
            	<?php
            		$o_table=new Home_Column(6);//专项督导
            	?>
                <div class="category_list_box category_left">
                    <div class="category_list_title">
                        <img alt="" src="images/list_point_icon.png" />
                        <h2><?php echo($o_table->getName())?></h2>
                        <div class="more_btn" onclick="location='index_article_list.php?id=<?php echo($o_table->getColumnId())?>'">更多</div>
                    </div>
                    <ul>
                        <?php 
	                        $o_temp=new Home_Article();
							$o_temp->PushWhere ( array ('||', 'Delete', '=', 0 ) );
							$o_temp->PushWhere ( array ('&&', 'Audit', '=', 3) );
							$o_temp->PushWhere ( array ('&&', 'ColumnId', '=', $o_table->getColumnId() ) );
							$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
							$o_column=new Home_Column();
							$o_column->PushWhere ( array ('||', 'Parent', '=', $o_table->getColumnId() ) );
							for($i=0;$i<$o_column->getAllCount();$i++)
							{
								$o_temp->PushWhere ( array ('||', 'Delete', '=', 0 ) );
								$o_temp->PushWhere ( array ('&&', 'Audit', '=', 3) );
								$o_temp->PushWhere ( array ('&&', 'ColumnId', '=', $o_column->getColumnId($i) ) );
								$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
							}
							$o_temp->PushOrder ( array ('Date', 'D' ) );
							$o_temp->getAllCount();
							for($i=0;$i<7;$i++)
							{
								if ($i>=$o_temp->getAllCount())
								{
									break;
								}
								echo('
								<li onclick="location=\'index_article.php?id='.$o_temp->getArticleId($i).'\'">
		                            <div class="dot"></div>
		                            <h2>'.$o_temp->getTitle($i).'</h2>
		                        </li>
								');
							}
                        ?>
                    </ul>
                </div>
                <?php
            		$o_table=new Home_Column(7);//科研工作
            	?>
                <div class="category_list_box category_right">
                    <div class="category_list_title">
                        <img alt="" src="images/list_point_icon.png" />
                        <h2><?php echo($o_table->getName())?></h2>
                        <div class="more_btn" onclick="location='index_article_list.php?id=<?php echo($o_table->getColumnId())?>'">更多</div>
                    </div>
                    <ul>
                        <?php 
	                        $o_temp=new Home_Article();
							$o_temp->PushWhere ( array ('||', 'Delete', '=', 0 ) );
							$o_temp->PushWhere ( array ('&&', 'Audit', '=', 3) );
							$o_temp->PushWhere ( array ('&&', 'ColumnId', '=', $o_table->getColumnId() ) );
							$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
							$o_column=new Home_Column();
							$o_column->PushWhere ( array ('||', 'Parent', '=', $o_table->getColumnId() ) );
							for($i=0;$i<$o_column->getAllCount();$i++)
							{
								$o_temp->PushWhere ( array ('||', 'Delete', '=', 0 ) );
								$o_temp->PushWhere ( array ('&&', 'Audit', '=', 3) );
								$o_temp->PushWhere ( array ('&&', 'ColumnId', '=', $o_column->getColumnId($i) ) );
								$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
							}
							$o_temp->PushOrder ( array ('Date', 'D' ) );
							$o_temp->getAllCount();
							for($i=0;$i<7;$i++)
							{
								if ($i>=$o_temp->getAllCount())
								{
									break;
								}
								echo('
								<li onclick="location=\'index_article.php?id='.$o_temp->getArticleId($i).'\'">
		                            <div class="dot"></div>
		                            <h2>'.$o_temp->getTitle($i).'</h2>
		                        </li>
								');
							}
                        ?>
                    </ul>
                </div>
                <?php
            		$o_table=new Home_Column(9);//学习交流
            	?>                
                <div class="category_list_box communication_box">
                	<div class="category_list_title">
                    <h2 style="width:auto;border:0px;margin-left:0px;">学习交流</h2>
                    <div class="more_btn" onclick="location='index_article_list.php?id=<?php echo($o_table->getColumnId())?>'">更多</div>
                    </div>
                    <?php 
	                    $o_temp=new Home_Article();
						$o_temp->PushWhere ( array ('||', 'Delete', '=', 0 ) );
						$o_temp->PushWhere ( array ('&&', 'Audit', '=', 3) );
						$o_temp->PushWhere ( array ('&&', 'ColumnId', '=', $o_table->getColumnId() ) );
						$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
						$o_column=new Home_Column();
						$o_column->PushWhere ( array ('||', 'Parent', '=', $o_table->getColumnId() ) );
						for($i=0;$i<$o_column->getAllCount();$i++)
						{
							$o_temp->PushWhere ( array ('||', 'Delete', '=', 0 ) );
							$o_temp->PushWhere ( array ('&&', 'Audit', '=', 3) );
							$o_temp->PushWhere ( array ('&&', 'ColumnId', '=', $o_column->getColumnId($i) ) );
							$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
						}
						$o_temp->PushOrder ( array ('Date', 'D' ) );
						$o_temp->getAllCount();
						//读取督学工作下的所有文章，然后显示最新的有图片的文章
	                    for($i=0;$i<$o_temp->getAllCount();$i++)
	                    {
	                    	$s_content=$o_temp->getContent($i);
	                    	$a_img=explode('<img', $s_content);
	                    	if (count($a_img)>1)
	                    	{
	                    		$a_img=explode('src="', $a_img[1]);
	                    		$a_img=explode('"', $a_img[1]);
	                    		if (count(explode('.gif', $a_img[0]))<=1)
	                    		{
	                    			//如果是小图标，那么跳过
	                    			echo('
		                    		<div class="communication_img" onclick="location=\'index_article.php?id='.$o_temp->getArticleId($i).'\'">
				                        <img alt="" src="'.$a_img[0].'" />
				                        <h3>'.$o_temp->getTitle($i).'</h3>
				                    </div>
		                    		');
		                    		break;
	                    		}               		
	                    	}
	                    }
                    ?>   
                </div>
            </div>
        </div>
<?php 
function currentPath()
{
    return str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']);
}
require_once 'index_footer.php';
?>