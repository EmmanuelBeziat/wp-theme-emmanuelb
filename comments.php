<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage EmmanuelB
* @since Emmanuel B 2.5
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments">

	<?php if (have_comments()): ?>

	<h2 class="comments__title">Commentaires</h2>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comments__navigation comments__navigation--top" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text">Liste de commentaires</h1>
		<div class="nav-previous"><?php previous_comments_link('Commentaires précédents'); ?></div>
		<div class="nav-next"><?php next_comments_link('Commentaires suivants'); ?></div>
	</nav><!-- #comment-nav-above -->
	<?php endif; // Check for comment navigation. ?>

	<ol class="comment-list">
		<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size'=> 34,
				'callback' => 'eb_comments'
			) );
		?>
	</ol><!-- .comment-list -->

	<?php if (get_comment_pages_count() > 1 && get_option( 'page_comments' )) : ?>
	<nav id="comments__navigation comments__navigation--bottom" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text">Liste de commentaires</h1>
		<div class="nav-previous"><?php previous_comments_link('Commentaires précédents'); ?></div>
		<div class="nav-next"><?php next_comments_link('Commentaires suivants'); ?></div>
	</nav><!-- #comment-nav-below -->
	<?php endif; // Check for comment navigation. ?>

	<?php endif; // have_comments() ?>

	<?php if (!comments_open()): ?>
	<p class="comments__none">Les commentaires de cet article sont fermés</p>
	<?php else: ?>

	<h2 class="comments__title">Laisser un commentaire</h2>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" class="comment-form modern-form" autocomplete="off">

		<?php if (is_user_logged_in()): ?>

			<p>Connecté en tant que <a href="<?php echo get_option('siteurl').'/wp-admin/profile.php'; ?>"><?php echo $user_identity; ?></a> (<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Déconnexion">Se déconnecter</a>)</p>

		<?php else: ?>

			<div class="comment-form__info">
				<p>Votre adresse de messagerie ne sera pas publiée. Les champs obligatoires sont indiqués avec <i class="gi gi-star"></i></p>
				<div class="note note--info">Si vous avez un problème avec un code, utilisez <a href="http://jsfiddle.net/" title="JsFiddle" target="_blank">JSFiddle</a>, <a href="http://codepen.io" title="CodePen" target="_blank">CodePen</a>, <a href="http://dabblet.com/" title="Dabblet" target="_blank">Dabblet</a> (etc.) pour le montrer. Si votre problème est plus complexe, postez plutôt sur un forum d'entraide comme <a href="http://zestedesavoir.com/" title="ZesteDeSavoir" target="_blank">Zeste De Savoir</a> ou <a href="http://fr.openclassrooms.com" title="Openclassrooms" target="_blank">OpenClassrooms</a>.</div>
			</div>

			<div class="form-group">
				<label class="form-label" for="author">Nom <i class="gi gi-star"></i></label>
				<input id="author" class="form-input" name="author" type="text" value="<?php echo esc_attr($comment_author)?>" required>
			</div>

			<div class="form-group">
				<label class="form-label" for="email">Adresse e-mail <i class="gi gi-star"></i></label>
				<input id="email" class="form-input" name="email" type="email" value="<?php echo esc_attr($comment_author_email)?>" required>
			</div>

			<div class="form-group">
				<label class="form-label" for="url">Site web</label>
				<input id="url" class="form-input" name="url" type="url" value="<?php echo esc_attr($comment_author_url)?>">
			</div>

		<?php endif; ?>

		<div class="form-group" id="respond">
			<label class="form-label" for="comment">Commentaire <i class="gi gi-star"></i></label>
			<textarea id="comment" class="form-input" name="comment" required></textarea>
		</div>

		<div class="form-submit">
			<button name="submit" class="button" type="submit" id="submit"><i class="gi gi-comment"></i> Laisser un commentaire</button>
			<?php comment_id_fields(); ?>
		</div>

		<?php do_action('comment_form', $post->ID); ?>
	</form>
	<?php endif; ?>

</div><!-- #comments -->