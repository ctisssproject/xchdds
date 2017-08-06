<?php
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
class MasterPage
{
   private $O_User;
   private $O_System_Info;
   private $O_System_Setup;
   private $S_Content;
   private $A_Site_Map;
   private $A_Script_File;
   private $A_Css_File;
   Private $S_Javascript_Code;
   private $S_Module_Name;
   private $S_Skin_Path;
   private $S_Root;

   public function __construct($o_user, $o_system_info, $o_system_setup, $s_root = '../../')
   {
      $this->O_User = $o_user;
      $this->O_System_Info = $o_system_info;
      $this->O_System_Setup = $o_system_setup;
      $this->A_Site_Map = array();
      $this->A_Script_File = array();
      $this->A_Css_File = array();
      $this->S_Root=$s_root;
      //设置公共样式
      $o_skin = new Common_Skinlist($this->O_System_Setup->getSkinId());
      $s_skin_path = $o_skin->getPath();
      array_push($this->A_Css_File, $s_root . 'css/common.css');
      array_push($this->A_Css_File, $s_root . 'css/'.$s_skin_path.'/style.css');
      array_push($this->A_Script_File, $s_root . 'javascript/ajax.class.js');
      array_push($this->A_Script_File, $s_root . 'javascript/dialog.fun.js');
      array_push($this->A_Script_File, $s_root . 'javascript/common.fun.js');

      $this->S_Skin_Path=$s_skin_path;
   }

   private function BuildTopMenu()//构建顶端菜单
   {
      $s_html = '<ul>';
      $d_db = new Common_Topbutton();
      $d_db->PushOrder(array('Number', 'D'));
      //$d_db->
      switch($this->O_User->get_Group_GroupId())
      {
         case 1:
            $d_db->PushWhere(array('&&', 'GroupId', '=', '1'));
            break;
         case 2:
            $d_db->PushWhere(array('&&', 'GroupId', '=', '2'));
            break;
         case 3:
            $d_db->PushWhere(array('&&', 'GroupId', '=', '3'));
            break;
      }
      $n_count = $d_db->getAllCount();
      $s_home_page = $this->O_System_Setup->getHomePage();
      for($i = 0; $i < $n_count; $i++)
      {
         if($d_db->getBlank($i) == 1)
         {
            $s_blank = 'target="_blank"';
         }
         else
         {
            $s_blank = '';
         }
         if($d_db->getIsScript($i) == 1)
         {
            $s_html .= '<li><a href="' . $d_db->getUrl($i) . '" title="' . $d_db->getTitle($i) . '">' . $d_db->getValue($i) . '</a></li>';
         }
         else
         {
            $s_html .= '<li><a href="' . $this->S_Root . $d_db->getUrl($i) . '" title="' . $d_db->getTitle($i) . '" ' . $s_blank . '>' . $d_db->getValue($i) . '</a></li>';
         }

         $s_html .= '<li class="space">|</li>';
      }
      $s_html .= '<li class="online">&nbsp;&nbsp;在线&nbsp;&nbsp;</li>
                  <li class="user">' . $this->O_User->getUserName() . '</li>
                  </ul>';
      return $s_html;
   }

