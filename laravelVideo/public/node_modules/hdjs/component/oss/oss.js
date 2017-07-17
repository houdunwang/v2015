//阿里OSS
define(['jquery', 'webuploader'], function ($, WebUploader) {
    var instance = {
        opt: {},
        oss: {
            //获取签名的后台地址
            serverUrl: '',
            //签名本地缓存时间
            expire: 0,
            //在OSS中储存object的目录
            dir: 'hdjs/',
        }
    };
    instance.upload = function (options) {
        instance.opt = $.extend({
            //在OSS中储存object的目录
            dir: 'hdjs/',
            //允许重复上传
            duplicate:true,
            // 选完文件后，是否自动上传。
            auto: true,
            // swf文件路径
            swf: hdjs.base + '/webuploader/Uploader.swf',
            // 文件接收服务端。
            server: 'http://oss.aliyuncs.com',
            //图片是否压缩
            resize:false,
            //储存到OSS的文件名类型,random_name:随机字符 local_name:原文件名
            name_type: 'random_name',
            //单文件上传
            multiple: false,
            //允许上传的文件数量
            fileNumLimit: 1,
            // 200 M 允许上传文件大小
            fileSizeLimit: 500 * 1024 * 1024,
            // 2 M 单个文件上传大小
            fileSingleSizeLimit: 200 * 1024 * 1024,
        }, options);
        instance.oss.dir = instance.opt.dir;
        instance.oss.serverUrl = instance.opt.serverUrl;
        //初始化webupload上传组件
        return instance.webupload();
    }
    //获取签名
    instance.get_signature = function () {
        //可以判断当前expire是否超过了当前时间,如果超过了当前时间,就重新取一下.3s 做为缓冲
        now = timestamp = Date.parse(new Date()) / 1000;
        if (instance.oss.expire < now + 3) {
            $.ajax({
                type: "POST",
                async: false,
                url: instance.oss.serverUrl + '&dir=' + instance.oss.dir,
                dataType: 'json',
                data: {
                    csrf_token: $('meta[name="csrf-token"]').attr('content'),
                    //hdcms使用
                    user_type: window.system?window.system.user_type:''
                },
                success: function (obj) {
                    instance.oss =$.extend(instance.oss, obj);
                }
            });
            return true;
        }
        return false;
    };
    //随机数用于生成随机对象名
    instance.random_string = function (len) {
        len = len || 32;
        var chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
        var maxPos = chars.length;
        var pwd = '';
        for (i = 0; i < len; i++) {
            pwd += chars.charAt(Math.floor(Math.random() * maxPos));
        }
        return pwd;
    }
    //获取扩展名后缀
    instance.get_suffix = function (filename) {
        pos = filename.lastIndexOf('.')
        suffix = ''
        if (pos != -1) {
            suffix = filename.substring(pos)
        }
        return suffix;
    }
    //获取对象名即储存到oss中的名子
    instance.object_name = function (filename) {
        if (instance.opt.name_type == 'local_name') {
            instance.oss.object_name = instance.oss.dir+filename;
        }
        else if (instance.opt.name_type == 'random_name') {
            instance.oss.object_name = instance.oss.dir + instance.random_string(10) + instance.get_suffix(filename)
        }
        return ''
    }
    instance.webupload = function () {
        var uploader =  new WebUploader.create(instance.opt);
        //当有文件被添加进队列的时候
        uploader.on('fileQueued', function (file) {
            instance.get_signature();
            instance.object_name(file.name);
            uploader.option('formData', {
                'key': instance.oss.object_name,
                'policy': instance.oss['policy'],
                'OSSAccessKeyId': instance.oss['accessid'],
                'success_action_status': '200', //让服务端返回200,不然，默认会返回204
                'callback': instance.oss['callbackbody'],
                'signature': instance.oss['signature'],
            });
            uploader.option('server', instance.oss.host);
        });
        return uploader;
    }
    return instance;
});