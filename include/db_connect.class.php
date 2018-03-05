<?php
require_once RELATIVITY_PATH . 'include/it_systext.class.php';
abstract class DB_Connect
{
   private $S_DatabaseServer = '192.168.0.35:3306';
   private $S_UserName = 'user34';
   private $S_PassWord = 'bjsql.com.cn';
   private $S_DataBaseName = 'xcjwszpj';
   protected $O_Result;
   protected $S_Id;
   protected $S_Error_Reason;
   protected $S_Error_Time=0;
   protected function Execute($sql) 
   {
      //echo($sql.'<br><br>');
      $db = @mysql_connect($this->S_DatabaseServer, $this->S_UserName, $this->S_PassWord);
      mysql_select_db($this->S_DataBaseName, $db);
      mysql_query("SET NAMES 'utf8'");
      $this->O_Result = mysql_query($sql, $db);
      if($this->O_Result)
      {
         if(strpos($sql, 'INSERT') > - 1)
         {
            $this->S_Id = mysql_insert_id();
         }
         mysql_close();         
         $this->S_Error_Time=0;
      }
      else if ($this->S_Error_Time<5)
      {
      	sleep(1);
      	$this->S_Error_Time++;
      	$this->Execute($sql);
      }else{
      	mysql_close();
      }      
      return;
   }
   protected function Command($sql)
   {
      $db = @mysql_connect($this->S_DatabaseServer, $this->S_UserName, $this->S_PassWord);
      mysql_select_db($this->S_DataBaseName, $db);
      mysql_query("SET NAMES 'utf8'");
      $result = mysql_query($sql, $db);
      mysql_close();
   }
   public function getErrorReason()
   {
      return $this->S_Error_Reason;
   }
   protected function Item($n_row, $s_item)
   {
      try
      {
         $s_temp = mysql_result($this->O_Result, $n_row, $s_item);
         //echo($n_row.'-'.$s_item.'<br>');
         return $s_temp;
      }
      catch(exception $err)
      {
         return null;
      }

   }

}
?>
