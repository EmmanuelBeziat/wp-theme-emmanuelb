/**
 * Google Analytics
 */
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-37604272-1', 'auto');
ga('send', 'pageview');

/**
  Fonction principale du site
 */
var emmanuelb = (function($, undefined) {
	'use strict';

	/**
	 * Préparer et créer le menu principal
	 */
	var menuCreator = function() {

		var sURL = window.location.pathname.split('/'),
			sURLpage = sURL[1],
			sURLanchor = window.location.hash,
			sClassName = 'navigation-main__item--current',
			$menu = $("#main-menu"),
			$menuItemAccueil = $menu.find('a[href="/#accueil"]').parent(),
			$menuItemPortfolio = $menu.find('a[href="/#portfolio"]').parent(),
			$menuItemBlog = $menu.find('a[href="/blog/"]').parent(),
			$menuItemContact = $menu.find('a[href="/#contact"]').parent();

		$menuItemAccueil.find('a').attr('data-toggle', 'tab').attr('href', '#accueil');
		$menuItemPortfolio.find('a').attr('data-toggle', 'tab').attr('href', '#portfolio');
		$menuItemContact.find('a').attr('data-toggle', 'tab').attr('href', '#contact');

		// Ajout des classes et des attributs sur les éléments
		if (sURLpage === 'blog') {
			$menuItemBlog.addClass(sClassName);
		}
		else {
			if ($.fn.tabs) {
				$menu.tabs({
					'anchors': true,
					'class': sClassName
				});
			}

			switch (sURLanchor) {
				case '#accueil':
					$menuItemAccueil.addClass(sClassName);
					break;
				case '#portfolio':
					$menuItemPortfolio.addClass(sClassName);
					break;
				case '#contact':
					$menuItemContact.addClass(sClassName);
					break;
				default:
					$menuItemAccueil.addClass(sClassName);
					break;
			}
		}
	};

	/**
	 * Créer une boite de dialogue complète
	 * @param  {json} content    [description]
	 * @param  {jQuery} $container [description]
	 */
	var dialogCreate = function(content, $container) {

		var classType = 'dialog--' + content.type,
			classOpen = 'dialog--open';

		$container.find('.dialog__header').html(content.title);
		$container.find('.dialog__body').html(content.content);
		$container.delay(400).addClass(classType + ' ' + classOpen);
	};

	/**
	 * Fermeture des fenêtres de dialogue
	 * @param  {event} event [description]
	 */
	var dialogClose = function(event) {
		$(this).parents('.dialog').removeClass('dialog--open dialog--alert dialog--success');

		event.preventDefault();
	};

	/**
	 * Requête ajax pour l'envoi de mail
	 * @param  {string} method          [description]
	 * @param  {string} action          [description]
	 * @param  {array} serializedDatas [description]
	 * @return {ajax}                 [description]
	 */
	var ajaxCall = function(method, action, serializedDatas) {

		return $.ajax({
			type: method,
			url: action,
			data: serializedDatas,
			datatype: 'json'
		});
	};

	/**
	 * Fonction d'envoi de mail du formulaire de contact
	 * @param  {event} event [description]
	 */
	var sendMail = function(event) {

		var $alert = $('.contact-alerts .dialog'),
			method = $(this).attr("method"),
			action = $(this).attr("action"),
			serializedDatas = $(this).serialize(),
			$champName = $('#name'),
			$champEmail = $('#email'),
			$champMessage = $('#message'),
			sChampName = $champName.val(),
			schampEmail = $champEmail.val(),
			sChampMessage = $champMessage.val();

		ajaxCall(method, action, serializedDatas)
			.done(function(content) {
				var json = JSON.parse(content);

				if (json.type === 'success') {
					$('.form-group').removeClass('form-group--focus form-group--label');
					$champName.val('');
					$champEmail.val('');
					$champMessage.val('');
				}

				dialogCreate(json, $alert);
			})
			.fail(function(content) {
				var json = JSON.parse(content);

				$champName.val(sChampName);
				$champEmail.val(schampEmail);
				$champMessage.val(sChampMessage);

				dialogCreate(json, $alert);
			});

		event.preventDefault();
	};

	/**
	 * Popup des liens de partage (réseaux sociaux)
	 * @param  {event} event [description]
	 */
	var shareLinks = function(event) {

		var url = $(this).attr('href');

		window.open(url, 'width=700', 'height=500', 'menubar=0', 'location=0', 'status=0', ' scrollbars=0');

		event.preventDefault();
	};

	/**
	 * Initialiser les fonctions et appeler les plugins
	 */
	var init = function() {

		// Menu principal
		menuCreator();

		// Comportement des formulaires
		$('#contact-form').modernForm();
		$('.search-form').modernForm();

		// Envoi de mail
		$('#contact-form').on('submit', sendMail);

		// Boutons de partage
		$('[data-link="share"]').on('click', shareLinks);

		// Fermer les alertes
		$('.contact-alerts').on('click', '.dialog__close', dialogClose);

		// ancre top
		$('.back-top').scrollOffset();
	};

	/**
	 * Renvoi de la fonction init à l'appel
	 */
	return {
		init: init
	};
})(jQuery);


/**
 * Appeler la fonction init quand jQuery est prêt
 */
$(function() {
	emmanuelb.init();
});