<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage EmmanuelB
 * @since Emmanuel B 2.5
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php
			get_sidebar('content');
			if (have_posts()) : ?>

			<header class="page__header">
				<h1 class="page__title page__title--alt">Résultats de recherche pour « <?php echo get_search_query(); ?> »</h1>
			</header><!-- .page-header -->

				<?php
					custom_paging_nav('navigation--top');
					// Start the Loop.
					while (have_posts()) : the_post();

						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part('content', get_post_format());

					endwhile;
					// Navigation article précédent / suivant
					custom_paging_nav('navigation--bottom');

				else :
					// S'il n'y a pas de contenu, inclure le template "aucun post trouvé" (none.php)
					get_template_part( 'content', 'none' );

				endif;
			?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_footer(); ?>