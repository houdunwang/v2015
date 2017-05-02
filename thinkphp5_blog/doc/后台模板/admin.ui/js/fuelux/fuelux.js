
/*
 * Fuel UX Checkbox
 * https://github.com/ExactTarget/fuelux
 *
 * Copyright (c) 2012 ExactTarget
 * Licensed under the MIT license.
 */

+function ($) { "use strict";


	// CHECKBOX CONSTRUCTOR AND PROTOTYPE

	var Checkbox = function (element, options) {

		this.$element = $(element);
		this.options = $.extend({}, $.fn.checkbox.defaults, options);

		// cache elements
		this.$label = this.$element.parent();
		this.$icon = this.$label.find('i');
		this.$chk = this.$label.find('input[type=checkbox]');

		// set default state
		this.setState(this.$chk);

		// handle events
		this.$chk.on('change', $.proxy(this.itemchecked, this));
	};

	Checkbox.prototype = {

		constructor: Checkbox,

		setState: function ($chk) {
			var checked = $chk.is(':checked');
			var disabled = $chk.is(':disabled');

			// reset classes
			this.$icon.removeClass('checked').removeClass('disabled');

			// set state of checkbox
			if (checked === true) {
				this.$icon.addClass('checked');
			}
			if (disabled === true) {
				this.$icon.addClass('disabled');
			}
		},

		enable: function () {
			this.$chk.attr('disabled', false);
			this.$icon.removeClass('disabled');
		},

		disable: function () {
			this.$chk.attr('disabled', true);
			this.$icon.addClass('disabled');
		},

		toggle: function () {
			this.$chk.click();
		},

		itemchecked: function (e) {
			var chk = $(e.target);
			this.setState(chk);
		}
	};


	// CHECKBOX PLUGIN DEFINITION

	$.fn.checkbox = function (option, value) {
		var methodReturn;

		var $set = this.each(function () {
			var $this = $(this);
			var data = $this.data('checkbox');
			var options = typeof option === 'object' && option;

			if (!data) $this.data('checkbox', (data = new Checkbox(this, options)));
			if (typeof option === 'string') methodReturn = data[option](value);
		});

		return (methodReturn === undefined) ? $set : methodReturn;
	};

	$.fn.checkbox.defaults = {};

	$.fn.checkbox.Constructor = Checkbox;


	// CHECKBOX DATA-API

	$(function () {
		$(window).on('load', function () {
			//$('i.checkbox').each(function () {
			$('.checkbox-custom > input[type=checkbox]').each(function () {
				var $this = $(this);
				if ($this.data('checkbox')) return;
				$this.checkbox($this.data());
			});
		});
	});

}(window.jQuery);

/*
 * Fuel UX Utilities
 * https://github.com/ExactTarget/fuelux
 *
 * Copyright (c) 2012 ExactTarget
 * Licensed under the MIT license.
 */

+function ($) { "use strict";

	// custom case-insensitive match expression
	function fuelTextExactCI(elem, text) {
		return (elem.textContent || elem.innerText || $(elem).text() || '').toLowerCase() === (text || '').toLowerCase();
	}

	$.expr[':'].fuelTextExactCI = $.expr.createPseudo ?
		$.expr.createPseudo(function (text) {
			return function (elem) {
				return fuelTextExactCI(elem, text);
			};
		}) :
		function (elem, i, match) {
			return fuelTextExactCI(elem, match[3]);
		};

}(window.jQuery);
/*
 * Fuel UX Combobox
 * https://github.com/ExactTarget/fuelux
 *
 * Copyright (c) 2012 ExactTarget
 * Licensed under the MIT license.
 */

