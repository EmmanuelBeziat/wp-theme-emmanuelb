<?php
/**
 * The template for displaying Author archive pages
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
				/*
				 * Queue the first post, that way we know what author
				 * we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop properly
				 * with a call to rewind_posts().
				 */
				the_post();

				printf( 'Tous les articles rédigés par  %s', get_the_author() );
			?>
		</h1>
		<?php if ( get_the_author_meta( 'description' ) ) : ?>
		<div class="author-description"><?php the_author_meta( 'description' ); ?></div>
		<?php endif; ?>
	</header><!-- .archive-header -->

	<?php
			/*
			 * Since we called the_post() above, we need to rewind
			 * the loop back to the beginning that way we can run
			 * the loop properly, in full.
			 */
			rewind_posts();

			// Start the Loop.
			while (have_posts()) : the_post();

				/*
				 * Include the post format-specific template for the content. If you want to
				 * use this in a child theme, then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part('content', get_post_format());

			endwhile;

		else :
			// S'il n'y a pas de contenu, inclure le template "aucun post trouvé" (none.php)
			get_template_part( 'content', 'none' );

		endif;
	?>
</section><!-- #primary -->

<?php get_footer(); ?>