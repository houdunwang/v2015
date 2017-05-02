//angularJs
define(['angular','uiRouter'], function (angular) {
    angular.module('app', ['ui.router']);
    //dom 解析后执行
    require(['allControllers','allDirectives','allServers','route'], function () {
        angular.element(document).ready(function () {
            angular.bootstrap(document, ['app']);
        })
    })
})