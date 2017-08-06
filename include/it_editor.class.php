<?php
require_once RELATIVITY_PATH . 'include/it_systext.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
class Editor {
	private $S_Height = '500px';
	private $S_Width = '';
	private $S_Width_Tool = '';
	private $S_Content;
	private $B_Enable = true;
	private $B_AllowUpload = false;
	private $B_Link = false;
	private $S_Script_Enable = 'edit_enable=true;';
	private $O_Picture;
	private $N_Height = 500;
	private $N_PhotoFreeSplace = 0;
	public function setUserObject($o_user) {
			$this->N_PhotoFreeSplace =10000000;//获取用户照片的剩余空间
	}
	public function setHeight($s_height) {
		if (is_numeric ( $s_height )) {
			$this->S_Height = 'height:' . $s_height . 'px';
			$this->N_Height = ( int ) $s_height;
		}
	}
	public function setRoot($s_root) {
		$this->S_Root = $s_root;
	}
	public function setWidth($s_width) {
		if (is_numeric ( $s_width )) {
			$this->S_Width = 'style="width:' . $s_width . 'px"';
			$this->S_Width_Tool = 'style="width:' . ($s_width - 2) . 'px"';
		}
	}
	public function setAllowUpload($s_allow) {
		$this->B_AllowUpload = $s_allow;
	}
	public function setUid($n_uid) {
		$this->O_Picture = new Base_User_Picture();
		$this->O_Picture->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
		$this->O_Picture->PushOrder ( array ('Timecut', 'D' ) );
	}
	public function setContent($s_content) {
		$this->S_Content = $s_content;
	}
	public function setEnable($b_enable) {
		if ($b_enable) {
			$this->S_Script_Enable = 'edit_enable=true;';
		} else {
			$this->S_Script_Enable = 'edit_enable=false;';
		}
	}
	public function getEditor() {
		$s_picture = '';
		if (isset ( $this->O_Picture ) && $this->B_Enable) {
			$n_count = $this->O_Picture->getAllCount ();
			for($i = 0; $i < $n_count; $i ++) {
				$s_picture .= '<div id="picture' . $this->O_Picture->getId ( $i ) . '"><a href="javascript:;" onclick="Editor_InsertPicture(\'' . $this->O_Picture->getPath ( $i ) . '\')"><img src="' . $this->O_Picture->getPath ( $i ) . '" alt="" /></a><a title="删除图片" href="javascript:;" title="" onclick="Editor_DelUpLoadPicture(' . $this->O_Picture->getId ( $i ) . ')"><img src="'.$this->S_Root.'images/email_delete.gif" style="height:16px; width:16px"/></a></div>';
			}
		}
		if ($this->B_AllowUpload) {
			//$o_sysinfo=new Common_Setup(1);
			//$s_uploadurl=$o_sysinfo->getHomePage();
			$s_uploadurl='http://58.128.133.101/';			
			$s_upload = '
		        <div class="popupmenu_popup uploadfile" id="e_cmd_image_menu" style="display: none">
                    <ul class="tab_01 tab_01_cl" id="e_cmd_image_ctrl">
                        <li class="on" id="tab_01"><a href="javascript:;" onclick="Editor_ChangeTab(\'edit_update_tab_url\')">' . SysText::Index ( 'TEXT_033' ) . '</a></li>
                        <li id="tab_02"><a href="javascript:;" onclick="Editor_ChangeTab(\'edit_update_tab_list\')">
                            ' . SysText::Index ( 'TEXT_041' ) . '</a></li>
                        <li id="tab_03"><a href="javascript:;" onclick="Editor_ChangeTab(\'edit_update_tab_upload\')">
                            ' . SysText::Index ( 'TEXT_042' ) . '</a></li>
                    </ul>
                    <div id="edit_update_tab_url">
                    <table style="width: 100%;padding-top:10px" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="f_12_2">
                                <table cellspacing="0" cellpadding="0" width="100%" style="font-weight: normal">
                                    <tbody>
                                        <tr>
                                            <th width="74%" class="f_12_2" style="height: 30px">
                                                ' . SysText::Index ( 'TEXT_034' ) . '
                                            </th>
                                            <th width="13%" class="f_12_2">
                                                ' . SysText::Index ( 'TEXT_035' ) . '
                                            </th>
                                            <th width="13%" class="f_12_2">
                                                ' . SysText::Index ( 'TEXT_036' ) . '
                                            </th>
                                        </tr>
                                        <tr>
                                            <td style="height: 30px">
                                                <input class="txt" id="e_cmd_image_param_1" style="width: 95%" />
                                            </td>
                                            <td>
                                                <input class="txt" id="e_cmd_image_param_2" size="5" maxlength="6" style="width: 50px" />
                                            </td>
                                            <td>
                                                <input class="txt" id="e_cmd_image_param_3" size="5" maxlength="6" style="width: 50px" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="middle" colspan="3" style="height: 30px">
                                                <input id="e_cmd_image_submit" type="button" value="' . SysText::Index ( 'TEXT_037' ) . '" />
                                                &nbsp;
                                                <input onclick="hideMenu();" type="button" value="' . SysText::Index ( 'TEXT_038' ) . '" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="edit_update_tab_list" style="display: none" unselectable="off">
                    <table style="width: 100%;padding-top:10px" border="0" cellspacing="0" cellpadding="0" unselectable="on">
                        <tr>
                            <td class="f_12_2">
                                <table cellspacing="0" cellpadding="0" width="100%" style="font-weight: normal">
                                    <tbody>
                                        <tr>
                                            <td style="height: 20px">
                                                ' . SysText::Index ( 'TEXT_043' ) . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height: 30px">
                                            <div id="edit_pic_list">
                                                 ' . $s_picture . '
                                                </div>
                                                <a class="f_12_4" href="javascript:;" onclick="Editor_ChangeTab(\'edit_update_tab_upload\')">
                                                    ' . SysText::Index ( 'TEXT_042' ) . '</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height: 20px">
                                                ' . SysText::Index ( 'TEXT_044' ) . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="middle" style="height: 20px">
                                                <input onclick="hideMenu();" type="button" value="' . SysText::Index ( 'TEXT_038' ) . '" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="edit_update_tab_upload" style="display:none">
                    <table style="width: 100%;padding-top:10px" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="f_12_2">
                                <table cellspacing="0" cellpadding="0" width="100%" style="font-weight: normal">
                                    <tbody>
                                        <tr>
                                            <td style="height: 40px">                                           
												<object id="vcl_flash_upload" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="470" height="270">
												  <param name="movie" value="' . $this->S_Root . 'images/upload.swf" />
												  <param name="quality" value="high" />
												  <param name="wmode" value="opaque" />
												  <param name="swfversion" value="8.0.35.0" />
												  <param name="FlashVars" value="N_FreeSplace=' . $this->N_PhotoFreeSplace . '&S_Url=' . $s_uploadurl . 'include/bn_submit.svr.php?function=UpLoadPicture"/>
												  <!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 -->
												  <param name="expressinstall" value="' . $this->S_Root . 'images/expressInstall.swf" />
												  <!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 -->
												  <!--[if !IE]>-->
												  <object id="vcl_flash_upload2" type="application/x-shockwave-flash" data="' . $this->S_Root . 'images/upload.swf" width="470" height="270">
												    <!--<![endif]-->
												    <param name="quality" value="high" />
												    <param name="wmode" value="opaque" />
												    <param name="swfversion" value="8.0.35.0" />												   
												    <param name="expressinstall" value="' . $this->S_Root . 'images/expressInstall.swf" />
												    <!-- 浏览器将以下替代内容显示给使用 Flash Player 6.0 和更低版本的用户。 -->
												    <div>
												      如果使用批量上传功能,需要下载较新版本的 Adobe Flash Player。
												      <br/><a href="http://www.adobe.com/go/getflashplayer"><img src="' . $this->S_Root . 'images/get_flash_player.gif" alt="获取 Adobe Flash Player" /></a>
												      <p/>
												      </div>
												    <!--[if !IE]>-->
												  </object>
												  <!--<![endif]-->
												</object>
												<script type="text/javascript">
												<!--
												swfobject.registerObject("vcl_flash_upload");
												//-->
												</script>											  
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height: 40px">
                                                  ' . SysText::Index ( 'TEXT_047' ) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input onclick="hideMenu();" type="button" value="' . SysText::Index ( 'TEXT_038' ) . '" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
        </div>';
		} else {
			$s_upload = '
							<div class="popupmenu_popup uploadfile" id="e_cmd_image_menu" style="display: none">
						        <ul class="tab_01 tab_01_cl" id="e_cmd_image_ctrl">
						            <li class="on" id="tab_01"><a href="javascript:;">
						                ' . SysText::Index ( 'TEXT_033' ) . '</a></li>
						        </ul>
						        <div id="edit_update_tab_url">
						            <table style="width: 100%; padding-top: 10px" border="0" cellspacing="0" cellpadding="0">
						                <tr>
						                    <td class="f_12_2">
						                        <table cellspacing="0" cellpadding="0" width="100%" style="font-weight: normal">
						                            <tbody>
						                                <tr>
						                                    <th width="74%" class="f_12_2" style="height: 30px">
						                                        ' . SysText::Index ( 'TEXT_034' ) . '
						                                    </th>
						                                    <th width="13%" class="f_12_2">
						                                        ' . SysText::Index ( 'TEXT_035' ) . '
						                                    </th>
						                                    <th width="13%" class="f_12_2">
						                                        ' . SysText::Index ( 'TEXT_036' ) . '
						                                    </th>
						                                </tr>
						                                <tr>
						                                    <td style="height: 30px">
						                                        <input class="txt" id="e_cmd_image_param_1" style="width: 95%" />
						                                    </td>
						                                    <td>
						                                        <input class="txt" id="e_cmd_image_param_2" size="5" maxlength="6" style="width: 50px" />
						                                    </td>
						                                    <td>
						                                        <input class="txt" id="e_cmd_image_param_3" size="5" maxlength="6" style="width: 50px" />
						                                    </td>
						                                </tr>
						                                <tr>
						                                    <td align="middle" colspan="3" style="height: 30px">
						                                        <input id="e_cmd_image_submit" type="button" value="' . SysText::Index ( 'TEXT_037' ) . '" />
						                                        &nbsp;
						                                        <input onclick="hideMenu();" type="button" value="' . SysText::Index ( 'TEXT_038' ) . '" />
						                                    </td>
						                                </tr>
						                            </tbody>
						                        </table>
						                    </td>
						                </tr>
						            </table>
						        </div>       
						    </div>';
		}
		$s_html = '<div id="append_parent"></div>                 
                 <div id="edit_content" style="display:none;">
                    ' . $this->S_Content . '
                 </div>
                 <div class="content editorcontent" ' . $this->S_Width . '>
                    <input id="formhash" type="hidden" value="0d149fab" name="formhash" />
                    <input id="e_mode" type="hidden" name="wysiwyg" />
                    <input id="iconid" type="hidden" name="iconid" />
                    <div class="s_clear" id="editorbox">
                        <div class="postbox" id="postbox">
                            <div class="editorrow" id="e_controls" ' . $this->S_Width_Tool . '>
                                <div class="editor">
                                    <div class="editorbtn">
                                        <div style="display: none">
                                            <a id="e_cmd_paste" title="' . SysText::Index ( 'TEXT_001' ) . '">' . SysText::Index ( 'TEXT_001' ) . '</a>
                                        </div>
                                        <div class="minibtn">
                                            <a id="e_cmd_simple" title="' . SysText::Index ( 'TEXT_002' ) . '">B</a> <a id="e_cmd_fontname" title="' . SysText::Index ( 'TEXT_003' ) . '">Font</a>
                                            <a id="e_cmd_fontsize" title="' . SysText::Index ( 'TEXT_004' ) . '">Size</a> <a id="e_cmd_forecolor" title="' . SysText::Index ( 'TEXT_005' ) . '">Color</a>
                                            <em></em><a id="e_cmd_removeformat" title="' . SysText::Index ( 'TEXT_006' ) . '">Removeformat</a> <a id="e_cmd_undo"
                                            title="' . SysText::Index ( 'TEXT_007' ) . '">Undo</a> <a id="e_cmd_redo" title="' . SysText::Index ( 'TEXT_008' ) . '">Redo</a> <a id="e_cmd_paragraph"
                                            title="' . SysText::Index ( 'TEXT_009' ) . '">P</a> <a id="e_cmd_table" title="' . SysText::Index ( 'TEXT_010' ) . '" style="display:none">Table</a> <a id="e_cmd_list" title="' . SysText::Index ( 'TEXT_011' ) . '">
                                                List</a><a id="e_cmd_clearcontent" title="' . SysText::Index ( 'TEXT_012' ) . '">Clearcontent</a><em></em><a id="e_cmd_createlink"
                                                    title="' . SysText::Index ( 'TEXT_013' ) . '">Url</a><a id="e_cmd_unlink" title="' . SysText::Index ( 'TEXT_014' ) . '"> Unlink</a><a id="e_cmd_image"
                                                        title="' . SysText::Index ( 'TEXT_015' ) . '">' . SysText::Index ( 'TEXT_015' ) . '</a>
                                                        <em></em><a href="javascript:;" id="add_line" title="' . SysText::Index ( 'TEXT_048' ) . '" onclick="Editor_AddHeight()">' . SysText::Index ( 'TEXT_048' ) . '</a>
                                                        <a href="javascript:;" id="sub_line" title="' . SysText::Index ( 'TEXT_049' ) . '" onclick="Editor_SubHeight(' . $this->N_Height . ')">' . SysText::Index ( 'TEXT_049' ) . '</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="newediter" id="edit_editor" style="' . $this->S_Height . '">
                                <table style="table-layout: fixed;" cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align:top">
                                                <textarea class="autosave" id="e_textarea" style="display:none;' . $this->S_Height . '" tabindex="1" name="message" rows="1"></textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                <script type="text/javascript">
var editorid = \'e\';
var textobj = DocumentElementById(editorid + \'_textarea\');
var wysiwyg = (BROWSER.ie || BROWSER.firefox || (BROWSER.opera >= 9)) && parseInt(\'\') == 1 ? 1 : 0;
var allowswitcheditor = parseInt(\'1\');
var allowhtml = parseInt(\'1\');
var forumallowhtml = parseInt(\'0\');
var allowsmilies = parseInt(\'1\');
var allowbbcode = parseInt(\'1\');
var allowimgcode = parseInt(\'1\');
var allowpostattach = parseInt(\'\');
var allowpostimg = parseInt(\'\');
var editorcss = \'\';
var TABLEBG = \'#FFF\';
var pid = parseInt(\'\');
var fontoptions = new Array("' . SysText::Index ( 'TEXT_016' ) . '", "' . SysText::Index ( 'TEXT_017' ) . '", "' . SysText::Index ( 'TEXT_018' ) . '", "' . SysText::Index ( 'TEXT_019' ) . '", "' . SysText::Index ( 'TEXT_020' ) . '", "' . SysText::Index ( 'TEXT_021' ) . '", "Trebuchet MS", "Tahoma", "Arial", "Impact", "Verdana", "Times New Roman");
var custombbcodes = new Array();
                </script>

            </div>
        </div>
    </div>
    <div class="editorrow" id="e_menus" style="margin-top: -5px; background: none transparent scroll repeat 0% 0%;
        overflow: hidden; border-top-style: none; border-right-style: none; border-left-style: none;
        height: 0px; border-bottom-style: none">
        <div class="editortoolbar">
            <div class="popupmenu_popup simple_menu" id="e_cmd_simple_menu" style="display: none">
                <ul unselectable="on">
                    <li id="e_cmd_bold" onclick="discuzcode(\'bold\')" unselectable="on">' . SysText::Index ( 'TEXT_022' ) . '</li>
                    <li id="e_cmd_italic" onclick="discuzcode(\'italic\')" unselectable="on">' . SysText::Index ( 'TEXT_023' ) . '</li>
                    <li id="e_cmd_underline" onclick="discuzcode(\'underline\')" unselectable="on">' . SysText::Index ( 'TEXT_024' ) . '</li>
                    <li id="e_cmd_strikethrough" onclick="discuzcode(\'strikethrough\')" unselectable="on">
                        ' . SysText::Index ( 'TEXT_025' ) . '</li>
                    <li id="e_cmd_inserthorizontalrule" onclick="discuzcode(\'inserthorizontalrule\')"
                        unselectable="on">' . SysText::Index ( 'TEXT_026' ) . '</li>
                </ul>
            </div>
            <div class="popupmenu_popup fontname_menu" id="e_cmd_fontname_menu" style="display: none">
                <ul unselectable="on">
                    <li style="font-family: ' . SysText::Index ( 'TEXT_016' ) . '" onclick="discuzcode(\'fontname\', \'' . SysText::Index ( 'TEXT_016' ) . '\')"
                        unselectable="on">' . SysText::Index ( 'TEXT_016' ) . '</li>
                    <li style="font-family: ' . SysText::Index ( 'TEXT_017' ) . '" onclick="discuzcode(\'fontname\', \'' . SysText::Index ( 'TEXT_017' ) . '\')" unselectable="on">
                        ' . SysText::Index ( 'TEXT_017' ) . '</li>
                    <li style="font-family: ' . SysText::Index ( 'TEXT_018' ) . '" onclick="discuzcode(\'fontname\', \'' . SysText::Index ( 'TEXT_018' ) . '\')"
                        unselectable="on">' . SysText::Index ( 'TEXT_018' ) . '</li>
                    <li style="font-family: ' . SysText::Index ( 'TEXT_019' ) . '" onclick="discuzcode(\'fontname\', \'' . SysText::Index ( 'TEXT_019' ) . '\')" unselectable="on">
                        ' . SysText::Index ( 'TEXT_019' ) . '</li>
                    <li style="font-family: ' . SysText::Index ( 'TEXT_020' ) . '" onclick="discuzcode(\'fontname\', \'' . SysText::Index ( 'TEXT_020' ) . '\')" unselectable="on">
                        ' . SysText::Index ( 'TEXT_020' ) . '</li>
                    <li style="font-family: ' . SysText::Index ( 'TEXT_021' ) . '" onclick="discuzcode(\'fontname\', \'' . SysText::Index ( 'TEXT_021' ) . '\')" unselectable="on">
                        ' . SysText::Index ( 'TEXT_021' ) . '</li>
                    <li style="font-family: Trebuchet MS" onclick="discuzcode(\'fontname\', \'Trebuchet MS\')"
                        unselectable="on">Trebuchet MS</li>
                    <li style="font-family: Tahoma" onclick="discuzcode(\'fontname\', \'Tahoma\')" unselectable="on">
                        Tahoma</li>
                    <li style="font-family: Arial" onclick="discuzcode(\'fontname\', \'Arial\')" unselectable="on">
                        Arial</li>
                    <li style="font-family: Impact" onclick="discuzcode(\'fontname\', \'Impact\')" unselectable="on">
                        Impact</li>
                    <li style="font-family: Verdana" onclick="discuzcode(\'fontname\', \'Verdana\')" unselectable="on">
                        Verdana</li>
                    <li style="font-family: Times New Roman" onclick="discuzcode(\'fontname\', \'Times New Roman\')"
                        unselectable="on">Times New Roman</li></ul>
            </div>
            <div class="popupmenu_popup fontsize_menu" id="e_cmd_fontsize_menu" style="display: none">
                <ul unselectable="on">
                    <li onclick="discuzcode(\'fontsize\', 1)" unselectable="on"><font size="1" unselectable="on">
                        1</font></li>
                    <li onclick="discuzcode(\'fontsize\', 2)" unselectable="on"><font size="2" unselectable="on">
                        2</font></li>
                    <li onclick="discuzcode(\'fontsize\', 3)" unselectable="on"><font size="3" unselectable="on">
                        3</font></li>
                    <li onclick="discuzcode(\'fontsize\', 4)" unselectable="on"><font size="4" unselectable="on">
                        4</font></li>
                    <li onclick="discuzcode(\'fontsize\', 5)" unselectable="on"><font size="5" unselectable="on">
                        5</font></li>
                    <li onclick="discuzcode(\'fontsize\', 6)" unselectable="on"><font size="6" unselectable="on">
                        6</font></li>
                    <li onclick="discuzcode(\'fontsize\', 7)" unselectable="on"><font size="7" unselectable="on">
                        7</font></li></ul>
            </div>
            <div class="popupmenu_popup simple_menu" id="e_cmd_paragraph_menu" style="display: none">
                <ul unselectable="on">
                    <li><a id="e_cmd_justifycenter" onclick="discuzcode(\'justifycenter\')" unselectable="on">
                        ' . SysText::Index ( 'TEXT_027' ) . '</a></li>
                    <li><a id="e_cmd_justifyleft" onclick="discuzcode(\'justifyleft\')" unselectable="on">
                        ' . SysText::Index ( 'TEXT_028' ) . '</a></li>
                    <li><a id="e_cmd_justifyright" onclick="discuzcode(\'justifyright\')" unselectable="on">
                        ' . SysText::Index ( 'TEXT_029' ) . '</a></li>
                    <li><a id="e_cmd_autotypeset" onclick="discuzcode(\'autotypeset\')" unselectable="on">
                        ' . SysText::Index ( 'TEXT_030' ) . '</a> </li>
                </ul>
            </div>
            <div class="popupmenu_popup simple_menu" id="e_cmd_list_menu" style="display: none">
                <ul unselectable="on">
                    <li id="e_cmd_insertorderedlist" onclick="discuzcode(\'insertorderedlist\')" unselectable="on">
                        ' . SysText::Index ( 'TEXT_031' ) . '</li>
                    <li id="e_cmd_insertunorderedlist" onclick="discuzcode(\'insertunorderedlist\')" unselectable="on">
                        ' . SysText::Index ( 'TEXT_032' ) . ' </li>
                </ul>
            </div>
        </div>
			' . $s_upload . '
        <script type="text/javascript">
var SHOWIMGPROMPT = false;
var edit_enable=true;
' . $this->S_Script_Enable . '
newEditor(1, bbcode2html(textobj.value));
        </script>
    </div>
    
	
    ';
		return $s_html;
	}
}
?>