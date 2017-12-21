window._ = require('lodash');
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
try {
    global.$ = global.jQuery = window.$ = window.jQuery = require('jquery');
    require('bootstrap-sass');
    require("bootstrap-sass/assets/stylesheets/_bootstrap.scss");
    require('./less/app.less');
    console.info('后盾人 人人做后盾  www.houdunren.com');
    //将属性hdjs元素显示出来
    $("[hd-cloak]").show();
    $("[hd-hide]").hide();
    $("[hd-loading]").hide();
} catch (e) {
}
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    //为异步请求设置CSRF令牌
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
} else {
    // console.error('CSRF token not found');
}