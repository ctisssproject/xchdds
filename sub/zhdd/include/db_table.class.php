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
class Zhdd_Appraise extends CRUD
{
    protected $Id;
    protected $Title;
    protected $State;
    protected $Type;
    protected $Info;
    protected $CreateDate;
    protected $ReleaseDate;
    protected $EndDate;
    protected $Comment;
    protected $IsDeleted;
    protected $IsAuto;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'zhdd_appraise';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'title' => 'Title',
                    'state' => 'State',
                    'info' => 'Info',
        			'type' => 'Type',
                    'create_date' => 'CreateDate',
                    'release_date' => 'ReleaseDate',
                    'end_date' => 'EndDate',
        			'is_deleted' => 'IsDeleted',
        			'is_auto' => 'IsAuto',
                    'comment' => 'Comment'
        ));
    }
}
class Zhdd_Appraise_Answers extends CRUD
{
    protected $Id;
    protected $AppraiseId;
    protected $Uid;
    protected $Info;
    protected $SchoolId;
    protected $Date;
    protected $Parameter;
    protected $Suggest;
    protected $Answer1;
    protected $Answer2;
    protected $Answer3;
    protected $Answer4;
    protected $Answer5;
    protected $Answer6;
    protected $Answer7;
    protected $Answer8;
    protected $Answer9;
    protected $Answer10;
    protected $Answer11;
    protected $Answer12;
    protected $Answer13;
    protected $Answer14;
    protected $Answer15;
    protected $Answer16;
    protected $Answer17;
    protected $Answer18;
    protected $Answer19;
    protected $Answer20;
    protected $Answer21;
    protected $Answer22;
    protected $Answer23;
    protected $Answer24;
    protected $Answer25;
    protected $Answer26;
    protected $Answer27;
    protected $Answer28;
    protected $Answer29;
    protected $Answer30;
    protected $Answer31;
    protected $Answer32;
    protected $Answer33;
    protected $Answer34;
    protected $Answer35;
    protected $Answer36;
    protected $Answer37;
    protected $Answer38;
    protected $Answer39;
    protected $Answer40;
    protected $Answer41;
    protected $Answer42;
    protected $Answer43;
    protected $Answer44;
    protected $Answer45;
    protected $Answer46;
    protected $Answer47;
    protected $Answer48;
    protected $Answer49;
    protected $Answer50;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'zhdd_appraise_answers';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'appraise_id' => 'AppraiseId',
                    'uid' => 'Uid',
                    'info' => 'Info',
                    'school_id' => 'SchoolId',
        			'parameter' => 'Parameter',
        			'suggest' => 'Suggest',
                    'date' => 'Date',
                    'answer_1' => 'Answer1',
                    'answer_2' => 'Answer2',
                    'answer_3' => 'Answer3',
                    'answer_4' => 'Answer4',
                    'answer_5' => 'Answer5',
                    'answer_6' => 'Answer6',
                    'answer_7' => 'Answer7',
                    'answer_8' => 'Answer8',
                    'answer_9' => 'Answer9',
                    'answer_10' => 'Answer10',
                    'answer_11' => 'Answer11',
                    'answer_12' => 'Answer12',
                    'answer_13' => 'Answer13',
                    'answer_14' => 'Answer14',
                    'answer_15' => 'Answer15',
                    'answer_16' => 'Answer16',
                    'answer_17' => 'Answer17',
                    'answer_18' => 'Answer18',
                    'answer_19' => 'Answer19',
                    'answer_20' => 'Answer20',
                    'answer_21' => 'Answer21',
                    'answer_22' => 'Answer22',
                    'answer_23' => 'Answer23',
                    'answer_24' => 'Answer24',
                    'answer_25' => 'Answer25',
                    'answer_26' => 'Answer26',
                    'answer_27' => 'Answer27',
                    'answer_28' => 'Answer28',
                    'answer_29' => 'Answer29',
                    'answer_30' => 'Answer30',
                    'answer_31' => 'Answer31',
                    'answer_32' => 'Answer32',
                    'answer_33' => 'Answer33',
                    'answer_34' => 'Answer34',
                    'answer_35' => 'Answer35',
                    'answer_36' => 'Answer36',
                    'answer_37' => 'Answer37',
                    'answer_38' => 'Answer38',
                    'answer_39' => 'Answer39',
                    'answer_40' => 'Answer40',
                    'answer_41' => 'Answer41',
                    'answer_42' => 'Answer42',
                    'answer_43' => 'Answer43',
                    'answer_44' => 'Answer44',
                    'answer_45' => 'Answer45',
                    'answer_46' => 'Answer46',
                    'answer_47' => 'Answer47',
                    'answer_48' => 'Answer48',
                    'answer_49' => 'Answer49',
                    'answer_50' => 'Answer50'
        ));
    }
}
class Zhdd_Appraise_Info_Item extends CRUD
{
    protected $Id;
    protected $Name;
    protected $Type;
    protected $Number;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'zhdd_appraise_info_item';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'name' => 'Name',
                    'type' => 'Type',
                    'number' => 'Number'
        ));
    }
}
class Zhdd_Appraise_Options extends CRUD
{
    protected $Id;
    protected $QuestionId;
    protected $Option;
    protected $Number;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'zhdd_appraise_options';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'question_id' => 'QuestionId',
                    'option' => 'Option',
                    'number' => 'Number'
        ));
    }
}
class Zhdd_Appraise_Questions extends CRUD
{
    protected $Id;
    protected $AppraiseId;
    protected $Question;
    protected $Type;
    protected $Number;
    protected $IsMust;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'zhdd_appraise_questions';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'appraise_id' => 'AppraiseId',
                    'question' => 'Question',
                    'type' => 'Type',
        			'is_must' => 'IsMust',
                    'number' => 'Number'
        ));
    }
}
class Zhdd_Appraise_Answers_View extends CRUD
{
	protected $Id;
	protected $AppraiseId;
	protected $Suggest;
	protected $Parameter;
	protected $IsAuto;
	protected $Uid;
	protected $SchoolId;
	protected $SchoolName;
	protected $OwnerName;
	protected $AppraiseTitle;
	protected $AppraiseState;
	protected $AppraiseType;
	protected $AppraiseInfo;
	protected $Info;
	protected $Date;
	protected $Answer1;
	protected $Answer2;
	protected $Answer3;
	protected $Answer4;
	protected $Answer5;
	protected $Answer6;
	protected $Answer7;
	protected $Answer8;
	protected $Answer9;
	protected $Answer10;
	protected $Answer11;
	protected $Answer12;
	protected $Answer13;
	protected $Answer14;
	protected $Answer15;
	protected $Answer16;
	protected $Answer17;
	protected $Answer18;
	protected $Answer19;
	protected $Answer20;
	protected $Answer21;
	protected $Answer22;
	protected $Answer23;
	protected $Answer24;
	protected $Answer25;
	protected $Answer26;
	protected $Answer27;
	protected $Answer28;
	protected $Answer29;
	protected $Answer30;
	protected $Answer31;
	protected $Answer32;
	protected $Answer33;
	protected $Answer34;
	protected $Answer35;
	protected $Answer36;
	protected $Answer37;
	protected $Answer38;
	protected $Answer39;
	protected $Answer40;
	protected $Answer41;
	protected $Answer42;
	protected $Answer43;
	protected $Answer44;
	protected $Answer45;
	protected $Answer46;
	protected $Answer47;
	protected $Answer48;
	protected $Answer49;
	protected $Answer50;
	
