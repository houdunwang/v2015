define('route', ['angular', 'ngRoute'], function (angular) {
    var module = angular.module('route', ['ngRoute']);
    module.config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/home', {templateUrl: 'view/home.html'})
            .when('/my', {templateUrl: 'view/my.html'})
            .otherwise('/home',{templateUrl: 'view/home.html'});
    }]);
});