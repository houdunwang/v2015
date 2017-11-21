/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.plugins.add('videoforpc',{requires:['iframedialog'],init:function(a){var b=300,c=660;CKEDITOR.dialog.addIframe('MyVideoDialog','从视频库插入视频','index.php?m=video&c=video_for_ck&a=init',c,b,function(){},{onOk:function(){}});a.addCommand('MyVideo',new CKEDITOR.dialogCommand('MyVideoDialog'));a.ui.addButton('MyVideo',{label:'插入视频/上传视频',command:'MyVideo',icon:this.path+'v.png'});}});
