define('goodsServers', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('servers');
    module.factory('goods', ['$http', function ($http) {
        return {
            all: function (callback) {
                promise = $http({method: 'get', 'url': 'a.php'});
                promise.then(function (res) {
                    callback(res.data);
                });
            }
        };
    }])
});