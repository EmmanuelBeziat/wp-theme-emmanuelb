/*!
 * Automatic tabs system
 * Version : 4.0
 * Emmanuel B. (www.emmanuelbeziat.com)
 * https://github.com/EmmanuelBeziat/jQuery-Tabs
 **/

;(function($, window, document, undefined) {
	'use strict';

	var pluginName = 'tabs';

	/**
	 * Constructor
	 */
	function Plugin(element, options) {
		this.element = element;
		this._name = pluginName;
		this._defaults = $.fn[pluginName].defaults;
		this.options = $.extend( {}, this._defaults, options );

		this.init();
	}

	/**
	 * Methods
	 */
	$.extend(Plugin.prototype, {

		// Initialization logic
		init: function() {
			this.buildCache();
			this.firstState();
			this.bindEvents();
		},

		/**
		 * Remove plugin instance
		 * Example: $('selector').data('tabs').destroy();
		 */
		destroy: function() {
			this.unbindEvents();
			this.$element.removeData();
		},

		/**
		 * Create variables that can be accessed by other functions
		 * Useful for DOM performances
		 */
		buildCache: function() {
			this.$element = $(this.element);
			this.$body = $('html, body');
			this.$firstTab = this.$element.find('li:first a[data-toggle="tab"]');
			this.$currentTab = this.$firstTab;
			this.hash = window.location.hash;
		},

		/**
		 * Attach actions to events
		 */
		bindEvents: function() {
			var plugin = this;

			plugin.$element.on('click' + '.' + plugin._name, 'a[data-toggle="tab"]', function(event) {
				plugin.openTab.call(plugin, event);
			});
		},

		/**
		 * Remove actions from events
		 */
		unbindEvents: function() {
			this.$element.off('.' + this._name);
		},

		firstState: function() {
			var plugin = this;

			/**
			 * Set the default tab active as the first, or use the anchor from the url
			 */
			if (plugin.options.anchors && '' !== plugin.hash && plugin.$element.find('a[data-toggle="tab"]')) {
				plugin.$firstTab = plugin.$element.find('a[data-toggle="tab"][href="' + plugin.hash + '"]');
			}

			/**
			 * Apply class on the first tab
			 */
			plugin.$firstTab.parent().addClass(plugin.options.class);

			/**
			 * Show the current tab by default
			 */
			this.changeTab($($(plugin.$firstTab).attr('href')), 'show', 0);

			/**
			 * Allow callback on complete loading
			 */
			this.callback();
		},

		/**
		 * Open tabs
		 */
		openTab: function(event) {
			var $tab = $(event.target),
				targetID = $tab.attr('href'),
				$target = $(targetID);


			if (targetID !== this.$currentTab.attr('href')) {
				this.changeTab($target, this.options.mode, this.options.duration);
			}

			/**
			 * Remove the class from other items and add it on the selected
			 */
			$tab.parent().addClass(this.options.class).siblings().removeClass(this.options.class);
			this.$currentTab = $target;

			/**
			 * Stop the page to scroll to anchor if needed
			 */
			if (true === this.options.anchors) {
				this.scrollToTop(this.$body);
			}
			else {
				event.preventDefault();
			}

			/**
			 * Allow callback on complete loading
			 */
			this.callback();
		},

		/**
		 * Switch tabs with specific modes
		 */
		changeTab: function($target, switchMode, duration) {
			switch (switchMode) {
				case ('slide'):
					$target.siblings().slideUp();
					$target.delay(duration).slideDown();
				break;

				case ('show'):
					$target.show().siblings().hide();
				break;

				case ('fade'):
					$target.fadeIn(duration).siblings().hide();
				break;

				default:
					$target.fadeIn(duration).siblings().hide();
				break;
			}
		},

		/**
		 * When anchors are used, lock up the scroll
		 */
		scrollToTop: function($body) {
			setTimeout(function() {
				$body.scrollTop(0, 0);
			}, 1);
		},

		/**
		 * When loading tab is complete
		 */
		callback: function() {
			// Cache onComplete option
			var onComplete = this.options.onComplete;

			if (typeof onComplete === 'function') {
				onComplete.call(this.element);
			}
		}

	});

	/**
	 * jQuery plugin wrapper
	 */
	$.fn[pluginName] = function(options) {
		this.each(function() {
			if (!$.data( this, "plugin_" + pluginName)) {
				$.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
			}
		});
		return this;
	};

	/**
	 * Plugin options and their default values
	 */
	$.fn[pluginName].defaults = {
		mode: 'fade',
		anchors: false,
		duration: 400,
		class: 'active',
		onComplete: null
	};

})( jQuery, window, document );
