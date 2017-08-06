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
	public function getFromList($n_page) {
		$this->S_FileName = 'from.php?';
		$this->N_Page = $n_page;
		$o_user = new GPDD_Wenti ();
		$o_user->PushWhere ( array ('&&', 'OwnerId', '=', $this->O_SingleUser->getUid() ) );
		$o_user->PushWhere ( array ('&&', 'State', '=', 0) );
		$o_user->PushOrder ( array ('State', 'A' ) );
		$o_user->PushOrder ( array ('Date', 'D' ) );
		$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();
		$n_count = $o_user->getCount ();
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		for($i = 0; $i < $n_count; $i ++) {		
			//分析状态
			$s_state='';
			$s_button='<a href="javascript:;" onclick="handle_classify('.$o_user->getId( $i ).')">问题分类</a>';		
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" nowrap="nowrap">
					                     ' . $o_user->getDate( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getName( $i ).'
					                </td>
					                <td align="center">
					                  ' . $o_user->getPhone ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getSchoolName( $i ).'
					                </td>
					                <td align="center" nowrap="nowrap">
					                   ' . $o_user->getProfile ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getContent( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                   ' . $o_user->getFrom ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$s_button.'
					                </td>
					            </tr>
			';
		}
		$s_html = '		
		 		<div class="PageHeader" style="padding-top:0px;">
			        <div class="title">
			            <span class="big3">来源受理列表</span>&nbsp;<input value="发起问题" class="BigButtonB" onclick="location=\'open.php\'" type="button" /></div>
			    </div>		    
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;条记录
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center" nowrap="nowrap">
					                    日期 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap">
					                   姓名
					                </td>
					                <td align="center" nowrap="nowrap">
					                   电话 
					                </td>
					                <td align="center" nowrap="nowrap">
					                   学校名称
					                </td>
					                <td align="center" nowrap="nowrap">
					                  身份
					                </td>
					                <td align="center" nowrap="nowrap">
					                  内容
					                </td>
					                <td align="center" nowrap="nowrap">
					                  来源
					                </td>
					                <td align="center" width="120">
					                    操作
					                </td>
					            </tr>
					        </thead>
			        <tbody>
						' . $s_record_list . '
			        </tbody>
			    </table>
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-top:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <br />
		
		';
		return $s_html;
	}
	public function getRecordList($n_page) {
		$this->S_FileName = 'handle.php?';
		$this->N_Page = $n_page;
		$o_user = new GPDD_Wenti ();
		$o_user->PushWhere ( array ('&&', 'OwnerId', '=', $this->O_SingleUser->getUid() ) );
		$o_user->PushWhere ( array ('&&', 'State', '>', 0) );
		$o_user->PushWhere ( array ('&&', 'State', '<', 10) );
		$o_user->PushOrder ( array ('State', 'A' ) );
		$o_user->PushOrder ( array ('Date', 'D' ) );
		$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();
		$n_count = $o_user->getCount ();
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		for($i = 0; $i < $n_count; $i ++) {		
			//分析状态
			$s_state='';
			$s_button='';
			switch ($o_user->getState($i))
			{
				case 1:
					$s_state='<span style="color:#FF6600">等待处理</span>';
					$s_button='<a href="handle_feedback.php?id='.$o_user->getId( $i ).'">马上处理</a>&nbsp;&nbsp;<a href="javascript:;" onclick="handle_arrange('.$o_user->getId( $i ).')">分配</a>';
					break;
				case 2:
					$s_state='<span style="color:#0066CC">等待学校处理</span>';
					break;
				case 3:
					$s_state='<span style="color:#0066CC">等待业务科室处理</span>';
					break;
				case 9:
					$s_state='<span style="color:#FF6600">已处理，待确认</span>';
					$s_button='<a href="handle_show.php?id='.$o_user->getId( $i ).'">马上确认</a>';
					break;
				case 10:
					$s_state='<span style="color:#009900">已解决</span>';
					break;
				default:
					break;
			}			
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" nowrap="nowrap">
					                     ' . $s_state . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getDate( $i ).'
					                </td>
					                <td align="center">
					                  ' . $o_user->getName ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getPhone ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getSchoolName ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getProfile ( $i ) . '
					                </td>
					                <td align="center">
					                 ' . $this->SearchResultAddRed1($o_user->getContent( $i ),'', 300) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                   ' . $o_user->getFrom ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getTypeName ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$s_button.'
					                </td>
					            </tr>
			';
		}
		$s_html = '	
				<div class="PageHeader" style="padding-top:0px;">
			        <div class="title">
			            <span class="big3">协同办理列表</span></div>
			    </div>			    
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;条记录
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center" nowrap="nowrap">
					                    状态 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap">
					                   日期
					                </td>
					                <td align="center" nowrap="nowrap">
					                   姓名
					                </td>
					                <td align="center" nowrap="nowrap">
					                   电话 
					                </td>
					                <td align="center" nowrap="nowrap">
					                   学校名称
					                </td>
					                <td align="center" nowrap="nowrap">
					                  身份
					                </td>
					                <td align="center" nowrap="nowrap">
					                  内容
					                </td>
					                <td align="center" nowrap="nowrap">
					                  来源
					                </td>
					                <td align="center" nowrap="nowrap">
					                  问题类型
					                </td>
					                <td align="center" width="120">
					                    操作
					                </td>
					            </tr>
					</thead>
			        <tbody>
						' . $s_record_list . '
			        </tbody>
			    </table>
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-top:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <br />
		
		';
		return $s_html;
	}
	public function getOfficeList($n_page) {
		$this->S_FileName = 'office.php?';
		$this->N_Page = $n_page;
		$o_user = new GPDD_Wenti ();
		$o_user->PushWhere ( array ('&&', 'State', '=', 3) );
		$o_user->PushOrder ( array ('State', 'A' ) );
		$o_user->PushOrder ( array ('Date', 'D' ) );
		$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();
		$n_count = $o_user->getCount ();
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		for($i = 0; $i < $n_count; $i ++) {		
			//分析状态
			$s_state='<span style="color:#FF6600">等待处理</span>';
			$s_button='<a href="'.RELATIVITY_PATH.'sub/telephone/dudao_print.php?id=' . $o_user->getId ( $i ) . '" target="blank">打印</a>&nbsp;&nbsp;<a href="'.RELATIVITY_PATH.'sub/telephone/dudao_modify.php?id='.$o_user->getId ( $i ) . '">录入信息</a>';
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" nowrap="nowrap">
					                     ' . $s_state . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getDate( $i ).'
					                </td>
					                <td align="center">
					                  ' . $o_user->getName ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getPhone ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getSchoolName ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getProfile ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $this->SearchResultAddRed1($o_user->getContent( $i ),'', 300) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                   ' . $o_user->getFrom ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getTypeName ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getOwnerName ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$s_button.'
					                </td>
					            </tr>
			';
		}
		$s_html = '	
				<div class="PageHeader" style="padding-top:0px;">
			        <div class="title">
			            <span class="big3">业务科室待处理</span></div>
			    </div>		    
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;条待处理记录
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center" nowrap="nowrap">
					                    状态 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap">
					                   日期
					                </td>
					                <td align="center" nowrap="nowrap">
					                   姓名
					                </td>
					                <td align="center" nowrap="nowrap">
					                   电话 
					                </td>
					                <td align="center" nowrap="nowrap">
					                   学校名称
					                </td>
					                <td align="center" nowrap="nowrap">
					                  身份
					                </td>
					                <td align="center" nowrap="nowrap">
					                  内容
					                </td>
					                <td align="center" nowrap="nowrap">
					                  来源
					                </td>
					                <td align="center" nowrap="nowrap">
					                  问题类型
					                </td>
					                <td align="center" nowrap="nowrap">
					                  督导
					                </td>
					                <td align="center" width="120">
					                    操作
					                </td>
					            </tr>
					</thead>
			        <tbody>
						' . $s_record_list . '
			        </tbody>
			    </table>
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-top:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <br />
		
		';
		return $s_html;
	}
	public function getSchool($n_page) {
		$this->S_FileName = 'school.php?';
		$this->N_Page = $n_page;
		$o_user = new GPDD_Wenti ();
		$o_user->PushWhere ( array ('&&', 'State', '=', 2) );
		//获取该用户的部门编号
		$a_dept=$this->O_SingleUser->getDeptId();
		$o_user->PushWhere ( array ('&&', 'SchoolId', '=', $a_dept[0]) );
		$o_user->PushOrder ( array ('State', 'A' ) );
		$o_user->PushOrder ( array ('Date', 'D' ) );
		$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();
		$n_count = $o_user->getCount ();
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		for($i = 0; $i < $n_count; $i ++) {		
			//分析状态
			$o_duxue=new Base_User_Info_Custom($o_user->getOwnerId( $i ));
			$s_state='<span style="color:#FF6600">等待处理</span>';
			$s_button='<a href="school_feedback.php?id='.$o_user->getId( $i ).'">马上处理</a>';
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getDate( $i ).'
					                </td>
					                <td align="center">
					                  ' . $o_user->getSchoolName ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    ' . $this->SearchResultAddRed1($o_user->getContent( $i ),'', 300) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getOwnerName( $i ).'
					                </td>
					                <td align="center" nowrap="nowrap">
					                   ' . $o_duxue->getMobilePhone ( ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getTypeName ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                   ' . $o_user->getFrom ( $i ) . '
					                </td>					                
					                <td align="center" nowrap="nowrap">
					                    '.$s_button.'
					                </td>
					            </tr>
			';
		}
		$s_html = '		
				<div class="PageHeader" style="padding-top:0px;">
			        <div class="title">
			            <span class="big3">学校处理列表</span></div>
			    </div>	    
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;条待处理记录
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center" nowrap="nowrap">
					                   日期
					                </td>
					                <td align="center" nowrap="nowrap">
					                   学校名称 
					                </td>
					                <td align="center" nowrap="nowrap">
					                   问题内容
					                </td>
					                <td align="center" nowrap="nowrap">
					                  督学
					                </td>
					                <td align="center" nowrap="nowrap">
					                  督学电话
					                </td>
					                <td align="center" nowrap="nowrap">
					                  问题类型
					                </td>
					                <td align="center" nowrap="nowrap">
					                  来源
					                </td>
					                <td align="center" width="120">
					                    操作
					                </td>
					            </tr>
					        </thead>
			        <tbody>
						' . $s_record_list . '
			        </tbody>
			    </table>
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-top:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <br />
		
		';
		return $s_html;
	}
		public function getCompletedList($n_page) {
		$this->S_FileName = 'Completed.php?';
		$this->N_Page = $n_page;
		$o_user = new GPDD_Wenti ();
		$o_user->PushWhere ( array ('&&', 'State', '=', 10) );
		$o_user->PushOrder ( array ('State', 'A' ) );
		$o_user->PushOrder ( array ('Date', 'D' ) );
		$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();
		$n_count = $o_user->getCount ();
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		for($i = 0; $i < $n_count; $i ++) {		
			//分析状态
			$s_state='';
			$s_button='<a href="completed_show.php?id='.$o_user->getId( $i ).'">查看</a>';
			switch ($o_user->getState($i))
			{
				case 1:
					$s_state='<span style="color:#FF6600">等待处理</span>';
					break;
				case 2:
					$s_state='<span style="color:#0066CC">等待学校处理</span>';
					break;
				case 3:
					$s_state='<span style="color:#0066CC">等待业务科室处理</span>';
					break;
				case 9:
					$s_state='<span style="color:#FF6600">已处理，待确认</span>';
					break;
				case 10:
					$s_state='<span style="color:#009900">已完成</span>';
					break;
				default:
					break;
			}			
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" nowrap="nowrap">
					                     ' . $s_state . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getDate( $i ).'
					                </td>
					                <td align="center">
					                  ' . $o_user->getName ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getPhone ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getSchoolName ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getProfile ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $this->SearchResultAddRed1($o_user->getContent( $i ),'', 300) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                   ' . $o_user->getFrom ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getTypeName ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $o_user->getResolveDate ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$s_button.'
					                </td>
					            </tr>
			';
		}
		$s_html = '		
				<div class="PageHeader" style="padding-top:0px;">
			        <div class="title">
			            <span class="big3">完成问题列表</span></div>
			    </div>		    
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;条记录
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
						<thead class="TableHeader">
					            <tr>
					                <td align="center" nowrap="nowrap">
					                    状态 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap">
					                   日期
					                </td>
					                <td align="center" nowrap="nowrap">
					                   姓名
					                </td>
					                <td align="center" nowrap="nowrap">
					                   电话 
					                </td>
					                <td align="center" nowrap="nowrap">
					                   学校名称
					                </td>
					                <td align="center" nowrap="nowrap">
					                  身份
					                </td>
					                <td align="center" nowrap="nowrap">
					                  内容
					                </td>
					                <td align="center" nowrap="nowrap">
					                  来源
					                </td>
					                <td align="center" nowrap="nowrap">
					                  问题类型
					                </td>
					                <td align="center" nowrap="nowrap">
					                  完成时间
					                </td>
					                <td align="center" width="120">
					                    操作
					                </td>
					            </tr>
					</thead>
			        <tbody>
						' . $s_record_list . '
			        </tbody>
			    </table>
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-top:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <br />
		
		';
		return $s_html;
	}	
	public function getZcTaskList($n_page) {
		$this->S_FileName = 'gpdd_zc_task.php?owner='.$_GET['owner'].'&start='.$_GET['start'].'&end='.$_GET['end'].'&schoolname='.$_GET['schoolname'].'&read='.$_GET['read'].'&';
		$this->N_Page = $n_page;
		$o_user = new GPDD_Zc ();
		if ($_GET['owner']!='')
		{
			$o_user->PushWhere ( array ('&&', 'OwnerName', 'like','%'.$_GET['owner'].'%') );
			if ($this->O_SingleUser->ValidModule(30024)==false)
			{
				$o_user->PushWhere ( array ('&&', 'OwnerId', '=', $this->O_SingleUser->getUid() ) );
			}		
			$o_user->PushWhere ( array ('&&', 'State', '<', 4) );
		}
		if ($_GET['schoolname']!='')
		{
			$o_user->PushWhere ( array ('&&', 'SchoolName', 'like','%'.$_GET['schoolname'].'%') );
			if ($this->O_SingleUser->ValidModule(30024)==false)
			{
				$o_user->PushWhere ( array ('&&', 'OwnerId', '=', $this->O_SingleUser->getUid() ) );
			}		
			$o_user->PushWhere ( array ('&&', 'State', '<', 4) );
		}
		if ($_GET['read']!='')
		{
			$o_user->PushWhere ( array ('&&', 'Read', 'like','%'.$_GET['read'].'%') );
			if ($this->O_SingleUser->ValidModule(30024)==false)
			{
				$o_user->PushWhere ( array ('&&', 'OwnerId', '=', $this->O_SingleUser->getUid() ) );
			}		
			$o_user->PushWhere ( array ('&&', 'State', '<', 4) );
		}
		if ($_GET['start']!='')
		{
			$o_user->PushWhere ( array ('&&', 'Date', '>=',$_GET['start']) );
			if ($this->O_SingleUser->ValidModule(30024)==false)
			{
				$o_user->PushWhere ( array ('&&', 'OwnerId', '=', $this->O_SingleUser->getUid() ) );
			}		
			$o_user->PushWhere ( array ('&&', 'State', '<', 4) );
		}
		if ($_GET['end']!='')
		{
			$o_user->PushWhere ( array ('&&', 'Date', '<=',$_GET['end']) );
			
		}
		if ($this->O_SingleUser->ValidModule(30024)==false)
		{
			$o_user->PushWhere ( array ('&&', 'OwnerId', '=', $this->O_SingleUser->getUid() ) );
		}		
		$o_user->PushWhere ( array ('&&', 'State', '<', 4) );
		
		
		
		$o_user->PushOrder ( array ('State', 'D' ) );
		$o_user->PushOrder ( array ('Date', 'D' ) );
		$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();
		$n_count = $o_user->getCount ();
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		for($i = 0; $i < $n_count; $i ++) {		
			$s_button='<a href="gpdd_zc_show.php?id='.$o_user->getId( $i ).'">详情</a>';	
			//
			$s_read='';
			//分析状态
			switch ($o_user->getState($i))
			{
				case 1:
					$s_state='<span style="color:#FF6600">等待学校反馈</span>';
					if ($o_user->getRead($i)==0)
					{
						$s_read='<span style="color:#FF6600">学校未读</span>';
					}else{
						$s_read='<span style="color:#009900">学校已读</span>';
					}
					break;
				case 2:
					$s_state='<span style="color:#FF6600">等待科室确认</span>';
					if ($this->O_SingleUser->ValidModule(30024))
					{
						$s_button='<a href="gpdd_zc_task_confirm.php?id='.$o_user->getId( $i ).'">马上确认</a>';		
					}
					break;
				case 3:
					$s_state='<span style="color:#FF0000">已退回</span>';
					break;
				default:
					break;
			}	
			if ($this->O_SingleUser->ValidModule(30030))
			{
				$s_button.='&nbsp;&nbsp;<a href="javascript:;" onclick="zc_delete('.$o_user->getId( $i ).')">删除</a>';	
			}
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" nowrap="nowrap">
					                     ' . $o_user->getDate( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    <a href="gpdd_zc_show.php?id='.$o_user->getId( $i ).'" style="font-size:14px"><strong>'.$o_user->getTitle( $i ).'</strong></a>
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getSchoolName( $i ).' '.$s_read.' 
					                </td>
					                <td align="center">
					                  ' . $o_user->getOwnerName ( $i ) . '
					                </td>
					                <td>
					                  ' . $this->SearchResultAddRed1($o_user->getContent( $i ),'', 300) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                   ' . $s_state . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$s_button.'
					                </td>
					            </tr>
			';
		}
		if ($this->O_SingleUser->ValidModule(30024))
		{
			$s_open='&nbsp;<input value="发起自查" class="BigButtonB" onclick="location=\'gpdd_zc_add.php\'" type="button" />';
		}
		$s_html = '		
		 		<div class="PageHeader" style="padding-top:0px;">
			        <div class="title">
			            <span class="big3">自查任务列表</span>'.$s_open.'</div>
			    </div>		    
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;条记录
			                    &nbsp;&nbsp;&nbsp;&nbsp;
			                    <input class="BigInput" id="Vcl_Owner" style="height: 20px;width:60px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['owner'].'" placeholder="发布人">
					                    &nbsp;&nbsp;
					                    <input class="BigInput" id="Vcl_SchoolName" style="height: 20px;width:100px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['schoolname'].'" placeholder="学校名称">
					                    &nbsp;&nbsp;
					                    <input class="BigInput" id="Vcl_StartDate" style="height: 20px;width:80px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['start'].'" placeholder="开始日期" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd\'})">
					                    &nbsp;至&nbsp;
					                    <input class="BigInput" id="Vcl_EndDate" style="height: 20px;width:80px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['end'].'" placeholder="结束日期" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd\'})">
					                    &nbsp;&nbsp;
					                    <select id="Vcl_Read" class="BigSelect">
					                    	<option value="">全部</option>
					                    	<option value="1">学校已读</option>
					                    	<option value="0">学校未读</option>
					                    </select>		
					                    <script type="text/javascript" language="javascript">
					                    $("#Vcl_Read").val("'.$_GET['read'].'");
					                    </script>                    
					                    &nbsp;&nbsp;
					                    <input class="BigButtonA" onclick="search()" type="button" value="搜索">
					                    &nbsp;&nbsp;
					                    <input class="BigButtonB" onclick="location=\'gpdd_zc_task.php\'" type="button" value="全部显示">
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center" nowrap="nowrap" style="width:90px;">
					                    日期 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap">
					                  标题
					                </td>
					                <td align="center" nowrap="nowrap" style="width:120px;">
					                  学校名称
					                </td>
					                <td align="center" nowrap="nowrap" style="width:80px;">
					                   责任督学 
					                </td>
					                <td align="center" nowrap="nowrap">
					                  内容
					                </td>
					                <td align="center" nowrap="nowrap" style="width:100px;">
					                  状态
					                </td>
					                <td align="center" width="120">
					                    操作
					                </td>
					            </tr>
					        </thead>
			        <tbody>
						' . $s_record_list . '
			        </tbody>
			    </table>
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-top:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <br />
		
		';
		return $s_html;
	}
	public function getZcCompletedList($n_page) {
		$this->S_FileName = 'gpdd_zc_completed.php?owner='.$_GET['owner'].'&start='.$_GET['start'].'&end='.$_GET['end'].'&schoolname='.$_GET['schoolname'].'&';
		$this->N_Page = $n_page;
		$o_user = new GPDD_Zc ();	
		if ($_GET['owner']!='')
		{
			$o_user->PushWhere ( array ('&&', 'OwnerName', 'like','%'.$_GET['owner'].'%') );	
		}
		if ($_GET['schoolname']!='')
		{
			$o_user->PushWhere ( array ('&&', 'SchoolName', 'like','%'.$_GET['schoolname'].'%') );		
		}
		if ($_GET['start']!='')
		{
			$o_user->PushWhere ( array ('&&', 'Date', '>=',$_GET['start']) );	
		}
		if ($_GET['end']!='')
		{
			$o_user->PushWhere ( array ('&&', 'Date', '<=',$_GET['end']) );
		}
		$o_user->PushWhere ( array ('&&', 'State', '=', 4) );
		$o_user->PushOrder ( array ('Date', 'D' ) );
		$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();
		$n_count = $o_user->getCount ();
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		for($i = 0; $i < $n_count; $i ++) {		
				
			//分析状态
			switch ($o_user->getState($i))
			{
				case 1:
					$s_state='<span style="color:#FF6600">等待学校反馈</span>';
					break;
				case 2:
					$s_state='<span style="color:#FF6600">等待科室确认</span>';
					if ($this->O_SingleUser->ValidModule(30024))
					{
						$s_button='<a href="gpdd_zc_task_confirm.php?id='.$o_user->getId( $i ).'">马上确认</a>';		
					}
					break;
				case 3:
					$s_state='<span style="color:green">已退回</span>';
					break;
				default:
					break;
			}	
			$s_button='<a href="gpdd_zc_show.php?id='.$o_user->getId( $i ).'">详情</a>';	
			$s_state='<span style="color:green">已完成</span>';
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" nowrap="nowrap">
					                     ' . $o_user->getDate( $i ) . '
					                </td>
					                <td align="center">
					                    <a href="gpdd_zc_show.php?id='.$o_user->getId( $i ).'" style="font-size:14px"><strong>'.$o_user->getTitle( $i ).'</strong></a>
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getSchoolName( $i ).'
					                </td>
					                <td align="center">
					                  ' . $o_user->getOwnerName ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $this->SearchResultAddRed1($o_user->getContent( $i ),'', 300) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                   ' . $s_state . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$s_button.'
					                </td>
					            </tr>
			';
		}
		$s_html = '		
		 		<div class="PageHeader" style="padding-top:0px;">
			        <div class="title">
			            <span class="big3">自查已完成列表</span></div>
			    </div>		    
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;条记录
			                    &nbsp;&nbsp;&nbsp;&nbsp;
			                    <input class="BigInput" id="Vcl_Owner" style="height: 20px;width:60px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['owner'].'" placeholder="发布人">
					                    &nbsp;&nbsp;
					                    <input class="BigInput" id="Vcl_SchoolName" style="height: 20px;width:100px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['schoolname'].'" placeholder="学校名称">
					                    &nbsp;&nbsp;
					                    <input class="BigInput" id="Vcl_StartDate" style="height: 20px;width:80px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['start'].'" placeholder="开始日期" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd\'})">
					                    &nbsp;至&nbsp;
					                    <input class="BigInput" id="Vcl_EndDate" style="height: 20px;width:80px; font-size: 14px;" type="text" size="80" maxlength="50" value="'.$_GET['end'].'" placeholder="结束日期" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd\'})">
					                    &nbsp;&nbsp;
					                    <input class="BigButtonA" onclick="search()" type="button" value="搜索">
					                    &nbsp;&nbsp;
					                    <input class="BigButtonB" onclick="location=\'gpdd_zc_completed.php\'" type="button" value="全部显示">
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center" nowrap="nowrap" style="width:90px;">
					                    日期 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap">
					                  标题
					                </td>
					                <td align="center" nowrap="nowrap" style="width:120px;">
					                  学校名称
					                </td>
					                <td align="center" nowrap="nowrap" style="width:80px;">
					                   责任督学 
					                </td>
					                <td align="center" nowrap="nowrap">
					                  内容
					                </td>
					                <td align="center" nowrap="nowrap" style="width:100px;">
					                  状态
					                </td>
					                <td align="center" width="120">
					                    操作
					                </td>
					            </tr>
					        </thead>
			        <tbody>
						' . $s_record_list . '
			        </tbody>
			    </table>
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-top:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <br />
		
		';
		return $s_html;
	}
	public function getZcFeedbackList($n_page) {
		$this->S_FileName = 'gpdd_zc_feedback.php?';
		$this->N_Page = $n_page;
		$o_user = new GPDD_Zc ();
		$a_deptid=$this->O_SingleUser->getDeptId();
		$o_user->PushWhere ( array ('&&', 'SchoolId', '=', $a_deptid[0] ) );	
		$o_user->PushWhere ( array ('&&', 'State', '<', 4) );
		$o_user->PushOrder ( array ('State', 'A' ) );
		$o_user->PushOrder ( array ('Date', 'D' ) );
		$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();
		$n_count = $o_user->getCount ();
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		for($i = 0; $i < $n_count; $i ++) {		
			//分析状态
			switch ($o_user->getState($i))
			{
				case 1:
					$s_state='<span style="color:#FF6600">等待学校反馈</span>';
					$s_button='<a href="gpdd_zc_feedback_handle.php?id='.$o_user->getId( $i ).'">反馈</a>';	
					break;
				case 2:
					$s_state='<span style="color:#FF6600">等待科室确认</span>';
					$s_button='';
					break;
				case 3:
					$s_state='<span style="color:#FF0000">已退回</span>';
					$s_button='<a href="gpdd_zc_feedback_handle.php?id='.$o_user->getId( $i ).'">反馈</a>';	
					break;
				default:
					break;
			}	
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" nowrap="nowrap">
					                     ' . $o_user->getDate( $i ) . '
					                </td>
					                <td align="center">
					                    <a href="gpdd_zc_show.php?id='.$o_user->getId( $i ).'" style="font-size:14px"><strong>'.$o_user->getTitle( $i ).'</strong></a>
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getSchoolName( $i ).'
					                </td>
					                <td align="center">
					                  ' . $o_user->getOwnerName ( $i ) . '
					                </td>
					                <td align="center">
					                 ' . $this->SearchResultAddRed1($o_user->getContent( $i ),'', 300) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                   ' . $s_state . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$s_button.'
					                </td>
					            </tr>
			';
		}
		$s_html = '		
		 		<div class="PageHeader" style="padding-top:0px;">
			        <div class="title">
			            <span class="big3">自查等待处理列表</span></div>
			    </div>		    
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;条记录
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center" nowrap="nowrap" style="width:90px;">
					                    日期 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap">
					                  标题
					                </td>
					                <td align="center" nowrap="nowrap" style="width:120px;">
					                  学校名称
					                </td>
					                <td align="center" nowrap="nowrap" style="width:80px;">
					                   责任督学 
					                </td>
					                <td align="center" nowrap="nowrap">
					                  内容
					                </td>
					                <td align="center" nowrap="nowrap" style="width:100px;">
					                  状态
					                </td>
					                <td align="center" width="120">
					                    操作
					                </td>
					            </tr>
					        </thead>
			        <tbody>
						' . $s_record_list . '
			        </tbody>
			    </table>
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-top:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <br />
		
		';
		return $s_html;
	}
	public function getDcFeedbackList($n_page) {
		$this->S_FileName = 'gpdd_dc_feedback.php?';
		$this->N_Page = $n_page;
		$o_user = new GPDD_Dc ();
		$a_deptid=$this->O_SingleUser->getDeptId();
		$o_user->PushWhere ( array ('&&', 'SchoolId', '=', $a_deptid[0] ) );	
		$o_user->PushWhere ( array ('&&', 'State', '<', 6) );
		$o_user->PushOrder ( array ('State', 'A' ) );
		$o_user->PushOrder ( array ('Date', 'D' ) );
		$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();
		$n_count = $o_user->getCount ();
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		for($i = 0; $i < $n_count; $i ++) {		
			//分析状态
			switch ($o_user->getState($i))
			{
				case 1:
					$s_state='<span style="color:#FF6600">等待学校反馈</span>';
					$s_button='<a href="gpdd_dc_feedback_handle.php?id='.$o_user->getId( $i ).'">反馈</a>';	
					break;
				case 2:
					$s_state='<span style="color:#FF6600">等待督查组审批</span>';
					$s_button='';
					break;
				case 3:
					$s_state='<span style="color:#FF0000">已退回</span>';
					$s_button='<a href="gpdd_dc_feedback_handle.php?id='.$o_user->getId( $i ).'">反馈</a>';	
					break;
				default:
					$s_state='<span style="color:#0466CB">等待科室归档</span>';
					break;
			}	
			$a_auditor=json_decode($o_user->getOwnerName ( $i ));
			$s_additor='';
			for($k=0;$k<count($a_auditor);$k++)
			{
				if (($k+1)<count($a_auditor))
				{
					$s_additor.=rawurldecode($a_auditor[$k]).'，';
				}else{
					$s_additor.=rawurldecode($a_auditor[$k]);
				}
			}
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" nowrap="nowrap">
					                     ' . $o_user->getDate( $i ) . '
					                </td>
					                <td align="center">
					                    <strong style="font-size:14px;">'.$o_user->getTitle( $i ).'</strong>
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getSchoolName( $i ).'
					                </td>
					                <td align="center">
					                  ' . $s_additor . '
					                </td>
					                <td align="center">
					                  ' . $this->SearchResultAddRed1($o_user->getContent( $i ),'', 300) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                   ' . $s_state . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$s_button.'
					                </td>
					            </tr>
			';
		}		
		$s_html = '		
		 		<div class="PageHeader" style="padding-top:0px;">
			        <div class="title">
			            <span class="big3">督查等待处理列表</span></div>
			    </div>		    
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;条记录
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center" nowrap="nowrap" style="width:90px;">
					                    日期 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap" style="width:200px;">
					                  标题
					                </td>
					                <td align="center" nowrap="nowrap" style="width:200px;">
					                  学校名称
					                </td>
					                <td align="center" nowrap="nowrap" style="width:150px;">
					                   督查组成员 
					                </td>
					                <td align="center" nowrap="nowrap">
					                  内容
					                </td>
					                <td align="center" nowrap="nowrap" style="width:100px;">
					                  状态
					                </td>
					                <td align="center" width="140">
					                    操作
					                </td>
					            </tr>
					        </thead>
			        <tbody>
						' . $s_record_list . '
			        </tbody>
			    </table>
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-top:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <br />
		
		';
		return $s_html;
	}
	public function getDcTaskList($n_page) {
		$this->S_FileName = 'gpdd_dc_task.php?';
		$this->N_Page = $n_page;
		$o_user = new GPDD_Dc_Summary ();
		if ($this->O_SingleUser->ValidModule(30025)==false)
		{
			$o_user->PushWhere ( array ('&&', 'OwnerId', 'Like', '%"'.$this->O_SingleUser->getUid().'"%' ) );
		}	
		$o_user->PushWhere ( array ('&&', 'State', '=', 0) );
		$o_user->PushOrder ( array ('State', 'D' ) );
		$o_user->PushOrder ( array ('Date', 'D' ) );
		$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();
		$n_count = $o_user->getCount ();
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		for($i = 0; $i < $n_count; $i ++) {		
			
			//读取详细记录
			$o_detail=new GPDD_Dc();
			$o_detail->PushWhere ( array ('&&', 'ParentId', '=', $o_user->getId( $i )) );
			$o_detail->PushOrder ( array ('State', 'A' ) );
			$n_detail=$o_detail->getAllCount();
			$s_archive='';
			if ($this->O_SingleUser->ValidModule(30025)==false)
			{
				$s_archive='<a href="gpdd_dc_task_summary.php?id='.$o_user->getId( $i ).'" style="font-size:12px"><strong>填写汇总后归档</strong></a>';
				for($j=0;$j<$n_detail;$j++)
				{
					if ($o_detail->getState($j)<6)
					{
						$s_archive='';
						break;
					}
				}
			}
			for($j=0;$j<$n_detail;$j++)
			{
				$s_button='<a href="gpdd_dc_show.php?id='.$o_detail->getId( $j ).'">详情</a>';	
				//分析状态
				switch ($o_detail->getState($j))
				{
					case 1:
						$s_state='<span style="color:#FF6600">等待学校反馈</span>';
						if ($o_detail->getRead($j)==0)
						{
							$s_read='<span style="color:#FF6600">学校未读</span>';
						}else{
							$s_read='<span style="color:#009900">学校已读</span>';
						}
						break;
					case 2:
						$s_state='<span style="color:#FF6600">等待督查组审批</span>';
						if ($this->O_SingleUser->ValidModule(30026))
						{
							$s_button='<a href="gpdd_dc_task_auditor_confirm.php?id='.$o_detail->getId( $j ).'">开始审批</a>';		
						}
						break;
					case 3:
						$s_state='<span style="color:#FF0000">已退回</span>';
						break;
					case 4:
						$s_state='<span style="color:#0466CB">等待科室归档</span>';
						if ($this->O_SingleUser->ValidModule(30026))
						{
							$s_button='<a href="gpdd_dc_task_confirm.php?id='.$o_detail->getId( $j ).'">开始归档</a>';		
						}
						break;
					case 5:
						$s_state='<span style="color:#FF0000">科室已退回</span>';
						if ($this->O_SingleUser->ValidModule(30026))
						{
							$s_button='<a href="gpdd_dc_task_auditor_confirm.php?id='.$o_detail->getId( $j ).'">开始审批</a>';		
						}
						break;
					case 6:
						$s_state='<span style="color:#008000">已完成</span>';
						break;
					default:
						break;
				}	
				if ($this->O_SingleUser->ValidModule(30031))
				{
					$s_button.='&nbsp;&nbsp;<a href="javascript:;" onclick="dc_delete('.$o_detail->getId( $j ).')">删除</a>';	
				}
				if ($j==0)
				{
					$a_auditor=json_decode($o_detail->getOwnerName ( $j ));
					$s_additor='';
					for($k=0;$k<count($a_auditor);$k++)
					{
						if (($k+1)<count($a_auditor))
						{
							$s_additor.=rawurldecode($a_auditor[$k]).'，';
						}else{
							$s_additor.=rawurldecode($a_auditor[$k]);
						}
					}
					$s_record_list .= '
					             	<tr class="TableLine1">
						                <td align="center" nowrap="nowrap" rowspan="'.$n_detail.'" style="border-right:1px #cccccc solid">
						                     ' . $o_detail->getDate( $j ) . '
						                </td>
						                <td align="center" rowspan="'.$n_detail.'" style="border-right:1px #cccccc solid">
						                    <strong style="font-size:14px;">'.$o_detail->getTitle( $j ).'</strong><br/>'.$s_archive.'						                    
						                </td>			               
						                <td align="center" rowspan="'.$n_detail.'" style="border-right:1px #cccccc solid">
						                	' . $this->SearchResultAddRed1($o_detail->getContent( $j ),'', 300) . '
						                </td>
						                <td align="center" rowspan="'.$n_detail.'" style="border-right:1px #cccccc solid;padding:10px;">
						                  ' .$s_additor  . '
						                </td>
						                <td align="center" nowrap="nowrap" style="border-right:1px #cccccc solid">
						                    '.$o_detail->getSchoolName( $j ).' '.$s_read.'
						                </td>
						                <td align="center" nowrap="nowrap" style="border-right:1px #cccccc solid">
						                   ' . $s_state . '
						                </td>
						                <td align="center" nowrap="nowrap">
						                    '.$s_button.'
						                </td>
						            </tr>
									';
				}else{
					$s_record_list .= '
				             	<tr class="TableLine1">
					                <td align="center" style="border-right:1px #cccccc solid">
					                    '.$o_detail->getSchoolName( $j ).'
					                </td>
					                <td align="center" nowrap="nowrap" style="border-right:1px #cccccc solid">
					                   ' . $s_state . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$s_button.'
					                </td>
					            </tr>
								';
				}				
			}
		}
		if ($this->O_SingleUser->ValidModule(30025))
		{
			$s_open='&nbsp;<input value="发起督查" class="BigButtonB" onclick="location=\'gpdd_dc_add.php\'" type="button" />';
		}
		$s_html = '		
		 		<div class="PageHeader" style="padding-top:0px;">
			        <div class="title">
			            <span class="big3">督查任务列表</span>'.$s_open.'</div>
			    </div>		    
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;个督查主题
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center" nowrap="nowrap" style="width:90px;">
					                    日期 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap" style="width:200px;">
					                  标题
					                </td>                
					                <td align="center" nowrap="nowrap">
					                  内容
					                </td>					               
					                <td align="center" nowrap="nowrap" style="width:150px;">
					                   督查组成员
					                </td>
					                 <td align="center" nowrap="nowrap" style="width:250px;">
					                 督查对象
					                </td>
					                <td align="center" nowrap="nowrap" style="width:100px;">
					                  状态
					                </td>
					                <td align="center" width="120">
					                    操作
					                </td>
					            </tr>
					        </thead>
			        <tbody>
						' . $s_record_list . '
			        </tbody>
			    </table>
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-top:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <br />
		
		';
		return $s_html;
	}
	public function getDcCompletedList($n_page) {
		$this->S_FileName = 'gpdd_dc_task.php?';
		$this->N_Page = $n_page;
		$o_user = new GPDD_Dc_Summary ();
		$o_user->PushWhere ( array ('&&', 'State', '=', 1) );
		$o_user->PushOrder ( array ('State', 'A' ) );
		$o_user->PushOrder ( array ('Date', 'D' ) );
		$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();
		$n_count = $o_user->getCount ();
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		for($i = 0; $i < $n_count; $i ++) {		
			
			//读取详细记录
			$o_detail=new GPDD_Dc();
			$o_detail->PushWhere ( array ('&&', 'ParentId', '=', $o_user->getId( $i )) );
			$o_detail->PushOrder ( array ('State', 'A' ) );
			$n_detail=$o_detail->getAllCount();
			$s_archive='<a href="gpdd_dc_task_summary.php?id='.$o_user->getId( $i ).'" style="font-size:12px"><strong>查看汇总报告</strong></a>';
			for($j=0;$j<$n_detail;$j++)
			{
				$s_button='<a href="gpdd_dc_show.php?id='.$o_detail->getId( $j ).'">详情</a>';	
				if ($j==0)
				{
					$a_auditor=json_decode($o_detail->getOwnerName ( $j ));
					$s_additor='';
					for($k=0;$k<count($a_auditor);$k++)
					{
						if (($k+1)<count($a_auditor))
						{
							$s_additor.=rawurldecode($a_auditor[$k]).'，';
						}else{
							$s_additor.=rawurldecode($a_auditor[$k]);
						}
					}
					$s_record_list .= '
					             	<tr class="TableLine1">
						                <td align="center" nowrap="nowrap" rowspan="'.$n_detail.'" style="border-right:1px #cccccc solid">
						                     ' . $o_detail->getDate( $j ) . '
						                </td>
						                <td align="center" rowspan="'.$n_detail.'" style="border-right:1px #cccccc solid">
						                    <strong style="font-size:14px;">'.$o_detail->getTitle( $j ).'</strong><br/>'.$s_archive.'						                    
						                </td>			               
						                <td align="center" rowspan="'.$n_detail.'" style="border-right:1px #cccccc solid">
						                	' . $this->SearchResultAddRed1($o_detail->getContent( $j ),'', 300) . '
						                </td>
						                <td align="center" rowspan="'.$n_detail.'" style="border-right:1px #cccccc solid;padding:10px;">
						                  ' .$s_additor  . '
						                </td>
						                <td align="center" nowrap="nowrap" style="border-right:1px #cccccc solid">
						                    '.$o_detail->getSchoolName( $j ).'
						                </td>
						                <td align="center" nowrap="nowrap">
						                    '.$s_button.'
						                </td>
						            </tr>
									';
				}else{
					$s_record_list .= '
				             	<tr class="TableLine1">
					                <td align="center" style="border-right:1px #cccccc solid">
					                    '.$o_detail->getSchoolName( $j ).'
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$s_button.'
					                </td>
					            </tr>
								';
				}				
			}
		}
		$s_html = '		
		 		<div class="PageHeader" style="padding-top:0px;">
			        <div class="title">
			            <span class="big3">督查归档列表</span></div>
			    </div>		    
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;个督查主题
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table class="TableList" width="100%">
			        <thead class="TableHeader">
					            <tr>
					                <td align="center" nowrap="nowrap" style="width:90px;">
					                    日期 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap" style="width:200px;">
					                  标题
					                </td>                
					                <td align="center" nowrap="nowrap">
					                  内容
					                </td>					               
					                <td align="center" nowrap="nowrap" style="width:150px;">
					                   督查组成员
					                </td>
					                 <td align="center" nowrap="nowrap" style="width:250px;">
					                 督查对象
					                </td>
					                <td align="center" width="120">
					                    操作
					                </td>
					            </tr>
					        </thead>
			        <tbody>
						' . $s_record_list . '
			        </tbody>
			    </table>
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-top:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                </td>
			                <td class="small1" align="right" valign="bottom">
			                    ' . $s_pagebutton . '
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <br />
		
		';
		return $s_html;
	}
}
?>