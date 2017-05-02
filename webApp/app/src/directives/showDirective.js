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
