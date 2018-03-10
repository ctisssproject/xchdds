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
$o_table=new Zhdd_Appraise($_GET['id']);
//?id=11&school_id=141&info_0=%E5%88%9D%E4%B8%80%E7%8F%AD&info_1=%E8%AF%AD%E6%96%87&info_2=2014-12-12&info_3=%E4%BD%9C%E6%96%87&info_4=%E6%9D%8E%E5%B0%8F%E7%92%90
$a_vcl=json_decode($o_table->getInfo());
$filePath= RELATIVITY_PATH . 'userdata/zhdd/appraise/input/'.$o_table->getId().'.xlsx' ;

//获取上传的excel文件，验证学校名称是否合法
require_once RELATIVITY_PATH . 'include/PHPExcel.php';
$PHPReader = new PHPExcel_Reader_Excel2007 ();
if (! $PHPReader->canRead ( $filePath )) {
	$PHPReader = new PHPExcel_Reader_Excel2007 ();
	if (! $PHPReader->canRead ( $filePath )) {
		exit(0);
	}
}
$PHPExcel = $PHPReader->load ( $filePath );
$currentSheet = $PHPExcel->getSheet ( 0 );
$allColumn = $currentSheet->getHighestColumn ();
$allRow = $currentSheet->getHighestRow ();
$n_count=1;
for($currentRow = 2; $currentRow <= $allRow; $currentRow ++) {
	ob_start();
	$o_school=new Base_Dept();	
	$o_school->PushWhere ( array ('&&', 'Name', '=',$currentSheet->getCell (get_column_number(2,$currentRow))->getValue ()) );
	$o_school->PushWhere ( array ('&&', 'ParentId', '=',1) );
	$o_school->getAllCount ();
	$s_rul='';
	$s_text='';
	//echo(excelTime($currentSheet->getCell (get_column_number(3,2))->getValue ()-1));
	//echo($currentSheet->getCell (get_column_number(3,2))->getValue ());
	if ($o_school->getAllCount ()==0)
	{
		$s_text='<b>学校名称错误</b>';
		$s_rul='';
	}else{
		//构建信息和二维码参数
		$s_text='
		<b>序号：</b>'.$currentSheet->getCell (get_column_number(1,$currentRow))->getValue ().'<br/>
		<b>学校名称：</b>'.$o_school->getName(0).'<br/>';
		$s_rul='id='.$o_table->getId();
		$s_rul.='&school_id='.$o_school->getDeptId(0);
		for($i=0;$i<count($a_vcl);$i++)
		{
			$s_rul.='&info_'.$i.'='.rawurlencode(excelTime($currentSheet->getCell (get_column_number(($i+3),$currentRow))->getValue ()));
			$s_text.='<b>'.rawurldecode($a_vcl[$i]).'：</b>'.excelTime($currentSheet->getCell (get_column_number(($i+3),$currentRow))->getValue ()).'<br/>';
		}		
	}	
?>
	<table cellspacing="0" cellpadding="0" style="width:100%">
		<tr>
			<td style="width:40%">
			<img src="appraise_manage_make_qrcode_show.php?<?php echo($s_rul)?>">
			</td>
			<td style="width:60%;line-height:25px;font-size:18px;">
			<?php 
			echo($s_text);
			?>
			</td>
		</tr>		
	</table>
    
<?php

	$content = ob_get_clean();

	if ($currentRow==2)
	{
		$mpdf->WriteHTML($content,2);
	}else{
		$mpdf->WriteHTML($content,($currentRow+6));
	}

}
function excelTime($date, $time = false) {
	if ((int)$date>25568)
	{	
		$date=$date-1;
		if(function_exists('GregorianToJD')){
			if (is_numeric( $date )) {
				$jd = GregorianToJD( 1, 1, 1970 );
				$gregorian = JDToGregorian( $jd + intval ( $date ) - 25569 );
				$date = explode( '/', $gregorian );
				$date_str = str_pad( $date [2], 4, '0', STR_PAD_LEFT )
				."-". str_pad( $date [0], 2, '0', STR_PAD_LEFT )
				."-". str_pad( $date [1], 2, '0', STR_PAD_LEFT )
				. ($time ? " 00:00:00" : '');
				return $date_str;
			}
		}else{
			$date=$date>25568?$date+1:25569;
			/*There was a bug if Converting date before 1-1-1970 (tstamp 0)*/
			$ofs=(70 * 365 + 17+2) * 86400;
			$date = date("Y-m-d",($date * 86400) - $ofs).($time ? " 00:00:00" : '');
		}
		return $date;
	}else{
		return $date;
	}	
}
function get_column_number($column,$row)
{
	$a_number=array('','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	//先除以24，然后取整
	//echo(floor($column/24));
	if ($column>26)
	{
		if ($column%26==0)
		{
			return $a_number[floor($column/26)-1].$a_number[26].$row;
		}else{
			return $a_number[floor($column/26)].$a_number[$column%26].$row;
		}
	}else{
		return $a_number[$column].$row;
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
