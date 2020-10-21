<?php
/**
 * Bootstrap4 Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bootstrap4
 */
$get_template_directory = get_template_directory();

function bootstrap4_scripts() {
    $directory_uri = get_template_directory_uri();

    // css
    wp_enqueue_style( 'bootstrap-css', $directory_uri . '/vendor/bootstrap/dist/css/bootstrap.min.css' );
    wp_enqueue_style( 'font-awesome-css', $directory_uri . '/vendor/font-awesome/css/font-awesome.min.css' );
    // wp_enqueue_style( 'venobox-css', $directory_uri . '/vendor/venobox/venobox/venobox.min.css' );
    // wp_enqueue_style( 'mmenu-css', $directory_uri . '/vendor/mmenu-js/dist/mmenu.css' );
    // wp_enqueue_style( 'slick-css', $directory_uri . '/assets/slick/slick.css' );
    wp_enqueue_style( 'custom-css', $directory_uri . '/css/custom.css' );
    wp_enqueue_style( 'theme-css', get_stylesheet_uri() );

    // script
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-js', $directory_uri . '/vendor/jquery/dist/jquery.min.js','','',true);
    wp_enqueue_script('jquery-once-js', $directory_uri . '/vendor/jquery-once/jquery.once.min.js','','',true);
    wp_enqueue_script('jquery-ui-js', $directory_uri . '/vendor/jquery-ui-dist/jquery-ui.min.js','','',true);
    // wp_enqueue_script('jquery-match-height-js', $directory_uri . '/vendor/jquery-match-height/dist/jquery.matchHeight-min.js','','',true);
    wp_enqueue_script('bootstrap-js', $directory_uri . '/vendor/bootstrap/dist/js/bootstrap.min.js','','',true);
    // wp_enqueue_script('venobox-js', $directory_uri . '/vendor/venobox/venobox/venobox.min.js','','',true);
    // wp_enqueue_script('lazysizes-unveilhooks-js', $directory_uri . '/vendor/lazysizes/plugins/unveilhooks/ls.unveilhooks.min.js','','',true);
    // wp_enqueue_script('lazysizes-js', $directory_uri . '/vendor/lazysizes/lazysizes.min.js','','',true);
    // wp_enqueue_script( 'mmenu-js', $directory_uri . '/vendor/mmenu-js/dist/mmenu.js', '','',true);
    // wp_enqueue_script('slick-js', $directory_uri . '/assets/slick/slick.js','','',true);
    wp_enqueue_script('theme-js', $directory_uri . '/js/main.js','','',true);
    wp_enqueue_script('custom-js', $directory_uri . '/js/custom.js','','',true);

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bootstrap4_scripts' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bootstrap4_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bootstrap4_content_width', 1200 );
}
add_action( 'after_setup_theme', 'bootstrap4_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bootstrap4_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar for blog', 'bootstrap4' ),
        'id'            => 'sidebar-blog',
        'description'   => esc_html__( 'Add widgets here.', 'bootstrap4' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'bootstrap4_widgets_init' );

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

/**
 * Add Welcome message to dashboard
 */
function bootstrap4_reminder(){
    $theme_page_url = 'http://jegson.herokuapp.com/';

        if(!get_option( 'triggered_welcomet')){
            $message = sprintf(__( 'Welcome to Bootstrap4 Theme made by Jayson Garcia! Before diving in to your new theme, please visit the <a style="color: #fff; font-weight: bold;" href="%1$s" target="_blank">theme\'s</a> page for access to dozens of tips and in-depth tutorials.', 'bootstrap4' ),
                esc_url( $theme_page_url )
            );

            printf(
                '<div class="notice is-dismissible" style="background-color: #6C2EB9; color: #fff; border-left: none;">
                    <p>%1$s</p>
                </div>',
                $message
            );
            add_option( 'triggered_welcomet', '1', '', 'yes' );
        }

}
add_action( 'admin_notices', 'bootstrap4_reminder' );

/**
 * Custom template tags for this theme.
 */
require $get_template_directory . '/inc/template_tags.php';

/**
 * Theme Setup.
 */
require_once ($get_template_directory . '/inc/theme_setup.php');

/**
 * Theme Filter.
 */
require_once ($get_template_directory . '/inc/theme_filter.php');

/**
 * Customizer additions.
 */
require_once ($get_template_directory . '/inc/customizer.php');

/**
 * Custom widgets.
 */
require_once ($get_template_directory . '/inc/custom-widgets/functions/widget-functions.php');

/**
 * Load custom WordPress nav walker.
 */
require_once ($get_template_directory . '/inc/navigation/class-wp-bootstrap-navwalker.php');

/**
 * Custom field.
 */
require_once ($get_template_directory . '/inc/custom-field.php');


/**
 * Custom post type.
 */
require_once ($get_template_directory . '/inc/custom-post-type.php');

/**
 * Shortcodes for this theme.
 */
require_once ($get_template_directory . '/inc/shortcodes.php');

include_once get_theme_file_path( 'inc/kirki/class-kirki-installer-section.php' );
