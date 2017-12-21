/**
 * 前端模块配置
 * @author 向军 <2300071698@qq.com>
 */

// window.hdjs = Object.assign({
//     node_modules: '', base: '/node_modules/hdjs/', uploader: '', filesLists: '', hdjs: ''
// }, window.hdjs);
require.config({
    urlArgs: 'version=1.2.100',
    baseUrl: window.hdjs.base,
    paths: {
        hdjs: 'dist/static/hdjs',
        css: 'dist/static/requirejs/css.min',
        domReady: 'dist/static/requirejs/domReady',
        vue: 'https://cdn.bootcss.com/vue/2.4.2/vue',
        Aliplayer: 'http://g.alicdn.com/de/prismplayer/2.0.1/aliplayer-min',
        //微信JSSDK
        jweixin: 'http://res.wx.qq.com/open/js/jweixin-1.2.0',
        //百度编辑器
        ueditor: 'dist/static/package/ueditor/ueditor.all',
        //代码高亮
        prism: 'dist/static/package/prism/prism',
        //剪贴版
        ZeroClipboard: 'https://cdn.bootcss.com/zeroclipboard/2.3.0/ZeroClipboard.min',
        //上传组件
        webuploader: 'dist/static/package/webuploader/dist/webuploader',
        md5: 'https://cdn.bootcss.com/blueimp-md5/2.10.0/js/md5.min',
        bootstrap: 'https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min',
        lodash: 'https://cdn.bootcss.com/lodash.js/4.17.4/lodash.min',
        //复选框切换
        bootstrapswitch: 'https://cdn.bootcss.com/bootstrap-switch/4.0.0-alpha.1/js/bootstrap-switch.min',
        select2: 'https://cdn.bootcss.com/select2/4.0.6-rc.1/js/select2.min',
        bootstrapfilestyle: 'https://cdn.bootcss.com/bootstrap-filestyle/2.1.0/bootstrap-filestyle.min',
        moment: 'https://cdn.bootcss.com/moment.js/2.14.0/moment.min',
        'jquery-mousewheel': 'https://cdn.bootcss.com/jquery-mousewheel/3.1.13/jquery.mousewheel.min',
        //markdown编辑器edit.md设置
        jquery: "https://cdn.bootcss.com/jquery/3.2.1/jquery.min",
        marked: "dist/static/package/editor.md/lib/marked.min",
        prettify: "dist/static/package/editor.md/lib/prettify.min",
        raphael: "dist/static/package/editor.md/lib/raphael.min",
        underscore: "dist/static/package/editor.md/lib/underscore.min",
        flowchart: "dist/static/package/editor.md/lib/flowchart.min",
        jqueryflowchart: "dist/static/package/editor.md/lib/jquery.flowchart.min",
        sequenceDiagram: "dist/static/package/editor.md/lib/sequence-diagram.min",
        katex: "https://cdn.bootcss.com/KaTeX/0.1.1/katex.min",
        codemirror: "https://cdn.bootcss.com/codemirror/5.31.0/codemirror",
        editormd: "dist/static/package/editor.md/lib/../editormd.amd",
        util: "dist/static/component/util",
        oss: "dist/static/component/oss",
    },
    shim: {
        hdjs: {
            deps: ['css!dist/static/css/hdjs.css']
        },
        bootstrap: {
            exports: '$',
            deps: ['jquery', 'css!https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css',
                'css!https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css']
        },
        select2: {
            exports: '$',
            deps: ['jquery', 'bootstrap']
        },
        bootstrapswitch: {
            exports: '$',
            deps: ['bootstrap', 'css!https://cdn.bootcss.com/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css']
        },
        webuploader: {
            deps: ['css!dist/static/package/webuploader/css/webuploader.css']
        },
        prism: {
            deps: ['css!dist/static/package/prism/prism.css']
        },
        ueditor: {
            deps: ['ZeroClipboard', 'dist/static/package/ueditor/ueditor.config']
        },
        editormd: {
            deps: [
                "css!dist/static/package/editor.md/css/editormd.min.css",
                "css!dist/static/package/editor.md/lib/codemirror/codemirror.min.css"
            ]
        }
    },
    waitSeconds: 30
});
require([
    'jquery',
    'https://cdn.bootcss.com/axios/0.17.1/axios.min.js',
    'lodash',
    'bootstrap'
], function ($, axios, _) {
    window.$ = window.jQuery = $;
    window._ = _;
    console.info('后盾人 人人做后盾  www.houdunren.com');
    //将属性hdjs元素显示出来
    $("[hd-cloak]").show();
    $("[hd-hide]").hide();
    $("[hd-loading]").hide();
    window.axios = axios;
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    var token = document.head.querySelector('meta[name="csrf-token"]');

    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        //为异步请求设置CSRF令牌
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    } else {
        // console.error('CSRF token not found');
    }
})