<?php

/**
 * Remove automatically generated <p> & </br> tag in content
 */
remove_filter( 'the_content', 'wpautop' );

/**
 * Remove automatically generated <p> & </br> tag in comment
 */
remove_filter('comment_text','wpautop',30);

/**
 * Excerpt Filters
 */
remove_filter( 'the_excerpt', 'wpautop' );

/**
 * Convert generated <p>&nbsp;</p> into </br> tag in content
 */
function add_newlines_to_post_content( $content ) {
    return nl2br( $content );
}
add_filter ( 'the_content', 'add_newlines_to_post_content' );

/**
 * Filter the except length to 20 words.
 */
function wpdocs_custom_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

/**
 * Filter the excerpt "read more" string.
 */
function wpdocs_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

/**
 * Filter for Next & Prev post link button
 */
function posts_link_attributes() {
    return 'class="page-link"';
}
add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

/**
 * Filter to add class in <li> tag in wp_nav_menu()
 */
function add_additional_class_on_li($classes, $item, $args) {
    if($args->add_li_class) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

/**
 * Filter to add class in <a> tag in wp_nav_menu()
 */
function add_additional_class_on_a($classes, $item, $args) {
    if($args->add_a_class) {
        $classes['class'] = $args->add_a_class;
    }
    return $classes;
}
add_filter('nav_menu_link_attributes', 'add_additional_class_on_a', 10, 3);

/**
 * @summary        filters an enqueued style tag and adds a noscript element after it
 * 
 * @description    filters an enqueued style tag (identified by the $handle variable) and
 *                 adds a noscript element after it.
 * 
 * @access    public
 * @param     string    $tag       The tag string sent by `style_loader_tag` filter on WP_Styles::do_item
 * @param     string    $handle    The script handle as sent by `script_loader_tag` filter on WP_Styles::do_item
 * @param     string    $href      The style tag href parameter as sent by `script_loader_tag` filter on WP_Styles::do_item
 * @param     string    $media     The style tag media parameter as sent by `script_loader_tag` filter on WP_Styles::do_item
 * @return    string    $tag       The filter $tag variable with the noscript element
 */
function add_noscript_filter($tag, $handle, $src){
    // as this filter will run for every enqueued script
    // we need to check if the handle is equals the script
    // we want to filter. If yes, than adds the noscript element
    if ( 'script-handle' === $handle ){
        $noscript = '<noscript>';
        // you could get the inner content from other function
        $noscript .= '<h1>You need to have JavaScript enabled to view this site.</h1>';
        $noscript .= '</noscript>';
        $tag = $tag . $noscript;
    }
        return $tag;
}
/**
 * adds the add_noscript_filter function to the script_loader_tag filters
 * it must use 3 as the last parameter to make $tag, $handle, $src available
 * to the filter function
 */
add_filter('script_loader_tag', 'add_noscript_filter', 10, 3);

/**
 * Add async on enqueue script
 */
function async_script($url)
{
    if ( strpos( $url, '#asyncscript') === false )
        return $url;
    else if ( is_admin() )
        return str_replace( '#asyncscript', '', $url );
    else
	return str_replace( '#asyncscript', '', $url )."' async='async"; 
}
add_filter( 'clean_url', 'async_script', 11, 1 );

/**
 * Change load of style to preload
 */
function async_style($url)
{
    if ( strpos( $url, '#asyncstyle') === false )
        return $url;
    else if ( is_admin() )
        return str_replace( '#asyncstyle', '', $url );
    else
	return str_replace( '#asyncstyle', '', $url )."' onload='this.media=\"all\""; 
}
add_filter( 'clean_url', 'async_style', 11, 1 );

/**
 * Filter to change cols and rows in "woocommerce checkout order notes"
 */
// function custom_override_checkout_fields( $fields ) {

//     $fields['order']['order_comments']['custom_attributes'] = array('cols' => 100, 'rows' => 9);

//     return $fields;
// }
// add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
