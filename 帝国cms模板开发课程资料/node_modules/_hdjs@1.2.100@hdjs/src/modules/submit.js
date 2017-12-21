//提交表单
import Message from './message'
import Loading from './loading'

export default (opt) => {
    var options = $.extend({
        el: 'form',
        url: window.system ? window.system.url : '',
        data: '',
        successUrl: 'back',
        callback: '',
    }, opt);
    var data = options.data == '' ? $(options.el).serialize() : options.data;
    $('[type="submit"]').attr('disabled', 'disabled');
    var loadingModal = Loading();
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