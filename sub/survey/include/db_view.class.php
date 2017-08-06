<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class View_Total_Item extends CRUD
{
   protected $Id;
   protected $Start;
   protected $SubjectId;
   protected $SubjectName;
   protected $Type;
   protected $TypeName;
   protected $DeptId;
   protected $DeptName;
   protected $End;
   protected $Sum;
   protected $Date;
   protected $Delete;
   protected $Limit;

   protected function DefineKey()
   {
      return 'survey_total_item.id';
   }
   protected function DefineTableName()
   {
      return 'survey_total_item` INNER JOIN `survey_subject` ON `survey_subject`.`id` = `survey_total_item`.`subject_id` INNER JOIN `survey_dept` ON `survey_dept`.`id` = `survey_total_item`.`dept_id` INNER JOIN `survey_type` ON `survey_type`.`id` = `survey_total_item`.`type';
   }
   protected function DefineRelationMap()
   {
      return(array( 'survey_total_item.id' => 'Id',
      'survey_total_item.start' => 'Start',
      'survey_total_item.subject_id' => 'SubjectId',
      'survey_subject.title' => 'SubjectName',
      'survey_total_item.type' => 'Type',
      'survey_type.name' => 'TypeName',
      'survey_dept.delete' => 'Delete',
      'survey_total_item.dept_id' => 'DeptId',
      'survey_dept.name' => 'DeptName',
      'survey_total_item.end' => 'End',
      'survey_total_item.date' => 'Date',
      'survey_total_item.limit' => 'Limit',
      'survey_total_item.sum' => 'Sum'
                   ));
   }
}
class View_Total_Option extends CRUD
{
   protected $Id;
   protected $OptionId;
   protected $TotalId;
   protected $ItemId;
   protected $Sum;
   protected $Number;
   protected $Content;

   protected function DefineKey()
   {
      return 'survey_total_option.id';
   }
   protected function DefineTableName()
   {
      return 'survey_total_option` INNER JOIN `survey_option` ON `survey_option`.`option_id` = `survey_total_option`.`option_id';
   }
   protected function DefineRelationMap()
   {
      return(array('survey_total_option.id' => 'Id',
      				'survey_total_option.option_id' => 'OptionId',
      				'survey_total_option.total_id' => 'TotalId',
      				'survey_total_option.item_id' => 'ItemId',
      				'survey_total_option.sum' => 'Sum',
      'survey_option.number' => 'Number',
      'survey_option.content' => 'Content'
                   ));
   }
}
?>