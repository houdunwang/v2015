/**
 * 前端模块配置
 * @author 向军 <2300071698@qq.com>
 */
require.config({
    baseUrl: './src',
    paths: {
        'app': '../app',
        'css': '../lib/js/css.min',
        'jquery': '../lib/js/jquery.min',
        'angular': '../lib/js/angular.min',
        'underscore': '../lib/js/underscore-min',
        'abc': '../abc',
        'uiRoute': '../lib/js/angular-ui-router.min'
    },
    shim: {
        'angular': {
            exports: 'angular',
            deps: ['jquery']
        },
        'uiRoute': {
            exports: 'uiRoute',
            deps: ['angular']
        },
        'app': {
            exports: 'app',
            deps: ['jquery', 'css!../build/main.css','css!../lib/font/css/font-awesome.min.css']
        }
    }
});
require(['app', './build/main.js','angular'], function (app) {
    app.init();
})












