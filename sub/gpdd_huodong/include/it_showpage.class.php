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
	public function getOpenList($n_page) {
		$this->S_FileName = 'list.php?';
		$this->N_Page = $n_page;
		$o_user = new GPDD_Huodong ();
		$o_user->PushWhere ( array ('&&', 'OwnerId', '=', $this->O_SingleUser->getUid() ) );
		$o_user->PushWhere ( array ('&&', 'State', '<', 10) );
		$o_user->PushWhere ( array ('||', 'OpenId', '=', $this->O_SingleUser->getUid() ) );
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
				case 0:
					$s_state='<span style="color:#FF6600">等待督学答复</span>';
					if($o_user->getOwnerId($i)== $this->O_SingleUser->getUid() )
					{
						$s_button='<a href="javascript:;" onclick="reply('.$o_user->getId( $i ).')">答复</a>';	
					}					
					break;
				case 1:
					$s_state='<span style="color:#FF6600">等待学校确认</span>';
					if($o_user->getOpenId($i)== $this->O_SingleUser->getUid() )
					{
						$s_button='<a href="javascript:;" onclick="join_confirm('.$o_user->getId( $i ).')">确认</a>';	
					}	
					break;
				case 2:
					$s_state='<span style="color:#FF6600">等待学校确认</span>';
					if($o_user->getOpenId($i)== $this->O_SingleUser->getUid() )
					{
						$s_button='<a href="javascript:;" onclick="completed_confirm('.$o_user->getId( $i ).')">确认</a>';	
					}	
					break;
				case 3:
					$s_state='<span style="color:#0066CC">等待督学反馈</span>';
					if($o_user->getOwnerId($i)== $this->O_SingleUser->getUid() )
					{
						$s_button='<a href="feedback.php?id='.$o_user->getId( $i ).'">反馈</a>';	
					}	
					break;
				case 4:
					$s_state='<span style="color:#FF6600">等待学校确认</span>';
					if($o_user->getOpenId($i)== $this->O_SingleUser->getUid() )
					{
						$s_button='<a href="javascript:;" onclick="completed_confirm('.$o_user->getId( $i ).')">确认</a>';	
					}	
					break;
				default:
					break;
			}
			$go_reason='';
			if ($o_user->getGoReason ( $i )!='')
			{
				if($o_user->getIsGo($i)==0)
				{
					$go_reason=$o_user->getOwnerName ( $i ).'&nbsp;答复：<span style="color:#FF0000"><strong>不参加</strong></span><br/>';
					$go_reason.='原因：'.$o_user->getGoReason ( $i );
				}else{
					$go_reason=$o_user->getOwnerName ( $i ). '&nbsp;答复：<span style="color:#339900"><strong>参加</strong></span><br/>';
					$go_reason.='备注：'.$o_user->getGoReason ( $i );
				}
			}
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" nowrap="nowrap">
					                     ' . $s_state . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getDate( $i ).'
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getSchoolName( $i ).'
					                </td>
					                <td align="center">
					                  主题：' . $o_user->getTitle ( $i ) . '<br/>
					                  地点：'.$o_user->getAddress( $i ).'
					                </td>
					                <td align="center" nowrap="nowrap">
					                     联系人：' . $o_user->getName ( $i ) . '<br/>
					       	联系电话：' . $o_user->getPhone ( $i ) . '
					                </td>
					                <td align="center">
					                   ' . $o_user->getContent ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $go_reason . '
					                </td>
					                <td align="center">
					                  '.$o_user->getFeedback( $i ).'
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$s_button.'
					                </td>
					            </tr>
			';
		}
		//如果是督学，不能有发起活动按钮
		$s_button='&nbsp;<input value="发起活动" class="BigButtonB" onclick="location=\'open.php\'" type="button" />';
		$o_detp=new Base_Dept();
		$o_detp->PushWhere ( array ('&&', 'Uid', '=', $this->O_SingleUser->getUid() ) );
		if ($o_detp->getAllCount()>0)
		{
			$s_button='';
		}
		$s_html = '		
		 		<div class="PageHeader" style="padding-top:0px;">
			        <div class="title">
			            <span class="big3">等待处理列表</span>'.$s_button.'</div>
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
					                    活动日期
					                </td>
					                <td align="center" nowrap="nowrap">
					                    学校名称
					                </td>
					                <td align="center" nowrap="nowrap">
					                   主题 与 地点
					                </td>
					                <td align="center" nowrap="nowrap">
					                  联系方式
					                </td>
					                <td align="center" nowrap="nowrap">
					                  活动概述
					                </td>
					                <td align="center" nowrap="nowrap">
					                  督学答复
					                </td>
					                <td align="center" nowrap="nowrap">
					                  活动反馈
					                </td>
					                <td align="center" width="80">
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
		$this->S_FileName = 'completed.php?';
		$this->N_Page = $n_page;
		$o_user = new GPDD_Huodong ();
		$o_user->PushWhere ( array ('&&', 'OwnerId', '=', $this->O_SingleUser->getUid() ) );
		$o_user->PushWhere ( array ('&&', 'State', '=', 10) );
		$o_user->PushWhere ( array ('||', 'OpenId', '=', $this->O_SingleUser->getUid() ) );
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
			$go_reason='';
			if ($o_user->getGoReason ( $i )!='')
			{
				if($o_user->getIsGo($i)==0)
				{
					$go_reason=$o_user->getOwnerName ( $i ).'&nbsp;答复：<span style="color:#FF0000"><strong>不参加</strong></span><br/>';
					$go_reason.='原因：'.$o_user->getGoReason ( $i );
				}else{
					$go_reason=$o_user->getOwnerName ( $i ). '&nbsp;答复：<span style="color:#339900"><strong>参加</strong></span><br/>';
					$go_reason.='备注：'.$o_user->getGoReason ( $i );
				}
			}
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getDate( $i ).'
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getSchoolName( $i ).'
					                </td>
					                <td align="center">
					                  主题：' . $o_user->getTitle ( $i ) . '<br/>
					                  地点：'.$o_user->getAddress( $i ).'
					                </td>
					                <td align="center" nowrap="nowrap">
					                     联系人：' . $o_user->getName ( $i ) . '<br/>
					       	联系电话：' . $o_user->getPhone ( $i ) . '
					                </td>
					                <td align="center">
					                   ' . $o_user->getContent ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $go_reason . '
					                </td>
					                <td align="center">
					                  '.$o_user->getFeedback( $i ).'
					                </td>
					            </tr>
			';
		}
		$s_html = '		
		 		<div class="PageHeader" style="padding-top:0px;">
			        <div class="title">
			            <span class="big3">历时活动列表</span></div>
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
					                    活动日期
					                </td>
					                <td align="center" nowrap="nowrap">
					                    学校名称
					                </td>
					                <td align="center" nowrap="nowrap">
					                   主题 与 地点
					                </td>
					                <td align="center" nowrap="nowrap">
					                  联系方式
					                </td>
					                <td align="center" nowrap="nowrap">
					                  活动概述
					                </td>
					                <td align="center" nowrap="nowrap">
					                  督学答复
					                </td>
					                <td align="center" nowrap="nowrap">
					                  活动反馈
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
	public function getManageList($n_page) {
		$this->S_FileName = 'Manage.php?';
		$this->N_Page = $n_page;
		$o_user = new GPDD_Huodong ();
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
				case 0:
					$s_state='<span style="color:#FF6600">等待督学答复</span>';				
					break;
				case 1:
					$s_state='<span style="color:#FF6600">等待学校确认</span>';
					break;
				case 2:
					$s_state='<span style="color:#FF6600">等待学校确认</span>';	
					break;
				case 3:
					$s_state='<span style="color:#0066CC">等待督学反馈</span>';	
					break;
				case 4:
					$s_state='<span style="color:#FF6600">等待学校确认</span>';
					break;
				default:
					break;
			}
			$go_reason='';
			if ($o_user->getGoReason ( $i )!='')
			{
				if($o_user->getIsGo($i)==0)
				{
					$go_reason=$o_user->getOwnerName ( $i ).'&nbsp;答复：<span style="color:#FF0000"><strong>不参加</strong></span><br/>';
					$go_reason.='原因：'.$o_user->getGoReason ( $i );
				}else{
					$go_reason=$o_user->getOwnerName ( $i ). '&nbsp;答复：<span style="color:#339900"><strong>参加</strong></span><br/>';
					$go_reason.='备注：'.$o_user->getGoReason ( $i );
				}
			}
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" nowrap="nowrap">
					                     ' . $s_state . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getDate( $i ).'
					                </td>
					                <td align="center" nowrap="nowrap">
					                    '.$o_user->getSchoolName( $i ).'
					                </td>
					                <td align="center">
					                  主题：' . $o_user->getTitle ( $i ) . '<br/>
					                  地点：'.$o_user->getAddress( $i ).'
					                </td>
					                <td align="center" nowrap="nowrap">
					                     联系人：' . $o_user->getName ( $i ) . '<br/>
					       	联系电话：' . $o_user->getPhone ( $i ) . '
					                </td>
					                <td align="center">
					                   ' . $o_user->getContent ( $i ) . '
					                </td>
					                <td align="center">
					                  ' . $go_reason . '
					                </td>
					                <td align="center">
					                  '.$o_user->getFeedback( $i ).'
					                </td>
					                <td align="center" nowrap="nowrap">
					                    <a href="javascript:;" onclick="huodong_delete('.$o_user->getId( $i ).')" style="color:red">删除</a>
					                </td>
					            </tr>
			';
		}
		$s_html = '		
		 		<div class="PageHeader" style="padding-top:0px;">
			        <div class="title">
			            <span class="big3">管理列表</span></div>
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
					                    活动日期
					                </td>
					                <td align="center" nowrap="nowrap">
					                    学校名称
					                </td>
					                <td align="center" nowrap="nowrap">
					                   主题 与 地点
					                </td>
					                <td align="center" nowrap="nowrap">
					                  联系方式
					                </td>
					                <td align="center" nowrap="nowrap">
					                  活动概述
					                </td>
					                <td align="center" nowrap="nowrap">
					                  督学答复
					                </td>
					                <td align="center" nowrap="nowrap">
					                  活动反馈
					                </td>
					                <td align="center" width="80">
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