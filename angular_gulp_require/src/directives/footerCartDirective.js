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