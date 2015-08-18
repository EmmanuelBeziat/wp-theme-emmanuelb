<?php
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');

remove_filter('the_content', 'wptexturize');
remove_filter('the_excerpt', 'wptexturize');
remove_filter('comment_text', 'wptexturize');

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

wp_dequeue_script('jquery');
wp_dequeue_script('form');

/* Préparation du template
************************************/
function theme_setup() {

	/* Support des éléments
	************************************/
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', 'title-tag', ['search-form', 'comment-form', 'comment-list']);

	/* Menus
	************************************/
	register_nav_menus([
		'top' => 'Haut de page',
		'footer' => 'Pied de page',
		'sidebar' => 'Barre latérale',
	]);

	/** Sidebars
	************************************/
	if (function_exists('register_sidebar')) {
		register_sidebar();
	}
}

add_action('after_setup_theme', 'theme_setup');

/* Custom Post Types & taxonomies
************************************/
function create_post_type() {

	// Compétences
	register_post_type('skills', [
			'labels' => [
				'name' => 'Compétences',
				'singular_name' => 'Compétence',
				'all_items' => 'Toutes les compétences',
				'add_new_item' => 'Ajouter une compétence',
				'edit_item' => 'Modifier la compétence',
				'view_item' => 'Voir la compétence',
				'search_items' => 'Rechercher une compétence',
			],
			'taxonomies' => ['skills_category'],
			'supports' => ['title', 'editor' => false,	'revisions' => false, 'custom-fields'],
			'public' => true,
			'description' => 'Permet d\'ajouter les compétences à mettre en avant.',
			'exclude_from_search' => true,
			'menu_icon' => 'dashicons-star-filled',
		]
	);

	// Portfolio, projets, références
	register_post_type('portfolio', [
			'labels' => [
				'name' => 'Portfolio',
				'singular_name' => 'Portfolio',
				'all_items' => 'Toutes les références',
				'add_new_item' => 'Ajouter une référence',
				'edit_item' => 'Modifier la référence',
				'view_item' => 'Voir la référence',
				'search_items' => 'Rechercher une référence',
			],
			'taxonomies' => ['portfolio_category', 'portfolio_tag'],
			'supports' => ['title', 'editor', 'custom_fields', 'thumbnail', 'custom-fields'],
			'public' => true,
			'description' => 'Permet d\'ajouter les références pour le portfolio. Chaque référence est reliée à une page spécifique détaillant le projet.',
			'exclude_from_search' => true,
			'menu_icon' => 'dashicons-format-gallery',
		]
	);

	// Catégories des références
	register_taxonomy(
		'portfolio_category', 'portfolio', [
			'labels' => [
				'name' => 'Catégories',
				'singular_name' => 'Catégorie',
				'search_items' => 'Rechercher une catégorie',
				'parent_item' => 'Catégorie parente',
				'edit_item' => 'Modifier la catégorie',
				'update_item' => 'Mettre à jour la catégorie',
			],
			'hierarchical' => true
		]
	);

	// Catégories des compétences
	register_taxonomy(
		'skills_category', 'skills', [
			'labels' => [
				'name' => 'Domaines de compétences',
				'singular_name' => 'Domaine de compétence',
				'search_items' => 'Rechercher un domaine de compétence',
				'edit_item' => 'Modifier le domaine de compétence',
				'update_item' => 'Mettre à jour le domaine de compétence',
			],
			'hierarchical' => true,
		]
	);
}

add_action('init', 'create_post_type');

/* Special Fields
************************************/
function add_metaboxes() {
	add_meta_box('portfolio_client', 'Portfolio Client', 'portfolio_client', 'portfolio', 'normal', 'default');
}
add_action( 'add_meta_boxes', 'add_metaboxes' );

function smashing_post_meta_boxes_setup() {
  add_action( 'add_meta_boxes', 'smashing_add_post_meta_boxes' );
  add_action( 'save_post', 'smashing_save_post_class_meta', 10, 2 );
}

function portfolio_client() {
	global $post; ?>

	<input type="hidden" name="portfolio_noncename" id="portfolio_noncename" value="<?php wp_create_nonce( plugin_basename(__FILE__) ) ?>" />
	<input type="text" name="_client" value="<?php echo get_post_meta($post->ID, '_client', true) ?>" class="widefat" />
<?php
}

/* Shortcodes
************************************/
function CodeXML($params, $content = null) {
	return '<pre><code class="language-markup">'.$content.'</code></pre>';
}

function CodeCSS($params, $content = null) {
	return '<pre><code class="language-css">'.$content.'</code></pre>';
}

function CodeJS($params, $content = null) {
	return '<pre><code class="language-javascript">'.$content.'</code></pre>';
}

