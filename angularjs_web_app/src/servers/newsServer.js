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