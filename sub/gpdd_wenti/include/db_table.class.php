<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class GPDD_Wenti extends CRUD 
{
	protected $Id;
	protected $Name;
	protected $Phone;
	protected $SchoolName;
	protected $SchoolId;
	protected $Profile; 
	protected $From;
	protected $Date;
	protected $OwnerName;
	protected $OwnerId;
	protected $Content;
	protected $State;
	protected $TypeName;
    protected $TypeId;
    protected $FeedbackType;
    protected $Feedback;
    protected $FeedbackUid;
    protected $FeedbackDate;
    protected $FeedbackName;
    protected $ResolveDate;
   
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'gpdd_wenti';
   }
   protected function DefineRelationMap()
   {
      return(array( 'id' => 'Id',
      				'name' => 'Name',
      				'phone' => 'Phone',
      				'school_name' => 'SchoolName',
      				'school_id' => 'SchoolId',
      				'profile' => 'Profile',
      				'from' => 'From',
     				'date' => 'Date',
				    'owner_name' => 'OwnerName',
				    'owner_id' => 'OwnerId',  		
				    'content' => 'Content',
      				'type_name' => 'TypeName',
      				'type_id' => 'TypeId',
      				'feedback_type' => 'FeedbackType',
      				'feedback' => 'Feedback',
			      	'feedback_uid' => 'FeedbackUid',
			      	'feedback_name' => 'FeedbackName',
			      	'feedback_date' => 'FeedbackDate',
			      	'resolve_date' => 'ResolveDate',
				    'state' => 'State' 		
                   ));
   }
}
class GPDD_Zc extends CRUD 
{
	protected $Id;
	protected $Date;
	protected $State;
	protected $Read;
	protected $Content;
	protected $Feedback;
	protected $Uid;
	protected $OwnerId;
	protected $SchoolId;
	protected $SchoolName;
	protected $Reason;  		
	protected $Title;
	protected $OwnerName;
	protected $UserName;
	protected $FeedbackDate;
	protected $FeedbackId;
	protected $FeedbackName;
	protected $CompletedDate;
   
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'gpdd_zc';
   }
   protected function DefineRelationMap()
   {
      return(array( 'id' => 'Id',
      				'date' => 'Date',
      				'state' => 'State',
      'read' => 'Read',
      				'content' => 'Content',
      				'feedback' => 'Feedback',
      				'uid' => 'Uid',
      				'owner_id' => 'OwnerId',
     				'school_id' => 'SchoolId',
				    'school_name' => 'SchoolName',
				    'reason' => 'Reason',  		
				    'title' => 'Title',
      				'owner_name' => 'OwnerName',
      				'user_name' => 'UserName',
      				'feedback_date' => 'FeedbackDate',
      				'feedback_id' => 'FeedbackId',
			      	'feedback_name' => 'FeedbackName',
			      	'completed_date' => 'CompletedDate'
                   ));
   }
}
class GPDD_Dc extends CRUD 
{
	protected $Id;
	protected $Date;
	protected $State;
	protected $Read;
	protected $Content;
	protected $Feedback;
	protected $Uid;
	protected $OwnerId;
	protected $SchoolId;
	protected $SchoolName;
	protected $Reason1;  
	protected $Reason2;  		
	protected $Title;
	protected $OwnerName;
	protected $UserName;
	protected $FeedbackDate;
	protected $FeedbackId;
	protected $FeedbackName;
	protected $CompletedDate;
	protected $OwnerFeedback;
	protected $ParentId;
   
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'gpdd_dc';
   }
   protected function DefineRelationMap()
   {
      return(array( 'id' => 'Id',
      				'date' => 'Date',
      				'state' => 'State',
      'read' => 'Read',
      				'content' => 'Content',
      				'feedback' => 'Feedback',
      				'uid' => 'Uid',
      				'owner_id' => 'OwnerId',
     				'school_id' => 'SchoolId',
				    'school_name' => 'SchoolName',
				    'reason1' => 'Reason1', 
      				'reason2' => 'Reason2',  		
				    'title' => 'Title',
      				'owner_name' => 'OwnerName',
      				'user_name' => 'UserName',
      				'feedback_date' => 'FeedbackDate',
      				'feedback_id' => 'FeedbackId',
			      	'feedback_name' => 'FeedbackName',
			      	'completed_date' => 'CompletedDate',
      				'owner_feedback' => 'OwnerFeedback',
			      	'parent_id' => 'ParentId'
                   ));
   }
}
class GPDD_Dc_Summary extends CRUD 
{
	protected $Id;
	protected $Date;
	protected $State;
	protected $Feedback;
	protected $Title;
	protected $FeedbackUid;
	protected $FeedbackName;
	protected $OwnerId;
   
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'gpdd_dc_summary';
   }
   protected function DefineRelationMap()
   {
      return(array( 'id' => 'Id',
      				'state' => 'State',
				    'title' => 'Title',
      'date' => 'Date',
      'owner_id' => 'OwnerId',
      				'feedback_uid' => 'FeedbackUid',
			      	'feedback_name' => 'FeedbackName',
      				'feedback' => 'Feedback'
                   ));
   }
}
?>