+function ($) { "use strict";

	// COMBOBOX CONSTRUCTOR AND PROTOTYPE

	var Combobox = function (element, options) {
		this.$element = $(element);
		this.options = $.extend({}, $.fn.combobox.defaults, options);
		this.$element.on('click', 'a', $.proxy(this.itemclicked, this));
		this.$element.on('change', 'input', $.proxy(this.inputchanged, this));
		this.$input = this.$element.find('input');
		this.$button = this.$element.find('.btn');

		// set default selection
		this.setDefaultSelection();
	};

	Combobox.prototype = {

		constructor: Combobox,

		selectedItem: function () {
			var item = this.$selectedItem;
			var data = {};

			if (item) {
				var txt = this.$selectedItem.text();
				data = $.extend({ text: txt }, this.$selectedItem.data());
			}
			else {
				data = { text: this.$input.val()};
			}

			return data;
		},

		selectByText: function (text) {
			var selector = 'li:fuelTextExactCI(' + text + ')';
			this.selectBySelector(selector);
		},

		selectByValue: function (value) {
			var selector = 'li[data-value="' + value + '"]';
			this.selectBySelector(selector);
		},

		selectByIndex: function (index) {
			// zero-based index
			var selector = 'li:eq(' + index + ')';
			this.selectBySelector(selector);
		},

		selectBySelector: function (selector) {
			var $item = this.$element.find(selector);

			if (typeof $item[0] !== 'undefined') {
				this.$selectedItem = $item;
				this.$input.val(this.$selectedItem.text());
			}
			else {
				this.$selectedItem = null;
			}
		},

		setDefaultSelection: function () {
			var selector = 'li[data-selected=true]:first';
			var item = this.$element.find(selector);

			if (item.length > 0) {
				// select by data-attribute
				this.selectBySelector(selector);
				item.removeData('selected');
				item.removeAttr('data-selected');
			}
		},

		enable: function () {
			this.$input.removeAttr('disabled');
			this.$button.removeClass('disabled');
		},

		disable: function () {
			this.$input.attr('disabled', true);
			this.$button.addClass('disabled');
		},

		itemclicked: function (e) {
			this.$selectedItem = $(e.target).parent();

			// set input text and trigger input change event marked as synthetic
			this.$input.val(this.$selectedItem.text()).trigger('change', { synthetic: true });

			// pass object including text and any data-attributes
			// to onchange event
			var data = this.selectedItem();

			// trigger changed event
			this.$element.trigger('changed', data);

			e.preventDefault();
		},

		inputchanged: function (e, extra) {

			// skip processing for internally-generated synthetic event
			// to avoid double processing
			if (extra && extra.synthetic) return;

			var val = $(e.target).val();
			this.selectByText(val);

			// find match based on input
			// if no match, pass the input value
			var data = this.selectedItem();
			if (data.text.length === 0) {
				data = { text: val };
			}

			// trigger changed event
			this.$element.trigger('changed', data);

		}

	};


	// COMBOBOX PLUGIN DEFINITION

	$.fn.combobox = function (option, value) {
		var methodReturn;

		var $set = this.each(function () {
			var $this = $(this);
			var data = $this.data('combobox');
			var options = typeof option === 'object' && option;

			if (!data) $this.data('combobox', (data = new Combobox(this, options)));
			if (typeof option === 'string') methodReturn = data[option](value);
		});

		return (methodReturn === undefined) ? $set : methodReturn;
	};

	$.fn.combobox.defaults = {};

	$.fn.combobox.Constructor = Combobox;


	// COMBOBOX DATA-API

	$(function () {

		$(window).on('load', function () {
			$('.combobox').each(function () {
				var $this = $(this);
				if ($this.data('combobox')) return;
				$this.combobox($this.data());
			});
		});

		$('body').on('mousedown.combobox.data-api', '.combobox', function (e) {
			var $this = $(this);
			if ($this.data('combobox')) return;
			$this.combobox($this.data());
		});
	});

}(window.jQuery);

/*
 * Fuel UX Datagrid
 * https://github.com/ExactTarget/fuelux
 *
 * Copyright (c) 2012 ExactTarget
 * Licensed under the MIT license.
 */

