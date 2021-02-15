<?php
/**
 * All theme setup
 *
 *
 * @package Bootstrap4
 */

/**
 * Reusable error notice function for admin_head()
 */
function error_activation_admin_notice() {
    echo '<style>#message2{border-left-color:#dc3232;}</style>';
}

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
	    'gallery',
            'caption',
        ) );
	    
	/*
        * Enable support for Post Formats.
        *
        * See: https://codex.wordpress.org/Post_Formats
        */
	add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'audio',
        ));

        /*
        * All Custom thumbnails
        */
        add_image_size( 'banner-scale', 1920, 1080, true ); // scale
        add_image_size( 'banner-scale-crop', 1920, 1080, array( 'center', 'center' ) ); // scale & crop
        add_image_size( 'thumbnail-10-10', 10, 10, array( 'center', 'center' ) );
        
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

/*
 * Function creates post duplicate as a draft and redirects then to the edit post screen
 */
function duplicate_post_as_draft(){
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}

	/*
	 * Nonce verification
	 */
	if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
		return;

	/*
	 * get the original post id
	 */
	$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );

	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;

	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {

		/*
		 * new post data array
		 */
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => 'Duplicate ' . $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);

		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );

		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}

		/*
		 * duplicate all post meta just in two SQL queries
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				if( $meta_key == '_wp_old_slug' ) continue;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}

		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_duplicate_post_as_draft', 'duplicate_post_as_draft' );

/*
 * Add the duplicate link to action list for post_row_actions
 */
function duplicate_post_link( $actions, $post ) {
	if (current_user_can('edit_posts')) {
		$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
	}
	return $actions;
}
add_filter( 'post_row_actions', 'duplicate_post_link', 10, 2 );
add_filter('page_row_actions', 'duplicate_post_link', 10, 2);

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

/**
 * Show menu pages on specific roles
 */
function remove_menu_pages() {
    if( !current_user_can('administrator') ) {
        // remove_menu_page('edit-comments.php'); // Comments
        remove_menu_page('wpcf7'); // Contact Form 7 Menu
    }
}
add_action( 'admin_init', 'remove_menu_pages' );
