//消息提示
import Modal from './modal'
import 'font-awesome/css/font-awesome.css'

/**
 * 消息处理
 * @param msg 内容
 * @param redirect
 * @param type
 * @param timeout
 * @param options
 */
export default (msg, redirect, type, timeout, options) => {
    if ($.isArray(msg)) {
        msg = msg.join('<br/>');
    }
    timeout = timeout ? timeout : 2;
    if (!redirect && !type) {
        type = 'info';
    }
    if ($.inArray(type, ['success', 'error', 'info', 'warning']) == -1) {
        type = '';
    }
    if (type == '') {
        type = redirect == '' ? 'error' : 'success';
    }
    var icons = {
        success: 'check-circle',
        error: 'times-circle',
        info: 'info-circle',
        warning: 'exclamation-triangle'
    };
    var fa = '';
    switch (type) {
        case 'success':
            fa = 'fa-check-circle';
            break;
        case 'warning':
            fa = 'fa-warning';
            break;
        case 'error':
            fa = 'fa-times-circle';
            break;
        case 'info':
            fa = 'fa-info-circle';
            break;
    }
    var h = '';
    if (redirect && redirect.length > 0) {
        if (redirect == 'back') {
            h = '<p>' +
                '<a href="javascript:;" onclick="history.go(-1)">' +
                '如果你的浏览器在 <span id="timeout">' +
                timeout + '</span> 秒后没有自动跳转，请点击此链接</a></p>';
            redirect = document.referrer ? document.referrer : location.href;
        } else if (redirect == 'refresh') {
            redirect = location.href;
            h = '<p><a href="' + redirect + '" target="main" data-dismiss="modal" aria-hidden="true">系统将在 <span id="timeout"></span> 秒后刷新页面</a></p>';
        } else {
            h = '<p><a href="' + redirect + '" target="main" data-dismiss="modal" aria-hidden="true">如果你的浏览器在 <span id="timeout">' + timeout + '</span> 秒后没有自动跳转，请点击此链接</a></p>';
        }
    }
    var content =
        '			<i class="pull-left fa fa-4x fa-' + icons[type] + '"></i>' +
        '			<div class="pull-left"><p>' + msg + '</p>' + h +
        '			</div>' +
        '			<div class="clearfix"></div>';
    var footer =
        '			<button type="button" class="btn btn-default" data-dismiss="modal">确认</button>';

    var modalobj = Modal($.extend({
        title: '系统提示',
        content: content,
        footer: footer,
        id: 'modalMessage'
    }, options));
    modalobj.find('.modal-content').addClass('alert alert-' + type);

    if (redirect) {
        var timer = '';
        modalobj.find("#timeout").html(timeout);
        modalobj.on('show.bs.modal', function () {
            doredirect();
        });
        modalobj.on('hide.bs.modal', function () {
            timeout = 0;
            doredirect();
        });
        modalobj.on('hidden.bs.modal', function () {
            modalobj.remove();
        });

        function doredirect() {
            timer = setTimeout(function () {
                if (timeout <= 0) {
                    modalobj.modal('hide');
                    clearTimeout(timer);
                    window.location.href = redirect;
                    return;
                } else {
                    timeout--;
                    modalobj.find("#timeout").html(timeout);
                    doredirect();
                }
            }, timeout * 1000);
        }
    }
    modalobj.modal('show');
    return modalobj;
}