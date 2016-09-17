define(['angular'], function (angular) {
    var init = function () {
        var controllers = angular.module('controllers', []);
        var directives = angular.module('directives', []);
        var servers = angular.module('servers', []);
        var route = angular.module('route', []);
        var app = angular.module('app', ['controllers', 'directives', 'servers', 'route']);
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