<?php

header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30008 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);
if (is_numeric ( $_GET ['id'] ) && $_GET ['id'] > 0) {
	$n_articleid = $_GET ['id'];
} else {
	exit ( 0 );
}
$o_article = new Jiaoliu_Article ( $n_articleid );
if ($o_article->getTitle () == false || $o_article->getDelete ()==1) {
	exit ( 0 );
}

$o_date = new DateTime ( 'Asia/Chongqing' );
ob_start();
?>

    <div id="page1">
        <table width="100%" align="center">
            <tbody>
                <tr>
                    <td class="tableTitle" colspan="2">
                        本学期挂牌督导工作下校随访
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="tableOutLine" style="" cellspacing="0" cellpadding="0" width="100%" align="center" border="0">
            <tbody>
                <tr>
                    <td colspan="2" style="width:25%;">
                        督导学校
                    </td>
                    <td style="width:40%">
                        <?php
				echo ($o_article->getSchoolName ());
				?>                    
                    </td>
                    <td style="width:20%">
                        督导日期
                    </td>
                    <td style="width:15%">
                       <?php
				echo ($o_article->getDate ());
				?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width:25%;">
                        到校时间
                    </td>
                    <td style="width:40%">
                        <?php
				echo ($o_article->getStartTime ());
				?>                    
                    </td>
                    <td style="width:20%">
                        离校时间
                    </td>
                    <td style="width:15%">
                       <?php
				echo ($o_article->getEndTime ());
				?>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">
                        参加人员
                    </td>
                    <td>
                        学校
                    </td>
                    <td colspan="3">
                       <?php
				echo ($o_article->getSchoolJoin ());
				?>                  
                    </td>
                </tr>
                <tr>
                    <td>
                        督学
                    </td>
                    <td colspan="3">
                        <?php
				echo ($o_article->getDuxueJoin ());
				?>                
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        内容<br/>纪要
                    </td>
                    <td colspan="3" style="text-align:left;height:400px;line-height:25px;padding:20px;vertical-align:top;">
                    <table style="" cellspacing="0" cellpadding="0" width="100%" align="center" border="0">
                    	<tr>
                    		<td style="text-align:center;padding-bottom:20px;border: 0px solid #3CB623"><?php
				echo ($o_article->getTitle ());
				?></td>
                    	</tr>
                    	<tr>
                    		<td class="content" style="text-align:left;border: 0px solid #3CB623;"><?php
                $s_text= str_ireplace('font-size', 'font-size:12px;', $o_article->getContent ());   
                $s_text= str_replace('calibri', '宋体', $s_text);   		
				echo (str_replace('仿宋_gb2312', '宋体', $s_text));
				?> </td>
                    	</tr>
                    </table>                    
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        意见<br/>建议
                    </td>
                    <td colspan="3" style="text-align:left;height:400px;line-height:25px;padding:20px">
                    
                        <?php
				echo ($o_article->getFeedback ());
				?>
                                    
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<?php 
$content = ob_get_clean();

include(RELATIVITY_PATH."/sub/survey_total/mpdf60/mpdf.php");

$mpdf=new mPDF('zh-CN','A4','','',32,25,27,25,16,13); 
$mpdf->AddPage('','','','','',10,10,10,10,10,10);
$mpdf->useAdobeCJK = true;
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('css/send_pdf.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($content,2);

$mpdf->Output(iconv ( 'UTF-8', 'gbk','本学期挂牌督导工作随访记录.pdf'),'I');
exit;

?>