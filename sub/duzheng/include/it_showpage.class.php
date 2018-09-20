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
		$this->S_FileName = 'appraise_manage_result_list.php?id='.$_GET['id'].'&owner='.$_GET['owner'].'&schoolname='.$_GET['schoolname'].'&year='.$_GET['year'].'&';
		$this->N_Page = $n_page;
		$o_article = new Dz_Appraise_Answers_View (); 
		if ($_GET['owner']!='')
		{
			$o_article->PushWhere ( array ('&&', 'OwnerName', 'like','%'.$_GET['owner'].'%') );
			$o_article->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['id']) );
		}
		if ($_GET['year']!='')
		{
			$o_article->PushWhere ( array ('&&', 'Date', '>=',$_GET['year'].'-01-01') );
			$o_article->PushWhere ( array ('&&', 'Date', '<=',$_GET['year'].'-12-31') );
			$o_article->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['id']) );
		}
		if ($_GET['schoolname']!='')
		{
			$o_article->PushWhere ( array ('&&', 'SchoolName', 'like','%'.$_GET['schoolname'].'%') );
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
		$n_last_question=0;
		//构建标题
		if ($n_count>0)
		{
			$a_vcl=json_decode($o_article->getAppraiseInfo(0));
			$o_questions=new Dz_Appraise_Questions($o_article->getAppraiseId(0));
			$o_questions->PushWhere ( array ('&&', 'AppraiseId', '=',$o_article->getAppraiseId(0)) );
			$n_last_question=$o_questions->getAllCount();
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
					                    <select id="Vcl_Year" class="BigSelect">
											<option value="">年份</option>
											<option value="2018">2018</option>
											<option value="2019">2019</option>
											<option value="2020">2020</option>
											<option value="2021">2021</option>
											<option value="2022">2022</option>
										</select>
										<script>
											$("#Vcl_Year").val("'.$_GET['year'].'");
										</script>
										<input class="BigInput" id="Vcl_SchoolName" style="height: 20px;width:100px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['schoolname'].'" placeholder="学校名称">
										<input style="display:none" class="BigInput" id="Vcl_Owner" style="height: 20px;width:60px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['owner'].'" placeholder="评价人">
					                    <input class="BigButtonA" onclick="search()" type="button" value="搜索">
					                    &nbsp;&nbsp;
					                    <input class="BigButtonB" onclick="location=\'appraise_manage_result_list.php?id='.$_GET['id'].'\'" type="button" value="全部显示">
										&nbsp;&nbsp;
										<input class="BigButtonC" onclick="location=\'appraise_manage_result_list_output.php?id='.$_GET['id'].'&owner='.$_GET['owner'].'&schoolname='.$_GET['schoolname'].'&year='.$_GET['year'].'\'" type="button" value="导出当前记录">
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
									<td align="center" nowrap="nowrap" width="80px">
					           	综合评价    
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
			//获取
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
			$s_last_anwser='';
			eval('$s_last_anwser=$o_article->getAnswer'.$n_last_question.'($i);');
			$s_last_anwser=str_replace('"', '', $s_last_anwser);//去掉多余的双引号
			$o_option=new Dz_Appraise_Options($s_last_anwser);
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
		                  '.$o_option->getNumber().'
		                </td>	
		                <td align="center">
		                  ' . $s_button . '
		                </td>	
		                	                
		            </tr>
			';
		}
		return $o_head . $o_body . $o_floor;
	}
	public function getAppraiseTotalList($n_page) {
		$this->S_FileName = 'appraise_manage_total_list.php?id='.$_GET['id'].'&owner='.$_GET['owner'];
		$this->N_Page = $n_page;
		$o_article = new Dz_Appraise_Answers_View ();
		if ($_GET['owner']!='')
		{
			$o_article->PushWhere ( array ('&&', 'SchoolName', 'like','%'.$_GET['owner'].'%') );
			$o_article->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['id']) );
		}
		$o_article->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['id']) );
		//按学校名称后，按年度排序
		$o_article->PushOrder ( array ('Date', 'D' ) );			
		$n_count = $o_article->getAllCount ();
		////////////////////////////////////
		$o_body = '';
		$o_floor = '';
		
		$o_head .= '    <table class="small" align="center" border="0" cellpadding="0" cellspacing="0" width="98%" style="margin-top:5px;margin-left:1%;margin-right:1%;">
					        <tbody>
					        	<tr>
					                <td class="small1" align="left"  valign="bottom" nowrap="nowrap">
					                <input value="返回" class="BigButtonA" onclick="location=\''.str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']).'appraise_manage.php\'" type="button" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					                    <input class="BigInput" id="Vcl_Owner" style="height: 20px;width:200px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['owner'].'" placeholder="学校名称">
					                    <input class="BigButtonA" onclick="search()" type="button" value="搜索">
					                    &nbsp;&nbsp;
					                    <input class="BigButtonB" onclick="location=\'appraise_manage_total_list.php?id='.$_GET['id'].'\'" type="button" value="全部显示">
					                </td>
					                 <td class="small1" align="right" valign="bottom" style="width:330px">
										
			                		</td>
					            </tr>
					        </tbody>
					    </table>
					    <table class="TableList" align="center" width="98%" style="margin-top:5px;margin-left:1%;margin-right:1%;">
					        <tbody>
					            <tr class="TableHeader">
					            <td align="center" nowrap="nowrap" width="160px">
					                                        年度<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle"> 
					                </td>
					                <td align="center" nowrap="nowrap">
					                                         学校名称
					                </td>
					                <td align="center" nowrap="nowrap" width="160px">
					           	操作
					                </td>
					            </tr>
		';
		
		$o_floor = '
					        </tbody>
					    </table><br/>
							';
		$o_admin=new Single_User($this->O_SingleUser->getUid());
		$s_school_name='';
		$s_year='';
		for($i = 0; $i < $n_count; $i ++) {		
			$a_date=explode(' ', $o_article->getDate ( $i ));
			$a_date=explode('-', $a_date[0]);
			if ($o_article->getSchoolName ( $i )==$s_school_name && $a_date[0]==$s_year)
			{
				continue;
			}			
			$s_school_name=$o_article->getSchoolName ( $i );
			$s_year=$a_date[0];
			$s_button = '<a href="appraise_manage_total_list_pdf.php?school_id=' . $o_article->getSchoolId ( $i ) . '&year='.$s_year.'&appraise_id='.$o_article->getAppraiseId($i).'">查看统计结果（PDF）</a>';	
			$o_body .= '
		            <tr class="TableLine1">
		            	<td align="center">
		                   <b>' . $a_date[0] . '</b>
		                </td>
		                <td align="center">
		                   <b>' . $o_article->getSchoolName ( $i ) . '</b>
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