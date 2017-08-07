<?php
?>
					<div class="article_bottom_box">
                        <img class="l_t_img" alt="" src="images/nes_icon.png" />
                        <ul>
                        <?php 
                        //获取最新的文章
                        $o_temp=new Home_Article();
						$o_temp->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
						$o_temp->PushWhere ( array ('&&', 'Audit', '=', 3) );
						$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
						$o_temp->PushOrder ( array ('Date', 'D' ) );
						$o_temp->setStartLine ( 0 ); //起始记录
						$o_temp->setCountLine (5);
						$o_temp->getAllCount ();
						$n_count = $o_temp->getCount ();
						for($i=0;$i<$n_count;$i++)
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
                        <div class="qr_code_box">
                            <img alt="" src="images/QR_code.jpg" />
                            <div class="qr_code_text">
                                <h2>微信公众号</h2>
                                <h3>扫一扫</h3>
                            </div>
                        </div>
                    </div>