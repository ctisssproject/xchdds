<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
class Telephone_Info extends CRUD
{
   protected $Id;
   protected $RecordDate;
   protected $RecordTime;
   protected $Uid;
   protected $Name;
   protected $Sex;
   protected $SchoolId;
   protected $ProfileId;
   protected $Phone;
   protected $TypeId;
   protected $Content;
   protected $Explain;
   protected $OwnerId;
   protected $OwnerName;
   protected $State;
	 
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'telephone_info';
   }
   protected function DefineRelationMap()
   {
      return(array( 'id' => 'Id',
      				'record_date' => 'RecordDate',
      				'record_time' => 'RecordTime',
      				'uid' => 'Uid',
      				'name' => 'Name',
      				'sex' => 'Sex',
      'state' => 'State',
      				'school_id' => 'SchoolId',
      				'profile_id' => 'ProfileId',
      				'phone' => 'Phone',
      				'type_id' => 'TypeId',
      				'content' => 'Content',
      				'content' => 'Content',
      				'owner_id' => 'OwnerId',
      				'owner_name' => 'OwnerName'
                   ));
   }
}
class Telephone_Info_Special extends CRUD
{
   protected $Id;
   protected $RecordDate;
   protected $RecordTime;
   protected $Uid;
   protected $Name;
   protected $Sex;
   protected $SchoolId;
   protected $ProfileId;
   protected $Phone;
   protected $TypeId;
   protected $Content;
   protected $Explain;
   protected $Dd;
   protected $DdQz;
   protected $Jgw;
   protected $JgwQz;
   protected $Cljg;
   protected $Cbr;
   protected $CbDate;
   protected $Df;
   protected $Completed;
	 
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'telephone_info_special';
   }
   protected function DefineRelationMap()
   {
      return(array( 'id' => 'Id',
      				'record_date' => 'RecordDate',
      				'record_time' => 'RecordTime',
      				'uid' => 'Uid',
      				'name' => 'Name',
      				'sex' => 'Sex',
      				'school_id' => 'SchoolId',
      				'profile_id' => 'ProfileId',
      				'phone' => 'Phone',
      				'type_id' => 'TypeId',
      				'content' => 'Content',
      				'explain' => 'Explain',
            		'dd' => 'Dd',
      				'dd_qz' => 'DdQz',
      				'jgw' => 'Jgw',
      				'jgw_qz' => 'JgwQz',
      				'cljg' => 'Cljg',
      				'cbr' => 'Cbr',
      				'cb_date' => 'CbDate',
      				'df' => 'Df',
      				'completed' => 'Completed'
                   ));
   }
}
class Telephone_Profile extends CRUD
{
   protected $Id;
   protected $Name;
	 
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'telephone_profile';
   }
   protected function DefineRelationMap()
   {
      return(array( 'id' => 'Id',
      				'name' => 'Name'
                   ));
   }
}
class Telephone_Type extends CRUD
{
   protected $Id;
   protected $Name;
	 
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'telephone_type';
   }
   protected function DefineRelationMap()
   {
      return(array( 'id' => 'Id',
      				'name' => 'Name'
                   ));
   }
}
class Telephone_Progress extends CRUD
{
   protected $Id;
   protected $Date;
   protected $Content;
   protected $Uid;
   protected $InfoId;
	 
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'telephone_progress';
   }
   protected function DefineRelationMap()
   {
      return(array( 'id' => 'Id',
      				'date' => 'Date',
      				'info_id' => 'InfoId',
      				'content' => 'Content',
      				'uid' => 'Uid'
                   ));
   }
}
?>