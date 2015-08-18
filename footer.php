<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage EmmanuelB
 * @since Emmanuel B 2.5
 */
?>

			</div><!-- #main -->

			<footer id="footer" class="site-footer hidden-xl">
				<div class="site__info">
					<div class="hidden-xl">© <?php echo date('Y')?> Emmanuel Béziat</div>
				</div><!-- .site-info -->
			</footer><!-- #footer -->
		</div>

		<noscript>
			<div class="noscript">
				<div class="container">
					<h3 class="noscript__header">Javascript est désactivé sur votre navigateur !</h3>
					Il semble que les scripts soient désactivés sur votre navigateur, vous risquez de ne pas pouvoir consulter correctement le site.
				</div>
			</div>
		</noscript>

		<script src="<?php echo get_template_directory_uri(); ?>/js/main.min.js"></script>
		<script async src="http://cdn.infographizm.com/javascript/twitter/widgets.js"></script>
		<?php //wp_footer(); ?>
	</body>
</html>