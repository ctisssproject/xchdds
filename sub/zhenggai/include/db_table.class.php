<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class Zhenggai_Article extends CRUD
{
   protected $Id;
   protected $Title;
   protected $Content;
   protected $Uid;
   protected $Date;
   protected $Type;
   protected $Dept;
   protected $DeptId;
   protected $Comment;
   protected $Read;
   
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'zhenggai_article';
   }
   protected function DefineRelationMap()
   {
      return(array( 'id' => 'Id',
      				'title' => 'Title',
      				'content' => 'Content',
      				'uid' => 'Uid',
     				'date' => 'Date',
				    'type' => 'Type',
      'dept_id' => 'DeptId',
      'comment' => 'Comment',
      'read' => 'Read',
				    'dept' => 'Dept'      				
                   ));
   }
}

?>