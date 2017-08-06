<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class GPDD_Huodong extends CRUD 
{
	protected $Id;
	protected $Title;
	protected $OpenId;
	protected $Name;
	protected $Phone;
	protected $Address;
	protected $SchoolName;
	protected $SchoolId;
	protected $Date;
	protected $State;
	protected $OwnerName;
	protected $OwnerId;  		
	protected $Content;
	protected $IsGo;
	protected $GoReason;
	protected $Feedback;
	protected $ResolveDate;
   
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'gpdd_huodong';
   }
   protected function DefineRelationMap()
   {
      return(array( 'id' => 'Id',
      				'title' => 'Title',
      				'open_id' => 'OpenId',
      				'name' => 'Name',
    				'state' => 'State',
      				'phone' => 'Phone',
      				'address' => 'Address',
      				'school_name' => 'SchoolName',
      				'school_id' => 'SchoolId',
     				'date' => 'Date',
				    'owner_name' => 'OwnerName',
				    'owner_id' => 'OwnerId',  		
				    'content' => 'Content',
      				'is_go' => 'IsGo',
      				'go_reason' => 'GoReason',
			      	'feedback' => 'Feedback',
			      	'resolve_date' => 'ResolveDate'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class GPDD_Setup  extends CRUD
{
   protected $Uid;
   protected $WaitRead;
	 
   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'gpdd_setup';
   }
   protected function DefineRelationMap()
   {
      return(array( 'uid' => 'Uid',
      				'wait_read' => 'WaitRead'
                   ));
   }
}
?>