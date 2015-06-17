<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage EmmanuelB
* @since Emmanuel B 2.5
 */
?>

<?php
$categories = '';
foreach (get_the_terms(get_the_ID(), 'portfolio_category') as $category):
	$categories .= '<span class="portfolio-single-meta__category"><i class="gi gi-'.$category->slug.'"></i> '.$category->name.'</span>';
endforeach;
?>

<div class="note note--info">
	<h4>Les pages du portfolio sont encore en développement</h4>
	Soyez indulgent•e, ce genre de choses prend du temps !
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class('portfolio-single'); ?>>

	<?php
	// Output the featured image.
	if ( has_post_thumbnail() ) :
		$colorclass = get_post_meta(get_the_ID(), 'portfolio-background', true); ?>
		<div class="portfolio-single__thumbnail <?php echo isset($colorclass) ? $colorclass : ''; ?>"><?php the_post_thumbnail(); ?></div>
	<?php endif; ?>

	<header class="portfolio-single__header">
		<?php the_title( '<h1 class="portfolio-single__title">', '</h1>' ); ?>
		<div class="portfolio-single-meta">
			<div class="portfolio-single-meta__clients">
				<span class="portfolio-single-meta__label">Client</span> <?php echo get_post_meta(get_the_ID(), 'portfolio-client', true) ?>
			</div>
			<div class="portfolio-single-meta__categories">
				<span class="portfolio-single-meta__label">Type</span> <?php echo $categories ?>
			</div>
		</div>
	</header><!-- .entry-header -->

	<div class="post-content">
		<?php the_content(); ?>
	</div><!-- .post-content -->

</article><!-- #post-## -->