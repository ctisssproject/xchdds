<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 30006);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
require_once 'include/db_table.class.php';
require_once RELATIVITY_PATH.'sub/survey/include/db_table.class.php';

function getWidth($n_totle,$n_this){
	$n_width=580;
	if ($n_this==0)
	{
		return 0;
	}
	$n_p=floor(($n_this/$n_totle)*580);
	return $n_p;
}
$n_year=0;
$o_date = new DateTime ( 'Asia/Chongqing' );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/total.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../js/jquery/jquery.min.js"></script>
    <link type="text/css" rel="stylesheet" href="../../module/DatePicker/skin/WdatePicker.css" />
	<script type="text/javascript" src="../../module/DatePicker/WdatePicker.js"></script>
	<script type="text/javascript" src="js/ajax.fun.js"></script>
</head>
<body style="padding: 0px; margin: 0px">
<form method="post" id="dialog_form"
	enctype="multipart/form-data"
	style="width: 100%">
    <table class="total_list" align="center" style="width:100%">
        <tr>
            <td class="line title" style="padding-top:20px; padding-bottom:20px;vertical-align:top">
        开始时间：<input id="Vcl_Start" name="Vcl_Start" size="20" maxlength="20" style="width:80px;" class="BigInput" value="<?php echo($_POST['Vcl_Start'])?>" readonly="readonly" type="text" onclick="WdatePicker()"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;结束时间：<input id="Vcl_End" style="width:80px;" name="Vcl_End" size="20" maxlength="20" class="BigInput" value="<?php echo($_POST['Vcl_End'])?>" readonly="readonly" type="text" onclick="WdatePicker()"/>
        &nbsp;&nbsp;&nbsp;&nbsp;<input value="查询" class="BigButtonA" onclick="total_submit()" type="button" />
        <?php 
        if ($_POST['Vcl_Start']!='')
        {
        ?>
        &nbsp;&nbsp;&nbsp;&nbsp;<input value="导出" class="BigButtonA" onclick="export_submit()" type="button" />
        <?php 
        }
        ?>
            </td>
        </tr>
        <?php 
        if ($_POST['Vcl_Start']!='')
        {
        	$o_sum=new Telephone_Info();
        	$o_sum->PushWhere ( array ('&&', 'RecordDate', '>=', $_POST ['Vcl_Start']) );
        	$o_sum->PushWhere ( array ('&&', 'RecordDate', '<=', $_POST ['Vcl_End']) );
        	$n_total=$o_sum->getAllCount();
        	echo('
		        <tr>
		            <td class="line">
		                <table class="total_list" align="center">
		                    <tr>
		                        <td class="td1">
		                            总数统计：
		                        </td>
		                        <td class="td2">
		                            总数
		                        </td>
		                        <td class="td3">
		                        <div class="t" style="width:'.getWidth($n_total, $n_total).'px"></div>'.$n_total.' 次
		                        </td>
		                    </tr>                   
		                </table>
		            </td>
		        </tr>
        	');
        	//按学校排序
        	echo('
		        <tr>
		            <td class="line">
		                <table class="total_list" align="center">
		                ');
        	$o_school_type=new Base_School_Type();
        	$o_school_type->PushOrder ( array ('Id', 'A' ) );
        	$n_count_type=$o_school_type->getAllCount();
        	for($z=0;$z<$n_count_type;$z++)
        	{
        		$s_title='按学校统计：';
        		if ($z>0)
        		{
        			$s_title='&nbsp;';
        		}
        		echo('              <tr>
		                        <td class="td1">
		                          '.$s_title.'
		                        </td>
		                        <td class="td2" style="width:100px">
		                           <span style="font-weight:bold;font-size:14px;">'.$o_school_type->getName($z).'</span>
		                        </td>
		                        <td class="td3" id="sch_'.$o_school_type->getId($z).'">
		                        
		                        </td>
		                    </tr>');  
	        	//先获取小学校总数列表
	        	$n_sum=0;
	        	$o_school=new SurveyDept();
	        	$o_school->PushWhere ( array ('&&', 'Type', '=', $o_school_type->getId($z)) );
	        	$o_school->PushWhere ( array ('&&', 'Id', '<>', 0) );
	        	$n_count=$o_school->getAllCount();
	        	$a_total_id=Array();
	        	for($i=0;$i<$n_count;$i++)
	        	{
	        		$o_temp=new Telephone_Info();
	        		$o_temp->PushWhere ( array ('&&', 'RecordDate', '>=', $_POST ['Vcl_Start']) );
	        		$o_temp->PushWhere ( array ('&&', 'RecordDate', '<=', $_POST ['Vcl_End']) );
	        		$o_temp->PushWhere ( array ('&&', 'SchoolId', '=',$o_school->getId($i)) );
	        		$n_temp=$o_temp->getAllCount();
	        		if ($n_temp>0)
	        		{
	        			//array_push($a_total_id,'123');
	        			$a_total_id[$i]=$n_temp;
	        		}        		
	        	}
	        	//数组降序
	        	arsort($a_total_id);
	        	foreach($a_total_id as $x=>$x_value)
	    		{
	    			$n_sum=$n_sum+$x_value;
	   				echo('      <tr>
			                        <td class="td1">
			                            &nbsp;
			                        </td>
			                        <td class="td2">
			                           &nbsp;
			                        </td>
			                        <td class="td3">
			                        <span>'.$o_school->getName($x).'</span>
			                        </td>
			                    </tr> 
	   							<tr>
			                        <td class="td1">
			                            &nbsp;
			                        </td>
			                        <td class="td2">
			                            次数
			                        </td>
			                        <td class="td3">
			                        <div class="m" style="width:'.getWidth($n_total, $x_value).'px"></div>'.$x_value.' 次
			                        </td>
			                    </tr>');
	    		}
	    		echo('<script>$("#sch_'.$o_school_type->getId($z).'").html("'.$n_sum.' 次");</script>');
        	}
		     /*
        	
    		//小学
    		echo('
		                    <tr>
		                        <td class="td1">
		                          &nbsp;
		                        </td>
		                        <td class="td2">
		                           <span style="font-weight:bold;font-size:14px;">小学</span>
		                        </td>
		                        <td class="td3" id="min_sch">
		                        
		                        </td>
		                    </tr>'); 
        	//先获取中学校总数列表        	
        	$o_school=new SurveyDept();
        	$o_school->PushWhere ( array ('&&', 'Type', '=', 2) );
        	$o_school->PushWhere ( array ('&&', 'Id', '<>', 0) );
        	$o_school->PushWhere ( array ('||', 'Type', '=', 1) );
        	$o_school->PushWhere ( array ('&&', 'Id', '<>', 0) );
        	$n_count=$o_school->getAllCount();
        	$a_total_id=Array();
        	for($i=0;$i<$n_count;$i++)
        	{
        		$o_temp=new Telephone_Info();
        		$o_temp->PushWhere ( array ('&&', 'RecordDate', '>=', $_POST ['Vcl_Start']) );
        		$o_temp->PushWhere ( array ('&&', 'RecordDate', '<=', $_POST ['Vcl_End']) );
        		$o_temp->PushWhere ( array ('&&', 'SchoolId', '=',$o_school->getId($i)) );
        		$n_temp=$o_temp->getAllCount();
        		if ($n_temp>0)
        		{
        			//array_push($a_total_id,'123');
        			$a_total_id[$i]=$n_temp;
        		}        		
        	}
        	//数组降序
        	arsort($a_total_id);
        	foreach($a_total_id as $x=>$x_value)
    		{
    			$n_sum=$n_sum+$x_value;
   				echo('      <tr>
		                        <td class="td1">
		                            &nbsp;
		                        </td>
		                        <td class="td2">
		                           &nbsp;
		                        </td>
		                        <td class="td3">
		                        <span>'.$o_school->getName($x).'</span>
		                        </td>
		                    </tr> 
   							<tr>
		                        <td class="td1">
		                            &nbsp;
		                        </td>
		                        <td class="td2">
		                            次数
		                        </td>
		                        <td class="td3">
		                        <div class="m" style="width:'.getWidth($n_total, $x_value).'px"></div>'.$x_value.' 次
		                        </td>
		                    </tr>');
    		} 
    		echo('<script>$("#min_sch").html("'.$n_sum.' 次");</script>');
        	//幼儿园
    		echo('
		                    <tr>
		                        <td class="td1">
		                          &nbsp;
		                        </td>
		                        <td class="td2">
		                           <span style="font-weight:bold;font-size:14px;">幼儿园</span>
		                        </td>
		                        <td class="td3">
		                        
		                        </td>
		                    </tr>'); 
        	//先获取中学校总数列表        	
        	$o_school=new SurveyDept();
        	$o_school->PushWhere ( array ('&&', 'Type', '=', 0) );
        	$o_school->PushWhere ( array ('&&', 'Id', '<>', 0) );
        	$n_count=$o_school->getAllCount();
        	$a_total_id=Array();
        	for($i=0;$i<$n_count;$i++)
        	{
        		$o_temp=new Telephone_Info();
        		$o_temp->PushWhere ( array ('&&', 'RecordDate', '>=', $_POST ['Vcl_Start']) );
        		$o_temp->PushWhere ( array ('&&', 'RecordDate', '<=', $_POST ['Vcl_End']) );
        		$o_temp->PushWhere ( array ('&&', 'SchoolId', '=',$o_school->getId($i)) );
        		$n_temp=$o_temp->getAllCount();
        		if ($n_temp>0)
        		{
        			//array_push($a_total_id,'123');
        			$a_total_id[$i]=$n_temp;
        		}        		
        	}
        	//数组降序
        	arsort($a_total_id);
        	foreach($a_total_id as $x=>$x_value)
    		{
   				echo('      <tr>
		                        <td class="td1">
		                            &nbsp;
		                        </td>
		                        <td class="td2">
		                           &nbsp;
		                        </td>
		                        <td class="td3">
		                        <span>'.$o_school->getName($x).'</span>
		                        </td>
		                    </tr> 
   							<tr>
		                        <td class="td1">
		                            &nbsp;
		                        </td>
		                        <td class="td2">
		                            次数
		                        </td>
		                        <td class="td3">
		                        <div class="m" style="width:'.getWidth($n_total, $x_value).'px"></div>'.$x_value.' 次
		                        </td>
		                    </tr>');
    		}*/
    		$o_temp=new Telephone_Info();
        	$o_temp->PushWhere ( array ('&&', 'RecordDate', '>=', $_POST ['Vcl_Start']) );
        	$o_temp->PushWhere ( array ('&&', 'RecordDate', '<=', $_POST ['Vcl_End']) );
        	$o_temp->PushWhere ( array ('&&', 'SchoolId', '=',0) );
        	$n_temp=$o_temp->getAllCount();
    		echo('
		                    <tr>
		                        <td class="td1">
		                          &nbsp;
		                        </td>
		                        <td class="td2">
		                           <span style="font-weight:bold;font-size:14px;">新生</span>
		                        </td>
		                        <td class="td3">
		                        
		                        </td>
		                    </tr>
		                    <tr>
		                        <td class="td1">
		                            &nbsp;
		                        </td>
		                        <td class="td2">
		                            次数
		                        </td>
		                        <td class="td3">
		                        <div class="m" style="width:'.getWidth($n_total, $n_temp).'px"></div>'.$n_temp.' 次
		                        </td>
		                    </tr>'); 
    		echo('                 
		                </table>
		            </td>
		        </tr>
        	');
    		echo('
		        <tr>
		            <td class="line">
		                <table class="total_list" align="center">
		                    <tr>
		                        <td class="td1">
		                           按类型统计：
		                        </td>
		                        <td class="td2">
		                          
		                        </td>
		                        <td class="td3">
		                        
		                        </td>
		                    </tr>'); 
    		//获取类型
    		$o_type=new Telephone_Type();
    		$o_type->PushOrder ( array ('Id', 'A' ) );
			$n_count=$o_type->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				$o_temp=new Telephone_Info();
        		$o_temp->PushWhere ( array ('&&', 'RecordDate', '>=', $_POST ['Vcl_Start']) );
        		$o_temp->PushWhere ( array ('&&', 'RecordDate', '<=', $_POST ['Vcl_End']) );
        		$o_temp->PushWhere ( array ('&&', 'TypeId', 'Like','%"'.$o_type->getId($i).'"%') );
        		$n_temp=$o_temp->getAllCount();
        		echo('      <tr>
		                        <td class="td1">
		                            &nbsp;
		                        </td>
		                        <td class="td2">
		                           &nbsp;
		                        </td>
		                        <td class="td3">
		                        <span>'.$o_type->getName($i).'</span>
		                        </td>
		                    </tr> 
   							<tr>
		                        <td class="td1">
		                            &nbsp;
		                        </td>
		                        <td class="td2">
		                            次数
		                        </td>
		                        <td class="td3">
		                        <div class="m" style="width:'.getWidth($n_total, $n_temp).'px"></div>'.$n_temp.' 次
		                        </td>
		                    </tr>');
			}
    		echo('                 
		                </table>
		            </td>
		        </tr>
        	');        	
        }
        ?>
    </table>
</form>
    <script type="text/javascript" language="javascript">
	S_Root='../../';
    </script>

</body>
</html>