	protected function DefineKey()
	{
		return 'id';
	}
	protected function DefineTableName()
	{
		return 'zhdd_appraise_answers_view';
	}
	protected function DefineRelationMap()
	{
		return(array(
				'id' => 'Id',
				'appraise_id' => 'AppraiseId',
				'suggest' => 'Suggest',
				'parameter' => 'Parameter',
				'is_auto' => 'IsAuto',
				'uid' => 'Uid',
				'school_id' => 'SchoolId',
				'school_name' => 'SchoolName',
				'owner_name' => 'OwnerName',
				'appraise_title' => 'AppraiseTitle',
				'appraise_state' => 'AppraiseState',
				'appraise_type' => 'AppraiseType',
				'appraise_info' => 'AppraiseInfo',
				'info' => 'Info',
				'date' => 'Date',
				'answer_1' => 'Answer1',
				'answer_2' => 'Answer2',
				'answer_3' => 'Answer3',
				'answer_4' => 'Answer4',
				'answer_5' => 'Answer5',
				'answer_6' => 'Answer6',
				'answer_7' => 'Answer7',
				'answer_8' => 'Answer8',
				'answer_9' => 'Answer9',
				'answer_10' => 'Answer10',
				'answer_11' => 'Answer11',
				'answer_12' => 'Answer12',
				'answer_13' => 'Answer13',
				'answer_14' => 'Answer14',
				'answer_15' => 'Answer15',
				'answer_16' => 'Answer16',
				'answer_17' => 'Answer17',
				'answer_18' => 'Answer18',
				'answer_19' => 'Answer19',
				'answer_20' => 'Answer20',
				'answer_21' => 'Answer21',
				'answer_22' => 'Answer22',
				'answer_23' => 'Answer23',
				'answer_24' => 'Answer24',
				'answer_25' => 'Answer25',
				'answer_26' => 'Answer26',
				'answer_27' => 'Answer27',
				'answer_28' => 'Answer28',
				'answer_29' => 'Answer29',
				'answer_30' => 'Answer30',
				'answer_31' => 'Answer31',
				'answer_32' => 'Answer32',
				'answer_33' => 'Answer33',
				'answer_34' => 'Answer34',
				'answer_35' => 'Answer35',
				'answer_36' => 'Answer36',
				'answer_37' => 'Answer37',
				'answer_38' => 'Answer38',
				'answer_39' => 'Answer39',
				'answer_40' => 'Answer40',
				'answer_41' => 'Answer41',
				'answer_42' => 'Answer42',
				'answer_43' => 'Answer43',
				'answer_44' => 'Answer44',
				'answer_45' => 'Answer45',
				'answer_46' => 'Answer46',
				'answer_47' => 'Answer47',
				'answer_48' => 'Answer48',
				'answer_49' => 'Answer49',
				'answer_50' => 'Answer50'
		));
	}
}
class Zhdd_Appraise_Input extends CRUD
{
	protected $Id;
	protected $SurveyId;
	protected $SchoolId;
	protected $SchoolName;
	protected $Type;
	protected $Key1;
	protected $Key2;
	protected $Key3;
	protected $Key4;
	protected $Key5;
	protected $Key6;
	protected $Key7;
	protected $Key8;
	protected $Key9;
	protected $Key10;
	
	protected function DefineKey()
	{
		return 'id';
	}
	protected function DefineTableName()
	{
		return 'zhdd_appraise_input';
	}
	protected function DefineRelationMap()
	{
		return(array(
				'id' => 'Id',
				'survey_id' => 'SurveyId',
				'school_id' => 'SchoolId',
				'school_name' => 'SchoolName',
				'type' => 'Type',
				'key1' => 'Key1',
				'key2' => 'Key2',
				'key3' => 'Key3',
				'key4' => 'Key4',
				'key5' => 'Key5',
				'key6' => 'Key6',
				'key7' => 'Key7',
				'key8' => 'Key8',
				'key9' => 'Key9',
				'key10' => 'Key10'
		));
	}
}
?>