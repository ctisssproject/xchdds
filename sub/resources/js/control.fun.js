   function resizeLayout()
   {
      // 主操作区域高度
      var wWidth = (window.document.documentElement.clientWidth || window.document.body.clientWidth || window.innerHeight);
      var wHeight = (window.document.documentElement.clientHeight || window.document.body.clientHeight || window.innerHeight);
      var nHeight = $('#north').is(':visible') ? $('#north').outerHeight() : 0;
      var fHeight = $('#funcbar').is(':visible') ? $('#funcbar').outerHeight() : 0;
      var cHeight = wHeight - nHeight - fHeight - $('#south').outerHeight() - $('#taskbar').outerHeight()-60;
      $('#center').height(cHeight);
      
      $("#center iframe").css({height: cHeight});

/*
      if(isTouchDevice())
      {
         $('.tabs-panel:visible').height(cHeight);
         if($('.tabs-panel > iframe:visible').height() > cHeight)
            $('.tabs-panel:visible').height($('.tabs-panel > iframe:visible').height());
      }
*/
      //一级标签宽度
   };
function showButton(obj)
 {
    a_div=obj.getElementsByTagName('div')
    if (a_div.length>1)
    {
        a_div[8].style.display='block'
    }else{
        a_div[0].style.display='block'
    }
 }
function hideButton(obj)
 {
    a_div=obj.getElementsByTagName('div')
    if (a_div.length>1)
    {
        a_div[8].style.display='none'
    }else{
        a_div[0].style.display='none'
    }
 }
 function showButtonLine(obj)
 {
    a_div=obj.getElementsByTagName('div')
    if (a_div.length>1)
    {
        a_div[3].style.display='block'
    }else{
        a_div[0].style.display='block'
    }
 }
function hideButtonLine(obj)
 {
    a_div=obj.getElementsByTagName('div')
    if (a_div.length>1)
    {
        a_div[3].style.display='none'
    }else{
        a_div[0].style.display='none'
    }
 }
function selected(obj)
 {
 try
    {
        if (obj.getElementsByTagName('input')[0].checked==true)
        {
            obj.className='off' 
            obj.getElementsByTagName('input')[0].checked=false 
        }else{
            obj.getElementsByTagName('input')[0].checked=true
            obj.className='on' 
        }
    }           
catch(e){}
    

 }
function selectedForCheck(obj)
 {
    if (obj.checked==true)
    {
        obj.parentNode.parentNode.className='off'
        obj.checked=false 
    }else{
        obj.parentNode.parentNode.className='on'
        obj.checked=true 
    }
}
function selectAll(obj)
{
   if (obj.checked==true)
    {
        var a_obj=document.getElementsByTagName('input')
        for (var i=0;i<a_obj.length;i++)
        {
            a_obj[i].parentNode.parentNode.className='on'
            a_obj[i].checked=true 
        }
    }else{
        var a_obj=document.getElementsByTagName('input')
        for (var i=0;i<a_obj.length;i++)
        {
            a_obj[i].parentNode.parentNode.className='off'
            a_obj[i].checked=false 
        }
 
    }

}
function goTo(s_url){
    var o_ifram=parent.document.getElementsByTagName('frame')[1]
    try{
    o_ifram.src=s_url
    parent.parent.Common_OpenLoading()
    } catch(e)
    {}
    
}
function goUp(s_id){
    
    try{
       parent.document.getElementsByTagName('frame')[0].contentWindow.refreshPath(s_id) 
     } catch(e)
    {}  
    parent.parent.Common_OpenLoading()
    location='explorer.php?folderid='+s_id; 
}
function goUp_Share(s_id,s_type){
    
    try{
        parent.document.getElementsByTagName('frame')[0].contentWindow.refreshPathShare(s_id) 
     } catch(e)
    {}
      
    location='explorer_share.php?'+s_type+'='+s_id; 
}
function goUpDirectory(s_id){
    
    try{
        parent.document.getElementsByTagName('frame')[0].contentWindow.refreshPathDirectory(s_id) 
     } catch(e)
    {}
      
    location='directory_explorer.php?folderid='+s_id; 
}
function goIn(s_parent,s_id){
    try{
        parent.parent.document.getElementsByTagName('frame')[0].contentWindow.refreshPath(s_parent) 
        var o_ifram=parent.parent.document.getElementsByTagName('frame')[1]
        parent.parent.parent.Common_OpenLoading()
        o_ifram.src='explorer.php?folderid='+s_id; 
        
    } catch(e)
    {
    
    }
    
}
function goInShare(s_parent,s_id){
    try{
        parent.parent.document.getElementsByTagName('frame')[0].contentWindow.refreshPathShare(s_parent) 
  } catch(e)
    {
    
    }   
    try{
        var o_ifram=parent.parent.document.getElementsByTagName('frame')[1]
        parent.parent.parent.Common_OpenLoading() 
        o_ifram.src='explorer_share.php?folderid='+s_id;
    } catch(e)
    {

    
    }
    
}
function goInDirectory(s_parent,s_id){
    try{
        parent.parent.document.getElementsByTagName('frame')[0].contentWindow.refreshPathShare(s_parent) 
  } catch(e)
    {
    
    }   
    try{
        var o_ifram=parent.parent.document.getElementsByTagName('frame')[1]
        parent.parent.parent.Common_OpenLoading() 
        o_ifram.src='directory_explorer.php?folderid='+s_id;
    } catch(e)
    {

    
    }
    
}