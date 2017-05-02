define('listsDirective', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('directives');
    module.directive('hdLists', [function () {
        return {
            restrict: 'A',
            replace: true,
            scope: {data: '=cart'},
            templateUrl: 'src/templates/hd-lists.html',
            controller: ['$scope', 'goods','cart', function ($scope, goods,cart) {
                //获取所有商品
                promise = goods.all();
                promise.then(function (res) {
                    $scope.data = res.data;
                });
                $scope.cartServer = cart;
                $scope.abc=33;
            }]
        };
    }])
});
