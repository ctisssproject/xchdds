<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
class SurveySubject extends CRUD
{
   protected $Id;
   protected $Title;
   protected $Type;
   protected $Scope;
   protected $Delete;
	 
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'survey_subject';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
      							'title' => 'Title',
      'scope' => 'Scope',
      'delete' => 'Delete',
      							'type' => 'Type'
                   ));
   }
}
class SurveyCode extends CRUD
{
   protected $Id;
   protected $Code;
   protected $State;
   protected $Type;
	 
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'survey_code';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
      							'code' => 'Code',
      'state' => 'State',
      'type' => 'Type'
                   ));
   }
}
class SurveyAnswer extends CRUD
{
   protected $Id;
   protected $OptionId;
   protected $SetupId;
   protected $Sum;
   protected $Score;
   protected $TypeId;
   protected $Comment;
	 
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'survey_answer';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
      							'option_id' => 'OptionId',
      							'setup_id' => 'SetupId',
      							'sum' => 'Sum',
      'score' => 'Score',
      'type_id' => 'TypeId',
      							'comment' => 'Comment'
                   ));
   }
}
class SurveyOption extends CRUD
{
   protected $OptionId;
   protected $Content;
   protected $Number;
   protected $ItemId;
	 
   protected function DefineKey()
   {
      return 'option_id';
   }
   protected function DefineTableName()
   {
      return 'survey_option';
   }
   protected function DefineRelationMap()
   {
      return(array('option_id' => 'OptionId',
      							'content' => 'Content',
      'item_id' => 'ItemId',
      							'number' => 'Number',
                   ));
   }
	public function DeleteOption($n_id)
	{
		for($i=0;$i<1000;$i++)
		{
			if ($this->O_Result)
			{
				break;
			}else{
				$this->Execute ( 'DELETE FROM `survey_option` WHERE `survey_option`.`item_id`='.$n_id );
			}
		}		
	}
}
class SurveyItem extends CRUD
{
   protected $ItemId;
   protected $SubjectId;
   protected $Content;
   protected $Delete;
   protected $Number;
   protected $TypeId;
   protected $Type;
   protected $Score;
	 
   protected function DefineKey()
   {
      return 'item_id';
   }
   protected function DefineTableName()
   {
      return 'survey_item';
   }
   protected function DefineRelationMap()
   {
      return(array('item_id' => 'ItemId',
      							'subject_id' => 'SubjectId',
      'delete' => 'Delete',
      'type' => 'Type',
      							'content' => 'Content',
      'score' => 'Score',
      							'number' => 'Number',
      							'type_id' => 'TypeId'
                   ));
   }
}
class SurveyType extends CRUD
{
   protected $Id;
   protected $Name;
   protected $Number;
   protected $Type;
	 
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'survey_type';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
      							'name' => 'Name',
      'number' => 'Number',
      'type' => 'Type'
                   ));
   }
}
class SurveySetup extends CRUD
{
   protected $Id;
   protected $Start;
   protected $End;
   protected $Dept;
	 
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'survey_setup';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
      							'start' => 'Start',
      'dept' => 'Dept',
      'end' => 'End'
                   ));
   }
}
class SurveyDept extends CRUD
{
   protected $Id;
   protected $Name;
   protected $Type;
   protected $Uid;
   protected $Delete;
	 
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'survey_dept';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
      							'name' => 'Name',
      'type' => 'Type',
      'delete' => 'Delete',
      'uid' => 'Uid'
                   ));
   }
}
class SurveyTotalItem extends CRUD
{
   protected $Id;
   protected $Start;
   protected $SubjectId;
   protected $Type;
   protected $DeptId;
   protected $End;
   protected $Delete; 
   protected $Date; 
   protected $Sum;
   protected $Limit;
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'survey_total_item';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
      				'start' => 'Start',
      				'subject_id' => 'SubjectId',
      				'type' => 'Type',
      				'dept_id' => 'DeptId',
      'delete' => 'Delete',
      'limit' => 'Limit',
      'date' => 'Date',
      'sum' => 'Sum',
      				'end' => 'End'
                   ));
   }
}
class SurveyTotalOption extends CRUD
{
   protected $Id;
   protected $OptionId;
   protected $TotalId;
   protected $ItemId;
   protected $Sum;
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'survey_total_option';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
      				'option_id' => 'OptionId',
      				'total_id' => 'TotalId',
      'item_id' => 'ItemId',
      				'sum' => 'Sum'
                   ));
   }
}
class SurveyTotalAnswer extends CRUD
{
   protected $Id;
   protected $TotalId;
   protected $ItemId;
   protected $Answer;
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'survey_total_answer';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
      				'total_id' => 'TotalId',
      'item_id' => 'ItemId',
      				'answer' => 'Answer'
                   ));
   }
}
class SurveyItemType extends CRUD
{
   protected $Id;
   protected $Name;
   protected $Number;
   protected $Type;
	 
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'survey_item_type';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
      							'name' => 'Name',
      'number' => 'Number',
      'type' => 'Type'
                   ));
   }
}
?>