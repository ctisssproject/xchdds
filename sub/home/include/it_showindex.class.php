<?php
require_once 'include/db_table.class.php';
require_once 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'include/it_basic.class.php';
class ShowIndex extends It_Basic {
	private $N_Column;
	private $O_Session;
	public function __construct() {
		
		$this->N_PageSize = 16;
		require_once RELATIVITY_PATH . 'include/bn_session.class.php';
		$this->O_Session = new Session ();
	}
	public function getComment($o_article) {
		$s_html = '';
		if ($o_article->getIsComment () == 1 && $this->O_Session->Login () == true) {
			$s_html = '	
			<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=CommentAdd"
	enctype="multipart/form-data" target="ajax_submit_frame">
			<table class="article" border="0" cellpadding="0" cellspacing="0"
			align="center">
			<tr>
								<td class="comment"><input type="hidden" name="Vcl_ArticleId" value="' . $o_article->getArticleId () . '"> <textarea id="Vcl_Content" name="Vcl_Content" cols="20" rows="8"></textarea><br/><input type="button" value="发表" onclick="submitComment()"/></td>
			</tr>
		</table>
		</from>';
		}
		$s_comment = '';
		if ($o_article->getIsComment () == 1) {
			//显示评论
			$o_comment = new View_Home_Comment ();
			$o_comment->PushWhere ( array ('&&', 'ArticleId', '=', $o_article->getArticleId () ) );
			$o_comment->PushOrder ( array ('Time', 'D' ) );
			$n_count = $o_comment->getAllCount ();
			if ($n_count > 0) {
				for($i = 0; $i < $n_count; $i ++) {
					$s_username = '';
					if ($this->O_Session->Login () == true) {
						$s_username = $o_comment->getName ( $i );
					} else {
						$s_username = substr ( $o_comment->getName ( $i ), 0, 3 ) . '**';
					}
					$s_button='';
					if ($this->O_Session->Login () == true)
					{
					$o_user=$this->O_Session->getUserObject();
					if($o_comment->getUid($i)==$this->O_Session->getUid()||$o_user->ValidModule ( 65 ))
					{
						$s_button='<a href="javascript:;" title="删除这条评论" onclick="commentDelete('.$o_comment->getCommentId ($i).')">删除</a>';
					}
					}
					$s_comment .= '<tr>
								<td class="comment_list">
								<div class="username">' . $s_username . '</div>
								<div class="date">' . $o_comment->getTime ( $i ) . ' '.$s_button.'</div>
								<div class="text">' . $o_comment->getContent ( $i ) . '</div>
								
								
								</td>
			</tr>';
				}
				$s_comment = '
			<table class="article" border="0" cellpadding="0" cellspacing="0"
			align="center">
			' . $s_comment . '
			</table>
			';
			}
		}
		if ($s_html . $s_comment != '') {
			return $s_html . $s_comment . '
			<table class="article" border="0" cellpadding="0" cellspacing="0"
			align="center">
				<tr>
					<td class="comment" style="padding:5px;">&nbsp;</td>
				</tr>
			</table>
			';
		}
	
	}
	public function getTop($n_columnid = 0) {
		$o_float = new View_Home_Float ();
		$o_float->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_float->getAllCount ();
		$s_float = '';
		for($i = 0; $i < $n_count; $i ++) {
			$s_float .= '<div class="item"><a href="index_article.php?articleid=' . $o_float->getArticleId ( $i ) . '">' . $o_float->getTitle ( $i ) . '</a></div>';
		}
		if ($n_count > 0) {
			$s_float = '
					<div class="float_box">
                		<div class="button" onclick="stopFloat()"></div>
                		<div class="list">
                			' . $s_float . '
                		</div>
                	</div>
			';
		}
		$s_html = '
        <tr class="top">
            <td>
                &nbsp;' . $s_float . '
            </td>
            <td style="width: 986px;">
                <div class="logo">
                </div>
                <div class="left">
                </div>
                <div class="right">
                	<div class="button" title="点击后加入收藏夹" onclick="AddFavorite(window.location,document.title)">
                    </div>
                    <div class="button" title="点击后设为首页" onclick="SetHome(this,window.location)">
                    </div>                    
                </div>
            </td>
            <td>
                &nbsp;
            </td>
        </tr>
		';
		$o_column = new Home_Column ( $n_columnid );
		if ($o_column->getParent () > 0) {
			//二级栏目
			$n_columnid = $o_column->getParent ();
		}
		$o_column = new Home_Column ();
		$o_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_column->PushWhere ( array ('&&', 'Parent', '=', 0 ) );
		$o_column->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_column->PushWhere ( array ('&&', 'ColumnId', '<>', 1 ) );
		$o_column->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_column->getAllCount ();
		$s_nav = '';
		if ($n_columnid == 0) {
			$s_nav .= '<div style="float:left;width:64px"><ul class="on" style="width:64px" onclick="location=\'index.php\'">首&nbsp;&nbsp;&nbsp;&nbsp;页</ul></div>';
		} else {
			$s_nav .= '<div style="float:left;width:64px"><ul class="button" style="width:64px" onclick="location=\'index.php\'">首&nbsp;&nbsp;&nbsp;&nbsp;页</ul></div>';
		}
		for($i = 0; $i < $n_count; $i ++) {
			$s_nav2 = '';
			$o_column2 = new Home_Column ();
			$o_column2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_column2->PushWhere ( array ('&&', 'Parent', '=', $o_column->getColumnId ( $i ) ) );
			$o_column2->PushWhere ( array ('&&', 'State', '=', 1 ) );
			$o_column2->PushOrder ( array ('Number', 'A' ) );
			$n_count2 = $o_column2->getAllCount ();
			for($j = 0; $j < $n_count2; $j ++) {
				$s_nav2 .= '<li onclick="location=\'index_column.php?columnid=' . $o_column2->getColumnId ( $j ) . '\'">' . $o_column2->getName ( $j ) . '</li>';
			}
			if ($n_count2 > 0) {
				$s_nav2 = '<ul class="menu" id="menu' . $i . '">' . $s_nav2 . '</ul>';
			}
			if ($n_columnid == $o_column->getColumnId ( $i )) {
				if ($o_column->getUrl ( $i ) == '') {
					$s_nav .= '<div style="float:left;width:76px"><ul class="on" onmouseover="$(\'#menu' . $i . '\').show()" onmouseout="$(\'#menu' . $i . '\').hide()"><li onclick="location=\'index_column.php?columnid=' . $o_column->getColumnId ( $i ) . '\'">' . $o_column->getName ( $i ) . '</li><li>' . $s_nav2 . '</li></ul></div>';
				} else {
					$s_nav .= '<div style="float:left;width:76px"><div class="on" onclick="location=\'' . $o_column->getUrl ( $i ) . '\'">' . $o_column->getName ( $i ) . '</div></div>';
				}
			} else {
				if ($o_column->getUrl ( $i ) == '') {
					$s_nav .= '<div style="float:left;width:76px"><ul class="button" onmouseover="$(\'#menu' . $i . '\').show()" onmouseout="$(\'#menu' . $i . '\').hide()"><li onclick="location=\'index_column.php?columnid=' . $o_column->getColumnId ( $i ) . '\'">' . $o_column->getName ( $i ) . '</li><li>' . $s_nav2 . '</li></ul></ul></div>';
				} else {
					$s_nav .= '<div class="button" onclick="location=\'' . $o_column->getUrl ( $i ) . '\'">' . $o_column->getName ( $i ) . '</div>';
				}
			}
			
		}
		if ($n_columnid == 10000) {
				$s_nav.='<div style="float:left;width:76px"><div class="on" onclick="location=\'index_book.php\'">图书馆</div></div>';
			}else{
				$s_nav.='<div style="float:left;width:76px"><div class="button" onclick="location=\'index_book.php\'">图书馆</div></div>';
			}
		$s_html .= '
				<tr class="nav">
		            <td>
		            </td>
		            <td>
		                <div class="left">
		                </div>
		                ' . $s_nav .'
		            </td>
		            <td>
		            </td>
		        </tr>
		';
		return $s_html;
	}
	public function getLogin() {
		
		if ($this->O_Session->Login () == true) //如果没有注册，跳转到首页
{
			$o_user = $this->O_Session->getUserObject ();
			$s_html = '
					<div class="login">
                        <div class="title1">
                            系统登录</div>
                        <div class="vcl">
                            欢迎用户 ' . $o_user->getUserName () . '</div>
                        <div class="vcl n2">
                           姓名：' . $o_user->getName () . '</div>
                        <div class="button">
                            <input type="button" value="注销" onclick="location=\'' . RELATIVITY_PATH . 'index.php?loginout=true\' "/><input style="width:80px;" type="button" value="进入后台" onclick="location=\'' . RELATIVITY_PATH . 'main.php\' "/></div>
                        <div class="title2">
                            联系我们</div>
                        <div class="contact">
                            地 址：西城区新安中里二巷10号（南樱桃园）<br />
                            电 话： 010-63584763<br />
                            联系人：刘主任<br />
                            电 话： 010-63550657<br />
                            联系人：张校长<br />
                            网 址： www.xwfyfz.com
                        </div>
                    </div>
		';
			return $s_html;
		}
		$s_html = '
					<div class="login">
					<form method="post" id="dialog_form"
	action="../../include/bn_submit.svr.php?function=Login"
	enctype="multipart/form-data" target="ajax_submit_frame">
                        <div class="title1">
                            系统登录</div>
                        <div class="vcl">
                            用户名：<input id="Vcl_UserName" name="Vcl_UserName" type="text" /></div>
                        <div class="vcl n2">
                            密&nbsp;&nbsp;码：<input id="Vcl_Password" name="Vcl_Password" type="password" /></div>
                        <div class="button">
                            <input type="submit" value="登录" /></div>
                        <div class="title2">
                            联系我们</div>
                        <div class="contact">
                            地 址：西城区新安中里二巷10号（南樱桃园）<br />
                            电 话： 010-63584763<br />
                            联系人：刘主任<br />
                            电 话： 010-63550657<br />
                            联系人：张校长<br />
                            网 址： www.xwfyfz.com
                        </div>
                        </form>
                    </div>
		';
		return $s_html;
	}
	public function getNews() {
		$o_article = new View_Home_Article ();
		$o_article->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		//$o_article->PushWhere ( array ('&&', 'Home', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'Audit', '=', 3 ) );
		$o_article->PushWhere ( array ('&&', 'ColumnId', '=', 1 ) );
		$o_article->PushWhere ( array ('||', 'Delete', '=', 0 ) );
		//$o_article->PushWhere ( array ('&&', 'Home', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'Audit', '=', 3 ) );
		$o_article->PushWhere ( array ('&&', 'Parent', '=', 1 ) );
		$o_article->PushOrder ( array ('Date', 'D' ) );
		$o_article->setStartLine ( 0 ); //起始记录
		$o_article->setCountLine ( 6 );
		$o_article->getAllCount ();
		$n_count = $o_article->getCount ();
		$s_article = '';
		for($i = 0; $i < $n_count; $i ++) {
			$s_title = $o_article->getTitle ( $i );
			if (strlen ( $s_title ) > 22) {
				$s_title = $this->CutStr ( $s_title, 44 );
			}
			$s_date = $o_article->getDate ( $i );
			$s_date = substr ( $s_date, 0, strlen ( $s_date ) - 8 );
			$s_date = substr ( $s_date, 5, strlen ( $s_date ) );
			$s_article .= '<div class="item">
                                <div class="text">
                                    <a title="' . $o_article->getTitle ( $i ) . '" href="index_article.php?articleid=' . $o_article->getArticleId ( $i ) . '">' . $s_title . '</a>
                                </div>
                                <div class="date">
                                    [ ' . $s_date . ' ]
                                </div>
                            </div>							                 
			';
		}
		$o_colume = new Home_Column ( 1 );
		$s_html = '
					<div class="news">
                        <div class="title">
                           ' . $o_colume->getName () . '</div>
                        <div class="button" title="查看更多内容" onclick="location=\'index_column.php?columnid=1\'">
                        </div>
                        <div class="list">
                            ' . $s_article . '
                        </div>
                    </div>
		';
		return $s_html;
	}
	public function getFoucs() {
		$o_focus = new Home_NewsFocus ();
		$o_focus->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_focus->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_focus->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_focus->getAllCount ();
		$s_photo = '';
		$s_title = '';
		$s_content = '';
		for($i = 0; $i < $n_count; $i ++) {
			$s_photo .= '<a href="index_article.php?articleid=' . $o_focus->getArticleId ( $i ) . '"><img src="' . $o_focus->getPhoto ( $i ) . '" alt="' . $o_focus->getTitle ( $i ) . '" width="305" height="206" /></a>';
		}
		if ($n_count == 0) {
			$s_photo .= '<a href="javascript:;"><img src="images/home/center_focus_waiting.jpg" alt="等待更新中" width="305" height="206" /></a>';
		}
		$s_html = '
					<div class="foucs">
                        <div id="KinSlideshow" style="visibility: hidden; border: 1px solid #940000;">
                            ' . $s_photo . '
                        </div>
                    </div>
		';
		return $s_html;
	}
	public function getLanmu() {
		for($j = 1; $j <= 8; $j ++) {
			$o_column = new View_Home_Indexcolumn ( $j );
			$o_article = new View_Home_Article ();
			$o_article->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
			$o_article->PushWhere ( array ('&&', 'Audit', '=', 3 ) );
			$o_article->PushWhere ( array ('&&', 'ColumnId', '=', $o_column->getColumnId () ) );
			$o_article->PushWhere ( array ('||', 'Delete', '=', 0 ) );
			$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
			$o_article->PushWhere ( array ('&&', 'Audit', '=', 3 ) );
			$o_article->PushWhere ( array ('&&', 'Parent', '=', $o_column->getColumnId () ) );
			$o_article->PushOrder ( array ('Date', 'D' ) );
			$o_article->setStartLine ( 0 ); //起始记录
			$o_article->setCountLine ( 7 );
			$o_article->getAllCount ();
			$n_count = $o_article->getCount ();
			$s_article = '';
			for($i = 0; $i < $n_count; $i ++) {
				$s_title = $o_article->getTitle ( $i );
				if ($o_article->getParent ( $i ) > 0) {
					$s_title = '[' . $o_article->getName ( $i ) . '] ' . $s_title;
				}
				if (strlen ( $s_title ) > 18) {
					$s_title = $this->CutStr ( $s_title, 28 );
				}
				$s_title = str_replace ( "[", "<strong>[", $s_title );
				$s_title = str_replace ( "]", "]</strong>", $s_title );
				$s_article .= '
							<div class="item">
                                <div class="text">
                                    <a title="' . $o_article->getTitle ( $i ) . '" href="index_article.php?articleid=' . $o_article->getArticleId ( $i ) . '">' . $s_title . '</a>
                                </div>
                            </div>
			';
			}
			if ($j == 4 || $j == 8) {
				$s_style = ' style="margin-right: 0px;"';
			} else {
				$s_style = '';
			}
			$s_html .= '
					<div class="lanmu number' . $j . '"' . $s_style . '>
                        <div class="title">
                            ' . $o_column->getName () . '</div>
                        <div class="button" title="查看更多内容" onclick="location=\'index_column.php?columnid=' . $o_column->getColumnId () . '\'">
                        </div>
                        <div class="list">
                            ' . $s_article . '
                        </div>
                    </div>
			';
		}
		return $s_html;
	}
	private function getScroll() {
		$o_article = new Home_Article ();
		$o_article->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_article->PushWhere ( array ('&&', 'Scroll', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_article->PushOrder ( array ('Date', 'D' ) );
		$n_count = $o_article->getAllCount ();
		$s_scroll = '';
		for($i = 0; $i < $n_count; $i ++) {
			$s_scroll .= '<span onclick="window.open(\'index_article.php?articleid=' . $o_article->getArticleId ( $i ) . '\',\'_blank\')">' . $o_article->getTitle ( $i ) . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		return $s_scroll;
	}
	public function getNav1($n_module_id) {
		$o_column = new Home_Column ( $n_module_id );
		if ($o_column->getParent () > 0) {
			//二级栏目
			$n_module_id = $o_column->getParent ();
		}
		$o_column = new Home_Column ();
		$o_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_column->PushWhere ( array ('&&', 'Parent', '=', 0 ) );
		$o_column->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_column->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_column->getAllCount ();
		$s_nav = '';
		if ($n_module_id == 0) {
			$s_nav .= '<td class="on"><a href="index.php">首&nbsp;&nbsp;页</a></td>';
		} else {
			$s_nav .= '<td class="off"><a href="index.php">首&nbsp;&nbsp;页</a></td>';
		}
		for($i = 0; $i < $n_count; $i ++) {
			$s_nav .= '<td class="fen"></td>';
			if ($n_module_id == $o_column->getColumnId ( $i )) {
				if ($o_column->getUrl ( $i ) == '') {
					$s_nav .= '<td class="on"><a href="index_column.php?columnid=' . $o_column->getColumnId ( $i ) . '">' . $o_column->getName ( $i ) . '</a></td>';
				} else {
					$s_nav .= '<td class="on"><a href="' . $o_column->getUrl ( $i ) . '" target="_blank">' . $o_column->getName ( $i ) . '</a></td>';
				}
			} else {
				if ($o_column->getUrl ( $i ) == '') {
					$s_nav .= '<td class="off"><div><div>123456</div></div><a href="index_column.php?columnid=' . $o_column->getColumnId ( $i ) . '">' . $o_column->getName ( $i ) . '1</a></td>';
				} else {
					$s_nav .= '<td class="off"><a href="' . $o_column->getUrl ( $i ) . '" target="_blank">' . $o_column->getName ( $i ) . '</a></td>';
				}
			}
		}
		$s_html = '
		
			    <table class="nav1" border="0" cellpadding="0" cellspacing="0" align="center">
			        <tr>
			            <td style="vertical-align: top">
			                <table border="0" cellpadding="0" cellspacing="0" style="height: 32px;">
			                    <tr>
			                        <td style="width: 80px">
			                        </td>
			                        ' . $s_nav . '
			                        <td>
			                            &nbsp;
			                        </td>
			                    </tr>
			                </table>
			                <table border="0" cellpadding="0" cellspacing="0" style="margin-top: 10px">
			                    <tr>
			                        <td style="font-size: 14px; vertical-align: top; color: #666666; font-weight: bold;
			                            padding-left: 10px; width: 66px">
			                            最新动态
			                        </td>
			                        <td style="width: 20px; vertical-align: middle">
			                            <img src="images/state_jiao.jpg" alt="" align="absmiddle" />
			                        </td>
			                        <td class="scrolling">
			                            <div>
			                                <marquee dir=\'rtl\' direction=\'left\' scrollamount="3" onmouseover="this.stop();" onmouseout="this.start();">' . $this->getScroll () . '</marquee>
			                            </div>
			                        </td>
			                        <td style="width: 30px">
			                        </td>
			                        <td style="width: 285px">
			                            <input id="Vcl_Search" type="text" maxlength="50"/>
			                        </td>
			                        <td>
			                            <a href="javascript:goToSearch(\'Vcl_Search\');">
			                                <img src="images/search_button.jpg" alt="" align="absmiddle" /></a>
			                        </td>
			                    </tr>
			                </table>
			            </td>
			        </tr>
			    </table>
		';
		return $s_html;
	
	}
	public function getColumnNav($n_columnid) {
		$o_column = new Home_Column ( $n_columnid );
		$o_column2 = new Home_Column ();
		$b_nav = false;
		if ($o_column->getName () == '') //没找到
{
			echo ('<script>location=\'index.php\'</script>');
			exit ( 0 );
		}
		if ($o_column->getParent () == 0) {
			//一级栏目
			$b_nav = true;
			$o_column2->PushWhere ( array ('&&', 'Parent', '=', $o_column->getColumnId () ) );
		} else {
			//二级栏目
			$o_column2->PushWhere ( array ('&&', 'Parent', '=', $o_column->getParent () ) );
			$this->N_Column = $n_columnid;
		}
		$o_column2->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_column2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_column2->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_column2->getAllCount ();
		if ($n_count == 0) {
			//显示通知公告
			$this->N_Column = $n_columnid;
			return '';
		} else {
			//显示导航菜单
			$s_button .= '';
			$s_class = '';
			for($i = 0; $i < $n_count; $i ++) {
				$s_class = '';
				if ($b_nav && $i == 0) {
					$o_article = new Home_Article ();
					$o_article->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
					$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
					$o_article->PushWhere ( array ('&&', 'ColumnId', '=', $n_columnid ) );
					$n_articlecount = $o_article->getAllCount ();
					if ($n_articlecount > 0) {
						$this->N_Column = $n_columnid;
					} else {
						$this->N_Column = $o_column2->getColumnId ( $i );
						$s_class = 'on';
					}
				} else if ($o_column2->getColumnId ( $i ) == $n_columnid) {
					$s_class = 'on';
				}
				$s_button .= '<div class="' . $s_class . '" onclick="location=\'index_column.php?columnid=' . $o_column2->getColumnId ( $i ) . '\'">&nbsp;' . $o_column2->getName ( $i ) . '</div>';
			}
			$s_html = '
			<div class="nav2">' . $s_button . '</div>
		';
			return $s_html;
		}
	}
	public function getArticleLeft() {
		$s_html = '
                <table border="0" cellpadding="0" cellspacing="0" class="loginmail_column">
                    <tr>
                        <td style="padding-top: 5px; padding-left: 10px; width: 110px">
                            <a href="../../login.php" target="_blank">
                                <img src="images/login_button_column.png" alt="" align="absmiddle" /></a>
                        </td>
                        <td>
                            <a href="javascript:;">
                                <img src="images/mail_button_column.png" alt="" align="absmiddle" /></a>
                        </td>
                    </tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" class="tzgg tzgg_column">
                    <tr>
                        <td class="header">
                        </td>
                    </tr>
                    <tr>
                        <td class="header2">
                            <div>
                                <img src="images/tongzhi_icon.jpg" alt="" align="absmiddle" />&nbsp;&nbsp;通知</div>
                            <a href="index_notice_list.php?type=0" target="_blank">更多&gt;&gt;</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="list">
                            <table border="0" cellpadding="0" cellspacing="0">
                                ' . $this->getNotice ( 0 ) . '
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="header2">
                            <div>
                                <img src="images/gonggao_icon.jpg" alt="" align="absmiddle" />&nbsp;&nbsp;公告</div>
                            <a href="index_notice_list.php?type=1" target="_blank">更多&gt;&gt;</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="list">
                            <table border="0" cellpadding="0" cellspacing="0">
                                 ' . $this->getNotice ( 1 ) . '
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="footer">
                            &nbsp;
                        </td>
                    </tr>
                </table>
            
		';
		return $s_html;
	}
	public function getNewsFocus() {
		$o_focus = new Home_NewsFocus ();
		$o_focus->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_focus->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_focus->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_focus->getAllCount ();
		$s_photo = '';
		$s_title = '';
		$s_content = '';
		for($i = 0; $i < $n_count; $i ++) {
			$s_photo .= '<a href="index_article.php?articleid=' . $o_focus->getArticleId ( $i ) . '" target="_blank"><img src="' . $o_focus->getPhoto ( $i ) . '" alt="' . $o_focus->getTitle ( $i ) . '" width="523" height="330" /></a>';
			if ($i == 0) {
				$s_title .= '<div id="photo_title_' . ($i + 1) . '" style="display:block"><a href="index_article.php?articleid=' . $o_focus->getArticleId ( $i ) . '" target="_blank">' . $o_focus->getTitle ( $i ) . '</a></div>';
				$s_content .= '<div id="photo_content_' . ($i + 1) . '" style="display:block"><a href="index_article.php?articleid=' . $o_focus->getArticleId ( $i ) . '" target="_blank">' . $o_focus->getContent ( $i ) . '</a></div>';
			} else {
				$s_title .= '<div id="photo_title_' . ($i + 1) . '"><a href="index_article.php?articleid=' . $o_focus->getArticleId ( $i ) . '" target="_blank">' . $o_focus->getTitle ( $i ) . '</a></div>';
				$s_content .= '<div id="photo_content_' . ($i + 1) . '"><a href="index_article.php?articleid=' . $o_focus->getArticleId ( $i ) . '" target="_blank">' . $o_focus->getContent ( $i ) . '</a></div>';
			}
		}
		$s_html = '
				  <table class="newsborder" border="0" cellpadding="0" cellspacing="0" align="center">
				        <tr>
				            <td style="width: 558px; vertical-align: top">
				                <div id="KinSlideshow" style="visibility: hidden;border: 1px solid #005CC3; margin-top:13px; margin-left:13px">
				                    ' . $s_photo . '
				                </div>
				            </td>
				            <td class="fen">
				            </td>
				            <td style="vertical-align: top; padding-left: 20px">
				            <script>
				            N_Photo_Sum=' . $n_count . '
				            </script>
				                <table border="0" cellpadding="0" cellspacing="0" style="width: 395px">
				                    <tr>
				                        <td class="new_title">
				                            ' . $s_title . '
				                        </td>
				                    </tr>
				                    <tr>
				                        <td class="content">
				                            ' . $s_content . '
				                        </td>
				                    </tr>
				                    ' . $this->getNewsCenter () . '
				                </table>
				            </td>
				        </tr>
				    </table>
		';
		return $s_html;
	}
	protected function getPageButtomForColumn($n_all_count, $n_page_size = 30, $n_page = 1) {
		if (fmod ( $n_all_count, $n_page_size ) == 0) {
			$n_page_count = floor ( $n_all_count / $n_page_size );
		} else {
			$n_page_count = floor ( $n_all_count / $n_page_size ) + 1;
		}
		if ($n_page_count <= 1) {
			return '';
		}
		$s_pagebutton .= ' 共 ' . $n_all_count . ' 篇&nbsp;&nbsp;&nbsp;&nbsp;第 ' . $n_page . ' / ' . $n_page_count . ' </span>页&nbsp;&nbsp;';
		if ($n_page > 1) {
			$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $this->S_FileName . 'page=1" title="首页">首页</a>';
		} else {
			//$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;首页';
		}
		if ($n_page > 1) {
			$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $this->S_FileName . 'page=' . ($n_page - 1) . '" title="上一页">上一页</a>';
		} else {
			//$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;上一页';
		}
		if ($n_page < $n_page_count) {
			$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $this->S_FileName . 'page=' . ($n_page + 1) . '" title="下一页">下一页</a>';
		} else {
			//$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;下一页';
		}
		if ($n_page < $n_page_count) {
			$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $this->S_FileName . 'page=' . ($n_page_count) . '" title="尾页">尾页</a>';
		} else {
			//$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;尾页';
		}
		return $s_pagebutton;
	}
	protected function getPageButtomForBook($n_all_count, $n_page_size = 30, $n_page = 1) {
		if (fmod ( $n_all_count, $n_page_size ) == 0) {
			$n_page_count = floor ( $n_all_count / $n_page_size );
		} else {
			$n_page_count = floor ( $n_all_count / $n_page_size ) + 1;
		}
		if ($n_page_count <= 1) {
			return '';
		}
		$s_pagebutton .= ' 共 ' . $n_all_count . ' 种图书&nbsp;&nbsp;&nbsp;&nbsp;第 ' . $n_page . ' / ' . $n_page_count . ' </span>页&nbsp;&nbsp;';
		if ($n_page > 1) {
			$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $this->S_FileName . 'page=1" title="首页">首页</a>';
		} else {
			$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;首页';
		}
		if ($n_page > 1) {
			$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $this->S_FileName . 'page=' . ($n_page - 1) . '" title="上一页">上一页</a>';
		} else {
			$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;上一页';
		}
		if ($n_page < $n_page_count) {
			$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $this->S_FileName . 'page=' . ($n_page + 1) . '" title="下一页">下一页</a>';
		} else {
			$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;下一页';
		}
		if ($n_page < $n_page_count) {
			$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $this->S_FileName . 'page=' . ($n_page_count) . '" title="尾页">尾页</a>';
		} else {
			$s_pagebutton .= '&nbsp;&nbsp;&nbsp;&nbsp;尾页';
		}
		return $s_pagebutton;
	}
	public function getNoticeList($n_page) {
		$this->S_FileName = 'index_notice_list.php?type=' . $_GET ['type'] . '&';
		$this->N_Page = $n_page;
		require_once RELATIVITY_PATH . 'sub/notices/include/db_table.class.php';
		$o_notice = new Notices_Notice ();
		$o_notice->PushWhere ( array ('&&', 'Open', '=', 1 ) );
		$o_notice->PushWhere ( array ('&&', 'Home', '=', 1 ) );
		$o_notice->PushWhere ( array ('&&', 'IsNotice', '=', $_GET ['type'] ) );
		$o_notice->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_notice->PushOrder ( array ('Date', 'D' ) );
		$o_notice->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_notice->setCountLine ( $this->N_PageSize );
		$n_count = $o_notice->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$n_yu = $n_count % $this->N_PageSize;
			$o_notice->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_notice->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_notice->getAllCount ();
		$n_count = $o_notice->getCount ();
		$s_pagebutton = $this->getPageButtomForColumn ( $n_allcount, $this->N_PageSize, $this->N_Page );
		$s_article = '';
		for($i = 0; $i < $n_count; $i ++) {
			$s_title = $o_notice->getTitle ( $i );
			if (strlen ( $s_title ) > 33) {
				$s_title = $this->CutStr ( $s_title, 66 );
			}
			$s_date = $o_notice->getDate ( $i );
			$s_date = substr ( $s_date, 0, strlen ( $s_date ) - 8 );
			$s_date = substr ( $s_date, 5, strlen ( $s_date ) );
			$s_article .= '
							                   <tr>
				                                    <td class="article_td1">
				                                        <img src="images/point.jpg" alt="" align="absmiddle" />
				                                    </td>
				                                    <td class="article_td2">
				                                        <a href="index_notice.php?noticeid=' . $o_notice->getNoticeId ( $i ) . '" target="_blank">' . $s_title . '</a>
				                                    </td>
				                                    <td class="article_td3">
				                                        [ ' . $s_date . ' ]
				                                    </td>
				                                </tr>
			';
		}
		if ($n_count == 0) {
			$s_article .= '
							                   <tr>
				                                    <td class="article_td1">
				                                       &nbsp;
				                                    </td>
				                                    <td class="article_td2">
				                                        没有文章
				                                    </td>
				                                    <td class="article_td3">
				                                        &nbsp;
				                                    </td>
				                                </tr>
			';
		}
		if ($_GET ['type'] == 1) {
			$s_name = '公告';
		} else {
			$s_name = '通知';
		}
		$s_html = '                   
				<table class="article" border="0" cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td class="title_td1">
                            <img src="images/column_title_icon.jpg" alt="" align="absmiddle" />
                        </td>
                        <td class="title_td2">
                              ' . $s_name . '
                        </td>
                        <td class="title_td3">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 10px">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                     ' . $s_article . '

                </table>
                <table class="article" border="0" cellpadding="0" cellspacing="0" align="center">
                     <tr>
                        <td class="page">
                            ' . $s_pagebutton . '
                        </td>
                    </tr>
                </table>
	';
		return $s_html;
	}
	public function getArticleList($n_page,$n_columnid) {
		$this->N_Column=$n_columnid;
		$this->S_FileName = 'index_column.php?columnid=' . $this->N_Column . '&';
		$this->N_Page = $n_page;
		$o_article = new View_Home_Article ();
		$o_article->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'Audit', '=', 3 ) );
		$o_article->PushWhere ( array ('&&', 'ColumnId', '=', $this->N_Column ) );
		$o_article->PushOrder ( array ('Date', 'D' ) );
		$o_article->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_article->setCountLine ( $this->N_PageSize );
		$n_count = $o_article->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$n_yu = $n_count % $this->N_PageSize;
			$o_article->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_article->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_article->getAllCount ();
		if ($n_allcount == 1) {
			echo ('<script type="text/javascript">location=\'index_article.php?articleid=' . $o_article->getArticleId ( 0 ) . '\'</script>');
		}
		$n_count = $o_article->getCount ();
		$s_pagebutton = $this->getPageButtomForColumn ( $n_allcount, $this->N_PageSize, $this->N_Page );
		$s_article = '';
		for($i = 0; $i < $n_count; $i ++) {
			$s_article .= '
			 												<tr>
                                                                <td class="title_td_css">
                                                                  <span style="width:12px; background:url(images/yuandian_hui.jpg) center no-repeat;display:-moz-inline-box;display:inline-block"></span>
                                                                </td>
                                                                <td class="title_td_css">
                                                                  <a target="_blank" class="xbx_custom_11561_css_1" title="'.$o_article->getTitle($i).'" href="index_article.php?articleid='.$o_article->getArticleId($i).'">'.$o_article->getTitle($i).'</a></td>
                                                                <td class="title_td_css" align="right">
                                                                  <font class="title_date_align_css">['.$o_article->getDate($i).']</font></td>
                                                              </tr>
			';
		}
		$s_html = '                   
				                                 <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                                    <tbody>
                                                      <tr>
                                                        <td class="title_td_css" align="left">
                                                          <table id="xx" width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tbody>                                                             
                                                             '.$s_article.'
                                                            </tbody>
                                                          </table>                                                          
                                                        </td>
                                                      </tr>
                                                      <tr>
                                                        <td align="center">
                                                          <table width="95%" id="columncontent" align="center">
                                                            <tbody>
                                                              <tr>
                                                                <td align="center" valign="bottom" class="title_more_css">
                                                                  <br>'.$s_pagebutton.'
                                                       			 </td>
	                                                        </tr>
	                                                        </tbody>
	                                                        </table>
				                                         </td>
				                                        </tr>
				                                       </tbody>
				                                      </table>
	';
		return $s_html;
	}
	public function getMessagesList($n_page) {
		$this->S_FileName = 'index_messages.php?columnid=' . $this->N_Column . '&';
		$this->N_Page = $n_page;
		$o_article = new Home_Messages ();
		$o_article->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'Audit', '=', 3 ) );
		$o_article->PushOrder ( array ('Date', 'D' ) );
		$o_article->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_article->setCountLine ( $this->N_PageSize );
		$n_count = $o_article->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$n_yu = $n_count % $this->N_PageSize;
			$o_article->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_article->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_article->getAllCount ();
		$n_count = $o_article->getCount ();
		$s_pagebutton = $this->getPageButtomForColumn ( $n_allcount, $this->N_PageSize, $this->N_Page );
		$s_article = '';
		for($i = 0; $i < $n_count; $i ++) {
			$s_title = $o_article->getTitle ( $i );
			if (strlen ( $s_title ) > 33) {
				$s_title = $this->CutStr ( $s_title, 66 );
			}
			$s_date = $o_article->getDate ( $i );
			$s_date = substr ( $s_date, 0, strlen ( $s_date ) - 8 );
			$s_date = substr ( $s_date, 5, strlen ( $s_date ) );
			$s_article .= '
							                   <tr>
				                                    <td class="article_td1">
				                                        <img src="images/point.jpg" alt="" align="absmiddle" />
				                                    </td>
				                                    <td class="article_td2">
				                                        <a href="index_messages_show.php?articleid=' . $o_article->getArticleId ( $i ) . '">' . $s_title . '</a>
				                                    </td>
				                                    <td class="article_td3">
				                                        [ ' . $s_date . ' ]
				                                    </td>
				                                </tr>
			';
		}
		if ($n_count == 0) {
			$s_article .= '
							                   <tr>
				                                    <td class="article_td1">
				                                       &nbsp;
				                                    </td>
				                                    <td class="article_td2">
				                                        没有文章
				                                    </td>
				                                    <td class="article_td3">
				                                        &nbsp;
				                                    </td>
				                                </tr>
			';
		}
		$o_colume = new Home_Column ( $this->N_Column );
		$s_html = '                   
				<table class="article" border="0" cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td class="title_td1">
                            <img src="images/home/column_title_icon.jpg" alt="" align="absmiddle" />
                        </td>
                        <td class="title_td2">
                              ' . $o_colume->getName () . '
                        </td>
                        <td class="title_td3">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 10px">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                     ' . $s_article . '

