/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

(function(){var b={exec:function(d){var e='capture';ext_editor=d.name;if(CKEDITOR.env.ie)try{var f=new ActiveXObject('WEBCAPTURECTRL.WebCaptureCtrlCtrl.1');document.getElementById('PC_Capture').ShowCaptureWindow();}catch(g){CKEDITOR.dialog.add(e,function(h){var i={title:d.lang.capture.notice,minWidth:350,minHeight:80,contents:[{id:'tab1',label:'Label',title:'Title',padding:0,elements:[{type:'html',html:d.lang.capture.notice_tips}]}],buttons:[CKEDITOR.dialog.cancelButton]};return i;});d.addCommand(e,new CKEDITOR.dialogCommand(e));d.execCommand(e);}else{alert(d.lang.capture.unsport_tips);return false;}}},c='capture';CKEDITOR.plugins.add('capture',{lang:['zh-cn'],init:function(d){if(CKEDITOR.env.ie){d.addCommand(c,b);d.ui.addButton('Capture',{label:d.lang.capture.title,command:c,icon:this.path+'capture.jpg'});}}});})();function pc_screen(b){var c=CKEDITOR.instances[ext_editor],d=c.getData(),e='<img src='+b+'><BR>';c.insertHtml(e);};
