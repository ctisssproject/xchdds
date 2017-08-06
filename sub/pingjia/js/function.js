function verify_browser()
{
	var browser=navigator.appName 
	var b_version=navigator.appVersion 
	var version=b_version.split(";"); 
	var trim_Version=version[1].replace(/[ ]/g,""); 
	var jump=false; 
	if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE6.0") 
	{ 
		jump=true; 
	} 
	else if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE7.0") 
	{ 
		jump=true; 
	} 
	else if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE8.0") 
	{ 
		jump=true; 
	} 
	else if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE9.0") 
	{ 
		jump=true; 
	} 
    if (jump)
    {
        location="browser_error.html"
    }
}
function show_load()
{
	document.getElementById("mask").style.display="block"
}
function hide_load()
{
	document.getElementById("mask").style.display="none"
}
//verify_browser()