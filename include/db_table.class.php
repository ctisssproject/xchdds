<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class Base_Dept extends CRUD
{
   protected $DeptId;
   protected $Name;
   protected $ParentId;
   protected $Number;
   protected $Phone;
   protected $Fax;
   protected $Address;
   protected $Type;
   protected $Uid;
   protected $SurveyNumber;
   
   protected function DefineKey()
   {
      return 'dept_id';
   }
   protected function DefineTableName()
   {
      return 'base_dept';
   }
   protected function DefineRelationMap()
   {
      return(array('dept_id' => 'DeptId',
      							'name' => 'Name',
      							'parent_id' => 'ParentId',
      							'number' => 'Number',
     								'phone' => 'Phone',
      							'fax' => 'Fax',  
      'type' => 'Type',
      'survey_number' => 'SurveyNumber',
      'uid' => 'Uid',    
      							'address' => 'Address'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_Module  extends CRUD
{
   protected $ModuleId;
   protected $Name;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $WaitReadTable;
    
   protected function DefineKey()
   {
      return 'module_id';
   }
   protected function DefineTableName()
   {
      return 'base_module';
   }
   protected function DefineRelationMap()
   {
      return(array('module_id' => 'ModuleId',
      				'name' => 'Name',
      				'module' => 'Module',
      				'explain' => 'Explain',
     				'icon_id' => 'IconId',
      				'path' => 'Path',
      				'parent_module_id' => 'ParentModuleId',
                   	'mini_icon_id' => 'MiniIconId',
      				'wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class Base_Group  extends CRUD
{
   protected $Id;
   protected $Name;
   protected $Type;
    
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'base_group';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
      				'name' => 'Name',
      'type' => 'Type'
                   ));
   }
}
class Base_Group_Member  extends CRUD
{
   protected $Id;
   protected $GroupId;
   protected $Uid;
   protected $Type;
    
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'base_group_member';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
      				'group_id' => 'GroupId',
      				'uid' => 'Uid',
      				'type' => 'Type'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_Module_Icon extends CRUD
{
   protected $IconId;
   protected $Path;

   protected function DefineKey()
   {
      return 'icon_id';
   }
   protected function DefineTableName()
   {
      return 'base_module_icon';
   }
   protected function DefineRelationMap()
   {
      return(array('icon_id' => 'IconId',
                   'path' => 'Path'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_Module_Icon_Mini extends CRUD
{
   protected $MiniIconId;
   protected $Path;

   protected function DefineKey()
   {
      return 'mini_icon_id';
   }
   protected function DefineTableName()
   {
      return 'base_module_icon_mini';
   }
   protected function DefineRelationMap()
   {
      return(array('mini_icon_id' => 'MiniIconId',
                   'path' => 'Path'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_Right extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;

   protected function DefineKey()
   {
      return 'right_id';
   }
   protected function DefineTableName()
   {
      return 'base_right';
   }
   protected function DefineRelationMap()
   {
      return(array('right_id' => 'RightId',
                   'role_id' => 'RoleId',
                   'module_id' => 'ModuleId'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_Role extends CRUD
{
   protected $RoleId;
   protected $Name;
   protected $Explain;

   protected function DefineKey()
   {
      return 'role_id';
   }
   protected function DefineTableName()
   {
      return 'base_role';
   }
   protected function DefineRelationMap()
   {
      return(array('role_id' => 'RoleId',
                   'name' => 'Name',
                   'explain' => 'Explain'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_System_Count extends CRUD
{
   protected $Id;
   protected $Visit;
   protected $Installed;
   protected $User;
   protected $OnlineCount;

   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'base_system_count';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
                   'visit' => 'Visit',
                   'installed' => 'Installed',
                   'user' => 'User',
                   'online_count' => 'OnlineCount'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_System_Setup extends CRUD
{
   protected $Id;
   protected $ThemeId;
   protected $SysOpen;
   protected $CloseReason;
   protected $Homepage;
   protected $DefaultPhoto;
   protected $UploadPictureSize;

   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'base_system_setup';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',               
                   'theme_id' => 'ThemeId',          
                   'sys_open' => 'SysOpen',          
                   'close_reason' => 'CloseReason',
                   'homepage' => 'Homepage',         
                   'default_photo' => 'DefaultPhoto',     
                   'upload_picture_size' => 'UploadPictureSize'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_System_Msg extends CRUD
{
   protected $Id;
   protected $Uid;
   protected $Text;
   protected $ParentModuleId;
   protected $ModuleId;
   protected $Type;
   protected $Readed;
   protected $AmReaded;

   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'base_system_msg';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',               
                   'uid' => 'Uid',          
                   'text' => 'Text',          
                   'parent_module_id' => 'ParentModuleId',
                   'module_id' => 'ModuleId',         
                   'type' => 'Type',
                   'readed' => 'Readed',
                   'am_readed' => 'AmReaded'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_System_Theme extends CRUD
{
   protected $ThemeId;
   protected $Path;
   protected $Name;
   protected $Explain;

   protected function DefineKey()
   {
      return 'theme_id';
   }
   protected function DefineTableName()
   {
      return 'base_system_theme';
   }
   protected function DefineRelationMap()
   {
      return(array('theme_id' => 'ThemeId',
                   'path' => 'Path',
                   'name' => 'Name',
                   'explain' => 'Explain'
                   ));
   }
}
class Base_School_Type extends CRUD
{
   protected $Id;
   protected $Name;

   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'base_school_type';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
                   'name' => 'Name'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User extends CRUD
{
   protected $UserName;
   protected $Password;
   protected $State;
   protected $Uid;
   protected $RegIp;
   protected $RegTime;
   protected $Type;
   protected $GroupId;

   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'base_user';
   }
   protected function DefineRelationMap()
   {
      return(array('uid' => 'Uid',
                   'username' => 'UserName',
                   'password' => 'Password',
                   'state' => 'State',
                   'reg_ip' => 'RegIp',
                   'reg_time' => 'RegTime',
      			   'type' => 'Type',
      			   'group_id' => 'GroupId'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Desktop extends CRUD
{
   protected $Uid;
   protected $ModuleSort;

   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'base_user_desktop';
   }
   protected function DefineRelationMap()
   {
      return(array('uid' => 'Uid',
                   'module_sort' => 'ModuleSort'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Info extends CRUD
{
   protected $Uid;
   protected $Name;
   protected $Email;
   protected $Sex;
   protected $EmailPassword;
   protected $AmUsername;
   protected $Phone;
   protected $SchoolId;

   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'base_user_info';
   }
   protected function DefineRelationMap()
   {
      return(array('uid' => 'Uid',
                   'name' => 'Name',
                   'email' => 'Email',
                   'sex' => 'Sex',
      			   'email_password' => 'EmailPassword',
      			   'am_username' => 'AmUsername',
      			   'phone' => 'Phone',
      			   'school_id' => 'SchoolId'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Info_Custom extends CRUD
{
   protected $Uid;
   protected $OtherName;
   protected $Birthday;
   protected $MobilePhone;
   protected $Phone;
   protected $Email;
   protected $QQ;
   protected $Nation;
   protected $Titles;
   protected $Education;
   protected $Job;
   protected $Subject;
   protected $CardId;
   protected $NetId;
   protected $UnitPhone;
   protected $TeachId;  
   protected $Finish; 
   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'base_user_info_custom';
   }
   protected function DefineRelationMap()
   {
      return(array('uid' => 'Uid',
                   'other_name' => 'OtherName',
                   'birthday' => 'Birthday',
                   'mobile_phone' => 'MobilePhone',
                   'phone' => 'Phone',
                   'email' => 'Email',
                   'qq' => 'QQ',
                   'nation' => 'Nation',
			       'titles' => 'Titles',
			       'education' => 'Education',
			       'job' => 'Job',
			       'subject' => 'Subject',
			       'card_id' => 'CardId',
			       'net_id' => 'NetId',
			       'unit_phone' => 'UnitPhone',
			       'teach_id' => 'TeachId',
      			   'finish' => 'Finish'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Login extends CRUD
{
   protected $Uid;
   protected $LastIp;
   protected $LastTime;
   protected $Online;
   protected $LoginTime;
   protected $OnlineTime;
   protected $UserAgent;
   protected $SessionId;
   protected $AmSessionId;
   protected $PassError;
   protected $LockTime;
      
   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'base_user_login';
   }
   protected function DefineRelationMap()
   {
      return(array('uid' => 'Uid',
                   'last_ip' => 'LastIp',
                   'last_time' => 'LastTime',
                   'online' => 'Online',
                   'login_time' => 'LoginTime',
                   'online_time' => 'OnlineTime',
                   'user_agent' => 'UserAgent',
                   'session_id' => 'SessionId',
      			   'am_session_id' => 'AmSessionId',
                   'pass_error' => 'PassError',
                   'lock_time' => 'LockTime'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Photo extends CRUD
{
   protected $Uid;
   protected $Path;
      
   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'base_user_photo';
   }
   protected function DefineRelationMap()
   {
      return(array('uid' => 'Uid',
                   'path' => 'Path'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Picture extends CRUD
{
   protected $Id;
   protected $Uid;
   protected $Path;
   protected $Timecut;
   protected $Filesize;
      
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'base_user_picture';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
                   'uid' => 'Uid',
                   'path' => 'Path',
                   'timecut' => 'Timecut',
                   'filesize' => 'Filesize'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Group extends CRUD
{
   protected $GroupId;
   protected $Name;
   protected $Explain;
      
   protected function DefineKey()
   {
      return 'group_id';
   }
   protected function DefineTableName()
   {
      return 'base_user_group';
   }
   protected function DefineRelationMap()
   {
      return(array('group_id' => 'GroupId',
                   'name' => 'Name',
                   'explain' => 'Explain'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Role extends CRUD
{
   protected $Uid;
   protected $DeptId;
   protected $DeptId1;
   protected $DeptId2;
   protected $DeptId3;
   protected $DeptId4;
   protected $DeptId5;
   protected $RoleId;
   protected $SecRoleId1;
   protected $SecRoleId2;
   protected $SecRoleId3;
   protected $SecRoleId4;
   protected $SecRoleId5;
      
   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'base_user_role';
   }
   protected function DefineRelationMap()
   {
      return(array('uid' => 'Uid',
                   'dept_id' => 'DeptId',
				   'dept_id_1' => 'DeptId1',
      			   'dept_id_2' => 'DeptId2',
      			   'dept_id_3' => 'DeptId3',
      			   'dept_id_4' => 'DeptId4',
      			   'dept_id_5' => 'DeptId5',
                   'role_id' => 'RoleId',
                   'sec_role_id_1' => 'SecRoleId1',
                   'sec_role_id_2' => 'SecRoleId2',
                   'sec_role_id_3' => 'SecRoleId3',
                   'sec_role_id_4' => 'SecRoleId4',
                   'sec_role_id_5' => 'SecRoleId5'
                   ));
   }
}
class Base_User_Wechat extends CRUD
{
    protected $Id;
    protected $Uid;
    protected $WechatId;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_base_user_wechat';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'uid' => 'Uid',
                    'wechat_id' => 'WechatId'
        ));
    }
}
class Base_User_Wechat_View extends CRUD
{
    protected $Id;
    protected $Uid;
    protected $Name;
    protected $Username;
    protected $State;
    protected $Deleted;
    protected $WechatId;
    protected $Nickname;
    protected $Sex;
    protected $OpenId;
    protected $SessionId;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_base_user_wechat_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'uid' => 'Uid',
                    'name' => 'Name',
                    'username' => 'Username',
                    'state' => 'State',
                    'deleted' => 'Deleted',
                    'wechat_id' => 'WechatId',
                    'nickname' => 'Nickname',
                    'sex' => 'Sex',
                    'open_id' => 'OpenId',
                    'session_id' => 'SessionId'
        ));
    }
}
//1111111111111111111111111111111111111111111111
class Base_Cmcc extends CRUD
{
   protected $Id;
   protected $Phone;
   protected $Content;
   protected $Sended;
   protected $SendTime;
      
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'base_cmcc';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
                   'phone' => 'Phone',
                   'content' => 'Content',
                   'sended' => 'Sended',
                   'sendtime' => 'SendTime'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
?>