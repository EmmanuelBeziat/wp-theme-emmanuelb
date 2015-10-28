<?php
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
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
		<h1 class="page__title page__title--alt">Tag « <?php echo single_tag_title('', false); ?> »</h1>

		<?php
			// Show an optional term description.
			$term_description = term_description();
			if ( ! empty( $term_description ) ) :
				printf( '<div class="taxonomy-description">%s</div>', $term_description );
			endif;
		?>
	</header><!-- .archive-header -->

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