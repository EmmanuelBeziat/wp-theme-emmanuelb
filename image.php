<?php
/**
 * The template for displaying image attachments
 *
 * @package WordPress
 * @subpackage EmmanuelB
 * @since Emmanuel B 2.5
 */

// Retrieve attachment metadata.
$metadata = wp_get_attachment_metadata();

get_header();

get_sidebar('content');
// Start the Loop.
while (have_posts()) : the_post();
?>
	<article <?php post_class(); ?>>
		<header class="post__header">
			<?php the_title( '<h1 class="post-header__title">', '</h1>' ); ?>

			<div class="post-meta">

				<span class="post__date"><time class="post__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></span>

				<span class="full-size-link"><a href="<?php echo wp_get_attachment_url(); ?>"><?php echo $metadata['width']; ?> &times; <?php echo $metadata['height']; ?></a></span>

				<span class="parent-post-link"><a href="<?php echo get_permalink( $post->post_parent ); ?>" rel="gallery"><?php echo get_the_title( $post->post_parent ); ?></a></span>
				<?php edit_post_link( __( 'Edit', 'twentyfourteen' ), '<span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-meta -->
		</header><!-- .entry-header -->

		<div class="post-content">
			<div class="post__attachment">
				<div class="attachment">
					<?php //twentyfourteen_the_attached_image(); ?>
				</div><!-- .attachment -->

				<?php if ( has_excerpt() ) : ?>
				<div class="post__caption">
					<?php the_excerpt(); ?>
				</div><!-- .entry-caption -->
				<?php endif; ?>
			</div><!-- .entry-attachment -->

			<?php
				the_content();
				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfourteen' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
			?>
		</div><!-- .entry-content -->
	</article><!-- #post-## -->

	<nav class="navigation image-navigation">
		<div class="nav-links">
		<?php previous_image_link( false, '<div class="previous-image">' . __( 'Previous Image', 'twentyfourteen' ) . '</div>' ); ?>
		<?php next_image_link( false, '<div class="next-image">' . __( 'Next Image', 'twentyfourteen' ) . '</div>' ); ?>
		</div><!-- .nav-links -->
	</nav><!-- #image-navigation -->

	<?php comments_template(); ?>

		<?php endwhile;
get_footer(); ?>