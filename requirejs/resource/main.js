require.config({
    baseUrl: '../resource/app',
    paths: {
        'hd': 'hd',
        'css': '../lib/css.min',
        'jquery': '../lib/jquery.min',
        'angular': '../lib/angular.min',
        'bootstrap': '../lib/bootstrap.min',
    },
    shim: {
        'hd': {
            // exports: 'modal',
            init: function () {
                return {
                    modal: modal,
                    success: success,
                }
            }
        },
        //houdunren.com
        'bootstrap': {
            'deps': ['jquery', 'css!../css/bootstrap.min.css', 'css!../css/font-awesome.min.css']
        }
    }
});
// require(['jquery', 'angular'], function ($, angular) {
//     $('body').css({'backgroundColor': 'red'});
// })