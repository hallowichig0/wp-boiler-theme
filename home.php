<?php
/**
 * Template for displaying all blog post
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootstrap4
 */

get_header();

// Kirki Variables
$switch_sidebar = get_theme_mod('sidebar_blog_toggleSwitch_setting');
?>
<!-- Page Content -->
<div id="content" class="site-content">
	<section class="container">
		<div class="row">
			<div class="col-sm-12 <?php echo $switch_sidebar == false ? 'col-md-12' : 'col-md-8'; ?>">
			
				<?php if ( have_posts() ) { ?>
					<?php if ( is_home() ): ?>
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					<?php endif; ?>
					
					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						* Include the Post-Format-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Format name) and that will be used instead.
						*/
						get_template_part( 'template-parts/content', 'home' );

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
			<?php
			if(is_home()) {
				if ( $switch_sidebar == true ):
					get_sidebar();
				endif;
			}
			?>
		</div><!-- .row -->
	</section><!-- .container -->
</div><!-- #content -->
<?php
get_footer();