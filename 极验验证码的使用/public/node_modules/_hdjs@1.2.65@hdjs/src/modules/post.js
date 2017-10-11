export default (opt) => {
    var options = $.extend({
        url: '',
        data: {},
        success: function () {
        },
        error: function () {
        }
    }, opt);
    $.post(options.url, options.data, function (json) {
        if ($.isFunction(options.callback)) {
            options.callback(json);
        }
    }, 'json')
}