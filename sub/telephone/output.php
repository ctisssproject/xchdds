<?php
define ( 'RELATIVITY_PATH', '../../' ); //定义相对路径
require_once RELATIVITY_PATH . 'include/bn_session.class.php';
$O_Session = new Session ();
if ($O_Session->Login () == false) //如果没有注册，跳转到首页
{
	echo ('非法操作');
	exit ( 0 );
}
require_once 'include/db_table.class.php';
require_once RELATIVITY_PATH.'sub/survey/include/db_table.class.php';

$S_Filename = '热线登记统计.csv';
OutputList ();

$file_name = 'output.csv';
$file_dir = '';
$rename = rawurlencode ( $S_Filename );
if (! file_exists ( $file_dir . $file_name )) { //检查文件是否存在
	echo "对不起,您要下载的文件不存在";
	exit ();
} else { 
	// 一下是php文件下载的重点
	Header ( "Content-type: application/octet-stream" );
	Header ( "Accept-Ranges: bytes" );
	Header ( "Content-Type: application/force-download" ); //强制浏览器下载
	Header ( "Content-Disposition: attachment; filename=" . $rename ); //重命名文件
	Header ( "Accept-Length: " . filesize ( $file_dir . $file_name ) ); //文件大小
	// 读取文件内容
	@readfile ( $file_dir . $file_name ); //加@不输出错误信息
}
function OutputList() {
	$fp = fopen ( 'output.csv', 'w' );
	$o_sum=new Telephone_Info();
    $o_sum->PushWhere ( array ('&&', 'RecordDate', '>=', $_GET ['start']) );
	$o_sum->PushWhere ( array ('&&', 'RecordDate', '<=', $_GET ['end'] ) );
	$n_total = $o_sum->getAllCount ();
	SetTotalInfo ( '开始时间', $_GET ['start'], '结束时间', $_GET ['end'], $fp );
	SetTotalInfo ( '总数统计', '总数', $n_total.'次', '', $fp );
	
	
	$o_school_type = new Base_School_Type ();
	$o_school_type->PushOrder ( array ('Id', 'A' ) );
	$n_count_type = $o_school_type->getAllCount ();
	for($z = 0; $z < $n_count_type; $z ++) {
		$s_title = '按学校统计：';
		if ($z > 0) {
			$s_title = '';
		}
		//先获取小学校总数列表
		$n_sum = 0;
		$o_school = new SurveyDept ();
		$o_school->PushWhere ( array ('&&', 'Type', '=', $o_school_type->getId ( $z ) ) );
		$o_school->PushWhere ( array ('&&', 'Id', '<>', 0 ) );
		$n_count = $o_school->getAllCount ();
		$a_total_id = Array ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_temp = new Telephone_Info ();
			$o_temp->PushWhere ( array ('&&', 'RecordDate', '>=', $_GET ['start'] ) );
			$o_temp->PushWhere ( array ('&&', 'RecordDate', '<=', $_GET ['end'] ) );
			$o_temp->PushWhere ( array ('&&', 'SchoolId', '=', $o_school->getId ( $i ) ) );
			$n_temp = $o_temp->getAllCount ();
			if ($n_temp > 0) {
				//array_push($a_total_id,'123');
				$a_total_id [$i] = $n_temp;
			}
		}
		//数组降序
		arsort ( $a_total_id );
		foreach ( $a_total_id as $x => $x_value ) {
			$n_sum = $n_sum + $x_value;
		}
		SetTotalInfo ($s_title,$o_school_type->getName ( $z ), $n_sum.'次', '', $fp );
		
		
		//先获取小学校总数列表
		$n_sum = 0;
		$o_school = new SurveyDept ();
		$o_school->PushWhere ( array ('&&', 'Type', '=', $o_school_type->getId ( $z ) ) );
		$o_school->PushWhere ( array ('&&', 'Id', '<>', 0 ) );
		$n_count = $o_school->getAllCount ();
		$a_total_id = Array ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_temp = new Telephone_Info ();
			$o_temp->PushWhere ( array ('&&', 'RecordDate', '>=', $_GET ['start'] ) );
			$o_temp->PushWhere ( array ('&&', 'RecordDate', '<=', $_GET ['end'] ) );
			$o_temp->PushWhere ( array ('&&', 'SchoolId', '=', $o_school->getId ( $i ) ) );
			$n_temp = $o_temp->getAllCount ();
			if ($n_temp > 0) {
				//array_push($a_total_id,'123');
				$a_total_id [$i] = $n_temp;
			}
		}
		//数组降序
		arsort ( $a_total_id );
		foreach ( $a_total_id as $x => $x_value ) {
			$n_sum = $n_sum + $x_value;
			SetTotalInfo ('','',$o_school->getName ( $x ), $x_value.'次', $fp );
		}
	}
	//新生
	$o_temp = new Telephone_Info ();
	$o_temp->PushWhere ( array ('&&', 'RecordDate', '>=',$_GET ['start'] ) );
	$o_temp->PushWhere ( array ('&&', 'RecordDate', '<=', $_GET ['end'] ) );
	$o_temp->PushWhere ( array ('&&', 'SchoolId', '=', 0 ) );
	$n_temp = $o_temp->getAllCount ();
	SetTotalInfo ('','','新生', $n_temp.'次', $fp );
	SetTotalInfo ('按类型统计','','', '', $fp );
	
	$o_type = new Telephone_Type ();
	$o_type->PushOrder ( array ('Id', 'A' ) );
	$n_count = $o_type->getAllCount ();
	for($i = 0; $i < $n_count; $i ++) {
		$o_temp = new Telephone_Info ();
		$o_temp->PushWhere ( array ('&&', 'RecordDate', '>=', $_GET ['start'] ) );
		$o_temp->PushWhere ( array ('&&', 'RecordDate', '<=', $_GET ['end'] ) );
		$o_temp->PushWhere ( array ('&&', 'TypeId', 'Like', '%"' . $o_type->getId ( $i ) . '"%' ) );
		$n_temp = $o_temp->getAllCount ();
		SetTotalInfo ('',$o_type->getName ( $i ),$n_temp.'次', '', $fp );
	}
	fclose ( $fp );
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