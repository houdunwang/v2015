define(['angular', 'uiRoute'], function (angular) {
    var init = function () {
        var controllers = angular.module('controllers', []);
        var directives = angular.module('directives', []);
        var servers = angular.module('servers', []);
        var app = angular.module('app', ['ui.router', 'controllers', 'directives', 'servers']);
        require([
            'allControllers',
            'allDirectives',
            'allServers',
            'route'
        ], function () {
            angular.element(document).ready(function () {
                angular.bootstrap(document, ["app"]);
            });
        });
    }
    return {init: init};
});