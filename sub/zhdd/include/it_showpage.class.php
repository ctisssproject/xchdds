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
	
	public function getAppraiseResultList($n_page) {
		$this->S_FileName = 'appraise_manage_result_list.php?id='.$_GET['id'].'&owner='.$_GET['owner'];
		$this->N_Page = $n_page;
		$o_article = new Zhdd_Appraise_Answers_View (); 
		if ($_GET['owner']!='')
		{
			$o_article->PushWhere ( array ('&&', 'SchoolName', 'like','%'.$_GET['owner'].'%') );
			$o_article->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['id']) );
			$o_article->PushWhere ( array ('||', 'OwnerName', 'like','%'.$_GET['owner'].'%') );
			$o_article->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['id']) );
		}
		$o_article->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['id']) );
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
		//构建标题
		if ($n_count>0)
		{
			$a_vcl=json_decode($o_article->getAppraiseInfo(0));
		}
		$s_title='';
		for($i=0;$i<count($a_vcl);$i++)
		{
			$s_title.='<td align="center" nowrap="nowrap">
					                     '.rawurldecode($a_vcl[$i]).'
					   </td>';
		}
		$o_head .= '    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%" style="margin-top:5px;margin-left:1%;margin-right:1%;">
					        <tbody>
					        	<tr>					                				                
					                <td class="small1" align="left"  valign="bottom" nowrap="nowrap">
					                <input value="返回" class="BigButtonA" onclick="location=\''.str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']).'appraise_manage.php\'" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;个评价&nbsp;&nbsp;&nbsp;&nbsp;
					                    <input class="BigInput" id="Vcl_Owner" style="height: 20px;width:200px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['owner'].'" placeholder="学校名称/评价人">
					                    <input class="BigButtonA" onclick="search()" type="button" value="搜索">
					                    &nbsp;&nbsp;
					                    <input class="BigButtonB" onclick="location=\'appraise_manage_result_list.php?id='.$_GET['id'].'\'" type="button" value="全部显示">
					                </td>
					                 <td class="small1" align="right" valign="bottom" style="width:330px">
										' . $s_pagebutton . '
			                		</td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:5px;margin-left:1%;margin-right:1%;">
					        <tbody>
					            <tr class="TableHeader">
					            <td align="center" nowrap="nowrap">
					                    评价日期 <img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap">
					                     学校名称
					                </td>	
					                '.$s_title.'				                
					                <td align="center" nowrap="nowrap" width="250px">
					           	评价人     
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
			$s_button = '<a href="appraise_manage_result_list_view.php?id=' . $o_article->getId ( $i ) . '">查看</a>';	
			$a_date=explode(' ', $o_article->getDate ( $i ));
			$a_vcl=json_decode($o_article->getInfo($i));
			$s_title='';
			for($j=0;$j<count($a_vcl);$j++)
			{
				$s_title.='<td align="center">
						   		'.rawurldecode($a_vcl[$j]).'
						   </td>';
			}
			$o_body .= '
		            <tr class="TableLine1">
		            	<td align="center">
		                   ' . $o_article->getDate ( $i ) . '
		                </td>
		                <td align="center">
		                   <b>' . $o_article->getSchoolName ( $i ) . '</b>
		                </td>	
		                '.$s_title.'	                
		                <td align="center">
		                  ' . $o_article->getOwnerName ( $i ) . '
		                </td>	
		                <td align="center">
		                  ' . $s_button . '
		                </td>	
		                	                
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}
	
	}
?>