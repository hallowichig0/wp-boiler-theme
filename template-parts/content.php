<?php
/**
 * Template part for displaying all posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootstrap4
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <!-- Blog Post -->
    <div class="card mb-4">
        <!-- Preview Image -->
        <?php
        if ( has_post_thumbnail() ) {
            echo get_the_post_thumbnail( $post_id, 'post-thumbnails', array( 'class' => 'img-fluid rounded' ) );
        } 
        ?>
        <div class="card-body">
            <!-- Title -->
            <?php
            if ( is_single() ) :
                the_title('<h2 class="entry-title card-title">', '</h2>');
            else:
                the_title('<h2 class="entry-title card-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>');
            endif;
            ?>
            <p class="card-text"><?php the_excerpt('',FALSE,''); // This is the short post content ?></p>
            <a href="<?php the_permalink(); // Get the link to this post ?>" class="btn btn-primary">Read More &rarr;</a>
        </div>
        <div class="card-footer text-muted">
            <!-- Date/Time -->
            <?php echo 'Posted on ' . get_the_date('F d, Y') ; ?>
            by
            <!-- Author -->
            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a>
        </div>
    </div>

</article>