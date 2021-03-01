<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Bootstrap4
 */

get_header(); ?>
<!-- Page Content -->
<div id="content" class="site-content">
	<section class="container">
		<div class="row">
			<div class="col-12">

				<section class="error-404 not-found">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'bootstrap4' ); ?></h1>
					</header><!-- .page-header -->

					<div class="page-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'bootstrap4' ); ?></p>

						<?php
							get_search_form();
						?>

					</div><!-- .page-content -->
				</section><!-- .error-404 -->

			</div><!-- #first -->
		</div><!-- .row -->
	</section><!-- .container -->
</div><!-- #content -->
<?php
get_footer();