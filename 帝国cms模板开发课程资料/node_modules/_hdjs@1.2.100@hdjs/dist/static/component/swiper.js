define([
    'https://cdn.bootcss.com/Swiper/4.0.6/js/swiper.js',
    'css!https://cdn.bootcss.com/Swiper/4.0.6/css/swiper.min.css'
], function (Swiper) {
    return function (el, options) {
        new Swiper(el, options);
    }
})