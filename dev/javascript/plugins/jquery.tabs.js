/*!
 * Automatic tabs system
 * Version : 3.1
 * Emmanuel B. (www.emmanuelbeziat.com)
 * https://github.com/EmmanuelBeziat/jQuery-Tabs
 **/

;(function($, window, document, undefined) {
	'use strict';

	/**
	 * Default values
	 */
	var pluginName = 'tabs',
		defaults = {
			mode: 'fade',
			anchors: false,
			duration: 400,
			class: 'selected'
		};

	/**
	 * Constructor
	 */
	var Plugin = function(element, options) {
		this.element = element;

		this.settings = $.extend({}, defaults, options);

		this._defaults = defaults;
		this._name = pluginName;

		this._body = $('html, body');

		this.init();
	};

	/**
	 * Methods
	 */
	$.extend(Plugin.prototype, {

		init: function() {

			/**
			 * Variables
			 */
			var plugin = this,
				settings = plugin.settings,
				$tabContainer = $(plugin.element),
				$tabFirst = $tabContainer.find('li:first a'),
				tabCurrent = null,
				tabAnchor = window.location.hash,
				tabID = null;

			/**
			 * Set the default tab active as the first, or use the anchor from the url
			 */
			if (settings.anchors && '' !== tabAnchor && $tabContainer.find('a[data-toggle="tab"]')) {
				$tabFirst = $tabContainer.find('a[href="' + tabAnchor + '"]');
			}

			/**
			 * Apply class on the first tab
			 */
			$tabFirst.parent().addClass(plugin.settings.class);

			/**
			 * Show the current tab by default
			 */
			tabCurrent = $tabFirst.attr('href');
			$(tabCurrent).show().siblings().hide();

			$tabContainer.on('click', 'a[data-toggle="tab"]', function(event) {
				tabID = $(this).attr('href');

				/**
				 * If a link is clicked, but not the current active one
				 */
				if (tabID != tabCurrent) {
					switch (settings.mode) {
						case ('slide'):
							$(tabID).siblings().slideUp();
							$(tabID).delay(settings.duration).slideDown();
							break;
						default:
							$(tabID).fadeIn(settings.duration).siblings().hide();
							break;
					}

					/**
					 * Remove the class from other items and add it on the selected
					 */
					$(this).parent().addClass(settings.class).siblings().removeClass(settings.class);
					tabCurrent = tabID;
				}

				/**
				 * Stop the page to scroll to anchor if needed
				 */
				if (true === settings.anchors) {
					setTimeout(function() {
						plugin._body.scrollTop(0, 0);
					}, 1);
				}
				else {
					event.preventDefault();
				}
			});
		}

	});

	/**
	 * jQuery plugin wrapper
	 */
	$.fn[pluginName] = function(options) {

		return this.each(function() {
			var _oPlugin;

			if ( $.data( this, 'plugin_' + pluginName ) !== true ) {
				_oPlugin = new Plugin( this, options );
				$.data( this, 'plugin_' + pluginName, true );
			}
		});

	};
 })(jQuery, window, document);
