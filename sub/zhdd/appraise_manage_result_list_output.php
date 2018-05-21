<?php
error_reporting(0);
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 31003 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$o_user = new Single_User ( $O_Session->getUid () );
if ($o_user->ValidModule ( MODULEID ) == false) {
	exit ( 0 );
}
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'include/db_table.class.php';
$o_appraise=new Zhdd_Appraise($_GET['id']);
$s_file_name=$o_appraise->getTitle();
$S_Filename = $s_file_name.'.xlsx';
OutputList ($S_Filename );
$file_name = 'ready.csv';
$file_dir = RELATIVITY_PATH . '/sub/zhdd/output/';
$rename = rawurlencode ( $S_Filename );
Header("Location: output/".$S_Filename); 
//echo('<script>location="output/'.$S_Filename.'"</script>');
//跳转到下载  http://wx.mldyey.com/sub/admission/output_all_temp.php?state=5
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
function OutputList($s_filename) {
	$n_counter=1;
	$s_filename='output/'.$s_filename;
	
	/** Include path **/
	ini_set('include_path', ini_get('include_path').'../Classes/');
	
	/** PHPExcel */
	require_once RELATIVITY_PATH .'include/PHPExcel.php';
	
	/** PHPExcel_Writer_Excel2007 */
	require_once RELATIVITY_PATH .'include/PHPExcel/Writer/Excel2007.php';
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
	$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
	$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
	$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
	$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
	
	// Add some data
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '评价日期');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '学校名称');$n_counter++;
	
	$o_article = new Zhdd_Appraise_Answers_View ();
	if ($_GET['owner']!='')
	{
		$o_article->PushWhere ( array ('&&', 'OwnerName', 'like','%'.$_GET['owner'].'%') );
		$o_article->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['id']) );
	}
	if ($_GET['year']!='')
	{
		$o_article->PushWhere ( array ('&&', 'Date', '>=',$_GET['year'].'-01-01') );
		$o_article->PushWhere ( array ('&&', 'Date', '<=',$_GET['year'].'-12-31') );
		$o_article->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['id']) );
	}
	if ($_GET['schoolname']!='')
	{
		$o_article->PushWhere ( array ('&&', 'SchoolName', 'like','%'.$_GET['schoolname'].'%') );
		$o_article->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['id']) );
	}
	$o_article->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['id']) );
	$o_article->PushOrder ( array ('Date', 'D' ) );
	$n_count = $o_article->getAllCount();
	$n_last_question=0;
	//构建标题
	if ($n_count>0)
	{
		$a_vcl=json_decode($o_article->getAppraiseInfo(0));
		$o_questions=new Zhdd_Appraise_Questions($o_article->getAppraiseId(0));
		$o_questions->PushWhere ( array ('&&', 'AppraiseId', '=',$o_article->getAppraiseId(0)) );
		$n_last_question=$o_questions->getAllCount();
	}
	$s_title='';
	for($i=0;$i<count($a_vcl);$i++)
	{
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1),rawurldecode($a_vcl[$i]));$n_counter++;
	}
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '评价人');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '综合评价');$n_counter++;
	
	for($i = 0; $i < $n_count; $i ++) {
		$n_counter=1;
		$n_row=$i+2;
		
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_article->getDate ( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_article->getSchoolName ( $i ));$n_counter++;
		//获取
		$a_date=explode(' ', $o_article->getDate ( $i ));
		$a_vcl=json_decode($o_article->getInfo($i));
		for($j=0;$j<count($a_vcl);$j++)
		{
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), rawurldecode($a_vcl[$j]));$n_counter++;
		}
		$s_last_anwser='';
		eval('$s_last_anwser=$o_article->getAnswer'.$n_last_question.'($i);');
		$s_last_anwser=str_replace('"', '', $s_last_anwser);//去掉多余的双引号
		$o_option=new Zhdd_Appraise_Options($s_last_anwser);
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_article->getOwnerName ( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_option->getNumber());$n_counter++;
	}
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save(iconv ( 'UTF-8',getEncode(),$s_filename));
	return;


}
	function getEncode()
	{
		if (strtoupper(substr(PHP_OS, 0,3)) === 'WIN') {
			$config['system_os']='windows';
			//return $this->getEncode();//user set your server system charset
		} else {
			//$config['system_os']='linux';
			return 'utf-8';
		}
	}
function SetTotalInfo($var1, $var2, $var3, $var4, $file) {
	$a_item = array ();
	array_push ( $a_item, iconv ( 'UTF-8', 'gbk', $var1 ) );
	array_push ( $a_item, iconv ( 'UTF-8', 'gbk', $var2 ) );
	array_push ( $a_item, iconv ( 'UTF-8', 'gbk', $var3 ) );
	array_push ( $a_item, iconv ( 'UTF-8', 'gbk', $var4 ) );
	fputcsv ( $file, $a_item );
}
?>