<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Bootstrap4
 */

get_header();
?>
<!-- Page Content -->
<div id="content" class="site-content">
	<section class="container">
		<div class="row">
			<div class="col-12">
				<?php
				if ( have_posts() ) { ?>
					<div class="page-header mt-4">
						<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'Bootstrap4' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</div><!-- .search-result -->

					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						// Include the Post-Format-specific template for the content.
						get_template_part( 'template-parts/content', get_post_format() );

					endwhile;
					?>

					<!-- Pagination -->
					<ul class="pagination justify-content-center mb-4">
						<li class="page-item">
							<?php echo get_previous_posts_link('&larr; Newer'); ?>
						</li>
						<li class="page-item">
							<?php echo get_next_posts_link('older &rarr;'); ?>
						</li>
					</ul>

				<?php
				}
				else {
					get_template_part( 'template-parts/content', 'none' );
				}
				?>
			</div><!-- #first -->
		</div><!-- .row -->
	</section><!-- .container -->
</div><!-- #content -->
<?php
get_footer();