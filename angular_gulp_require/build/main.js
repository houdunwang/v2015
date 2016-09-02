define('allControllers', ['lessonController', 'videoController'], function () {
});
define('lessonController', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('controllers');
    module.controller('lessonController', ['$scope', function ($scope) {
        $scope.name = 'houdunwang';
    }]);
});
define('videoController', ['angular', 'jquery'], function (angular, $) {
    var module = angular.module('controllers');
    module.controller('videoController', ['$scope', function ($scope) {
        $scope.name = 'abc';
    }]);
});
//require(['angular', 'jquery'], function (angular, $) {
//    var module = angular.module('directives');
//});