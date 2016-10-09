define('homeController', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('controllers');
    module.controller('homeController', ['$scope', function ($scope) {
        $scope.title='abc';
    }]);
});