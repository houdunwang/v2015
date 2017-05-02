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