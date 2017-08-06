<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 92 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
$o_user = new Base_User ($O_Session->getUid());
$o_user_info = new Base_User_Info ($O_Session->getUid());
$o_user_info_custom = new Base_User_Info_Custom ($O_Session->getUid());
$o_user_role = new Base_User_Role ($O_Session->getUid());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="../../module/DatePicker/skin/WdatePicker.css" />
<script type="text/javascript" src="../../module/DatePicker/WdatePicker.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/common.fun.js"></script>
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="js/ajax.fun.js"></script>
</head>
<body class="bodycolor">
<form method="post" id="dialog_form"
	action="include/bn_submit.svr.php?function=<?php 
		if ($o_user->getType()==0)
		{
			echo('ExternalInfoModify');
		}else{
			echo('InfoModify');
		}	
		?>"
	enctype="multipart/form-data" target="ajax_submit_frame"
	style="width: 100%">
<table class="small" border="0" cellpadding="3" cellspacing="0"
	width="600" align="center" style="margin-top:10px">
	<tbody>
		<tr>
			<td><img src="../../images/sms_type31.gif" align="absmiddle" /><span
				class="big3"> 个人资料</span></td>
		</tr>
	</tbody>
</table>
<table class="TableBlock_Editor" align="center" width="600" style="margin-top:10px">
	<tbody>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>基本信息</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">用户名：</td>
			<td class="TableData">
			<?php echo($o_user->getUserName())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">真实姓名：</td>
			<td class="TableData">
			<input id="Vcl_Name" name="Vcl_Name" size="20" maxlength="20" class="BigInput" value="<?php echo($o_user_info->getName())?>" type="text" /> *
			
			</td>
		</tr>
		<?php 
		if ($o_user->getType()==0)
		{
			echo('
				<tr>
					<td class="TableData" nowrap="nowrap" width="120">绑定手机：</td>
					<td class="TableData">
					'.$o_user_info->getPhone().'
					</td>
				</tr>
			');
		}	
		?>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">默认邮箱：</td>
			<td class="TableData">
			<?php echo($o_user_info->getEmail())?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">状态：</td>
			<td class="TableData">
			<?php 
			if ($o_user->getState () == 1) {
				$s_state = '<span style="color:#42B475">启用</span>';
			} else {
				$s_state = '<span style="color:red">停用</span>';
			}
			echo ($s_state);
			?>
		</td>
		</tr>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>个人信息</strong></td>
		</tr>
		<?php 
		if ($o_user->getType()==0)
		{
			echo('
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">性别：</td>
			<td class="TableData">
				<select name="Vcl_Sex" id="Vcl_Sex"class="BigSelect">');
			if($o_user_info->getSex()=='男') 
			{
				echo('<option value="男" selected="selected">男</option><option value="女">女</option>');
			}else{
				echo('<option value="男">男</option><option value="女" selected="selected">女</option>');
			}
   			echo('</select> *
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">出生日期：</td>
			<td class="TableData">
				<input id="Vcl_Birthday" name="Vcl_Birthday" size="20" readonly="readonly" maxlength="20" class="BigInput" value="'.$o_user_info_custom->getBirthday().'" onclick="WdatePicker()" type="text" /> *
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">民族：</td>
			<td class="TableData">
				<input id="Vcl_Nation" name="Vcl_Nation" size="20" maxlength="20" class="BigInput" value="'.$o_user_info_custom->getNation().'" type="text" /> *
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">身份证号码：</td>
			<td class="TableData">
			<input id="Vcl_CardId" name="Vcl_CardId" size="20" maxlength="20" class="BigInput" value="'.$o_user_info_custom->getCardId().'" type="text"/> *
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">职称：</td>
			<td class="TableData">
				<select name="Vcl_Titles" id="Vcl_Titles"class="BigSelect">');
			if($o_user_info_custom->getTitles()=='二级') 
			{
				echo('<option value=""></option><option value="二级" selected="selected">二级</option><option value="一级">一级</option><option value="高级">高级</option>');
			}else if ($o_user_info_custom->getTitles()=='一级'){
				echo('<option value=""></option><option value="二级">二级</option><option value="一级" selected="selected">一级</option><option value="高级">高级</option>');
			}else if ($o_user_info_custom->getTitles()=='高级'){
				echo('<option value=""></option><option value="二级">二级</option><option value="一级">一级</option><option value="高级" selected="selected">高级</option>');
			}else{
				echo('<option value=""></option><option value="二级">二级</option><option value="一级">一级</option><option value="高级">高级</option>');
			}
   			echo('</select> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">学历：</td>
			<td class="TableData">
				<select name="Vcl_Education" id="Vcl_Education"class="BigSelect">');
			if($o_user_info_custom->getEducation()=='大专') 
			{
				echo('<option value=""></option><option value="大专" selected="selected">大专</option><option value="本科">本科</option><option value="本科以上">本科以上</option>');
			}else if ($o_user_info_custom->getTitle()=='本科'){
				echo('<option value=""></option><option value="大专">大专</option><option value="本科" selected="selected">本科</option><option value="本科以上">本科以上</option>');
			}else if ($o_user_info_custom->getTitle()=='本科以上'){
				echo('<option value=""></option><option value="大专">大专</option><option value="本科">本科</option><option value="本科以上" selected="selected">本科以上</option>');
			}else{
				echo('<option value=""></option><option value="大专">大专</option><option value="本科">本科</option><option value="本科以上">本科以上</option>');
			}
   			echo('</select> *
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">职务：</td>
			<td class="TableData">
			<input id="Vcl_Job" name="Vcl_Job" size="20" maxlength="20" class="BigInput" value="'.$o_user_info_custom->getJob().'" type="text"/> *
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">任教学科：</td>
			<td class="TableData">
			<input id="Vcl_Subject" name="Vcl_Subject" size="20" maxlength="20" class="BigInput" value="'.$o_user_info_custom->getSubject().'" type="text"/> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">网管证书编号：</td>
			<td class="TableData">
			<input id="Vcl_NetId" name="Vcl_NetId" size="20" maxlength="20" class="BigInput" value="'.$o_user_info_custom->getNetId().'" type="text"/> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">继教编号：</td>
			<td class="TableData">
			<input id="Vcl_TeachId" name="Vcl_TeachId" size="20" maxlength="20" class="BigInput" value="'.$o_user_info_custom->getTeachId().'" type="text"/> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">单位座机：</td>
			<td class="TableData">
			<input id="Vcl_UnitPhone" name="Vcl_UnitPhone" size="20" maxlength="20" class="BigInput" value="'.$o_user_info_custom->getUnitPhone().'" type="text"/> <span>（可选）</span>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">QQ：</td>
			<td class="TableData">
			<input id="Vcl_QQ" name="Vcl_QQ" size="20" maxlength="20" class="BigInput" value="'.$o_user_info_custom->getQQ().'" type="text"/>
			</td>
		</tr>
			');	
		}else{
			echo('
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">性别：</td>
			<td class="TableData">
				<select name="Vcl_Sex" id="Vcl_Sex"class="BigSelect">');
			if($o_user_info->getSex()=='男') 
			{
				echo('<option value="男" selected="selected">男</option><option value="女">女</option>');
			}else{
				echo('<option value="男">男</option><option value="女" selected="selected">女</option>');
			}
   			echo('</select>
			</td>
		</tr>
			<tr>
			<td class="TableData" nowrap="nowrap" width="120">出生日期：</td>
			<td class="TableData">
				<input id="Vcl_Birthday" name="Vcl_Birthday" size="20" readonly="readonly" maxlength="20" class="BigInput" value="'.$o_user_info_custom->getBirthday().'" onclick="WdatePicker()" type="text" />
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">手机：</td>
			<td class="TableData">
			<input id="Vcl_MobilePhone" name="Vcl_MobilePhone" size="20" maxlength="20" class="BigInput" value="'.$o_user_info_custom->getMobilePhone().'" type="text"/>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">座机：</td>
			<td class="TableData">
			<input id="Vcl_Phone" name="Vcl_Phone" size="20" maxlength="20" class="BigInput" value="'.$o_user_info_custom->getPhone().'" type="text"/>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">邮箱：</td>
			<td class="TableData">
			<input id="Vcl_OtherEmail" name="Vcl_OtherEmail" size="20" maxlength="20" class="BigInput" value="'.$o_user_info_custom->getEmail().'" type="text"/>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">QQ：</td>
			<td class="TableData">
			<input id="Vcl_QQ" name="Vcl_QQ" size="20" maxlength="20" class="BigInput" value="'.$o_user_info_custom->getQQ().'" type="text"/>
			</td>
		</tr>	
			');
		}
		?>
			
		<tr align="center">
			<td colspan="2" nowrap="nowrap" height="40" class="TableData" >
			<input value="保存" class="BigButtonA" type="button" onclick="info_modify_submit()"/></td>
		</tr>
		<tr>
			<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>所属部门</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">部门：</td>
			<td class="TableData">
			<?php 
			$o_dept=new Single_User($O_Session->getUid());
			echo($o_dept->getDeptNameForStr());
			?>
			</td>
		</tr>
		<tr>
		<td class="TableData" colspan="2" nowrap="nowrap" style="font-size:14px" align="center"><strong>用户角色</strong></td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">主角色：</td>
			<td class="TableData">
			<?php 
			$o_role=new Base_Role($o_user_role->getRoleId());
			echo($o_role->getName());
			?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色1：</td>
			<td class="TableData">
			<?php 
			$o_role=new Base_Role($o_user_role->getSecRoleId1());
			echo($o_role->getName());
			?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色2：</td>
			<td class="TableData">
			<?php 
			$o_role=new Base_Role($o_user_role->getSecRoleId2());
			echo($o_role->getName());
			?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色3：</td>
			<td class="TableData">
			<?php 
			$o_role=new Base_Role($o_user_role->getSecRoleId3());
			echo($o_role->getName());
			?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色4：</td>
			<td class="TableData">
			<?php 
			$o_role=new Base_Role($o_user_role->getSecRoleId4());
			echo($o_role->getName());
			?>
			</td>
		</tr>
		<tr>
			<td class="TableData" nowrap="nowrap" width="120">附属角色5：</td>
			<td class="TableData">
			<?php 
			$o_role=new Base_Role($o_user_role->getSecRoleId5());
			echo($o_role->getName());
			?>
			</td>
		</tr>
	</tbody>
</table>
<br></br>
</form>
<iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0"
	height="0" marginwidth="0" border="0" frameborder="0" src="about:blank"></iframe>
<script type="text/javascript" language="javascript">
	S_Root='../../';
    <?php 
    	    //如果外部人员个人信息不全，就必须录入完整
    		if($o_user->getType()==0 && $o_user_info_custom->getFinish()==0)
    	    {
    	    	echo('parent.Dialog_Message("请完善您的个人资料！");');
    	    }
    ?>
    </script>
</body>
</html>
