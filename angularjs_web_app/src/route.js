define('route', ['angular'], function (angular) {
    var m = angular.module('app');
    m.config(['$stateProvider','$urlRouterProvider',function ($stateProvider,$urlRouterProvider) {
        $urlRouterProvider.otherwise('home');
        $stateProvider.state('home',{
            url:'/home?{cid?}',
            templateUrl:'src/view/home.html'
        })
            .state('article',{
            url:'/article?{aid}',
            templateUrl:'src/view/article.html'
        })
    }])
});