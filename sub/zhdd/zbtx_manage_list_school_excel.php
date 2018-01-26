<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 31001 );
$O_Session='';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once 'include/db_table.class.php';
$O_Session->ValidModuleForPage(MODULEID);
$o_result=new Zhdd_Zbtx_Result_View($_GET['id']);
$S_Filename = $o_result->getDeptName().'.xlsx';
mkdir ( RELATIVITY_PATH . 'userdata/output', 0777 );
OutputList ($_GET['id'],$S_Filename );
$file_dir = RELATIVITY_PATH . 'userdata/output/';
$rename = rawurlencode ( $S_Filename );
Header("Location: ".RELATIVITY_PATH."userdata/output/".$S_Filename); 
//跳转到下载
function OutputList($S_Class,$s_filename) {
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
	
	$objPHPExcel->getDefaultStyle()->getFont()->setName( '宋体');  
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(11);  
	// Add some data
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', '三级指标');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(70);;
	$objPHPExcel->getActiveSheet()->getStyle( 'A1')->getFont()->setBold(true);  
	$objPHPExcel->getActiveSheet()->getStyle( 'A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', '文件说明');
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);  
	$objPHPExcel->getActiveSheet()->getStyle( 'B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$o_result=new Zhdd_Zbtx_Result($_GET['id']);
	$o_term = new Zhdd_Zbtx_Level1();
	$o_term->PushWhere ( array ('&&', 'ProjectId', '=', $o_result->getProjectId()) );
	$o_term->PushWhere ( array ('&&', 'IsDelete', '=', 0) );
	$o_term->PushOrder ( array ('Number', 'A' ) );
	$n_count = $o_term->getAllCount ();	
	$n_row=2;
	for($i = 0; $i < $n_count; $i ++) {
		$o_level2 = new Zhdd_Zbtx_Level2();
		$o_level2->PushWhere ( array ('&&', 'Level1Id', '=', $o_term->getId($i)) );
		$o_level2->PushWhere ( array ('&&', 'IsDelete', '=', 0) );
		$o_level2->PushOrder ( array ('Number', 'A' ) );
		for($j = 0; $j < $o_level2->getAllCount (); $j ++) {
			$o_level3 = new Zhdd_Zbtx_Level3();
			$o_level3->PushWhere ( array ('&&', 'Level2Id', '=', $o_level2->getId($j)) );
			$o_level3->PushWhere ( array ('&&', 'IsDelete', '=', 0) );
			$o_level3->PushOrder ( array ('Number', 'A' ) );
			for($k = 0; $k < $o_level3->getAllCount (); $k ++) {
				//三级指标
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$n_row, $o_level3->getName ( $k ));
				$objPHPExcel->getActiveSheet()->getStyle('A'.$n_row)->getAlignment()->setWrapText(true);
				$o_doc=new Zhdd_Zbtx_Doc();
				$o_doc->PushWhere ( array ('&&', 'Level3Id', '=', $o_level3->getId ( $k )) );
				$o_doc->PushWhere ( array ('&&', 'ResultId', '=', $o_result->getId ()) );
				$o_doc->PushWhere ( array ('&&', 'IsDelete', '=', 0) );
				$o_doc->PushOrder ( array ('Number', 'A' ) );
				$n_start=$n_row;
				$n_end=$n_row-1;
				for($z=0;$z<$o_doc->getAllCount();$z++)
				{
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$n_row, $o_doc->getExplain($z));
					$objPHPExcel->getActiveSheet()->getStyle('B'.$n_row)->getAlignment()->setWrapText(true);
					$n_row++;
					$n_end++;
				}
				if ($o_doc->getAllCount()==0)
				{
					$n_row++;
				}else{
					$objPHPExcel->getActiveSheet()->mergeCells('A'.$n_start.':A'.$n_end);  
				}
							
			}
		}		
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