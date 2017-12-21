define(['dist/static/component/fileUploader', 'dist/static/component/util'], function (fileUploader, util) {
    return function (callback, options) {
        //初始化参数数据mes
        options = options ? options : {};
        //初始化POST数据
        options.data = options.data ? options.data : {};
        var opts = $.extend({
            width: util.isMobile() ? '95%' : 700,//宽度
            type: 'image',
            extensions: 'gif,jpg,jpeg,png',
            multiple: false,
            fileSizeLimit: 200 * 1024 * 1024,
            fileSingleSizeLimit: 20 * 1024 * 1024,
            compress: false,
            data: {},
        }, options);
        fileUploader.show(function (images) {
            if (images.length > 0) {
                if ($.isFunction(callback)) {
                    callback(images);
                }
            }
        }, opts);
    }
})
