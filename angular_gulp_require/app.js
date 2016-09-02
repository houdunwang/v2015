define(['angular'], function (angular) {
    var init = function () {
        var controllers = angular.module('controllers', []);
        var app = angular.module('app', ['controllers']);
        require([
            'allControllers',
        ], function () {
            angular.element(document).ready(function () {
                angular.bootstrap(document, ["app"]);
            });
        });
    }
    return {init: init};
});