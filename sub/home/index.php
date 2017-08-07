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
                    <div class="newest_div">
                        <img alt="" src="images/nes_icon.png" />
                        2017年西城区教育系统党风廉政建设工作会议召开
                    </div>
                    <div class="news_list_content">
                        <div class="news_img_box">
                            <div class="news_img_div">
                                <img alt="" src="images/news_img_1.jpg" />
                                <h2>区教委召开视频安全培训会</h2>
                            </div>
                            <div class="news_img_div">
                                <img alt="" src="images/news_img_1.jpg" />
                                <h2>区教委召开视频安全培训会2</h2>
                            </div>
                            <div class="news_img_div">
                                <img alt="" src="images/news_img_1.jpg" />
                                <h2>区教委召开视频安全培训会3</h2>
                            </div>
                        </div>
                        <div class="news_list_div">
                            <ul>
                                <li>
                                    <div class="dot"></div>
                                    <h2>2017年西城区教育系统党风廉政建设工作会议展开</h2>
                                    <h3>2017-05-11</h3>
                                </li>
                                <li>
                                    <div class="dot"></div>
                                    <h2>司马红副区长做客“政民互动直播间”解读义务教育入学</h2>
                                    <h3>2017-05-11</h3>
                                </li>
                                <li>
                                    <div class="dot"></div>
                                    <h2>学习总数据讲话 做合格共青团员 西城区教育系统举办XX会议</h2>
                                    <h3>2017-05-04</h3>
                                </li>
                                <li>
                                    <div class="dot"></div>
                                    <h2>北京市委常委、教工委书记林克庆到西城区调研教育工作</h2>
                                    <h3>2017-05-03</h3>
                                </li>
                                <li>
                                    <div class="dot"></div>
                                    <h2>西城区教委召开北京十五中教育集团和北京三十五中教育集团</h2>
                                    <h3>2017-05-02</h3>
                                </li>
                                <li>
                                    <div class="dot"></div>
                                    <h2>区教委召开食品安全培训会</h2>
                                    <h3>2017-04-28</h3>
                                </li>
                                <li>
                                    <div class="dot"></div>
                                    <h2>2017年西城区中小学生田径运动会圆满结束</h2>
                                    <h3>2017-04-26</h3>
                                </li>
                            </ul>
                            <div class="more_btn">
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
                <div class="category_list_box category_left">
                    <div class="category_list_title">
                        <img alt="" src="images/list_point_icon.png" />
                        <h2>督学工作</h2>
                        <div class="more_btn">更多</div>
                    </div>
                    <ul>
                        <li>
                            <div class="dot"></div>
                            <h2>2017年西城区教育系统党风廉政见着工作会议召开</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>司马红副区长做客“政民互动直播间”解读义务教育入学</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>学习总数据讲话 做合格共青团员 西城区教育系统举办XX会议</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>北京市委常委、教工委书记林克庆到西城区调研教育工作</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>西城区教委召开北京十五中教育集团和北京三十五中教育集团</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>区教委召开食品安全培训会</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>2017年西城区中小学生田径运动会圆满结束</h2>
                        </li>
                    </ul>
                    <div class="category_img">
                        <img alt="" src="images/img_1.jpg" />
                        <h2>2017年西城区教育系统党风廉政建设工作会议召开</h2>
                    </div>
                </div>
                <div class="category_list_box category_right">
                    <div class="category_list_title">
                        <img alt="" src="images/list_point_icon.png" />
                        <h2>督政工作</h2>
                        <div class="more_btn">更多</div>
                    </div>
                    <ul>
                        <li>
                            <div class="dot"></div>
                            <h2>2017年西城区教育系统党风廉政见着工作会议召开</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>司马红副区长做客“政民互动直播间”解读义务教育入学</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>学习总数据讲话 做合格共青团员 西城区教育系统举办XX会议</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>北京市委常委、教工委书记林克庆到西城区调研教育工作</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>西城区教委召开北京十五中教育集团和北京三十五中教育集团</h2>
                        </li>
                    </ul>
                    <div class="category_img">
                        <img alt="" src="images/img_2.jpg" />
                        <h2>2017年西城区教育系统党风廉政建设工作会议召开</h2>
                    </div>
                </div>
                <div class="open_government">
                    <img class="government_title" alt="" src="images/government_img.jpg" />
                    <div class="government_btn_box">
                        <div class="government_btn" onclick="location='index_article_list.php?id=<?php 
                        	$o_table=new Home_Column(12);//组织机构
                        	echo($o_table->getColumnId());
                        ?>'"><?php echo($o_table->getName())?></div>
                        <div class="government_btn" onclick="location='index_article_list.php?id=<?php 
                        	$o_table=new Home_Column(13);//政策法规
                        	echo($o_table->getColumnId());
                        ?>'"><?php echo($o_table->getName())?></div>
                        <div class="government_btn" onclick="location='index_article_list.php?id=<?php 
                        	$o_table=new Home_Column(14);//督导文件
                        	echo($o_table->getColumnId());
                        ?>'"><?php echo($o_table->getName())?></div>
                        <div class="government_btn" onclick="location='index_article_list.php?id=<?php 
                        	$o_table=new Home_Column(15);//督评报告
                        	echo($o_table->getColumnId());
                        ?>'"><?php echo($o_table->getName())?></div>
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
                <div class="category_list_box category_left">
                    <div class="category_list_title">
                        <img alt="" src="images/list_point_icon.png" />
                        <h2>专项督导</h2>
                        <div class="more_btn">更多</div>
                    </div>
                    <ul>
                        <li>
                            <div class="dot"></div>
                            <h2>2017年西城区教育系统党风廉政见着工作会议召开</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>司马红副区长做客“政民互动直播间”解读义务教育入学</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>学习总数据讲话 做合格共青团员 西城区教育系统举办XX会议</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>北京市委常委、教工委书记林克庆到西城区调研教育工作</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>西城区教委召开北京十五中教育集团和北京三十五中教育集团</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>区教委召开食品安全培训会</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>2017年西城区中小学生田径运动会圆满结束</h2>
                        </li>
                    </ul>
                </div>
                <div class="category_list_box category_right">
                    <div class="category_list_title">
                        <img alt="" src="images/list_point_icon.png" />
                        <h2>科研工作</h2>
                        <div class="more_btn">更多</div>
                    </div>
                    <ul>
                        <li>
                            <div class="dot"></div>
                            <h2>2017年西城区教育系统党风廉政见着工作会议召开</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>司马红副区长做客“政民互动直播间”解读义务教育入学</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>学习总数据讲话 做合格共青团员 西城区教育系统举办XX会议</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>北京市委常委、教工委书记林克庆到西城区调研教育工作</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>西城区教委召开北京十五中教育集团和北京三十五中教育集团</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>区教委召开食品安全培训会</h2>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <h2>2017年西城区中小学生田径运动会圆满结束</h2>
                        </li>
                    </ul>
                </div>
                <div class="communication_box">
                    <h2>学习交流</h2>
                    <div class="communication_img">
                        <img alt="" src="images/img_3.jpg" />
                        <h3>2017年西城区教育系统交流会</h3>
                    </div>
                </div>
            </div>
        </div>
<?php 
require_once 'index_footer.php';
?>