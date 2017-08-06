<?php
require_once 'include/db_table.class.php';
require_once 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'include/it_basic.class.php';
class ShowPage extends It_Basic {
	protected $O_SingleUser;
	protected $S_HomePage;
	
	public function __construct($o_singleUser) {
		$this->O_SingleUser = $o_singleUser;
		
		$this->N_PageSize = 20;
	} 
	
	public function getSendList($n_page) {
		$this->S_FileName = 'send.php?owner='.$_GET['owner'].'&start='.$_GET['start'].'&end='.$_GET['end'].'&';
		$this->N_Page = $n_page;
		$o_article = new View_Jiaoliu_Article (); 
		if ($_GET['owner']!='')
		{
			$o_article->PushWhere ( array ('&&', 'Name', 'like','%'.$_GET['owner'].'%') );
		}
		if ($_GET['start']!='')
		{
			$o_article->PushWhere ( array ('&&', 'Date', '>=',$_GET['start']) );
		}
		if ($_GET['end']!='')
		{
			$o_article->PushWhere ( array ('&&', 'Date', '<=',$_GET['end']) );
		}
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
			//return $this->returnNoRecord ( '', '目前没有文章' );
		}
		$o_head .= '    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					        	<tr>					                				                
					                <td class="small1" align="left"  valign="bottom" nowrap="nowrap">
					                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;篇文章&nbsp;&nbsp;&nbsp;&nbsp;
					                    <input class="BigInput" id="Vcl_Owner" style="height: 20px;width:80px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['owner'].'" placeholder="发布人">
					                    &nbsp;&nbsp;
					                    <input class="BigInput" id="Vcl_StartDate" style="height: 20px;width:100px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['start'].'" placeholder="开始日期" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd\'})">
					                    &nbsp;至&nbsp;
					                    <input class="BigInput" id="Vcl_EndDate" style="height: 20px;width:100px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['end'].'" placeholder="结束日期" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd\'})">
					                    &nbsp;&nbsp;
					                    <input class="BigButtonA" onclick="search()" type="button" value="搜索">
					                    &nbsp;&nbsp;
					                    <input class="BigButtonB" onclick="location=\'send.php\'" type="button" value="全部显示">
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
					            <td align="center" nowrap="nowrap">
					                    编号
					                </td>
					                <td align="center" nowrap="nowrap">
					                     学校
					                </td>
					                <td align="center" nowrap="nowrap">
					                     标题
					                </td>
								    <td align="center" nowrap="nowrap">
					                     学校参与人员
					                </td>
								    <td align="center" nowrap="nowrap">
					                     督学参与人员
					                </td>
					                <td align="center" nowrap="nowrap">
					           	发布日期    <img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">   
					                </td>
					                <td align="center" nowrap="nowrap" width="100px">
					           	发布人       
					                </td>
					                <td align="center" nowrap="nowrap" width="250px">
					           	发布单位     
					                </td>
					                <td align="center" nowrap="nowrap" width="120px">
					           	操作    
					                </td>					               
					            </tr>
		';
		
