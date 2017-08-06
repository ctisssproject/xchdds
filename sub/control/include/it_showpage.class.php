<?php
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'include/it_basic.class.php';
class ShowPage extends It_Basic {
	protected $O_SingleUser;
	public function __construct($o_singleUser) {
		$this->O_SingleUser = $o_singleUser;
		
		$this->N_PageSize = 20;
	}
	public function getRoleList($n_page) {
		$this->S_FileName = 'role_list.php?';
		$this->N_Page = $n_page;
		$o_role = new Base_Role ();
		$o_role->PushOrder ( array ('Name', 'A' ) );
		$o_role->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize ); //起始记录
		$o_role->setCountLine ( $this->N_PageSize );
		$n_count = $o_role->getAllCount ();
		if (($this->N_PageSize * ($this->N_Page - 1)) >= $n_count) {
			$this->N_Page = ceil ( $n_count / $this->N_PageSize );
			$o_role->setStartLine ( ($this->N_Page - 1) * $this->N_PageSize );
			$o_role->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_role->getAllCount ();
		$n_count = $o_role->getCount ();
		$s_pagebutton = $this->getPageButtom ( $n_allcount, $this->N_PageSize, $this->N_Page );
		for($i = 0; $i < $n_count; $i ++) {
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center">
					                    <strong>' . $o_role->getName ( $i ) . '</strong>
					                </td>
					                <td nowrap="nowrap">
					                    ' . $o_role->getExplain ( $i ) . '
					                <td>
					                   	<a href="javascript:;" onclick="roleOpenUser(this)"><span>展开</span><img src="images/open.png" border="0" align="absmiddle"></a><div id="' . $o_role->getRoleId ( $i ) . '" style="padding-left:10px;padding-right:10px;width:270px;display:none"></div>
					                </td>
					                <td align="center" nowrap="nowrap">
					                    <a href="role_modify.php?roleid=' . $o_role->getRoleId ( $i ) . '">编辑权限</a>&nbsp;&nbsp;<a href="javascript:roleDelete(' . $o_role->getRoleId ( $i ) . ')">删除</a>
					                </td>
					            </tr>
			';
		}
		$s_html = '
			    <div class="PageHeader" style="padding-top: 0px">
			        <div class="title">
			             <span class="big3">角色列表</span>&nbsp;</div>
			    </div>
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    &nbsp;&nbsp;&nbsp;&nbsp;共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;个角色
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
					                <td align="center" width="150">
					                    角色名称 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                    
					                </td>
					                <td align="center" width="300">
					                    角色描述
					                </td>
					                <td align="center" width="300">
					                   归属用户
					                </td>
					                <td align="center">
					                    操作
					                </td>
					            </tr>
					        </thead>
			        <tbody>
						' . $s_record_list . '
			        </tbody>
			    </table>
			    <br />
		
		';
		return $s_html;
	}
	public function getUserList($n_page) {
		$this->S_FileName = 'user_list.php?';
		$this->N_Page = $n_page;
		$o_user = new View_User_List ();
		$o_user->PushOrder ( array ('DeptId', 'A' ) );
		$o_user->PushOrder ( array ('Name', 'A' ) );
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
			$s_state = '';
			if ($o_user->getState ( $i ) == 1) {
				$s_state = '<span class="open_on" title="启用用户" onclick="userOpen(this,' . $o_user->getUid ( $i ) . ')">启用</span>&nbsp;<span class="close_off" title="用户停用" onclick="userClose(this,' . $o_user->getUid ( $i ) . ')">停用</span>';
			} else {
				$s_state = '<span class="open_off" title="启用用户" onclick="userOpen(this,' . $o_user->getUid ( $i ) . ')">启用</span>&nbsp;<span class="close_on" title="用户停用" onclick="userClose(this,' . $o_user->getUid ( $i ) . ')">停用</span>';
			}
			$o_user2 = new Single_User ( $o_user->getUid ( $i ) );
			$s_deptname = $o_user2->getDeptNameForStr ();
			$s_record_list .= '
				             <tr class="TableLine1">
					                <td align="center" nowrap="nowrap">
					                     ' . $o_user->getUserName ( $i ) . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    <strong>' . $o_user->getName ( $i ) . '</strong>
					                </td>
					                <td align="center" nowrap="nowrap">
					                    ' . $o_user->getSex ( $i ) . '
					                </td>
					                <td nowrap="nowrap">
					                   &nbsp;&nbsp;' . $s_deptname . '<span class="setting" title="部门修改" onclick="userModifyDept(' . $o_user->getUid ( $i ) . ',\'' . $o_user->getUserName ( $i ) . '\',\'' . $o_user->getName ( $i ) . '\')"></span>
					                </td>
					                <td nowrap="nowrap">
					                  &nbsp;&nbsp;' . $o_user->getRoleName ( $i ) . '<span class="setting" title="角色修改" onclick="userModifyRole(' . $o_user->getUid ( $i ) . ',\'' . $o_user->getUserName ( $i ) . '\',\'' . $o_user->getName ( $i ) . '\')"></span>
					                </td>
					                <td align="center"  nowrap="nowrap">
					                   ' . $s_state . '
					                </td>
					                <td align="center" nowrap="nowrap">
					                    <a href="user_show.php?uid=' . $o_user->getUid ( $i ) . '">详细</a>&nbsp;&nbsp;<a href="javascript:userModifyInfo(' . $o_user->getUid ( $i ) . ',\'' . $o_user->getUserName ( $i ) . '\',\'' . $o_user->getName ( $i ) . '\',\'' . $o_user->getSex ( $i ) . '\',\'' . $o_user->getEmail ( $i ) . '\')">修改信息</a>&nbsp;&nbsp;<a href="javascript:userResetPassword(' . $o_user->getUid ( $i ) . ',\'' . $o_user->getUserName ( $i ) . '\',\'' . $o_user->getName ( $i ) . '\')">重置密码</a>
					                </td>
					            </tr>
			';
		}
		$s_html = '
			    <div class="PageHeader" style="padding-top: 0px">
			        <div class="title">
			             <img src="../../images/user_list3/group.png" align="absmiddle">&nbsp;&nbsp;<span class="big3">用户列表</span>&nbsp;</div>
			    </div>
			    <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
			        <tbody>
			            <tr>
                			<td class="title">
			                    &nbsp;&nbsp;&nbsp;&nbsp;共<span class="big4">&nbsp;' . $n_allcount . '</span>&nbsp;个用户
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
					                <td align="center" nowrap="nowrap" width="100">
					                    用户名
					                    
