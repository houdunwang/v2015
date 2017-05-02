define('route', ['angular'], function (angular) {
    var module = angular.module('app');
    module.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {             //设置默认访问路由 
        $urlRouterProvider.otherwise("/home");
        $stateProvider.state('home', {
                url: "/home",
                templateUrl: 'view/home.html'
            })
            .state('show', {
                url: "/show/{id}",
                templateUrl: 'view/show.html'
            });
    }]);
});
define('allControllers', ['homeController'], function () {
});
define('homeController', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('controllers');
    module.controller('homeController', ['$scope', function ($scope) {
        $scope.title='abc';
    }]);
});
define('allServers', ['goodsServers', 'shopServers','cartServers'], function () {
});
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
define('shopServers', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('servers');
    module.factory('shop', ['$http', function ($http) {
        return {
            all: function () {

            }
        };
    }])
});
define('allDirectives', ['listsDirective', 'coverDirective','cartDirective','showDirective'], function () {
});
define('cartDirective', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('directives');
    module.directive('hdCart', ['cart', function (cart) {
        return {
            restrict: 'A',
            replace: true,
            scope: {title: '@title'},
            templateUrl: 'src/templates/hd-cart.html',
            controller: ['$scope', 'cart', function ($scope, cart) {
                $scope.cartServer = cart;
            }]
        };
    }])
});

define('coverDirective', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('directives');
    module.directive('hdCover', [function () {
        return {
            restrict: 'A',
            replace: true,
            templateUrl: 'src/templates/hd-cover.html',
            controller: ['$scope', function ($scope) {
            }]
        };
    }])
});

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

define('showDirective', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('directives');
    module.directive('hdShow', [function () {
        return {
            restrict: 'A',
            replace: true,
            templateUrl: 'src/templates/hd-show.html',
            controller: ['$scope', 'goods', 'cart', '$stateParams', function ($scope, goods, cart, $stateParams) {
                $scope.cartServer = cart;
                console.log($stateParams.id);
            }]
        };
    }])
});
