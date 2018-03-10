<?php
error_reporting(0);
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 31003 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$o_user = new Single_User ( $O_Session->getUid () );
if ($o_user->ValidModule ( MODULEID ) == false) {
	echo('No right.');
	exit ( 0 );//没有权限
}
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once 'include/db_table.class.php';
if (isset ( $_GET ['id'] )) {
	$o_class=new Zhdd_Appraise();
	$o_class->PushWhere ( array ('&&', 'Id', '=',$_GET ['id']) );
	if ($o_class->getAllCount()>0){
		$s_file_name=$o_class->getTitle(0);
	}else{
		echo('ID error.');
		echo(0);//Id不合法
	}
} else {
	echo('Parameter error.');
	echo(0);//参数错误
}
$S_Filename = $s_file_name.'.xlsx';
OutputList ($_GET ['id'],$S_Filename );
$file_dir = RELATIVITY_PATH . 'userdata/output/';
$rename = rawurlencode ( $S_Filename );
Header("Location: ".RELATIVITY_PATH."userdata/output/".$S_Filename);
//跳转到下载

function OutputList($S_Class,$s_filename) {
	$o_table=new Zhdd_Appraise($S_Class);
	$s_filename=RELATIVITY_PATH . 'userdata/output/'.$s_filename;
	
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
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', '序号');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', '学校名称');
	$a_number=array('C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$a_vcl=json_decode($o_table->getInfo());
	for($i=0;$i<count($a_vcl);$i++)
	{
		$objPHPExcel->getActiveSheet()->SetCellValue($a_number[$i].'1',rawurldecode($a_vcl[$i]));
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

?>