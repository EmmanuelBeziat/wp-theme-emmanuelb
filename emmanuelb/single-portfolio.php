<?php
/**
 * The Template for displaying all single portfolio type
 *
 * @package WordPress
 * @subpackage EmmanuelB
 * @since Emmanuel B 2.5
 */

get_header();
get_sidebar('content');

// Start the Loop.
while (have_posts()) : the_post();

	// Navigation article précédent / suivant
	//custom_post_nav('navigation--top');

	/*
	 * Include the post format-specific template for the content. If you want to
	 * use this in a child theme, then include a file called called content-___.php
	 * (where ___ is the post format) and that will be used instead.
	 */
	get_template_part('content', 'portfolio');

	// Navigation article précédent / suivant
	//custom_post_nav('navigation--bottom');

	// Afficher les commentaires s'ils sont ouverts et s'il y en a au moins un
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
endwhile;

get_footer(); ?>