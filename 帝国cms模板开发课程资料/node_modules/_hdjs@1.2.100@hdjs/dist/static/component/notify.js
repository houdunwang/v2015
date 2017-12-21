//消息通知
define([
    'bootstrap',
    'dist/static/package/bootstrap-notify/bootstrap-notify'
], function ($) {
    return function (options, settings) {
        return $.notify(options, settings);
    }
})