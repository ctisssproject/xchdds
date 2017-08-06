<?php
require_once 'include/db_table.class.php';
require_once 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'include/it_basic.class.php';
class ShowPage extends It_Basic {
	protected $O_SingleUser;
	protected $S_HomePage;
	public function getHomePage() {
		return $this->S_HomePage;
	}
	public function __construct($o_singleUser) {
		$this->O_SingleUser = $o_singleUser;
		
		$this->N_PageSize = 20;
	}
	public function getColumnForArticle() {
		$Column1 = new Home_Column ();
		$Column1->PushWhere ( array ('&&', 'Parent', '=', 0 ) );
		$Column1->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$Column1->PushWhere ( array ('&&', 'Url', '=', '' ) );
		$Column1->PushOrder ( array ('Number', 'A' ) );
		$n_count = $Column1->getAllCount ();
		$s_html = '';
		for($i = 0; $i < $n_count; $i ++) {
			if ($i == 0) {
				$this->S_HomePage = 'article_list.php?columnid=' . $Column1->getColumnId ( $i );
				$s_html .= '
                     <table class="BlockTop" width="100%">
                        <tbody>
                            <tr>
                                <td class="left">
                                </td>
                                <td class="center">
                                    <a href="article_list.php?columnid=' . $Column1->getColumnId ( $i ) . '" class="header" target="diary_body">' . $Column1->getName ( $i ) . '</a>
                                </td>
                                <td class="right">
                                </td>
                            </tr>
                        </tbody>
                    </table>
				';
			} else if (($i + 1) == $n_count) {
				$s_html .= '
                    <table class="BlockBottom no-top-border" >
                        <tbody>
                            <tr>
                                <td class="left">
                                </td>
                                <td class="center">
                                    <a href="article_list.php?columnid=' . $Column1->getColumnId ( $i ) . '" class="header" target="diary_body">' . $Column1->getName ( $i ) . '</a>
                                </td>
                                <td class="right">
                                </td>
                            </tr>
                        </tbody>
                    </table>
				';
			} else if ($i == 1) {
				$s_html .= '
                    <div class="head no-top-border"><a href="article_list.php?columnid=' . $Column1->getColumnId ( $i ) . '" class="header" target="diary_body">' . $Column1->getName ( $i ) . '</a></div>
				';
			} else {
				$s_html .= '
                    <div class="head"><a href="article_list.php?columnid=' . $Column1->getColumnId ( $i ) . '" class="header" target="diary_body">' . $Column1->getName ( $i ) . '</a></div>
				';
			}
		}
		return $s_html;
	}
	private function getTypeForNavHtml($a_path, $a_name) {
		for($i = 0; $i < count ( $a_path ); $i ++) {
			if ($i == 0) {
				$this->S_HomePage = RELATIVITY_PATH . $a_path [$i];
				$s_html .= '
                     <table class="BlockTop" width="100%">
                        <tbody>
                            <tr>
                                <td class="left">
                                </td>
                                <td class="center">
                                    <a href="' . RELATIVITY_PATH . $a_path [$i] . '" class="header" target="diary_body">' . $a_name [$i] . '</a>
                                </td>
                                <td class="right">
                                </td>
                            </tr>
                        </tbody>
                    </table>
				';
			} else if (($i + 1) == count ( $a_path )) {
				$s_html .= '
                    <table class="BlockBottom no-top-border" >
                        <tbody>
                            <tr>
                                <td class="left">
                                </td>
                                <td class="center">
                                    <a href="' . RELATIVITY_PATH . $a_path [$i] . '" class="header" target="diary_body">' . $a_name [$i] . '</a>
                                </td>
                                <td class="right">
                                </td>
                            </tr>
                        </tbody>
                    </table>
				';
			} else if ($i == 1) {
				$s_html .= '
                    <div class="head no-top-border"><a href="' . RELATIVITY_PATH . $a_path [$i] . '" class="header" target="diary_body">' . $a_name [$i] . '</a></div>
				';
			} else {
				$s_html .= '
                    <div class="head"><a href="' . RELATIVITY_PATH . $a_path [$i] . '" class="header" target="diary_body">' . $a_name [$i] . '</a></div>
				';
			}
		}
		return $s_html;
	}
	public function getTypeForNav() {
		$o_type = new View_User_Right ();
		$o_type->PushWhere ( array ('&&', 'ParentModuleId', '=', MODULEID ) );
		$o_type->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_type->PushOrder ( array ('RightId', 'A' ) );
		$n_count = $o_type->getAllCount ();
		$s_html = '';
		$a_name = array ();
		$a_path = array ();
		for($i = 0; $i < $n_count; $i ++) {
			array_push ( $a_path, $o_type->getPath ( $i ) );
			array_push ( $a_name, $o_type->getModuleName ( $i ) );
		}
		$o_type = new View_User_Right_Sec1 ();
		$o_type->PushWhere ( array ('&&', 'ParentModuleId', '=', MODULEID ) );
		$o_type->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_type->PushOrder ( array ('RightId', 'A' ) );
		$n_count = $o_type->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			array_push ( $a_path, $o_type->getPath ( $i ) );
			array_push ( $a_name, $o_type->getModuleName ( $i ) );
		}
		
