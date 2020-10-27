<?php
/**
 * All theme setup
 *
 *
 * @package Bootstrap4
 */

/**
 * Display a pop-up message when trying to activate this theme without activated kirki plugin
 */
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

/**
 * Kirki validation text
 */
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

/**
 * ACF validation text
 */
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
if ( ! function_exists( 'bootstrap4_setup' ) ) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     * Registration of theme setup. (i.e: Register menu, adding logo, adding thumbnail & etc...)
     */
    function bootstrap4_setup() {

        /*
        * Make theme available for translation.
        * Translations can be filed in the /languages/ directory.
        * If you're building a theme based on Bootstrap 4 Theme, use a find and replace
        * to change 'bootstrap4' to the name of your theme in all the template files.
        */
        load_theme_textdomain( 'bootstrap4', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        
        // Header Logo
        add_theme_support( 'custom-logo', array(
                'height'      => 100,
                'width'       => 400,
                'flex-height' => true,
                'flex-width'  => true,
                'header-text' => array( 'site-title', 'site-description'),
        ));

        /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
        add_theme_support( 'post-thumbnails');

        /*
        * Switch default core markup for search form, comment form, and comments
        * to output valid HTML5.
        */
        add_theme_support( 'html5', array(
            'comment-form',
            'comment-list',
            'caption',
        ) );

        /*
        * All Custom thumbnails
        */
        add_image_size( 'banner-scale', 1920, 1080, true );
        
        /*
        * Register Navigation Menu
        */
        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'bootstrap4' ),
        ) );
    }
}
add_action( 'after_setup_theme', 'bootstrap4_setup' );

function theme_prefix_the_custom_logo() {
	
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}

}

/**
 * Default Favicon
 */
function favicon_default() {
    if( ! has_site_icon()  && ! is_customize_preview() ) {
        echo '<link rel="shortcut icon" type="image/x-icon" href="'.get_template_directory_uri().'/images/w-logo-blue.png" />';
    }
}
add_action('wp_head', 'favicon_default');

/**
 * pre_get_posts function added to include custom post type in author loop
 */
function add_cpt_in_author( $query ) {
    if ( !is_admin() && $query->is_author() && $query->is_main_query() ) {
        $query->set( 'post_type', array('post', 'your-custom-post-type' ) );
    }
}
add_action( 'pre_get_posts', 'add_cpt_in_author' ); 

/**
 * Uncomment this if woocommerce was not templated
 */
// function add_cpt_in_archive( $query ) {
//     if ( class_exists( 'WooCommerce' ) ) {
//         if ( !is_admin() && $query->is_archive() && $query->is_main_query() && !is_post_type_archive( 'product' ) ) {
//             $query->set( 'post_type', array('post', 'your-custom-post-type' ) );
//         }
//     }else {
//         if ( !is_admin() && $query->is_archive() && $query->is_main_query() ) {
//             $query->set( 'post_type', array('post', 'your-custom-post-type' ) );
//         }
//     }
// }
// add_action( 'pre_get_posts', 'add_cpt_in_archive' );

/**
 * Uncomment this if woocommerce was templated
 * pre_get_posts function added to include custom post type in archive loop
 */
function add_cpt_in_archive( $query ) {
    if ( class_exists( 'WooCommerce' ) ) {
        $prod_cat = '';
        if(!empty($query->query_vars['product_cat'])){
            $prod_cat = $query->query_vars['product_cat'];
        }
        if ( !is_admin() && $query->is_archive() && $query->is_main_query() && !is_shop() && !$prod_cat) {
            $query->set( 'post_type', array('post', 'your-custom-post-type' ) );
        }
    }else {
        if ( !is_admin() && $query->is_archive() && $query->is_main_query()) {
            $query->set( 'post_type', array('post', 'your-custom-post-type' ) );
        }
    }
}
add_action( 'pre_get_posts', 'add_cpt_in_archive' );

/**
 * woocommerce theme setup
 */
function setup_woocommerce_support() {
    add_theme_support('woocommerce');
}
add_action( 'after_setup_theme', 'setup_woocommerce_support' );

/**
 * Remove margin-top: 32px in html when login
 */
function remove_margin_in_admin_login_header() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_margin_in_admin_login_header');

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function bootstrap4_pingback_header() {
	echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
}
add_action( 'wp_head', 'bootstrap4_pingback_header' );

/**
 * Add what template file name used
 * This will be show after <body> tag
 */
add_action('wp_body_open', 'show_template');
function show_template() {
    global $template;
    if( current_user_can('administrator') ) {
        echo '<!-- Template File: ' . basename($template) . ' -->';
    }
}