<?php
/**
 * Bootstrap functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bootstrap4
 */
$get_template_directory = get_template_directory();

function bootstrap_scripts() {
    $directory_uri = get_template_directory_uri();

    // css
    wp_enqueue_style( 'bootstrap-css', $directory_uri . '/vendor/bootstrap/dist/css/bootstrap.min.css' );
    wp_enqueue_style( 'font-awesome', $directory_uri . '/vendor/font-awesome/css/font-awesome.min.css' );
    wp_enqueue_style( 'slick-style', $directory_uri . '/assets/slick/slick.css' );
    wp_enqueue_style( 'custom-style', $directory_uri . '/css/custom.css' );
    wp_enqueue_style( 'theme-style', get_stylesheet_uri() );

    // script
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-script', $directory_uri . '/vendor/jquery/dist/jquery.min.js','','',true);
    wp_enqueue_script('bootstrap-bundle', $directory_uri . '/vendor/bootstrap/dist/js/bootstrap.bundle.min.js','','',true);
    wp_enqueue_script('slick-js', $directory_uri . '/assets/slick/slick.js','','',true);
    wp_enqueue_script('theme-js', $directory_uri . '/js/main.js','','',true);
}

add_action( 'wp_enqueue_scripts', 'bootstrap_scripts' );

// Override wordpress admin jquery default
function override_wordpress_jquery () {
	if (is_admin()) {
		return;
	}

	global $wp_scripts;
	if (isset($wp_scripts->registered['jquery']->ver)) {
		$ver = $wp_scripts->registered['jquery']->ver;
        $ver = str_replace("-wp", "", $ver);
	} else {
		$ver = '1.12.4';
	}

	wp_deregister_script('jquery');
	wp_register_script('jquery', get_template_directory_uri() . "/vendor/jquery/dist/jquery.min.js", true, $ver);
}
add_action('init', 'override_wordpress_jquery');

// widget search
function get_widget_search(){
    get_template_part('inc/custom-widgets/widget', 'search');
}

// widget category
function get_widget_category(){
    get_template_part('inc/custom-widgets/widget', 'category');
}

// widget archive
function get_widget_archive() {
    get_template_part('inc/custom-widgets/widget', 'archive');
}

// breadcrumb
function get_breadcrumb() {
    echo '
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="'.home_url().'" rel="nofollow">Home</a>
        </li>
    ';
    if (is_category() || is_single()) {
        // if (is_category()) {
            
            foreach((get_the_category()) as $category) {
                $cat_title = $category->cat_name . ' ';
                $cat_link = get_category_link($category->cat_ID);
                echo '<li class="breadcrumb-item"><a href="'.$cat_link.'">'.$cat_title.'</a></li>';
            }
        // }
        if (is_single()) {

            // single post title
            echo '<li class="breadcrumb-item active">'.get_the_title().'</li>';         
        }
    } elseif (is_page()) {
        echo '<li class="breadcrumb-item active">'.get_the_title().'</li>';
    }
    echo '</ol>';
}


require $get_template_directory . '/inc/template_tags.php';
require_once ($get_template_directory . '/inc/theme_setup.php');
require_once ($get_template_directory . '/inc/theme_filter.php');
require_once ($get_template_directory . '/inc/customizer.php');
require_once ($get_template_directory . '/inc/custom-widgets/functions/widget-functions.php');
require_once ($get_template_directory . '/inc/navigation/class-wp-bootstrap-navwalker.php');
require_once ($get_template_directory . '/inc/custom-field.php');
require_once ($get_template_directory . '/inc/shortcodes.php');
include_once get_theme_file_path( 'inc/kirki/class-kirki-installer-section.php' );