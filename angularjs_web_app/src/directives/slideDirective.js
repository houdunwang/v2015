define('slideDirective', ['angular'], function (angular) {
    var m = angular.module('app');
    m.directive('hdSlide', [function () {
        return {
            restrict: 'AE',
            templateUrl: 'src/templates/hdSlide.html',
            controller:['$scope','news',function($scope,news){

            }]
        };
    }]);
});