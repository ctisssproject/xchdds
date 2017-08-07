<?php
define ( 'RELATIVITY_PATH', '../../' );
require_once 'index_header.php';
if (is_numeric ( $_GET ['page'] )) {
	$n_page = $_GET ['page'];
} else {
	$n_page = 1;
}
if (is_numeric ( $_GET ['id'] )) {
	$n_columnid = $_GET ['id'];
	if ($n_columnid > 0) {
		$n_columnid = $_GET ['id'];
	} else {
		echo ('<script>location=\'index.php\'</script>');
		exit ( 0 );
	}
} else {
	echo ('<script>location=\'index.php\'</script>');
	exit ( 0 );
}
$n_pagesize=20;
$o_column=new Home_Column($n_columnid);
//判断是否只有一篇文章,直接跳转到文章页
$o_temp=new Home_Article();
$o_temp->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
$o_temp->PushWhere ( array ('&&', 'Audit', '=', 3) );
$o_temp->PushWhere ( array ('&&', 'ColumnId', '=', $n_columnid) );
$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
if($o_temp->getAllCount()==1)
{
	echo ('<script>location=\'index_article.php?id='.$o_temp->getArticleId(0).'\'</script>');
	exit ( 0 );
}
?>
        <div class="page_body">
            <div class="location_box">
                <h2 onclick="location='index.php'">首页</h2><h3>&gt;</h3><h2 onclick="location='index_article_list.php?id=<?php echo($o_column->getColumnId())?>'"><?php echo($o_column->getName())?></h2>
            </div>
            <div class="list_page">
                <div class="list_title"><?php echo($o_column->getName())?></div>
                <div class="list_page_content">
                    <div class="list_box">
                    <?php 
                    $o_article = new View_Home_Article ();
					$o_article->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
					$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
					$o_article->PushWhere ( array ('&&', 'Audit', '=', 3 ) );
					$o_article->PushWhere ( array ('&&', 'ColumnId', '=', $n_columnid ) );
					$o_article->PushOrder ( array ('Date', 'D' ) );
					$o_article->setStartLine ( ($n_page - 1) * $n_pagesize ); //起始记录
					$o_article->setCountLine ( $n_pagesize );
					$n_count = $o_article->getAllCount ();
					if (($n_pagesize * ($n_page - 1)) >= $n_count) {
						$n_page = ceil ( $n_count / $n_pagesize );
						$n_yu = $n_count % $n_pagesize;
						$o_article->setStartLine ( ($n_page - 1) * $n_pagesize);
						$o_article->setCountLine ( $n_pagesize );
					}
					$n_allcount = $o_article->getAllCount ();
					$n_count = $o_article->getCount ();
					$s_article = '';
					for($i = 0; $i < $n_count; $i ++) {
						$s_article .= '						
							<li>
                                <div class="dot"></div>
                                <h2 onclick="location=\'index_article.php?id='.$o_article->getArticleId($i).'\'">'.$o_article->getTitle($i).'</h2>
                                <h3>'.$o_article->getDate($i).'</h3>
                            </li>
						';						
						if (($i+1)%5==0 || ($i+1)>=$n_count)
						{
							echo('
							<ul>
								'.$s_article.'
							</ul>
							');
							$s_article = '';
						}
					}
                    ?>
                    </div>
                    <div class="pageno_box">
						<?php 
						echo(get_page_button_for_column('index_article_list.php?id=' . $n_columnid . '&',$n_allcount,$n_pagesize,$n_page));
						?>
                    </div>
                </div>
            </div>
        </div>
<?php 
require_once 'index_footer.php';
?>