function CodeBlank($params, $content = null) {
	return '<pre><code class="language-coffeescript">'.$content.'</code></pre>';
}

function CodeYoutube($params, $content = null) {
	$hash = explode('=', $content);
	return '<iframe class="aligncenter" width="640" height="360" src="//www.youtube.com/embed/'.$hash[1].'?rel=0" frameborder="0" allowfullscreen></iframe>';
}

function CodeNoteInfo($params, $content = null) {
	return '<div class="note note--info">'.$content.'</div>';
}

function CodeNoteQuestion($params, $content = null) {
	return '<div class="note note--question">'.$content.'</div>';
}

function CodeNoteImportant($params, $content = null) {
	return '<div class="note note--important">'.$content.'</div>';
}

function CodeNoteAlerte($params, $content = null) {
	return '<div class="note note--alert">'.$content.'</div>';
}

add_shortcode('xml', 'CodeXML');
add_shortcode('css', 'CodeCSS');
add_shortcode('js', 'CodeJS');
add_shortcode('blank', 'CodeBlank');
add_shortcode('youtube', 'CodeYoutube');
add_shortcode('info', 'CodeNoteInfo');
add_shortcode('question', 'CodeNoteQuestion');
add_shortcode('important', 'CodeNoteImportant');
add_shortcode('alert', 'CodeNoteAlerte');

/* Shortcodes version éditeur html
************************************/
function addQuicktags() {
	if (wp_script_is('quicktags')) : ?>
	<script>
		QTags.addButton('eg_xml', 'XML', '<pre><code class="language-markup">', '</code></pre>', '', 'Markup html/xml');
		QTags.addButton('eg_css', 'CSS', '<pre><code class="language-css">', '</code></pre>', '', 'Code CSS');
		QTags.addButton('eg_js', 'JS', '<pre><code class="language-javascript">', '</code></pre>', '', 'Code Javascript');
		QTags.addButton('eg_blank', 'Code', '<pre><code class="language-coffeescript">', '</code></pre>', '', 'Code Commun');
		QTags.addButton('eg_youtube', 'YouTube', '[youtube]', '[/youtube]', '', 'Vidéo YouTube');
		QTags.addButton('eg_note-info', 'Info', '<div class="note note--info">', '</div>', '', 'Bloc informatif');
		QTags.addButton('eg_note-question', 'Question', '<div class="note note--question">', '</div>', '', 'Bloc de question');
		QTags.addButton('eg_note-important', 'Important', '<div class="note note--important">', '</div>', '', 'Bloc important');
		QTags.addButton('eg_note-alert', 'Alerte', '<div class="note note--alert">', '</div>', '', 'Bloc d\'alerte');
	</script>
	<?php endif;
}

add_action('admin_print_footer_scripts', 'addQuicktags');

/* Boutons
************************************/
function new_buttons() {
	add_filter('mce_external_plugins', 'new_add_buttons');
	add_filter('mce_buttons', 'new_register_buttons');
}
function new_add_buttons($plugin_array) {
	$plugin_array['newbtn'] = get_bloginfo('template_url').'/js/customcodes.js';
	return $plugin_array;
}
function new_register_buttons($buttons) {
	array_push($buttons, 'xml', 'css', 'js', 'youtube');
	return $buttons;
}

add_action('init', 'new_buttons');

/** Sessions
************************************/
function generateToken() {
	return md5(uniqid(microtime(), true) + time());
}

function verifyToken($token) {

    // check if a session is started and a token is transmitted, if not return an error
	if (!isset($_SESSION['token'])) {
		return false;
    }

	// check if the form is sent with token in it
	if (!isset($_POST['token'])) {
		return false;
    }

	// compare the tokens against each other if they are still the same
	if ($_SESSION['token'] !== $token) {
		return false;
    }

	return true;
}

function wpSessionStart() {
	if (!session_id()) {
		@session_start();
		$_SESSION['tokenID'] = generateToken();
	}
}

function wpSessionStop() {
	if (isset($_SESSION['tokenID'])) {
		unset($_SESSION['tokenID']);
	}
	if (isset($_SESSION['mailChamps'])) {
		unset($_SESSION['mailChamps']);
	}
}

add_action('init', 'wpSessionStart', 1);
add_action('wp_logout', 'wpSessionStop');

/* Filtres
************************************/
function add_nofollow_cat($text) {
	return str_replace('rel="category tag"', "", $text);
}

add_filter('the_category', 'add_nofollow_cat');

function add_image_insert_override($sizes){
	unset( $sizes['thumbnail']);
	unset( $sizes['medium']);
	unset( $sizes['large']);

	return $sizes;
}

