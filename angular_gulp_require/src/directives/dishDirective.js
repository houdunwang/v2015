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