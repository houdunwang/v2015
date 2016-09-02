define('videoController', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('controllers');
    module.controller('videoController', ['$scope', function ($scope) {
        $scope.name = 'abc';
    }]);
});