add_filter('intermediate_image_sizes_advanced', 'add_image_insert_override' );

function wpse_wpautop_nobr( $content ) {
	return wpautop( $content, false );
}

add_filter( 'the_content', 'wpse_wpautop_nobr' );
add_filter( 'the_excerpt', 'wpse_wpautop_nobr' );

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 */
function eb_post_classes( $classes ) {
	if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'eb_post_classes' );

/**
 * Espaces insécables automatiques dans les titres
 */
function insecables_title($title) {
	$title = str_replace (' « ', '&nbsp;«&nbsp;', $title);
	$title = str_replace (' » ', '&nbsp;»&nbsp;', $title);
	$title = str_replace (' : ', '&nbsp;:&nbsp;', $title);
	$title = str_replace (' ? ', '&nbsp;?&nbsp;', $title);
	$title = str_replace (' ! ', '&nbsp;!&nbsp;', $title);
	$title = str_replace (' ; ', '&nbsp;;&nbsp;', $title);
	$title = str_replace (' = ', '&nbsp;=&nbsp;', $title);
	$title = str_replace (' $ ', '&nbsp;$&nbsp;', $title);
	$title = str_replace (' € ', '&nbsp;$&nbsp;', $title);
	$title = str_replace (' £ ', '&nbsp;£&nbsp;', $title);
	$title = str_replace (' % ', '&nbsp;%&nbsp;', $title);
	return $title;
}
add_filter('the_title', 'insecables_title');

/* Fonctions
************************************/
function share_links($id) {
	$titreArticle = strtolower(str_replace(' ', '%20', get_the_title($id))); ?>
	<div class="post-share">
		<ul class="list-unstyled">
			<li><a class="post-share__link" title="Partager sur Twitter" href="https://twitter.com/share?url=<?php echo get_permalink($id); ?>&amp;text=<?php echo $titreArticle; ?>&amp;via=EmmanuelBeziat" rel="nofollow" data-link="share"><i class="gi gi-twitter"></i>Partager sur Twitter</a></li>
			<li><a class="post-share__link" title="Partager sur Faceook" href="https://www.facebook.com/sharer.php?u=<?php echo get_permalink($id); ?>&amp;t=<?php echo $titreArticle; ?>" rel="nofollow" data-link="share"><i class="gi gi-facebook-alt"></i>Partager sur Facebook</a></li>
			<li><a class="post-share__link" title="Partager sur Google+" href="https://plus.google.com/share?url=<?php echo get_permalink($id); ?>&amp;hl=fr" rel="nofollow" data-link="share"><i class="gi gi-googleplus-alt"></i>Partager sur Google+</a></li>
			<li><a class="post-share__link" title="Partager sur Linkedin" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo get_permalink($id); ?>&amp;title=<?php echo $titreArticle; ?>" rel="nofollow" data-link="share"><i class="gi gi-linkedin"></i>Partager sur Linkedin</a></li>
		</ul>
	</div>
<?php }

/**
 * Pagination dans les articles
 */
function custom_paging_nav($position) {
	global $wp_query, $wp_rewrite;

	// Ne pas mettre le code s'il n'y a pas d'autres pages
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation <?php echo $position; ?>">
		<div class="pagination loop-pagination">
			<div class="nav-previous"><?php next_posts_link( 'Articles précédents' ); ?></div>
			<div class="nav-next"><?php previous_posts_link( 'Articles suivants', '' ); ?></div>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
}

/**
 * Pagination pour les articles
 */
