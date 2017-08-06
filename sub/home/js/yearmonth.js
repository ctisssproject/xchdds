//Form ShangHaiTongCheng--liaohongfa
var xians ="";
var del ="";
var date ="";
var year="";
var add="";
var tc ="";
var getvalue="";
var relative ="";
var type="index";
var infourl = "";
var now = new Date();
var nyear = now.getFullYear();
//var now = "2014-01,2013-10";

function huanghtml(obj){


var xhtml ="";
xhtml+=' <img id="tc" border="0" onfocus=this.blur() onClick="show(this)" src="images/more.png" >';
xhtml+=' <div id="xians" style="left:2px;top:300px;position:absolute;border: 1px solid #dddddd;';
xhtml+=' width:200px;background-color:#E1EAFA; z-';
xhtml+=' index:999999;display:none;"><table id="date" style="background-color:#EDF2F6;"> ';
xhtml+=' <tr >';
xhtml+=' <td colspan="4" style="text-align:center;" class="top">';
xhtml+=' <span class="span"><a id="del" href="javascript:DelYear()" onfocus=this.blur()> ';
xhtml+='<img src="images/left.gif" border="0"></a>&nbsp;&nbsp;&nbsp;';
//xhtml+=' <input  readonly="readonly"id="year" value="2014" height="3" size="5" maxlength="4" style="border:1px solid #cccccc;padding-left:2px;">';
xhtml+=getSelect(nyear);
xhtml+='&nbsp;&nbsp;&nbsp;<a href="javascript:AddYear()" onfocus=this.blur() id="add" >';
xhtml+='<img border="0"  src="images/right0.gif"></a><a href="javascript:hide()" onfocus=this.blur() class="aright"><img src="images/delete.gif" border="0" ></a></span> ';
//xhtml+=' ';	
xhtml+=' </td></tr><tr style="border="1px solid red"><td ';
xhtml+=' class="td" id="month1" ><a onclick="ChangeMonth(this,1)" href="#">一月</a></td><td " ';
xhtml+=' class="td" id="month2"><a onclick="ChangeMonth(this,2)" href="#">二月</a></td><td  class="td" id="month3"><a onclick="ChangeMonth(this,3)" href="#">三月</a></td><td ';
xhtml+=' class="td" id="month4"><a onclick="ChangeMonth(this,4)" href="#">四月</a></td></tr><tr><td ';
xhtml+=' class="td" id="month5"><a onclick="ChangeMonth(this,5)" href="#">五月</a></td><td  ';
xhtml+=' class="td" id="month6"><a onclick="ChangeMonth(this,6)" href="#">六月</a></td><td class="td" id="month7"><a onclick="ChangeMonth(this,7)" href="#">七月</a></td><td ';
xhtml+=' class="td" id="month8"><a onclick="ChangeMonth(this,8)" href="#">八月</a></td></tr><tr><td ';
xhtml+=' class="td" id="month9"><a onclick="ChangeMonth(this,9)" href="#">九月</a></td><td ';
xhtml+=' class="td" id="month10"><a onclick="ChangeMonth(this,10)" href="#">十月</a></td><td class="td" id="month11"><a onclick="ChangeMonth(this,11)" href="#">十一月</a></td><td ';
xhtml+=' class="td" id="month12"><a onclick="ChangeMonth(this,12)" href="#">十二月</a></td><td><input type="text" id="getvalue" ';
xhtml+=' style="display:none;" /></td></tr></table> ';
//xhtml+=' <button class="button" onclick="nowDate()">当前年月</button>';
xhtml+=' </div>';

document.getElementById(obj).innerHTML= xhtml;
filtermonth(document.getElementById("year").value);
}
//
var selec = null;
		function getSelect(year){
			//alert();
			if(!year){
				year = new Date().getFullYear();
			}
			//alert(year)
			selec = "<select  height=\"3\" onChange=\"changeYear()\" id=\"year\" style=\"border:1px solid #cccccc;padding-left:2px;\">";
			for(var i = 15; i >=0; i--){
				//alert("111");
				if(i==0){
					selec=selec+"<option selected value=\""+(year - i )+"\">"+(year - i )+"</option>";
					}else{
				selec=selec+"<option value=\""+(year - i )+"\">"+(year - i )+"</option>";
					}
			}
			//alert("00");
			//for(var i = 1; i <= 10; i++){
			//	selec=selec+"<option value=\""+(year + i )+"\">"+(year + i )+"</option>";
			//}
			selec =selec+ "</select>";
			
			//alert();
			return selec;
		};
