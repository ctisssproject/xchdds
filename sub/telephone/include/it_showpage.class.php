<?php
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'include/it_basic.class.php';
require_once 'include/db_view.class.php';
require_once 'include/db_table.class.php';
class ShowPage extends It_Basic {
	protected $O_SingleUser;
	public function __construct($o_singleUser) {
		$this->O_SingleUser = $o_singleUser;
		$this->N_PageSize = 20;
	}
	
	public function getRecordList($n_page) {
		$this->S_FileName = 'record_list.php?';
		$this->N_Page = $n_page;
		$b_isadmin = $this->O_SingleUser->ValidModule (30002);
		$o_user = new Telephone_Info ();
		if($b_isadmin)
		{
			
		}else{
			$o_user->PushWhere ( array ('&&', 'OwnerId', '=', $this->O_SingleUser->getUid() ) );
		}
		$o_user->PushOrder ( array ('RecordDate', 'D' ) );
		$o_user->PushOrder ( array ('RecordTime', 'D' ) );
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
/*			if($b_isadmin==true || $o_user->getUid ($i)==$this->O_SingleUser->getUid())	
			{
				
			}else{
				continue;
			}*/
			$o_dept=new Base_Dept($o_user->getSchoolId ( $i ));
			$o_per=new Telephone_Profile($o_user->getProfileId( $i ));
			$o_user_info=new Base_User_Info($o_user->getUid( $i ));
			if ($o_user->getOwnerId($i)!=$this->O_SingleUser->getUid())
			{
				$s_button='<a href="record_show.php?id=' . $o_user->getId ( $i ) . '">查看</a>';
			}else{
				$s_button='<a href="record_show.php?id=' . $o_user->getId ( $i ) . '">查看</a>&nbsp;<a href="record_modify.php?id='.$o_user->getId ( $i ) . '">修改</a>&nbsp;<a style="color:red" href="javascript:;" onclick="record_delete('.$o_user->getId ( $i ).')">删除</a>';
			}
			//生成处理人
			$s_owner_name=$o_user_info->getName ();
			if($o_user->getOwnerId($i)!=0)
			{
				$s_owner_name=$o_user->getOwnerName ( $i );
			}
			$s_record_list .= '
				             <tr class="TableLine1">
				             		<td align="center" nowrap="nowrap">
					                     ' . $o_user->getId ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                     ' . $o_user->getRecordDate ( $i ) . ' ' . $o_user->getRecordTime ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    ' . $o_user->getName ( $i ) . '---' . $o_user->getSex ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    ' . $o_dept->getName () . '---' . $o_per->getName () . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                   ' . $o_user->getPhone ( $i ) . '
					                </td>
					                <td>
					                  ' . $o_user->getContent ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                  ' . $o_user_info->getName () . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                  ' . $s_owner_name . '
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
			            <span class="big3">电话记录列表</span>&nbsp;<input value="添加记录" class="BigButtonB" onclick="location=\'record_add.php\'" type="button" /></div>
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
					            	<td align="center" nowrap="nowrap" style="width:60px;">
					                    编号
					                </td>
					                <td align="center" nowrap="nowrap">
					                    日期 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap">
					                   姓名
					                </td>
					                <td align="center" nowrap="nowrap">
					                  来源
					                </td>
					                <td align="center" nowrap="nowrap">
					                   电话 
					                </td>
					                <td align="center" style="max-width:350px;">
					                    来电记录
					                </td>
					                <td align="center">
					                    记录人
					                </td>
					                <td align="center">
					                    处理人
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
	public function getDudaoList($n_page) {
		$this->S_FileName = 'dudao_list.php?';
		$this->N_Page = $n_page;
		$o_user = new View_Telephone_Info_Special ();
		$o_user->PushOrder ( array ('Completed', 'A' ) );
		$o_user->PushOrder ( array ('RecordDate', 'D' ) );
		$o_user->PushOrder ( array ('RecordTime', 'D' ) );
		$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$b_isadmin = $this->O_SingleUser->ValidModule (30003);
		$n_allcount = $o_user->getAllCount ();
		$n_count = $o_user->getCount ();
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		for($i = 0; $i < $n_count; $i ++) {		
			if ($o_user->getCompleted ( $i )=='1')
			{
				$s_button='<a href="dudao_show.php?id=' . $o_user->getId ( $i ) . '">查看</a>';
				$s_style='';
			}else{
				$s_button='<a href="dudao_print.php?id=' . $o_user->getId ( $i ) . '" target="blank">打印</a>&nbsp;&nbsp;<a href="dudao_modify.php?id='.$o_user->getId ( $i ) . '">录入信息</a>&nbsp;&nbsp;<a style="color:red" href="javascript:;" onclick="dudao_delete('.$o_user->getId ( $i ).')">删除</a>';
				$s_style=' style="font-weight:bold;"';
			}
			$s_record_list .= '
				             <tr class="TableLine1"'.$s_style.'>
					                <td align="center" nowrap="nowrap">
					                     ' . $o_user->getRecordDate ( $i ) . ' ' . $o_user->getRecordTime ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    ' . $o_user->getName ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                ' . $o_user->getPhone ( $i ) . '					                    
					                </td>
					                <td align="center" nowrap="nowrap">
					                   ' . $o_user->getSchoolName ( $i ) . '
					                </td>
					                <td>
					                  ' . $o_user->getContent ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                  ' . $o_user->getUserName ( $i ) . '
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
			            <span class="big3">西城区责任督学挂牌督导特殊问题办理记录单</span>
			            </div>
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
					                <td align="center">
					                  反应学校（部门）
					                </td>
					                <td align="center" style="max-width:350px;">
					                    反应情况
					                </td>
					                <td align="center">
					                    记录人
					                </td>
					                <td align="center" width="130">
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