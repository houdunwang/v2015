//生成二维码
define([
    'bootstrap',
    'https://cdn.bootcss.com/jquery.qrcode/1.0/jquery.qrcode.min.js'
], function ($) {
    return function (el, text) {
        return $(el).qrcode(text);
        var canvas = $(el)[0];
        QRCode.toCanvas(canvas, text, function (error) {
            if (error) console.error(error)
        })
    }
})