//
function filtermonth(year){
	var zhon =["一","二","三","四","五","六","七","八","九","十","十一","十二"]; 
	for(var i=1;i<=12;i++){
		 document.getElementById("month"+i).innerHTML="<a onclick=\"ChangeMonth(this,"+i+")\" href=\"#\">"+zhon[i-1]+"月</a>";
		}
	for(var i=1;i<=12;i++){
		//var yn=i;
		//if(yn<10){
		//		yn = "0"+yn;
		//	}
		//var ym = year+"-"+yn;

		var nowmont = "month"+i;
		var starts = start.split("-");
		var ends = end.split("-");
		if(parseInt(starts[0])== parseInt(year))
		{
			if(parseInt(ends[0])==parseInt(year)){
				if(parseInt(ends[1])>=i ){
					document.getElementById(nowmont).style.background="lavender";
   					document.getElementById(nowmont).style.color ="#060300";
					}else{
						document.getElementById(nowmont).style.background="#ffffff";
   						 document.getElementById(nowmont).innerHTML="&nbsp;";
						}
		}else{
			if(parseInt(starts[1])<=i){
				document.getElementById(nowmont).style.background="lavender";
   				document.getElementById(nowmont).style.color ="#060300";
				}else{
				document.getElementById(nowmont).style.background="#ffffff";
   				 document.getElementById(nowmont).innerHTML="&nbsp;";
			}
		}
   	
		}else if(parseInt(starts[0])<parseInt(year)&&parseInt(year)<parseInt(ends[0])){
			document.getElementById(nowmont).style.background="lavender";
   			document.getElementById(nowmont).style.color ="#060300";
		}else if(parseInt(starts[0])!= parseInt(year)&&parseInt(ends[0])==parseInt(year)){
				if(parseInt(ends[1])>=i ){
					document.getElementById(nowmont).style.background="lavender";
   					document.getElementById(nowmont).style.color ="#060300";
					}else{
						document.getElementById(nowmont).style.background="#ffffff";
   						 document.getElementById(nowmont).innerHTML="&nbsp;";
						}
		}else{
			document.getElementById(nowmont).style.background="#ffffff";
   			 document.getElementById(nowmont).innerHTML="&nbsp;";
			}
		}
	
	}
function setvalue(obj)
{
 huanghtml(obj);
 //
 var thisURL = document.URL;
var infoid = thisURL.substring(thisURL.lastIndexOf("/")+1,thisURL.length)
infourl = thisURL.substring(0,thisURL.lastIndexOf("/")+1)
if(infoid.length>0){
if(infoid.indexOf("_")<0){
	type = infoid.substring(0,infoid.lastIndexOf("."))
	}else{
		type = infoid.substring(0,infoid.lastIndexOf("_"))
		}
}

 //
 tc = "tc"+obj;
 xians = "tc"+obj+"xians"; 
 del   = "tc"+obj+"del";
 date  = "tc"+obj+"date";	
 year  = "tc"+obj+"year";
 add   = "tc"+obj+"add";
 getvalue ="tc"+obj+"getvalue";
 relative = "tc"+obj+"relative";
 document.getElementById("tc").id=tc;	 
 document.getElementById("xians").id=xians;
 document.getElementById("del").id=del;
 document.getElementById("date").id=date;
 document.getElementById("year").id=year;
 document.getElementById("add").id=add;
 document.getElementById("getvalue").id=getvalue;
 //nowDate();
 //document.getElementById("relative").id=relative;
 //$("#"+tc+"").attr("size",textsize);
}
function changeYear(){
	   var yearid= tc+"year";
	   var year=document.getElementById(yearid).value;
	  // alert(year);
	   //year=Number(year)+1;
	   document.getElementById(yearid).value=year; 
	   filtermonth(year);
	}
