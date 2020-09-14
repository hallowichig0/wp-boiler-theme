<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootstrap4
 */
get_header();
while ( have_posts() ) : the_post();
?>
<!-- Page Content -->
<div id="content" class="site-content">
	<section class="container">
        <?php
        // Title
        the_title("<h1>", "</h1>");
        ?>
		<div class="row">
            <?php
            get_template_part( 'template-parts/content', 'page' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>
        </div><!-- .row -->
    </section><!-- .container -->
</div><!-- #content -->
<?php
endwhile;
get_footer();