		$o_floor = '
					        </tbody>
					    </table><br/>
							';
		$o_admin=new Single_User($this->O_SingleUser->getUid());
		for($i = 0; $i < $n_count; $i ++) {
			//如果是自己的文章，就显示编辑按钮和勾选框，如果不是，显示为空
			$o_temp=new Single_User($o_article->getUid($i));
			$s_button='';
			if ($o_admin->ValidModule(30009))
			{
			    $s_button = '<a href="send_pdf.php?id=' . $o_article->getId ( $i ) . '" target="_blank">PDF打印</a>';
			}
			if ($this->O_SingleUser->getUid()==$o_article->getUid($i))
			{
				$s_button = '<a href="article_modify.php?id=' . $o_article->getId ( $i ) . '">编辑</a>&nbsp;&nbsp;<a href="send_pdf.php?id=' . $o_article->getId ( $i ) . '" target="_blank">PDF打印</a>&nbsp;&nbsp;<a href="javascript:;" onclick="deleteArticle('.$o_article->getId ( $i ).')" style="color:red">删除</a>';
			}	
			//统计文章数
			$o_number = new Jiaoliu_Article ();
			$o_number->PushWhere ( array ('&&', 'Uid', '=',$o_article->getUid($i)) );
			
			$o_body .= '
		            <tr class="TableLine1">
		            	<td align="center">
		                   ' . $o_article->getId ( $i ) . '
		                </td>
		                <td align="center">
		                   ' . $o_article->getSchoolName ( $i ) . '
		                </td>
		                <td align="center">
		                 <a href="show.php?id=' . $o_article->getId ( $i ) . '" style="font-size:14px"><strong>' . $o_article->getTitle ( $i ) . '</strong></a>
		                </td>	
		                <td align="center">
		                   ' . $o_article->getSchoolJoin ( $i ) . '
		                </td>
		                <td align="center">
		                   ' . $o_article->getDuxueJoin( $i ) . '
		                </td>	                
		                <td align="center">
		                   ' . $o_article->getDate ( $i ) . '
		                </td>
		                <td align="center">
		                  ' . $o_temp->getName ( $i ) . '（'.$o_number->getAllCount().'）
		                </td>
		                <td align="center">
		                  ' . $o_article->getDept ( $i ) . '
		                </td>	
		                <td align="center">
		                  ' . $s_button . '
		                </td>	
		                	                
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}
	public function getFeebackList($n_page) {
		$this->S_FileName = 'feeback.php?';
		$this->N_Page = $n_page;
		$o_article = new Jiaoliu_Article ();
		$o_article->PushWhere ( array ('&&', 'Type', '=', '意见反馈' ) );
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
			return $this->returnNoRecord ( '', '目前没有文章' );
		}
		$o_head .= '    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					        	<tr>					                				                
					                <td class="small1" align="left"  valign="bottom" nowrap="nowrap">
					                   意见反馈 共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;篇文章
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
					             <td align="center" nowrap="nowrap">
					                    编号
					                </td>
					                <td align="center" nowrap="nowrap">
					                     学校
					                </td>
					                <td align="center" nowrap="nowrap">
					                     标题
					                </td>
					                <td align="center" width="200px">
					           	发布日期    <img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">   
					                </td>
					                <td align="center" nowrap="nowrap" width="100px">
					           	发布人       
					                </td>
					                <td align="center" nowrap="nowrap" width="250px">
					           	发布单位     
					                </td>		
					                <td align="center" nowrap="nowrap" width="100px">
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
			$o_temp=new Single_User($o_article->getUid($i));
			$s_button='';
			if ($this->O_SingleUser->getUid()==$o_article->getUid($i))
			{
				$s_button = '<a href="article_modify.php?id=' . $o_article->getId ( $i ) . '">编辑</a>&nbsp;&nbsp;<a href="javascript:;" onclick="deleteArticle('.$o_article->getId ( $i ).')" style="color:red">删除</a>';
			}
			$o_body .= '
		            <tr class="TableLine1">
		            <td align="center">
		                   ' . $o_article->getId ( $i ) . '
		                </td>
		                <td align="center">
		                   ' . $o_article->getSchoolName ( $i ) . '
		                </td>
		                <td align="center">
		                 <a href="show.php?id=' . $o_article->getId ( $i ) . '" style="font-size:14px"><strong>' . $o_article->getTitle ( $i ) . '</strong></a>
		                </td>		                
		                <td align="center">
		                   ' . $o_article->getDate ( $i ) . '
		                </td>
		                <td align="center">
		                  ' . $o_temp->getName ( $i ) . '
		                </td>
		                <td align="center">
		                  ' . $o_article->getDept ( $i ) . '
		                </td>	
		                <td align="center">
		                  ' . $s_button . '
		                </td>	                
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}	
	public function getSummaryList($n_page) {
		$this->N_PageSize = 2000;
		$this->N_Page = $n_page;
		//读取所有责任督学
		$o_type = new View_User_List ();
		if($_GET['owner']!='')
		{
			$o_type->PushWhere ( array ('&&', 'Name', 'like','%'.$_GET['owner'].'%') );
		}
		$o_type->PushWhere ( array ('&&', 'State', '=', 1 ) );
		$o_type->PushWhere ( array ('&&', 'DeptId', '=', 138 ) );
		$o_type->PushOrder ( array ('Name', 'A' ) );
		$n_count=$o_type->getAllCount();
		for($i=0;$i<$n_count;$i++)
		{
			$o_article = new View_Jiaoliu_Article (); 
			$o_article->PushWhere ( array ('&&', 'Uid', '=', $o_type->getUid($i) ) );
			if ($_GET['start']!='')
			{
				$o_article->PushWhere ( array ('&&', 'Date', '>=',$_GET['start']) );
			}
			if ($_GET['end']!='')
			{
				$o_article->PushWhere ( array ('&&', 'Date', '<=',$_GET['end']) );
			}
			$o_body .= '
		            <tr class="TableLine1">
		            	<td align="center">
		                   ' .( $i+1 ) . '
		                </td>
		                <td align="center">
		                   ' . $o_type->getName ( $i ) . '
		                </td>
		                <td align="center">
		                 '.$o_article->getAllCount().'
		                </td>	
		                	                
		            </tr>
			';
		}		
		$o_head .= '    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
					        <tbody>
					        	<tr>					                				                
					                <td class="small1" align="left"  valign="bottom" nowrap="nowrap">
					                    共<span class="big4">&nbsp;' . $n_count . '</span>&nbsp;人&nbsp;&nbsp;&nbsp;&nbsp;
					                    <input class="BigInput" id="Vcl_Owner" style="height: 20px;width:80px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['owner'].'" placeholder="发布人">
					                    &nbsp;&nbsp;
					                    <input class="BigInput" id="Vcl_StartDate" style="height: 20px;width:100px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['start'].'" placeholder="开始日期" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd\'})">
					                    &nbsp;至&nbsp;
					                    <input class="BigInput" id="Vcl_EndDate" style="height: 20px;width:100px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['end'].'" placeholder="结束日期" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd\'})">
					                    &nbsp;&nbsp;
					                    <input class="BigButtonA" onclick="search()" type="button" value="搜索">
					                    &nbsp;&nbsp;
					                    <input class="BigButtonB" onclick="location=\'summary.php\'" type="button" value="全部显示">
					                </td>
					                 <td class="small1" align="right" valign="bottom">
			                		</td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:5px">
					        <tbody>
					            <tr class="TableHeader">
					            <td align="center" nowrap="nowrap">
					                    序号
					                </td>
					                <td align="center" nowrap="nowrap">
					                     发布人
					                </td>
					                <td align="center" nowrap="nowrap">
					                     发布文章数量
					                </td>
								    		               
					            </tr>
		';
		
		$o_floor = '
					        </tbody>
					    </table><br/>
							';		
		return $o_head . $o_body . $o_floor;
	}
}
?>