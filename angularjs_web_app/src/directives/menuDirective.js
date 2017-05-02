define('menuDirective', ['angular'], function (angular) {
    var m = angular.module('app');
    m.directive('hdMenu', [function () {
        return {
            restrict: 'AE',
            scope:{},
            templateUrl: 'src/templates/hdMenu.html',
            controller: ['$scope', 'news', function ($scope, news) {
                news.category().then(function(response){
                    $scope.data = response.data;
                })
            }]
        };
    }]);
});