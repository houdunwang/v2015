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
