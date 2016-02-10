###!
# JS principal
###

###*
# Google Analytics
###

((i, s, o, g, r, a, m) ->
	i['GoogleAnalyticsObject'] = r
	i[r] = i[r] or ->
		(i[r].q = i[r].q or []).push arguments
		return

	i[r].l = 1 * new Date
	a = s.createElement(o)
	m = s.getElementsByTagName(o)[0]
	a.async = 1
	a.src = g
	m.parentNode.insertBefore a, m
	return
) window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga'
ga 'create', 'UA-37604272-1', 'auto'
ga 'send', 'pageview'


###*
# Fonction principale du site
###

emmanuelb = (($) ->
	'use strict'

	###*
	# Préparer et créer le menu principal
	###

	menuCreator = ->
		sURL = window.location.pathname.split('/')
		sURLpage = sURL[1]
		sURLanchor = window.location.hash
		sClassName = 'navigation-main__item--current'
		$menu = $('.navigation-main')
		$menuItemAccueil = $menu.find('a[href="/#accueil"]').parent()
		$menuItemPortfolio = $menu.find('a[href="/#portfolio"]').parent()
		$menuItemBlog = $menu.find('a[href="/blog/"]').parent()
		$menuItemContact = $menu.find('a[href="/#contact"]').parent()
		$menuItemAccueil.find('a').attr('data-toggle', 'tab').attr 'href', '#accueil'
		$menuItemPortfolio.find('a').attr('data-toggle', 'tab').attr 'href', '#portfolio'
		$menuItemContact.find('a').attr('data-toggle', 'tab').attr 'href', '#contact'

		# Ajout des classes et des attributs sur les éléments
		if sURLpage == 'blog'
			$menuItemBlog.addClass sClassName
		else
			if $.fn.tabs
				$menu.tabs
					'anchors': true
					'class': sClassName
			switch sURLanchor
				when '#accueil'
					$menuItemAccueil.addClass sClassName
				when '#portfolio'
					$menuItemPortfolio.addClass sClassName
				when '#contact'
					$menuItemContact.addClass sClassName
				else
					$menuItemAccueil.addClass sClassName
					break
		return

	###*
	# Créer une boite de dialogue complète
	# @param  {json} content    [description]
	# @param  {jQuery} $container [description]
	###

	dialogCreate = (content, $container) ->
		classType = 'dialog--' + content.type
		classOpen = 'dialog--open'
		$container.find('.dialog__header').html content.title
		$container.find('.dialog__body').html content.content
		$container.delay(400).addClass classType + ' ' + classOpen
		$('.site').addClass 'de-emphasized'
		return

	###*
	# Fermeture des fenêtres de dialogue
	# @param  {event} event [description]
	###

	dialogClose = (event) ->
		$(this).parents('.dialog').removeClass 'dialog--open dialog--alert dialog--success'
		$('.site').removeClass 'de-emphasized'
		event.preventDefault()
		return

	###*
	# Requête ajax pour l'envoi de mail
	# @param  {string} method          [description]
	# @param  {string} action          [description]
	# @param  {array} serializedDatas [description]
	# @return {ajax}                 [description]
	###

	ajaxCall = (method, action, serializedDatas) ->
		$.ajax
			type: method
			url: action
			data: serializedDatas
			datatype: 'json'

	###*
	# Fonction d'envoi de mail du formulaire de contact
	# @param  {event} event [description]
	###

	sendMail = (event) ->
		$alert = $('.contact-alerts .dialog')
		method = $(this).attr('method')
		action = $(this).attr('action')
		serializedDatas = $(this).serialize()
		$champName = $('#name')
		$champEmail = $('#email')
		$champMessage = $('#message')
		sChampName = $champName.val()
		schampEmail = $champEmail.val()
		sChampMessage = $champMessage.val()
		ajaxCall(method, action, serializedDatas).done((content) ->
			json = JSON.parse(content)
			if json.type == 'success'
				$('.form-group').removeClass 'form-group--focus form-group--label'
				$champName.val ''
				$champEmail.val ''
				$champMessage.val ''
			dialogCreate json, $alert
			return
		).fail (content) ->
			json = JSON.parse(content)
			$champName.val sChampName
			$champEmail.val schampEmail
			$champMessage.val sChampMessage
			dialogCreate json, $alert
			return
		event.preventDefault()
		return

	skillsAnimation = (delay) ->
		$skill = $('.skill__item')
		iSkillValue = $skill.attr('data-skill')
		setTimeout (->
			$skill.addClass 'skill__item--animation'
			return
		), delay
		return

	###*
	# Popup des liens de partage (réseaux sociaux)
	# @param  {event} event [description]
	###

	shareLinks = (event) ->
		url = $(this).attr('data-url')
		left = window.screenLeft || window.screenX
		top = window.screenTop || window.screenY
		popupWidth = 640
		popupHeight = 480
		popupPosX = left + window.innerWidth / 2 - popupWidth / 2
		popupPosY = top + window.innerHeight / 2 - popupHeight / 3

		window.open url, 'Partager', 'width=' + popupWidth + ', height=' + popupHeight + ', menubar=0, location=0, scrollbars=yes, left=' + popupPosX + ', top=' + popupPosY + ', status=0'
		event.preventDefault()
		return

	###*
	# Initialiser les fonctions et appeler les plugins
	###

	init = ->
		# Menu principal
		menuCreator()
		# Skills
		skillsAnimation 600
		# Comportement des formulaires
		$('.modern-form').modernForm()
		# Envoi de mail
		$('#contact-form').on 'submit', sendMail
		# Boutons de partage
		$('[data-link="share"]').on 'click', shareLinks
		# Fermer les alertes
		$('.contact-alerts').on 'click', '.dialog__close', dialogClose
		# ancre top
		$('.back-top').scrollOffset()
		return

	###*
	# Renvoi de la fonction init à l'appel
	###

	{ init: init }
)(jQuery)

###*
# Appeler la fonction init quand jQuery est prêt
###

$ ->
	emmanuelb.init()
	return
