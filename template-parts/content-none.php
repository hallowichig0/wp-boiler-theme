<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootstrap4
 */

?>

<section class="no-results not-found">
	<!-- .page-content -->
	<div class="page-content">
	<?php
	if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

		<div class="alert alert-info">No content assiged yet.</div>

	<?php elseif ( is_search() ) : ?>
		<div class="alert alert-info">Sorry, but nothing matched your search terms. Please try again with some different keywords.</div>
		<?php get_search_form(); ?>

	<?php else : ?>

		<div class="alert alert-info">It seems we can't find what you're looking for. Perhaps searching can help.</div>
		<?php get_search_form(); ?>

	<?php endif; ?>
	</div>
</section>
<!-- .no-results -->
