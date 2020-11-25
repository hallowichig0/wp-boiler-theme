<?php
/**
 * Bootstrap4 Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bootstrap4
 */
$get_template_directory = get_template_directory();

/**
 * Enqueue stylesheet and script.
 * Using async on style. Just put this #asyncstyle at the end of src. (Ex. https://example.com/embed.css#asyncstyle)
 * In enqueue style with async. This should be the output: wp_enqueue_style( 'myexternal-css', 'https://example.com/embed.css#asyncstyle', array(), '', 'print' );
 * Using async on script. Just put this #asyncsript at the end of src. (Ex. https://example.com/embed.js#asyncscript)
 */
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

    // Update jquery version (Frontend only)
    if ( !is_admin() || !is_customize_preview() ) {
        wp_deregister_script( 'jquery' );
        // Deregister WP jQuery
        wp_deregister_script( 'jquery-core' );
        // Deregister WP jQuery Migrate
        wp_deregister_script( 'jquery-migrate' );
        // Register jQuery in the head
        wp_register_script('jquery-core', $directory_uri . '/vendor/jquery/dist/jquery.min.js','','',true);

        /**
         * Register jquery using jquery-core as a dependency, so other scripts could use the jquery handle
         * see https://wordpress.stackexchange.com/questions/283828/wp-register-script-multiple-identifiers
         * We first register the script and afther that we enqueue it, see why:
         * https://wordpress.stackexchange.com/questions/82490/when-should-i-use-wp-register-script-with-wp-enqueue-script-vs-just-wp-enque
         * https://stackoverflow.com/questions/39653993/what-is-diffrence-between-wp-enqueue-script-and-wp-register-script
         */
        wp_register_script( 'jquery', false, array( 'jquery-core' ), null, false );
        wp_enqueue_script( 'jquery' );
    }

    // script
    wp_enqueue_script('jquery-effects-core'); // get the wp core jquery-ui-effect
    wp_enqueue_script('jquery-once-js', $directory_uri . '/vendor/jquery-once/jquery.once.min.js','','',true);
    // wp_enqueue_script('jquery-match-height-js', $directory_uri . '/vendor/jquery-match-height/dist/jquery.matchHeight-min.js','','',true);
    wp_enqueue_script('bootstrap-js', $directory_uri . '/vendor/bootstrap/dist/js/bootstrap.min.js','','',true);
    // wp_enqueue_script('venobox-js', $directory_uri . '/vendor/venobox/venobox/venobox.min.js','','',true);
    // wp_enqueue_script('lazysizes-unveilhooks-js', $directory_uri . '/vendor/lazysizes/plugins/unveilhooks/ls.unveilhooks.min.js','','',true);
    // wp_enqueue_script('lazysizes-js', $directory_uri . '/vendor/lazysizes/lazysizes.min.js','','',true);
    // wp_enqueue_script('infinite-scroll-js', $directory_uri . '/vendor/infinite-scroll/dist/infinite-scroll.pkgd.min.js','','',true);
    // wp_enqueue_script( 'mmenu-js', $directory_uri . '/vendor/mmenu-js/dist/mmenu.js', '','',true);
    // wp_enqueue_script('slick-js', $directory_uri . '/assets/slick/slick.js','','',true);
    wp_enqueue_script('theme-js', $directory_uri . '/js/main.js','','',true);
    wp_enqueue_script('global-js', $directory_uri . '/js/global.js','','',true);

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
    }
    
    if( is_front_page() ) {
        wp_enqueue_script('front-js', $directory_uri . '/js/front.js','','',true);
    }

    if( is_home() ) {
        wp_enqueue_script('home-js', $directory_uri . '/js/home.js','','',true);
    }
}
add_action( 'wp_enqueue_scripts', 'bootstrap4_scripts' );

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
