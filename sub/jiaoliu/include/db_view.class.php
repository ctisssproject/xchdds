<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class View_Jiaoliu_Article extends CRUD
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
   protected $Name;
   
   protected function DefineKey()
   {
      return 'jiaoliu_article.id';
   }
   protected function DefineTableName()
   {
      return 'jiaoliu_article` INNER JOIN `base_user_info` ON `base_user_info`.`uid` = `jiaoliu_article`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'jiaoliu_article.id' => 'Id',
      				'jiaoliu_article.title' => 'Title',
      				'jiaoliu_article.content' => 'Content',
      				'jiaoliu_article.uid' => 'Uid',
				    'jiaoliu_article.school_id' => 'SchoolId',
      'base_user_info.name' => 'Name',
				    'jiaoliu_article.school_name' => 'SchoolName',
     				'jiaoliu_article.date' => 'Date',
				    'jiaoliu_article.type' => 'Type',
          'jiaoliu_article.school_join' => 'SchoolJoin',
          'jiaoliu_article.duxue_join' => 'DuxueJoin',
      'jiaoliu_article.feedback' => 'Feedback',
				    'jiaoliu_article.dept' => 'Dept'      				
                   ));
   }
}
?>