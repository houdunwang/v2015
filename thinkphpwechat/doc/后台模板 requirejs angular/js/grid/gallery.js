$(function () {
    // Load images via flickr for demonstration purposes:
    $.ajax({
        url: 'http://api.flickr.com/services/rest/',
        data: {
            format: 'json',
            method: 'flickr.interestingness.getList',
            api_key: 'f77cf83fcba4290ba3b0c54b36af5f3b',
            tags: 'natual',
            extras: 'description, date_taken',
            per_page: 50
        },
        dataType: 'jsonp',
        jsonp: 'jsoncallback'
    }).done(function (data) {
        
        var gallery = $('#gallery')
            , gl = $('#galleryLoading')
            , str
            , url;
        gl.removeClass('fadeInRightBig').addClass('fadeOutLeftBig');
        _.delay(function(){
            gl.hide();
        }, 1000);
        gallery.removeClass('hide').addClass('animated fadeInUpBig');
        $.each(data.photos.photo, function (index, photo) {
            url = 'http://farm' + photo.farm + '.static.flickr.com/' +
                photo.server + '/' + photo.id + '_' + photo.secret;

            str ='<div class="item">'+
                    '<img src="'+url+'_z.jpg">'+
                    '<a href="'+ url +'_c.jpg" rel="prettyPhoto[gallery]"></a>'+
                    '<div class="desc">'+
                        '<h4>'+photo.title+'</h4>'+
                        '<p>'+ photo.description._content +'</p>'+
                        '<span>'+ photo.datetaken +'</span>'+
                    '</div>'+
                  '</div>';

            $(str).appendTo(gallery);
        });

        buildGallery();
    });
    
    var buildGallery = function(){
        $("#gallery").removeClass('hide');
        $('a[rel^="prettyPhoto"]').prettyPhoto({slideshow:5000, autoplay_slideshow:false});

        $("#gallery").gridalicious({
          animate: true,
          gutter: 1,
          width: 250
        });
    }

    // if you use the local image just need call 
    // buildGallery();
});