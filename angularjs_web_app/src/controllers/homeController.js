define('homeController', ['angular'], function (angular) {
    var module = angular.module('app');
    module.controller('homeController', ['$scope', function ($scope) {
        $scope.title = '后盾人';
    }]);
});