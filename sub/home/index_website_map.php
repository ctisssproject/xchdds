<?php
define ( 'RELATIVITY_PATH', '../../' );
require_once 'index_header.php';
?>
        <div class="page_body">
            <div class="location_box">
                <h2 onclick="location='index.php'">首页</h2>
                <h3>&gt;</h3>
                <h2 onclick="location='index_website_map.php'">站点地图</h2>
            </div>
            <div class="article_page">
                <div class="article_title">
                    <h1>站点地图</h1>
                </div>
                <div class="article_content">
                    <p style="line-height:30px;">
                       <a href="index.php"><b>首页</b></a><br/>
                       <?php 
                       $o_column=new Home_Column();
                       $o_column->PushWhere ( array ('&&', 'Parent', '=', 0 ) );
                       $o_column->PushOrder ( array ('Number', 'A' ) );
                       for($i=0;$i<$o_column->getAllCount();$i++)
                       {
                       	   echo('&nbsp;&nbsp;&nbsp;&nbsp;——<a href="index_article_list.php?id='.$o_column->getColumnId($i).'"><b>'.$o_column->getName($i).'</b></a><br/>');
                       	   $o_sub_column=new Home_Column();
	                       $o_sub_column->PushWhere ( array ('&&', 'Parent', '=', $o_column->getColumnId($i) ) );
	                       $o_sub_column->PushOrder ( array ('Number', 'A' ) );
	                       for($j=0;$j<$o_sub_column->getAllCount();$j++)
	                       {
	                       		echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;——<a href="index_article_list.php?id='.$o_sub_column->getColumnId($j).'">'.$o_sub_column->getName($j).'</a><br/>');
	                       	   $o_sub_sub_column=new Home_Column();
		                       $o_sub_sub_column->PushWhere ( array ('&&', 'Parent', '=', $o_sub_column->getColumnId($j) ) );
		                       $o_sub_sub_column->PushOrder ( array ('Number', 'A' ) );
		                       for($k=0;$k<$o_sub_sub_column->getAllCount();$k++)
		                       {
		                       		echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;——<a href="index_article_list.php?id='.$o_sub_sub_column->getColumnId($k).'">'.$o_sub_sub_column->getName($k).'</a><br/>');
		                       }
	                       }
                       }
                       ?>
                    </p>
                    <?php require_once 'index_article_footer.php';?>
                </div>
            </div>
        </div>
<?php 
require_once 'index_footer.php';
?>