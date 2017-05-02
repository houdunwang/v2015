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