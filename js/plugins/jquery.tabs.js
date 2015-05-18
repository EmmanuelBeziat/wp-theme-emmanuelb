/*!
 * Système d'onglets automatisé
 * Version : 2.1
 * Par Emmanuel "Manumanu" B. (www.emmanuelbeziat.com)
 * https://github.com/EmmanuelBEziat/jQuery-Tabs
 **/

;(function($, undefined) {
	"use strict";

	$.fn.tabs = function(params) {

		// Valeurs par défauts des options
		params = $.extend({
			mode: 'fade',
			anchors: false,
			duration: 400,
			class: 'selected'
		}, params);

		// Variables globales
		var page = $('html, body'),
			tabAnchor = window.location.hash;

		this.each(function() {

			// Variables
			var tabContainer = $(this),
				tabFirst = tabContainer.find('li:first a'),
				tabCurrent = null,
				tabID = null;

			// Attribuer l'onglet par défaut comme étant le premier, ou utiliser l'ancre
			if (true === params.anchors && '' !== tabAnchor && tabContainer.find('a[data-toggle="tab"]'))
				tabFirst = tabContainer.find('a[href="' + tabAnchor + '"]');

			// Appliquer la class select sur l'onglet actuel
			tabFirst.parent().addClass(params.class);

			// Afficher l'élément par défaut correspondant à celui de l'onglet par défaut ou l'onglet ancré
			tabCurrent = tabFirst.attr('href');
			$(tabCurrent).show().siblings().hide();

			// Gestion de l'événement clic
			tabContainer.on('click', 'a[data-toggle="tab"]', function(event) {

				tabID = $(this).attr('href');

				// Si l'élément n'est pas déjà sélectionné
				if (tabID != tabCurrent) {

					// Afficher le contenu demandé et masquer le contenu restant
					switch (params.mode) {
						case ('slide'):
							$(tabID).siblings().slideUp();
							$(tabID).delay(params.duration).slideDown();
							break;
						default:
							$(tabID).fadeIn(params.duration).siblings().hide();
							break;
					}

					// Retirer la classe des autres onglets et l'ajouter sur l'élément sélectionné
					$(this).parent().addClass(params.class).siblings().removeClass(params.class);
					tabCurrent = tabID;
				}

				// Empêche le déclenchement du lien si voulu
				if (params.anchors)
					setTimeout(function() {
						page.scrollTop(0, 0);
					}, 1);
				else
					event.preventDefault();
			});
		});

		// Chainage jQuery
		return this;
	};
})(jQuery);