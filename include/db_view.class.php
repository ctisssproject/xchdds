<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class View_User_Right extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $RoleName;
   protected $Uid;
   protected $IconPathB;
   protected $WaitReadTable;
   protected $MiniIconPath;
   protected $Name;

   protected function DefineKey()
   {
      return 'base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'base_right` INNER JOIN `base_module` ON `base_right`.`module_id` = `base_module`.`module_id` INNER JOIN `base_role` ON `base_role`.`role_id` = `base_right`.`role_id` INNER JOIN `base_user_role` ON `base_user_role`.`role_id` = `base_right`.`role_id` INNER JOIN `base_module_icon` ON `base_module_icon`.`icon_id` = `base_module`.`icon_id` INNER JOIN `base_module_icon_mini` ON `base_module_icon_mini`.`mini_icon_id` = `base_module`.`mini_icon_id` INNER JOIN `base_user_info` ON `base_user_role`.`uid` = `base_user_info`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'base_right.right_id' => 'RightId',
                    'base_right.role_id' => 'RoleId',
                    'base_right.module_id' => 'ModuleId',
      				'base_module.name' => 'ModuleName',
      				'base_module.module' => 'Module',
      				'base_module.explain' => 'Explain',
     				'base_module.icon_id' => 'IconId',
      				'base_module.path' => 'Path',
      				'base_module.parent_module_id' => 'ParentModuleId',
                    'base_module.mini_icon_id' => 'MiniIconId',
      				'base_module_icon_mini.path' => 'MiniIconPath',
      				'base_role.name' => 'RoleName',
      				'base_user_role.uid' => 'Uid',
      				'base_module_icon.path' => 'IconPathB',
      				'base_user_info.name' => 'Name',
      				'base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_User_Right_Sec1 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $RoleName;
   protected $Uid;
   protected $IconPathB;
   protected $WaitReadTable;
   protected $MiniIconPath;
   protected $Name;

   protected function DefineKey()
   {
      return 'base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'base_right` INNER JOIN `base_module` ON `base_right`.`module_id` = `base_module`.`module_id` INNER JOIN `base_role` ON `base_role`.`role_id` = `base_right`.`role_id` INNER JOIN `base_user_role` ON `base_user_role`.`sec_role_id_1` = `base_right`.`role_id` INNER JOIN `base_module_icon` ON `base_module_icon`.`icon_id` = `base_module`.`icon_id` INNER JOIN `base_module_icon_mini` ON `base_module_icon_mini`.`mini_icon_id` = `base_module`.`mini_icon_id` INNER JOIN `base_user_info` ON `base_user_role`.`uid` = `base_user_info`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'base_right.right_id' => 'RightId',
                    'base_right.role_id' => 'RoleId',
                    'base_right.module_id' => 'ModuleId',
      				'base_module.name' => 'ModuleName',
      				'base_module.module' => 'Module',
      				'base_module.explain' => 'Explain',
     				'base_module.icon_id' => 'IconId',
      				'base_module.path' => 'Path',
      				'base_module.parent_module_id' => 'ParentModuleId',
                    'base_module.mini_icon_id' => 'MiniIconId',
      				'base_role.name' => 'RoleName',
      				'base_user_role.uid' => 'Uid',
      				'base_module_icon_mini.path' => 'MiniIconPath',
      				'base_module_icon.path' => 'IconPathB',
      				'base_user_info.name' => 'Name',
      				'base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_User_Right_Sec2 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $RoleName;
   protected $Uid;
   protected $IconPathB;
   protected $WaitReadTable;
   protected $MiniIconPath;
   protected $Name;

   protected function DefineKey()
   {
      return 'base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'base_right` INNER JOIN `base_module` ON `base_right`.`module_id` = `base_module`.`module_id` INNER JOIN `base_role` ON `base_role`.`role_id` = `base_right`.`role_id` INNER JOIN `base_user_role` ON `base_user_role`.`sec_role_id_2` = `base_right`.`role_id` INNER JOIN `base_module_icon` ON `base_module_icon`.`icon_id` = `base_module`.`icon_id` INNER JOIN `base_module_icon_mini` ON `base_module_icon_mini`.`mini_icon_id` = `base_module`.`mini_icon_id` INNER JOIN `base_user_info` ON `base_user_role`.`uid` = `base_user_info`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'base_right.right_id' => 'RightId',
                    'base_right.role_id' => 'RoleId',
                    'base_right.module_id' => 'ModuleId',
      				'base_module.name' => 'ModuleName',
      				'base_module.module' => 'Module',
      				'base_module.explain' => 'Explain',
     				'base_module.icon_id' => 'IconId',
      				'base_module.path' => 'Path',
      				'base_module.parent_module_id' => 'ParentModuleId',
                    'base_module.mini_icon_id' => 'MiniIconId',
      				'base_module_icon_mini.path' => 'MiniIconPath',
      				'base_role.name' => 'RoleName',
      				'base_user_info.name' => 'Name',
      				'base_user_role.uid' => 'Uid',
      				'base_module_icon.path' => 'IconPathB',
      				'base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_User_Right_Sec3 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $RoleName;
   protected $Uid;
   protected $IconPathB;
   protected $WaitReadTable;
   protected $MiniIconPath;
   protected $Name;

   protected function DefineKey()
   {
      return 'base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'base_right` INNER JOIN `base_module` ON `base_right`.`module_id` = `base_module`.`module_id` INNER JOIN `base_role` ON `base_role`.`role_id` = `base_right`.`role_id` INNER JOIN `base_user_role` ON `base_user_role`.`sec_role_id_3` = `base_right`.`role_id` INNER JOIN `base_module_icon` ON `base_module_icon`.`icon_id` = `base_module`.`icon_id` INNER JOIN `base_module_icon_mini` ON `base_module_icon_mini`.`mini_icon_id` = `base_module`.`mini_icon_id` INNER JOIN `base_user_info` ON `base_user_role`.`uid` = `base_user_info`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'base_right.right_id' => 'RightId',
                    'base_right.role_id' => 'RoleId',
                    'base_right.module_id' => 'ModuleId',
      				'base_module.name' => 'ModuleName',
      				'base_module.module' => 'Module',
      				'base_module.explain' => 'Explain',
     				'base_module.icon_id' => 'IconId',
      				'base_module.path' => 'Path',
      				'base_module.parent_module_id' => 'ParentModuleId',
                    'base_module.mini_icon_id' => 'MiniIconId',
      				'base_role.name' => 'RoleName',
      				'base_user_role.uid' => 'Uid',
      				'base_user_info.name' => 'Name',
      				'base_module_icon.path' => 'IconPathB',
      				'base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_User_Right_Sec4 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $RoleName;
   protected $Uid;
   protected $IconPathB;
   protected $WaitReadTable;
   protected $MiniIconPath;
   protected $Name;

   protected function DefineKey()
   {
      return 'base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'base_right` INNER JOIN `base_module` ON `base_right`.`module_id` = `base_module`.`module_id` INNER JOIN `base_role` ON `base_role`.`role_id` = `base_right`.`role_id` INNER JOIN `base_user_role` ON `base_user_role`.`sec_role_id_4` = `base_right`.`role_id` INNER JOIN `base_module_icon` ON `base_module_icon`.`icon_id` = `base_module`.`icon_id` INNER JOIN `base_module_icon_mini` ON `base_module_icon_mini`.`mini_icon_id` = `base_module`.`mini_icon_id` INNER JOIN `base_user_info` ON `base_user_role`.`uid` = `base_user_info`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'base_right.right_id' => 'RightId',
                    'base_right.role_id' => 'RoleId',
                    'base_right.module_id' => 'ModuleId',
      				'base_module.name' => 'ModuleName',
      				'base_module.module' => 'Module',
      				'base_module.explain' => 'Explain',
     				'base_module.icon_id' => 'IconId',
      				'base_module.path' => 'Path',
      				'base_module.parent_module_id' => 'ParentModuleId',
                    'base_module.mini_icon_id' => 'MiniIconId',
      				'base_module_icon_mini.path' => 'MiniIconPath',
      				'base_role.name' => 'RoleName',
      				'base_user_role.uid' => 'Uid',
      				'base_user_info.name' => 'Name',
      				'base_module_icon.path' => 'IconPathB',
      				'base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_User_Right_Sec5 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $RoleName;
   protected $Uid;
   protected $IconPathB;
   protected $WaitReadTable;
   protected $MiniIconPath;
   protected $Name;

   protected function DefineKey()
   {
      return 'base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'base_right` INNER JOIN `base_module` ON `base_right`.`module_id` = `base_module`.`module_id` INNER JOIN `base_role` ON `base_role`.`role_id` = `base_right`.`role_id` INNER JOIN `base_user_role` ON `base_user_role`.`sec_role_id_5` = `base_right`.`role_id` INNER JOIN `base_module_icon` ON `base_module_icon`.`icon_id` = `base_module`.`icon_id` INNER JOIN `base_module_icon_mini` ON `base_module_icon_mini`.`mini_icon_id` = `base_module`.`mini_icon_id` INNER JOIN `base_user_info` ON `base_user_role`.`uid` = `base_user_info`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'base_right.right_id' => 'RightId',
                    'base_right.role_id' => 'RoleId',
                    'base_right.module_id' => 'ModuleId',
      				'base_module.name' => 'ModuleName',
      				'base_module.module' => 'Module',
      				'base_module.explain' => 'Explain',
     				'base_module.icon_id' => 'IconId',
      				'base_module.path' => 'Path',
      				'base_module.parent_module_id' => 'ParentModuleId',
                    'base_module.mini_icon_id' => 'MiniIconId',
      				'base_module_icon_mini.path' => 'MiniIconPath',
      				'base_role.name' => 'RoleName',
      				'base_user_role.uid' => 'Uid',
      				'base_user_info.name' => 'Name',
      				'base_module_icon.path' => 'IconPathB',
      				'base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_Menu_Right extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $RoleName;
   protected $Uid;
   protected $MiniIconPath;
   protected $WaitReadTable;

   protected function DefineKey()
   {
      return 'base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'base_right` INNER JOIN `base_module` ON `base_right`.`module_id` = `base_module`.`module_id` INNER JOIN `base_role` ON `base_role`.`role_id` = `base_right`.`role_id` INNER JOIN `base_user_role` ON `base_user_role`.`role_id` = `base_right`.`role_id` INNER JOIN `base_module_icon_mini` ON `base_module_icon_mini`.`mini_icon_id` = `base_module`.`mini_icon_id';
   }
   protected function DefineRelationMap()
   {
      return(array( 'base_right.right_id' => 'RightId',
                    'base_right.role_id' => 'RoleId',
                    'base_right.module_id' => 'ModuleId',
      				'base_module.name' => 'ModuleName',
      				'base_module.module' => 'Module',
      				'base_module.explain' => 'Explain',
     				'base_module.icon_id' => 'IconId',
      				'base_module.path' => 'Path',
      				'base_module.parent_module_id' => 'ParentModuleId',
                    'base_module.mini_icon_id' => 'MiniIconId',
      				'base_role.name' => 'RoleName',
      				'base_user_role.uid' => 'Uid',
      				'base_module_icon_mini.path' => 'MiniIconPath',
      				'base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_Menu_Right_Sec1 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $RoleName;
   protected $Uid;
   protected $MiniIconPath;
   protected $WaitReadTable;

   protected function DefineKey()
   {
      return 'base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'base_right` INNER JOIN `base_module` ON `base_right`.`module_id` = `base_module`.`module_id` INNER JOIN `base_role` ON `base_role`.`role_id` = `base_right`.`role_id` INNER JOIN `base_user_role` ON `base_user_role`.`sec_role_id_1` = `base_right`.`role_id` INNER JOIN `base_module_icon_mini` ON `base_module_icon_mini`.`mini_icon_id` = `base_module`.`mini_icon_id';
   }
   protected function DefineRelationMap()
   {
      return(array( 'base_right.right_id' => 'RightId',
                    'base_right.role_id' => 'RoleId',
                    'base_right.module_id' => 'ModuleId',
      				'base_module.name' => 'ModuleName',
      				'base_module.module' => 'Module',
      				'base_module.explain' => 'Explain',
     				'base_module.icon_id' => 'IconId',
      				'base_module.path' => 'Path',
      				'base_module.parent_module_id' => 'ParentModuleId',
                    'base_module.mini_icon_id' => 'MiniIconId',
      				'base_role.name' => 'RoleName',
      				'base_user_role.uid' => 'Uid',
      				'base_module_icon_mini.path' => 'MiniIconPath',
      				'base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_Menu_Right_Sec2 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $RoleName;
   protected $Uid;
   protected $MiniIconPath;
   protected $WaitReadTable;

   protected function DefineKey()
   {
      return 'base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'base_right` INNER JOIN `base_module` ON `base_right`.`module_id` = `base_module`.`module_id` INNER JOIN `base_role` ON `base_role`.`role_id` = `base_right`.`role_id` INNER JOIN `base_user_role` ON `base_user_role`.`sec_role_id_2` = `base_right`.`role_id` INNER JOIN `base_module_icon_mini` ON `base_module_icon_mini`.`mini_icon_id` = `base_module`.`mini_icon_id';
   }
   protected function DefineRelationMap()
   {
      return(array( 'base_right.right_id' => 'RightId',
                    'base_right.role_id' => 'RoleId',
                    'base_right.module_id' => 'ModuleId',
      				'base_module.name' => 'ModuleName',
      				'base_module.module' => 'Module',
      				'base_module.explain' => 'Explain',
     				'base_module.icon_id' => 'IconId',
      				'base_module.path' => 'Path',
      				'base_module.parent_module_id' => 'ParentModuleId',
                    'base_module.mini_icon_id' => 'MiniIconId',
      				'base_role.name' => 'RoleName',
      				'base_user_role.uid' => 'Uid',
      				'base_module_icon_mini.path' => 'MiniIconPath',
      				'base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_Menu_Right_Sec3 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $RoleName;
   protected $Uid;
   protected $MiniIconPath;
   protected $WaitReadTable;

   protected function DefineKey()
   {
      return 'base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'base_right` INNER JOIN `base_module` ON `base_right`.`module_id` = `base_module`.`module_id` INNER JOIN `base_role` ON `base_role`.`role_id` = `base_right`.`role_id` INNER JOIN `base_user_role` ON `base_user_role`.`sec_role_id_3` = `base_right`.`role_id` INNER JOIN `base_module_icon_mini` ON `base_module_icon_mini`.`mini_icon_id` = `base_module`.`mini_icon_id';
   }
   protected function DefineRelationMap()
   {
      return(array( 'base_right.right_id' => 'RightId',
                    'base_right.role_id' => 'RoleId',
                    'base_right.module_id' => 'ModuleId',
      				'base_module.name' => 'ModuleName',
      				'base_module.module' => 'Module',
      				'base_module.explain' => 'Explain',
     				'base_module.icon_id' => 'IconId',
      				'base_module.path' => 'Path',
      				'base_module.parent_module_id' => 'ParentModuleId',
                    'base_module.mini_icon_id' => 'MiniIconId',
      				'base_role.name' => 'RoleName',
      				'base_user_role.uid' => 'Uid',
      				'base_module_icon_mini.path' => 'MiniIconPath',
      				'base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_Menu_Right_Sec4 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $RoleName;
   protected $Uid;
   protected $MiniIconPath;
   protected $WaitReadTable;

   protected function DefineKey()
   {
      return 'base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'base_right` INNER JOIN `base_module` ON `base_right`.`module_id` = `base_module`.`module_id` INNER JOIN `base_role` ON `base_role`.`role_id` = `base_right`.`role_id` INNER JOIN `base_user_role` ON `base_user_role`.`sec_role_id_4` = `base_right`.`role_id` INNER JOIN `base_module_icon_mini` ON `base_module_icon_mini`.`mini_icon_id` = `base_module`.`mini_icon_id';
   }
   protected function DefineRelationMap()
   {
      return(array( 'base_right.right_id' => 'RightId',
                    'base_right.role_id' => 'RoleId',
                    'base_right.module_id' => 'ModuleId',
      				'base_module.name' => 'ModuleName',
      				'base_module.module' => 'Module',
      				'base_module.explain' => 'Explain',
     				'base_module.icon_id' => 'IconId',
      				'base_module.path' => 'Path',
      				'base_module.parent_module_id' => 'ParentModuleId',
                    'base_module.mini_icon_id' => 'MiniIconId',
      				'base_role.name' => 'RoleName',
      				'base_user_role.uid' => 'Uid',
      				'base_module_icon_mini.path' => 'MiniIconPath',
      				'base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_Menu_Right_Sec5 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $RoleName;
   protected $Uid;
   protected $MiniIconPath;
   protected $WaitReadTable;

   protected function DefineKey()
   {
      return 'base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'base_right` INNER JOIN `base_module` ON `base_right`.`module_id` = `base_module`.`module_id` INNER JOIN `base_role` ON `base_role`.`role_id` = `base_right`.`role_id` INNER JOIN `base_user_role` ON `base_user_role`.`sec_role_id_5` = `base_right`.`role_id` INNER JOIN `base_module_icon_mini` ON `base_module_icon_mini`.`mini_icon_id` = `base_module`.`mini_icon_id';
   }
   protected function DefineRelationMap()
   {
      return(array( 'base_right.right_id' => 'RightId',
                    'base_right.role_id' => 'RoleId',
                    'base_right.module_id' => 'ModuleId',
      				'base_module.name' => 'ModuleName',
      				'base_module.module' => 'Module',
      				'base_module.explain' => 'Explain',
     				'base_module.icon_id' => 'IconId',
      				'base_module.path' => 'Path',
      				'base_module.parent_module_id' => 'ParentModuleId',
                    'base_module.mini_icon_id' => 'MiniIconId',
      				'base_role.name' => 'RoleName',
      				'base_user_role.uid' => 'Uid',
      				'base_module_icon_mini.path' => 'MiniIconPath',
      				'base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_User_Dept extends CRUD
{
   protected $DeptId;
   protected $DeptName;
   protected $ParentId;
   protected $Number;
   protected $Fax;
   protected $Address;
   protected $Uid;
   protected $Name;
   protected $RoleId;
   protected $RoleName;
   protected $Delete;
   protected $Email;
   protected $State;
   protected $Sex;
   protected $CustomEmail;
   protected $MobilePhone;
   protected $Phone;
   protected $SecRoleId1;
   protected $SecRoleId2;
   protected $SecRoleId3;
   protected $SecRoleId4;
   protected $SecRoleId5;
   
   protected function DefineKey()
   {
      return 'base_dept.dept_id';
   }
   protected function DefineTableName()
   {
      return 'base_dept` INNER JOIN `base_user_role` ON `base_user_role`.`dept_id` = `base_dept`.`dept_id` INNER JOIN `base_user_info` ON `base_user_role`.`uid` = `base_user_info`.`uid` INNER JOIN `base_user` ON `base_user_role`.`uid` = `base_user`.`uid` INNER JOIN `base_user_info_custom` ON `base_user_role`.`uid` = `base_user_info_custom`.`uid` INNER JOIN `base_role` ON `base_role`.`role_id` = `base_user_role`.`role_id';
   }
   protected function DefineRelationMap()
   {
      return(array('base_dept.dept_id' => 'DeptId',
      				'base_dept.name' => 'DeptName',
      				'base_dept.parent_id' => 'ParentId',
      				'base_dept.number' => 'Number',
      				'base_user_info.uid' => 'Uid',
      				'base_user_info.name' => 'Name',
      				'base_user_info.sex' => 'Sex',
      				'base_user_info.email' => 'Email',
      				'base_user_info.delete' => 'Delete',
     				'base_user_role.role_id' => 'RoleId',
      				'base_role.name' => 'RoleName',
     				'base_user.state' => 'State',
     				'base_user_info_custom.email' => 'CustomEmail',
      				'base_user_info_custom.mobile_phone' => 'MobilePhone',
      				'base_user_info_custom.phone' => 'Phone',
                    'base_user_role.sec_role_id_1' => 'SecRoleId1',
                    'base_user_role.sec_role_id_2' => 'SecRoleId2',
                    'base_user_role.sec_role_id_3' => 'SecRoleId3',
                    'base_user_role.sec_role_id_4' => 'SecRoleId4',
                    'base_user_role.sec_role_id_5' => 'SecRoleId5'
                   ));
   }
}
class View_User_List extends CRUD
{
   protected $Uid;
   protected $UserName;
   protected $Name;
   protected $RoleName;
   protected $State;
   protected $Type;
   protected $Sex;
   protected $Phone;
   protected $DeptId;
   protected $SchoolId;
   protected $Email;
   protected $GroupId;
   protected $AmUsername;
   protected $SecRole1;
   protected $SecRole2;
   protected $SecRole3;
   protected $SecRole4;
   protected $SecRole5;
   protected $RoleId;
   
   protected function DefineKey()
   {
      return 'base_user.uid';
   }
   protected function DefineTableName()
   {
      return 'base_user` INNER JOIN `base_user_info` ON `base_user_info`.`uid` = `base_user`.`uid` INNER JOIN `base_user_role` ON `base_user`.`uid` = `base_user_role`.`uid` INNER JOIN `base_role` ON `base_role`.`role_id` = `base_user_role`.`role_id';
   }
   protected function DefineRelationMap()
   {
      return(array('base_user.uid' => 'Uid',
      				'base_user.username' => 'UserName',
      				'base_user.type' => 'Type',
      				'base_user.state' => 'State',
      'base_user.group_id' => 'GroupId',
      				'base_user_info.name' => 'Name',
     				'base_user_info.sex' => 'Sex',
      				'base_user_info.phone' => 'Phone',
      				'base_user_info.email' => 'Email',
      				'base_user_info.school_id' => 'SchoolId',
      				'base_user_info.am_username' => 'AmUsername',
      				'base_user_role.dept_id' => 'DeptId',
      				'base_user_role.role_id' => 'RoleId',
      				'base_role.name' => 'RoleName',
      				'base_user_role.sec_role_id_1' => 'SecRole1',
				    'base_user_role.sec_role_id_2' => 'SecRole2',
				    'base_user_role.sec_role_id_3' => 'SecRole3',
				    'base_user_role.sec_role_id_4' => 'SecRole4',
				    'base_user_role.sec_role_id_5' => 'SecRole5',
                   ));
   }
}
class View_AddRole_Module extends CRUD
{
   protected $ModuleId;
   protected $Name;
   protected $Explain;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $Path;
   protected $Module;
   protected function DefineKey()
   {
      return 'base_module.module_id';
   }
   protected function DefineTableName()
   {
      return 'base_module` INNER JOIN `base_module_icon_mini` ON `base_module_icon_mini`.`mini_icon_id` = `base_module`.`mini_icon_id';
   }
   protected function DefineRelationMap()
   {
      return(array('base_module.module_id' => 'ModuleId',
      				'base_module.name' => 'Name',
      				'base_module.explain' => 'Explain',
      				'base_module.module' => 'Module',
      				'base_module.parent_module_id' => 'ParentModuleId',
                   	'base_module.mini_icon_id' => 'MiniIconId',
      				'base_module_icon_mini.path' => 'Path'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class View_User_Role extends CRUD
{
   protected $Uid;
   protected $DeptId;
   protected $RoleId;
   protected $SecRoleId1;
   protected $SecRoleId2;
   protected $SecRoleId3;
   protected $SecRoleId4;
   protected $SecRoleId5;
   protected $Name;
      
   protected function DefineKey()
   {
      return 'base_user_role.uid';
   }
   protected function DefineTableName()
   {
      return 'base_user_role` INNER JOIN `base_user_info` ON `base_user_info`.`uid` = `base_user_role`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array('base_user_role.uid' => 'Uid',
                   'base_user_role.dept_id' => 'DeptId',
                   'base_user_role.role_id' => 'RoleId',
                   'base_user_role.sec_role_id_1' => 'SecRoleId1',
                   'base_user_role.sec_role_id_2' => 'SecRoleId2',
                   'base_user_role.sec_role_id_3' => 'SecRoleId3',
                   'base_user_role.sec_role_id_4' => 'SecRoleId4',
                   'base_user_role.sec_role_id_5' => 'SecRoleId5',
      			   'base_user_info.name' => 'Name'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class View_User_Info extends CRUD
{
   protected $State;
   protected $Username;
   protected $Uid;
   protected $Name;
   protected $Email;
   protected $DeptId;
   protected $EmailPassword;
    
   protected function DefineKey()
   {
      return 'base_user.uid';
   }
   protected function DefineTableName()
   {
      return 'base_user` INNER JOIN `base_user_info` ON `base_user_info`.`uid` = `base_user`.`uid` INNER JOIN `base_user_role` ON `base_user_role`.`uid` = `base_user`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array('base_user.uid' => 'Uid',
                   'base_user.state' => 'State',
      				'base_user.username' => 'Username',
                   'base_user_info.email' => 'Email',
      				'base_user_info.name' => 'Name',
      'base_user_role.dept_id' => 'DeptId',
      				'base_user_info.email_password' => 'EmailPassword',
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class View_System_Msg extends CRUD
{
   protected $Id;
   protected $Uid;
   protected $Text;
   protected $ParentModuleId;
   protected $ModuleId;
   protected $Type;
   protected $AmUsername;
   protected $Readed;
   protected $AmReaded;

   protected function DefineKey()
   {
      return 'base_system_msg.id';
   }
   protected function DefineTableName()
   {
      return 'base_system_msg` INNER JOIN `base_user_info` ON `base_user_info`.`uid` = `base_system_msg`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array('base_system_msg.id' => 'Id',               
                   'base_system_msg.uid' => 'Uid',          
                   'base_system_msg.text' => 'Text',          
                   'base_system_msg.parent_module_id' => 'ParentModuleId',
                   'base_system_msg.module_id' => 'ModuleId',         
                   'base_system_msg.readed' => 'Readed',
      			   'base_system_msg.type' => 'Type',
      			   'base_system_msg.am_readed' => 'AmReaded',
      			   'base_user_info.am_username' => 'AmUsername'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class View_Online_User extends CRUD
{
   protected $Uid;
   protected $Online;
   protected $Name;

   protected function DefineKey()
   {
      return 'base_user_login.uid';
   }
   protected function DefineTableName()
   {
      return 'base_user_login` INNER JOIN `base_user_info` ON `base_user_info`.`uid` = `base_user_login`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array('base_user_login.uid' => 'Uid',          
                   'base_user_login.online' => 'Online',          
                   'base_user_info.name' => 'Name'
                   ));
   }
}
class ViewSurveyDept extends CRUD
{
   protected $Id;
   protected $Name;
   protected $Type;
   protected $Uid;
   protected $TypeName;
   protected $TeacherName; 
   protected function DefineKey()
   {
      return 'survey_dept.id';
   }
   protected function DefineTableName()
   {
      return 'survey_dept` INNER JOIN `base_user_info` ON `base_user_info`.`uid` = `survey_dept`.`uid` INNER JOIN `base_school_type` ON `base_school_type`.`id` = `survey_dept`.`type';
   }
   protected function DefineRelationMap()
   {
      return(array('survey_dept.id' => 'Id',
      							'survey_dept.name' => 'Name',
      'survey_dept.type' => 'Type',
      'base_school_type.name' => 'TypeName',
      'survey_dept.delete' => 'Delete',
      'base_user_info.name' => 'TeacherName',
      'survey_dept.uid' => 'Uid'
                   ));
   }
}
class View_Group_Dept_Member extends CRUD
{
   protected $Id;
   protected $Name;
   protected $GroupId;
   protected $Uid;
   protected $Type;
   
   protected function DefineKey()
   {
      return 'base_group_member.id';
   }
   protected function DefineTableName()
   {
      return 'base_group_member` INNER JOIN `base_dept` ON `base_dept`.`dept_id` = `base_group_member`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array('base_group_member.id' => 'Id',
      				'base_dept.name' => 'Name',
      				'base_group_member.group_id' => 'GroupId',
      				'base_group_member.uid' => 'Uid',
      				'base_group_member.type' => 'Type'
                   ));
   }
}
class View_Group_User_Member extends CRUD
{
   protected $Id;
   protected $Name;
   protected $GroupId;
   protected $Uid;
   protected $Type;
   
   protected function DefineKey()
   {
      return 'base_group_member.id';
   }
   protected function DefineTableName()
   {
      return 'base_group_member` INNER JOIN `base_user_info` ON `base_user_info`.`uid` = `base_group_member`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array('base_group_member.id' => 'Id',
      				'base_user_info.name' => 'Name',
      				'base_group_member.group_id' => 'GroupId',
      				'base_group_member.uid' => 'Uid',
      				'base_group_member.type' => 'Type'
                   ));
   }
}
?>