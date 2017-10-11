import '../component/ueditor/ueditor.config'
import '../component/ueditor/ueditor.all'
import ZeroClipboard from 'zeroclipboard'
import fileUploader from './fileUploader'
window.ZeroClipboard = ZeroClipboard;
export default (id, opt, callback, buttons) => {
    var options = Object.assign({
        UEDITOR_HOME_URL: window.hdjs.base + '/dist/static/ueditor/',
        serverUrl: window.hdjs.ueditor,
        'elementPathEnabled': false,
        'initialFrameHeight': 200,
        'focus': false,
        'maximumWords': 9999999999999,
        'autoClearinitialContent': false,
        'toolbars': [[
            'fullscreen', 'source', '|', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor','hdimage', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
            'emotion', 'music', 'attachment', 'map', 'insertframe', 'insertcode', 'pagebreak', 'template', 'background', '|',
            'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
            'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
            'print', 'preview', 'searchreplace'
        ]],
        autoHeightEnabled: false,//自动增高
        autoFloatEnabled: false,
    }, opt);
    var editor = UE.getEditor(id, options);
    UE.commands['hdimage'] = {
        execCommand: function (cmdName, align) {
            var This= this;
            fileUploader.show(function (imgs) {
                if (imgs.length > 0) {
                    var imglist = [];
                    for (i in imgs) {
                        imglist.push({
                            'src': imgs[i],
                            'max-width': '100%',
                        });
                    }
                    This.execCommand('insertimage', imglist);
                }
            }, {type: 'image', multiple: true, extensions: 'gif,jpg,jpeg,bmp,png'});
        }
    };
    // UE.registerUI('image' + id, function (editor, uiName) {
    //     //注册按钮执行时的command命令，使用命令默认就会带有回退操作
    //     editor.registerCommand(uiName, {
    //         execCommand: function () {
    //             fileUploader.show(function (imgs) {
    //                 if (imgs.length > 0) {
    //                     var imglist = [];
    //                     for (i in imgs) {
    //                         imglist.push({
    //                             'src': imgs[i],
    //                             'max-width': '100%',
    //                         });
    //                     }
    //                     editor.execCommand('insertimage', imglist);
    //                 }
    //             }, {type: 'image', multiple: true, extensions: 'gif,jpg,jpeg,bmp,png'});
    //         }
    //     });
    //     //创建一个button
    //     var btn = new UE.ui.Button({
    //         //按钮的名字
    //         name: uiName,
    //         //提示
    //         title: uiName,
    //         //添加额外样式，指定icon图标，这里默认使用一个重复的icon
    //         cssRules: 'background-position: -726px -77px',
    //         //点击时执行的命令
    //         onclick: function () {
    //             //这里可以不用执行命令,做你自己的操作也可
    //             editor.execCommand(uiName);
    //         }
    //     });
    //     //当点到编辑内容上时，按钮要做的状态反射
    //     editor.addListener('selectionchange', function () {
    //         var state = editor.queryCommandState(uiName);
    //         if (state == -1) {
    //             btn.setDisabled(true);
    //             btn.setChecked(false);
    //         } else {
    //             btn.setDisabled(false);
    //             btn.setChecked(state);
    //         }
    //     });
    //     return btn;
    // }, 19, id);
    if ($.isFunction(callback)) {
        callback(editor);
    }
    return editor;
}