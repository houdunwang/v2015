/**
 * 前端模块配置
 * @author 向军 <2300071698@qq.com>
 */
require.config({
    baseUrl: hdjs.base + '/app',
    paths: {
        //'async': '../js/async',
        'require.css': '../js/require.css.min',
        'swiper': '../js/swiper-3.3.1.min',
        //阿里云oss
        'oss': '../component/oss/oss',
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
        'vue': '../js/vue.min',
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
        //右键菜单
        'bootstrapContextmenu': '../js/bootstrap-contextmenu.min',
        'map': 'http://api.map.baidu.com/getscript?v=2.0&ak=WcqLYXBH2tHLhYNfPNpZCD4s&services=&t=20160708193109',
        //HDCMS
        'wapeditor': '../../../module/ucenter/template/js/wapeditor',
        //vue.js
        'vue': '../js/vue',
        //http请求库
        'axios': '../js/axios.min',
        //markdown编辑器edit.md设置
        marked: "../component/editormd/lib/marked.min",
        prettify: "../component/editormd/lib/prettify.min",
        raphael: "../component/editormd/lib/raphael.min",
        flowchart: "../component/editormd/lib/flowchart.min",
        jqueryflowchart: "../component/editormd/lib/jquery.flowchart.min",
        sequenceDiagram: "../component/editormd/lib/sequence-diagram.min",
        katex: "http://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.1.1/katex.min",
        editormd: "../component/editormd/editormd.amd"

    },
    shim: {
        'bootstrapContextmenu': {
            exports: '$',
            deps: ['bootstrap']
        },
        'map': {
            exports: 'BMap'
        },
        'ngSortable': {
            deps: ['Sortable']
        },
        'editormd': {
            deps: [
                "css!../component/editormd/css/editormd.min.css",
                "css!../component/editormd/lib/codemirror/codemirror.min.css",
                "css!../component/editormd/lib/codemirror/codemirror.min.css",
                // "jquery",
                // "../component/editormd/languages/en",
                // "../component/editormd/plugins/link-dialog/link-dialog",
                // "../component/editormd/plugins/reference-link-dialog/reference-link-dialog",
                // "../component/editormd/plugins/image-dialog/image-dialog",
                // "../component/editormd/plugins/code-block-dialog/code-block-dialog",
                // "../component/editormd/plugins/table-dialog/table-dialog",
                // "../component/editormd/plugins/emoji-dialog/emoji-dialog",
                // "../component/editormd/plugins/goto-line-dialog/goto-line-dialog",
                // "../component/editormd/plugins/help-dialog/help-dialog",
                // "../component/editormd/plugins/html-entities-dialog/html-entities-dialog",
                // "../component/editormd/plugins/preformatted-text-dialog/preformatted-text-dialog",
                // 'css!../component/editormd/lib/codemirror/addon/fold/foldgutter.css'
            ]
        },
        'oss': {
            deps: ['../component/oss/plupload-2.1.2/js/plupload.full.min']
        },
        'jquery': {
            exports: '$',
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
            deps: ['jquery', 'css!../css/swiper-3.3.1.min.css']
        },
        'bootstrap': {
            exports: '$',
            deps: ['jquery', 'css!../css/bootstrap.min.css', 'css!../css/font-awesome.min.css']
        },
        'filestyle': {
            exports: '$',
            deps: ['bootstrap']
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
            deps: ['css!../component/webuploader/webuploader.css', 'css!../component/webuploader/style.css', 'css!../css/app.css']
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
    },
    // waitSeconds: 30
});












