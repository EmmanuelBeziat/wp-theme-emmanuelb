<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Fourteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage EmmanuelB
 * @since Emmanuel B 2.5
 */

get_header(); ?>

<section class="site-content">

		<?php
		get_sidebar('content');

		if (have_posts()) : ?>

		<header class="page__header">
			<h1 class="page__title page__title--alt">
				<?php
					if ( is_day() ) :
						printf( 'Archives quotidiennes: %s', get_the_date() );

					elseif ( is_month() ) :
						printf('Archives mensuelles: %s', get_the_date( _x( 'F Y', 'monthly archives date format', 'twentyfourteen' ) ) );

					elseif ( is_year() ) :
						printf('Archives annuelles: %s', get_the_date( _x( 'Y', 'yearly archives date format', 'twentyfourteen' ) ) );

					else :
						echo 'Archives';

					endif;
				?>
			</h1>
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
				// Previous/next page navigation.
				custom_paging_nav('navigation--bottom');

			else :
				// S'il n'y a pas de contenu, inclure le template "aucun post trouvé" (none.php)
				get_template_part( 'content', 'none' );

			endif;
		?>
</section><!-- #primary -->

<?php get_footer(); ?>
