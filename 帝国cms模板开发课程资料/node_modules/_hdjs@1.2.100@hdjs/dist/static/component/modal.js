define(['dist/static/component/util'], function (util) {
    return function (options, userCallback) {
        var opt = $.extend({
            show: true,//自动显示
            title: '',//标题
            content: '',//内容
            footer: '',//底部
            id: 'hdMessage',//模态框id
            width: util.isMobile() ? '95%' : 600,//宽度
            class: '',//样式
            option: {},//bootstrap模态框选项
            events: {},//事件,参考bootstrap
        }, options);
        var modalObj = $("#" + opt.id);
        if (modalObj.length == 0) {
            $(document.body).append('<div class="modal fade" id="' + opt.id + '"role="dialog" tabindex="-1" role="dialog" aria-hidden="true"></div>');
            modalObj = $("#" + opt.id);
        }
        var html = '<div class="modal-dialog" role="document">' +
            '<div class="modal-content ' + opt.class + '">';
        if (opt.title) {
            html += '<div class="modal-header">'
                + '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
                + '<span aria-hidden="true">&times;</span></button>'
                + '<h4 class="modal-title">' + opt.title + '</h4></div>';
        }
        //模态框内容
        if (opt.content) {
            if (!$.isArray(opt.content)) {
                html += '<div class="modal-body">' + opt.content + '</div>';
            } else {
                html += '<div class="modal-body">正在加载中...</div>';
            }
        }
        if (opt.footer) {
            html += '<div class="modal-footer">' + opt.footer + '</div>';
        }
        html += "</div></div>";
        modalObj.html(html);
        if (opt.width) {
            modalObj.find('.modal-dialog').css({width: opt.width});
        }
        if (opt.content && $.isArray(opt.content)) {
            //将异步加载内容放入模态体中
            var callback = function (d) {
                modalObj.find('.modal-body').html(d);
            }
            if (opt.content.length == 2) {
                $.post(opt.content[0], opt.content[1]).done(callback);
            } else {
                $.get(opt.content[0]).done(callback);
            }
        }
        //绑定模态事件
        $(opt.events).each(function (i) {
            for (name in opt.events) {
                if (typeof opt.events[name] == 'function') {
                    modalObj.on(name, opt.events[name]);
                }
            }
        });
        //点击确定按钮事件
        if (typeof opt.events['confirm'] == 'function') {
            modalObj.find('.confirm', modalObj).on('click', function () {
                options.events['confirm'](modalObj);
                //隐藏模态框
                modalObj.modal('hide');
            });
        }
        //关闭模态框时删除他
        modalObj.on('hidden.bs.modal', function () {
            modalObj.remove();
        });
        /**
         * 有确定按钮时添加事件
         * 当点击确定时删除模态框
         */
        modalObj.on('hidden.bs.modal', function () {
            modalObj.remove();
        });
        //点击取消按钮事件
        if (typeof opt.events['cancel'] == 'function') {
            modalObj.find('.cancel', modalObj).on('click', function () {
                options.events['cancel'](modalObj);
            });
        }
        if ($.isFunction(userCallback)) {
            return userCallback(modalObj);
        }
        modalObj.modal(opt);
        return modalObj;
    }
})