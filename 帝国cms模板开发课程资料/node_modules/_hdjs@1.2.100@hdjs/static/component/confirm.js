define(['bootstrap', 'dist/static/component/modal'], function ($, Modal) {
    return function (content, callback, options) {
        var content =
            '			<i class="pull-left fa fa-4x fa-info-circle"></i>' +
            '			<div class="pull-left"><p>' + content + '</p>' +
            '			</div>' +
            '			<div class="clearfix"></div>';
        var modalobj = Modal($.extend({
            title: '系统提示',
            content: content,
            footer: '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>' +
            '<button type="button" class="btn btn-primary confirm">确定</button>',
            events: {
                confirm: function () {
                    if ($.isFunction(callback)) {
                        modalobj.modal('hide');
                        callback();
                    }
                }
            }
        }, options));
        modalobj.find('.modal-content').addClass('alert alert-info');
        return modalobj;
    }
})