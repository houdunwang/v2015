//cookie操作
define(['https://cdn.bootcss.com/js-cookie/latest/js.cookie.min.js'], function (Cookie) {
    return function (callback) {
        callback(Cookie);
    }
})