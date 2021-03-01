<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package Bootstrap4
 */
get_header();

// Kirki Variables
$switch_sidebar = get_theme_mod('sidebar_blog_toggleSwitch_setting');

while ( have_posts() ) : the_post();
?>
<!-- Page Content -->
<div id="content" class="site-content">
	<section class="container">
        
        <!-- Title -->
        <h1 class="entry-title mt-4">
            <?php if ( is_single() ) : ?>
                <?php echo get_the_title(); ?>
            <?php else: ?>
                <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php echo get_the_title(); ?></a>
            <?php endif; ?>

            <!-- Author -->
            <small>
                by
                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a>
            </small>
        </h1>

        <!-- Breadcrumb -->
        <?php get_breadcrumb(); ?>
        
		<div class="row">
            <div class="col-12 <?php echo !empty($switch_sidebar) ? 'col-md-12' : 'col-md-8'; ?>">
                <!-- Post Content Column -->
                <?php
                get_template_part( 'template-parts/content', 'single' );

                    the_post_navigation();
                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) {
                    comments_template();
                }
                ?>
            </div><!-- #first -->

            <?php
            if ( $switch_sidebar == true ):
                get_sidebar();
            endif;
            ?>
        </div><!-- .row -->
	</section><!-- .container -->
</div><!-- #content -->
<?php
endwhile;
get_footer();