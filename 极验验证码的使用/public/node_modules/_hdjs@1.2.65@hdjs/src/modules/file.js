import fileUploader from './fileUploader'
export default (callback, options) => {
    //初始化参数数据
    options = options ? options : {};
    //初始化POST数据
    options.data = options.data ? options.data : {};
    var opts = $.extend({
        type: 'file',
        extensions: 'doc,ppt,wps,zip,txt',
        multiple: false,
        fileSizeLimit: 200 * 1024 * 1024,
        fileSingleSizeLimit: 5 * 1024 * 1024,
        data: ''
    }, options);
    fileUploader.show(function (files) {
        if (files) {
            if ($.isFunction(callback)) {
                callback(files);
            }
        }
    }, opts);
}