                </table>
                <form method="post" id="dialog_form2" action="include/bn_submit.svr.php?function=MessagesAdd" enctype="multipart/form-data" target="ajax_submit_frame">
					<table class="article" border="0" cellpadding="0" cellspacing="0" align="center">
						<tr>
							<td class="messages" style="border-bottom: 0px dotted #940000;"><input class="input" type="text" id="Vcl_Title" name="Vcl_Title" value=""></td>
						</tr>
						<tr>
							<td class="messages" style="padding-top:0px;"><textarea id="Vcl_Content" name="Vcl_Content" cols="20" rows="8"></textarea><br/><input type="button" value="提交" onclick="submitMessages()"/></td>
						</tr>
				</table>
				</from>           
                <table class="article" border="0" cellpadding="0" cellspacing="0" align="center">
                     <tr>
                        <td class="page">
                            ' . $s_pagebutton . '
                        </td>
                    </tr>
                </table>
	';
		return $s_html;
	}
	public function getSearch($n_page) {
		$this->S_FileName = 'index_column.php?key=' . $_GET ['key'] . '&';
		$this->N_Page = $n_page;
		if (isset ( $_GET ['key'] ) && str_replace ( ' ', '', $_GET ['key'] ) != '') {
			$a_key = explode ( " ", $_GET ['key'] );
		} else {
			//没有任何结果
			return '                   
				<table class="article" border="0" cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td class="title_td1">
                            <img src="images/column_title_icon.jpg" alt="" align="absmiddle" />
                        </td>
                        <td class="title_td2">
                              	搜索结果
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 10px">
                        </td>
                        <td>
                        </td>
                    </tr>
                     <tr>
				       <td class="article_td1">
				          &nbsp;
				      </td>
				      <td class="article_td2">
				          对不起，没有找到您想要的结果，请您换个关键词试试。
				      </td>
				      <td class="article_td3">
				         &nbsp;
				      </td>
				    </tr>
                </table>
		';
		}
		$o_article = new View_Home_Article ();
		//标题
		$o_article->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
		for($i = 0; $i < count ( $a_key ); $i ++) {
			if ($a_key [$i] == '') {
				continue;
			}
			$o_article->PushWhere ( array ('&&', 'Title', 'LIKE', '%' . $a_key [$i] . '%' ) );
		}
		//内容
		$o_article->PushWhere ( array ('||', 'Delete', '=', 0 ) );
		$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
		for($i = 0; $i < count ( $a_key ); $i ++) {
			if ($a_key [$i] == '') {
				continue;
			}
			$o_article->PushWhere ( array ('&&', 'Content', 'LIKE', '%' . $a_key [$i] . '%' ) );
		}
		$o_article->PushOrder ( array ('Date', 'D' ) );
		$o_article->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_article->setCountLine ( $this->N_PageSize );
		$n_count = $o_article->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$n_yu = $n_count % $this->N_PageSize;
			$o_article->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_article->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_article->getAllCount ();
		$n_count = $o_article->getCount ();
		$s_pagebutton = $this->getPageButtomForColumn ( $n_allcount, $this->N_PageSize, $this->N_Page );
		$s_article = '';
		for($i = 0; $i < $n_count; $i ++) {
			$s_title = $o_article->getTitle ( $i );
			$s_title = $this->SearchResultAddRed ( $s_title, $a_key );
			$s_conetnt = $o_article->getContent ( $i );
			$s_conetnt = $this->SearchResultAddRed ( $s_conetnt, $a_key );
			$s_date = $o_article->getDate ( $i );
			$s_date = substr ( $s_date, 0, strlen ( $s_date ) - 8 );
			$s_date = substr ( $s_date, 5, strlen ( $s_date ) );
			$s_article .= '
			 		<tr>
                        <td class="article_td1">
                        &nbsp;
                        </td>
                        <td>
                            <table class="search_result" border="0" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td class="result_td1">
                                        <img src="images/point.jpg" alt="" align="absmiddle" />
                                    </td>
                                    <td class="result_td2">
                                        <a href="index_article.php?articleid=' . $o_article->getArticleId ( $i ) . '" target="_blank">' . $s_title . '</a>
                                    </td>
                                    <td class="result_td3">
                                      
                                    </td>
                                </tr>
                                 <tr>
                                    <td>
                                        
                                    </td>
                                    <td class="date">
                                        栏目：<a href="index_column.php?columnid=' . $o_article->getColumnId ( $i ) . '" target="_blank">[' . $o_article->getName ( $i ) . ']</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;发布日期：' . $s_date . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;发布人：' . $o_article->getUserName ( $i ) . '
                                    </td>
                                    <td>
                                       
                                    </td>
                                </tr>
                                 <tr class="footer">
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td class="result_content">
                                        <a href="index_article.php?articleid=' . $o_article->getArticleId ( $i ) . '" target="_blank">' . $s_conetnt . '</a>
                                    </td>
                                    <td>
                                        &nbsp;
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
			';
		}
		if ($n_count == 0) {
			$s_article .= '
							                   <tr>
				                                    <td class="article_td1">
				                                       &nbsp;
				                                    </td>
				                                    <td class="article_td2">
				                                        没有文章
				                                    </td>
				                                    <td class="article_td3">
				                                        &nbsp;
				                                    </td>
				                                </tr>
			';
		}
		$o_colume = new Home_Column ( $this->N_Column );
		$s_html = '                   
				<table class="article" border="0" cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td class="title_td1">
                            <img src="images/column_title_icon.jpg" alt="" align="absmiddle" />
                        </td>
                        <td class="title_td2">
                              	搜索结果 <span>关键词“<strong>' . $_GET ['key'] . '</strong>”共有<strong> ' . $n_allcount . ' </strong>条搜索结果<span>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 10px">
                        </td>
                        <td>
                        </td>
                    </tr>
                     ' . $s_article . '
                </table>				     
                <table class="article" border="0" cellpadding="0" cellspacing="0" align="center">
                     <tr>
                        <td class="page">
                            ' . $s_pagebutton . '
                        </td>
                    </tr>
                </table>
	';
		return $s_html;
	}
	private function getNewsCenter() {
		$o_article = new View_Home_Article ();
		$o_article->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_article->PushWhere ( array ('&&', 'Home', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'Audit', '=', 3 ) );
		$o_article->PushWhere ( array ('&&', 'ColumnId', '=', 1 ) );
		$o_article->PushWhere ( array ('||', 'Delete', '=', 0 ) );
		$o_article->PushWhere ( array ('&&', 'Home', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'Audit', '=', 3 ) );
		$o_article->PushWhere ( array ('&&', 'Parent', '=', 1 ) );
		$o_article->PushOrder ( array ('Date', 'D' ) );
		$o_article->setStartLine ( 0 ); //起始记录
		$o_article->setCountLine ( 5 );
		$o_article->getAllCount ();
		$n_count = $o_article->getCount ();
		$s_article = '';
		for($i = 0; $i < $n_count; $i ++) {
			$s_title = $o_article->getTitle ( $i );
			if (strlen ( $s_title ) > 22) {
				$s_title = $this->CutStr ( $s_title, 44 );
			}
			$s_date = $o_article->getDate ( $i );
			$s_date = substr ( $s_date, 0, strlen ( $s_date ) - 8 );
			$s_date = substr ( $s_date, 5, strlen ( $s_date ) );
			$s_article .= '
							                   <tr>
				                                    <td class="td1">
				                                        <img src="images/point.jpg" alt="" align="absmiddle" />
				                                    </td>
				                                    <td class="td2">
				                                        <a href="index_article.php?articleid=' . $o_article->getArticleId ( $i ) . '" target="_blank">' . $s_title . '</a>
				                                    </td>
				                                    <td class="td3">
				                                        [ ' . $s_date . ' ]
				                                    </td>
				                                </tr>
			';
		}
		$o_colume = new Home_Column ( 1 );
		$s_html = '
									<tr>
				                        <td class="new_header">
				                            ' . $o_colume->getName () . '
				                        </td>
				                    </tr>
				                    <tr>
				                        <td style="height: 145px; vertical-align: top">
				                            <table class="list" border="0" cellpadding="0" cellspacing="0">
				                               ' . $s_article . '

				                            </table>
				                        </td>
				                    </tr>
				                    <tr>
				                        <td class="more">
				                            <a href="index_column.php?columnid=' . $o_colume->getColumnId () . '" target="_blank">更多&gt;&gt;</a>
				                        </td>
				                    </tr>
	';
		return $s_html;
	}
	public function getTopics() {
		$o_topics = new Home_Topics ();
		$o_topics->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_topics->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_topics->PushOrder ( array ('Number', 'A' ) );
		$s_topics = '';
		$n_count = $o_topics->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			if ($i == 0) {
				$s_topics .= '
						<td>
                            <a href="' . $o_topics->getUrl ( $i ) . '" target="_blank">
                                <img src="' . $o_topics->getPhoto ( $i ) . '" alt="" align="absmiddle" /></a>
                        </td>
				';
			} else {
				$s_topics .= '
						<td class="fen">
                        </td>
                        <td>
                            <a href="' . $o_topics->getUrl ( $i ) . '" target="_blank">
                                <img src="' . $o_topics->getPhoto ( $i ) . '" alt="" align="absmiddle" /></a>
                        </td>
				';
			}
		}
		$s_html = '
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        ' . $s_topics . '
                    </tr>
                </table>		
		';
		return $s_html;
	}
	public function getColumn($n_number) {
		$o_column = new View_Home_Indexcolumn ( $n_number );
		$o_article = new View_Home_Article ();
		$o_article->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_article->PushWhere ( array ('&&', 'Home', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'Audit', '=', 3 ) );
		$o_article->PushWhere ( array ('&&', 'ColumnId', '=', $o_column->getColumnId () ) );
		$o_article->PushWhere ( array ('||', 'Delete', '=', 0 ) );
		$o_article->PushWhere ( array ('&&', 'Home', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_article->PushWhere ( array ('&&', 'Audit', '=', 3 ) );
		$o_article->PushWhere ( array ('&&', 'Parent', '=', $o_column->getColumnId () ) );
		$o_article->PushOrder ( array ('Date', 'D' ) );
		$o_article->setStartLine ( 0 ); //起始记录
		$o_article->setCountLine ( 7 );
		$o_article->getAllCount ();
		$n_count = $o_article->getCount ();
		$s_article = '';
		for($i = 0; $i < $n_count; $i ++) {
			$s_title = $o_article->getTitle ( $i );
			if ($o_article->getParent ( $i ) > 0) {
				$s_title = '[' . $o_article->getName ( $i ) . '] ' . $s_title;
			}
			if (strlen ( $s_title ) > 18) {
				$s_title = $this->CutStr ( $s_title, 36 );
			}
			$s_title = str_replace ( "[", "<strong>[", $s_title );
			$s_title = str_replace ( "]", "]</strong>", $s_title );
			
			$s_date = $o_article->getDate ( $i );
			$s_date = substr ( $s_date, 0, strlen ( $s_date ) - 8 );
			$s_date = substr ( $s_date, 5, strlen ( $s_date ) );
			$s_article .= '
							                   <tr>
				                                    <td class="td1">
				                                        <img src="images/point.jpg" alt="" align="absmiddle" />
				                                    </td>
				                                    <td class="td2">
				                                        <a href="index_article.php?articleid=' . $o_article->getArticleId ( $i ) . '" target="_blank">' . $s_title . '</a>
				                                    </td>
				                                    <td class="td3">
				                                        [ ' . $s_date . ' ]
				                                    </td>
				                                </tr>
			';
		}
		$s_html = '
				<table border="0" cellpadding="0" cellspacing="0" class="lanmu">
					<tr>
						<td class="header">' . $o_column->getName () . '</td>
					</tr>
					<tr>
						<td class="list">
						<table border="0" cellpadding="0" cellspacing="0">
							' . $s_article . '
						</table>
						</td>
					</tr>
					<tr>
						<td class="footer"><a href="index_column.php?columnid=' . $o_column->getColumnId () . '" target="_blank">更多&gt;&gt;</a></td>
					</tr>
				</table>
		';
		return $s_html;
	}
	public function getNotice($s_type) {
		require_once RELATIVITY_PATH . 'sub/notices/include/db_table.class.php';
		$o_notice = new Notices_Notice ();
		$o_notice->PushWhere ( array ('&&', 'Open', '=', 1 ) );
		$o_notice->PushWhere ( array ('&&', 'Home', '=', 1 ) );
		$o_notice->PushWhere ( array ('&&', 'IsNotice', '=', $s_type ) );
		$o_notice->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_notice->PushOrder ( array ('Date', 'D' ) );
		$o_notice->setStartLine ( 0 ); //起始记录
		$o_notice->setCountLine ( 9 );
		$o_notice->getAllCount ();
		$n_count = $o_notice->getCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$s_title = $o_notice->getTitle ( $i );
			if (strlen ( $s_title ) > 14) {
				$s_title = $this->CutStr ( $s_title, 28 );
			}
			$s_html .= '<tr>
						<td class="td1"><img src="images/point.jpg" alt=""
							align="absmiddle" /></td>
						<td class="td2"><a href="index_notice.php?noticeid=' . $o_notice->getNoticeId ( $i ) . '" target="_blank">' . $s_title . '</a></td>
					</tr>';
		}
		return $s_html;
	}
	public function getLink() {
		$o_link = new Home_Link ();
		$o_link->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_link->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_link->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_link->getAllCount ();
		$s_link .= '<tr>';
		for($i = 0; $i < $n_count; $i ++) {
			if ((($i + 1) % 4) == 0) {
				$s_link .= '</tr><tr><td><a href="' . $o_link->getUrl ( $i ) . '" target="_blank">' . $o_link->getName ( $i ) . '</a></td>';
			} else {
				$s_link .= '<td><a href="' . $o_link->getUrl ( $i ) . '" target="_blank">' . $o_link->getName ( $i ) . '</a></td>';
			}
		}
		$s_link .= '</tr>';
		$s_html = '
				<table style="width: 100%" border="0" cellpadding="0" cellspacing="0"
					class="link">
					<tr>
						<td class="content">
						<table style="width: 100%" border="0" cellpadding="0"
							cellspacing="0">
							' . $s_link . '
						</table>
						</td>
					</tr>
				</table>
		';
		return $s_html;
	}
	public function getFooter() {
		$o_focus = new Home_Article_Footer ();
		$o_focus->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_focus->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_focus->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_focus->getAllCount ();
		$s_footer = '';
		for($i = 0; $i < $n_count; $i ++) {
			$s_footer .= '<a href="index_other.php?articleid=' . $o_focus->getArticleId ( $i ) . '">' . $o_focus->getTitle ( $i ) . '</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		if ($n_count > 0) {
			$s_footer = substr ( $s_footer, 0, strlen ( $s_footer ) - 49 );
		}
		//读取图片专区
		$o_photo = new Home_Photo ();
		if ($o_photo->getAllCount () > 0) {
			$s_photo = '
			<div class="title">
                       		 图片专区</div>
                    <div class="photo">
                    <iframe marginwidth="0" border="0" scrolling="no"
					frameborder="0" src="index_photo.php" style="overflow: hidden"></iframe>
                    </div>
			
			';
		}
		$s_html = '
		<tr class="footer">
            <td>
            </td>
            <td>  
                      
                <div class="center">   
                ' . $s_photo . '                 
                    <div class="text">' . $s_footer . '
                    </div>
                    <div class="info">版权所有 Copyright(c)2013-2016 北京教育学院宣武分院附属中学<br/>ICP备案编号：京ICP备13035714号</div>
                </div>
            </td>
            <td>
            </td>
        </tr>
		';
		return $s_html;
	}
	public function getBook($n_page,$s_key) {
		$this->S_FileName = 'index_book.php?key=' . $_GET ['key'] . '&';
		$this->N_Page = $n_page;
		$this->N_PageSize = 51;
		$o_book = new Book_Info ();
		if ($s_key!='')
		{
			$o_book->PushWhere ( array ('&&', 'Isbn', '=', $s_key ) );
			$o_book->PushWhere ( array ('||', 'Title', 'LIKE', '%' . $s_key . '%' ) );
			$o_book->PushWhere ( array ('||', 'Author', 'LIKE', '%' . $s_key . '%' ) );
			$o_book->PushWhere ( array ('||', 'Publisher', 'LIKE', '%' . $s_key . '%' ) );
			$o_book->PushWhere ( array ('||', 'Tag', 'LIKE', '%' . $s_key . '%' ) );
		}else{
			
		}
		$o_book->PushOrder ( array ('Pubdate', 'D' ) ); //按编号降序	
		$o_book->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_book->setCountLine ( $this->N_PageSize );
		$n_count = $o_book->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$n_yu = $n_count % $this->N_PageSize;
			$o_book->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_book->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_book->getAllCount ();
		$n_count = $o_book->getCount ();
		$s_pagebutton = $this->getPageButtomForBook ( $n_allcount, $this->N_PageSize, $this->N_Page );
		//搜索框
		for($i = 0; $i < $n_count; $i ++) { //按条数循环显示
			$s_html.='<div class="book_info">
						<a class="img" href="index_book_info.php?id='.$o_book->getInfoId($i).'" target="_blank"><img src="../../'.$o_book->getImg($i).'" align="absmiddle"></a>
						<div class="info">
							<div class="title" title="'.$o_book->getTitle($i).'" onclick="window.open(\'index_book_info.php?id='.$o_book->getInfoId($i).'\',\'_blank\')">'.$this->CutStr($o_book->getTitle($i), 16).'</div>
							<div class="text">
							ISBN：<span class="red">'.$o_book->getIsbn($i).'</span><br/>
							作者：'.$this->CutStr($o_book->getAuthor($i), 14).'</span><br/>
							定价：<span class="red">￥'.$o_book->getPrice($i).' 元</span><br/>							
							</div>
						</div>
						</div>';
		}
		$s_html='
		'.
		$s_html
		.'
		<table class="article" border="0" cellpadding="0" cellspacing="0" align="center">
                     <tr>
                        <td class="page">
                            ' . $s_pagebutton . '
                        </td>
                    </tr>
                </table>';
		return $s_html;
	}
	
}
?>