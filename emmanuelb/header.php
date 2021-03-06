<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage EmmanuelB
 * @since Emmanuel B 2.5
 */
?><!doctype html>
<html lang="fr-FR" dir="ltr" prefix="og: http://ogp.me/ns#">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width">
		<title><?php echo get_bloginfo('name'); ?><?php wp_title('::', true, 'left'); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
		<!--[if lt IE 9]>
			<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie.css">
			<script src="<?php echo get_template_directory_uri(); ?>/js/vendors/html5.js"></script>
		<![endif]-->

		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-180x180.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicons/favicon-32x32.png" sizes="32x32">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicons/favicon-194x194.png" sizes="194x194">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicons/favicon-96x96.png" sizes="96x96">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicons/android-chrome-192x192.png" sizes="192x192">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicons/favicon-16x16.png" sizes="16x16">
		<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/images/favicons/manifest.json">
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicons/favicon.ico">
		<link rel="author" href="humans.txt">

		<meta name="description" content="Portfolio en ligne d'un développeur web du sud. Billets de blogs, tutoriels, astuces, diatribes et réflexions sur le métier, le code et plein d'autres choses.">
		<meta name="format-detection" content="telephone=yes">
		<meta name="application-name" content="Emmanuel B.">
		<meta name="msapplication-tooltip" content="Cliquez pour aller sur le site d'Emmanuel Béziat !">
		<meta name="msapplication-navbutton-color" content="#ed5936">
		<meta name="msapplication-TileColor" content="#2e3235">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/images/favicons/mstile-144x144.png">
		<meta name="msapplication-starturl" content="./">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/images/favicons/mstile-144x144.png">
		<meta name="msapplication-config" content="<?php echo get_template_directory_uri(); ?>/images/favicons/browserconfig.xml">
		<meta name="msapplication-task" content="name=Le blog;action-uri=./blog/;icon-uri=/design/wordpress.ico">
		<meta name="msapplication-task" content="name=Profil Twitter;action-uri=https://twitter.com/emmanuelbeziat;icon-uri=http://twitter.com/favicon.ico">
		<meta name="msapplication-task" content="name=Profil Google+;action-uri=https://plus.google.com/+Emmanuelbeziat-web;icon-uri=https://ssl.gstatic.com/s2/oz/images/faviconr2.ico">
		<meta name="msapplication-task" content="name=Profil LinkedIn;action-uri=http://lnkd.in/Gg_f_2;icon-uri=http://s.c.lnkd.licdn.com/scds/common/u/img/favicon_v3.ico">

		<meta name="google-site-verification" content="r-jxizeApI9fc9d0Lz8hsK4L_PFTuQdtzQ2AvWM7S-g" />

		<?php twittercards(); ?>
		<?php facebookmeta(); ?>

		<base href="<?php echo esc_url(home_url('/')); ?>">

		<!--[if lt IE 8]><script src="http://cdn.infographizm.com/javascript/google/ie.js"></script><link rel="stylesheet" href="design/style-ie7.css"><![endif]-->
		<?php //wp_head(); ?>
	</head>
	<?php flush(); ?>
	<body <?php body_class(); ?>>
		<div class="site" id="anchor-top">
			<header class="site-header">
				<div class="site-header__main">
					<h1 class="site-header__title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Emmanuel B.</a></h1>
					<img class="portrait" src="<?php echo get_template_directory_uri(); ?>/images/emmanuelb.png" width="220" height="220" alt="Manu">

					<nav class="navigation-social">
						<ul class="list-unstyled">
							<li><a class="navigation-social__link" href="https://pinterest.com/rhomanu/"><i class="icon-pinterest"></i>Pinterest</a></li>
							<li><a class="navigation-social__link" href="https://plus.google.com/+Emmanuelbeziat-web" rel="publisher"><i class="icon-googleplus"></i>Google+</a></li>
							<li><a class="navigation-social__link" href="https://twitter.com/emmanuelbeziat"><i class="icon-twitter"></i>Twitter</a></li>
							<li><a class="navigation-social__link" href="https://www.facebook.com/emmanuelbeziat"><i class="icon-facebook"></i>Facebook</a></li>
							<li><a class="navigation-social__link" href="blog/"><i class="icon-wordpress"></i>Blog</a></li>
							<li><a class="navigation-social__link" href="https://www.linkedin.com/pub/emmanuel-b/49/429/542"><i class="icon-linkedin"></i>LinkedIn</a></li>
							<li><a class="navigation-social__link" href="http://codepen.io/EmmanuelB/"><i class="icon-codepen"></i>CodePen</a></li>
							<li><a class="navigation-social__link" href="https://github.com/EmmanuelBeziat"><i class="icon-github"></i>GitHub</a></li>
						</ul>
					</nav>

					<div class="site-header__content">
						<div class="hidden-sm hidden-xs">
							<p>jeune développeur web perpignanais passionné de geekeries</p>
							<p>je travaille aussi chez <a href="http://www.italic.fr/" target="_blank">italic</a>, une chouette web-agency à paris !</p>
							<p>et je suis également formateur web à l'<a href="http://www.lidem.eu/" target="_blank">IDEM</a>, dans l'sud !</p>
						</div>
						<nav class="secondary-menu">
							<ul class="list-unstyled">
								<li>
									<a class="secondary-menu__link" href="https://download.emmanuelbeziat.com/emmanuel-beziat-cv2016.pdf" rel="prefetch" target="_blank">
										<i class="icon-code"></i>Téléchargez mon CV
									</a>
								</li>
							</ul>
						</nav>
					</div>
					<span class="copyright">© <?php echo date('Y')?> Emmanuel Béziat</span>
				</div>
			</header><!-- #header -->

			<div class="site-main">
				<?php get_sidebar(); ?>

				<main class="main-content">
