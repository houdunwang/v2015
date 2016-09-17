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