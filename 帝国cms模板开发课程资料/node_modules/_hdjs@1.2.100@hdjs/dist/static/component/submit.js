//提交表单
define([
    'dist/static/component/message',
    'hdjs',
    'https://cdn.bootcss.com/axios/0.17.1/axios.min.js',
    'lodash'
], function (Message, hdjs, axios) {
    return function (opt) {
        var options = $.extend({
            el: 'form',
            url: window.system ? window.system.url : '',
            data: '',
            successUrl: 'back',
            callback: '',
        }, opt);
        var data = options.data == '' ? $(options.el).serialize() : options.data;
        $('[type="submit"]').attr('disabled', 'disabled');
        var loadingModal = hdjs.loading();
        axios.post(options.url, data).then(function (response) {
            loadingModal.modal('hide');
            $('[type="submit"]').removeAttr('disabled');
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
