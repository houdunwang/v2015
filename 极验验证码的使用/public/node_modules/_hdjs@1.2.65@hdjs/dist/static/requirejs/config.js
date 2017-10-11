/**
 * 前端模块配置
 * @author 向军 <2300071698@qq.com>
 */
if (!window.hdjs) {
    window.hdjs = {node_modules: '', base: '', uploader: '', filesLists: ''};
}
if (!window.hdjs.base) {
    window.hdjs.base = '/node_modules/hdjs';
}
require.config({
    urlArgs: 'version=1.2.63',
    baseUrl: window.hdjs.base,
    paths: {
        hdjs: window.hdjs.base + '/dist/hdjs',
        css: window.hdjs.base + '/dist/static/requirejs/css.min',
        domReady: window.hdjs.base + '/dist/static/requirejs/domReady',
        vue: 'https://cdn.bootcss.com/vue/2.4.2/vue'
    },
    shim: {
        'hdjs': {
            deps: ['css!dist/hdjs.css']
        }
    },
    waitSeconds: 30
});










