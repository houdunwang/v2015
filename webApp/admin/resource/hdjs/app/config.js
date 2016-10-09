/**
 * 前端模块配置
 * @author 向军 <2300071698@qq.com>
 */

require.config({
    baseUrl: 'resource/hdjs/app',
    paths: {
        //'async': '../js/async',
        'require.css': '../js/require.css.min',
        'swiper': '../js/swiper-3.3.1.min',
        'wapeditor': '../../js/wapeditor',
        'angular.drag': '../js/angular-drag-and-drop-lists.min',
        'domReady': '../js/domReady',
        'jquery-ui': '../js/jquery-ui.min',
        'css': '../js/css.min',
        'jquery': '../js/jquery.min',
        'jquery.mobile': '../js/jquery.mobile-1.4.5.min',
        'angular': '../js/angular.min',
        'angular.sanitize': '../js/angular-sanitize.min',
        'ngSortable': '../js/ng-sortable',
        'Sortable': '../js/Sortable',
        'cookie': '../js/js.cookie.min',
        'bootstrap': '../js/bootstrap.min',
        'bootstrap.switch': '../js/bootstrap-switch.min',
        //音乐、视频播放
        'jquery.jplayer': '../js/jquery.jplayer.min',
        //复制内容
        'jquery.zclip': '../js/jquery.zclip.min',
        'md5': '../js/md5.min',
        //函数库
        'underscore': '../js/underscore-min',
        'lodash': '../js/lodash.min',
        //图表
        'chart': '../js/Chart.min',
        //时间处理 http://momentjs.cn/
        'moment': '../js/moment-with-locales.min',
        //拾色器
        'colorpicker': '../js/spectrum.min',
        //二维码
        'qrcode': '../js/jquery.qrcode.min',
        //二维码
        'select2': '../js/i18n/zh-CN',
        //日期选择器
        'datetimepicker': '../js/bootstrap-datetimepicker.min',
        //时间区间
        'daterangepicker': '../js/daterangepicker.min',
        //验证
        'validator': '../js/bootstrapValidator.min',
        //光标位置
        'caret': '../js/jquery.caret',
        //百度文件上传
        'webuploader': '../component/webuploader/webuploader.min',
        //编辑器
        'kindeditor': '../component/kindeditor/lang/zh_CN',
        'kindeditor.main': '../component/kindeditor/kindeditor-min',
        //百度编辑器
        'ueditor.config': '../component/ueditor/ueditor.config',
        'ueditor.main': '../component/ueditor/ueditor.all.min',
        'ueditor': '../component/ueditor/lang/zh-cn/zh-cn',
        'ZeroClipboard': '../component/ueditor/third-party/zeroclipboard/ZeroClipboard.min',
        //时间选择
        'clockpicker': '../component/clockpicker/bootstrap-clockpicker.min',
        'filestyle': '../js/bootstrap-filestyle.min',
        'json2': '../js/json2.min',
        'map': 'http://api.map.baidu.com/getscript?v=2.0&ak=WcqLYXBH2tHLhYNfPNpZCD4s&services=&t=20160708193109',
    },
    shim: {
        'map': {
            exports: 'BMap'
        },
        'ngSortable': {
            deps: ['Sortable']
        },
        'jquery.mobile': {
            exports: '$',
            deps: ['jquery']
        },
        'wapeditor': {
            exports: 'angular',
            deps: ['angular.sanitize', 'underscore', 'json2', 'datetimepicker']
        },
        'jquery-ui': {
            deps: ['jquery', 'css!../css/jquery-ui.min.css']
        },
        'ueditor': {
            deps: ['ueditor.config', 'ueditor.main', 'ZeroClipboard']
        },
        'ZeroClipboard': {
            exports: ['ZeroClipboard']
        },
        'angular.sanitize': {
            exports: 'angular',
            deps: ['angular']
        },
        'swiper': {
            exports: '$',
            deps: ['bootstrap', 'css!../css/swiper-3.3.1.min.css']
        },
        'bootstrap': {
            exports: '$',
            deps: ['jquery', 'filestyle', 'css!../css/app.css', 'css!../css/bootstrap.min.css', 'css!../css/font-awesome.min.css']
        },
        'bootstrap.switch': {
            exports: '$',
            deps: ['bootstrap', 'css!../css/bootstrap-switch.min.css']
        },
        'angular': {
            exports: 'angular',
            deps: ['jquery']
        },
        'jquery.jplayer': {
            deps: ['jquery']
        },
        'jquery.zclip': {
            deps: ['jquery']
        },
        'chart': {
            exports: 'chart'
        },
        'caret': {
            exports: '$',
            deps: ['jquery']
        },
        'webuploader': {
            deps: ['css!../component/webuploader/webuploader.css', 'css!../component/webuploader/style.css']
        },
        'qrcode': {
            exports: '$',
            deps: ['jquery']
        },
        'select2': {
            deps: ['bootstrap', '../js/select2.min.js', 'css!../css/select2.css']
        },
        'cookie': {
            exports: 'Cookie',
        },
        'colorpicker': {
            exports: '$',
            deps: ['css!../css/spectrum.min.css']
        },
        'datetimepicker': {
            exports: '',
            deps: ['jquery', 'moment', 'bootstrap', 'css!../css/bootstrap-datetimepicker.min.css']
        },
        'daterangepicker': {
            exports: '$',
            deps: ['jquery', 'moment', 'bootstrap', 'css!../css/daterangepicker.min.css']
        },
        'kindeditor': {
            deps: ['kindeditor.main', 'css!../component/kindeditor/themes/default/default.css']
        },
        'validator': {
            exports: '$',
            deps: ['bootstrap', 'css!../css/bootstrapValidator.min.css']
        },
        'clockpicker': {
            exports: '$',
            deps: ['bootstrap', 'css!../component/clockpicker/bootstrap-clockpicker.min.css']
        },
        'json2': {
            exports: 'JSON'
        }
    }
});












