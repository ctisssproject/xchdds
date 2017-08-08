<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class View_Home_Article extends CRUD
{
   protected $ArticleId;
   protected $Title;
   protected $Content;
   protected $Uid;
   protected $Home;
   protected $Date;
   protected $UploadDate;
   protected $Scroll;
   protected $Visit;
   protected $ColumnId;
   protected $State;
   protected $Delete;
   protected $Name;
   protected $Parent;
   protected $TagId;
   protected $UserName;
   protected $ColumnState;
   protected $Audit;
   protected $AuditUid;
   protected $UnauditReason;
   protected $IsComment;
	 
   protected function DefineKey()
   {
      return 'home_article.article_id';
   }
   protected function DefineTableName()
   {
      return 'home_article` INNER JOIN `home_column` ON `home_column`.`column_id` = `home_article`.`column_id` INNER JOIN `base_user_info` ON `base_user_info`.`uid` = `home_article`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'home_article.article_id' => 'ArticleId',
      				'home_article.title' => 'Title',
      				'home_article.content' => 'Content',
      				'home_article.uid' => 'Uid',
      				'home_article.home' => 'Home',
     				'home_article.date' => 'Date',
      'home_article.tag_id' => 'TagId',
      'home_article.upload_date' => 'UploadDate',
      				'home_article.scroll' => 'Scroll',
      				'home_article.visit' => 'Visit',
      				'home_article.column_id' => 'ColumnId',
      				'home_article.state' => 'State',
     				'home_article.delete' => 'Delete',
            		'home_article.audit' => 'Audit',
      				'home_article.audit_uid' => 'AuditUid',
      				'home_article.unaudit_reason' => 'UnauditReason',
     				'home_column.name' => 'Name',
     				'home_column.parent' => 'Parent',
      				'home_column.state' => 'ColumnState',
      				'home_article.is_comment' => 'IsComment',
     				'base_user_info.name' => 'UserName'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class View_Home_Indexcolumn extends CRUD
{
   protected $IndexcolumnId;
   protected $ColumnId;
   protected $Name;
	 
   protected function DefineKey()
   {
      return 'home_indexcolumn.indexcolumn_id';
   }
   protected function DefineTableName()
   {
      return 'home_indexcolumn` INNER JOIN `home_column` ON `home_indexcolumn`.`column_id` = `home_column`.`column_id';
   }
   protected function DefineRelationMap()
   {
      return(array( 'home_indexcolumn.indexcolumn_id' => 'IndexcolumnId',
      				'home_indexcolumn.column_id' => 'ColumnId',
      				'home_column.name' => 'Name'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class View_Home_Float  extends CRUD
{
   protected $FloatId;
   protected $ArticleId;
   protected $Number;
   protected $Title;
	 
   protected function DefineKey()
   {
      return 'float_id';
   }
   protected function DefineTableName()
   {
      return 'home_float` INNER JOIN `home_article` ON `home_float`.`article_id` = `home_article`.`article_id';
   }
   protected function DefineRelationMap()
   {
      return(array( 'home_float.float_id' => 'FloatId',
      				'home_float.article_id' => 'ArticleId',
      				'home_float.number' => 'Number',
      				'home_article.title' => 'Title'
                   ));
   }
}
class View_Home_Comment  extends CRUD
{
   protected $CommentId;
   protected $ArticleId;
   protected $Content;
   protected $Uid;
   protected $Time;
   protected $Name;
	 
   protected function DefineKey()
   {
      return 'home_comment.comment_id';
   }
   protected function DefineTableName()
   {
      return 'home_comment` INNER JOIN `base_user_info` ON `base_user_info`.`uid` = `home_comment`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'home_comment.comment_id' => 'CommentId',
      				'home_comment.article_id' => 'ArticleId',
      				'home_comment.content' => 'Content',
      				'home_comment.uid' => 'Uid',
      				'home_comment.time' => 'Time',
      				'base_user_info.name' => 'Name'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class View_Home_Messages extends CRUD
{
   protected $ArticleId;
   protected $Title;
   protected $Content;
   protected $Uid;
   protected $Home;
   protected $Date;
   protected $Visit;
   protected $State;
   protected $Delete;
   protected $Name;
   protected $UserName;
   protected $Audit;
   protected $AuditUid;
   protected $Return;
	 
   protected function DefineKey()
   {
      return 'home_messages.article_id';
   }
   protected function DefineTableName()
   {
      return 'home_messages` INNER JOIN `home_column` ON `home_column`.`column_id` = `home_article`.`column_id` INNER JOIN `base_user_info` ON `base_user_info`.`uid` = `home_article`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'home_article.article_id' => 'ArticleId',
      				'home_article.title' => 'Title',
      				'home_article.content' => 'Content',
      				'home_article.uid' => 'Uid',
      				'home_article.home' => 'Home',
     				'home_article.date' => 'Date',
      				'home_article.scroll' => 'Scroll',
      				'home_article.visit' => 'Visit',
      				'home_article.column_id' => 'ColumnId',
      				'home_article.state' => 'State',
     				'home_article.delete' => 'Delete',
            		'home_article.audit' => 'Audit',
      				'home_article.audit_uid' => 'AuditUid',
      				'home_article.return' => 'Return',
     				'home_column.name' => 'Name',
     				'home_column.parent' => 'Parent',
      				'home_column.state' => 'ColumnState',
      				'home_article.is_comment' => 'IsComment',
     				'base_user_info.name' => 'UserName'
                   ));
   }
}
?>