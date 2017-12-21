define([
    'jquery',
    'dist/static/component/modal',
    'bootstrap'
], function ($, modal) {
    return {
        //百度编辑器
        ueditor: function (id, opt, callback, buttons) {
            require(['dist/static/component/ueditor'], function (ueditor) {
                ueditor(id, opt, callback, buttons);
            })
        },
        //Markdown编辑器
        markdown: function (el, options) {
            require(['dist/static/component/editormd'], function (editormd) {
                editormd.markdown(el, options);
            })
        },
        //Markdown编辑器前台转为HTML
        markdownToHTML: function (el, options) {
            require(['dist/static/component/editormd'], function (editormd) {
                editormd.markdownToHTML(el, options);
            })
        },
        //模态框
        modal: function (options, callback) {
            return modal(options, callback);
        },
        //提示消息
        message: function (msg, redirect, type, timeout, options) {
            require(['dist/static/component/message'], function (message) {
                message(msg, redirect, type, timeout, options);
            })
        },
        //确认消息框
        confirm: function (content, callback, options) {
            require(['dist/static/component/confirm'], function (confirm) {
                confirm(content, callback, options);
            })
        },
        //确认消息框
        bootstrapswitch: function (el) {
            require(['dist/static/component/bootstrapswitch'], function (bootstrapswitch) {
                bootstrapswitch(el);
            })
        },
        //确认消息框
        select2: function (el) {
            require(['dist/static/component/select2'], function (select2) {
                select2(el);
            })
        },
        //文件选择框样式
        bootstrapfilestyle: function (el) {
            require(['dist/static/component/bootstrapfilestyle'], function (bootstrapfilestyle) {
                bootstrapfilestyle(el);
            })
        },
        //图片上传
        image: function (callback, options) {
            require(['dist/static/component/image'], function (image) {
                image(callback, options);
            })
        },
        //文件上传
        file: function (callback, options) {
            require(['dist/static/component/file'], function (file) {
                file(callback, options);
            })
        },
        //光标定位
        caret: function (el, pos) {
            require(['https://cdn.bootcss.com/caret/1.0.0/jquery.caret.min.js'], function () {
                if ($.isFunction(pos)) {
                    pos($(el).caret());
                } else {
                    $(el).caret(pos)
                }
            })
        },
        //图表
        chart: function (el, opt) {
            require(['dist/static/component/chart'], function (chart) {
                chart(el, opt);
            })
        },
        //城市选择
        city: function (items, vals) {
            require(['dist/static/component/city'], function (city) {
                city.render(items, vals);
            })
        },
        //剪贴版
        clipboard: function (elem, options, callback) {
            require(['dist/static/component/clipboard'], function (clipboard) {
                clipboard(elem, options, callback);
            })
        },
        //消息通知
        notify: function (options, settings) {
            require(['dist/static/component/notify'], function (notify) {
                notify(options, settings);
            })
        },
        //时间选择
        clockpicker: function (el, options) {
            require(['dist/static/component/clockpicker'], function (clockpicker) {
                clockpicker(el, options);
            })
        },
        //异步提交
        ajax: function (opt) {
            require(['dist/static/component/ajax'], function (ajax) {
                ajax(opt);
            })
        },
        //提交POST
        post: function (opt) {
            require(['dist/static/component/ajax'], function (ajax) {
                ajax(opt)
            })
        },
        //预览图片
        preview: function (url, option) {
            var option = option ? option : {};
            var opt = $.extend({
                title: '图片预览',
                width: 700,
                height: 500,
                content: '<div style="text-align: center">' +
                '<img style="max-width: 100%;" src="' + url + '"/>' +
                '</div>'
            }, option)
            modal(opt)
        },
        //二维码
        qrcode: function (el, options) {
            require(['dist/static/component/qrcode'], function (qrcode) {
                qrcode(el, options);
            })
        },
        //颜色选择
        colorpicker: function (el, options) {
            require(['dist/static/component/colorpicker'], function (colorpicker) {
                colorpicker(el, options);
            })
        },
        //cookie操作
        cookie: function (callback) {
            require(['dist/static/component/cookie'], function (cookie) {
                cookie(callback);
            })
        },
        //时间区间选择
        daterangepicker: function (options) {
            require(['dist/static/component/daterangepicker'], function (daterangepicker) {
                daterangepicker(options);
            })
        },
        //列表框选择日期
        dateselect: function (elem, val) {
            require(['dist/static/component/dateselect'], function (dateselect) {
                dateselect(elem, val);
            })
        },
        //列表框选择日期
        datetimepicker: function (elem, options) {
            require(['dist/static/component/datetimepicker'], function (datetimepicker) {
                datetimepicker(elem, options);
            })
        },
        //表情选择
        emotion: function (options) {
            require(['dist/static/component/emotion'], function (emotion) {
                emotion(options);
            })
        },
        //字体选择
        font: function (callback) {
            require(['dist/static/component/font'], function (font) {
                font(callback);
            })
        },
        //css加载动画
        spinners: function (callback) {
            require(['css!dist/static/css/spinners.css'])
        },
        //字体选择
        swiper: function (el, options) {
            require(['dist/static/component/swiper'], function (swiper) {
                swiper(el, options);
            })
        },
        //字体选择
        map: function (val, callback) {
            require(['dist/static/component/map'], function (map) {
                map(val, callback);
            })
        },
        //表单提交
        submit: function (options) {
            require(['dist/static/component/submit'], function (submit) {
                submit(options);
            })
        },
        //发送验证码
        validCode: function (options) {
            require(['dist/static/component/validCode'], function (validCode) {
                validCode(options);
            })
        },
        //视频播放器
        video: function (TagName, callback) {
            require(['dist/static/component/video'], function (video) {
                video(TagName, callback);
            })
        },
        //表单验证
        validate: function () {
            require(['https://cdn.bootcss.com/jquery-form-validator/2.3.77/jquery.form-validator.min.js'], function () {
                $.validate();
            })
        },
        //加载动作
        loading: function (callback) {
            var modalobj = $('#modal-loading');
            if (modalobj.length == 0) {
                $(document.body).append('<div id="modal-loading" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>');
                modalobj = $('#modal-loading');
                var html =
                    '<div class="modal-dialog" style="position: absolute;top:30%;left:35%;">' +
                    '	<div style="text-align:center; background-color: transparent;">' +
                    '     <i class="fa fa-spinner fa-spin fa-4x fa-fw" style="font-size: 5em;"></i>' +
                    '	</div>' +
                    '</div>';
                modalobj.html(html);
            }
            modalobj.modal('show');
            modalobj.next().css('z-index', 999999);
            return modalobj;
        },
        //URL中GET参数管理
        get: {
            get: function (par, url) {
                //获取当前URL
                var local_url = url ? url : document.location.href;
                //获取要取得的get参数位置
                var get = local_url.indexOf(par + "=");
                if (get == -1) {
                    return false;
                }
                //截取字符串
                var get_par = local_url.slice(par.length + get + 1);
                //判断截取后的字符串是否还有其他get参数
                var nextPar = get_par.indexOf("&");
                if (nextPar != -1) {
                    get_par = get_par.slice(0, nextPar);
                }
                return get_par;
            },
            //替换get参数
            set: function (paramName, replaceWith, url) {
                var url = url ? url : document.location.href;
                var oUrl = url.toString();
                if (oUrl.indexOf(paramName) >= 0) {
                    var re = eval('/(' + paramName + '=)([^&]*)/gi');
                    return oUrl.replace(re, paramName + '=' + replaceWith);
                } else {
                    return oUrl + '&' + paramName + '=' + replaceWith;
                }
            },
            regexp: {
                //手机
                mobile: function (val) {
                    return /^\d{11}$/.test(val);
                },
                //邮箱
                email: function (val) {
                    return !/^.+@.+$/.test(val);
                }
            }
        }
    }
})