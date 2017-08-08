<?php
define ( 'RELATIVITY_PATH', '../../' );
require_once 'index_header.php';
if (is_numeric ( $_GET ['page'] )) {
	$n_page = $_GET ['page'];
} else {
	$n_page = 1;
}
if($_GET['key']=='')
{
	echo ('<script>location=\'index.php\'</script>');
	exit ( 0 );
}
$n_pagesize=20;
$o_article = new View_Home_Article ();
$o_article->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
$o_article->PushWhere ( array ('&&', 'Audit', '=', 3 ) );
$o_article->PushWhere ( array ('&&', 'Title', 'Like', '%'.$_GET['key'].'%' ) );
if($_GET['date']!='')
{
	$o_article->PushWhere ( array ('&&', 'Date', '>=', $_GET['date'] ) );
}
$o_article->PushWhere ( array ('||', 'Delete', '=', 0 ) );
$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
$o_article->PushWhere ( array ('&&', 'Audit', '=', 3 ) );
$o_article->PushWhere ( array ('&&', 'Content', 'Like', '%'.$_GET['key'].'%' ) );
if($_GET['date']!='')
{
	$o_article->PushWhere ( array ('&&', 'Date', '>=', $_GET['date'] ) );
}
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
        <div class="page_body">
            <div class="search_body">
                <div class="results_list">
                    <div class="results_title">
                        <h2>搜索关键词<span>“<?php echo($_GET['key'])?>”</span></h2>
                        <h3>找到 <?php echo($n_allcount)?> 条结果</h3>
                    </div>
                    <div class="results_content">
                        <ul>
                        <?php 
                        for($i = 0; $i < $n_count; $i ++) {
                        	//先查找文章内是否有图片，如果有图片，那么使用图片的模板
	                        $s_content=$o_article->getContent($i);
	                    	$a_img=explode('<img', $s_content);
	                    	if (count($a_img)>1)
	                    	{
	                    		$a_img=explode('src="', $a_img[1]);
	                    		$a_img=explode('"', $a_img[1]);
	                    		if (count(explode('.gif', $a_img[0]))<=1)
	                    		{
	                    			//如果是小图标，那么跳过
	                    			echo('
		                   			<li>
		                                <h2 onclick="window.open(\'index_article.php?id='.$o_article->getArticleId($i).'\',\'_blank\')">'.str_replace($_GET['key'], '<span style="font-weight:bold">'.$_GET['key'].'</span>',$o_article->getTitle($i)).'</h2>
		                                <div class="img_div">
		                                	<img alt="" src="'.$a_img[0].'" />
		                                    <p onclick="window.open(\'index_article.php?id='.$o_article->getArticleId($i).'\',\'_blank\')">'.get_highline_content($s_content,$_GET['key'],210).'</p>
		                                    <h3>发布时间：'.$o_article->getDate($i).'</h3>
		                                </div>
		                            </li>
		                   			');
	                    		}else{
	                    			echo('
		                   			<li>
		                                <h2 onclick="window.open(\'index_article.php?id='.$o_article->getArticleId($i).'\',\'_blank\')">'.str_replace($_GET['key'], '<span style="font-weight:bold">'.$_GET['key'].'</span>',$o_article->getTitle($i)).'</h2>
		                                <div class="no_img_div">
		                                    <p onclick="window.open(\'index_article.php?id='.$o_article->getArticleId($i).'\',\'_blank\')">'.get_highline_content($s_content,$_GET['key'],210).'</p>
		                                    <h3>发布时间：'.$o_article->getDate($i).'</h3>
		                                </div>
		                            </li>
		                   			');
	                    		}             		
	                    	}else{
	                   			echo('
	                   			<li>
	                                <h2 onclick="window.open(\'index_article.php?id='.$o_article->getArticleId($i).'\',\'_blank\')">'.str_replace($_GET['key'], '<span style="font-weight:bold">'.$_GET['key'].'</span>',$o_article->getTitle($i)).'</h2>
	                                <div class="no_img_div">
	                                    <p onclick="window.open(\'index_article.php?id='.$o_article->getArticleId($i).'\',\'_blank\')">'.get_highline_content($s_content,$_GET['key'],210).'</p>
	                                    <h3>发布时间：'.$o_article->getDate($i).'</h3>
	                                </div>
	                            </li>
	                   			');
	                    	}
                        }
                        ?>                        
                        </ul>
                    </div>
                </div>
                <div class="time_box">
                    <h2>时间</h2>
                    <ul>
                    	<?php
                    	//构建日期按钮
                    	$o_date = new DateTime ( 'Asia/Chongqing' );
                    	$s_date=$o_date->format ( 'Y' ).'-'.$o_date->format ( 'm' ).'-'.$o_date->format ( 'd' );
                    	$s_week=date('Y-m-d',strtotime('-7 day',strtotime($s_date)));
                    	$s_month=date('Y-m-d',strtotime('-30 day',strtotime($s_date)));
                    	$s_year=date('Y-m-d',strtotime('-365 day',strtotime($s_date)));
                    	$s_active='';
                    	if($_GET['date']=='')
                    	{
                    		$s_active='active';
                    	}
                    	?>
                        <li class="<?php echo($s_active)?>" onclick="location='index_search.php?key=<?php echo($_GET['key'])?>'">&gt; 全部</li>
                        <?php 
                        $s_active='';
                        if($_GET['date']==$s_week)
                    	{
                    		$s_active='active';
                    	}
                        ?>
                        <li class="<?php echo($s_active)?>" onclick="location='index_search.php?key=<?php echo($_GET['key'])?>&date=<?php echo($s_week)?>'">&gt; 一周内</li>
                        <?php 
                        $s_active='';
                        if($_GET['date']==$s_month)
                    	{
                    		$s_active='active';
                    	}
                        ?>
                        <li class="<?php echo($s_active)?>" onclick="location='index_search.php?key=<?php echo($_GET['key'])?>&date=<?php echo($s_month)?>'">&gt; 一月内</li>
                        <?php 
                        $s_active='';
                        if($_GET['date']==$s_year)
                    	{
                    		$s_active='active';
                    	}
                        ?>
                        <li class="<?php echo($s_active)?>" onclick="location='index_search.php?key=<?php echo($_GET['key'])?>&date=<?php echo($s_year)?>'">&gt; 一年内</li>
                    </ul>
                </div>
            </div>
            <div class="pageno_box">
                <?php 
					echo(get_page_button_for_column('index_search.php?key=' . $_GET['key'] . '&date='.$_GET['date'].'&',$n_allcount,$n_pagesize,$n_page));
				?>
            </div>
        </div>
<?php 
require_once 'index_footer.php';
?>