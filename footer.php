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

			<footer id="footer" class="site-footer hidden-xl" role="contentinfo">
				<div class="site__info">
					<div class="hidden-xl">© <?php echo date('Y')?> Emmanuel Béziat</div>
				</div><!-- .site-info -->
			</footer><!-- #footer -->
		</div>

		<script src="<?php echo get_template_directory_uri(); ?>/js/main.min.js"></script>
		<script async src="http://cdn.infographizm.com/javascript/twitter/widgets.js"></script>
		<?php //wp_footer(); ?>
	</body>
</html>