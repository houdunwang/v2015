define('route', ['angular'], function (angular) {
    var m = angular.module('app');
    m.config(['$stateProvider','$urlRouterProvider',function ($stateProvider,$urlRouterProvider) {
        $urlRouterProvider.otherwise('home');
        $stateProvider.state('home',{
            url:'/home?{cid?}',
            templateUrl:'src/view/home.html'
        })
            .state('article',{
            url:'/article?{aid}',
            templateUrl:'src/view/article.html'
        })
    }])
});
define('allControllers',['homeController']);
define('homeController', ['angular'], function (angular) {
    var module = angular.module('app');
    module.controller('homeController', ['$scope', function ($scope) {
        $scope.title = '后盾人';
    }]);
});
define('allDirectives',['newsDirective','menuDirective','slideDirective','articleDirective']);
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
define('slideDirective', ['angular'], function (angular) {
    var m = angular.module('app');
    m.directive('hdSlide', [function () {
        return {
            restrict: 'AE',
            templateUrl: 'src/templates/hdSlide.html',
            controller:['$scope','news',function($scope,news){

            }]
        };
    }]);
});
define('allServers',['newsServer']);
define('newsServer', ['angular'], function (angular) {
    var m = angular.module('app');
    m.factory('news', ['$http', function ($http) {
        return {
            category:function(){
                return $http({method:'get',url:'http://localhost/video/angularjs_web_app/admin/category.php'})
            },
            article:function(cid){
                cid =  cid?cid:1;
                return $http({method:'get',url:'http://localhost/video/angularjs_web_app/admin/article.php?cid='+cid})
            },
            get:function(aid){
                return $http({method:'get',url:'http://localhost/video/angularjs_web_app/admin/article.php?aid='+aid})
            }
        }
    }]);
})