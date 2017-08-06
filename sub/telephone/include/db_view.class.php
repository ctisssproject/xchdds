<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class View_Telephone_Info  extends CRUD
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
   protected $SchoolName;
   protected $ProfileName;
   protected $UserName;
   protected $OwnerId;
   protected $OwnerName;
	 
   protected function DefineKey()
   {
      return 'telephone_info.id';
   }
   protected function DefineTableName()
   {
      return 'telephone_info` INNER JOIN `base_dept` ON `base_dept`.`dept_id` = `telephone_info`.`school_id` INNER JOIN `telephone_profile` ON `telephone_profile`.`id` = `telephone_info`.`profile_id` INNER JOIN `base_user_info` ON `base_user_info`.`uid` = `telephone_info`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'telephone_info.id' => 'Id',
      				'telephone_info.record_date' => 'RecordDate',
      				'telephone_info.record_time' => 'RecordTime',
      				'telephone_info.uid' => 'Uid',
      				'telephone_info.name' => 'Name',
      				'telephone_info.sex' => 'Sex',
      				'telephone_info.school_id' => 'SchoolId',
      				'telephone_info.profile_id' => 'ProfileId',
      				'telephone_info.phone' => 'Phone',
      				'telephone_info.type_id' => 'TypeId',
      				'telephone_info.content' => 'Content',
      'telephone_info.owner_id' => 'OwnerId',
      'telephone_info.owner_name' => 'OwnerName',
      				'base_dept.name' => 'SchoolName',
      				'telephone_profile.name' => 'ProfileName',
     				'base_user_info.name' => 'UserName',
      				'telephone_info.explain' => 'Explain'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class View_Telephone_Info_Special  extends CRUD
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
   protected $SchoolName;
   protected $ProfileName;
   protected $UserName;
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
      return 'telephone_info_special.id';
   }
   protected function DefineTableName()
   {
      return 'telephone_info_special` INNER JOIN `base_dept` ON `base_dept`.`dept_id` = `telephone_info_special`.`school_id` INNER JOIN `telephone_profile` ON `telephone_profile`.`id` = `telephone_info_special`.`profile_id` INNER JOIN `base_user_info` ON `base_user_info`.`uid` = `telephone_info_special`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'telephone_info_special.id' => 'Id',
      				'telephone_info_special.record_date' => 'RecordDate',
      				'telephone_info_special.record_time' => 'RecordTime',
      				'telephone_info_special.uid' => 'Uid',
      				'telephone_info_special.name' => 'Name',
      				'telephone_info_special.sex' => 'Sex',
      				'telephone_info_special.school_id' => 'SchoolId',
      				'telephone_info_special.profile_id' => 'ProfileId',
      				'telephone_info_special.phone' => 'Phone',
      				'telephone_info_special.type_id' => 'TypeId',
      				'telephone_info_special.content' => 'Content',
      				'base_dept.name' => 'SchoolName',
      				'telephone_profile.name' => 'ProfileName',
     				'base_user_info.name' => 'UserName',
      				'telephone_info_special.explain' => 'Explain',
                  	'telephone_info_special.dd' => 'Dd',
      				'telephone_info_special.dd_qz' => 'DdQz',
      				'telephone_info_special.jgw' => 'Jgw',
      				'telephone_info_special.jgw_qz' => 'JgwQz',
      				'telephone_info_special.cljg' => 'Cljg',
      				'telephone_info_special.cbr' => 'Cbr',
      				'telephone_info_special.cb_date' => 'CbDate',
      				'telephone_info_special.df' => 'Df',
      				'telephone_info_special.completed' => 'Completed'
                   ));
   }
}
?>