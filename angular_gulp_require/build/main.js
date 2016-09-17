define('allControllers', ['goodsController','cartController'], function () {});
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
define('allDirectives', ['footerCartDirective','coverDirective','dishDirective','goodsDirective','orderDirective'], function () {});
define('coverDirective', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('directives');
    module.directive('hdCover', [function () {
        return {
            restrict: 'A',
            replace: true,
            scope: {data: '=data'},
            templateUrl: 'src/templates/cover.html',
            //link: function (scope, ele, attr) {
            //    scope.data=[
            //        {title:'abc'},
            //        {title:'eee'},
            //    ];
            //}
        };
    }])
});
define('dishDirective', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('directives');
    module.directive('hdDish', [function () {
        return {
            restrict: 'A',
            replace: true,
            scope: {data: '=data'},
            templateUrl: 'src/templates/hd-dish.html',
            //link: function (scope, ele, attr) {
            //    scope.data=[
            //        {title:'abc'},
            //        {title:'eee'},
            //    ];
            //}
        };
    }])
});
define('footerCartDirective', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('directives');
    module.directive('hdFooterCart', [function () {
        return {
            restrict: 'A',
            replace: true,
            scope: {title: '@'},
            templateUrl: 'src/templates/hd-footer-cart.html',
            link: function (scope, ele, attr) {
                scope.title='去结算'
            }
        };
    }])
});
define('goodsDirective', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('directives');
    module.directive('hdGoods', [function () {
        return {
            restrict: 'A',
            replace: true,
            scope: {data: '=data'},
            templateUrl: 'src/templates/hd-goods.html',
            //link: function (scope, ele, attr) {
            //    scope.data=[
            //        {title:'abc'},
            //        {title:'eee'},
            //    ];
            //}
        };
    }])
});
define('orderDirective', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('directives');
    module.directive('hdOrder', [function () {
        return {
            restrict: 'A',
            replace: true,
            scope: {data: '=data'},
            templateUrl: 'src/templates/hd-order.html',
            //link: function (scope, ele, attr) {
            //    scope.data=[
            //        {title:'abc'},
            //        {title:'eee'},
            //    ];
            //}
        };
    }])
});
define('allServers', ['goodsServers','cartServers'], function () {
});
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
define('route', ['angular', 'ngRoute'], function (angular) {
    var module = angular.module('route', ['ngRoute']);
    module.config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/home', {templateUrl: 'view/home.html'})
            .when('/my', {templateUrl: 'view/my.html'})
            .otherwise('/home',{templateUrl: 'view/home.html'});
    }]);
});