+function ($) { "use strict";

	// Relates to thead .sorted styles in datagrid.less
	var SORTED_HEADER_OFFSET = 22;

	// DATAGRID CONSTRUCTOR AND PROTOTYPE

	var Datagrid = function (element, options) {
		this.$element = $(element);
		this.$thead = this.$element.find('thead');
		this.$tfoot = this.$element.find('tfoot');
		this.$footer = this.$element.find('tfoot th');
		this.$footerchildren = this.$footer.children().show().css('visibility', 'hidden');
		this.$topheader = this.$element.find('thead th');
		this.$searchcontrol = this.$element.find('.datagrid-search');
		this.$filtercontrol = this.$element.find('.filter');
		this.$pagesize = this.$element.find('.grid-pagesize');
		this.$pageinput = this.$element.find('.grid-pager input');
		this.$pagedropdown = this.$element.find('.grid-pager .dropdown-menu');
		this.$prevpagebtn = this.$element.find('.grid-prevpage');
		this.$nextpagebtn = this.$element.find('.grid-nextpage');
		this.$pageslabel = this.$element.find('.grid-pages');
		this.$countlabel = this.$element.find('.grid-count');
		this.$startlabel = this.$element.find('.grid-start');
		this.$endlabel = this.$element.find('.grid-end');

		this.$tbody = $('<tbody>').insertAfter(this.$thead);
		this.$colheader = $('<tr>').appendTo(this.$thead);

		this.options = $.extend(true, {}, $.fn.datagrid.defaults, options);

		// Shim until v3 -- account for FuelUX select or native select for page size:
		if (this.$pagesize.hasClass('select')) {
			this.options.dataOptions.pageSize = parseInt(this.$pagesize.select('selectedItem').value, 10);
		} else {
			this.options.dataOptions.pageSize = parseInt(this.$pagesize.val(), 10);
		}

		// Shim until v3 -- account for older search class:
		if (this.$searchcontrol.length <= 0) {
			this.$searchcontrol = this.$element.find('.search');
		}

		this.columns = this.options.dataSource.columns();

		this.$nextpagebtn.on('click', $.proxy(this.next, this));
		this.$prevpagebtn.on('click', $.proxy(this.previous, this));
		this.$searchcontrol.on('searched cleared', $.proxy(this.searchChanged, this));
		this.$filtercontrol.on('changed', $.proxy(this.filterChanged, this));
		this.$colheader.on('click', 'th', $.proxy(this.headerClicked, this));

		if(this.$pagesize.hasClass('select')) {
			this.$pagesize.on('changed', $.proxy(this.pagesizeChanged, this));
		} else {
			this.$pagesize.on('change', $.proxy(this.pagesizeChanged, this));
		}

		this.$pageinput.on('change', $.proxy(this.pageChanged, this));

		this.renderColumns();

		if (this.options.stretchHeight) this.initStretchHeight();

		this.renderData();
	};

	Datagrid.prototype = {

		constructor: Datagrid,

		renderColumns: function () {
			var self = this;

			this.$footer.attr('colspan', this.columns.length);
			this.$topheader.attr('colspan', this.columns.length);

			var colHTML = '';

			$.each(this.columns, function (index, column) {
				colHTML += '<th data-property="' + column.property + '"';
				if (column.sortable) colHTML += ' class="sortable"';
				colHTML += '>' + column.label + '</th>';
			});

			self.$colheader.append(colHTML);
		},

		updateColumns: function ($target, direction) {
			this._updateColumns(this.$colheader, $target, direction);

			if (this.$sizingHeader) {
				this._updateColumns(this.$sizingHeader, this.$sizingHeader.find('th').eq($target.index()), direction);
			}
		},

		_updateColumns: function ($header, $target, direction) {
			var className = (direction === 'asc') ? 'fa fa-caret-up' : 'fa fa-caret-down';
			$header.find('i.datagrid-sort').remove();
			$header.find('th').removeClass('sorted');
			$('<i>').addClass(className + ' datagrid-sort').appendTo($target);
			$target.addClass('sorted');
		},

		updatePageDropdown: function (data) {
			var pageHTML = '';

			for (var i = 1; i <= data.pages; i++) {
				pageHTML += '<li><a>' + i + '</a></li>';
			}

			this.$pagedropdown.html(pageHTML);
		},

		updatePageButtons: function (data) {
			if (data.page === 1) {
				this.$prevpagebtn.attr('disabled', 'disabled');
			} else {
				this.$prevpagebtn.removeAttr('disabled');
			}

			if (data.page === data.pages) {
				this.$nextpagebtn.attr('disabled', 'disabled');
			} else {
				this.$nextpagebtn.removeAttr('disabled');
			}
		},

		renderData: function () {
			var self = this;

			this.$tbody.html(this.placeholderRowHTML(this.options.loadingHTML));

			this.options.dataSource.data(this.options.dataOptions, function (data) {
				var itemdesc = (data.count === 1) ? self.options.itemText : self.options.itemsText;
				var rowHTML = '';

				self.$footerchildren.css('visibility', function () {
					return (data.count > 0) ? 'visible' : 'hidden';
				});

				self.$pageinput.val(data.page);
				self.$pageslabel.text(data.pages);
				self.$countlabel.text(data.count + ' ' + itemdesc);
				self.$startlabel.text(data.start);
				self.$endlabel.text(data.end);

				self.updatePageDropdown(data);
				self.updatePageButtons(data);

				$.each(data.data, function (index, row) {
					rowHTML += '<tr>';
					$.each(self.columns, function (index, column) {
						rowHTML += '<td>' + row[column.property] + '</td>';
					});
					rowHTML += '</tr>';
				});

				if (!rowHTML) rowHTML = self.placeholderRowHTML('0 ' + self.options.itemsText);

				self.$tbody.html(rowHTML);
				self.stretchHeight();

				self.$element.trigger('loaded');
			});

		},

		placeholderRowHTML: function (content) {
			return '<tr><td style="text-align:center;padding:20px;border-bottom:none;" colspan="' +
				this.columns.length + '">' + content + '</td></tr>';
		},

		headerClicked: function (e) {
			var $target = $(e.target);
			if (!$target.hasClass('sortable')) return;

			var direction = this.options.dataOptions.sortDirection;
			var sort = this.options.dataOptions.sortProperty;
			var property = $target.data('property');

			if (sort === property) {
				this.options.dataOptions.sortDirection = (direction === 'asc') ? 'desc' : 'asc';
			} else {
				this.options.dataOptions.sortDirection = 'asc';
				this.options.dataOptions.sortProperty = property;
			}

			this.options.dataOptions.pageIndex = 0;
			this.updateColumns($target, this.options.dataOptions.sortDirection);
			this.renderData();
		},

		pagesizeChanged: function (e, pageSize) {
			if(pageSize) {
				this.options.dataOptions.pageSize = parseInt(pageSize.value, 10);
			} else {
				this.options.dataOptions.pageSize = parseInt($(e.target).val(), 10);
			}

			this.options.dataOptions.pageIndex = 0;
			this.renderData();
		},

		pageChanged: function (e) {
			var pageRequested = parseInt($(e.target).val(), 10);
			pageRequested = (isNaN(pageRequested)) ? 1 : pageRequested;
			var maxPages = this.$pageslabel.text();
		
			this.options.dataOptions.pageIndex = 
				(pageRequested > maxPages) ? maxPages - 1 : pageRequested - 1;

			this.renderData();
		},

		searchChanged: function (e, search) {
			this.options.dataOptions.search = search;
			this.options.dataOptions.pageIndex = 0;
			this.renderData();
		},

		filterChanged: function (e, filter) {
			this.options.dataOptions.filter = filter;
			this.options.dataOptions.pageIndex = 0;
			this.renderData();
		},

		previous: function () {
			this.options.dataOptions.pageIndex--;
			this.renderData();
		},

		next: function () {
			this.options.dataOptions.pageIndex++;
			this.renderData();
		},

		reload: function () {
			this.options.dataOptions.pageIndex = 0;
			this.renderData();
		},

		initStretchHeight: function () {
			this.$gridContainer = this.$element.parent();

			this.$element.wrap('<div class="datagrid-stretch-wrapper">');
			this.$stretchWrapper = this.$element.parent();

			this.$headerTable = $('<table>').attr('class', this.$element.attr('class'));
			this.$footerTable = this.$headerTable.clone();

			this.$headerTable.prependTo(this.$gridContainer).addClass('datagrid-stretch-header');
			this.$thead.detach().appendTo(this.$headerTable);

			this.$sizingHeader = this.$thead.clone();
			this.$sizingHeader.find('tr:first').remove();

			this.$footerTable.appendTo(this.$gridContainer).addClass('datagrid-stretch-footer');
			this.$tfoot.detach().appendTo(this.$footerTable);
		},

		stretchHeight: function () {
			if (!this.$gridContainer) return;

			this.setColumnWidths();

			var targetHeight = this.$gridContainer.height();
			var headerHeight = this.$headerTable.outerHeight();
			var footerHeight = this.$footerTable.outerHeight();
			var overhead = headerHeight + footerHeight;

			this.$stretchWrapper.height(targetHeight - overhead);
		},

		setColumnWidths: function () {
			if (!this.$sizingHeader) return;

			this.$element.prepend(this.$sizingHeader);

			var $sizingCells = this.$sizingHeader.find('th');
			var columnCount = $sizingCells.length;

			function matchSizingCellWidth(i, el) {
				if (i === columnCount - 1) return;

				var $el = $(el);
				var $sourceCell = $sizingCells.eq(i);
				var width = $sourceCell.width();

				// TD needs extra width to match sorted column header
				if ($sourceCell.hasClass('sorted') && $el.prop('tagName') === 'TD') width = width + SORTED_HEADER_OFFSET;

				$el.width(width);
			}

			this.$colheader.find('th').each(matchSizingCellWidth);
			this.$tbody.find('tr:first > td').each(matchSizingCellWidth);

			this.$sizingHeader.detach();
		}
	};


	// DATAGRID PLUGIN DEFINITION

	$.fn.datagrid = function (option) {
		return this.each(function () {
			var $this = $(this);
			var data = $this.data('datagrid');
			var options = typeof option === 'object' && option;

			if (!data) $this.data('datagrid', (data = new Datagrid(this, options)));
			if (typeof option === 'string') data[option]();
		});
	};

	$.fn.datagrid.defaults = {
		dataOptions: { pageIndex: 0, pageSize: 10 },
		loadingHTML: '<div class="progress progress-striped active" style="width:50%;margin:auto;"><div class="bar" style="width:100%;"></div></div>',
		itemsText: 'items',
		itemText: 'item'
	};

	$.fn.datagrid.Constructor = Datagrid;

}(window.jQuery);

