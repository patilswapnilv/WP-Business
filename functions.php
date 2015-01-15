<?php
/**
 * WP_Business functions and definitions
 *
 * @package WP_Business
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 1200; /* pixels */
}


if ( ! function_exists( 'WP_Business_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function WP_Business_setup() {

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on WP_Business, use a find and replace
     * to change 'WP_Business' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'WP_Business', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'WP_Business_client', 160, 75, true ); // use 420
    add_image_size( 'WP_Business_team', 400, 400, true );
    add_image_size( 'WP_Business_medium', 525, 365, false );
    add_image_size( 'WP_Business_large', 640, 555, true );
    add_image_size( 'sell_media_item', 520, 520, true ); // sell media images

    update_option( 'thumbnail_size_w', 120, true );
    update_option( 'thumbnail_size_h', 120, true );
    update_option( 'medium_size_w', 900, true );
    update_option( 'medium_size_h', '', true );
    update_option( 'large_size_w', 1280, true );
    update_option( 'large_size_h', '', true );


    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'WP_Business' ),
        'footer' => __( 'Footer Menu', 'WP_Business' ),
    ) );

    // Setup the WordPress core custom background feature.
    add_theme_support( 'custom-background', apply_filters( 'WP_Business_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );
}
endif; // WP_Business_setup
add_action( 'after_setup_theme', 'WP_Business_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function WP_Business_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Footer 1', 'WP_Business' ),
        'id'            => 'footer-1',
        'before_widget' => '<aside id="%1$s" class="widget one-third column %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer 2', 'WP_Business' ),
        'id'            => 'footer-2',
        'before_widget' => '<aside id="%1$s" class="widget one-third column %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer 3', 'WP_Business' ),
        'id'            => 'footer-3',
        'before_widget' => '<aside id="%1$s" class="widget one-third column %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'WP_Business' ),
        'id'            => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Bottom', 'WP_Business' ),
        'id'            => 'bottom',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'WP_Business_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function WP_Business_scripts() {

    $theme = wp_get_theme( 'WP_Business' );

    wp_enqueue_style( 'WP_Business-genericons', get_template_directory_uri() . '/genericons/genericons.css', '', WP_Business_get_theme_version() );
    wp_enqueue_style( 'WP_Business-flexslider-style', get_template_directory_uri() . '/js/flexslider/flexslider.css', '', WP_Business_get_theme_version() );
    wp_enqueue_style( 'style', get_stylesheet_uri(), array('WP_Business-genericons','WP_Business-flexslider-style'), WP_Business_get_theme_version() );
    if ( WP_Business_sell_media_check() == true )
        wp_enqueue_style( 'WP_Business-sell-media', get_template_directory_uri() . '/css/sell-media.css', '', WP_Business_get_theme_version() );

    wp_enqueue_script( 'WP_Business-navigation', get_template_directory_uri() . '/js/navigation.js', array(), WP_Business_get_theme_version(), true );
    wp_enqueue_script( 'WP_Business-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), WP_Business_get_theme_version(), true );
    wp_enqueue_script( 'WP_Business-flexslider-script', get_template_directory_uri() . '/js/flexslider/jquery.flexslider-min.js', array('jquery'), WP_Business_get_theme_version() );
    wp_enqueue_script( 'WP_Business-waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array( 'jquery' ), WP_Business_get_theme_version() );

    wp_enqueue_script( 'WP_Business-script', get_template_directory_uri() . '/js/scripts.js', array( 'jquery', 'WP_Business-flexslider-script', 'WP_Business-waypoints' ), WP_Business_get_theme_version() );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'WP_Business_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load our custom widgets
 */
require get_template_directory() . '/inc/custom-widgets.php';
/**
 * Load custom post types
 */
require_once( get_template_directory() . '/inc/custom-post-types.php' );
/**
 * Load custom taxonomies
 */
require_once( get_template_directory() . '/inc/custom-taxonomies.php' );

/**
 * Load our custom post meta
 */
require get_template_directory() . '/inc/custom-post-meta.php';

/**
 * Load tm theme options
 */
include_once(get_template_directory().'/options/options.php');
include_once(get_template_directory().'/theme-options.php');
