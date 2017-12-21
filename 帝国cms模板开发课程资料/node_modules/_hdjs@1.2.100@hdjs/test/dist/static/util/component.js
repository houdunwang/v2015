define([
    "hdjs",
    "jQuery",
], function (hdjs, $) {
    return {
        markdown: function (elem, options) {
            require([
                "editormd",
                "dist/static/editor.md/languages/zh-tw",
                "dist/static/editor.md/plugins/link-dialog/link-dialog",
                "dist/static/editor.md/plugins/reference-link-dialog/reference-link-dialog",
                "dist/static/editor.md/plugins/image-dialog/image-dialog",
                "dist/static/editor.md/plugins/code-block-dialog/code-block-dialog",
                "dist/static/editor.md/plugins/table-dialog/table-dialog",
                "dist/static/editor.md/plugins/emoji-dialog/emoji-dialog",
                "dist/static/editor.md/plugins/goto-line-dialog/goto-line-dialog",
                "dist/static/editor.md/plugins/help-dialog/help-dialog",
                "dist/static/editor.md/plugins/html-entities-dialog/html-entities-dialog",
                "dist/static/editor.md/plugins/preformatted-text-dialog/preformatted-text-dialog"], function (editormd) {
                options = Object.assign({
                    syncScrolling: "single",
                    path: window.hdjs.base + "/dist/static/editor.md/lib/",
                    width: "100%",
                    height: 500,
                    toolbarAutoFixed: false,
                    toolbarIcons: function () {
                        return [
                            "undo", "redo", "|",
                            "bold", "del", "italic", "quote", "ucwords", "uppercase", "lowercase", "|",
                            "h1", "h2", "h3", "h4", "h5", "h6", "|",
                            "list-ul", "list-ol", "hr", "|",
                            "link", "reference-link", "hdimage", "code", "preformatted-text", "code-block", "table", "datetime", "emoji", "html-entities", "pagebreak", "|",
                            "goto-line", "watch", "preview", "fullscreen", "clear", "search", "|",
                            "help"
                        ]
                    },
                    // toolbarIcons : "full", // You can also use editormd.toolbarModes[name] default list, values: full, simple, mini.
                    toolbarIconsClass: {
                        hdimage: "fa-picture-o"  // 指定一个FontAawsome的图标类
                    },
                    // 自定义工具栏按钮的事件处理
                    toolbarHandlers: {
                        /**
                         * @param {Object}      cm         CodeMirror对象
                         * @param {Object}      icon       图标按钮jQuery元素对象
                         * @param {Object}      cursor     CodeMirror的光标对象，可获取光标所在行和位置
                         * @param {String}      selection  编辑器选中的文本
                         */
                        hdimage: function (cm, icon, cursor, selection) {
                            hdjs.image(function (images) {
                                var str = '![](' + images[0] + ')';
                                cm.replaceSelection(str);
                            })
                        }
                    },
                    lang: {
                        toolbar: {
                            hdimage: "图片上传",
                        }
                    }
                }, options);
                return editormd(elem, options);
            })
        },
        markdownToHTML: function (elem, options) {
            require(['editormd'], function (editormd) {
                options = Object.assign({
                    htmlDecode: "style,script,iframe",  // you can filter tags decode
                    emoji: true,
                    taskList: true,
                    tex: true,  // 默认不解析
                    flowChart: true,  // 默认不解析
                    sequenceDiagram: true,  // 默认不解析
                }, options);
                return editormd.markdownToHTML("editormd", {
                    htmlDecode: "style,script,iframe",  // you can filter tags decode
                    emoji: true,
                    taskList: true,
                    tex: true,  // 默认不解析
                    flowChart: true,  // 默认不解析
                    sequenceDiagram: true,  // 默认不解析
                });
            })
        }
    }
})