define('goodsController', ['angular', 'jquery', 'underscore'], function (angular, $, _) {
    var module = angular.module('controllers');
    module.controller('goodsController', ['$scope', 'goods', 'cart', function ($scope, goods, cart) {
        $scope.cartServer = cart;
        //获取菜品列表
        goods.all(function (data) {
            $scope.data = data;
        });
        //商品是否在购物车中
        $scope.inCart = function (g) {
            if (_.findIndex(cart.get(), g) > 0) {
                return cart.getGoodsTotal(g);
            }
        }
    }]);
});