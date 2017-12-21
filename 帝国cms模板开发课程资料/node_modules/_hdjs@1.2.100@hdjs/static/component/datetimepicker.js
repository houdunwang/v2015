//日期时间选择
define([
    'https://cdn.bootcss.com/jquery-datetimepicker/2.5.14/jquery.datetimepicker.full.js',
    'css!https://cdn.bootcss.com/jquery-datetimepicker/2.5.14/jquery.datetimepicker.min.css',
], function () {
    return function (el, options) {
        jQuery.datetimepicker.setLocale('zh');
        jQuery(el).datetimepicker(options);
    }
})