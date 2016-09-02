define('lessonController', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('controllers');
    module.controller('lessonController', ['$scope', function ($scope) {
        $scope.name = 'houdunwang';
    }]);
});