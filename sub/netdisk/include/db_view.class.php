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
   protected $ShareUsername;
   protected $ShareUid;
   protected $Path;
   protected $Uid;
   protected $Delete;
   protected $DeleteDate;
   protected $KeyWord;
   protected $ClassName;
   protected $FolderId;
   protected $OriginalPath;
   protected $OriginalFilename;
	 
   protected function DefineKey()
   {
      return 'netdisk_file.file_id';
   }
   protected function DefineTableName()
   {
      return 'netdisk_file` INNER JOIN `netdisk_type` ON `netdisk_file`.`suffix` = `netdisk_type`.`suffix';
   }
   protected function DefineRelationMap()
   {
      return(array( 'netdisk_file.file_id' => 'FileId',
      				'netdisk_file.filename' => 'Filename',
      				'netdisk_file.filesize' => 'Filesize',
      				'netdisk_file.date' => 'Date',
      				'netdisk_file.folder_id' => 'FolderId',
      				'netdisk_file.suffix' => 'Suffix',
     				'netdisk_file.crc' => 'Crc',
      				'netdisk_file.share_username' => 'ShareUsername',
      				'netdisk_file.share_uid' => 'ShareUid',
      				'netdisk_file.path' => 'Path',
      				'netdisk_file.uid' => 'Uid',
      				'netdisk_file.delete' => 'Delete',
      				'netdisk_file.delete_date' => 'DeleteDate',
      				'netdisk_file.key_word' => 'KeyWord',
      				'netdisk_file.original_path' => 'OriginalPath',
      				'netdisk_file.original_filename' => 'OriginalFilename',
      				'netdisk_type.classname' => 'ClassName'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
?>