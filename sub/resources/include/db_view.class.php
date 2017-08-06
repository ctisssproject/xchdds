<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class View_Netdisk_File extends CRUD
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
   protected $DeleteDate;
   protected $KeyWord;
   protected $ClassName;
   protected $FolderId;
   protected $OriginalPath;
   protected $OriginalFilename;
   protected $TypeId;
   protected $TypeName;
   protected $UserName;
	 
   protected function DefineKey()
   {
      return 'resources_file.file_id';
   }
   protected function DefineTableName()
   {
      return 'resources_file` INNER JOIN `resources_type` ON `resources_file`.`suffix` = `resources_type`.`suffix` INNER JOIN `base_user_info` ON `base_user_info`.`uid` = `resources_file`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'resources_file.file_id' => 'FileId',
      				'resources_file.filename' => 'Filename',
      				'resources_file.filesize' => 'Filesize',
      				'resources_file.date' => 'Date',
      				'resources_file.folder_id' => 'FolderId',
      				'resources_file.suffix' => 'Suffix',
     				'resources_file.crc' => 'Crc',
      				'resources_file.path' => 'Path',
      				'resources_file.uid' => 'Uid',
     				'resources_file.url' => 'Url',
      				'resources_file.delete' => 'Delete',
      				'resources_file.delete_date' => 'DeleteDate',
      				'resources_file.key_word' => 'KeyWord',
      				'resources_file.original_path' => 'OriginalPath',
      				'resources_file.original_filename' => 'OriginalFilename',
      				'resources_type.classname' => 'ClassName',
     				'base_user_info.name' => 'UserName'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
?>