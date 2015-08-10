<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage EmmanuelB
* @since Emmanuel B 2.5
 */
?>

<?php if ( has_nav_menu( 'top' ) ) : ?>
<nav class="navigation site-navigation">
	<?php wp_nav_menu(array(
		'theme_location' => 'top',
		'container' => false,
		'menu_class' => 'navigation-main',
		'menu_id' => 'main-menu'
	)); ?>
</nav>
<?php endif; ?>