function AddYear(){
	   var yearid= tc+"year";
	   var year=document.getElementById(yearid).value;
	   if(nyear!=year){
		    year=Number(year)+1;
		   }
	   document.getElementById(yearid).value=year; 
	   filtermonth(year);
	}
	function DelYear(){
	  yearid= tc+"year";	
	   var year=document.getElementById(yearid).value;
	   if(nyear-15!=year){
		    year=Number(year)-1;
		   }
	   //year=Number(year)-1;
	   document.getElementById(yearid).value=year;
	   filtermonth(year);
	}
	function ChangeMonth(obj,mon){
	  var  dateid = tc+"date";
      var yearid = tc + "year"; 
	  var addid =tc+"add"; 
	  var xiansid =tc+"xians"; 
	 // var getvalueid = tc+"getvalue";	
	  var relative = tc+"relative";
	   var trs=document.getElementById(dateid).getElementsByTagName("tr");
	   for(i=1;i<trs.length;i++){
	      var tds=trs[i].getElementsByTagName("td");
	      for(j=0;j<tds.length;j++){
	          tds[j].style.background="lavender";
	      }
	   }
	   
	   //document.getElementById("month1").style.background="#ffffff";
	   //document.getElementById("month1").style.color ="#ffffff";
	   var year=document.getElementById(yearid).value;
	   filtermonth(year);
	   //obj.style.background="tomato";
	   document.getElementById("month"+mon).style.background="tomato";
	  
	   //var month = obj.innerHTML;
	   //month=obj.innerHTML.substring(0,1);
	   //if(obj.innerHTML.length>2)
	   ///   month = obj.innerHTML.substring(0,2);
	   //}
	  // var svalue =year+"年"+month+"月";
      // var formtvalue=year+"-"+month;
			//
			if(mon.toString().length<2){
				mon = "0"+mon;
				}
				//alert(infourl+"list/"+type+"/"+year+"-"+mon+"/"+type+".htm");
			//
	  // document.getElementById(getvalueid).value=formtvalue;
	   //document.getElementById(tc).value=svalue;	
	   document.getElementById(xiansid).style.display="none";
	 //  document.getElementById(relative).style.display="none";
	 var ul = infourl+"list/"+type+"/"+year+"-"+mon+"/"+type+".htm";
	 window.open(ul, "_blank"); 
	 //location.href=infourl+"list/"+type+"/"+year+"-"+mon+"/"+type+".htm";
	}
	function show(obj){
		 var id =obj.id;
		 tc = id;
		 with(pos(obj)){
			 document.getElementById(tc+"xians").style.top = Top-117;
			 document.getElementById(tc+"xians").style.left = Left;
		 }
		// document.getElementById(tc).style.border="1px solid #74E540";
		 document.getElementById(tc+"xians").style.display="block";
		// document.getElementById(tc+"relative").style.display="block";
	}
	
	function getvalue(obj){
		var  getid="tc"+obj;
		var getvalue = document.getElementById(getid).value;
		if(getvalue.length>7){
			getvalue = getvalue.substring(0,4)+"-"+getvalue.substring(5,7);	
		}else{
			getvalue = getvalue.substring(0,4)+"-"+getvalue.substring(5,6);	
		}
		return getvalue;
	}
	function setsize(x,y){
		 document.getElementById(tc+"xians").style.top = x;
		 document.getElementById(tc+"xians").style.left = y;
	}
	var pos=function(str){
		//获取元素绝对位置
		    var Left=0,Top=0;
		    do{Left+=str.offsetLeft,Top+=str.offsetTop;}
		    while(str=str.offsetParent);
		    return {"Left":Left,"Top":Top};
		}
	function hide(){
		var xiansid =tc+"xians"; 
		var relative = tc+"relative";
		document.getElementById(xiansid).style.display="none";
	//	document.getElementById(relative).style.display="none";
	}
	function nowDate(){
		var date = new Date();
		var dateid = tc+"date";
		var year = date.getFullYear();
		var month = date.getMonth()+1;
		var trs=document.getElementById(dateid).getElementsByTagName("tr");
		for(i=1;i<trs.length;i++){
		  var tds=trs[i].getElementsByTagName("td");
		  for(j=0;j<tds.length;j++){
		     tds[j].style.background="lavender";
		     var obj = tds[j];
		     var objhtml=obj.innerHTML.substring(0,1);
			   if(obj.innerHTML.length>2)
			   {
				   objhtml = obj.innerHTML.substring(0,2);
			   }
		     if(objhtml==month){
		    	 tds[j].style.background="tomato";
		     }
		  }
		}
		if(month.toString().length<2){
				month = "0"+month;
				}
				//alert(infourl+"list/"+type+"/"+year+"-"+month+"/"+type+".htm");
		document.getElementById(tc+"date").value=year;		
		//document.getElementById(tc).value=year+"年"+month+"月";
		document.getElementById(tc+"xians").style.display="none";
		//location.href=infourl+"list/"+type+"/"+year+"-"+month+"/"+type+".htm";
			 var ul = infourl+"list/"+type+"/"+year+"-"+month+"/"+type+".htm";
	 window.open(ul, "_blank"); 
	}
	
	function loadjscssfile(filename,filetype){

    if(filetype == "js"){
        var fileref = document.createElement('script');
        fileref.setAttribute("type","text/javascript");
        fileref.setAttribute("src",filename);
    }else if(filetype == "css"){
    
        var fileref = document.createElement('link');
        fileref.setAttribute("rel","stylesheet");
        fileref.setAttribute("type","text/css");
        fileref.setAttribute("href",filename);
    }
   if(typeof fileref != "undefined"){
        document.getElementsByTagName("head")[0].appendChild(fileref);
    }
    
}

