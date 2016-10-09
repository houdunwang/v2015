define('shopServers', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('servers');
    module.factory('shop', ['$http', function ($http) {
        return {
            all: function () {

            }
        };
    }])
});