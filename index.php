<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage EmmanuelB
 * @since Emmanuel B 2.5
 */

get_header(); ?>

<div id="main-content" class="main-content">

<?php
	/*if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}*/
?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php
			get_sidebar('content');
			if (have_posts()) :

				// Navigation article précédent / suivant
				custom_paging_nav('navigation--top');

				// Boucle wordpress
				while (have_posts()) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format());

				endwhile;
				// Navigation article précédent / suivant
				custom_paging_nav('navigation--bottom');
			else :
				// S'il n'y a pas de contenu, inclure le template "aucun post trouvé" (none.php)
				get_template_part( 'content', 'none' );

			endif;
		?>

		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php get_footer(); ?>