//提交表单
define([
    'dist/static/component/message',
    'hdjs',
    'https://cdn.bootcss.com/axios/0.17.1/axios.min.js',
    'lodash'
], function (Message, hdjs, axios) {
    return function (opt) {
        var options = $.extend({
            type: 'post',
            url: window.system ? window.system.url : '',
            data: {},
            successUrl: 'back',
            callback: '',
        }, opt);
        var loadingModal = hdjs.loading();
        var ax;
        switch (options.type) {
            case 'get':
                ax = axios.get(options.url, {params: options.data})
                break;
            case 'post':
                ax = axios.post(options.url, options.data)
                break;
        }
        ax.then(function (response) {
            loadingModal.modal('hide');
            if (_.isObject(response.data)) {
                if ($.isFunction(options.callback)) {
                    options.callback(response.data);
                } else {
                    if (response.data.valid == 1) {
                        Message(response.data.message, options.successUrl, 'success');
                    } else {
                        Message(response.data.message, '', 'info');
                    }
                }
            } else {
                Message(response.data, '', 'error');
            }
        }).catch(function (response) {
            loadingModal.modal('hide');
            Message(response, '', 'error');
        });
        return false;
    }
})
