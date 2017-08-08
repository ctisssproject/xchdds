<?php
define ( 'RELATIVITY_PATH', '../../' );
require_once 'index_header.php';
if (is_numeric ( $_GET ['id'] )) {
	$n_articleid = $_GET ['id'];
} else {
	echo ('<script>location=\'index.php\'</script>');
	exit ( 0 );
}
$o_article = new View_Home_Article ( $n_articleid );
$n_columnid = $o_article->getColumnId ();
if (! ($o_article->getColumnId () > 0) || $o_article->getColumnState () == 0 || $o_article->getState () == 0 || $o_article->getDelete () == 1) {
	echo ('<script>location=\'index.php\'</script>');
	exit ( 0 );
}
$o_visit = new Home_Article ( $n_articleid );
if ($o_article->getAudit () == 3) {
	//只有审核过的文章才可以记录访问量
	$o_visit->setVisit ( $o_visit->getVisit () + 1 );
	$o_visit->Save ();
}
$o_column=new Home_Column($n_columnid);
?>
        <div class="page_body">
            <div class="location_box">
                <h2 onclick="location='index.php'">首页</h2>
                <?php 
                	//显示栏目路径
                	if($o_column->getParent()>0)
                	{
                		$o_parent_column=new Home_Column($o_column->getParent());
                		if ($o_parent_column->getParent()>0)
                		{
                			$o_parent_parent_column=new Home_Column($o_parent_column->getParent());
                			echo('<h3>&gt;</h3>');
                			echo('<h2 onclick="location=\'index_article_list.php?id='.$o_parent_parent_column->getColumnId().'\'">'.$o_parent_parent_column->getName().'</h2>');
                		}
                		echo('<h3>&gt;</h3>');
                		echo('<h2 onclick="location=\'index_article_list.php?id='.$o_parent_column->getColumnId().'\'">'.$o_parent_column->getName().'</h2>');
                	}
                ?>
                <h3>&gt;</h3>
                <h2 onclick="location='index_article_list.php?id=<?php echo($o_column->getColumnId())?>'"><?php echo($o_column->getName())?></h2>
            </div>
            <div class="article_page">
                <div class="article_title">
                    <h1><?php echo($o_article->getTitle())?></h1>
                    <p><?php echo($o_article->getDate())?>&nbsp;&nbsp;&nbsp;&nbsp;浏览：<?php echo($o_article->getVisit())?>次</p>
                </div>
                <div class="article_content">
                    <p>
                       <?php echo($o_article->getContent())?>
                    </p>
                    <?php require_once 'index_article_footer.php';?>
                </div>
            </div>
        </div>
<?php 
require_once 'index_footer.php';
?>