<?php
require_once 'include/db_table.class.php';
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
	
	public function getList($n_page) {
		$this->S_FileName = 'list.php?';
		$this->N_Page = $n_page;
		$o_article = new Zhenggai_Article ();
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
					                <td align="center" nowrap="nowrap">
					                     标题
					                </td>
					                <td align="center" width="200px">
					           	发布日期    <img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">   
					                </td>
					                <td align="center" width="80px">
					           	类型
					                </td>
					                <td align="center" nowrap="nowrap" width="100px">
					           	发布人       
					                </td>
					                <td align="center" nowrap="nowrap" width="250px">
					           	发送对象     
					                </td>
					                <td align="center" nowrap="nowrap" width="100px">
					           	状态    
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
			$s_status='';
			if ($o_article->getComment ( $i )!='')
			{
				
				$s_status = '<span style="color:green">已读 并反馈</span>';
			}else if ($o_article->getRead ( $i )==1 ){
				$s_status = '<span style="color:green">已读</span>';
			}else{
				$s_status = '<span style="color:red">未读</span>';
			}		
			$o_body .= '
		            <tr class="TableLine1">
		                <td align="center">
		                 <a href="list_show.php?id=' . $o_article->getId ( $i ) . '" style="font-size:14px"><strong>' . $o_article->getTitle ( $i ) . '</strong></a>
		                </td>			                	                
		                <td align="center">
		                   ' . $o_article->getDate ( $i ) . '
		                </td>
		                <td align="center">
		                   ' . $o_article->getType ( $i ) . '
		                </td>
		                <td align="center">
		                  ' . $o_temp->getName ( $i ) . '
		                </td>
		                <td align="center">
		                  ' . $o_article->getDept ( $i ) . '
		                </td>	
		                <td align="center">
		                  ' . $s_status . '
		                </td>	
		                	                
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}
	public function getReadList($n_page) {
		$this->S_FileName = 'read.php?';
		$this->N_Page = $n_page;
		$a_deptid=$this->O_SingleUser->getDeptId();
		$o_article = new Zhenggai_Article ();
		$o_article->PushWhere ( array ('&&', 'DeptId', '=',$a_deptid[0]) );
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
					                <td align="center" nowrap="nowrap">
					                     标题
					                </td>
					                <td align="center" width="200px">
					           	发布日期    <img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">   
					                </td>
					                <td align="center" width="80px">
					           	类型
					                </td>
					                <td align="center" nowrap="nowrap" width="100px">
					           	发布人       
					                </td>
					                <td align="center" nowrap="nowrap" width="180px">
					           	状态    
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
			$s_status='';
			if ($o_article->getComment ( $i )!='')
			{
				
				$s_status = '<span style="color:green">已读 并反馈</span>';
			}else if ($o_article->getRead ( $i )==1 ){
				$s_status = '<span style="color:orange">已读 未反馈<br/>（在通知底部填写反馈信息）</span>';
			}else{
				$s_status = '<span style="color:red">未读</span>';
			}		
			$o_body .= '
		            <tr class="TableLine1">
		                <td align="center">
		                 <a href="read_show.php?id=' . $o_article->getId ( $i ) . '" style="font-size:14px"><strong>' . $o_article->getTitle ( $i ) . '</strong></a>
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
		                  ' . $s_status . '
		                </td>	              
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}	
	
}
?>