<?php
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
define ( 'RELATIVITY_PATH', '../../' );
require_once 'include/db_table.class.php';
$o_setup=new SurveySetup(1);
$o_date = new DateTime ( 'Asia/Chongqing' );
$s_date=$o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>西城区普通中小学（幼儿园）全面实施素质教育督导评价系统</title>
     <link href="css/layout.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/common.fun.js"></script>
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/ajax_post.class.js"></script>
	<script type="text/javascript" src="js/function.js"></script>
</head>
<body>
      <div id="container">
      <div id="top" style="overflow: inherit;">
              <table style="color:#ffffff;">
                <tr style="height:120px;">
                <td style="width:80px;"><img src="images/6.png"/></td>
                <td style="width:880px;"><h2 >西城区普通中小学（幼儿园）全面实施素质教育督导评价系统</h2></td>
                </tr>
           </table>
       </div>
       <?php 
       if ($s_date>=$o_setup->getStart() && $s_date<=$o_setup->getEnd())
       {
       ?>
             <div id="center">
                   <div class="title" style="text-align:center;padding-top:55px;">
                <h3 align="center">欢迎参加，请输入学校编号！</h3>
            </div>
            <div style="text-align:center;padding-right:175px;padding:35px;padding-top:20px; font-size:18px;line-height:30px;">
            	<input id="Vcl_DeptId" name="Vcl_DeptId" class="BigInput" style="width:200px;font-size:20px;" type="text"/>
            </div>
            <div class="title" style="text-align:center;">
                <h3 align="center">请输入您的序列号！</h3>
            </div>
            
            <div style="text-align:center;padding-right:150px;padding:25px;">
            	<input id="Vcl_Type" name="Vcl_Type" class="BigInput" style="width:200px;font-size:20px;" type="text"/>
            </div>
            <div style="text-align:center;">
				<input type="submit" value="下一步" onclick="next()" class="sv_submit" />
			</div>
        </div>

	<?php 
       }else{
       	?>
       	<div class="title" style="text-align:center; margin-left:0px;">
                <h2 align="center">非常抱歉，问卷评价还没有开始。</h2>
            </div>
       	<?php
       	
       }
	?>
    <div id="bottom" style="margin-top:80px;float:right;width:auto;">
              	<div class="title">
                <h3 align="right">西城区人民政府教育督导室&nbsp;&nbsp;&nbsp;&nbsp;</h3>
                <h4 align="right">2014年9月&nbsp;&nbsp;&nbsp;&nbsp;</h4>
                </div>
       </div>
   </div>
<script>
function next()
{
	var dept=document.getElementById('Vcl_DeptId').value;
	if (dept==0)
	{
		window.alert('请选择您的单位！');
		return;
	}
	if ($('#Vcl_Type').val()=="")
	{
		window.alert('请输入您的序列号！');
		return;
		}
	location='index_type.php?id='+$('#Vcl_Type').val()+'&deptid='+dept;
}
</script>
</body>
</html>
