<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootstrap4
 */
get_header(); ?>
<!-- Page Content -->
<div id="content" class="site-content">
	<section class="container">
		<div class="row">
			<div class="col-sm-12 <?php
			if(class_exists( 'Kirki' )){
				if ( false == get_theme_mod('sidebar_blog_toggleSwitch_setting')) :
					echo 'col-md-12';
				else:
					echo 'col-md-8';
				endif;
			}else{
				echo 'col-md-12';
			}
			?>">

				<?php
				if ( have_posts() ) : ?>

					<div class="page-header mt-4">
						<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="archive-description">', '</div>' );
						?>
					</div><!-- .archive-title -->

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
							<?php
							echo get_previous_posts_link('&larr; Newer');
							?>
						</li>
						<li class="page-item">
							<?php
							echo get_next_posts_link('older &rarr;');
							?>
						</li>
					</ul>

				<?php
				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>

			</div><!-- #first -->
			<?php
			if(class_exists( 'Kirki' )){
				if ( true == get_theme_mod('sidebar_blog_toggleSwitch_setting')) :
					get_sidebar();
				endif;
			}
			?>
		</div><!-- .row -->
	</section><!-- .container -->
</div><!-- #content -->
<?php
get_footer();