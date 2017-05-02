define('goodsServers', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('servers');
    module.factory('goods', ['$http', function ($http) {
        return {
            all: function () {
                return $http({method:'GET',url:'http://localhost/a/admin/index.php?s=api/goods/all'});
            }
        };
    }])
});