define('newsDirective', ['angular'], function (angular) {
    var m = angular.module('app');
    m.directive('hdNews', [function () {
        return {
            restrict: 'AE',
            scope:{},
            templateUrl: 'src/templates/hdNews.html',
            controller:['$scope','news','$stateParams',function($scope,news,$stateParams){
                news.article($stateParams.cid).then(function(response){
                    $scope.data = response.data;
                })
            }]
        };
    }]);
});