   private function BuildNavigation()//构建导航菜单
   {
      $s_html = '<ul>';
      $s_home_page = $this->O_System_Setup->getHomePage();
      $d_db = new Common_Installed();
      $d_db->PushOrder(array('Number', 'A'));
      $n_count = $d_db->getAllCount();
      for($i = 0; $i < $n_count; $i++)
      {
         if($d_db->getBlank($i) == 1)
         {
            $s_blank = 'target="_blank"';
         }
         else
         {
            $s_blank = '';
         }
         if($this->S_Module_Name == $d_db->getName($i))
         {
            $s_html .= '<li class="on"><a href="' . $s_home_page . $d_db->getUrl($i) . '" title="' . $d_db->getTitle($i) . '">' . $d_db->getValue($i) . '</a></li>';
         }
         else
         {
            $s_html .= '<li><a href="' . $this->S_Root . $d_db->getUrl($i) . '" title="' . $d_db->getTitle($i) . '" ' . $s_blank . '>' . $d_db->getValue($i) . '</a></li>';
         }
         if(($i + 1) < $n_count)
         {
            $s_html .= '<li class="space"></li>';
         }
      }
      $s_html .= '</ul>';
      return $s_html;
   }
   public function getSiteMapForHtml()
   {
      return $this->BuildSiteMap();
   }
   private function BuildSiteMap()//构建站点地图菜单
   {
      $s_home_page = $this->O_System_Setup->getHomePage();
      $s_html = '<ul><li><a class="home" title="首页" href="' . $s_home_page . '"></a></li>';
      $n_count = count($this->A_Site_Map);
      for($i = 0; $i < $n_count; $i++)
      {
         $a_button = $this->A_Site_Map[$i];
         $s_html .= '<li class="space"></li>';
         if(($i + 1) < $n_count)
         {
            $s_html .= '<li><a href="' . $s_root . $a_button[1] . '" title="' . $a_button[2] . '">' . $a_button[0] . '</a></li>';
         }
         else
         {
            $s_html .= '<li>&nbsp;&nbsp;' . $a_button[0] . '</li>';
         }
      }
      $s_html .= '</ul>';
      return $s_html;
   }

   private function BuildScriptFile()//构建导入javacript文件
   {
      $s_html = '';
      foreach($this->A_Script_File  as $s_key => $s_value)
      {
         $s_html .= '<script src="' . $s_value . '" type="text/javascript"></script>';
      }
      return $s_html;
   }

   private function BuildCssFile()//构建导入css文件
   {
      $s_html = '';
      foreach($this->A_Css_File  as $s_key => $s_value)
      {
         $s_html .= '<link href="' . $s_value . '" rel="stylesheet" type="text/css" />';
      }
      return $s_html;
   }

   private function BuildTitle()//构建网页标题
   {
      return 'Allround 建站系统';
   }

   private function BuildFooter()//构建网页底部公司信息
   {
      return $this->O_System_Setup->getFooter();
   }

   public function BuildPage()//生成网页
   {
      echo('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title>' . $this->BuildTitle() . '</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            ' . $this->BuildScriptFile() . '
            ' . $this->BuildCssFile() . '
        </head>
        <body>
            <div align="center">
                <div id="container">
                    <div id="system_massage">
                    </div>
                    <div id="header">
                        <div id="logo">
                        </div>
                        <div id="top_button">
                           ' . $this->BuildTopMenu() . '
                        </div>
                        <div id="top_info">
                        </div>
                    </div>
                    <div id="navigator">
                        ' . $this->BuildNavigation() . '
                    </div>
                    <div id="site_map">
                        ' . $this->BuildSiteMap() . '
                        <div id="search">
                        </div>
                    </div>
                    <div id="content">
                        ' . $this->S_Content . '
                    </div>
                    <div id="footer">
                        ' . $this->BuildFooter() . '
                    </div>
                </div>
            </div>
            <iframe id="ajax_submit_frame" name="ajax_submit_frame" width="500" height="500" marginwidth="0" border="0"
                frameborder="0" src="about:blank"></iframe>
            <div id="master_box" style="position: absolute; z-index: 2000;
                left: 0px; top: -500px;">
            </div>
            <script type="text/javascript" language="javascript">
        <!--
            ' . $this->S_Javascript_Code . '
            S_Root=\''.RELATIVITY_PATH.'\';

        -->
            </script>

        </body>
        </html>');
   }

   public function PushScriptFile($s_filename)//压入javacript文件
   {
      array_push($this->A_Script_File, $s_filename);
   }

   public function PushCssFile($s_filename)//压入css文件
   {
      array_push($this->A_Css_File, $s_filename);
   }

   public function setContent($s_content)//设置显示内容
   {
      $this->S_Content = $s_content;
   }

   public function setJavaScriptCode($s_code)//设置javescript运行脚本
   {
      $this->S_Javascript_Code = $s_code;
   }

   public function setSiteMap($a_site_map)//设置站点地图
   {
      $this->A_Site_Map = $a_site_map;
   }

   public function setModuleName($s_name)//设置模块名称
   {
      $this->S_Module_Name = $s_name;
   }

   public function getSkinPath()
   {
      return $this->S_Skin_Path;
   }
}
?>