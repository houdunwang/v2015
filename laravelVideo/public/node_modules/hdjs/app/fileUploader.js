define(["jquery", "underscore", "webuploader", "util"], function ($, underscore, WebUploader, util) {
    var modalobj = null;
    var obj = {
        show: function (callback, options) {
            //初始化POST数据
            options.data = options.data ? options.data : {};
            //后台管理时添加
            if (window.system) {
                options.data.user_type = window.system.user_type
            }
            //针对HDCMS的表单令牌处理
            if ($('meta[name="csrf-token"]').length > 0) {
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                options.data.csrf_token = csrf_token;
                options.data._token = csrf_token;
            }
            //成功上传的图片
            var images = [];
            switch (options.type) {
                case 'image':
                    modalobj = util.modal({
                        width: 700,
                        title: '<ul class="nav nav-pills" role="tablist">\
                    <li role="presentation" class="active"><a href="#upload" aria-controls="home" role="tab" data-toggle="tab">上传图片</a></li>\
                    <li role="presentation"><a href="#imagelistsBox" aria-controls="profile" role="tab" data-toggle="tab">浏览图片</a></li>\
                    </ul>',
                        content: ' <div class="tab-content">\
                    <div role="tabpanel" class="tab-pane active" id="upload"><div id="wrapper">\
                          <div id="container">\
                        <div id="uploader">\
                            <div class="queueList">\
                            <div id="dndArea" class="placeholder">\
                            <div id="filePicker"></div>\
                            <p>或将照片拖到这里</p>\
                        </div>\
                        </div>\
                        <div class="statusBar">\
                            <div class="progress">\
                            <span class="text">0%</span>\
                            <span class="percentage"></span>\
                            </div><div class="info"></div>\
                            <div class="btns">\
                            <div class="btn btn-default" data-dismiss="modal">取消</div>\
                            <div class="btn btn-primary uploadBtn">确定使用</div>\
                            </div> </div> </div> </div> </div></div>\
                    <div role="tabpanel" class="tab-pane" id="imagelistsBox">\
                        <div id="imagelists"></div>\
                    </div>\
                </div>\
                ',
                        events: {
                            'shown.bs.modal': function () {
                                if (options.multiple) {
                                    $("#imagelistsBox").append('<br/><div class="text-right"><div class="btn btn-default" data-dismiss="modal">取消</div> <div class="btn btn-primary uploadSelectFiles">确定使用</div></div>');
                                }
                                //加载远程文件
                                function getImageList(url) {
                                    //添加获取的类型是后台用户还是前台用户
                                    var post = {extensions: options.extensions};
                                    if (window.system) {
                                        post.user_type = window.system.user_type
                                    }
                                    post.csrf_token = options.data.csrf_token;
                                    $.post(url, post, function (res) {
                                        if (res.valid == 0) {
                                            modalobj.modal('hide');
                                            util.message(res.message, '', 'warning');
                                        } else {
                                            var html = '<ul class="clearfix image-list-box">';
                                            $(res.data).each(function (i) {
                                                html += '<li style="background-image: url(' + res.data[i].url + ');" path="' + res.data[i].path + '"></li>';
                                            });
                                            html += "</ul>";
                                            html += res.page;
                                            modalobj.find('#imagelists').html(html);
                                        }
                                    }, 'json');
                                }

                                getImageList(hdjs.filesLists + '&type=image');
                                //分页处理
                                modalobj.delegate('#imagelists .pagination a', 'click', function () {
                                    var url = $(this).attr('href');
                                    getImageList(url);
                                    return false;
                                });
                                //选中图片
                                modalobj.delegate('#imagelists li', 'click', function () {
                                    $(this).toggleClass('selectActive');
                                    images = [];
                                    $("#imagelists li.selectActive").each(function () {
                                        url = $(this).attr('path');
                                        images.push(url);
                                    })
                                    if (!options.multiple) {
                                        modalobj.modal('hide');
                                    }
                                });
                                //多图上传时选中确定选择的图片
                                modalobj.delegate('.uploadSelectFiles', 'click', function () {
                                    modalobj.modal('hide');
                                });

                                //显示上传控件
                                var uploader = obj.initImageUploader({
                                    accept: {
                                        title: 'Images',
                                        extensions: options.extensions,//允许上传的文件类型
                                        mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'
                                    },
                                    compress: false,
                                    formData: options.data,
                                    multiple: options.multiple,
                                    fileNumLimit: 100,//允许上传的文件数量
                                    fileSizeLimit: 200 * 1024 * 1024,    // 200 M 允许上传文件大小
                                    fileSingleSizeLimit: 2 * 1024 * 1024    // 2 M 单个文件上传大小
                                });
                                uploader.on('uploadAccept', function (file, response) {
                                    if (response.valid !== undefined) {
                                        if (response.valid) {
                                            images.push(response.message);
                                            return true;
                                        } else {
                                            //上传失败
                                            alert('上传失败, ' + response.message);
                                            uploader.removeFile(file.file);
                                            return false;
                                        }
                                    } else {
                                        require(['util'], function () {
                                            util.message(response._raw, '', 'info', 5);
                                        })
                                    }
                                });
                            },
                            'hide.bs.modal': function () {
                                callback(images);
                            },
                            'hidden.bs.modal': function () {
                                modalobj.remove();
                            }
                        }
                    });
                    break;
                case 'mobileImage':
                    modalobj = util.modal({
                        width: '96%',
                        title: '<h4>请上传图片</h4>',
                        content: ' <div class="tab-content">\
                    <div role="tabpanel" class="tab-pane active" id="upload"><div id="wrapper">\
                          <div id="container">\
                        <div id="uploader">\
                            <div class="queueList">\
                                <div id="dndArea" class="placeholder">\
                                <div id="filePicker"></div>\
                            </div>\
                        </div>\
                        <div class="statusBar">\
                            <div class="progress">\
                            <span class="text">0%</span>\
                            <span class="percentage"></span>\
                            </div>\
                            <div class="btns">\
                            <div class="btn btn-default" data-dismiss="modal">关闭</div>\
                            </div> </div> </div> </div> </div></div>\
                </div>\
                ',
                        events: {
                            'shown.bs.modal': function () {
                                //加载远程文件
                                function getImageList(url) {
                                    //添加获取的类型是后台用户还是前台用户
                                    var post = {extensions: options.extensions};
                                    if (window.system) {
                                        post.user_type = window.system.user_type
                                    }
                                    post.csrf_token = options.data.csrf_token;
                                    $.post(url, post, function (res) {
                                        if (res.valid == 0) {
                                            modalobj.modal('hide');
                                            util.message(res.message, '', 'warning');
                                        } else {
                                            var html = '<ul class="clearfix">';
                                            $(res.data).each(function (i) {
                                                html += '<li><img src="' + res.data[i].path + '"></li>';
                                            })
                                            html += "</ul>";
                                            html += res.page;
                                            modalobj.find('#imagelists').html(html);
                                        }
                                    }, 'json');
                                }

                                getImageList(hdjs.filesLists);
                                //分页处理
                                modalobj.delegate('#imagelists .pagination a', 'click', function () {
                                    var url = $(this).attr('href');
                                    getImageList(url);
                                    return false;
                                });
                                //选中图片
                                modalobj.delegate('#imagelists li img', 'click', function () {
                                    var url = $(this).attr('src');
                                    images.push(url);
                                    modalobj.modal('hide');
                                });

                                //显示上传控件
                                var uploader = obj.initImageUploader({
                                    accept: {
                                        title: 'Images',
                                        extensions: options.extensions,//允许上传的文件类型
                                        mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'
                                    },
                                    formData: options.data,
                                    compress: {
                                        width: 1600,
                                        height: 1600,
                                    },
                                    auto: true,
                                    multiple: false,
                                    fileNumLimit: 1,//允许上传的文件数量
                                    fileSizeLimit: 200 * 1024 * 1024,    // 200 M 允许上传文件大小
                                    fileSingleSizeLimit: 20 * 1024 * 1024    // 2 M 单个文件上传大小
                                });
                                uploader.on('uploadAccept', function (file, response) {
                                    if (response.valid) {
                                        images.push(response.message);
                                        return true;
                                    } else {
                                        //上传失败
                                        alert('上传失败, ' + response.message);
                                        uploader.removeFile(file.file);
                                        return false;
                                    }
                                });
                            },
                            'hide.bs.modal': function () {
                                callback(images);
                            },
                            'hidden.bs.modal': function () {
                                modalobj.remove();
                            }
                        }
                    });
                    break;
                case 'file':
                    //上传文件
                    modalobj = util.modal({
                        width: 700,
                        title: '<ul class="nav nav-pills" role="tablist">\
                    <li role="presentation" class="active"><a href="#upload" aria-controls="home" role="tab" data-toggle="tab">上传文件</a></li>\
                    <li role="presentation"><a href="#imagelists" aria-controls="profile" role="tab" data-toggle="tab">浏览文件</a></li>\
                    </ul>',
                        content: ' <div class="tab-content">\
                    <div role="tabpanel" class="tab-pane active" id="upload"><div id="wrapper">\
                          <div id="container">\
                        <div id="uploader">\
                            <div class="queueList">\
                            <div id="dndArea" class="placeholder">\
                            <div id="filePicker"></div>\
                            <p>或将文件拖到这里</p>\
                        </div>\
                        </div>\
                        <div class="statusBar">\
                            <div class="progress">\
                            <span class="text">0%</span>\
                            <span class="percentage"></span>\
                            </div><div class="info"></div>\
                            <div class="btns">\
                            <div class="btn btn-default" data-dismiss="modal">取消</div>\
                            <div class="btn btn-primary uploadBtn">确定使用</div>\
                            </div> </div> </div> </div> </div></div>\
                <div role="tabpanel" class="tab-pane" id="imagelists">\
                \
                </div>\
                </div>\
                ',
                        events: {
                            'shown.bs.modal': function () {
                                //加载远程文件
                                function getImageList(url) {
                                    //添加获取的类型是后台用户还是前台用户
                                    var post = {extensions: options.extensions};
                                    if (window.system) {
                                        post.user_type = window.system.user_type
                                    }
                                    post.csrf_token = options.data.csrf_token;
                                    $.post(url, post, function (res) {
                                        if (res.valid == 0) {
                                            modalobj.modal('hide');
                                            util.message(res.message, '', 'warning');
                                        } else {
                                            var html = '<table class="table table-hover">' +
                                                '<tr><th>文件名</th><th>大小</th><th>创建时间</th></tr>';
                                            $(res.data).each(function (i) {
                                                html += '<tr><td><a href="javascript:;" src="' + res.data[i].path + '">' + res.data[i].name + '</a></td>' +
                                                    '<td>' + res.data[i].size + '</td>' +
                                                    '<td>' + res.data[i].createtime + '</td></tr>';
                                            })
                                            html += "</table>";
                                            html += res.page;
                                            modalobj.find('#imagelists').html(html);
                                        }
                                    }, 'json');
                                }

                                getImageList(hdjs.filesLists + '&type=file');
                                //分页处理
                                modalobj.delegate('#imagelists .pagination a', 'click', function () {
                                    var url = $(this).attr('href');
                                    getImageList(url);
                                    return false;
                                });
                                //选中图片
                                modalobj.delegate('#imagelists table a', 'click', function () {
                                    var url = $(this).attr('src');
                                    images.push(url);
                                    modalobj.modal('hide');
                                });
                                // alert('.' + options.extensions.replace(/,/g, ',.'));
                                //显示上传控件
                                var uploader = obj.initImageUploader({
                                    accept: {
                                        title: 'file',
                                        extensions: options.extensions,//允许上传的文件类型
                                        // mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'
                                        // mimeTypes: '.' + options.extensions.replace(/,/g, ',.'),
                                        // mimeTypes: 'application/zip' ',.'),
                                    },
                                    formData: options.data,
                                    multiple: options.multiple,
                                    fileNumLimit: 100,//允许上传的文件数量
                                    fileSizeLimit: 200 * 1024 * 1024,    // 200 M 允许上传文件大小
                                    fileSingleSizeLimit: options.fileSingleSizeLimit    // 2 M 单个文件上传大小
                                });
                                uploader.on('uploadAccept', function (file, response) {
                                    if (response.valid) {
                                        images.push(response.message);
                                        return true;
                                    } else {
                                        //上传失败
                                        alert('上传失败, ' + response.message);
                                        uploader.removeFile(file.file);
                                        return false;
                                    }
                                });
                            },
                            'hide.bs.modal': function () {
                                callback(images);
                            },
                            'hidden.bs.modal': function () {
                                modalobj.remove();
                            }
                        }
                    });
                    break;
            }
        },
        initImageUploader: function (options) {
            var opt = $.extend({
                accept: {
                    title: 'Images',
                    extensions: 'jpg,jpeg,png',
                    mimeTypes: 'image/jpg,image/jpeg,image/png'
                },
                // method: 'GET',
                multiple: false,//同时可以选多个文件
                fileNumLimit: 300,//允许上传的文件数量
                fileSizeLimit: 200 * 1024 * 1024,    // 200 M 允许上传文件大小
                fileSingleSizeLimit: 50 * 1024 * 1024    // 50 M 单个文件上传大小
            }, options);

            var $wrap = $('#uploader'),
                // 图片容器
                $queue = $('<ul class="filelist"></ul>')
                    .appendTo($wrap.find('.queueList')),

                // 状态栏，包括进度和控制按钮
                $statusBar = $wrap.find('.statusBar'),

                // 文件总体选择信息。
                $info = $statusBar.find('.info'),

                // 上传按钮
                $upload = $wrap.find('.uploadBtn'),

                // 没选择文件之前的内容。
                $placeHolder = $wrap.find('.placeholder'),

                $progress = $statusBar.find('.progress').hide(),

                // 添加的文件数量
                fileCount = 0,

                // 添加的文件总大小
                fileSize = 0,

                // 优化retina, 在retina下这个值是2
                ratio = window.devicePixelRatio || 1,

                // 缩略图大小
                thumbnailWidth = 110 * ratio,
                thumbnailHeight = 110 * ratio,

                // 可能有pedding, ready, uploading, confirm, done.
                state = 'pedding',

                // 所有文件的进度信息，key为file id
                percentages = {},
                // 判断浏览器是否支持图片的base64
                isSupportBase64 = (function () {
                    var data = new Image();
                    var support = true;
                    data.onload = data.onerror = function () {
                        if (this.width != 1 || this.height != 1) {
                            support = false;
                        }
                    }
                    data.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
                    return support;
                })(),

                // 检测是否已经安装flash，检测flash的版本
                flashVersion = (function () {
                    var version;

                    try {
                        version = navigator.plugins['Shockwave Flash'];
                        version = version.description;
                    } catch (ex) {
                        try {
                            version = new ActiveXObject('ShockwaveFlash.ShockwaveFlash')
                                .GetVariable('$version');
                        } catch (ex2) {
                            version = '0.0';
                        }
                    }
                    version = version.match(/\d+/g);
                    return parseFloat(version[0] + '.' + version[1], 10);
                })(),

                supportTransition = (function () {
                    var s = document.createElement('p').style,
                        r = 'transition' in s ||
                            'WebkitTransition' in s ||
                            'MozTransition' in s ||
                            'msTransition' in s ||
                            'OTransition' in s;
                    s = null;
                    return r;
                })(),

                // WebUploader实例
                uploader;
            if (!WebUploader.Uploader.support('flash') && WebUploader.browser.ie) {
                // flash 安装了但是版本过低。
                if (flashVersion) {
                    (function (container) {
                        window['expressinstallcallback'] = function (state) {
                            switch (state) {
                                case 'Download.Cancelled':
                                    alert('您取消了更新！')
                                    break;

                                case 'Download.Failed':
                                    alert('安装失败')
                                    break;

                                default:
                                    alert('安装已成功，请刷新！');
                                    break;
                            }
                            delete window['expressinstallcallback'];
                        };

                        var swf = 'resource/hdjs/component/webuploader/expressInstall.swf';
                        // insert flash object
                        var html = '<object type="application/' +
                            'x-shockwave-flash" data="' + swf + '" ';

                        if (WebUploader.browser.ie) {
                            html += 'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
                        }

                        html += 'width="100%" height="100%" style="outline:0">' +
                            '<param name="movie" value="' + swf + '" />' +
                            '<param name="wmode" value="transparent" />' +
                            '<param name="allowscriptaccess" value="always" />' +
                            '</object>';

                        container.html(html);

                    })($wrap);

                    // 压根就没有安转。
                } else {
                    $wrap.html('<a href="http://www.adobe.com/go/getflashplayer" target="_blank" border="0"><img alt="get flash player" src="http://www.adobe.com/macromedia/style_guide/images/160x41_Get_Flash_Player.jpg" /></a>');
                }

                return;
            } else if (!WebUploader.Uploader.support()) {
                alert('Web Uploader 不支持您的浏览器！');
                return;
            }

            // 实例化
            var _options = $.extend({
                pick: {
                    id: '#filePicker',
                    label: '点击选择文件',
                    multiple: opt.multiple,
                },
                formData: {},
                dnd: '#dndArea',
                paste: '#uploader',
                swf: hdjs.base + '/component/webuploader/Uploader.swf',
                chunked: false,
                chunkSize: 512 * 1024,
                server: hdjs.uploader,
                // runtimeOrder: 'flash',
                accept: opt.accept,//允许上传的文件类型
                // 禁掉全局的拖拽功能。这样不会出现图片拖进页面的时候，把图片打开。
                disableGlobalDnd: true,
                fileNumLimit: opt.fileNumLimit,//允许上传的文件数量
                fileSizeLimit: opt.fileSizeLimit,    // 200 M 允许上传文件大小
                fileSingleSizeLimit: opt.fileSingleSizeLimit    // 50 M 单个文件上传大小
            }, opt);
            uploader = WebUploader.create(_options);
            // 拖拽时不接受 js, txt 文件。
            uploader.on('dndAccept', function (items) {
                var denied = false,
                    len = items.length,
                    i = 0,
                    // 修改js类型
                    unAllowed = 'text/plain;application/javascript ';

                for (; i < len; i++) {
                    // 如果在列表里面
                    if (~unAllowed.indexOf(items[i].type)) {
                        denied = true;
                        break;
                    }
                }

                return !denied;
            });

            // uploader.on('filesQueued', function() {
            //     uploader.sort(function( a, b ) {
            //         if ( a.name < b.name )
            //           return -1;
            //         if ( a.name > b.name )
            //           return 1;
            //         return 0;
            //     });
            // });

            // 添加“添加文件”的按钮，
            uploader.addButton({
                id: '#filePicker2',
                label: '继续添加'
            });

            uploader.on('ready', function () {
                window.uploader = uploader;
            });

            // 当有文件添加进来时执行，负责view的创建
            function addFile(file) {
                var $li = $('<li id="' + file.id + '">' +
                        '<p class="title">' + file.name + '</p>' +
                        '<p class="imgWrap"></p>' +
                        //'<p class="progress"><span></span></p>' +
                        '</li>'),

                    $btns = $('<div class="file-panel">' +
                        '<span class="cancel">删除</span>' +
                        '<span class="rotateRight">向右旋转</span>' +
                        '<span class="rotateLeft">向左旋转</span></div>').appendTo($li),
                    $prgress = $li.find('p.progress span'),
                    $wrap = $li.find('p.imgWrap'),
                    $info = $('<p class="error"></p>'),

                    showError = function (code) {
                        switch (code) {
                            case 'exceed_size':
                                text = '文件大小超出';
                                break;

                            case 'interrupt':
                                text = '上传暂停';
                                break;

                            default:
                                text = '上传失败，请重试';
                                break;
                        }

                        $info.text(text).appendTo($li);
                    };

                if (file.getStatus() === 'invalid') {
                    showError(file.statusText);
                } else {
                    // @todo lazyload
                    $wrap.text('预览中');
                    uploader.makeThumb(file, function (error, src) {
                        var img;

                        if (error) {
                            $wrap.text('不能预览');
                            return;
                        }

                        if (isSupportBase64) {
                            img = $('<img src="' + src + '">');
                            $wrap.empty().append(img);
                        } else {
                            $.ajax('../../server/preview.php', {
                                method: 'POST',
                                data: src,
                                dataType: 'json'
                            }).done(function (response) {
                                if (response.result) {
                                    img = $('<img src="' + response.result + '">');
                                    $wrap.empty().append(img);
                                } else {
                                    $wrap.text("预览出错");
                                }
                            });
                        }
                    }, thumbnailWidth, thumbnailHeight);

                    percentages[file.id] = [file.size, 0];
                    file.rotation = 0;
                }

                file.on('statuschange', function (cur, prev) {
                    if (prev === 'progress') {
                        $prgress.hide().width(0);
                    } else if (prev === 'queued') {
                        $li.off('mouseenter mouseleave');
                        $btns.remove();
                    }

                    // 成功
                    if (cur === 'error' || cur === 'invalid') {
                        console.log(file.statusText);
                        showError(file.statusText);
                        percentages[file.id][1] = 1;
                    } else if (cur === 'interrupt') {
                        showError('interrupt');
                    } else if (cur === 'queued') {
                        percentages[file.id][1] = 0;
                    } else if (cur === 'progress') {
                        $info.remove();
                        $prgress.css('display', 'block');
                    } else if (cur === 'complete') {
                        $li.append('<span class="success"></span>');
                    }

                    $li.removeClass('state-' + prev).addClass('state-' + cur);
                });

                $li.on('mouseenter', function () {
                    $btns.stop().animate({height: 30});
                });

                $li.on('mouseleave', function () {
                    $btns.stop().animate({height: 0});
                });

                $btns.on('click', 'span', function () {
                    var index = $(this).index(),
                        deg;

                    switch (index) {
                        case 0:
                            uploader.removeFile(file);
                            return;

                        case 1:
                            file.rotation += 90;
                            break;

                        case 2:
                            file.rotation -= 90;
                            break;
                    }

                    if (supportTransition) {
                        deg = 'rotate(' + file.rotation + 'deg)';
                        $wrap.css({
                            '-webkit-transform': deg,
                            '-mos-transform': deg,
                            '-o-transform': deg,
                            'transform': deg
                        });
                    } else {
                        $wrap.css('filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation=' + (~~((file.rotation / 90) % 4 + 4) % 4) + ')');
                        // use jquery animate to rotation
                        // $({
                        //     rotation: rotation
                        // }).animate({
                        //     rotation: file.rotation
                        // }, {
                        //     easing: 'linear',
                        //     step: function( now ) {
                        //         now = now * Math.PI / 180;

                        //         var cos = Math.cos( now ),
                        //             sin = Math.sin( now );

                        //         $wrap.css( 'filter', "progid:DXImageTransform.Microsoft.Matrix(M11=" + cos + ",M12=" + (-sin) + ",M21=" + sin + ",M22=" + cos + ",SizingMethod='auto expand')");
                        //     }
                        // });
                    }


                });

                $li.appendTo($queue);
            }

            // 负责view的销毁
            function removeFile(file) {
                var $li = $('#' + file.id);

                delete percentages[file.id];
                updateTotalProgress();
                $li.off().find('.file-panel').off().end().remove();
            }

            function updateTotalProgress() {
                var loaded = 0,
                    total = 0,
                    spans = $progress.children(),
                    percent;

                $.each(percentages, function (k, v) {
                    total += v[0];
                    loaded += v[0] * v[1];
                });

                percent = total ? loaded / total : 0;


                spans.eq(0).text(Math.round(percent * 100) + '%');
                spans.eq(1).css('width', Math.round(percent * 100) + '%');
                updateStatus();
            }

            function updateStatus() {
                var text = '', stats;

                if (state === 'ready') {
                    text = '选中' + fileCount + '张图片，共' +
                        WebUploader.formatSize(fileSize) + '。';
                } else if (state === 'confirm') {
                    stats = uploader.getStats();
                    if (stats.uploadFailNum) {
                        text = '已成功上传' + stats.successNum + '个文件';
                    }

                } else {
                    stats = uploader.getStats();
                    text = '共' + fileCount + '张（' +
                        WebUploader.formatSize(fileSize) +
                        '），已上传' + stats.successNum + '张';

                    if (stats.uploadFailNum) {
                        text += '，失败' + stats.uploadFailNum + '张';
                    }
                }

                $info.html(text);
            }

            function setState(val) {
                var file, stats;

                if (val === state) {
                    return;
                }

                $upload.removeClass('state-' + state);
                $upload.addClass('state-' + val);
                state = val;

                switch (state) {
                    case 'pedding':
                        $placeHolder.removeClass('element-invisible');
                        $queue.hide();
                        //$statusBar.addClass('element-invisible');
                        uploader.refresh();
                        break;

                    case 'ready':
                        $placeHolder.addClass('element-invisible');
                        $('#filePicker2').removeClass('element-invisible');
                        $queue.show();
                        $statusBar.removeClass('element-invisible');
                        uploader.refresh();
                        break;

                    case 'uploading':
                        $('#filePicker2').addClass('element-invisible');
                        $progress.show();
                        $upload.text('暂停上传');
                        break;

                    case 'paused':
                        $progress.show();
                        $upload.text('继续上传');
                        break;

                    case 'confirm':
                        $progress.hide();
                        $('#filePicker2').removeClass('element-invisible');
                        $upload.text('开始上传');

                        stats = uploader.getStats();
                        if (stats.successNum && !stats.uploadFailNum) {
                            setState('finish');
                            return;
                        }
                        break;
                    case 'finish':
                        stats = uploader.getStats();
                        if (stats.successNum) {
                            //隐藏上传模态框
                            modalobj.modal('hide');
                            //alert('上传成功');
                        } else {
                            // 没有成功的图片，重设
                            state = 'done';
                            location.reload();
                        }
                        break;
                }

                updateStatus();
            }

            uploader.onUploadProgress = function (file, percentage) {
                var $li = $('#' + file.id),
                    $percent = $li.find('.progress span');

                $percent.css('width', percentage * 100 + '%');
                percentages[file.id][1] = percentage;
                updateTotalProgress();
            };

            uploader.onFileQueued = function (file) {
                fileCount++;
                fileSize += file.size;

                if (fileCount === 1) {
                    $placeHolder.addClass('element-invisible');
                    $statusBar.show();
                }

                addFile(file);
                setState('ready');
                updateTotalProgress();
            };

            uploader.onFileDequeued = function (file) {
                fileCount--;
                fileSize -= file.size;

                if (!fileCount) {
                    setState('pedding');
                }

                removeFile(file);
                updateTotalProgress();

            };

            uploader.on('all', function (type) {
                var stats;
                switch (type) {
                    case 'uploadFinished':
                        setState('confirm');
                        break;

                    case 'startUpload':
                        setState('uploading');
                        break;

                    case 'stopUpload':
                        setState('paused');
                        break;

                }
            });

            uploader.onError = function (code) {
                alert('上传错误,请检测文件类型与大小');
                // alert('Eroor: ' + code);
            };

            $upload.on('click', function () {
                if ($(this).hasClass('disabled')) {
                    return false;
                }

                if (state === 'ready') {
                    uploader.upload();
                } else if (state === 'paused') {
                    uploader.upload();
                } else if (state === 'uploading') {
                    uploader.stop();
                }
            });

            $info.on('click', '.retry', function () {
                uploader.retry();
            });

            $info.on('click', '.ignore', function () {
                alert('todo');
            });

            $upload.addClass('state-' + state);
            updateTotalProgress();
            return uploader;
        }
    }
    return obj;
});