					                </td>
					                <td align="center" nowrap="nowrap" width="100">
					                    姓名
					                </td>
					                <td align="center" nowrap="nowrap" width="60">
					                  性别
					                </td>
					                <td align="center" width="300">
					                   部门 <img src="../../images/arrow_down.gif" height="10" border="0" width="11" align="absmiddle">
					                </td>
					                <td align="center" width="200">
					                    主角色
					                </td>
					                <td align="center" width="80">
					                    状态
					                </td>
					                <td align="center">
					                    操作
					                </td>
					            </tr>
					        </thead>
			        <tbody>
						' . $s_record_list . '
			        </tbody>
			    </table>
			    <br />
		
		';
		return $s_html;
	}
	public function getRoleModuleList() {
		$o_module1 = new View_AddRole_Module ();
		$o_module1->PushWhere ( array ('&&', 'ParentModuleId', '=', 0 ) );
		$o_module1->PushOrder ( array ('Module', 'A' ) );
		$n_count1 = $o_module1->getAllCount ();
		for($i = 0; $i < $n_count1; $i ++) {
			$s_html .= '<td valign="top">
                    <table class="TableBlock" align="center" style="border: 1px #9CB269 solid;">
                        <tbody>
                            <tr class="TableHeader" title="' . $o_module1->getName ( $i ) . '">
                                <td nowrap="nowrap">
                                    <input id="module_' . $o_module1->getModuleId ( $i ) . '" value="' . $o_module1->getModuleId ( $i ) . '" onclick="roleSelectAllModuleRoot(this);" type="checkbox"/>
                                    <img src="../../' . $o_module1->getPath ( $i ) . '" height="16" width="16" align="absmiddle" alt=""/>
                                    <label>
                                        <b>' . $o_module1->getName ( $i ) . '</b></label>
                                </td>
                            </tr>';
			$o_module2 = new View_AddRole_Module ();
			$o_module2->PushWhere ( array ('&&', 'ParentModuleId', '=', $o_module1->getModuleId ( $i ) ) );
			$o_module2->PushOrder ( array ('Module', 'A' ) );
			$n_count2 = $o_module2->getAllCount ();
			for($j = 0; $j < $n_count2; $j ++) {
				$s_html .= '		<tr title="' . $o_module2->getName ( $j ) . '">
	                                <td class="TableData" nowrap="nowrap">
	                                    <input id="module_' . $o_module2->getModuleId ( $j ) . '" value="' . $o_module2->getModuleId ( $j ) . '" onclick="roleSelectAllModuleSub(this);" type="checkbox"/>
	                                    <img src="../../' . $o_module2->getPath ( $j ) . '" height="16" width="16" align="absmiddle" alt=""/>
	                                    <label> ' . $o_module2->getName ( $j ) . '</label>';
				$o_module3 = new View_AddRole_Module ();
				$o_module3->PushWhere ( array ('&&', 'ParentModuleId', '=', $o_module2->getModuleId ( $j ) ) );
				$o_module3->PushOrder ( array ('Module', 'A' ) );
				$n_count3 = $o_module3->getAllCount ();
				for($k = 0; $k < $n_count3; $k ++) {
					$s_html .= '			<br/>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                                    <input id="module_' . $o_module3->getModuleId ( $k ) . '" value="' . $o_module3->getModuleId ( $k ) . '" onclick="roleSelectOnClick(this)" type="checkbox"/>
	                                    <img src="../../' . $o_module3->getPath ( $k ) . '" height="16" width="16" align="absmiddle" alt=""/>
	                                    <label for="50_89"> ' . $o_module3->getName ( $k ) . '</label>';
				}
				$s_html .= '			</td>
                            </tr>';
			}
			$s_html .= '		</tbody>
                    </table>
                </td>';
		}
		return $s_html;
	
	}
	public function getDeptList() {
		$o_dept1 = new Base_Dept ();
		$o_dept1->PushWhere ( array ('&&', 'ParentId', '=', 0 ) );
		$o_dept1->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_dept1->getAllCount ();
		$o_head = '';
		$o_body = '';
		$o_head = '
					    <table class="TableList" align="center" width="98%" style="margin-top:10px">
					            <tr class="TableHeader">
					                <td align="center" nowrap="nowrap" width="100px">
					       	顺序<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap" width="200px">
					                   一级部门
					                </td>
					                <td align="center" width="100px">
					           	顺序<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle"> 
					                </td>
					                <td align="center" width="200px">
					           	二级部门   
					                </td>
					                <td align="center" width="100px">
					           	顺序<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle"> 
					                </td>
					                <td align="center" width="200px">
					           	三级部门       
					                </td>
					                <td align="center" nowrap="nowrap">
					           	操作       
					                </td>
					            </tr>
							';
		for($i = 0; $i < $n_count; $i ++) {
			$o_body .= '
		            <tr class="TableLine1">
		                <td align="center" nowrap="nowrap">
		                    ' . $o_dept1->getNumber ( $i ) . '<span class="setting" title="修改顺序" onclick="showDeptModifySort(\'' . $o_dept1->getName ( $i ) . '\',' . $o_dept1->getDeptId ( $i ) . ',' . $o_dept1->getNumber ( $i ) . ',\'' . $n_count . '\')"></span>
		                </td>
		                <td align="center">
		                  <strong>' . $o_dept1->getName ( $i ) . '</strong>
		                </td>
		                <td align="center">
		                
		                </td>
		                <td align="center">
		                  
		                </td>
		                <td align="center">
		                </td>
		                <td align="center">
		                </td>
		                <td align="center">
		                  <a href="javascript:deptModify('.$o_dept1->getDeptId ( $i ).',\''.$o_dept1->getName ( $i ).'\',\''.$o_dept1->getPhone ( $i ).'\',\''.$o_dept1->getFax ( $i ).'\',\''.$o_dept1->getAddress ( $i ).'\')">编辑</a>&nbsp;&nbsp;<a href="javascript:deptDelete(' . $o_dept1->getDeptId ( $i ) . ');">删除</a>
		                </td>
		            </tr>
			';
			$o_dept2 = new Base_Dept ();
			$o_dept2->PushWhere ( array ('&&', 'ParentId', '=', $o_dept1->getDeptId ( $i ) ) );
			$o_dept2->PushOrder ( array ('Number', 'A' ) );
			$n_count2 = $o_dept2->getAllCount ();
			for($j = 0; $j < $n_count2; $j ++) {
				if (($j + 1) == $n_count2) {
					$s_photo1 = '';
					$s_photo = '<img src="images/column_path2.png" align="absMiddle">';
				} else {
					$s_photo = '<img src="images/column_path1.png" align="absMiddle">';
					$s_photo1 = '<img src="images/column_path3.png" align="absMiddle">';
				}
				$o_body .= '
		            <tr class="TableLine1">
		                <td align="center" nowrap="nowrap">
		                   
		                </td>
		                <td align="right">
		                  ' . $s_photo . '
		                </td>
		                <td align="center">
		                   ' . $o_dept2->getNumber ( $j ) . '<span class="setting" title="修改顺序" onclick="showDeptModifySort(\'' . $o_dept2->getName ( $j ) . '\',' . $o_dept2->getDeptId ( $j ) . ',' . $o_dept2->getNumber ( $j ) . ',\'' . $n_count2 . '\')"></span>
		                </td>
		                <td align="center">
		                  ' . $o_dept2->getName ( $j ) . '
		                </td>
		                <td align="center" nowrap="nowrap">

		                </td>
		                <td align="center">

		                </td>
		                <td align="center">
		                  <a href="javascript:deptModify('.$o_dept2->getDeptId ( $j ).',\''.$o_dept2->getName ( $j ).'\',\''.$o_dept2->getPhone ( $j ).'\',\''.$o_dept2->getFax ( $j ).'\',\''.$o_dept2->getAddress ( $j ).'\')">编辑</a>&nbsp;&nbsp;<a href="javascript:deptDelete(' . $o_dept2->getDeptId ( $j ) . ');">删除</a>
		                </td>
		            </tr>
			';
				$o_dept3 = new Base_Dept ();
				$o_dept3->PushWhere ( array ('&&', 'ParentId', '=', $o_dept2->getDeptId ( $j ) ) );
				$o_dept3->PushOrder ( array ('Number', 'A' ) );
				$n_count3 = $o_dept3->getAllCount ();
				for($k = 0; $k < $n_count3; $k ++) {
					if (($k + 1) == $n_count3) {
						$s_photo = '<img src="images/column_path2.png" align="absMiddle">';
					} else {
						$s_photo = '<img src="images/column_path1.png" align="absMiddle">';
					}
					//显是路径关系的图片
					$o_body .= '
		            <tr class="TableLine1">
		                <td align="center" nowrap="nowrap">
		                   
		                </td>
		                <td align="right">
							'.$s_photo1.'
		                </td>
		                <td align="center">

		                </td>
		                <td align="right">
		                  ' . $s_photo . '
		                </td>
		                <td align="center" nowrap="nowrap">
							 ' . $o_dept3->getNumber ( $k ) . '<span class="setting" title="修改顺序" onclick="showDeptModifySort(\'' . $o_dept3->getName ( $k ) . '\',' . $o_dept3->getDeptId ( $k ) . ',' . $o_dept3->getNumber ( $k ) . ',\'' . $n_count3 . '\')"></span>
		                </td>
		                <td align="center">
							' . $o_dept3->getName ( $k ) . '
		                </td>
		                <td align="center">
		                   <a href="javascript:deptModify('.$o_dept3->getDeptId ( $k ).',\''.$o_dept3->getName ( $k ).'\',\''.$o_dept3->getPhone ( $k ).'\',\''.$o_dept3->getFax ( $k ).'\',\''.$o_dept3->getAddress ( $k ).'\')">编辑</a>&nbsp;&nbsp;<a href="javascript:deptDelete(' . $o_dept3->getDeptId ( $k ) . ');">删除</a>
		                </td>
		            </tr>
			';
				}
			}
		}
		return $o_head . $o_body.'
					    </table><br/>';
	}
	public function getModuleList() {
		$o_dept1 = new Base_Module ();
		$o_dept1->PushWhere ( array ('&&', 'ParentModuleId', '=', 0 ) );
		$o_dept1->PushOrder ( array ('Module', 'A' ) );
		$n_count = $o_dept1->getAllCount ();
		$o_head = '';
		$o_body = '';
		$o_head = '
					    <table class="TableList" align="center" width="98%" style="margin-top:10px">
					            <tr class="TableHeader">
					                <td align="center" nowrap="nowrap" width="100px">
					       	顺序<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle">
					                </td>
					                <td align="center" nowrap="nowrap" width="200px">
					                   一级模块
					                </td>
					                <td align="center" width="100px">
					           	顺序<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle"> 
					                </td>
					                <td align="center" width="200px">
					           	二级模块   
					                </td>
					                <td align="center" width="100px">
					           	顺序<img src="../../images/arrow_down.gif" border="0" height="10" width="11" align="absmiddle"> 
					                </td>
					                <td align="center" width="200px">
					           	三级模块       
					                </td>
					                <td>
					           	      
					                </td>
					            </tr>
							';
		for($i = 0; $i < $n_count; $i ++) {
			$o_body .= '
		            <tr class="TableLine1">
		                <td align="center" nowrap="nowrap">
		                    ' . ($i+1) . '
		                </td>
		                <td align="center">
		                  <strong>' . $o_dept1->getName ( $i ) . '</strong><span class="setting" title="编辑" onclick="showModuleModify(\'' . $o_dept1->getName ( $i) . '\',' . $o_dept1->getModuleId ( $i ) . ')"></span>
		                </td>
		                <td align="center">
		                
		                </td>
		                <td align="center">
		                  
		                </td>
		                <td align="center">
		                </td>
		                <td align="center">
		                </td>
					                <td>
					           	      
					                </td>
		            </tr>
			';
			$o_dept2 = new Base_Module ();
			$o_dept2->PushWhere ( array ('&&', 'ParentModuleId', '=', $o_dept1->getModuleId ( $i ) ) );
			$o_dept2->PushOrder ( array ('Module', 'A' ) );
			$n_count2 = $o_dept2->getAllCount ();
			for($j = 0; $j < $n_count2; $j ++) {
				if (($j + 1) == $n_count2) {
					$s_photo1 = '';
					$s_photo = '<img src="images/column_path2.png" align="absMiddle">';
				} else {
					$s_photo = '<img src="images/column_path1.png" align="absMiddle">';
					$s_photo1 = '<img src="images/column_path3.png" align="absMiddle">';
				}
				$o_body .= '
		            <tr class="TableLine1">
		                <td align="center" nowrap="nowrap">
		                   
		                </td>
		                <td align="right">
		                  ' . $s_photo . '
		                </td>
		                <td align="center">
		                  '.($j+1).'
		                </td>
		                <td align="center">
		                  ' . $o_dept2->getName ( $j ) . '<span class="setting" title="编辑" onclick="showModuleModify(\'' . $o_dept2->getName ( $j) . '\',' . $o_dept2->getModuleId ( $j ) . ')"></span>
		                </td>
		                <td align="center" nowrap="nowrap">

		                </td>
		                <td align="center">

		                </td>
		                <td>
					           	      
					    </td>
		            </tr>
			';
				$o_dept3 = new Base_Module ();
				$o_dept3->PushWhere ( array ('&&', 'ParentModuleId', '=', $o_dept2->getModuleId ( $j ) ) );
				$o_dept3->PushOrder ( array ('Module', 'A' ) );
				$n_count3 = $o_dept3->getAllCount ();
				for($k = 0; $k < $n_count3; $k ++) {
					if (($k + 1) == $n_count3) {
						$s_photo = '<img src="images/column_path2.png" align="absMiddle">';
					} else {
						$s_photo = '<img src="images/column_path1.png" align="absMiddle">';
					}
					//显是路径关系的图片
					$o_body .= '
		            <tr class="TableLine1">
		                <td align="center" nowrap="nowrap">
		                   
		                </td>
		                <td align="right">
							'.$s_photo1.'
		                </td>
		                <td align="center">

		                </td>
		                <td align="right">
		                  ' . $s_photo . '
		                </td>
		                <td align="center" nowrap="nowrap">
							 ' . ($k+1) . '
		                </td>
		                <td align="center">
							' . $o_dept3->getName ( $k ) . '<span class="setting" title="编辑" onclick="showModuleModify(\'' . $o_dept3->getName ( $k) . '\',' . $o_dept3->getModuleId ( $k ) . ')"></span>
		                </td>
					                <td>
					           	      
					                </td>
		            </tr>
			';
				}
			}
		}
		return $o_head . $o_body.'
					    </table><br/>';
	}
}

?>