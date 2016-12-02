//requireJs
require.config({
    //基础目录
    baseUrl:'src',
    paths: {
        'jquery': '../bower_components/jquery/dist/jquery.min',
        'bootstrap': '../bower_components/bootstrap/dist/js/bootstrap.min',
        'angular': '../bower_components/angular/angular.min',
        'uiRouter': '../bower_components/angular-ui-router/release/angular-ui-router.min',
        'css': '../bower_components/require-css/css.min',
        'app': '../app'
    },
    shim: {
        'angular': {
            exports: 'angular',
            deps: ['jquery']
        },
        'uiRouter': {
            exports: 'uiRouter',
            deps: ['angular']
        },
        'bootstrap': {
            exports: '$',
            deps: ['jquery', 'css!bower_components/bootstrap/dist/css/bootstrap.min.css']
        },
        'app': {
            exports: 'app',
            deps: ['bootstrap','angular','uiRouter','../dist/main']
        }
    }
});
require(['app','directives/home']);