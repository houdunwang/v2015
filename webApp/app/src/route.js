define('route', ['angular'], function (angular) {
    var module = angular.module('app');
    module.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {             //设置默认访问路由 
        $urlRouterProvider.otherwise("/home");
        $stateProvider.state('home', {
                url: "/home",
                templateUrl: 'view/home.html'
            })
            .state('show', {
                url: "/show/{id}",
                templateUrl: 'view/show.html'
            });
    }]);
});