<?php
/**
 * The Content Sidebar
 *
 * @package WordPress
 * @subpackage Emmanuel B
 * @since Emmanuel B 2.5
 */
?>
<div class="search-box-wrapper">
	<div class="search-box">
		<form method="get" class="search-form modern-form" action="<?php echo get_option('siteurl'); ?>" autocomplete="off">
			<div class="form-group">
				<label class="form-label">Rechercher&nbsp;:</label>
				<input type="search" class="form-input" value="<?php get_search_query(); ?>" name="s" title="Rechercher&nbsp;:">
				<button type="submit" class="button-search"><i class="icon-search"></i></button>
			</div>
		</form>
	</div>
</div>