/*
 * Fuel UX Pillbox
 * https://github.com/ExactTarget/fuelux
 *
 * Copyright (c) 2012 ExactTarget
 * Licensed under the MIT license.
 */

+function ($) { "use strict";
	
	// PILLBOX CONSTRUCTOR AND PROTOTYPE

	var Pillbox = function (element, options) {
		this.$element = $(element);
		this.options = $.extend({}, $.fn.pillbox.defaults, options);
		this.$element.on('click', 'li', $.proxy(this.itemclicked, this));
	};

	Pillbox.prototype = {
		constructor: Pillbox,

		items: function() {
			return this.$element.find('li').map(function() {
				var $this = $(this);
				return $.extend({ text: $this.text() }, $this.data());
			}).get();
		},

		itemclicked: function (e) {
			$(e.currentTarget).remove();
			e.preventDefault();
		}
	};


	// PILLBOX PLUGIN DEFINITION

	$.fn.pillbox = function (option) {
		var methodReturn;

		var $set = this.each(function () {
			var $this = $(this);
			var data = $this.data('pillbox');
			var options = typeof option === 'object' && option;

			if (!data) $this.data('pillbox', (data = new Pillbox(this, options)));
			if (typeof option === 'string') methodReturn = data[option]();
		});

		return (methodReturn === undefined) ? $set : methodReturn;
	};

	$.fn.pillbox.defaults = {};

	$.fn.pillbox.Constructor = Pillbox;


	// PILLBOX DATA-API

	$(function () {
		$('body').on('mousedown.pillbox.data-api', '.pillbox', function (e) {
			var $this = $(this);
			if ($this.data('pillbox')) return;
			$this.pillbox($this.data());
		});
	});
	
}(window.jQuery);


/*
 * Fuel UX Radio
 * https://github.com/ExactTarget/fuelux
 *
 * Copyright (c) 2012 ExactTarget
 * Licensed under the MIT license.
 */

+function ($) { "use strict";

	// RADIO CONSTRUCTOR AND PROTOTYPE

	var Radio = function (element, options) {
		this.$element = $(element);
		this.options = $.extend({}, $.fn.radio.defaults, options);

		// cache elements
		this.$label = this.$element.parent();
		this.$icon = this.$label.find('i');
		this.$radio = this.$label.find('input[type=radio]');
		this.groupName = this.$radio.attr('name');

		// set default state
		this.setState(this.$radio);

		// handle events
		this.$radio.on('change', $.proxy(this.itemchecked, this));
	};

	Radio.prototype = {

		constructor: Radio,

		setState: function ($radio, resetGroupState) {
			var checked = $radio.is(':checked');
			var disabled = $radio.is(':disabled');

			// set state of radio
			if (checked === true) {
				this.$icon.addClass('checked');
			}
			if (disabled === true) {
				this.$icon.addClass('disabled');
			}
		},

		resetGroup: function () {
			// reset all radio buttons in group
			$('input[name=' + this.groupName + ']').next().removeClass('checked');
		},

		enable: function () {
			this.$radio.attr('disabled', false);
			this.$icon.removeClass('disabled');
		},

		disable: function () {
			this.$radio.attr('disabled', true);
			this.$icon.addClass('disabled');
		},

		itemchecked: function (e) {
			var radio = $(e.target);

			this.resetGroup();
			this.setState(radio);
		}
	};


	// RADIO PLUGIN DEFINITION

	$.fn.radio = function (option, value) {
		var methodReturn;

		var $set = this.each(function () {
			var $this = $(this);
			var data = $this.data('radio');
			var options = typeof option === 'object' && option;

			if (!data) $this.data('radio', (data = new Radio(this, options)));
			if (typeof option === 'string') methodReturn = data[option](value);
		});

		return (methodReturn === undefined) ? $set : methodReturn;
	};

	$.fn.radio.defaults = {};

	$.fn.radio.Constructor = Radio;


	// RADIO DATA-API

	$(function () {
		$(window).on('load', function () {
			//$('i.radio').each(function () {
			$('.radio-custom > input[type=radio]').each(function () {
				var $this = $(this);
				if ($this.data('radio')) return;
				$this.radio($this.data());
			});
		});
	});

}(window.jQuery);

