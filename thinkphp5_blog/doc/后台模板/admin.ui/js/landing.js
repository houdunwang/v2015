jQuery.extend( jQuery.easing,
{
    def: 'easeOutQuad',
    easeInOutExpo: function (x, t, b, c, d) {
        if (t==0) return b;
        if (t==d) return b+c;
        if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
        return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
    }
});

!function ($) {

  $(function(){

    $('[data-ride="animated"]').appear();
    if( !$('html').hasClass('ie no-ie10') ) {
        $('[data-ride="animated"]').addClass('appear');
    	$('[data-ride="animated"]').on('appear', function() {
	        var $el = $(this), $ani = ($el.data('animation') || 'fadeIn'), $delay;
	        if ( !$el.hasClass('animated') ) {
	        	$delay = $el.data('delay') || 0;
                setTimeout(function(){
                    $el.removeClass('appear').addClass( $ani + " animated" );
                }, $delay);
	        }
	    });
    };
    
    $(document).on('click.app','[href^="#"]',function (e) {
        e.preventDefault();
        var $target = this.hash;
        if(!$(this).data('jump')) return;
        $('html, body').stop().animate({
            'scrollTop': $($target).offset().top
        }, 1000, 'easeInOutExpo', function () {
            window.location.hash = $target;
        });
    });
    
  });
}(window.jQuery);