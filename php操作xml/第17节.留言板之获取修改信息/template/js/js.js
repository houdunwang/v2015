$(function(){
    var inputValue='';//创建存放value的变量
    $(':input').focus(function(){
        inputValue=$(this).val();//记录value值
        this.value='';//清空
        $(this).addClass('inputBorder');
    }).blur(function(){
        //当value为空时，将原有的值赋值回去
        if(this.value==''){
            this.value=inputValue;
        }
        $(this).removeClass('inputBorder');
    });

    //浮动楼层
    showfloat();
    //alert($(window).width());
    //实时获取屏幕宽度变化
    $(window).resize(function(){
        showfloat();
    });

    function showfloat(){
        var winWidth=$(window).width();
        var winHeight=$(window).height();
        //获得新的top值和left值
        var newLeft=(winWidth-634)/2-40;
        var newTop=winHeight*0.8;

        //alert(winWidth);
        //赋值给浮动层
        $('.up').css({'right':newLeft+'px','top':newTop+'px'});
    }
})