$(function(){
    $(".header .right ul.menu li").hover(function() {
        // $(this).find('ul').css({'display': 'block',});
        $(this).find('ul').stop().slideDown();
    }, function() {
        $(this).find('ul').stop().slideUp();
    });
    $(".header .right ul.menu li ul li").hover(function() {
        // $(this).css('border', 'solid 2px white');
        // $(this).css({'border': 'solid 1px white','background': '#06f'});
    }, function() {
        // $(this).css('border', 'solid 1px #06f');
    });

})