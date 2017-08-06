<?php
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
define ( 'RELATIVITY_PATH', '../../' );
require_once 'include/db_table.class.php';
if (isset($_GET['id'])&& $_GET['id']>0)
{
	$o_temp=new SurveyType();
	$o_temp->PushWhere ( array ('&&', 'Number', '=', $_GET['id'] ) );
	if ($o_temp->getAllCount()==0)
	{
		//查找有没有激活码
		$_code=new SurveyCode();
		$_code->PushWhere ( array ('&&', 'Code', '=', $_GET['id'] ) );
		$_code->PushWhere ( array ('&&', 'State', '=', 1) );
		if ($_code->getAllCount()>0)
		{
			$o_temp=new SurveyType();
			if ($_code->getType(0)==0)
			{
				$o_temp->PushWhere ( array ('&&', 'Id', '=',10) );
			}else if ($_code->getType(0)==1){
				$o_temp->PushWhere ( array ('&&', 'Id', '=',6) );
			}else{
				$o_temp->PushWhere ( array ('&&', 'Id', '=',16) );
			}
			$o_temp->getAllCount();
			$s_type=$o_temp->getType(0);
			$_GET['id']=$o_temp->getId(0);
			setcookie ('TYPE',$o_temp->getId(0),0);
			setcookie ('CODE',$_code->getCode(0),0);
		}else{
			echo ('<script>window.alert("您输入的身份编号有误，请重新输入！！");location=\'index.php\'</script>');
			exit(0);
		}
	}else{
		//检测学校类型是否选对
		$b_right=true;
		$o_dept=new SurveyDept($_GET['deptid']);
		if ($o_temp->getType(0)==0)
		{
			//幼儿园
			if($o_dept->getType()!=0)
			{
				$b_right=false;
			}
		}
		if ($o_temp->getType(0)==1)
		{
			//中小学
			if($o_dept->getType()!=1 && $o_dept->getType()!=2 && $o_dept->getType()!=3 && $o_dept->getType()!=5 && $o_dept->getType()!=4)
			{
				$b_right=false;
			}
		}
		if ($o_temp->getType(0)==2)
		{
			//校外
			if($o_dept->getType()!=7)
			{
				$b_right=false;
			}
		}
		if ($b_right==false)
		{
			echo ('<script>window.alert("您输入的学校编号或序列号有误，请重新输入！！");location=\'index.php\'</script>');
			exit(0);
		}
		$_code=new SurveyCode();
		$_GET['id']=$o_temp->getId(0);
		setcookie ( 'TYPE', $o_temp->getId(0),0);
		$s_type=$o_temp->getType(0);
		
	}
}else{
	echo ('<script>location=\'index.php\'</script>');
}


//检测单位编号是否正确
$o_dept=new SurveySetup(1);
$a_dept=split(',', $o_dept->getDept());
if (!in_array($_GET['deptid'], $a_dept))
{
	echo ('<script>window.alert("您输入的单位编号有误，请重新输入！！");location=\'index.php\'</script>');
}
//检测学校类型是否选对
if($s_type==0)
{
	if ($o_dept->getType()!=0)
	{
		//echo ('<script>window.alert("您只能选择幼儿园！！");location=\'index.php\'</script>');
	}
}else{
	if ($o_dept->getType()==0)
	{
		//echo ('<script>window.alert("您只能选择中小学！！");location=\'index.php\'</script>');
	}
}
setcookie ( 'DEPT',$_GET['deptid'], 0 );
$s_temp=rawurldecode($_GET['already']);
$s_temp=str_replace('\\', '', $s_temp);
$a_already=json_decode($s_temp);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>西城区素质教育评价</title>
     <link href="css/layout.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/common.fun.js"></script>
	<script type="text/javascript" src="<?php echo (RELATIVITY_PATH)?>js/ajax_post.class.js"></script>
	<script type="text/javascript" src="js/function.js"></script>
