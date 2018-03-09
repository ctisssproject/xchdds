<?php
set_time_limit(0); 
error_reporting(0);
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 31003 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once 'include/db_table.class.php';
$o_bn_base=new Bn_Basic();
$o_user = new Single_User ( $O_Session->getUid () );
if ($o_user->ValidModule ( MODULEID ) == false) {
	echo('No right.');
	exit ( 0 );//没有权限
}


require_once RELATIVITY_PATH . 'include/mpdf60/mpdf.php';

$mpdf=new mPDF('zh-CN','A4','','',32,25,27,25,16,13); 
$mpdf->AddPage('','','','','',10,10,10,10,10,10);
$mpdf->useAdobeCJK = true;
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('css/qrcode.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$o_school=new Base_Dept($_GET['school_id']);

$o_table=new Zhdd_Appraise($_GET['id']);
//?id=11&school_id=141&info_0=%E5%88%9D%E4%B8%80%E7%8F%AD&info_1=%E8%AF%AD%E6%96%87&info_2=2014-12-12&info_3=%E4%BD%9C%E6%96%87&info_4=%E6%9D%8E%E5%B0%8F%E7%92%90
$a_vcl=json_decode($o_table->getInfo());
for($i=0;$i<count($a_vcl);$i++)
{
	$s_rul.='&info_'.$i.'='.rawurlencode();
}


$n_count=1;
for($i = 0; $i < $n_count; $i ++) {
	ob_start();
	$s_rul='id='.$o_table->getId();	
	$s_rul.='&school_id='.$o_school->getDeptId();
	
?>
	<table cellspacing="0" cellpadding="0" style="width:100%">
		<tr>
			<td style="width:40%">
			<img src="appraise_manage_make_qrcode_show.php?id=1">
			</td>
			<td style="width:60%;line-height:25px;font-size:18px;">
			<b>学校名称：</b>北京市东城区十佳互动<br/>
			<b>督导日期：</b><br/>
			</td>
		</tr>		
	</table>
    
<?php

	$content = ob_get_clean();

	if ($i==0)
	{
		$mpdf->WriteHTML($content,2);
	}else{
		$mpdf->WriteHTML($content,($i+4));
	}

}
function filter($str)
{
	if ($str=='')
	{
		echo('—');
	}else{
		echo($str);
	}
}
$mpdf->Output(iconv ( 'UTF-8', 'gbk','新入园儿童登记表().pdf'),'I');
exit;
?>
