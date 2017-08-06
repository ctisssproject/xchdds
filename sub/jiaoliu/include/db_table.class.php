<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class Jiaoliu_Article extends CRUD
{
   protected $Id;
   protected $Title;
   protected $Content;
   protected $SchoolId;
   protected $SchoolName;
   protected $Uid;
   protected $Date;
   protected $Type;
   protected $Dept;
   protected $SchoolJoin;
   protected $DuxueJoin;
   protected $Feedback;
   
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'jiaoliu_article';
   }
   protected function DefineRelationMap()
   {
      return(array( 'id' => 'Id',
      				'title' => 'Title',
      				'content' => 'Content',
      				'uid' => 'Uid',
				    'school_id' => 'SchoolId',
				    'school_name' => 'SchoolName',
     				'date' => 'Date',
				    'type' => 'Type',
          'school_join' => 'SchoolJoin',
          'duxue_join' => 'DuxueJoin',
      'feedback' => 'Feedback',
				    'dept' => 'Dept'      				
                   ));
   }
}

?>