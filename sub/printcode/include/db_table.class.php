<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
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
	public function DeleteAll()
	{
		for($i=0;$i<1000;$i++)
		{
			if ($this->O_Result)
			{
				break;
			}else{
				$this->Execute ( 'TRUNCATE TABLE `survey_code`' );
			}
		}		
	}
	public function DeleteComplete()
	{
		for($i=0;$i<1000;$i++)
		{
			if ($this->O_Result)
			{
				break;
			}else{
				$this->Execute ( 'DELETE FROM `survey_code` WHERE `survey_code`.`state`=0' );
			}
		}		
	}   
}
?>