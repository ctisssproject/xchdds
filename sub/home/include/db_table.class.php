<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class Home_Column  extends CRUD
{
   protected $ColumnId;
   protected $Name;
   protected $Number;
   protected $Parent;
   protected $State;
   protected $Delete;
   protected $AllowDelete;
   protected $Url;
	 
   protected function DefineKey()
   {
      return 'column_id';
   }
   protected function DefineTableName()
   {
      return 'home_column';
   }
   protected function DefineRelationMap()
   {
      return(array( 'column_id' => 'ColumnId',
      				'name' => 'Name',
      				'number' => 'Number',
      				'parent' => 'Parent',
      				'state' => 'State',
     				'delete' => 'Delete',
      				'allow_delete' => 'AllowDelete',
      				'url' => 'Url'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Home_Article extends CRUD
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
   protected $Audit;
   protected $AuditUid;
   protected $UnauditReason;
   protected $Delete;
   protected $LastUid;
   protected $LastDate;
   protected $TagId;
   protected $IsComment;
	 
   protected function DefineKey()
   {
      return 'article_id';
   }
   protected function DefineTableName()
   {
      return 'home_article';
   }
   protected function DefineRelationMap()
   {
      return(array( 'article_id' => 'ArticleId',
      				'title' => 'Title',
      				'content' => 'Content',
      				'uid' => 'Uid',
      				'home' => 'Home',
     				'date' => 'Date',
      				'upload_date' => 'UploadDate',
      				'scroll' => 'Scroll',
      				'visit' => 'Visit',
      				'column_id' => 'ColumnId',
      				'state' => 'State',
      				'audit' => 'Audit',
      				'tag_id' => 'TagId',
      				'audit_uid' => 'AuditUid',
      				'unaudit_reason' => 'UnauditReason',
     				'delete' => 'Delete',
      				'last_uid' => 'LastUid',
      				'is_comment' => 'IsComment',
      				'last_date' => 'LastDate'
                   ));
   }
}
class Home_Messages extends CRUD
{
   protected $ArticleId;
   protected $Title;
   protected $Content;
   protected $Uid;
   protected $Home;
   protected $Date;
   protected $Visit;
   protected $State;
   protected $Audit;
   protected $AuditUid;
   protected $AuditDate;
   protected $Return;
   protected $Delete;
	 
   protected function DefineKey()
   {
      return 'article_id';
   }
   protected function DefineTableName()
   {
      return 'home_messages';
   }
   protected function DefineRelationMap()
   {
      return(array( 'article_id' => 'ArticleId',
      				'title' => 'Title',
      				'content' => 'Content',
      				'uid' => 'Uid',
      				'home' => 'Home',
     				'date' => 'Date',
      				'visit' => 'Visit',
      				'state' => 'State',
      				'audit' => 'Audit',
      				'audit_uid' => 'AuditUid',
      				'audit_date' => 'AuditDate',
      				'return' => 'Return',
     				'delete' => 'Delete'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Home_NewsFocus extends CRUD
{
   protected $FocusId;
   protected $Title;
   protected $Content;
   protected $Uid;
   protected $Photo;
   protected $ArticleId;
   protected $State;
   protected $Delete;
   protected $Number;
	 
   protected function DefineKey()
   {
      return 'focus_id';
   }
   protected function DefineTableName()
   {
      return 'home_newsfocus';
   }
   protected function DefineRelationMap()
   {
      return(array( 'focus_id' => 'FocusId',
      				'title' => 'Title',
      				'content' => 'Content',
      				'uid' => 'Uid',
      				'photo' => 'Photo',
     				'article_id' => 'ArticleId',
      				'state' => 'State',
     				'delete' => 'Delete',
     				'number' => 'Number'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Home_Topics extends CRUD
{
   protected $TopicsId;
   protected $Uid;
   protected $Photo;
   protected $Url;
   protected $State;
   protected $Delete;
   protected $Number;
	 
   protected function DefineKey()
   {
      return 'topics_id';
   }
   protected function DefineTableName()
   {
      return 'home_topics';
   }
   protected function DefineRelationMap()
   {
      return(array( 'topics_id' => 'TopicsId',
      				'uid' => 'Uid',
      				'photo' => 'Photo',
     				'url' => 'Url',
      				'state' => 'State',
     				'delete' => 'Delete',
     				'number' => 'Number'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Home_Indexcolumn extends CRUD
{
   protected $IndexcolumnId;
   protected $ColumnId;
	 
   protected function DefineKey()
   {
      return 'indexcolumn_id';
   }
   protected function DefineTableName()
   {
      return 'home_indexcolumn';
   }
   protected function DefineRelationMap()
   {
      return(array( 'indexcolumn_id' => 'IndexcolumnId',
      				'column_id' => 'ColumnId'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Home_Link extends CRUD
{
   protected $LinkId;
   protected $Name;
   protected $Url;
   protected $State;
   protected $Delete;
   protected $Number;
	 
   protected function DefineKey()
   {
      return 'link_id';
   }
   protected function DefineTableName()
   {
      return 'home_link';
   }
   protected function DefineRelationMap()
   {
      return(array( 'link_id' => 'LinkId',
      				'name' => 'Name',
     				'url' => 'Url',
      				'state' => 'State',
     				'delete' => 'Delete',
     				'number' => 'Number'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Home_Article_Footer extends CRUD
{
   protected $ArticleId;
   protected $Title;
   protected $Content;
   protected $Date;
   protected $Visit;
   protected $State;
   protected $Delete;
   protected $Number;
	 
   protected function DefineKey()
   {
      return 'article_id';
   }
   protected function DefineTableName()
   {
      return 'home_article_footer';
   }
   protected function DefineRelationMap()
   {
      return(array( 'article_id' => 'ArticleId',
      				'title' => 'Title',
      				'content' => 'Content',
     				'date' => 'Date',
      				'visit' => 'Visit',
      				'state' => 'State',
     				'delete' => 'Delete',
     				'Number' => 'Number'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Home_Setup  extends CRUD
{
   protected $Uid;
   protected $WaitRead;
	 
   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'home_setup';
   }
   protected function DefineRelationMap()
   {
      return(array( 'uid' => 'Uid',
      				'wait_read' => 'WaitRead'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Home_Float  extends CRUD
{
   protected $FloatId;
   protected $ArticleId;
   protected $Number;
	 
   protected function DefineKey()
   {
      return 'float_id';
   }
   protected function DefineTableName()
   {
      return 'home_float';
   }
   protected function DefineRelationMap()
   {
      return(array( 'float_id' => 'FloatId',
      				'article_id' => 'ArticleId',
      				'number' => 'Number'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Home_Photo  extends CRUD
{
   protected $PhotoId;
   protected $Path;
   protected $Text;
	 
   protected function DefineKey()
   {
      return 'photo_id';
   }
   protected function DefineTableName()
   {
      return 'home_photo';
   }
   protected function DefineRelationMap()
   {
      return(array( 'photo_id' => 'PhotoId',
      				'path' => 'Path',
      				'text' => 'Text'
                   ));
   }
}
class Home_Comment  extends CRUD
{
   protected $CommentId;
   protected $ArticleId;
   protected $Content;
   protected $Uid;
   protected $Time;
	 
   protected function DefineKey()
   {
      return 'comment_id';
   }
   protected function DefineTableName()
   {
      return 'home_comment';
   }
   protected function DefineRelationMap()
   {
      return(array( 'comment_id' => 'CommentId',
      				'article_id' => 'ArticleId',
      				'content' => 'Content',
      				'uid' => 'Uid',
      				'time' => 'Time'
                   ));
   }
}
class Home_Focus extends CRUD
{
   protected $FocusId;
   protected $Photo;
   protected $Number;
	 
   protected function DefineKey()
   {
      return 'focus_id';
   }
   protected function DefineTableName()
   {
      return 'home_focus';
   }
   protected function DefineRelationMap()
   {
      return(array( 'focus_id' => 'FocusId',
      				'photo' => 'Photo',
     				'number' => 'Number'
                   ));
   }
}
class Home_Column_Tags extends CRUD
{
    protected $Id;
    protected $Name;
    protected $ColumnId;
    protected $Color;
    protected $Number;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'home_column_tags';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'name' => 'Name',
                    'column_id' => 'ColumnId',
                    'color' => 'Color',
                    'number' => 'Number'
        ));
    }
}
?>