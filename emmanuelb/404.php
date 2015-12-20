<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage EmmanuelB
 * @since Emmanuel B 2.5
 */

get_header(); ?>

<section class="site-content">

	<header class="page__header">
		<h1 class="page__title">Page introuvable</h1>
	</header>

	<div class="page-content">
		<p>Ce que vous cherchez n'est pas ici. Avez-vous essayé une recherche ?</p>

		<?php get_search_form(); ?>
	</div><!-- .page-content -->
</section>

<?php get_footer(); ?>