/*
 * Fuel UX Search
 * https://github.com/ExactTarget/fuelux
 *
 * Copyright (c) 2012 ExactTarget
 * Licensed under the MIT license.
 */

+function ($) { "use strict";

	// SEARCH CONSTRUCTOR AND PROTOTYPE

	var Search = function (element, options) {
		this.$element = $(element);
		this.options = $.extend({}, $.fn.search.defaults, options);

		this.$button = this.$element.find('button')
			.on('click', $.proxy(this.buttonclicked, this));

		this.$input = this.$element.find('input')
			.on('keydown', $.proxy(this.keypress, this))
			.on('keyup', $.proxy(this.keypressed, this));

		this.$icon = this.$element.find('i');
		this.activeSearch = '';
	};

	Search.prototype = {

		constructor: Search,

		search: function (searchText) {
			this.$icon.attr('class', 'fa fa-times');
			this.activeSearch = searchText;
			this.$element.trigger('searched', searchText);
		},

		clear: function () {
			this.$icon.attr('class', 'fa fa-search');
			this.activeSearch = '';
			this.$input.val('');
			this.$element.trigger('cleared');
		},

		action: function () {
			var val = this.$input.val();
			var inputEmptyOrUnchanged = val === '' || val === this.activeSearch;

			if (this.activeSearch && inputEmptyOrUnchanged) {
				this.clear();
			} else if (val) {
				this.search(val);
			}
		},

		buttonclicked: function (e) {
			e.preventDefault();
			if ($(e.currentTarget).is('.disabled, :disabled')) return;
			this.action();
		},

		keypress: function (e) {
			if (e.which === 13) {
				e.preventDefault();
			}
		},

		keypressed: function (e) {
			var val, inputPresentAndUnchanged;

			if (e.which === 13) {
				e.preventDefault();
				this.action();
			} else {
				val = this.$input.val();
				inputPresentAndUnchanged = val && (val === this.activeSearch);
				this.$icon.attr('class', inputPresentAndUnchanged ? 'fa fa-times' : 'fa fa-search');
			}
		},

		disable: function () {
			this.$input.attr('disabled', 'disabled');
			this.$button.addClass('disabled');
		},

		enable: function () {
			this.$input.removeAttr('disabled');
			this.$button.removeClass('disabled');
		}

	};


	// SEARCH PLUGIN DEFINITION

	$.fn.search = function (option) {
		return this.each(function () {
			var $this = $(this);
			var data = $this.data('search');
			var options = typeof option === 'object' && option;

			if (!data) $this.data('search', (data = new Search(this, options)));
			if (typeof option === 'string') data[option]();
		});
	};

	$.fn.search.defaults = {};

	$.fn.search.Constructor = Search;


	// SEARCH DATA-API

	$(function () {
		$('body').on('mousedown.search.data-api', '.search', function () {
			var $this = $(this);
			if ($this.data('search')) return;
			$this.search($this.data());
		});
	});

}(window.jQuery);

/*
 * Fuel UX Spinner
 * https://github.com/ExactTarget/fuelux
 *
 * Copyright (c) 2012 ExactTarget
 * Licensed under the MIT license.
 */

