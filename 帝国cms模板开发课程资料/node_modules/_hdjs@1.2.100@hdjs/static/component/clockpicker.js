//时间选择
define([
    'jquery',
    'dist/static/package/clockpicker/bootstrap-clockpicker.min',
    'css!dist/static/package/clockpicker/bootstrap-clockpicker.min.css'
], function ($) {
    return function (el, options) {
        return $(el).clockpicker(options);
    }
})