<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class Zhdd_Zbtx_Doc extends CRUD
{
    protected $Id;
    protected $DeptId;
    protected $OwnerId;
    protected $Level3Id;
    protected $ResultId;
    protected $Number;
    protected $IsDelete;
    protected $CreateDate;
    protected $Path;
    protected $FileName;
    protected $Explain;
    protected $FileType;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'zhdd_zbtx_doc';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'dept_id' => 'DeptId',
                    'owner_id' => 'OwnerId',
                    'level3_id' => 'Level3Id',
        			'result_id' => 'ResultId',
                    'number' => 'Number',
                    'is_delete' => 'IsDelete',
                    'create_date' => 'CreateDate',
                    'path' => 'Path',
                    'file_name' => 'FileName',
                    'explain' => 'Explain',
                    'file_type' => 'FileType'
        ));
    }
}
class Zhdd_Zbtx_Level1 extends CRUD
{
    protected $Id;
    protected $Name;
    protected $Number;
    protected $IsDelete;
    protected $ProjectId;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'zhdd_zbtx_level1';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'name' => 'Name',
        			'number' => 'Number',
        			'is_delete' => 'IsDelete',
                    'project_id' => 'ProjectId'
        ));
    }
}
class Zhdd_Zbtx_Level2 extends CRUD
{
    protected $Id;
    protected $Name;
    protected $Number;
    protected $IsDelete;
    protected $Level1Id;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'zhdd_zbtx_level2';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'name' => 'Name',
        			'number' => 'Number',
        			'is_delete' => 'IsDelete',
                    'level1_id' => 'Level1Id'
        ));
    }
}
class Zhdd_Zbtx_Level3 extends CRUD
{
    protected $Id;
    protected $Name;
    protected $Number;
    protected $IsDelete;
    protected $Level2Id;
    protected $Score;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'zhdd_zbtx_level3';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'name' => 'Name',
                    'level2_id' => 'Level2Id',
        			'number' => 'Number',
        			'is_delete' => 'IsDelete',
                    'score' => 'Score'
        ));
    }
}
class Zhdd_Zbtx_Project extends CRUD
{
    protected $Id;
    protected $Name;
    protected $CreateDate;
    protected $State;
    protected $ReleaseDate;
    protected $OwnerId;
    protected $Explain;
    protected $Scope;
    protected $IsDelete;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'zhdd_zbtx_project';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'name' => 'Name',
                    'create_date' => 'CreateDate',
                    'state' => 'State',
                    'release_date' => 'ReleaseDate',
                    'owner_id' => 'OwnerId',
        			'explain' => 'Explain',
        			'is_delete' => 'IsDelete',
                    'scope' => 'Scope'
        ));
    }
}
class Zhdd_Zbtx_Result extends CRUD
{
    protected $Id;
    protected $CreateDate;
    protected $OwnerId;
    protected $DeptId;
    protected $ProjectId;
    protected $State;
    protected $Result;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'zhdd_zbtx_result';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'create_date' => 'CreateDate',
                    'owner_id' => 'OwnerId',
                    'dept_id' => 'DeptId',
                    'project_id' => 'ProjectId',
                    'state' => 'State',
                    'result' => 'Result'
        ));
    }
}
class Base_User_Info_View extends CRUD
{
    protected $Uid;
    protected $Password;
    protected $Username;
    protected $State;
    protected $GroupId;
    protected $Name;
    protected $DeptId;
    protected $DeptName;
    protected $TypeId;
    protected $TypeName;

    protected function DefineKey()
    {
        return 'uid';
    }
    protected function DefineTableName()
    {
        return 'base_user_info_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'uid' => 'Uid',
                    'password' => 'Password',
                    'username' => 'Username',
                    'state' => 'State',
                    'group_id' => 'GroupId',
                    'name' => 'Name',
                    'dept_id' => 'DeptId',
                    'dept_name' => 'DeptName',
                    'type_id' => 'TypeId',
                    'type_name' => 'TypeName'
        ));
    }
}
class Zhdd_Zbtx_Level3_View extends CRUD
{
    protected $Id;
    protected $ProjectId;
    protected $ProjectName;
    protected $CreateDate;
    protected $State;
    protected $ReleaseDate;
    protected $OwnerId;
    protected $Scope;
    protected $Level1Id;
    protected $Level1Name;
    protected $Level2Id;
    protected $Level2Name;
    protected $Level3Name;
    protected $Score;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'zhdd_zbtx_level3_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'project_id' => 'ProjectId',
                    'project_name' => 'ProjectName',
                    'create_date' => 'CreateDate',
                    'state' => 'State',
                    'release_date' => 'ReleaseDate',
                    'owner_id' => 'OwnerId',
                    'scope' => 'Scope',
                    'level1_id' => 'Level1Id',
                    'level1_name' => 'Level1Name',
                    'level2_id' => 'Level2Id',
                    'level2_name' => 'Level2Name',
                    'level3_name' => 'Level3Name',
                    'score' => 'Score'
        ));
    }
}
class Zhdd_Zbtx_Result_View extends CRUD
{
    protected $Id;
    protected $CreateDate;
    protected $OwnerId;
    protected $OwnerName;
    protected $DeptId;
    protected $DeptName;
    protected $ProjectId;
    protected $ProjectName;
    protected $State;
    protected $Scope;
    protected $ResultState;
    protected $Result;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'zhdd_zbtx_result_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'create_date' => 'CreateDate',
                    'owner_id' => 'OwnerId',
                    'owner_name' => 'OwnerName',
                    'dept_id' => 'DeptId',
                    'dept_name' => 'DeptName',
                    'project_id' => 'ProjectId',
                    'project_name' => 'ProjectName',
                    'state' => 'State',
                    'scope' => 'Scope',
                    'result_state' => 'ResultState',
                    'result' => 'Result'
        ));
    }
}
?>