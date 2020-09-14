<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootstrap4
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <!-- Preview Image -->
    <?php
    if ( has_post_thumbnail() ) {
        echo get_the_post_thumbnail( $post_id, 'post-thumbnails', array( 'class' => 'img-fluid rounded' ) );
    } 
    ?>

    <hr>

    <!-- Date/Time -->
    <p>
        <?php
        $day = get_the_date('F d, Y');
        $time = get_the_date('h:m A');
        echo 'Posted on ' . $day . ' at ' . $time;
        ?>
    </p>

    <hr>

    <!-- Post Content -->
    <div class="entry-content">
        <?php 
        the_content();

        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bootstrap4' ),
            'after'  => '</div>',
        ) );
        ?>
    </div>
    <hr>

</article>