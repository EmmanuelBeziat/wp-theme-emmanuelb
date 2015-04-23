<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage EmmanuelB
 * @since Emmanuel B 2.5
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		//twentyfourteen_post_thumbnail();
		the_title( '<header class="post-header"><h1 class="post-header__title">', '</h1></header><!-- .entry-header -->' );
	?>
	<div class="post-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
