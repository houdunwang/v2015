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
        'ngRoute': '../lib/js/angular-route.min',
        'underscore': '../lib/js/underscore-min'
    },
    shim: {
        'angular': {
            exports: 'angular',
            deps: ['jquery']
        },
        'app': {
            exports: 'app',
            deps: ['jquery', 'css!../build/main.css']
        }
    }
});
require(['app', './build/main.js'], function (app) {
    app.init();
})