+function ($) { "use strict";

	// SPINNER CONSTRUCTOR AND PROTOTYPE

	var Spinner = function (element, options) {
		this.$element = $(element);
		this.options = $.extend({}, $.fn.spinner.defaults, options);
		this.$input = this.$element.find('.spinner-input');
		this.$element.on('keyup', this.$input, $.proxy(this.change, this));

		if (this.options.hold) {
			this.$element.on('mousedown', '.spinner-up', $.proxy(function() { this.startSpin(true); } , this));
			this.$element.on('mouseup', '.spinner-up, .spinner-down', $.proxy(this.stopSpin, this));
			this.$element.on('mouseout', '.spinner-up, .spinner-down', $.proxy(this.stopSpin, this));
			this.$element.on('mousedown', '.spinner-down', $.proxy(function() {this.startSpin(false);} , this));
		} else {
			this.$element.on('click', '.spinner-up', $.proxy(function() { this.step(true); } , this));
			this.$element.on('click', '.spinner-down', $.proxy(function() { this.step(false); }, this));
		}

		this.switches = {
			count: 1,
			enabled: true
		};

		if (this.options.speed === 'medium') {
			this.switches.speed = 300;
		} else if (this.options.speed === 'fast') {
			this.switches.speed = 100;
		} else {
			this.switches.speed = 500;
		}

		this.lastValue = null;

		this.render();

		if (this.options.disabled) {
			this.disable();
		}
	};

	Spinner.prototype = {
		constructor: Spinner,

		render: function () {
			this.$input.val(this.options.value);
			this.$input.attr('maxlength',(this.options.max + '').split('').length);
		},

		change: function () {
			var newVal = this.$input.val();

			if(newVal/1){
				this.options.value = newVal/1;
			}else{
				newVal = newVal.replace(/[^0-9]/g,'');
				this.$input.val(newVal);
				this.options.value = newVal/1;
			}

			this.triggerChangedEvent();
		},

		stopSpin: function () {
			clearTimeout(this.switches.timeout);
			this.switches.count = 1;
			this.triggerChangedEvent();
		},

		triggerChangedEvent: function () {
			var currentValue = this.value();
			if (currentValue === this.lastValue) return;

			this.lastValue = currentValue;

			// Primary changed event
			this.$element.trigger('changed', currentValue);

			// Undocumented, kept for backward compatibility
			this.$element.trigger('change');
		},

		startSpin: function (type) {

			if (!this.options.disabled) {
				var divisor = this.switches.count;

				if (divisor === 1) {
					this.step(type);
					divisor = 1;
				} else if (divisor < 3){
					divisor = 1.5;
				} else if (divisor < 8){
					divisor = 2.5;
				} else {
					divisor = 4;
				}

				this.switches.timeout = setTimeout($.proxy(function() {this.iterator(type);} ,this),this.switches.speed/divisor);
				this.switches.count++;
			}
		},

		iterator: function (type) {
			this.step(type);
			this.startSpin(type);
		},

		step: function (dir) {
			var curValue = this.options.value;
			var limValue = dir ? this.options.max : this.options.min;

			if ((dir ? curValue < limValue : curValue > limValue)) {
				var newVal = curValue + (dir ? 1 : -1) * this.options.step;

				if (dir ? newVal > limValue : newVal < limValue) {
					this.value(limValue);
				} else {
					this.value(newVal);
				}
			}
		},

		value: function (value) {
			if (!isNaN(parseFloat(value)) && isFinite(value)) {
				value = parseFloat(value);
				this.options.value = value;
				this.$input.val(value);
				return this;
			} else {
				return this.options.value;
			}
		},

		disable: function () {
			this.options.disabled = true;
			this.$input.attr('disabled','');
			this.$element.find('button').addClass('disabled');
		},

		enable: function () {
			this.options.disabled = false;
			this.$input.removeAttr("disabled");
			this.$element.find('button').removeClass('disabled');
		}
	};


	// SPINNER PLUGIN DEFINITION

	$.fn.spinner = function (option,value) {
		var methodReturn;

		var $set = this.each(function () {
			var $this = $(this);
			var data = $this.data('spinner');
			var options = typeof option === 'object' && option;

			if (!data) $this.data('spinner', (data = new Spinner(this, options)));
			if (typeof option === 'string') methodReturn = data[option](value);
		});

		return (methodReturn === undefined) ? $set : methodReturn;
	};

	$.fn.spinner.defaults = {
		value: 1,
		min: 1,
		max: 999,
		step: 1,
		hold: true,
		speed: 'medium',
		disabled: false
	};

	$.fn.spinner.Constructor = Spinner;


	// SPINNER DATA-API

	$(function () {
		$('body').on('mousedown.spinner.data-api', '.spinner', function (e) {
			var $this = $(this);
			if ($this.data('spinner')) return;
			$this.spinner($this.data());
		});
	});

}(window.jQuery);

/*
 * Fuel UX Select
 * https://github.com/ExactTarget/fuelux
 *
 * Copyright (c) 2012 ExactTarget
 * Licensed under the MIT license.
 */

+function ($) { "use strict";

    // SELECT CONSTRUCTOR AND PROTOTYPE

    var Select = function (element, options) {
        this.$element = $(element);
        this.options = $.extend({}, $.fn.select.defaults, options);
        this.$element.on('click', 'a', $.proxy(this.itemclicked, this));
        this.$button = this.$element.find('.btn');
        this.$label = this.$element.find('.dropdown-label');
        this.setDefaultSelection();

        if (options.resize === 'auto') {
            this.resize();
        }
    };

    Select.prototype = {

        constructor: Select,

        itemclicked: function (e) {
            this.$selectedItem = $(e.target).parent();
            this.$label.text(this.$selectedItem.text());

            // pass object including text and any data-attributes
            // to onchange event
            var data = this.selectedItem();

            // trigger changed event
            this.$element.trigger('changed', data);

            e.preventDefault();
        },

        resize: function() {
            var el = $('#selectTextSize')[0];

            // create element if it doesn't exist
            // used to calculate the length of the longest string
            if(!el) {
                $('<div/>').attr({id:'selectTextSize'}).appendTo('body');
            }

            var width = 0;
            var newWidth = 0;

            // iterate through each item to find longest string
            this.$element.find('a').each(function () {
                var $this = $(this);
                var txt = $this.text();
                var $txtSize = $('#selectTextSize');
                $txtSize.text(txt);
                newWidth = $txtSize.outerWidth();
                if(newWidth > width) {
                    width = newWidth;
                }
            });

            this.$label.width(width);
        },

        selectedItem: function() {
            var txt = this.$selectedItem.text();
            return $.extend({ text: txt }, this.$selectedItem.data());
        },

        selectByText: function(text) {
            var selector = 'li a:fuelTextExactCI(' + text + ')';
            this.selectBySelector(selector);
        },

        selectByValue: function(value) {
            var selector = 'li[data-value="' + value + '"]';
            this.selectBySelector(selector);
        },

        selectByIndex: function(index) {
            // zero-based index
            var selector = 'li:eq(' + index + ')';
            this.selectBySelector(selector);
        },

        selectBySelector: function(selector) {
            var item = this.$element.find(selector);

            this.$selectedItem = item;
            this.$label.text(this.$selectedItem.text());
        },

        setDefaultSelection: function() {
            var selector = 'li[data-selected=true]:first';
            var item = this.$element.find(selector);
            if(item.length === 0) {
                // select first item
                this.selectByIndex(0);
            }
            else {
                // select by data-attribute
                this.selectBySelector(selector);
                item.removeData('selected');
                item.removeAttr('data-selected');
            }
        },

        enable: function() {
            this.$button.removeClass('disabled');
        },

        disable: function() {
            this.$button.addClass('disabled');
        }

    };


    // SELECT PLUGIN DEFINITION

    $.fn.select = function (option,value) {
        var methodReturn;

        var $set = this.each(function () {
            var $this = $(this);
            var data = $this.data('select');
            var options = typeof option === 'object' && option;

            if (!data) $this.data('select', (data = new Select(this, options)));
            if (typeof option === 'string') methodReturn = data[option](value);
        });

        return (methodReturn === undefined) ? $set : methodReturn;
    };

    $.fn.select.defaults = {};

    $.fn.select.Constructor = Select;


    // SELECT DATA-API

    $(function () {

        $(window).on('load', function () {
            $('.select').each(function () {
                var $this = $(this);
                if ($this.data('select')) return;
                $this.select($this.data());
            });
        });

        $('body').on('mousedown.select.data-api', '.select', function (e) {
            var $this = $(this);
            if ($this.data('select')) return;
            $this.select($this.data());
        });
    });

}(window.jQuery);

