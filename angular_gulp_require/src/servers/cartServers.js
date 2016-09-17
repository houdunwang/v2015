define('cartServers', ['angular', 'jquery', 'underscore'], function (angular, $, _) {
    var module = angular.module('servers');
    module.factory('cart', ['$http', function ($http) {
        return {
            //购物车商品
            goods: [],
            //添加购物车
            add: function (g) {
                var index = _.findIndex(this.goods, g);
                if (index == -1) {
                    g.total = 0;
                    this.goods.push(g);
                } else {
                    this.goods[index].total += 1;
                }
            },
            del: function (g) {
                var index = _.findIndex(this.goods, g);
                if (index >= 0) {
                    this.goods[index].total--;
                    if (this.goods['index'] == 0) {
                        this.goods = _.without(this.goods, g);
                    }
                }
            },
            //获取购物车所有商品
            get: function () {
                return this.goods;
            },
            //获取商品在购物车中的数量
            getGoodsTotal: function (g) {
                var index = _.findIndex(this.goods, g);
                if (index >= 0) {
                    return this.goods[index].total;
                }
            }
        };
    }])
});