		$o_type = new View_User_Right_Sec2 ();
		$o_type->PushWhere ( array ('&&', 'ParentModuleId', '=', MODULEID ) );
		$o_type->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_type->PushOrder ( array ('RightId', 'A' ) );
		$n_count = $o_type->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			array_push ( $a_path, $o_type->getPath ( $i ) );
			array_push ( $a_name, $o_type->getModuleName ( $i ) );
		}
		
		$o_type = new View_User_Right_Sec3 ();
		$o_type->PushWhere ( array ('&&', 'ParentModuleId', '=', MODULEID ) );
		$o_type->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_type->PushOrder ( array ('RightId', 'A' ) );
		$n_count = $o_type->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			array_push ( $a_path, $o_type->getPath ( $i ) );
			array_push ( $a_name, $o_type->getModuleName ( $i ) );
		}
		
		$o_type = new View_User_Right_Sec4 ();
		$o_type->PushWhere ( array ('&&', 'ParentModuleId', '=', MODULEID ) );
		$o_type->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_type->PushOrder ( array ('RightId', 'A' ) );
		$n_count = $o_type->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			array_push ( $a_path, $o_type->getPath ( $i ) );
			array_push ( $a_name, $o_type->getModuleName ( $i ) );
		}
		
		$o_type = new View_User_Right_Sec5 ();
		$o_type->PushWhere ( array ('&&', 'ParentModuleId', '=', MODULEID ) );
		$o_type->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_type->PushOrder ( array ('RightId', 'A' ) );
		$n_count = $o_type->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			array_push ( $a_path, $o_type->getPath ( $i ) );
			array_push ( $a_name, $o_type->getModuleName ( $i ) );
		}
		return $this->getTypeForNavHtml($a_path, $a_name);
	}
	public function getIndexColumn() {
		$o_scroll = new View_Home_Indexcolumn ();
		$o_scroll->PushOrder ( array ('IndexcolumnId', 'A' ) );
		$n_count = $o_scroll->getAllCount ();
		$o_head = '';
		$o_body = '';
		$o_floor = '';
		//构造弹出菜单的一级栏目
		$s_column_id = 'new Array(';
		$s_column_name = 'new Array(';
		$o_column = new Home_Column ();
		$o_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_column->PushWhere ( array ('&&', 'Parent', '=', 0 ) );
		$o_column->PushWhere ( array ('&&', 'Url', '=', '' ) );
		$o_column->PushOrder ( array ('Number', 'A' ) );
		for($i = 0; $i < $o_column->getAllCount (); $i ++) {
			$s_column_id .= $o_column->getColumnId ( $i ) . ',';
			$s_column_name .= '\'' . $o_column->getName ( $i ) . '\',';
		}
		$s_column_id = substr ( $s_column_id, 0, strlen ( $s_column_id ) - 1 );
		$s_column_name = substr ( $s_column_name, 0, strlen ( $s_column_name ) - 1 );
		$s_column_id .= ')';
		$s_column_name .= ')';
		//////////////////
		$o_head = '
					    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					            <tr>
					                <td class="small1" align="left">
					                    共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;条栏目
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:10px">
					        <tbody>
					            <tr class="TableHeader">
					                <td nowrap="nowrap" align="center" width="150px">
					                    顺序<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap">
					       	首页显示的栏目名称
					                </td>
					                <td align="center" nowrap="nowrap" width="80px">
					           	操作       
					                </td>
					            </tr>
		';
		$o_floor = '
					        </tbody>
					    </table><br/>
							';
		for($i = 0; $i < $n_count; $i ++) {
			$o_body .= '
		            <tr class="TableLine1">
		                <td align="center" nowrap="nowrap">
		                    ' . ($i + 1) . '
		                </td>
		                <td align="center" nowrap="nowrap">
		                    <strong>' . $o_scroll->getName ( $i ) . '</strong>
		                </td>
		                <td align="center" nowrap="nowrap">
		                 <a href="javascript:indexColume(' . $o_scroll->getIndexcolumnId ( $i ) . ',' . $s_column_id . ',' . $s_column_name . ');">修改</a>
		                </td>
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}
	public function getScroll() {
		$o_scroll = new View_Home_Article ();
		$o_scroll->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_scroll->PushWhere ( array ('&&', 'Scroll', '=', 1 ) );
		$o_scroll->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_scroll->PushOrder ( array ('Date', 'D' ) );
		$n_count = $o_scroll->getAllCount ();
		$o_head = '';
		$o_body = '';
		$o_floor = '';
		if ($n_count == 0) {
			return $this->returnNoRecord ( '<input class="BigButtonC" onclick="location=\'home_dynamic_modify.php\'" value="添加滚动文章" type="button"/>', '首页没有滚动最新动态' );
		} else {
			$o_head = '
					    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					            <tr>
					                <td width="200">
			                    <input class="BigButtonC" onclick="location=\'home_dynamic_modify.php\'" value="添加滚动文章" type="button"/>
			                		</td>
					                <td class="small1" align="left">
					                    共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;条滚动动态
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:10px">
					        <tbody>
					            <tr class="TableHeader">
					                <td nowrap="nowrap" class="xuan" width="50px">
					                    选
					                </td>
					                <td align="center" nowrap="nowrap" width="100px">
					       	文章编号
					                </td>
					                <td align="center" nowrap="nowrap" width="150px">
					                    发布日期<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap" width="200px">
					                    栏目
					                </td>
					                <td align="center" nowrap="nowrap">
					           	标题       
					                </td>
					            </tr>
		';
			$o_floor = '
					  <tr class="TableControl">
					                <td colspan="5">
					                    &nbsp;<input id="allcheck" onclick="selectAll(this)" type="checkbox">
					                    <label for="allbox_for">
					                        全选</label>
					                    &nbsp; <a href="javascript:deleteScroll();" title="删除所选动态">
					                        <img src="../../images/delete.gif" align="absMiddle">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="blue">注：删除后在首页的最新动态滚动里，将不再显示此文章的标题，但是文章不会被删除。</span>
					                </td>
					            </tr>
					        </tbody>
					    </table><br/>
							';
		}
		for($i = 0; $i < $n_count; $i ++) {
			$o_affix = $o_scroll->getParent ( $i );
			if ($o_scroll->getParent ( $i ) > 0) {
				$o_column = new Home_Column ( $o_scroll->getParent ( $i ) );
				$s_column = $o_column->getName () . ' >> ' . $o_scroll->getName ( $i );
			} else {
				$s_column = $o_scroll->getName ( $i );
			}
			$o_body .= '
		            <tr class="TableLine1">
		                <td>
		                    &nbsp;<input id="check_' . ($i + 1) . '" value="' . $o_scroll->getArticleId ( $i ) . '" type="checkbox" onclick="selectSingle()">
		                </td>
		                <td align="center" nowrap="nowrap">
		                    ' . $o_scroll->getArticleId ( $i ) . '
		                </td>
		                <td align="center" nowrap="nowrap">
		                    ' . $o_scroll->getDate ( $i ) . '		                   
		                </td>
		                <td align="center" nowrap="nowrap">
		                   ' . $s_column . '
		                </td>
		                <td nowrap="nowrap" align="center">
		                   <a href="index_article.php?articleid=' . $o_scroll->getArticleId ( $i ) . '" target="_blank" style="font-size:14px"><strong>' . $o_scroll->getTitle ( $i ) . '</strong></a>
		                </td>
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}
	public function getFocus() {
		$o_focus = new Home_Focus ();
		$o_focus->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_focus->getAllCount ();
		$o_head = '';
		$o_body = '';
		$o_floor = '';
		if ($n_count == 0) {
			return $this->returnNoRecord ( '<input class="BigButtonC" onclick="location=\'home_focus_add.php\'" value="添加展示大图" type="button"/>', '没有展示大图' );
		} else {
			$o_head = '
					    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					            <tr>
					                <td width="200">
			                    <input class="BigButtonC" onclick="location=\'home_focus_add.php\'" value="添加展示大图" type="button"/>
			                		</td>
					                <td class="small1" align="left">
					                    共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;个展示大图
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:10px">
					        <tbody>
					            <tr class="TableHeader">
					                <td nowrap="nowrap" class="xuan" width="50px">
					                    选
					                </td>
					                <td align="center" nowrap="nowrap">
					       	顺序<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap">
					                    图片
					                </td>
					                   <td align="center" nowrap="nowrap">
					           	操作       
					                </td>
					            </tr>
		';
			$o_floor = '
					  <tr class="TableControl">
					                <td colspan="7">
					                    &nbsp;<input id="allcheck" onclick="selectAll(this)" type="checkbox">
					                    <label for="allbox_for">
					                        全选</label>
					                    &nbsp; <a href="javascript:deleteBigFocus();" title="删除所选图片">
					                        <img src="../../images/delete.gif" align="absMiddle">删除</a>
					                        					                </td>
					            </tr>
					        </tbody>
					    </table><br/>
							';
		}
		for($i = 0; $i < $n_count; $i ++) {
			$o_body .= '
		            <tr class="TableLine1">
		                <td>
		                    &nbsp;<input id="check_' . ($i + 1) . '" value="' . $o_focus->getFocusId ( $i ) . '" type="checkbox" onclick="selectSingle()">
		                </td>
		                <td align="center" nowrap="nowrap">
		                    ' . $o_focus->getNumber ( $i ) . '
		                </td>
		                <td align="center" nowrap="nowrap">
		                    <img src="' . $o_focus->getPhoto ( $i ) . '" alt="' . $o_focus->getTitle ( $i ) . '" width="378" height="150" />		                   
		                </td>
		                <td align="center">
		                  <a href="home_focus_modify.php?focusid=' . $o_focus->getFocusId ( $i ) . '">修改</a>
		                </td>
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}
	public function getFocusPhoto() {
		$o_focus = new Home_NewsFocus ();
		$o_focus->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_focus->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_focus->getAllCount ();
		$o_head = '';
		$o_body = '';
		$o_floor = '';
		if ($n_count == 0) {
			return $this->returnNoRecord ( '<input class="BigButtonC" onclick="location=\'home_focusphoto_add.php\'" value="添加焦点图片" type="button"/>', '没有焦点图片' );
		} else {
			$o_head = '
					    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					            <tr>
					                <td width="200">
			                    <input class="BigButtonC" onclick="location=\'home_focusphoto_add.php\'" value="添加焦点图片" type="button"/>
			                		</td>
					                <td class="small1" align="left">
					                    共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;个焦点图片
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:10px">
					        <tbody>
					            <tr class="TableHeader">
					                <td nowrap="nowrap" class="xuan" width="50px">
					                    选
					                </td>
					                <td align="center" nowrap="nowrap" width="60px">
					       	顺序<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap" width="170px">
					                    图片
					                </td>
					                <td align="center" nowrap="nowrap" width="450px">
					                    标题
					                </td>
					                <td align="center" nowrap="nowrap" width="60px">
					           	状态       
					                </td>
					                   <td align="center" nowrap="nowrap" width="60px">
					           	操作       
					                </td>
					            </tr>
		';
			$o_floor = '
					  <tr class="TableControl">
					                <td colspan="7">
					                    &nbsp;<input id="allcheck" onclick="selectAll(this)" type="checkbox">
					                    <label for="allbox_for">
					                        全选</label>
					                    &nbsp; <a href="javascript:deleteFocus();" title="删除所选焦点图片">
					                        <img src="../../images/delete.gif" align="absMiddle">删除</a>
					                        					                </td>
					            </tr>
					        </tbody>
					    </table><br/>
							';
		}
		for($i = 0; $i < $n_count; $i ++) {
			if ($o_focus->getState ( $i ) == 1) {
				$s_state = '<span class="green">启用</span>';
			} else {
				$s_state = '<span class="red">禁用</span>';
			}
			$o_body .= '
		            <tr class="TableLine1">
		                <td>
		                    &nbsp;<input id="check_' . ($i + 1) . '" value="' . $o_focus->getFocusId ( $i ) . '" type="checkbox" onclick="selectSingle()">
		                </td>
		                <td align="center" nowrap="nowrap">
		                    ' . $o_focus->getNumber ( $i ) . '
		                </td>
		                <td align="center" nowrap="nowrap">
		                    <a href="index_article.php?articleid=' . $o_focus->getArticleId ( $i ) . '" target="_blank"><img src="' . $o_focus->getPhoto ( $i ) . '" alt="' . $o_focus->getTitle ( $i ) . '" width="158" height="100" /></a>		                   
		                </td>
		                <td align="center">
		                  <a href="index_article.php?articleid=' . $o_focus->getArticleId ( $i ) . '" target="_blank" style="font-size:14px"><strong>' . $o_focus->getTitle ( $i ) . '</strong></a>
		                </td>
		                <td align="center">
		                  ' . $s_state . '
		                </td>
		                <td align="center">
		                  <a href="home_focusphoto_modify.php?focusid=' . $o_focus->getFocusId ( $i ) . '">修改</a>
		                </td>
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}
	public function getPhotoList() {
		$o_focus = new Home_Photo (); 
		$o_focus->PushOrder ( array ('PhotoId', 'D' ) );
		$n_count = $o_focus->getAllCount ();
		$o_head = '';
		$o_body = '';
		$o_floor = '';
		if ($n_count == 0) {
			return $this->returnNoRecord ( '<input class="BigButtonC" onclick="location=\'home_photo_add.php\'" value="添加图片" type="button"/>', '没有图片' );
		} else {
			$o_head = '
					    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					            <tr>
					                <td width="200">
			                    <input class="BigButtonC" onclick="location=\'home_photo_add.php\'" value="添加图片" type="button"/>
			                		</td>
					                <td class="small1" align="left">
					                    共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;个图片
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:10px">
					        <tbody>
					            <tr class="TableHeader">
					                <td nowrap="nowrap" class="xuan" width="50px">
					                    选
					                </td>
					                <td align="center" nowrap="nowrap" width="170px">
					                    图片
					                </td>
					                <td align="center" nowrap="nowrap" width="450px">
					                   图片标题
					                </td>
					            </tr>
		';
			$o_floor = '
					  <tr class="TableControl">
					                <td colspan="7">
					                    &nbsp;<input id="allcheck" onclick="selectAll(this)" type="checkbox">
					                    <label for="allbox_for">
					                        全选</label>
					                    &nbsp; <a href="javascript:deletePhoto();" title="删除所选图片">
					                        <img src="../../images/delete.gif" align="absMiddle">删除</a>
					                        					                </td>
					            </tr>
					        </tbody>
					    </table><br/>
							';
		}
		for($i = 0; $i < $n_count; $i ++) {
			if ($o_focus->getState ( $i ) == 1) {
				$s_state = '<span class="green">启用</span>';
			} else {
				$s_state = '<span class="red">禁用</span>';
			}
			$o_body .= '
		            <tr class="TableLine1">
		                <td>
		                    &nbsp;<input id="check_' . ($i + 1) . '" value="' . $o_focus->getPhotoId ( $i ) . '" type="checkbox" onclick="selectSingle()">
		                </td>
		                <td align="center" nowrap="nowrap">
		                    <a href="'.$o_focus->getPath($i).'" target="_blank"><img src="' . $o_focus->getPath ( $i ) . '" width="100" height="100" /></a>		                   
		                </td>
		                <td>
		                  '.$o_focus->getText($i).'
		                </td>
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}
	public function getColumn() {
		$o_indexcolumn = new Home_Indexcolumn ();
		$n_indexcolumn = $o_indexcolumn->getAllCount ();
		$o_column1 = new Home_Column ();
		$o_column1->PushWhere ( array ('&&', 'Parent', '=', 0 ) );
		$o_column1->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_column1->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_column1->getAllCount ();
		$n_id = 1;
		$o_head = '';
		$o_body = '';
		$o_floor = '';
		if ($n_count == 0) {
			return $this->returnNoRecord ( '<input class="BigButtonC" onclick="showAddColumn(0,' . $n_count . ')" value="添加一级栏目" type="button"/>', '没有栏目' );
		} else {
			$o_head = '
					    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					            <tr>
					                <td width="200">
			                    <input class="BigButtonC" onclick="showAddColumn(0,' . $n_count . ')" value="添加一级栏目" type="button"/>
			                		</td>
					                <td class="small1" align="left">
					                
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:10px">
					        <tbody>
					            <tr class="TableHeader">
					                <td align="center" nowrap="nowrap" width="100px">
					       	顺序<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap" width="200px">
					                   一级栏目
					                </td>
					                <td align="center" width="100px">
					           	顺序<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle"> 
					                </td>
					                <td align="center" width="200px">
					           	二级栏目       
					                </td>
					                    <td align="center" nowrap="nowrap" width="80px">
					           	首页显示      
					                </td>
					                <td align="center" nowrap="nowrap" width="80px">
					           	状态       
					                </td>
					                   <td align="center" nowrap="nowrap">
					           	操作       
					                </td>
					            </tr>
		';
			$o_floor = '
					        </tbody>
					    </table><br/>
							';
		}
		for($i = 0; $i < $n_count; $i ++) {
			if ($o_column1->getState ( $i ) == 1) {
				$s_state = '<span class="green">启用</span>';
			} else {
				$s_state = '<span class="red">禁用</span>';
			}
			$s_delete = '';
			if ($o_column1->getAllowDelete ( $i ) == 1) {
				$s_delete = '&nbsp;&nbsp;<a href="javascript:deleteColumn(' . $o_column1->getColumnId ( $i ) . ');">删除</a>';
			}
			for($k = 0; $k < $n_indexcolumn; $k ++) {
				if ($o_indexcolumn->getColumnId ( $k ) == $o_column1->getColumnId ( $i )) {
					$s_index = '<img src="../../images/correct.gif" align="absMiddle">';
					break;
				} else {
					$s_index = '';
				}
			}
			$o_column2 = new Home_Column ();
			$o_column2->PushWhere ( array ('&&', 'Parent', '=', $o_column1->getColumnId ( $i ) ) );
			$o_column2->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_column2->PushOrder ( array ('Number', 'A' ) );
			$n_count2 = $o_column2->getAllCount ();
			$o_body .= '
		            <tr class="TableLine1">
		                <td align="center" nowrap="nowrap">
		                    ' . $o_column1->getNumber ( $i ) . '
		                </td>
		                <td align="center">
		                  <strong>' . $o_column1->getName ( $i ) . '</strong>
		                </td>
		                <td align="center">
		                  <a href="javascript:showAddColumn(' . $o_column1->getColumnId ( $i ) . ',' . $n_count2 . ');" title="添加二级栏目"><img src="../../images/green_plus.gif" align="absMiddle" alt="添加二级栏目"></a>
		                </td>
		                <td align="center">
		                  
		                </td>
		                <td align="center">
		                  ' . $s_index . '
		                </td>
		                <td align="center">
		                  ' . $s_state . '
		                </td>
		                <td align="center">
		                  <a href="javascript:showModifyColumn(' . $o_column1->getColumnId ( $i ) . ',\'' . $o_column1->getName ( $i ) . '\',' . $o_column1->getParent ( $i ) . ',' . $o_column1->getNumber ( $i ) . ',' . $n_count . ',' . $o_column1->getState ( $i ) . ',\'' . $o_column1->getUrl ( $i ) . '\');">编辑</a>' . $s_delete . '
		                </td>
		            </tr>
			';
			for($j = 0; $j < $n_count2; $j ++) {
				if (($j + 1) == $n_count2) {
					$s_photo = '<img src="images/column_path2.png" align="absMiddle">';
				} else {
					$s_photo = '<img src="images/column_path1.png" align="absMiddle">';
				}
				if ($o_column2->getState ( $j ) == 1) {
					$s_state = '<span class="green">启用</span>';
				} else {
					$s_state = '<span class="red">禁用</span>';
				}
				$s_delete = '';
				if ($o_column2->getAllowDelete ( $j ) == 1) {
					$s_delete = '&nbsp;&nbsp;<a href="javascript:deleteColumn(' . $o_column2->getColumnId ( $j ) . ');">删除</a>';
				}
				for($k = 0; $k < $n_indexcolumn; $k ++) {
					if ($o_indexcolumn->getColumnId ( $k ) == $o_column2->getColumnId ( $j )) {
						$s_index = '<img src="../../images/correct.gif" align="absMiddle">';
						break;
					} else {
						$s_index = '';
					}
				}
				$o_body .= '
		            <tr class="TableLine1">
		                <td align="center" nowrap="nowrap">
		                   
		                </td>
		                <td align="right">
		                  ' . $s_photo . '
		                </td>
		                <td align="center">
		                   ' . $o_column2->getNumber ( $j ) . '
		                </td>
		                <td align="center">
		                  ' . $o_column2->getName ( $j ) . '
		                </td>
		                <td align="center" nowrap="nowrap">
		                   ' . $s_index . '
		                </td>
		                <td align="center">
		                  ' . $s_state . '
		                </td>
		                <td align="center">
		                  <a href="javascript:showModifyColumn(' . $o_column2->getColumnId ( $j ) . ',\'' . $o_column2->getName ( $j ) . '\',' . $o_column2->getParent ( $j ) . ',' . $o_column2->getNumber ( $j ) . ',' . $n_count2 . ',' . $o_column2->getState ( $j ) . ',\'' . $o_column2->getUrl ( $j ) . '\');">编辑</a>' . $s_delete . '
		                </td>
		            </tr>
			';
			}
		
		}
		
		return $o_head . $o_body . $o_floor;
	}
	public function getLinkList() {
		$o_focus = new Home_Link ();
		$o_focus->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_focus->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_focus->getAllCount ();
		$o_head = '';
		$o_body = '';
		$o_floor = '';
		if ($n_count == 0) {
			return $this->returnNoRecord ( '<input class="BigButtonC" onclick="location=\'home_link_modify.php\'" value="添加友情链接" type="button"/>', '没有友情链接' );
		} else {
			$o_head = '
					    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					            <tr>
					                <td width="200">
			                    <input class="BigButtonC" onclick="location=\'home_link_add.php\'" value="添加友情链接" type="button"/>
			                		</td>
					                <td class="small1" align="left">
					                    共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;个友情链接
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:10px">
					        <tbody>
					            <tr class="TableHeader">
					                <td nowrap="nowrap" class="xuan" width="50px">
					                    选
					                </td>
					                <td align="center" nowrap="nowrap" width="60px">
					       	顺序<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap" width="450px">
					                    标题
					                </td>
					                <td align="center" >
					           	链接地址       
					                </td>
					                <td align="center" nowrap="nowrap" width="60px">
					           	状态       
					                </td>
					                   <td align="center" nowrap="nowrap" width="60px">
					           	操作       
					                </td>
					            </tr>
		';
			$o_floor = '
					  <tr class="TableControl">
					                <td colspan="6">
					                    &nbsp;<input id="allcheck" onclick="selectAll(this)" type="checkbox">
					                    <label for="allbox_for">
					                        全选</label>
					                    &nbsp; <a href="javascript:deleteLink();" title="删除所选友情链接">
					                        <img src="../../images/delete.gif" align="absMiddle">删除</a>
					                        					                </td>
					            </tr>
					        </tbody>
					    </table><br/>
							';
		}
		for($i = 0; $i < $n_count; $i ++) {
			if ($o_focus->getState ( $i ) == 1) {
				$s_state = '<span class="green">启用</span>';
			} else {
				$s_state = '<span class="red">禁用</span>';
			}
			$o_body .= '
		            <tr class="TableLine1">
		                <td>
		                    &nbsp;<input id="check_' . ($i + 1) . '" value="' . $o_focus->getLinkId ( $i ) . '" type="checkbox" onclick="selectSingle()">
		                </td>
		                <td align="center" nowrap="nowrap">
		                    ' . $o_focus->getNumber ( $i ) . '
		                </td>
		                <td align="center">
		                  <a href="' . $o_focus->getUrl ( $i ) . '" target="_blank" style="font-size:14px"><strong>' . $o_focus->getName ( $i ) . '</strong></a>
		                </td>
		                <td align="center">
		                   ' . $o_focus->getUrl ( $i ) . '
		                </td>
		                <td align="center">
		                  ' . $s_state . '
		                </td>
		                <td align="center">
		                  <a href="home_link_modify.php?linkid=' . $o_focus->getLinkId ( $i ) . '">修改</a>
		                </td>
		            </tr>
			';
		}
		
		return $o_head . $o_body . $o_floor;
	}
	public function getFooterArticle() {
		$o_focus = new Home_Article_Footer ();
		$o_focus->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_focus->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_focus->getAllCount ();
		$o_head = '';
		$o_body = '';
		$o_floor = '';
		if ($n_count == 0) {
			return $this->returnNoRecord ( '<input class="BigButtonC" onclick="location=\'home_footer_modify.php\'" value="添加文章" type="button"/>', '没有底部栏目文章' );
		} else {
			$o_head = '
					    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					            <tr>
					                <td width="200">
			                    <input class="BigButtonC" onclick="location=\'home_footer_add.php\'" value="添加文章" type="button"/>
			                		</td>
					                <td class="small1" align="left">
					                    共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;个底部文章
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:10px">
					        <tbody>
					            <tr class="TableHeader">
					                <td nowrap="nowrap" class="xuan" width="50px">
					                    选
					                </td>
					                <td align="center" nowrap="nowrap" width="60px">
					       	顺序<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap">
					                    标题
					                </td>
					                <td align="center" width="200px">
					           	发布日期       
					                </td>
					                <td align="center" nowrap="nowrap" width="60px">
					           	状态       
					                </td>
					                   <td align="center" nowrap="nowrap" width="60px">
					           	操作       
					                </td>
					            </tr>
		';
			$o_floor = '
					  <tr class="TableControl">
					                <td colspan="6">
					                    &nbsp;<input id="allcheck" onclick="selectAll(this)" type="checkbox">
					                    <label for="allbox_for">
					                        全选</label>
					                    &nbsp; <a href="javascript:deleteFooter();" title="删除所选文章">
					                        <img src="../../images/delete.gif" align="absMiddle">删除</a>
					                        					                </td>
					            </tr>
					        </tbody>
					    </table><br/>
							';
		}
		for($i = 0; $i < $n_count; $i ++) {
			if ($o_focus->getState ( $i ) == 1) {
				$s_state = '<span class="green">启用</span>';
			} else {
				$s_state = '<span class="red">禁用</span>';
			}
			$o_body .= '
		            <tr class="TableLine1">
		                <td>
		                    &nbsp;<input id="check_' . ($i + 1) . '" value="' . $o_focus->getArticleId ( $i ) . '" type="checkbox" onclick="selectSingle()">
		                </td>
		                <td align="center" nowrap="nowrap">
		                    ' . $o_focus->getNumber ( $i ) . '
		                </td>
		                <td align="center">
		                  <a href="index_other.php?articleid=' . $o_focus->getArticleId ( $i ) . '" target="_blank" style="font-size:14px"><strong>' . $o_focus->getTitle ( $i ) . '</strong></a>
		                </td>
		                <td align="center">
		                   ' . $o_focus->getDate ( $i ) . '
		                </td>
		                <td align="center">
		                  ' . $s_state . '
		                </td>
		                <td align="center">
		                  <a href="home_footer_modify.php?articleid=' . $o_focus->getArticleId ( $i ) . '">修改</a>
		                </td>
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}
	
	public function getArticleList($n_page) {
		$this->S_FileName = 'article_list.php?columnid=' . $_GET ['columnid'] . '&';
		$this->N_Page = $n_page;
		$o_article = new View_Home_Article ();
		$o_article->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_article->PushWhere ( array ('&&', 'ColumnId', '=', $_GET ['columnid'] ) );
		$o_article->PushOrder ( array ('Date', 'D' ) );
		$o_article->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
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
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		//构造弹出菜单的一级栏目
		$s_column_id = 'new Array(';
		$s_column_name = 'new Array(';
		$o_column = new Home_Column ();
		$o_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_column->PushWhere ( array ('&&', 'Parent', '=', 0 ) );
		$o_column->PushWhere ( array ('&&', 'Url', '=', '' ) );
		$o_column->PushOrder ( array ('Number', 'A' ) );
		for($i = 0; $i < $o_column->getAllCount (); $i ++) {
			$s_column_id .= $o_column->getColumnId ( $i ) . ',';
			$s_column_name .= '\'' . $o_column->getName ( $i ) . '\',';
		}
		$s_column_id = substr ( $s_column_id, 0, strlen ( $s_column_id ) - 1 );
		$s_column_name = substr ( $s_column_name, 0, strlen ( $s_column_name ) - 1 );
		$s_column_id .= ')';
		$s_column_name .= ')';
		//构建二级栏目按钮
		$s_columnname = '';
		$o_column = new Home_Column ( $_GET ['columnid'] );
		if ($o_column->getParent () == 0) {
			$n_parent = $o_column->getColumnId ();
			$s_titlename = $o_column->getName ();
		} else {
			$n_parent = $o_column->getParent ();
			$o_column = new Home_Column ( $o_column->getParent () );
			$s_titlename = $o_column->getName ();
		}
		$o_column = new Home_Column ();
		$o_column->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_column->PushWhere ( array ('&&', 'Parent', '=', $n_parent ) );
		$o_column->PushOrder ( array ('Number', 'A' ) );
		$s_column_button = '';
		for($i = 0; $i < $o_column->getAllCount (); $i ++) {
			if ($o_column->getColumnId ( $i ) == $_GET ['columnid']) {
				$s_column_button .= '<div class="column_bottom_on" onclick=" location=\'article_list.php?columnid=' . $o_column->getColumnId ( $i ) . '\'">' . $o_column->getName ( $i ) . '</div>';
			} else {
				if ($o_column->getColumnId ( $i )==66)
				{
					continue;
				}
				$s_column_button .= '<div class="column_bottom_off" onclick=" location=\'article_list.php?columnid=' . $o_column->getColumnId ( $i ) . '\'">' . $o_column->getName ( $i ) . '</div>';
			}
		}
		////验证是否为管理员,如果是,可以显示删除,和移动
		$b_isadmin = $this->O_SingleUser->ValidModule (96);
		///////////////////////////////////
		////////////////////////////////////
		$o_body = '';
		$o_floor = '';
		$o_head .= '    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					        	<tr>					                
					                <td style="height:30px" colspan="3"><span class="big3">' . $s_titlename . ' </span>
					                
			                		</td>
					            </tr>
					            <tr>					                
					                <td >' . $s_column_button . '
					                </td>
					                <td class="small1" align="left"  valign="bottom" nowrap="nowrap">
					                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;篇文章
					                </td>
					                 <td class="small1" align="right" valign="bottom" style="width:330px">
										' . $s_pagebutton . '
			                		</td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:5px">
					        <tbody>
					            <tr class="TableHeader">
					                <td nowrap="nowrap" class="xuan" width="50px">
					                    选
					                </td>
					                <td nowrap="nowrap" width="70px">
					                   文章编号
					                </td>
					                <td align="center" nowrap="nowrap">
					                     标题
					                </td>
					                <td align="center" width="200px">
					           	发布日期    <img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">   
					                </td>
					                <td align="center" nowrap="nowrap" width="70px">
					           	发布人       
					                </td>
					                <td align="center" nowrap="nowrap" width="120px">
					           	状态       
					                </td>
					                   <td align="center" nowrap="nowrap" width="70px">
					           	操作       
					                </td>
					            </tr>
		';
		if ($b_isadmin) {
			//可以删除和移动
			$o_floor = '
					  <tr class="TableControl">
					                <td colspan="7">
					                    &nbsp;<input id="allcheck" onclick="selectAll(this)" type="checkbox">
					                    <label for="allbox_for">
					                        全选</label>
					                    &nbsp; <a href="javascript:deleteArticle();" title="删除所选文章">
					                        <img src="../../images/delete.gif" align="absMiddle">删除</a>
					                        &nbsp; <a href="javascript:moveArticle(' . $s_column_id . ',' . $s_column_name . ');" title="移动所选文章">
					                        <img src="../../images/movetofolder.gif" align="absMiddle">移动</a>
					                        					                </td>
					            </tr>
					        </tbody>
					    </table><br/>
							';
		} else {
			//只能删除
			$o_floor = '
					  <tr class="TableControl">
					                <td colspan="8">
					                    &nbsp;<input id="allcheck" onclick="selectAll(this)" type="checkbox">
					                    <label for="allbox_for">
					                        全选</label>
					                    &nbsp; <a href="javascript:deleteArticle();" title="删除所选文章">
					                        <img src="../../images/delete.gif" align="absMiddle"> 删除</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="gray">提示：审核通过后的文章，将不允许私自删除。</span>
					             </td>
					            </tr>
					        </tbody>
					    </table><br/>
							';
		
		}
		
		for($i = 0; $i < $n_count; $i ++) {
			//如果是自己的文章，就显示编辑按钮和勾选框，如果不是，显示为空
			if ($o_article->getUid ( $i ) == $this->O_SingleUser->getUid ()|| $b_isadmin) {
				if ($o_article->getUid ( $i ) == $this->O_SingleUser->getUid ())
				{
					$s_button = '<a href="article_modify_my.php?articleid=' . $o_article->getArticleId ( $i ) . '">编辑</a>';
				}else{
					$s_button = '<a href="article_modify.php?articleid=' . $o_article->getArticleId ( $i ) . '">编辑</a>';
				}
				
			} else {
				$s_button = '';;
			}
			if ($o_article->getAudit ( $i ) == 1) {
				//在文章列表中显示审核状态
				$s_audit = '&nbsp;&nbsp;<span class="blue">(等待审核)</span>';
			} else if ($o_article->getAudit ( $i ) == 2) {
				$s_audit = '&nbsp;&nbsp;<span class="red">(退回)</span>';
			} else {
				$s_audit = '';
			}
			if ($o_article->getState ( $i ) == 1) {
				$s_state = '<span class="green">开放</span>' . $s_audit;
			} else {
				$s_state = '<span class="red">关闭</span>' . $s_audit;
			}
			if (($o_article->getUid ( $i ) == $this->O_SingleUser->getUid () && $o_article->getAudit ( $i ) != 3 && $o_article->getVisit ( $i ) == 0) || $b_isadmin) {
				$s_check = '<input id="check_' . ($i + 1) . '" value="' . $o_article->getArticleId ( $i ) . '" type="checkbox" onclick="selectSingle()">';
			} else {
				$s_check = '<input id="check_' . ($i + 1) . '" value="0" type="checkbox" style="display:none">';
			}
			$o_body .= '
		            <tr class="TableLine1">
		                <td>
		                    &nbsp;' . $s_check . '
		                </td>
		                <td align="center">
		                   ' . $o_article->getArticleId ( $i ) . '
		                </td>
		                <td align="left">
		                  <a href="index_article.php?articleid=' . $o_article->getArticleId ( $i ) . '" target="_blank" style="font-size:14px"><strong>' . $o_article->getTitle ( $i ) . '</strong></a>
		                </td>		                
		                <td align="center">
		                   ' . $o_article->getDate ( $i ) . '
		                </td>
		                <td align="center">
		                  ' . $o_article->getUserName ( $i ) . '
		                </td>
		                <td align="center">
		                  ' . $s_state . '
		                </td>
		                <td align="center">
		                  ' . $s_button . '
		                </td>
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}
	public function getArticleUnauditList($n_page) {
		$this->S_FileName = 'article_audit.php?';
		$this->N_Page = $n_page;
		$o_article = new View_Home_Article ();
		$o_article->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_article->PushWhere ( array ('&&', 'Audit', '=', 1 ) );
		//$o_article->PushWhere ( array ('&&', 'AuditUid', '=', $this->O_SingleUser->getUid () ) );
		$o_article->PushOrder ( array ('UploadDate', 'D' ) );
		$o_article->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
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
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		///////////////////////////////////
		////////////////////////////////////
		$o_body = '';
		$o_floor = '';
		if ($n_count == 0) {
			return $this->returnNoRecord ( '<span class="big3">门户文章审核</span>', '目前没有等待审核的文章' );
		}
		$o_head .= '    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					        	<tr>					                
					                <td style="height:30px" width="200"><span class="big3">门户文章审核 </span>
					                
			                		</td>				                
					                <td class="small1" align="left"  valign="bottom" nowrap="nowrap">
					                    共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;篇文章
					                </td>
					                 <td class="small1" align="right" valign="bottom" style="width:330px">
										' . $s_pagebutton . '
			                		</td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:5px">
					        <tbody>
					            <tr class="TableHeader">
					                <td nowrap="nowrap" width="70px">
					                   文章编号
					                </td>
					                <td align="center" nowrap="nowrap">
					                     标题
					                </td>
					                <td align="center" width="200px">
					           	新建日期    <img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">   
					                </td>
					                <td align="center" nowrap="nowrap" width="70px">
					           	发布人 
					                </td>
					                <td align="center" nowrap="nowrap" width="120px">
					           	状态       
					                </td>
					                   <td align="center" nowrap="nowrap" width="70px">
					           	操作       
					                </td>
					            </tr>
		';
		$o_floor = '
					        </tbody>
					    </table><br/>
							';
		for($i = 0; $i < $n_count; $i ++) {
			//如果是自己的文章，就显示编辑按钮和勾选框，如果不是，显示为空
			if ($o_article->getState ( $i ) == 1) {
				$s_state = '<span class="green">开放</span>';
			} else {
				$s_state = '<span class="red">关闭</span>';
			}
			$o_body .= '
		            <tr class="TableLine1">
		                <td align="center">
		                   ' . $o_article->getArticleId ( $i ) . '
		                </td>
		                <td align="left">
		                  <a href="index_article.php?articleid=' . $o_article->getArticleId ( $i ) . '" target="_blank" style="font-size:14px"><strong>' . $o_article->getTitle ( $i ) . '</strong></a>
		                </td>		                
		                <td align="center">
		                   ' . $o_article->getUploadDate ( $i ) . '
		                </td>
		                <td align="center">
		                  ' . $o_article->getUserName ( $i ) . '
		                </td>
		                <td align="center">
		                  ' . $s_state . '
		                </td>
		                <td align="center">
		                  <a href="article_audit_show.php?articleid=' . $o_article->getArticleId ( $i ) . '">审核</a>
		                </td>
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}
	public function getArticleMy($n_page) {
		$this->S_FileName = 'article_my.php?';
		$this->N_Page = $n_page;
		$o_article = new View_Home_Article ();
		$o_article->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
		$o_article->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid () ) );
		$o_article->PushOrder ( array ('Date', 'D' ) );
		$o_article->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
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
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		///////////////////////////////////
		////////////////////////////////////
		$o_body = '';
		$o_floor = '';
		if ($n_count == 0) {
			return $this->returnNoRecord ( '<span class="big3">我的文章</span>&nbsp;&nbsp;&nbsp;&nbsp;<input class="BigButtonB" onclick="location=\'article_add.php?page='.$n_page.'\'" value="发布文章" type="button"/>', '目前没有文章' );
		}
		$o_head .= '    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					        	<tr>					                
					                <td style="height:30px" width="200"><span class="big3">我的文章 </span>&nbsp;&nbsp;&nbsp;&nbsp;<input class="BigButtonB" onclick="location=\'article_add.php?page='.$n_page.'\'" value="发布文章" type="button"/>
			                		</td>				                
					                <td class="small1" align="left"  valign="bottom" nowrap="nowrap">
					                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;篇文章
					                </td>
					                 <td class="small1" align="right" valign="bottom" style="width:330px">
										' . $s_pagebutton . '
			                		</td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:5px">
					        <tbody>
					            <tr class="TableHeader">
					            	<td nowrap="nowrap" class="xuan" width="50px">
					                    选
					                </td>
					                <td nowrap="nowrap" width="70px">
					                   文章编号
					                </td>
					                <td align="center" nowrap="nowrap">
					                     标题
					                </td>
					                <td align="center" width="200px">
					           	发布日期    <img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">   
					                </td>
					                <td align="center" nowrap="nowrap" width="70px">
					           	发布人       
					                </td>
					                <td align="center" nowrap="nowrap" width="120px">
					           	状态       
					                </td>
					                <td align="center" nowrap="nowrap" width="120px">
					           	审核状态       
					                </td>
					                   <td align="center" nowrap="nowrap" width="70px">
					           	操作       
					                </td>
					            </tr>
		';
		
		$o_floor = '
					  <tr class="TableControl">
					                <td colspan="8">
					                    &nbsp;<input id="allcheck" onclick="selectAll(this)" type="checkbox">
					                    <label for="allbox_for">
					                        全选</label>
					                    &nbsp; <a href="javascript:deleteArticle();" title="删除所选文章">
					                        <img src="../../images/delete.gif" align="absMiddle"> 删除</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="gray">提示：审核通过后的文章，将不允许私自删除。</span>
					             </td>
					            </tr>
					        </tbody>
					    </table><br/>
							';
		for($i = 0; $i < $n_count; $i ++) {
			//如果是自己的文章，就显示编辑按钮和勾选框，如果不是，显示为空
			if ($o_article->getUid ( $i ) == $this->O_SingleUser->getUid ()) {
				$s_button = '<a href="article_modify.php?articleid=' . $o_article->getArticleId ( $i ) . '">编辑</a>';
			} else {
				$s_button = '';
			}
			if ($o_article->getState ( $i ) == 1) {
				$s_state = '<span class="green">开放</span>';
			} else {
				$s_state = '<span class="red">关闭</span>';
			}
			if ($o_article->getAudit ( $i ) == 1) {
				$s_audit = '<span class="blue">等待审核</span>';
			}
			if ($o_article->getAudit ( $i ) == 2) {
				$s_audit = '<span class="red">退回</span>';
			}
			if ($o_article->getAudit ( $i ) == 3) {
				$s_audit = '<span class="green">已通过</span>';
			}
			if ($o_article->getUid ( $i ) == $this->O_SingleUser->getUid () && $o_article->getAudit ( $i ) != 3 && $o_article->getVisit ( $i ) == 0) {
				$s_check = '<input id="check_' . ($i + 1) . '" value="' . $o_article->getArticleId ( $i ) . '" type="checkbox" onclick="selectSingle()">';
			} else {
				$s_check = '<input id="check_' . ($i + 1) . '" value="0" type="checkbox" style="display:none">';
			}
			$o_body .= '
		            <tr class="TableLine1">
		            	<td>
		                    &nbsp;' . $s_check . '
		                </td>
		                <td align="center">
		                   ' . $o_article->getArticleId ( $i ) . '
		                </td>
		                <td align="left">
		                  [<span class="green">' . $o_article->getName ( $i ) . '</span>] <a href="index_article.php?articleid=' . $o_article->getArticleId ( $i ) . '" target="_blank" style="font-size:14px"><strong>' . $o_article->getTitle ( $i ) . '</strong></a>
		                </td>		                
		                <td align="center">
		                   ' . $o_article->getDate ( $i ) . '
		                </td>
		                <td align="center">
		                  ' . $o_article->getUserName ( $i ) . '
		                </td>
		                <td align="center">
		                  ' . $s_state . '
		                </td>
		                <td align="center">
		                  ' . $s_audit . '
		                </td>
		                <td align="center">
		                  <a href="article_modify_my.php?articleid=' . $o_article->getArticleId ( $i ) . '">编辑</a>
		                </td>
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}
	public function getFloatList() {
		$o_focus = new View_Home_Float();
		$o_focus->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_focus->getAllCount ();
		$o_head = '';
		$o_body = '';
		$o_floor = '';
		if ($n_count == 0) {
			return $this->returnNoRecord ( '<input class="BigButtonB" onclick="showAddFloat(0)" value="添加" type="button"/>', '没有浮动文章' );
		} else {
			$o_head = '
					    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					            <tr>
					                <td width="200">
			                    <input class="BigButtonB" onclick="showAddFloat('.$n_count.')" value="添加" type="button"/>
			                		</td>
					                <td class="small1" align="left">
					                    共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;个浮动文章
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:10px">
					        <tbody>
					            <tr class="TableHeader">
					                <td nowrap="nowrap" class="xuan" width="50px">
					                    选
					                </td>
					                <td align="center" nowrap="nowrap" width="60px">
					       	顺序<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap" width="80px">
					                    文章编号
					                </td>
					                <td align="center" nowrap="nowrap">
					                    标题
					                </td>
					                   <td align="center" nowrap="nowrap" width="80px">
					           	操作       
					                </td>
					            </tr>
		';
			$o_floor = '
					  <tr class="TableControl">
					                <td colspan="6">
					                    &nbsp;<input id="allcheck" onclick="selectAll(this)" type="checkbox">
					                    <label for="allbox_for">
					                        全选</label>
					                    &nbsp; <a href="javascript:deleteFloat();" title="删除所选文章">
					                        <img src="../../images/delete.gif" align="absMiddle">删除</a>
					                        					                </td>
					            </tr>
					        </tbody>
					    </table><br/>
							';
		}
		for($i = 0; $i < $n_count; $i ++) {
			if ($o_focus->getState ( $i ) == 1) {
				$s_state = '<span class="green">启用</span>';
			} else {
				$s_state = '<span class="red">禁用</span>';
			}
			$o_body .= '
		            <tr class="TableLine1">
		                <td>
		                    &nbsp;<input id="check_' . ($i + 1) . '" value="' . $o_focus->getFloatId ( $i ) . '" type="checkbox" onclick="selectSingle()">
		                </td>
		                <td align="center" nowrap="nowrap">
		                    ' . $o_focus->getNumber ( $i ) . '
		                </td>
		                <td align="center">
		                  	' . $o_focus->getArticleId ( $i ) . '
		                </td>
		                <td align="center">
		                  <a href="index_article.php?articleid=' . $o_focus->getArticleId ( $i ) . '" target="_blank" style="font-size:14px"><strong>' . $o_focus->getTitle ( $i ) . '</strong></a>
		                </td>
		                <td align="center">
		                  <a href="javascript:;" onclick="showModifyFloat('.$o_focus->getFloatId($i).','.$o_focus->getArticleId($i).','.$o_focus->getNumber($i).','.$n_count.')">修改</a>
		                </td>
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}
	public function getMessages($n_page) {
		$this->S_FileName = 'messages.php?';
		$this->N_Page = $n_page;
		$o_notice = new Home_Messages ();
		$o_notice->PushWhere ( array ('&&', 'Delete', '=', 0 ) ); //按角色查询
		$o_notice->PushOrder ( array ('Audit', 'A' ) ); //按编号降序	
		$o_notice->PushOrder ( array ('Date', 'D' ) ); //按编号降序	
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
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		$j=0;
		for($i = 0; $i < $n_count; $i ++) { //按条数循环显示
			$s_check = '';
			$s_state='';
			$s_date='';
			$s_title='';
			if ($o_notice->getAudit ( $i ) == 3) {
				$s_state='已审核';
				$s_date=$o_notice->getOpenDate( $i );
				$s_button='';
				$s_title=$o_notice->getTitle( $i );
				$s_url='<a href="index_messages_show.php?articleid='.$o_notice->getArticleId( $i ).'" title="" style="font-size:14px;padding-left:15px" target="_blank">';
				$s_auditdate=$o_notice->getAuditDate( $i );
				$o_user=new Base_User_Info($o_notice->getAuditUid( $i ));
				$s_username=$o_user->getName();
			}else{
				$s_username='';
				$s_title='<strong>'.$o_notice->getTitle( $i ).'</strong>';
				//$s_check = '<input id="check_' . ($j + 1) . '" value="' . $o_notice->getNoticeId ( $i ) . '" type="checkbox" onclick="selectSingle()">';
				
				$s_auditdate='';
				$s_state='未审核';
				$s_button='<a href="messages_audit.php?articleid='.$o_notice->getArticleId( $i ).'">审核</a>';
				$s_url='<a href="messages_audit.php?articleid='.$o_notice->getArticleId( $i ).'" title="" style="font-size:14px;padding-left:15px">';
			}
			$s_list .= '
						<tr class="TableLine1">
			                <td>
			                    &nbsp;<input id="check_' . ($j + 1) . '" value="' . $o_notice->getArticleId ( $i ) . '" type="checkbox" onclick="selectSingle()">
			                </td>
			                <td align="center" width="200">
			                    '.$o_notice->getDate( $i ).'
			                </td>
			                <td align="center">
			                    '.$o_notice->getUid( $i ).'
			                </td>
			                <td>
			                    '.$s_url.'
			                        ' .$s_title . '</a>
			                </td>
			                <td align="center">
			                   '.$s_auditdate.'
			                </td>
			                <td align="center">
			                    '.$s_username.'
			                </td>
			                <td align="center">
			                    '.$s_state.'
			                </td>
			                <td nowrap="nowrap" style="text-align: center">
			                    '.$s_button.'
			                </td>
			            </tr>
		';
			$j++;
		}
		$s_html = '
			    <table class="small" align="center" border="0" cellpadding="3" cellspacing="0" width="95%">
			        <tbody>
			            <tr>
			                <td class="Big" width="150">
			                    <img src="../../images/newfolder.gif" align="absmiddle">&nbsp;&nbsp;<span class="big3">
			                        留言板管理</span>&nbsp;
			                </td>
			                <td class="small1" align="right" valign="bottom">
							' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" align="center" width="95%">
			        <tbody>
			            <tr class="TableHeader">
			                <td align="center" nowrap="nowrap" style="width: 50px">
			                    选择
			                </td>
			                <td align="center" nowrap="nowrap" style="width: 200px">
			                    留言日期 <img src="../../images/arrow_down.gif" height="10" border="0" width="11">
			                </td>
			                <td align="center" nowrap="nowrap" style="width: 80px">
			                   留言人
			                </td>
			                <td align="center" nowrap="nowrap">
			                    标题
			                </td>
			                <td  style="width: 120px" align="center" nowrap="nowrap" style="width: 150px">
			                    审核日期
			                </td>
			                <td align="center" nowrap="nowrap" style="width: 100px">
			                    审核人
			                </td>
			                <td align="center" nowrap="nowrap" style="width: 100px">
			                    状态
			                </td>
			                <td align="center" nowrap="nowrap" style="width: 100px">
			                    操作
			                </td>
			            </tr>
			           ' . $s_list . '
			            <tr class="TableControl">
			                <td colspan="8">
			                    <input name="allcheck" id="allcheck" onclick="selectAll(this)" type="checkbox"><label
			                        for="allbox_for"/>全选</label>
			                    &nbsp; <a href="javascript:deleteMessages();" title="删除所选留言">
			                        <img src="../../images/delete.gif" align="absMiddle"> 删除所选留言</a>&nbsp;
			                </td>
			            </tr>
			        </tbody>
			    </table>
		';
		return $s_html;
	}
}
?>