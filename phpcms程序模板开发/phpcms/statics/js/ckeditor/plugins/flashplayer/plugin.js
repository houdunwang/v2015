CKEDITOR.plugins.add('flashplayer', {
	init: function(editor) {
		//plugin code goes here
		var pluginName = 'flashplayer';
		CKEDITOR.dialog.add('flashplayer', 　function(a) {
			var b = a.config;
			var　 escape　 = 　 function(value) {　　　　　　　　
				return　 value;　　　　
			};　　　　
			return　 {　　　　　　　　
				title: 　 '插入FLV,MP4视频',
				　　　　　　　　resizable: 　CKEDITOR.DIALOG_RESIZE_BOTH,
				　　　　　　　　minWidth: 350,
				minHeight: 200,
				　　　　　　　　contents: 　[{　　　　　　　　　　
					id: 'info',
					label: '常规',
					accessKey: 'P',
					elements: [{
						type: 'hbox',
						widths: ['80%', '20%'],
						children: [{
							id: 'src',
							type: 'text',
							label: '源文件'
						}, {
							type: 'button',
							id: 'browse',
							filebrowser: 'info:src',
							hidden: true,
							align: 'center',
							label: '浏览服务器'
						}]
					}, {
						type: 'hbox',
						widths: ['35%', '35%', '30%'],
						children: [{
								type: 　 'text',
								　　　　　　　　　　　　　　label: 　 '视频宽度',
								　　　　　　　　　　　　　　id: 　 'mywidth',
								　　　　　　　　　　　　　　'default': 　 '480px',
								　　　　　　　　　　　　　　style: 　 'width:50px'
							}, {
								type: 　 'text',
								　　　　　　　　　　　　　　label: 　 '视频高度',
								　　　　　　　　　　　　　　id: 　 'myheight',
								　　　　　　　　　　　　　　'default': 　 '270px',
								　　　　　　　　　　　　　　style: 　 'width:50px'
							}, {
								type: 　 'select',
								　　　　　　　　　　　　　　label: 　 '自动播放',
								　　　　　　　　　　　　　　id: 　 'myautoplay',
								　　　　　　　　　　　　　　required: 　true,
								　　　　　　　　　　　　　　'default': 　 '0',
								　　　　　　　　　　　　　　items: 　[
									['是', 　'1'], 　
									['否', 　'0']
								]
							}] //children finish
					}, {　　　　　　　　　　
						type: 　 'text',
						　　　　　　　　　　　　　　style: 　 'width:300px;',
						　　　　　　　　　　　　　　label: 　 '视频截图',
													'default': 　 '',
						　　　　　　　　　　　　　　id: 　 'mythumbnail'　　　　　　　　　　
					}]
				}, {
					id: 'Upload',
					hidden: true,
					filebrowser: 'uploadButton',
					label: '上传视频',
					elements: [{
						type: 'file',
						id: 'upload',
						label: '上传视频',
						size: 38
					}, {
						type: 'fileButton',
						id: 'uploadButton',
						label: '上传到服务器上',
						filebrowser: 'info:src',
						'for': ['Upload', 'upload'] //'page_id', 'element_id'
					}]　　　　　　　　
				}],
				　　　　　　　　onOk: 　 function() {　　　　　　　　　　　　
					mywidth　 = 　this.getValueOf('info', 　'mywidth');　　　　　　　　　　　　
					myheight　 = 　this.getValueOf('info', 　'myheight');　　　　　　　　　　　　
					myautoplay　 = 　this.getValueOf('info', 　'myautoplay');　　　　　　　　　　　　
					mysrc　 = 　this.getValueOf('info', 　'src');
					mythumbnail	　　　 = 　this.getValueOf('info', 　'mythumbnail');　　　　　　　　　　
					html　 = 　''　 + 　escape(mysrc)　 + 　'';					　　　　　　　　　　　　
					a.insertHtml("<embed type=\"application/x-shockwave-flash\" src=\"" + b.flv_path + "player\/player.swf\" id=\"f4Player\" width=\""　 + 　mywidth　 + 　"\" height=\""　 + 　myheight　 + 　"\" flashvars=\"autoplay=" + myautoplay + "&skin=" + b.flv_path + "player\/skin.swf&video="　 + 　html　 + 　"&thumbnail="+mythumbnail+"\" allowscriptaccess=\"always\" allowfullscreen=\"true\" bgcolor=\"#000000\"></embed>");　　　　　　　　
				},
				　　　　　　　　onLoad: 　 function() {　　　　　　　　}　　　　
			};
		});
		editor.config.flv_path = editor.config.flv_path || (this.path);
		editor.addCommand(pluginName, new CKEDITOR.dialogCommand(pluginName));
		editor.ui.addButton('flashplayer', {
			label: '插入Flv视频',
			command: pluginName,
			icon: this.path + 'icon.png'
		});
	}
});