define('articleDirective', ['angular'], function (angular) {
    var m = angular.module('app');
    m.directive('hdArticle', [function () {
        return {
            restrict: 'AE',
            templateUrl: 'src/templates/hdArticle.html',
            controller: ['$scope', 'news', '$stateParams', function ($scope, news, $stateParams) {
                news.get($stateParams.aid).then(function (response) {
                    $scope.field = response.data;
                })
            }]
        };
    }]);
});