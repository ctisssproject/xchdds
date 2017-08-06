    var a_div=document.getElementById('photo')
    a_div=a_div.getElementsByTagName('div')    
    var N_Count=a_div.length
    var N_Number=1
    if (N_Count==0)
    {
        N_Number=0
    }
    var B_Press=false
    $('.count').html(N_Number+' / '+N_Count)
    $('#photo1').show()
    $('#text1').show()
    for(var i=1;i<=N_Count;i++)
    {

        eval('$.extend({photo'+i+'_out:function(){$("#photo'+i+'").fadeOut()}});')
        eval('$.extend({photo'+i+'_in:function(){$("#photo'+i+'").fadeIn()}});')
        eval('$.extend({text'+i+'_out:function(){$("#text'+i+'").fadeOut()}});')
        eval('$.extend({text'+i+'_in:function(){$("#text'+i+'").fadeIn()}});')
    }
    function next()
    {
        if(B_Press)
        {
            return
        }
        B_Press=true
        eval('$.photo'+N_Number+'_out();')
        eval('$.text'+N_Number+'_out();')
        N_Number=N_Number+1
        if(N_Number>N_Count)
        {
            N_Number=1
        }
        $('.count').html(N_Number+' / '+N_Count)
        setTimeout('$.photo'+N_Number+'_in();',500)
        setTimeout('$.text'+N_Number+'_in();',500)
        setTimeout('B_Press=false',1000)
    }
    function prev()
    {
        if(B_Press)
        {
            return
        }
        B_Press=true
        eval('$.photo'+N_Number+'_out();')
        eval('$.text'+N_Number+'_out();')
        N_Number=N_Number-1
        if(N_Number<=0)
        {
            N_Number=N_Count
        }
        $('.count').html(N_Number+' / '+N_Count)
        setTimeout('$.photo'+N_Number+'_in();',500)
        setTimeout('$.text'+N_Number+'_in();',500)
        setTimeout('B_Press=false',1000)
    }
    setInterval(next,5000)