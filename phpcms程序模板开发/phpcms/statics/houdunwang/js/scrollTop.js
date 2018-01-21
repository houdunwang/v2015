/* Design by jason.leung, QQ,147430218, 鏂版氮寰崥,@鍒囩墖闈㈠寘, 濡傛灉鎮ㄦ湁浠讳綍闂锛屽彲浠ヨ嚦鎴戠殑鐣欒█鏉跨暀瑷€锛佽阿璋紒http://shlzh1984.gicp.net */
/* 閰风珯浠ｇ爜鏁寸悊 杞浇璇锋敞鏄庡嚭澶� http://www.5icool.org */
function myEvent(obj,ev,fn){
    if(obj.attachEvent){
        obj.attachEvent('on'+ev,fn);
    }else{
        obj.addEventListener(ev,fn,false);
    }
}
myEvent(window,'load',function(){
    var oRTT=document.getElementById('rtt');
    var pH=document.documentElement.clientHeight;
    var timer=null;
    var scrollTop;
    window.onscroll=function(){
        scrollTop=document.documentElement.scrollTop||document.body.scrollTop;
        if(scrollTop>=pH){
            oRTT.style.display='block';
        }else{
            oRTT.style.display='none';
        }
        return scrollTop;
    };
    oRTT.onclick=function(){
        clearInterval(timer);
        timer=setInterval(function(){
            var now=scrollTop;
            var speed=(0-now)/10;
            speed=speed>0?Math.ceil(speed):Math.floor(speed);
            if(scrollTop==0){
                clearInterval(timer);
            }
            document.documentElement.scrollTop=scrollTop+speed;
            document.body.scrollTop=scrollTop+speed;
        }, 30);
    }
});