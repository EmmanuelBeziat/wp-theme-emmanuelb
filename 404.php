<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage EmmanuelB
 * @since Emmanuel B 2.5
 */

get_header(); ?>


	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<header class="page__header">
				<h1 class="page__title">Page introuvable</h1>
			</header>

			<div class="page-content">
				<p>Ce que vous cherchez n'est pas ici. Avez-vous essayé une recherche ?</p>

				<?php get_search_form(); ?>
			</div><!-- .page-content -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>