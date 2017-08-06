<?php
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
class Operate extends Bn_Basic {
	protected $Result;
	public $S_DeptName;
	public $S_DeptId;
	public function __construct() {
		$this->Result = TRUE;
		$this->S_DeptId = '';
		$this->S_DeptName = '';
	}
	public function getResult() {
		return $this->Result;
	}
	
	public function GetSubDept($n_id, $n_uid) {
		if ($n_id == '') {
			return;
		}
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 78 )) {
			$o_detp = new Base_Dept ();
			$o_detp->PushWhere ( array ('&&', 'ParentId', '=', $n_id ) );
			$o_detp->PushOrder ( array ('Number', 'A' ) );
			$n_count = $o_detp->getAllCount ();
			for($i = 0; $i < $n_count; $i ++) {
				if (($i + 1) == $n_count) {
					$this->S_DeptId .= $o_detp->getDeptId ( $i );
					$this->S_DeptName .= $o_detp->getName ( $i );
				} else {
					$this->S_DeptId .= $o_detp->getDeptId ( $i ) . '<1>';
					$this->S_DeptName .= $o_detp->getName ( $i ) . '<1>';
				}
			}
		}
	}
	public function UserModifyDeptGetDeptVcl($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 79 )) {
			$o_user = new Single_User ( $n_id );
			$a_deptid = array_reverse ( $o_user->getDeptId () );
			//开始构建控件
			//建立第一级部门控件
			$o_detp = new Base_Dept ();
			$o_detp->PushWhere ( array ('&&', 'ParentId', '=', 0 ) );
			$o_detp->PushWhere ( array ('&&', 'DeptId', '>', 0 ) );
			$o_detp->PushOrder ( array ('Number', 'A' ) );
			$n_count = $o_detp->getAllCount ();
			$s_html .= '
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<select name="Vcl_Dept1" id="Vcl_Dept1" style="min-width:100px" class="BigSelect" onchange="getDept2()">';
			for($i = 0; $i < $n_count; $i ++) {
				if ($a_deptid [0] == $o_detp->getDeptId ( $i )) {
					$s_html .= '<option value="' . $o_detp->getDeptId ( $i ) . '" selected="selected">' . $o_detp->getName ( $i ) . '</option>';
				} else {
					$s_html .= '<option value="' . $o_detp->getDeptId ( $i ) . '">' . $o_detp->getName ( $i ) . '</option>';
				}
			}
			$s_html .= '</select></td>';
			
				//建立第二级部门控件
				$s_html .= '<td id="dept2">&nbsp;&nbsp;<select name="Vcl_Dept2" id="Vcl_Dept2" style="min-width:100px" class="BigSelect" onchange="getDept3()"><option value=""></option>';
				$o_detp = new Base_Dept ();
				$o_detp->PushWhere ( array ('&&', 'ParentId', '=', $a_deptid [0] ) );
				$o_detp->PushOrder ( array ('Number', 'A' ) );
				$n_count = $o_detp->getAllCount ();
				for($i = 0; $i < $n_count; $i ++) {
					if ($a_deptid [1] == $o_detp->getDeptId ( $i )) {
						$s_html .= '<option value="' . $o_detp->getDeptId ( $i ) . '" selected="selected">' . $o_detp->getName ( $i ) . '</option>';
					} else {
						$s_html .= '<option value="' . $o_detp->getDeptId ( $i ) . '">' . $o_detp->getName ( $i ) . '</option>';
					}
				}
			if (count ( $a_deptid ) >= 2) {	
				$s_html .= '</select></td>';
			} else {
				//封口
				$s_html .= '<td id="dept2">
					</td>
					<td id="dept3">
					</td>
				</tr>
			</table>';
				return $s_html;
			}
			if (count ( $a_deptid ) == 3) {
				//建立第二级部门控件
				$s_html .= '<td id="dept3">&nbsp;&nbsp;<select name="Vcl_Dept3" id="Vcl_Dept3" style="min-width:100px" class="BigSelect"><option value=""></option>';
				$o_detp = new Base_Dept ();
				$o_detp->PushWhere ( array ('&&', 'ParentId', '=', $a_deptid [1] ) );
				$o_detp->PushOrder ( array ('Number', 'A' ) );
				$n_count = $o_detp->getAllCount ();
				for($i = 0; $i < $n_count; $i ++) {
					if ($a_deptid [2] == $o_detp->getDeptId ( $i )) {
						$s_html .= '<option value="' . $o_detp->getDeptId ( $i ) . '" selected="selected">' . $o_detp->getName ( $i ) . '</option>';
					} else {
						$s_html .= '<option value="' . $o_detp->getDeptId ( $i ) . '">' . $o_detp->getName ( $i ) . '</option>';
					}
				}
				$s_html .= '</select></td></tr></table>';
			} else {
				//封口
				$s_html .= '
					<td id="dept3">
					</td>
				</tr>
			</table>';
				return $s_html;
			}
			return $s_html;
		}
	}
	public function DeptModifyDeptGetDeptVcl($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		$o_detp2 = new Base_Dept ( $n_id );
		if ($o_detp2->getParentId () > 0) {
			
			$o_detp = new Base_Dept ( $o_detp2->getParentId () );
			if ($o_detp->getParentId () == 0) {
				$n_dept2 = 0;
				$n_dept1 = $o_detp2->getParentId ();
			} else {
				$n_dept2 = $o_detp2->getParentId ();
				$n_dept1 = $o_detp->getParentId ();
			}
		
		} else {
			$n_dept1 = 0;
		}
		if ($o_user->ValidModule ( 86 )) {
			$o_user = new Single_User ( $n_id );
			//开始构建控件
			//建立第一级部门控件
			$o_detp = new Base_Dept ();
			$o_detp->PushWhere ( array ('&&', 'ParentId', '=', 0 ) );
			$o_detp->PushOrder ( array ('Number', 'A' ) );
			$n_count = $o_detp->getAllCount ();
			$s_html .= '
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<select name="Vcl_Dept1" id="Vcl_Dept1" style="min-width:100px" class="BigSelect" onchange="getDept2()"><option value=""></option>';
			for($i = 0; $i < $n_count; $i ++) {
				if ($n_dept1 == $o_detp->getDeptId ( $i )) {
					$s_html .= '<option value="' . $o_detp->getDeptId ( $i ) . '" selected="selected">' . $o_detp->getName ( $i ) . '</option>';
				} else {
					$s_html .= '<option value="' . $o_detp->getDeptId ( $i ) . '">' . $o_detp->getName ( $i ) . '</option>';
				}
			}
			$s_html .= '</select></td>';
			if ($n_dept2 > 0) {
				//建立第二级部门控件
				$s_html .= '<td id="dept2">&nbsp;&nbsp;<select name="Vcl_Dept2" id="Vcl_Dept2" style="min-width:100px" class="BigSelect">';
				$o_detp = new Base_Dept ();
				$o_detp->PushWhere ( array ('&&', 'ParentId', '=', $n_dept1 ) );
				$n_count = $o_detp->getAllCount ();
				for($i = 0; $i < $n_count; $i ++) {
					if ($n_dept2 == $o_detp->getDeptId ( $i )) {
						$s_html .= '<option value="' . $o_detp->getDeptId ( $i ) . '" selected="selected">' . $o_detp->getName ( $i ) . '</option>';
					} else {
						$s_html .= '<option value="' . $o_detp->getDeptId ( $i ) . '">' . $o_detp->getName ( $i ) . '</option>';
					}
				}
				$s_html .= '</select></td></tr></table>';
			} else {
				//封口
				$s_html .= '
					<td id="dept2">
					</td>
				</tr>
			</table>';
			}
			return $s_html;
		}
	}
	public function UserModifyRoleGetRoleVcl($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 79 )) {
			$o_user = new Base_User_Role ( $n_id );
			$o_role = new Base_Role ();
			$n_count = $o_role->getAllCount ();
			//开始构建主角色
			$s_html .= '<table class="TableBlock_Role" align="center" width="100%">
				<tr><td class="TableData" nowrap="nowrap" width="80">主角色：</td>
				<td class="TableData" style="border-right:none">
					<select name="Vcl_Role0" id="Vcl_Role0" style="min-width:100px" class="BigSelect">
			';
			for($i = 0; $i < $n_count; $i ++) {
				if ($o_user->getRoleId () == $o_role->getRoleId ( $i )) {
					$s_html .= '<option value="' . $o_role->getRoleId ( $i ) . '" selected="selected">' . $o_role->getName ( $i ) . '</option>';
				} else {
					$s_html .= '<option value="' . $o_role->getRoleId ( $i ) . '">' . $o_role->getName ( $i ) . '</option>';
				}
			}
			$s_html .= '</select>
						</td>
					</tr>';
			$s_html .= '<tr>' . $this->UserModifyRoleGetRoleVclOtherRole ( 1, $o_user, $o_role, $n_count ) . '</tr>';
			$s_html .= '<tr>' . $this->UserModifyRoleGetRoleVclOtherRole ( 2, $o_user, $o_role, $n_count ) . '</tr>';
			$s_html .= '<tr>' . $this->UserModifyRoleGetRoleVclOtherRole ( 3, $o_user, $o_role, $n_count ) . '</tr>';
			$s_html .= '<tr>' . $this->UserModifyRoleGetRoleVclOtherRole ( 4, $o_user, $o_role, $n_count ) . '</tr>';
			$s_html .= '<tr>' . $this->UserModifyRoleGetRoleVclOtherRole ( 5, $o_user, $o_role, $n_count ) . '</tr></table>';
			return $s_html;
		}
	}
	private function UserModifyRoleGetRoleVclOtherRole($n_number, $o_user, $o_role, $n_count) {
		$s_html .= '
				<td class="TableData" nowrap="nowrap">附属角色' . $n_number . '：</td>
				<td class="TableData" style="border-right:none">
					<select name="Vcl_Role' . $n_number . '" id="Vcl_Role' . $n_number . '" style="min-width:100px" class="BigSelect"><option value=""></option>
			';
		for($i = 0; $i < $n_count; $i ++) {
			$a = '';
			$a = '$a=$o_user->getSecRoleId' . $n_number . '();';
			eval ( '$a=$o_user->getSecRoleId' . $n_number . '();' );
			if ($a == $o_role->getRoleId ( $i )) {
				$s_html .= '<option value="' . $o_role->getRoleId ( $i ) . '" selected="selected">' . $o_role->getName ( $i ) . '</option>';
			} else {
				$s_html .= '<option value="' . $o_role->getRoleId ( $i ) . '">' . $o_role->getName ( $i ) . '</option>';
			}
		}
		$s_html .= '</select> <span>（可选）</span></td>';
		return $s_html;
	}
	public function UserAdd($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 78 )) {
			//检测有无重名
			$a = $_POST ['Vcl_Birthday'];
			if ($o_user->FindUserName ( $_POST ['Vcl_UserName'] ) > 0) {
				//有重名
				return FALSE;
			}
			//用户基本信息
			$o_user = new Base_User ();
			$o_user->setPassword ( md5 ( 'welcome ' . $_POST ['Vcl_Password'] . ' to 教育城域网综合管理信息系统 !' ) );
			$o_user->setUserName ( $_POST ['Vcl_UserName'] );
			$o_user->setState ( $_POST ['Vcl_State'] );
			$o_user->setRegIp ( $_SERVER ['REMOTE_ADDR'] );
			$o_user->setRegTime ( $this->GetDateNow () );
			$a_group_id=array();
			array_push($a_group_id, $_POST ['Vcl_GroupId']);
			if ($_POST ['Vcl_GroupId']=='')
			{
				$o_user->setGroupId('[]'); 
			}else{
				$o_user->setGroupId(json_encode($a_group_id)); 
			}			
			$o_user->Save ();
			//用户不可修改的信息
			$o_user_info = new Base_User_Info ();
			$o_user_info->setUid ( $o_user->getUid () );
			$o_user_info->setName ( $_POST ['Vcl_Name'] );
			$o_user_info->setEmail ( $_POST ['Vcl_Email'] );
			$o_user_info->setSex ( $_POST ['Vcl_Sex'] );
			$o_user_info->setAmUsername ( $_POST ['Vcl_Am_Username'] );
			$o_user_info->Save ();
			//用户可修改的信息
			$o_user_info_custom = new Base_User_Info_Custom ();
			$o_user_info_custom->setUid ( $o_user->getUid () );
			$o_user_info_custom->setBirthday ( $_POST ['Vcl_Birthday'] );
			$o_user_info_custom->setEmail ( $_POST ['Vcl_OtherEmail'] );
			$o_user_info_custom->setPhone ( $_POST ['Vcl_Phone'] );
			$o_user_info_custom->setMobilePhone ( $_POST ['Vcl_MobilePhone'] );
			$o_user_info_custom->setQQ ( $_POST ['Vcl_QQ'] );
			$o_user_info_custom->Save ();
			//用户登陆信息
			$o_user_login = new Base_User_Login ();
			$o_user_login->setUid ( $o_user->getUid () );
			$o_user_login->Save ();
			//用户部门角色信息
			$o_user_role = new Base_User_Role ();
			$o_user_role->setUid ( $o_user->getUid () );
			if (isset ( $_POST ['Vcl_Dept3'] ) && $_POST ['Vcl_Dept3'] != '') {
				$o_user_role->setDeptId ( $_POST ['Vcl_Dept3'] );
			} else if (isset ( $_POST ['Vcl_Dept2'] ) && $_POST ['Vcl_Dept2'] != '') {
				$o_user_role->setDeptId ( $_POST ['Vcl_Dept2'] );
			} else {
				$o_user_role->setDeptId ( $_POST ['Vcl_Dept1'] );
			}
			$o_user_role->setRoleId ( $_POST ['Vcl_Role0'] );
			$o_user_role->setSecRoleId1 ( $_POST ['Vcl_Role1'] );
			$o_user_role->setSecRoleId2 ( $_POST ['Vcl_Role2'] );
			$o_user_role->setSecRoleId3 ( $_POST ['Vcl_Role3'] );
			$o_user_role->setSecRoleId4 ( $_POST ['Vcl_Role4'] );
			$o_user_role->setSecRoleId5 ( $_POST ['Vcl_Role5'] );
			$o_user_role->Save ();
			//开通网盘功能
			//require_once RELATIVITY_PATH . 'sub/netdisk/include/db_table.class.php';
			//$o_netdisk = new Netdisk_Space ();
			//$o_netdisk->setUid ( $o_user->getUid () );
			//$o_netdisk->setFree ( 5242880 );
			//$o_netdisk->setTotal ( 5242880 );
			//$o_netdisk->Save ();
			//建立相应的文件夹
			mkdir ( RELATIVITY_PATH . 'userdata/' . md5 ( $_POST ['Vcl_UserName'] ), 0700 );
			mkdir ( RELATIVITY_PATH . 'userdata/' . md5 ( $_POST ['Vcl_UserName'] ) . '/photo', 0700 );
			mkdir ( RELATIVITY_PATH . 'userdata/' . md5 ( $_POST ['Vcl_UserName'] ) . '/picture', 0700 );
			mkdir ( RELATIVITY_PATH . 'userdata/' . md5 ( $_POST ['Vcl_UserName'] ) . '/netdisk', 0700 );
			mkdir ( RELATIVITY_PATH . 'userdata/' . md5 ( $_POST ['Vcl_UserName'] ) . '/affix', 0700 );
			return true;
		}
	}
	public function UserModifyDept($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 79 )) {
			//检测有无重名
			//用户部门角色信息
			$o_user_role = new Base_User_Role ( $_POST ['Vcl_Uid'] );
			if (isset ( $_POST ['Vcl_Dept3'] ) && $_POST ['Vcl_Dept3'] != '') {
				$o_user_role->setDeptId ( $_POST ['Vcl_Dept3'] );
			} else if (isset ( $_POST ['Vcl_Dept2'] ) && $_POST ['Vcl_Dept2'] != '') {
				$o_user_role->setDeptId ( $_POST ['Vcl_Dept2'] );
			} else {
				$o_user_role->setDeptId ( $_POST ['Vcl_Dept1'] );
			}
			$o_user_role->Save ();
		}
	}
	public function UserModifyRole($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 79 )) {
			//检测有无重名
			//用户部门角色信息
			$o_user_role = new Base_User_Role ( $_POST ['Vcl_Uid'] );
			$o_user_role->setRoleId ( $_POST ['Vcl_Role0'] );
			$o_user_role->setSecRoleId1 ( $_POST ['Vcl_Role1'] );
			$o_user_role->setSecRoleId2 ( $_POST ['Vcl_Role2'] );
			$o_user_role->setSecRoleId3 ( $_POST ['Vcl_Role3'] );
			$o_user_role->setSecRoleId4 ( $_POST ['Vcl_Role4'] );
			$o_user_role->setSecRoleId5 ( $_POST ['Vcl_Role5'] );
			$o_user_role->Save ();
		}
	}
	public function UserResetPassword($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 79 )) {
			//检测有无重名
			//用户部门角色信息
			$o_user = new Base_User ( $_POST ['Vcl_Uid'] );
			$o_user->setPassword ( md5 ( 'welcome ' . $_POST ['Vcl_Password'] . ' to 教育城域网综合管理信息系统 !' ) );
			$o_user->Save ();
		}
	}
	public function UserModifyInfo($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 79 )) {
			//检测有无重名
			//用户部门角色信息
			//用户不可修改的信息
			$o_user_info = new Base_User_Info ( $_POST ['Vcl_Uid'] );
			$o_user_info->setName ( $_POST ['Vcl_Name'] );
			$o_user_info->setEmail ( $_POST ['Vcl_Email'] );
			$o_user_info->setSex ( $_POST ['Vcl_Sex'] );
			$o_user_info->setAmUsername ( $_POST ['Vcl_Am_Username'] );
			$o_user=new Base_User($_POST ['Vcl_Uid']);
			$a_group_id=array();
			array_push($a_group_id, $_POST ['Vcl_GroupId']);
			if ($_POST ['Vcl_GroupId']=='')
			{
				$o_user->setGroupId('[]'); 
			}else{
				$o_user->setGroupId(json_encode($a_group_id)); 
			}
			$o_user->Save();
			$o_user_info->Save ();
		}
	}
	public function UserSetState($n_id, $s_state, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 79 )) {
			//检测有无重名
			//用户部门角色信息
			$o_user = new Base_User ( $n_id );
			$o_user->setState ( $s_state );
			$o_user->Save ();
		}
	}
	public function RoleAdd($n_name, $n_exlain, $s_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 81 )) {
			$o_role = new Base_Role ();
			$o_role->setName ( $n_name );
			$o_role->setExplain ( $n_exlain );
			$o_role->Save ();
			if ($s_id == '') {
				return;
			}
			$a_role_id = explode ( "<1>", $s_id );
			for($i = 0; $i < count ( $a_role_id ); $i ++) {
				$o_right = new Base_Right ();
				$o_right->setRoleId ( $o_role->getRoleId () );
				$o_right->setModuleId ( $a_role_id [$i] );
				$o_right->Save ();
			}
		}
	}
	public function RoleModify($n_id, $n_name, $n_exlain, $s_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 82 )) {
			$o_role = new Base_Role ( $n_id );
			$o_role->setName ( $n_name );
			$o_role->setExplain ( $n_exlain );
			$o_role->Save ();
			//删除所有权限
			$o_right = new Base_Right ();
			$o_right->PushWhere ( array ('&&', 'RoleId', '=', $n_id ) );
			$n_count = $o_right->getAllCount ();
			for($i = 0; $i < $n_count; $i ++) {
				$o_right2 = new Base_Right ( $o_right->getRightId ( $i ) );
				$o_right2->Deletion ();
			}
			if ($s_id == '') {
				return;
			}
			$a_role_id = explode ( "<1>", $s_id );
			for($i = 0; $i < count ( $a_role_id ); $i ++) {
				$o_right = new Base_Right ();
				$o_right->setRoleId ( $o_role->getRoleId () );
				$o_right->setModuleId ( $a_role_id [$i] );
				$o_right->Save ();
			}
		}
	}
	public function RoleDelete($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 82 )) {
			//验证有无用户使用这个角色
			$o_role = new Base_User_Role ();
			$o_role->PushWhere ( array ('||', 'RoleId', '=', $n_id ) );
			$o_role->PushWhere ( array ('||', 'SecRoleId1', '=', $n_id ) );
			$o_role->PushWhere ( array ('||', 'SecRoleId2', '=', $n_id ) );
			$o_role->PushWhere ( array ('||', 'SecRoleId3', '=', $n_id ) );
			$o_role->PushWhere ( array ('||', 'SecRoleId4', '=', $n_id ) );
			$o_role->PushWhere ( array ('||', 'SecRoleId5', '=', $n_id ) );
			if ($o_role->getAllCount () > 0) {
				return false;
			}
			$o_right = new Base_Right ();
			$o_right->PushWhere ( array ('&&', 'RoleId', '=', $n_id ) );
			$n_count = $o_right->getAllCount ();
			for($i = 0; $i < $n_count; $i ++) {
				$o_right2 = new Base_Right ( $o_right->getRightId ( $i ) );
				$o_right2->Deletion ();
			}
			$o_role = new Base_Role ( $n_id );
			$o_role->Deletion ();
			return true;
		}
	}
	public function GroupDelete($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 97 )) {
			//验证有无用户使用这个角色
			$o_group = new Base_Group($n_id);
			$o_group->Deletion();
			$o_group= new Base_Group_Member();
			$o_group->PushWhere ( array ('&&', 'GroupId', '=', $n_id ) );
			$o_group->DeletionWhere();
			return true;
		}
	}
	public function RoleGetUser($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 82 )) {
			//验证有无用户使用这个角色
			$o_role = new View_User_Role ();
			$o_role->PushWhere ( array ('||', 'RoleId', '=', $n_id ) );
			$o_role->PushWhere ( array ('||', 'SecRoleId1', '=', $n_id ) );
			$o_role->PushWhere ( array ('||', 'SecRoleId2', '=', $n_id ) );
			$o_role->PushWhere ( array ('||', 'SecRoleId3', '=', $n_id ) );
			$o_role->PushWhere ( array ('||', 'SecRoleId4', '=', $n_id ) );
			$o_role->PushWhere ( array ('||', 'SecRoleId5', '=', $n_id ) );
			$n_count = $o_role->getAllCount ();
			$s_name = '';
			for($i = 0; $i < $n_count; $i ++) {
				$o_user=new Base_User($o_role->getUid($i));
				if ($o_user->getState()!=1)
				{
					continue;
				}
				if (($i + 1) == $n_count) {
					$s_name .= $o_role->getName ( $i );
				} else {
					$s_name .= $o_role->getName ( $i ) . '、';
				}
			}
			if ($n_count == 0) {
				$s_name = '无';
			}
			return $s_name;
		}
	}
	public function DeptAdd($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 85 )) {
			//用户基本信息
			$o_dept = new Base_Dept ();
			$o_dept->setName ( $_POST ['Vcl_Name'] );
			if (isset ( $_POST ['Vcl_Dept2'] ) && $_POST ['Vcl_Dept2'] != '') {
				$S_ParentId = $_POST ['Vcl_Dept2'];
			} else if (isset ( $_POST ['Vcl_Dept1'] ) && $_POST ['Vcl_Dept1'] != '') {
				$S_ParentId = $_POST ['Vcl_Dept1'];
			} else {
				$S_ParentId = 0;
			}
			$o_dept2 = new Base_Dept ();
			$o_dept2->PushWhere ( array ('&&', 'ParentId', '=', $S_ParentId ) );
			$o_dept2->PushWhere ( array ('&&', 'Name', '=', $_POST ['Vcl_Name'] ) );
			$n_count = $o_dept2->getAllCount ();
			if ($n_count > 0) {
				$this->S_ErrorReasion='部门名称有重复，请更换！';
				return FALSE;
			}
			$o_dept2 = new Base_Dept ();
			$o_dept2->PushWhere ( array ('&&', 'ParentId', '=', $S_ParentId ) );
			$n_count = $o_dept2->getAllCount ();
			$o_dept->setParentId ( $S_ParentId );
			$o_dept->setNumber ( $n_count + 1 );
			$o_dept->setPhone ( $_POST ['Vcl_Phone'] );
			$o_dept->setFax ( $_POST ['Vcl_Fax'] );
			$o_dept->setAddress ( $_POST ['Vcl_Address'] );
			$o_dept->setType ( $_POST ['Vcl_Type'] );
			$o_dept->setUid ( $_POST ['Vcl_Uid'] );
			$o_dept->setSurveyNumber ( $_POST ['Vcl_SurveyNumber'] );
			//验证问卷调查识别号是否合法
			$o_dept2 = new Base_Dept ();
			$o_dept2->PushWhere ( array ('&&', 'ParentId', '=', $S_ParentId ) );
			$o_dept2->PushWhere ( array ('&&', 'SurveyNumber', '=', $_POST ['Vcl_SurveyNumber'] ) );
			$o_dept2->PushWhere ( array ('&&', 'SurveyNumber', '<>', '') );
			$n_count = $o_dept2->getAllCount ();
			if ($n_count > 0) {
				$this->S_ErrorReasion='问卷识别号有重复，请更换！';
				return FALSE;
			}
			$o_dept->Save ();
			return true;
		}
	}
	public function GroupAdd($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 97 )) {
			//用户基本信息
			$o_dept = new Base_Group ();
			$o_dept->setName ( $_POST ['Vcl_Name'] );
			$o_dept2 = new Base_Group ();
			$o_dept2->PushWhere ( array ('&&', 'Name', '=', $_POST ['Vcl_Name'] ) );
			$n_count = $o_dept2->getAllCount ();
			if ($n_count > 0) {
				//$this->S_ErrorReasion='分组名称有重复，请更换！';
				//return FALSE;
			}
			$o_dept->Save ();
			$s_type='Dept';
			//先查看学校
			$o_temp=new Base_Dept();
			$o_temp->PushWhere ( array ('&&', 'ParentId', '=', 1 ) );
			$n_count=$o_temp->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				if($_POST['Vcl_Dept_'.$o_temp->getDeptId($i)]=='on')
				{
					$o_save=new Base_Group_Member();
					$o_save->setType('Dept');
					$o_save->setUid($o_temp->getDeptId($i));
					$o_save->setGroupId($o_dept->getId());
					$o_save->Save();
				}
			}
			//再查看用户
			$o_temp=new View_User_Info();
			$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
			$o_temp->PushWhere ( array ('&&', 'DeptId', '=', 138 ) );
			$n_count=$o_temp->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				if($_POST['Vcl_User_'.$o_temp->getUid($i)]=='on')
				{
					$o_save=new Base_Group_Member();
					$o_save->setType('User');
					$o_save->setUid($o_temp->getUid($i));
					$o_save->setGroupId($o_dept->getId());
					$o_save->Save();
					$s_type='User';
				}
			}
			$o_dept->setType($s_type);
			$o_dept->Save();
			return true;
		}
	}
	public function GroupModify($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 97 )) {
			//用户基本信息
			$o_dept = new Base_Group ($_POST ['Vcl_Id']);
			$o_dept->setName ( $_POST ['Vcl_Name'] );
			$o_dept2 = new Base_Group ();
			$o_dept2->PushWhere ( array ('&&', 'Name', '=', $_POST ['Vcl_Name'] ) );
			$o_dept2->PushWhere ( array ('&&', 'Id', '<>', $o_dept->getId() ) );
			$n_count = $o_dept2->getAllCount ();
			if ($n_count > 0) {
				//$this->S_ErrorReasion='分组名称有重复，请更换！';
				//return FALSE;
			}
			$o_dept->Save ();
			//删除该分组下所有的记录
			$o_temp=new Base_Group_Member();
			$o_temp->PushWhere ( array ('&&', 'GroupId', '=',$o_dept->getId() ) );
			$o_temp->DeletionWhere();
			$s_type='Dept';
			//先查看学校
			$o_temp=new Base_Dept();
			$o_temp->PushWhere ( array ('&&', 'ParentId', '=', 1 ) );
			$n_count=$o_temp->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				if($_POST['Vcl_Dept_'.$o_temp->getDeptId($i)]=='on')
				{
					$o_save=new Base_Group_Member();
					$o_save->setType('Dept');
					$o_save->setUid($o_temp->getDeptId($i));
					$o_save->setGroupId($o_dept->getId());
					$o_save->Save();
				}
			}
			//再查看用户
			$o_temp=new View_User_Info();
			$o_temp->PushWhere ( array ('&&', 'State', '=', 1 ) );
			$o_temp->PushWhere ( array ('&&', 'DeptId', '=', 138 ) );
			$n_count=$o_temp->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				if($_POST['Vcl_User_'.$o_temp->getUid($i)]=='on')
				{
					$o_save=new Base_Group_Member();
					$o_save->setType('User');
					$o_save->setUid($o_temp->getUid($i));
					$o_save->setGroupId($o_dept->getId());
					$o_save->Save();
					$s_type='User';
				}
			}
			return true;
		}
	}
	public function DeptModify($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 85 )) {
			//用户基本信息
			$o_dept = new Base_Dept ( $_POST ['Vcl_DeptId'] );
			$o_dept->setName ( $_POST ['Vcl_Name'] );
			if (isset ( $_POST ['Vcl_Dept2'] ) && $_POST ['Vcl_Dept2'] != '') {
				$S_ParentId = $_POST ['Vcl_Dept2'];
			} else if (isset ( $_POST ['Vcl_Dept1'] ) && $_POST ['Vcl_Dept1'] != '') {
				$S_ParentId = $_POST ['Vcl_Dept1'];
			} else {
				$S_ParentId = 0;
			}
			$o_dept2 = new Base_Dept ();
			$o_dept2->PushWhere ( array ('&&', 'ParentId', '=', $S_ParentId ) );
			$o_dept2->PushWhere ( array ('&&', 'Name', '=', $_POST ['Vcl_Name'] ) );
			$o_dept2->PushWhere ( array ('&&', 'DeptId', '<>', $_POST ['Vcl_DeptId'] ) );
			$n_count = $o_dept2->getAllCount ();
			if ($n_count > 0) {
				return FALSE;
			}
			if ($S_ParentId != $o_dept->getParentId ()) { //如果上级部门有变动，则编号设为最后
				$n_yuanParent=$o_dept->getParentId ();
				$o_dept2 = new Base_Dept ();
				$o_dept2->PushWhere ( array ('&&', 'ParentId', '=', $S_ParentId ));
				$n_count = $o_dept2->getAllCount ();
				$o_dept->setNumber ( $n_count + 1 );				
				$o_dept->setParentId($S_ParentId);	
				
				$o_dept->Save ();
				$this->DeptSortAll($n_yuanParent);
			//部门重新排序
			}
			$o_dept->setPhone ( $_POST ['Vcl_Phone'] );
			$o_dept->setFax ( $_POST ['Vcl_Fax'] );
			$o_dept->setAddress ( $_POST ['Vcl_Address'] );
			$o_dept->setType ( $_POST ['Vcl_Type'] );
			$o_dept->setUid ( $_POST ['Vcl_Uid'] );
			//验证问卷调查识别号是否合法
			$o_dept2 = new Base_Dept ();
			$o_dept2->PushWhere ( array ('&&', 'ParentId', '=', $S_ParentId ) );
			$o_dept2->PushWhere ( array ('&&', 'DeptId', '<>', $_POST ['Vcl_DeptId'] ) );
			$o_dept2->PushWhere ( array ('&&', 'SurveyNumber', '=', $_POST ['Vcl_SurveyNumber'] ) );
			$o_dept2->PushWhere ( array ('&&', 'SurveyNumber', '<>', '') );
			$n_count = $o_dept2->getAllCount ();
			if ($n_count > 0) {
				$this->S_ErrorReasion='问卷识别号有重复，请更换！';
				return FALSE;
			}
			$o_dept->setSurveyNumber ( $_POST ['Vcl_SurveyNumber'] );
			$o_dept->Save ();
			return true;
		}
	}
	public function ModuleModify($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 87 )) {
			//用户基本信息
			$o_dept = new Base_Module ( $_POST ['Vcl_ModuleId'] );
			$o_dept->setName ( $_POST ['Vcl_Name'] );			
			$o_dept->Save ();
			return true;
		}
	}
	private function DeptModifySortAll($n_parent,$n_focusid, $n_number) {
		$o_all = new Base_Dept();
		$o_all->PushWhere ( array ('&&', 'ParentId', '=', $n_parent ) );
		$o_all->PushWhere ( array ('&&', 'DeptId', '<>', $n_focusid ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Base_Dept ( $o_all->getDeptId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	public function DeptModifySort($n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 85 )) {
			//用户基本信息
			$o_dept = new Base_Dept ( $_POST ['Vcl_DeptId'] );
			$o_dept->setNumber ( $_POST ['Vcl_Number'] );
			$o_dept->Save();
			$this->DeptModifySortAll($o_dept->getParentId(), $_POST ['Vcl_DeptId'], $_POST ['Vcl_Number'] );
			return true;
		}
	}
	public function DeptSortAll($n_parent) { //部门重新排序
		$o_dept2 = new Base_Dept ();
		$o_dept2->PushWhere ( array ('&&', 'ParentId', '=', $n_parent ) );
		$o_dept2->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_dept2->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_dept=new Base_Dept($o_dept2->getDeptId($i));
			$o_dept->setNumber($i+1);
			$o_dept->Save();
		}
	}
	public function DeptDelete($n_id, $n_uid) {
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->Result = FALSE;
			return;
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 86 )) {
			//用户基本信息
			$o_dept = new Base_Dept ( $n_id );
			//有没有子部门
			$o_dept2 = new Base_Dept ();
			$o_dept2->PushWhere ( array ('&&', 'ParentId', '=', $o_dept->getDeptId () ) );
			$n_count = $o_dept2->getAllCount ();
			if ($n_count > 0) {
				return 2;
			}
			//有没有用户
			$o_role = new Base_User_Role ();
			$o_role->PushWhere ( array ('&&', 'DeptId', '=', $o_dept->getDeptId () ) );
			$n_count = $o_role->getAllCount ();
			if ($n_count > 0) {
				return 3;
			}
			$o_dept->Deletion ();
			return 1;
		}
	}
}

?>