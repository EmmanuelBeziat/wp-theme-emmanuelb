<?php
/**
 * Template Name: Accueil
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage EmmanuelB
 * @since Emmanuel B 2.5
 */

get_header(); ?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<section id="accueil" class="homepage">

				<h1 class="main-title vcard" id="hcard-Emmanuel-Béziat">
					<span class="block-type fn hcard__name">Emmanuel B.</span>
					<span class="block-type"><span class="hcard__age">28 ans</span> <span class="hcard__status">Freelance</span></span>
					<span class="block-type hcard__job">Développeur web</span>
					<span class="block-type hcard__job--alt">Infographiste</span>
				</h1>

				<div id="competences" class="skills">
					<ul class="skill__list">
						<li class="skill__item" data-skill="100">HTML / CSS</li>
						<li class="skill__item" data-skill="60">Javascript / jQuery</li>
						<li class="skill__item" data-skill="60">PHP</li>
						<li class="skill__item" data-skill="70">WordPress</li>
						<li class="skill__item" data-skill="40">C# .NET</li>
						<li class="skill__item" data-skill="60">SQL</li>
					</ul>
					<ul class="skill__list">
						<li class="skill__item" data-skill="90">Graphisme 2D</li>
						<li class="skill__item" data-skill="60">Graphisme 3D</li>
						<li class="skill__item" data-skill="40">Animation</li>
						<li class="skill__item" data-skill="40">Audio-visuel</li>
					</ul>
					<ul class="skill__list">
						<li class="skill__item" data-skill="70">Windows</li>
						<li class="skill__item" data-skill="50">Linux (Debian)</li>
						<li class="skill__item" data-skill="30">Mac OSX</li>
					</ul>
				</div>
			</section>

			<section id="portfolio" class="portfolio">
				<h2 class="section__title">Portfolio</h2>

				<div class="portfolio-list">
					<?php
					$args = array(
						'post_type' => 'portfolio',
						'post_status' => 'publish',
						'posts_per_page' => -1,
						'caller_get_posts'=> 1
						);

					$query = new WP_Query($args);
					if ($query->have_posts()) :

						while ($query->have_posts()) : $query->the_post();
							$image_attr = array('class' => 'portfolio__thumbnail');
							$colorclass = get_post_meta(get_the_ID(), 'portfolio-background', true);
						?>

						<figure class="portfolio__item">
							<a href="<?php the_permalink() ?>" class="portfolio__link <?php echo isset($colorclass) ? $colorclass : ''; ?>" title="<?php the_title_attribute(); ?>">
								<div class="portfolio__image">
									<?php the_post_thumbnail(array(340,160), $image_attr); ?>
								</div>

								<div class="portfolio-caption">
									<h2 class="portfolio-caption__title"><?php echo get_the_title(); ?></h2>
									<div class="portfolio-categories">
										<ul class="list-unstyled">
											<?php foreach (get_the_terms(get_the_ID(), 'portfolio_category') as $category): ?>
											<li class="portfolio-categories__item">
												<i class="gi gi-<?php echo $category->slug; ?>"></i>
												<span class="portfolio-categories__name sr-only"><?php echo $category->name; ?></span>
											</li>
											<?php endforeach; ?>
										</ul>
									</div>
								</div>
							</a>
						</figure>

						<?php
						endwhile;
					endif;

					wp_reset_query();
					?>
				</div>
				<h3 class="portfolio__thanks">Et bien d'autres encore, au fil des ans (Merci <i>♥</i> !)</h3>
			</section>

			<section id="contact" class="contact">
				<h2 class="section__title">Contact</h2>
				<p>Si vous voulez me dire un petit mot, me poser des questions ou bien me proposer du travail, vous pouvez me contacter sur <a href="https://twitter.com/RhooManu" target="_blank">Twitter</a>, <a href="http://fr.viadeo.com/fr/profile/emmanuel.b1" target="_blank">viadeo</a> ou encore <a href="http://lnkd.in/Gg_f_2" target="_blank">LinkedIn</a>, me téléphoner en scannant le <em>QRcode</em> ci-dessous avec votre mobile, ou bien m'envoyer un e-mail via le formulaire en-dessous.</p>
				<p>N'hésitez pas, je ne mords que les jours de pluie !</p>

				<h3 class="middle-title">Bonus QR-code !</h3>
				<div class="qrcode"></div>

				<h3 class="middle-title">Un petit mail</h3>
				<form action="<?php echo get_template_directory_uri(); ?>/contact-form.php" method="post" id="contact-form" class="contact-form modern-form" autocomplete="off">
					<input type="hidden" name="tokenID" value="<?php echo (isset($_SESSION['tokenID'])) ? $_SESSION['tokenID'] : '' ?>">

					<div class="form-group">
						<label class="form-label" for="name">Nom</label>
						<input id="name" class="form-input" name="name" type="text" value="<?php echo (isset($_SESSION['mailChamps']['name'])) ? $_SESSION['mailChamps']['name'] : '' ?>" required>
					</div>

					<div class="form-group sr-only">
						<label class="form-label" for="firstname">Ne pas remplir !<i class="gi gi-star"></i></label>
						<input id="firstname" class="form-input" name="firstname" type="text" tabindex="-1">
					</div>

					<div class="form-group">
						<label class="form-label" for="email">Adresse e-mail</label>
						<input id="email" class="form-input" name="email" type="email" value="<?php echo (isset($_SESSION['mailChamps']['email'])) ? $_SESSION['mailChamps']['email'] : '' ?>" required>
					</div>

					<div class="form-group">
						<label class="form-label" for="message">Message</label>
						<textarea id="message" class="form-input" name="message" required><?php echo (isset($_SESSION['mailChamps']['message'])) ? $_SESSION['mailChamps']['message'] : '' ?></textarea>
					</div>

					<div class="form-submit">
						<button name="submit" class="button" type="submit" id="submit"><i class="gi gi-mail"></i> Envoyer un mail</button>
					</div>
				</form>

				<div class="contact-alerts">
					<div class="dialog" id="contact-alert" role="dialog">
						<div class="dialog__content">
							<header class="dialog__header"></header>
							<div class="dialog__body"></div>
							<footer class="dialog__footer">
								<button type="button" class="dialog__close button" data-dismiss="alert">Fermer</button>
							</footer>
						</div>
					</div>
					<div class="dialog-overlay"></div>
				</div>
			</section>

		</div>
	</div>
</div><!-- #main-content -->

<?php get_footer(); ?>
