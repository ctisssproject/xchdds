<?php
class AjaxRequest
{
   private $S_Receive_Xml;
   private $S_Receive_Function;
   private $A_Receive_Parameter;
   private $S_Send_Xml;
   private $S_Send_Function;
   private $A_Send_Parameter;
   private $S_Function_Node;
   private $S_Parameter_Node;

   public function __construct($s_xml = null)
   {
      $this->S_Receive_Xml = $s_xml;
      $this->S_Function_Node = 'FUNCTION';
      $this->S_Parameter_Node = 'PARAMETER';
      $this->A_Receive_Parameter = array();
      $this->A_Send_Parameter = array();
      $this->S_Receive_Function = $this->getValue($this->S_Function_Node);
      for($i = 0; $i < 10; $i++)
      {
         $s_parameter = $this->getValue($this->S_Parameter_Node . $i);
         if(is_bool($s_parameter) && $s_parameter == false)
         {
            break;
         }
         array_push($this->A_Receive_Parameter, $s_parameter);
      }
   }
   public function getFunction()
   {
      return $this->S_Receive_Function;
   }
   public function getCommand($s_obj)
   {
      if($this->S_Receive_Function == false)
      {
         return '';
      }
      $s_command = $this->S_Receive_Function . '(';
      $s_parameter = '';
      for($i = 0; $i < count($this->A_Receive_Parameter); $i++)
      {
         $s_parameter = $s_parameter . $s_obj . '->getParameter(' . $i . '),';
      }
      if($s_parameter != '')
      {
         $s_parameter = substr($s_parameter, 0, strlen($s_parameter) - 1);
      }
      return $s_command . $s_parameter . ');';
   }
   private function getValue($s_node)
   {
      $n_start = stripos($this->S_Receive_Xml, '<' . $s_node . '>');
      if(is_bool($n_start) && $n_start == false)
      {
         return false;
      }
      $n_start = $n_start + strlen($s_node) + 2;
      $n_end = stripos($this->S_Receive_Xml, '</' . $s_node . '>');
      if(is_bool($n_start) && $n_start == false)
      {
         return false;
      }
      $n_end = $n_end - $n_start;
      $s_return = rawurldecode(substr($this->S_Receive_Xml, $n_start, $n_end));
      return $s_return;
   }
   public function getParameter($n_number)
   {
      if($n_number < count($this->A_Receive_Parameter))
      {
         return $this->A_Receive_Parameter[$n_number];
      }
      else
      {
         return null;
      }
   }
   public function setFunction($s_function)
   {
      $this->S_Send_Function = rawurlencode($s_function);
   }
   public function PushParameter($s_parameter)
   {
      array_push($this->A_Send_Parameter, rawurlencode($s_parameter));
   }
   public function getSendXml()
   {
      $this->S_Send_Xml = '<' . $this->S_Function_Node . '>' . $this->S_Send_Function . '</' . $this->S_Function_Node . '>';
      for($i = 0; $i < count($this->A_Send_Parameter); $i++)
      {
         $this->S_Send_Xml .= '<' . $this->S_Parameter_Node . $i . '>' . $this->A_Send_Parameter[$i] . '</' . $this->S_Parameter_Node . $i . '>';
      }
      return $this->S_Send_Xml;
   }

}
?>