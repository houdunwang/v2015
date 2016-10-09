define('cartServers', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('servers');
    module.factory('cart', ['$http', function ($http) {
        return {
            //购物车中的商品
            goods:[],
            //总价
            totalPrice: 0,
            //总数
            total: 0,
            //加入购物车
            add: function (g) {
                g.num = 1;
                this.goods.push(g);
                this.setTotalPrice();
                this.setTotal();
            },
            //设置总价
            setTotalPrice: function () {
                var total = 0;
                for (var i = 0; i < this.goods.length; i++) {
                    total += (this.goods[i].price * this.goods[i].num);
                }
                this.totalPrice = total;
            },
            //设置总数
            setTotal: function () {
                var total = 0;
                for (var i = 0; i < this.goods.length; i++) {
                    total += this.goods[i].num;
                }
                this.total = total;
            }
        };
    }])
});