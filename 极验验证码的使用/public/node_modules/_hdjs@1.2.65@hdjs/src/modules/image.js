import fileUploader from './fileUploader'

export default (callback, options) => {
    //初始化参数数据mes
    options = options ? options : {};
    //初始化POST数据
    options.data = options.data ? options.data : {};
    var opts = Object.assign({
        width: 700,
        type: 'image',
        extensions: 'gif,jpg,jpeg,png',
        multiple: false,
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