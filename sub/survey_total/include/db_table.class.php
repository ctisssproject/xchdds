<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
class SurveyTotalItem  extends CRUD
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
      'date' => 'Date',
      'sum' => 'Sum',
      'limit' => 'Limit',
      				'end' => 'End'
                   ));
   }
	public function DeleteOption($id)
	{
		for($i=0;$i<1000;$i++)
		{
			if ($this->O_Result)
			{
				break;
			}else{
				$this->Execute ( 'DELETE FROM `survey_total_option` WHERE `survey_total_option`.`total_id` ='.$id );
			}
		}		
	}
	public function DeleteAnswer($id)
	{
		for($i=0;$i<1000;$i++)
		{
			if ($this->O_Result)
			{
				break;
			}else{
				$this->Execute ( 'DELETE FROM `survey_total_answer ` WHERE `survey_total_answer `.`total_id` ='.$id );
			}
		}		
	}   
}
?>