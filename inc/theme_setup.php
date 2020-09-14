<?php
/**
 * All theme setup
 *
 *
 * @package Bootstrap4
 */

 // Display a pop-up message when trying to activate this theme without activated kirki plugin
function check_theme_dependencies( $oldtheme_name, $oldtheme ) {
    if ( !class_exists( 'Kirki' ) ) :
        add_filter( 'gettext', 'update_activation_admin_notice_kirki', 10, 3 );
        add_action( 'admin_head', 'error_activation_admin_notice' );
        switch_theme( $oldtheme->stylesheet );
        return false;
    endif;

    if ( !class_exists( 'ACF' ) ) :
        add_filter( 'gettext', 'update_activation_admin_notice_acf', 10, 3 );
        add_action( 'admin_head', 'error_activation_admin_notice' );
        switch_theme( $oldtheme->stylesheet );
        return false;
    endif;
}
add_action( 'after_switch_theme', 'check_theme_dependencies', 10, 2 );

// Kirki validation text
function update_activation_admin_notice_kirki( $translated, $original, $domain ) {
    $strings = array(
        'New theme activated.' => 'Theme not activated. Bootstrap4 Theme has dependency with kirki plugin. You must activate <a target="_blank" href="https://wordpress.org/plugins/kirki/">kirki plugin</a> first before activating this theme.'
    );

    if ( isset( $strings[$original] ) ) {
        $translations = get_translations_for_domain( $domain );
        $translated = $translations->translate( $strings[$original] );
    }

    return $translated;
}

// ACF validation text
function update_activation_admin_notice_acf( $translated, $original, $domain ) {
    $strings = array(
        'New theme activated.' => 'Theme not activated. Bootstrap4 Theme has dependency with ACF plugin. You must activate <a target="_blank" href="https://wordpress.org/plugins/advanced-custom-fields/">ACF plugin</a> first before activating this theme.'
    );

    if ( isset( $strings[$original] ) ) {
        $translations = get_translations_for_domain( $domain );
        $translated = $translations->translate( $strings[$original] );
    }

    return $translated;
}

function error_activation_admin_notice() {
    echo '<style>#message2{border-left-color:#dc3232;}</style>';
}

// Registration of theme setup. (i.e: Register menu, adding logo, adding thumbnail & etc...)
function bootstrap4_setup() {
    // Header Logo
    add_theme_support( 'custom-logo', array(
            'height'      => 100,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => array( 'site-title', 'site-description'),
    ));

    // Post Thumbnail Image
    add_theme_support( 'post-thumbnails');

    // Banner Size
    add_image_size( 'banner_scale', 1920, 1080, true );

    // Register Navigation Menu
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'bootstrap4' ),
    ) );
}
add_action( 'after_setup_theme', 'bootstrap4_setup' );

function theme_prefix_the_custom_logo() {
	
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}

}

// register new post type called -> book
function register_post_type_program()
{

	$args = array(
		'labels' => array(
			'name' => __('Programs', 'program'),
            'singular_name' => __('Program', 'program'),
            'all_items' => 'All Programs',
		),
		'description' => '',
		'supports' => array('title', 'editor', 'thumbnail',),
		'taxonomies' => array('program'),
		'public' => true,
		'menu_position' => 20,
        'menu_icon' => 'dashicons-pressthis',
		'has_archive' => true,
		'capability_type' => 'post',
        'rewrite' => array('slug' => 'program', 'with_front' => false),
	);

	register_post_type('program', $args);
}
add_action('init', 'register_post_type_program');

// we need to flush the new register post type
function my_rewrite_flush()
{
	register_post_type_program();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'my_rewrite_flush' );

// pre_get_posts function added to include custom post type "program" in author loop
function add_cpt_program_in_author( $query ) {
    if ( !is_admin() && $query->is_author() && $query->is_main_query() ) {
        $query->set( 'post_type', array('post', 'program' ) );
    }
}
add_action( 'pre_get_posts', 'add_cpt_program_in_author' ); 

// Uncomment this if woocommerce was not templated
// function add_cpt_program_in_archive( $query ) {
//     if ( !is_admin() && $query->is_archive() && $query->is_main_query() && !is_post_type_archive( 'product' ) ) {
//         $query->set( 'post_type', array('post', 'program' ) );
//     }
// }
// add_action( 'pre_get_posts', 'add_cpt_program_in_archive' );

// Uncomment this if woocommerce was templated
// pre_get_posts function added to include custom post type "program" in archive loop
function add_cpt_program_in_archive( $query ) {
    $prod_cat = '';
    if(!empty($query->query_vars['product_cat'])){
        $prod_cat = $query->query_vars['product_cat'];
    }
    if ( !is_admin() && $query->is_archive() && $query->is_main_query() && !is_shop() && !$prod_cat) {
        $query->set( 'post_type', array('post', 'program' ) );
    }
}
add_action( 'pre_get_posts', 'add_cpt_program_in_archive' );

// woocommerce theme setup
function setup_woocommerce_support() {
    add_theme_support('woocommerce');
}
add_action( 'after_setup_theme', 'setup_woocommerce_support' );

// Remove margin-top: 32px in html when login
function remove_margin_in_admin_login_header() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_margin_in_admin_login_header');