/*
 * Fuel UX Tree
 * https://github.com/ExactTarget/fuelux
 *
 * Copyright (c) 2012 ExactTarget
 * Licensed under the MIT license.
 */

+function ($) { "use strict";

	// TREE CONSTRUCTOR AND PROTOTYPE

	var Tree = function (element, options) {
		this.$element = $(element);
		this.options = $.extend({}, $.fn.tree.defaults, options);

		this.$element.on('click', '.tree-item', $.proxy( function(ev) { this.selectItem(ev.currentTarget); } ,this));
		this.$element.on('click', '.tree-folder-header', $.proxy( function(ev) { this.selectFolder(ev.currentTarget); }, this));

		this.render();
	};

	Tree.prototype = {
		constructor: Tree,

		render: function () {
			this.populate(this.$element);
		},

		populate: function ($el) {
			var self = this;
			var loader = $el.parent().find('.tree-loader:eq(0)');

			loader.show();
			this.options.dataSource.data($el.data(), function (items) {
				loader.hide();

				$.each( items.data, function(index, value) {
					var $entity;

					if(value.type === "folder") {
						$entity = self.$element.find('.tree-folder:eq(0)').clone().show();
						$entity.find('.tree-folder-name').html(value.name);
						$entity.find('.tree-loader').html(self.options.loadingHTML);
						$entity.find('.tree-folder-header').data(value);
					} else if (value.type === "item") {
						$entity = self.$element.find('.tree-item:eq(0)').clone().show();
						$entity.find('.tree-item-name').html(value.name);
						$entity.data(value);
					}

					if($el.hasClass('tree-folder-header')) {
						$el.parent().find('.tree-folder-content:eq(0)').append($entity);
					} else {
						$el.append($entity);
					}
				});

				self.$element.trigger('loaded');
			});
		},

		selectItem: function (el) {
			var $el = $(el);
			var $all = this.$element.find('.tree-selected');
			var data = [];

			if (this.options.multiSelect) {
				$.each($all, function(index, value) {
					var $val = $(value);
					if($val[0] !== $el[0]) {
						data.push( $(value).data() );
					}
				});
			} else if ($all[0] !== $el[0]) {
				$all.removeClass('tree-selected')
					.find('i').removeClass('icon-ok').addClass('tree-dot');
				data.push($el.data());
			}

			if($el.hasClass('tree-selected')) {
				$el.removeClass('tree-selected');
				$el.find('i').removeClass('icon-ok').addClass('tree-dot');
			} else {
				$el.addClass ('tree-selected');
				$el.find('i').removeClass('tree-dot').addClass('icon-ok');
				if (this.options.multiSelect) {
					data.push( $el.data() );
				}
			}

			if(data.length) {
				this.$element.trigger('selected', {info: data});
			}

		},

		selectFolder: function (el) {
			var $el = $(el);
			var $par = $el.parent();

			if($el.find('.icon-folder-close').length) {
				if ($par.find('.tree-folder-content').children().length) {
					$par.find('.tree-folder-content:eq(0)').show();
				} else {
					this.populate( $el );
				}

				$par.find('.icon-folder-close:eq(0)')
					.removeClass('icon-folder-close')
					.addClass('icon-folder-open');

				this.$element.trigger('opened', $el.data());
			} else {
				if(this.options.cacheItems) {
					$par.find('.tree-folder-content:eq(0)').hide();
				} else {
					$par.find('.tree-folder-content:eq(0)').empty();
				}

				$par.find('.icon-folder-open:eq(0)')
					.removeClass('icon-folder-open')
					.addClass('icon-folder-close');

				this.$element.trigger('closed', $el.data());
			}
		},

		selectedItems: function () {
			var $sel = this.$element.find('.tree-selected');
			var data = [];

			$.each($sel, function (index, value) {
				data.push($(value).data());
			});
			return data;
		}
	};


	// TREE PLUGIN DEFINITION

	$.fn.tree = function (option, value) {
		var methodReturn;

		var $set = this.each(function () {
			var $this = $(this);
			var data = $this.data('tree');
			var options = typeof option === 'object' && option;

			if (!data) $this.data('tree', (data = new Tree(this, options)));
			if (typeof option === 'string') methodReturn = data[option](value);
		});

		return (methodReturn === undefined) ? $set : methodReturn;
	};

	$.fn.tree.defaults = {
		multiSelect: false,
		loadingHTML: '<div>Loading...</div>',
		cacheItems: true
	};

	$.fn.tree.Constructor = Tree;

}(window.jQuery);

