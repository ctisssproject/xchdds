<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30016 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_table.class.php';
require_once 'include/db_view.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
$o_table = new View_Telephone_Info_Special ($_GET['id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
</head>
<body>
<div style="width:640px;">
    <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
        <span style="mso-spacerun:'yes'; font-size:18.0000pt; font-family:'仿宋_GB2312'; ">
        西城区责任督学挂牌督导特殊问题办理记录单<o:p></o:p></span></p>
        <br/>
        <br/>
    <table style="border-collapse:collapse;
width:455.4000pt; margin-left:6.7500pt; margin-right:6.7500pt; mso-table-layout-alt:fixed;
padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; ">
        <tr style="height:46.0500pt; ">
            <td style="width:95.4000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:0.5000pt solid rgb(0,0,0); mso-border-left-alt:0.5000pt solid rgb(0,0,0); border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:0.5000pt solid rgb(0,0,0); mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="127">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    日期</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
            <td colspan="2" 
                style="width:126.0000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:none; ; mso-border-left-alt:none; ; border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:0.5000pt solid rgb(0,0,0); mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="168">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <?php echo($o_table->getRecordDate());?><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
            </td>
            <td colspan="1" 
                style="width:99.0000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:none; ; mso-border-left-alt:none; ; border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:0.5000pt solid rgb(0,0,0); mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="132">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    记录人</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
            <td colspan="3" 
                style="width:135.0000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:none; ; mso-border-left-alt:none; ; border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:0.5000pt solid rgb(0,0,0); mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="180">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <?php echo($o_table->getUserName());?><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
            </td>
        </tr>
        <tr style="height:30.9000pt; ">
            <td rowspan="2" 
                style="width:95.4000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:0.5000pt solid rgb(0,0,0); mso-border-left-alt:0.5000pt solid rgb(0,0,0); border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:none; ; border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="127">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    信息来源</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
            <td style="width:99.0000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:none; ; mso-border-left-alt:none; ; border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="132">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    姓&nbsp;&nbsp;名</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
            <td colspan="2" 
                style="width:90.0000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:none; ; mso-border-left-alt:none; ; border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="120">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; width:100px;">
                    <?php echo($o_table->getName());?><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
            </td>
            <td colspan="2" 
                style="width:72.0000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:none; ; mso-border-left-alt:none; ; border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="96">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; width:100px;">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    联系电话</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    （邮箱）</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
            <td style="width:99.0000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:none; ; mso-border-left-alt:none; ; border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:0.5000pt solid rgb(0,0,0); mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="132">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <?php echo($o_table->getPhone())?><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
            </td>
        </tr>
        <tr style="height:30.6000pt; ">
            <td style="width:99.0000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:none; ; mso-border-left-alt:none; ; border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="132">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    反映学校<br/>（部门）</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
            <td colspan="5" 
                style="width:261.0000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:none; ; mso-border-left-alt:none; ; border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="348">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <?php echo($o_table->getSchoolName())?><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
            </td>
        </tr>
        <tr style="height:140.7500pt; ">
            <td style="width:95.4000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:0.5000pt solid rgb(0,0,0); mso-border-left-alt:0.5000pt solid rgb(0,0,0); border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="127">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    反映情况</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
            <td colspan="6" 
                style="width:360.0000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:none; ; mso-border-left-alt:none; ; border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="480">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt;">
                    <?php echo($o_table->getContent())?><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
            </td>
        </tr>
        <tr style="height:69.1500pt; ">
            <td style="width:95.4000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:0.5000pt solid rgb(0,0,0); mso-border-left-alt:0.5000pt solid rgb(0,0,0); border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="127">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    督导室</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    处理建议</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
            <td colspan="6" 
                style="width:360.0000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:none; ; mso-border-left-alt:none; ; border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="480">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;主管领导：</span><span 
                        style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
        </tr>
        <tr style="height:69.4000pt; ">
            <td style="width:95.4000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:0.5000pt solid rgb(0,0,0); mso-border-left-alt:0.5000pt solid rgb(0,0,0); border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="127">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    教工委、教委</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    意见</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
            <td colspan="6" 
                style="width:360.0000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:none; ; mso-border-left-alt:none; ; border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="480">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;主管领导：</span><span 
                        style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
        </tr>
        <tr style="height:175.8500pt; ">
            <td style="width:95.4000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:0.5000pt solid rgb(0,0,0); mso-border-left-alt:0.5000pt solid rgb(0,0,0); border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="127">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    最终处理结果</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
            <td colspan="6" 
                style="width:360.0000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:none; ; mso-border-left-alt:none; ; border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="480">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p>&nbsp;</o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;承办人：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;完成时间：</span><span 
                        style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
        </tr>
        <tr style="height:76.6500pt; ">
            <td style="width:95.4000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:0.5000pt solid rgb(0,0,0); mso-border-left-alt:0.5000pt solid rgb(0,0,0); border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="127">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; text-align:center; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    答复情况</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
            <td colspan="6" 
                style="width:360.0000pt; padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ; border-left:none; ; mso-border-left-alt:none; ; border-right:0.5000pt solid rgb(0,0,0); mso-border-right-alt:0.5000pt solid rgb(0,0,0); border-top:none; ; mso-border-top-alt:0.5000pt solid rgb(0,0,0); border-bottom:0.5000pt solid rgb(0,0,0); mso-border-bottom-alt:0.5000pt solid rgb(0,0,0); " 
                valign="center" width="480">
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    请在下面选项中画</span><span style="font-size:12.0000pt; font-family:'仿宋_GB2312'; ">√<o:p></o:p></span></p>
                <p class="p0" style="margin-bottom:0pt; margin-top:0pt; ">
                    <span style="mso-spacerun:'yes'; font-size:12.0000pt; font-family:'仿宋_GB2312'; ">
                    电话（&nbsp;&nbsp;&nbsp;）&nbsp;&nbsp;面谈（&nbsp;&nbsp;&nbsp;）&nbsp;&nbsp;电子邮件（&nbsp;&nbsp;&nbsp;）&nbsp;&nbsp;其他（&nbsp;&nbsp;&nbsp;）</span><span 
                        style="font-size:12.0000pt; font-family:'仿宋_GB2312'; "><o:p></o:p></span></p>
            </td>
        </tr>
    </table>
    <p class="p0" style="margin-bottom:0pt; margin-top:0pt; ">
        <span style="mso-spacerun:'yes'; font-size:10.5000pt; font-family:'宋体'; "><o:p>&nbsp;</o:p></span></p>
</div>

</body>
</html>
