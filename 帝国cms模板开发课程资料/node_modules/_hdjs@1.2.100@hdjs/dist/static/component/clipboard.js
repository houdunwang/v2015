//剪贴板
define(['https://cdn.bootcss.com/clipboard.js/1.7.1/clipboard.min.js'], function (Clipboard) {
    return function (elem, options,callback) {
        var clipboard = new Clipboard(elem);
        clipboard.on('success', callback);
    }
})