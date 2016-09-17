define('cartController', ['angular', 'jquery', 'underscore'], function (angular, $, _) {
    var module = angular.module('controllers');
    module.controller('cartController', ['$scope', 'goods', 'cart', function ($scope, goods, cart) {
        $scope.add = function (goods) {
            cart.add(goods);
        }

        $scope.get = function () {

        }
        //获取商品数量
        $scope.getGoodsNum = function () {
            var total = 0;
            var goods = cart.get();
            if (goods) {
                angular.forEach(goods, function (v, k) {
                    total += v.total;
                })
            }
            return total;
        }
        //获取总价
        $scope.getTotalPrice = function () {
            var price = 0;
            angular.forEach(cart.get(), function (v, k) {
                price += v.price * v.total;
            });
            return price;
        }
    }]);
});