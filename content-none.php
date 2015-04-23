<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @package WordPress
 * @subpackage EmmanuelB
 * @since Emmanuel B 2.5
 */
?>

<header class="page__header">
	<h1 class="page__title">Aucun contenu trouvé</h1>
</header>

<div class="page-content">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

	<h3>Ce site est vide</h3>
	<p>Écrivez un premier article.</p>

	<?php elseif ( is_search() ) : ?>

	<h3>Aucun résultat</h3>
	<p>Essayez avec d'autres termes de recherche</p>
	<?php get_search_form(); ?>

	<?php else : ?>

	<h3>Impossible de trouver le contenu</h3>
	<?php get_search_form(); ?>

	<?php endif; ?>
</div><!-- .page-content -->
