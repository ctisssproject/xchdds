//______________________________________________________________________________________________________________>'Ajax通讯类
function AjaxRequest(){    
    this.S_Page;//发送服务器地址
    this.S_Send_Xml;
    this.S_Send_Function;
    this.A_Send_Parameter=new Array();
    this.S_Receive_Xml;
    this.S_Receive_Function;
    this.A_Receive_Parameter=new Array();
    this.S_Parameter_Node='PARAMETER';
    this.S_Function_Node='FUNCTION';    
}
AjaxRequest.prototype.SendRequest = function() {//参数_sendInfo:发送到服务器信息,_page:服务器端页面地址
    var _XMLHttp;//通讯对象
    if (window.ActiveXObject)//验证浏览器是否支持Ajax,并获得该对象
    {
        _XMLHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }else if (window.XMLHttpRequest)
            {
            _XMLHttp=new XMLHttpRequest()
            }
    this.BuildSendXml();
    var s_send=this.S_Page+'?xml='+this.S_Send_Xml;              
    _XMLHttp.open("GET",s_send,true)//设置发送信息的网页
    _XMLHttp.onreadystatechange=StateChange//回调函数
    _XMLHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    _XMLHttp.send()//发送信息,
    function StateChange()
    {
        if (_XMLHttp.readyState==4)
        {
            if (_XMLHttp.status==200)
            {
                var o_xml=new AjaxRequest()
                o_xml.setReceiveXml(_XMLHttp.responseText)//接收信息                
                if (_XMLHttp.responseText=='')
                {
                    return
                }
                try
                {    
                    //window.alert(o_xml.getCommand('o_xml'));     
                    eval(o_xml.getCommand('o_xml'))                 
	            }           
                catch(e)
                {
                debugger
                    eval("Dialog_error('Ajax返回信息出现问题 !!')")//执行回调函数
                }
            }
        }
    }
}
AjaxRequest.prototype.setReceiveXml=function(s_xml){
    this.S_Receive_Xml=s_xml
}
AjaxRequest.prototype.getCommand=function(s_obj){
    this.AnalyticReceiveXml() 
    if (this.S_Receive_Function==false){
        return '';
    }
    var s_command=this.S_Receive_Function+'(';
    var s_parameter='';
    for(var i=0;i<this.A_Receive_Parameter.length;i++)
    {
        s_parameter=s_parameter+s_obj+'.A_Receive_Parameter['+i+'],'          
    }
    if (s_parameter!=''){
        s_parameter=s_parameter.substring(0,s_parameter.length-1)
    }
   //window.alert (s_command+s_parameter+');')
    return s_command+s_parameter+');'
    
}
AjaxRequest.prototype.setFunction = function(s_function) {//
    s_function=encodeURIComponent(s_function);
    this.S_Send_Function=s_function;
}
AjaxRequest.prototype.PushParameter = function(s_parameter) {//
    s_parameter=encodeURIComponent(s_parameter);
    this.A_Send_Parameter.push(s_parameter)
}
AjaxRequest.prototype.setPage = function(s_page) {//
    this.S_Page=s_page;
}
AjaxRequest.prototype.BuildSendXml = function() {//
    this.S_Send_Xml='<'+this.S_Function_Node+'>'+this.S_Send_Function+'</'+this.S_Function_Node+'>';
    for(var i=0;i<this.A_Send_Parameter.length;i++)
    {
        this.S_Send_Xml=this.S_Send_Xml+'<'+this.S_Parameter_Node+i+'>'+this.A_Send_Parameter[i]+'</'+this.S_Parameter_Node+i+'>';    
    }
}
AjaxRequest.prototype.AnalyticReceiveXml = function() {//
    this.S_Receive_Function=this.getValue(this.S_Function_Node)
    for(var i=0;i<100;i++){
        var s_parameter=this.getValue(this.S_Parameter_Node+i)
        if (s_parameter===false){
            break;
        }
        this.A_Receive_Parameter.push(s_parameter)
    }
}
AjaxRequest.prototype.getValue = function(s_node) {//
    var n_start=this.S_Receive_Xml.indexOf('<'+s_node+'>')
    if (n_start==-1){
        return false;    
    }
    n_start=n_start+s_node.length+2;
    var n_end=this.S_Receive_Xml.indexOf('</'+s_node+'>');
    if (n_end==-1){
        return false;    
    }
    var s_return=decodeURIComponent(this.S_Receive_Xml.substring(n_start,n_end))
    return s_return;
}
//______________________________________________________________________________________________________________>'通用回调函数,用于执行服务器发回的JavaScript语句

