define('coverDirective', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('directives');
    module.directive('hdCover', [function () {
        return {
            restrict: 'A',
            replace: true,
            templateUrl: 'src/templates/hd-cover.html',
            controller: ['$scope', function ($scope) {
            }]
        };
    }])
});
