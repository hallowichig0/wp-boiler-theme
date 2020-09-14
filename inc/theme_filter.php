<?php

// Remove automatically generated <p> & </br> tag in content
remove_filter( 'the_content', 'wpautop' );

// Remove automatically generated <p> & </br> tag in comment
remove_filter('comment_text','wpautop',30);

// Excerpt Filters
remove_filter( 'the_excerpt', 'wpautop' );

// Filter the except length to 20 words.
function wpdocs_custom_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

// Filter the excerpt "read more" string.
function wpdocs_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

// Filter for Next & Prev post link button
function posts_link_attributes() {
    return 'class="page-link"';
}
add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

// Filter to add class in <li> tag in wp_nav_menu()
function add_additional_class_on_li($classes, $item, $args) {
    if($args->add_li_class) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

// Filter to add class in <li> tag in wp_nav_menu()
function add_additional_class_on_a($classes, $item, $args) {
    if($args->add_a_class) {
        $classes['class'] = $args->add_a_class;
    }
    return $classes;
}
add_filter('nav_menu_link_attributes', 'add_additional_class_on_a', 10, 3);

// Filter to change cols and rows in "woocommerce checkout order notes"
function custom_override_checkout_fields( $fields ) {

    $fields['order']['order_comments']['custom_attributes'] = array('cols' => 100, 'rows' => 9);

    return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );