
	/*
	 *  在jquery.suggest 1.1基础上针对中文输入的特点做了部分修改，下载原版请到jquery插件库
	 *  修改者：wangshuai
	 *
	 *  修改部分已在文中标注
	 *
	 *
	 *	jquery.suggest 1.1 - 2007-08-06
	 *
	 *	Uses code and techniques from following libraries:
	 *	1. http://www.dyve.net/jquery/?autocomplete
	 *	2. http://dev.jquery.com/browser/trunk/plugins/interface/iautocompleter.js
	 *
	 *	All the new stuff written by Peter Vulgaris (www.vulgarisoip.com)
	 *	Feel free to do whatever you want with this file
	 *
	 */

	(function($) {

		$.suggest = function(input, options) {
			var $input = $(input).attr("autocomplete", "off");
			var $results = $("#sr_infos");

			var timeout = false;		// hold timeout ID for suggestion results to appear
			var prevLength = 0;			// last recorded length of $input.val()

			$input.blur(function() {
				setTimeout(function() { $results.hide() }, 200);
			});

			$results.mouseover(function() {
				$("#sr_infos ul li").removeClass(options.selectClass);
			})

			// help IE users if possible
			try {
				$results.bgiframe();
			} catch(e) { }

			// I really hate browser detection, but I don't see any other way

//修改开始
//下面部分在作者原来代码的基本上针对中文输入的特点做了些修改
			if ($.browser.mozilla)
				$input.keypress(processKey2);	// onkeypress repeats arrow keys in Mozilla/Opera
			else
				$input.keydown(processKey2);		// onkeydown repeats arrow keys in IE/Safari*/
			//这里是自己改为keyup事件
			$input.keyup(processKey);
//修改结束

			function processKey(e) {

				// handling up/down/escape requires results to be visible
				// handling enter/tab requires that AND a result to be selected
				if (/^32$|^9$/.test(e.keyCode) && getCurrentResult()) {

		            if (e.preventDefault)
		                e.preventDefault();
					if (e.stopPropagation)
		                e.stopPropagation();

	                e.cancelBubble = true;
	                e.returnValue = false;
					selectCurrentResult();

				} else if ($input.val().length != prevLength) {
					if (timeout)
						clearTimeout(timeout);
					timeout = setTimeout(suggest, options.delay);
					prevLength = $input.val().length;
				}
			}
//此处针对上面介绍的修改增加的函数
			function processKey2(e) {

				// handling up/down/escape requires results to be visible
				// handling enter/tab requires that AND a result to be selected
				if (/27$|38$|40$|13$/.test(e.keyCode) && $results.is(':visible')) {

		            if (e.preventDefault)
		                e.preventDefault();
					if (e.stopPropagation)
		                e.stopPropagation();

	                e.cancelBubble = true;
	                e.returnValue = false;
					switch(e.keyCode) {

						case 38: // up
							prevResult();
							break;

						case 40: // down
							nextResult();
							break;

						case 27: //	escape
							$results.hide();
							break;

						case 13: //	enter
							$currentResult = getCurrentResult();
							if ($currentResult) {
								$input.val($currentResult.text());
								window.location.href='?m=search&c=index&a=init&q='+$currentResult.text();
							}
							
							break;
					}

				} else if ($input.val().length != prevLength) {

					if (timeout)
						clearTimeout(timeout);
					timeout = setTimeout(suggest, options.delay);
					prevLength = $input.val().length;

				}
			}


			function suggest() {
				var q = $input.val().replace(/ /g, '');
				if (q.length >= options.minchars) {
					$.getScript(options.source+'&q='+q, function(){
					});
					$results.hide();
					//var items = parseTxt(txt, q);
					//displayItems(items);
					$results.show();

				} else {
					$results.hide();
				}
			}

			function displayItems(items) {
				if (!items)
					return;
				if (!items.length) {
					$results.hide();
					return;
				}
				var html = '';
				for (var i = 0; i < items.length; i++)
					html += '<li>' + items[i] + '</li>';

				$results.html(html).show();

				$results
					.children('li')
					.mouseover(function() {
						$results.children('li').removeClass(options.selectClass);
						$(this).addClass(options.selectClass);
					})
					.click(function(e) {
						e.preventDefault();
						e.stopPropagation();
						selectCurrentResult();
					});

			}

			function getCurrentResult() {
				if (!$results.is(':visible'))
					return false;
				//var $currentResult = $results.children('li.' + options.selectClass);
				var $currentResult = $("#sr_infos ul li."+ options.selectClass);
				if (!$currentResult.length)
					$currentResult = false;
				return $currentResult;
			}

			function selectCurrentResult() {
				$currentResult = getCurrentResult();
				if ($currentResult) {
					$input.val($currentResult.text());
					$results.hide();
					if (options.onSelect)
						options.onSelect.apply($input[0]);
				}
			}
			function nextResult() {
				$currentResult = getCurrentResult();
				if ($currentResult) {
					$currentResult.removeClass(options.selectClass).next().addClass(options.selectClass);
				} else {
					$("#sr_infos ul li:first-child'").addClass(options.selectClass);
					//$results.children('li:first-child').addClass(options.selectClass);
				}
			}

			function prevResult() {
				$currentResult = getCurrentResult();
				if ($currentResult)
					$currentResult.removeClass(options.selectClass).prev().addClass(options.selectClass);
				else
					//$results.children('li:last-child').addClass(options.selectClass);
					$("#sr_infos ul li:last-child'").addClass(options.selectClass);
				
			}
		}

		$.fn.suggest = function(source, options) {
			if (!source)
				return;
			options = options || {};
			options.source = source;
			options.delay = options.delay || 100;
			options.resultsClass = options.resultsClass || 'ac_results';
			options.selectClass = options.selectClass || 'ac_over';
			options.matchClass = options.matchClass || 'ac_match';
			options.minchars = options.minchars || 1;
			options.delimiter = options.delimiter || '\n';
			options.onSelect = options.onSelect || false;

			this.each(function() {
				new $.suggest(this, options);
			});

			return this;
		};
	})(jQuery);