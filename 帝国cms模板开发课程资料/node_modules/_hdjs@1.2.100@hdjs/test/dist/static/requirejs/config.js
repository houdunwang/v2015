/**
 * 前端模块配置
 * @author 向军 <2300071698@qq.com>
 */
window.hdjs = Object.assign({
    node_modules: '', base: '/node_modules/hdjs/', uploader: '', filesLists: '', hdjs: ''
}, window.hdjs);
require.config({
    urlArgs: 'version=1.2.90',
    baseUrl: window.hdjs.base,
    paths: {
        hdjs: 'dist/hdjs',
        css: 'dist/static/requirejs/css.min',
        domReady: 'dist/static/requirejs/domReady',
        vue: 'https://cdn.bootcss.com/vue/2.4.2/vue',
        Aliplayer: 'http://g.alicdn.com/de/prismplayer/2.0.1/aliplayer-min',
        //代码高亮
        prism: 'dist/static/prism/prism',
        //markdown编辑器edit.md设置
        jQuery: "https://cdn.bootcss.com/jquery/3.2.1/jquery.min",
        marked: "dist/static/editor.md/lib/marked.min",
        prettify: "dist/static/editor.md/lib/prettify.min",
        raphael: "dist/static/editor.md/lib/raphael.min",
        underscore: "dist/static/editor.md/lib/underscore.min",
        flowchart: "dist/static/editor.md/lib/flowchart.min",
        jqueryflowchart: "dist/static/editor.md/lib/jquery.flowchart.min",
        sequenceDiagram: "dist/static/editor.md/lib/sequence-diagram.min",
        katex: "https://cdn.bootcss.com/KaTeX/0.1.1/katex.min",
        codemirror: "https://cdn.bootcss.com/codemirror/5.31.0/codemirror",
        editormd: "dist/static/editor.md/lib/../editormd.amd",
        util: "dist/static/util/component",
    },
    shim: {
        hdjs: {
            deps: ['css!dist/hdjs.css','dist/vendor']
        },
        prism: {
            deps: [
                'css!dist/static/prism/prism.css'
            ]
        },
        editormd: {
            deps: [
                "css!dist/static/editor.md/css/editormd.min.css",
                "css!dist/static/editor.md/lib/codemirror/codemirror.min.css"
            ]
        }
    },
    waitSeconds: 30
});