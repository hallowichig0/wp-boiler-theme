<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootstrap4
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				// $comments_number = get_comments_number();
				// if ( 1 === $comments_number ) {
				// 	/* translators: %s: post title */
				// 	printf( _x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'twentysixteen' ), get_the_title() );
				// } else {
				// 	printf(
				// 		/* translators: 1: number of comments, 2: post title */
				// 		_nx(
				// 			'%1$s thought on &ldquo;%2$s&rdquo;',
				// 			'%1$s thoughts on &ldquo;%2$s&rdquo;',
				// 			$comments_number,
				// 			'comments title',
				// 			'twentysixteen'
				// 		),
				// 		number_format_i18n( $comments_number ),
				// 		get_the_title()
				// 	);
				// }
			?>
        </h2>
        <?php the_comments_navigation(); ?>

		<ul class="comment-list">
			<?php
				wp_list_comments( array( 'callback' => 'bootstrap4_comment', 'avatar_size' => 50 ));
			?>
		</ul><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

<?php endif; // Check for have_comments(). ?>

<?php
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
?>
<p class="no-comments"><?php _e( 'Comments are closed.', 'bootstrap4' ); ?></p>
<?php endif; ?>

    <!-- Comments Form -->
    <div class="card my-4">
    <?php
        comment_form( array(
            'title_reply'        => __( 'Leave a Reply', 'bootstrap4' ),
            'title_reply_to'     => __( 'Leave a Reply to %s', 'bootstrap4' ),
            'title_reply_before' => '<h5 class="card-header">',
            'title_reply_after'  => '</h5><div class="card-body">',

            'comment_field' => '<div class="form-group"><textarea id="comment" name="comment" class="form-control" rows="3"></textarea></div>',
            'label_submit'  => 'Submit',
            'class_submit'  => 'btn btn-primary',
            'submit_field'  => '<div class="form-submit">%1$s %2$s</div></div>',
        ) );
    ?>
    </div>

</div>