</head>
<body>
 <div id="container" style="display:none">
  <div id="top">
              <table style="color:#ffffff;">
                <tr style="height:120px;">
                <td style="width:80px;"><img src="images/6.png"/></td>
                <td style="width:880px;"><h2>西城区普通中小学全面实施素质教育督导评价系统</h2></td>
                </tr>
           </table>
       </div>
       <div class="top">
            <div class="title" style="text-align:center; margin-left:0px;">
                <h2 align="center">您需要完成以下试题</h2>
            </div>
            <div style="text-align:left;padding:50px;padding-left:100px;">
            <?php 
            $o_table=new SurveySubject();
            for($i=0;$i<count($a_already);$i++)
            {
            	//$o_table->PushWhere ( array ('&&', 'Id', '<>', $a_already[$i] ) );
            }
            $o_table->PushWhere ( array ('&&', 'Delete', '=', 0 ) );
			$o_table->PushOrder ( array ('Id', 'A' ) );
			$n_count=$o_table->getAllCount();
			$b_finish=true;
			for($i=0;$i<$n_count;$i++)
			{
				$a_type=json_decode($o_table->getType($i));
				
				if (in_array($o_temp->getId(0), $a_type))
				{
					
					//判断这个学校是否为35中，如果是，跳过指标体系100131
					/*if ($_GET['deptid']==100131)
					{
						$a_temp=explode('问卷', $o_table->getTitle($i));
						if(count($a_temp)==1)
						{
							continue;
						}
					}*/
					
					//判断是否已经答题
					
					if(in_array($o_table->getId($i), $a_already))
					{
						//echo('<div text-align:left; style="padding:10px;">'.$o_table->getTitle($i).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:green">已完成</span></div>');
					}else{
						$b_finish=false;
						echo('<script>location="index_start.php?id='.$o_table->getId($i).'&already='.rawurlencode($_GET['already']).'&code='.rawurlencode($_code->getCode(0)).'"</script>');
						//echo('<div text-align:left; style="padding:10px;">'.$o_table->getTitle($i).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style="color:blue" href="index_start.php?id='.$o_table->getId($i).'&already='.rawurlencode($_GET['already']).'&code='.rawurlencode($_code->getCode(0)).'">开始答题</a></div>');
					}					
				}
			}
			?>
            </div>
        </div>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <div id="bottom">
              	<div class="title" style="padding-top:80px;">
                <h3 align="right">西城区人民政府教育督导室&nbsp;&nbsp;&nbsp;&nbsp;</h3>
                <h4 align="right">2014年9月&nbsp;&nbsp;&nbsp;&nbsp;</h4>
                </div>
       </div>
</div>
<script>
function next()
{
	if ($('#Vcl_Type').val()=="0")
	{
		window.alert('请选择您属于哪一类人群？');
		return;
		}
	location='index_type.php?id='+$('#Vcl_Type').val();
	}
<?php 
if ($b_finish)
{
	$o_code=new SurveyCode();
	$o_code->PushWhere ( array ('&&', 'Code', '=', $_COOKIE['CODE']) );
	$o_code->PushWhere ( array ('&&', 'State', '=', 1) );
	if ($o_code->getAllCount()>0)
	{
		$o_temp=new SurveyCode($o_code->getId(0));
		$o_temp->setState(0);
		$o_temp->Save();
	}
	//清楚所有cookie
	$o_date = new DateTime ( 'Asia/Chongqing' );
	$n_nowTime = $o_date->format ( 'U' );
	$S_Session_Id = md5 ( $_SERVER ['REMOTE_ADDR'] . $_SERVER ['HTTP_USER_AGENT'] . rand ( 0, 9999 ) . $n_nowTime );
	setcookie ( 'VISITER', '', 0 );
	setcookie ( 'SESSIONID', $S_Session_Id, 0 );
	setcookie ( 'VALIDCODE', '', 0 );
	setcookie ( 'TYPE', '', 0 );
	setcookie ( 'ALREADY', '', 0 );
	setcookie ( 'DEPT','', 0 );
	echo('window.alert("恭喜您，已经完成所有问卷或测评 ！！！");location=\'index.php\';');
	}
?>

</script>

</body>
</html>
