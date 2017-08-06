<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class Netdisk_File  extends CRUD
{
   protected $FileId;
   protected $Filename;
   protected $Filesize;
   protected $Date;
   protected $Suffix;
   protected $Crc;
   protected $Path;
   protected $Uid;
   protected $Url;
   protected $Delete;
   protected $KeyWord;
   protected $FolderId;
   protected $DeleteDate;
   protected $OriginalPath;
   protected $OriginalFilename;
	 
   protected function DefineKey()
   {
      return 'file_id';
   }
   protected function DefineTableName()
   {
      return 'resources_file';
   }
   protected function DefineRelationMap()
   {
      return(array( 'file_id' => 'FileId',
      				'filename' => 'Filename',
      				'filesize' => 'Filesize',
      				'date' => 'Date',
      				'suffix' => 'Suffix',
     				'crc' => 'Crc',
      				'path' => 'Path',
      				'uid' => 'Uid',
      				'url' => 'Url',
      				'delete' => 'Delete',
      				'key_word' => 'KeyWord',
      				'folder_id' => 'FolderId',
      				'delete_date' => 'DeleteDate',
      				'original_path' => 'OriginalPath',
      				'original_filename' => 'OriginalFilename'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Netdisk_Folder extends CRUD
{
   protected $FolderId;
   protected $FolderName;
   protected $Date;
   protected $Uid;
   protected $ParentId;
   protected $Delete;
   protected $DeleteDate;
   protected $OriginalPath;
	 
   protected function DefineKey()
   {
      return 'folder_id';
   }
   protected function DefineTableName()
   {
      return 'resources_folder';
   }
   protected function DefineRelationMap()
   {
      return(array( 'folder_id' => 'FolderId',
      				'foldername' => 'FolderName',
      				'date' => 'Date',
      				'uid' => 'Uid',
      				'delete' => 'Delete',
      				'parent_id' => 'ParentId',
      				'delete_date' => 'DeleteDate',
      				'original_path' => 'OriginalPath'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Netdisk_Space extends CRUD
{
   protected $Uid;
   protected $Free;
   protected $Use;
   protected $Total;
	 
   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'resources_space';
   }
   protected function DefineRelationMap()
   {
      return(array( 'uid' => 'Uid',
      				'free' => 'Free',
      				'use' => 'Use',
      				'total' => 'Total'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Netdisk_Type extends CRUD
{
   protected $Suffix;
   protected $ClassName;
   protected $Explain;
	 
   protected function DefineKey()
   {
      return 'suffix';
   }
   protected function DefineTableName()
   {
      return 'resources_type';
   }
   protected function DefineRelationMap()
   {
      return(array( 'suffix' => 'Suffix',
      				'classname' => 'ClassName',
      				'explain' => 'Explain'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
//1111111111111111111111111111111111111111111111
class Netdisk_File_Type extends CRUD
{
   protected $TypeId;
   protected $Name;
	 
   protected function DefineKey()
   {
      return 'type_id';
   }
   protected function DefineTableName()
   {
      return 'resources_file_type';
   }
   protected function DefineRelationMap()
   {
      return(array( 'type_id' => 'TypeId',
      				'name' => 'Name'
                   ));
   }
}
?>