/*
 * Fuel UX Wizard
 * https://github.com/ExactTarget/fuelux
 *
 * Copyright (c) 2012 ExactTarget
 * Licensed under the MIT license.
 */

+function ($) { "use strict";

	// WIZARD CONSTRUCTOR AND PROTOTYPE

	var Wizard = function (element, options) {
		var kids;

		this.$element = $(element);
		this.options = $.extend({}, $.fn.wizard.defaults, options);
		this.currentStep = 1;
		this.numSteps = this.$element.find('li').length;
		this.$prevBtn = this.$element.find('button.btn-prev');
		this.$nextBtn = this.$element.find('button.btn-next');

		kids = this.$nextBtn.children().detach();
		this.nextText = $.trim(this.$nextBtn.text());
		this.$nextBtn.append(kids);

		// handle events
		this.$prevBtn.on('click', $.proxy(this.previous, this));
		this.$nextBtn.on('click', $.proxy(this.next, this));
		this.$element.on('click', 'li.complete', $.proxy(this.stepclicked, this));
	};

	Wizard.prototype = {

		constructor: Wizard,

		setState: function () {
			var canMovePrev = (this.currentStep > 1);
			var firstStep = (this.currentStep === 1);
			var lastStep = (this.currentStep === this.numSteps);

			// disable buttons based on current step
			this.$prevBtn.attr('disabled', (firstStep === true || canMovePrev === false));

			// change button text of last step, if specified
			var data = this.$nextBtn.data();
			if (data && data.last) {
				this.lastText = data.last;
				if (typeof this.lastText !== 'undefined') {
					// replace text
					var text = (lastStep !== true) ? this.nextText : this.lastText;
					var kids = this.$nextBtn.children().detach();
					this.$nextBtn.text(text).append(kids);
				}
			}

			// reset classes for all steps
			var $steps = this.$element.find('li');
			$steps.removeClass('active').removeClass('complete');
			$steps.find('span.badge').removeClass('badge-info').removeClass('badge-success');

			// set class for all previous steps
			var prevSelector = 'li:lt(' + (this.currentStep - 1) + ')';
			var $prevSteps = this.$element.find(prevSelector);
			$prevSteps.addClass('complete');
			$prevSteps.find('span.badge').addClass('badge-success');

			// set class for current step
			var currentSelector = 'li:eq(' + (this.currentStep - 1) + ')';
			var $currentStep = this.$element.find(currentSelector);
			$currentStep.addClass('active');
			$currentStep.find('span.badge').addClass('badge-info');

			// set display of target element
			var target = $currentStep.data().target;
			// Dillon changed for support multi wizard
			$('.step-pane', $(target).parent()).removeClass('active');
			$(target).addClass('active');

			this.$element.trigger('changed');
		},

		stepclicked: function (e) {
			var li = $(e.currentTarget);

			// Dillon changed for support multi wizard
			var index = li.parent().find('li').index(li);

			var evt = $.Event('stepclick');
			this.$element.trigger(evt, {step: index + 1});
			if (evt.isDefaultPrevented()) return;

			this.currentStep = (index + 1);
			this.setState();
		},

		previous: function () {
			var canMovePrev = (this.currentStep > 1);
			if (canMovePrev) {
				var e = $.Event('change');
				this.$element.trigger(e, {step: this.currentStep, direction: 'previous'});
				if (e.isDefaultPrevented()) return;

				this.currentStep -= 1;
				this.setState();
			}
		},

		next: function () {
			var canMoveNext = (this.currentStep + 1 <= this.numSteps);
			var lastStep = (this.currentStep === this.numSteps);

			if (canMoveNext) {
				var e = $.Event('change');
				this.$element.trigger(e, {step: this.currentStep, direction: 'next'});

				if (e.isDefaultPrevented()) return;

				this.currentStep += 1;
				this.setState();
			}
			else if (lastStep) {
				this.$element.trigger('finished');
			}
		},

		selectedItem: function (val) {
			return {
				step: this.currentStep
			};
		}
	};


	// WIZARD PLUGIN DEFINITION

	$.fn.wizard = function (option, value) {
		var methodReturn;

		var $set = this.each(function () {
			var $this = $(this);
			var data = $this.data('wizard');
			var options = typeof option === 'object' && option;

			if (!data) $this.data('wizard', (data = new Wizard(this, options)));
			if (typeof option === 'string') methodReturn = data[option](value);
		});

		return (methodReturn === undefined) ? $set : methodReturn;
	};

	$.fn.wizard.defaults = {};

	$.fn.wizard.Constructor = Wizard;


	// WIZARD DATA-API

	$(function () {
		$('body').on('mousedown.wizard.data-api', '.wizard', function () {
			var $this = $(this);
			if ($this.data('wizard')) return;
			$this.wizard($this.data());
		});
	});

}(window.jQuery);