function custom_post_nav($position) {

	// Ne pas mettre le code s'il n'y a pas d'autres pages
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation post-navigation <?php echo $position; ?>">
		<div class="nav-links">
			<div class="nav-previous"><?php previous_post_link('%link'); ?></div>
			<div class="nav-next"><?php next_post_link('%link'); ?></div>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

/**
 * Renvoie la date de l'article
 */
function get_date_post() { ?>
	<div class="post-meta post-meta--header">Par <?php the_author(); ?>, le <time datetime="<?php the_time(__(DATE_W3C)); ?>"><?php the_time('j F Y'); ?></time><?php // dans <?php the_category(', '); ?></div>
<?php }

/**
 * Retire les classes par défaut du menu
 */
function menu_classes_item($classes) {
	if (!is_array($classes)) return;

	$current_indicators = ['current-menu-item', 'current-menu-parent', 'current_page_item', 'current_page_parent'];
	$newClasses = array();

	array_push($newClasses, 'navigation-main__item');

	return $newClasses;
}
add_filter('nav_menu_css_class', 'menu_classes_item', 100, 1);

add_filter('login_errors', create_function('$no_login_error', "return 'Mauvais identifiants';"));

/**
 * Retourne un var_dump de $arguments avec un markup lisible
 */
function debug($arguments) {
	echo '<pre class="language-markup"><code>';
	var_dump($arguments);
	echo '</code></pre>';
}

/**
 * Désactiver les rétroliens vers son propre site
 */
function mes_pings( &$liens ) {
	$home = get_option( 'home' );
	foreach ( $liens as $l => $lien )
		if ( 0 === strpos( $lien, $home ) )
			unset($liens[$l]);
}
add_action( 'pre_ping', 'mes_pings' );

/**
 * Twitter cards
 */
function twittercards() {
	if (is_single()) :
		global $wp_query, $post; ?>
<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:site" content="@emmanuelbeziat">
		<meta name="twitter:title" content="<?php echo get_the_title(); ?> :: Emmanuel B.">
		<meta name="twitter:url" content="<?php echo get_permalink(); ?>">
		<meta name="twitter:image:src" content="<?php echo has_post_thumbnail() ? wp_get_attachment_image_src( get_post_thumbnail_id($post->ID))[0] : 'http://www.emmanuelbeziat.com/wp-content/themes/emmanuelb/images/emmanuelb.png'; ?>">
		<meta name="twitter:description" content="<?php echo htmlspecialchars(strip_tags(explode('<!--more-->', $post->post_content)[0])) ?>">
	<?php
	else :
		global $wp_query, $post; ?>
<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:site" content="@emmanuelbeziat">
		<meta name="twitter:title" content="Emmanuel B.">
		<meta name="twitter:url" content="<?php echo get_permalink(); ?>">
		<meta name="twitter:image:src" content="http://www.emmanuelbeziat.com/wp-content/themes/emmanuelb/images/emmanuelb.png">
		<meta name="twitter:description" content="Portfolio en ligne d'un développeur web du sud. Billets de blogs, tutoriels, astuces, diatribes et réflexions sur le métier, le code et plein d'autres choses.">
	<?php
	endif;
}

/**
 * Facebook Meta
 */
function facebookmeta() {
	if (is_single()) :
			global $wp_query, $post; ?>
<meta property="og:title" content="<?php echo get_the_title() ; ?>">
		<meta property="og:site_name" content="Emmanuel B.">
		<meta property="og:type" content="article">
		<meta property="og:url" content="<?php echo get_permalink(); ?>">
		<meta property="og:locale:alternate" content="fr_FR">
		<meta property="og:description" content="<?php echo htmlspecialchars(strip_tags(explode('<!--more-->', $post->post_content)[0])) ?>">
		<meta property="og:image" content="<?php echo has_post_thumbnail() ? wp_get_attachment_image_src( get_post_thumbnail_id($post->ID))[0] : 'http://www.emmanuelbeziat.com/wp-content/themes/emmanuelb/images/emmanuelb.png'; ?>">
	<?php
	else :
		global $wp_query, $post; ?>
<meta property="og:title" content="Emmanuel Béziat">
		<meta property="og:site_name" content="Emmanuel B.">
		<meta property="og:type" content="article">
		<meta property="og:url" content="<?php echo get_permalink(); ?>">
		<meta property="og:locale:alternate" content="fr_FR">
		<meta property="og:description" content="Portfolio en ligne d'un développeur web du sud. Billets de blogs, tutoriels, astuces, diatribes et réflexions sur le métier, le code et plein d'autres choses.">
		<meta property="og:image" content="http://www.emmanuelbeziat.com/wp-content/themes/emmanuelb/images/emmanuelb.png">
	<?php
	endif;
}

/**
 * Rendu perso des commentaires
 */
function eb_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<header class="comment__header">
				<div class="comment__author">
					<?php printf( __( '<cite class="fn">%s</cite> <span class="says">dit :</span>' ), get_comment_author_link() ); ?>
				</div>
				<div class="comment__meta commentmetadata">
					<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf( __('%1$s à %2$s'), get_comment_date(),  get_comment_time() ); ?></a>
					<?php edit_comment_link( '(Modifier)', '', '' ); ?>
				</div>
				<?php if ( $comment->comment_approved == '0' ) : ?>
				<div class="comment__moderation">Commentaire en attente de modération</div>
				<?php endif; ?>
			</header>

			<div class="comment__content"><?php comment_text(); ?></div>

			<footer class="comment__footer">
				<div class="reply">
					<?php comment_reply_link( array_merge( $args, ['reply_text' => 'Répondre', 'depth' => $depth, 'max_depth' => $args['max_depth']] ) ); ?>
				</div>
			</footer>
		</div>
<?php
}