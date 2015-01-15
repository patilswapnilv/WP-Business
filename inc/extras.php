<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package WP_Business
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function WP_Business_page_menu_args( $args ) {
    $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'WP_Business_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function WP_Business_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    global $post;
    if ( 'portfolio' == get_post_type() && is_single() && has_shortcode( get_post_field( 'post_content', $post->ID ), 'gallery' ) ||
        is_home() && ! empty( tm_get_options()->homepage_slideshow ) ){

        // If any one image doesn't exists we just return
        $gallery = get_post_gallery( $post->ID, false );
        $slider_ids = explode( ',', $gallery['ids'] );
        foreach( $slider_ids as $id ){
            $valid_id = get_post_field( 'ID', $id );
        }

        $classes[] = 'flexslider-helper';

    }

    return $classes;
}
add_filter( 'body_class', 'WP_Business_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function WP_Business_wp_title( $title, $sep ) {
    global $page, $paged;

    if ( is_feed() ) {
        return $title;
    }

    // Add the blog name
    $title .= get_bloginfo( 'name' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title .= " $sep $site_description";
    }

    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 ) {
        $title .= " $sep " . sprintf( __( 'Page %s', 'WP_Business' ), max( $paged, $page ) );
    }

    return $title;
}
add_filter( 'wp_title', 'WP_Business_wp_title', 10, 2 );


/**
 * Add custom button title field to media uploader
 */
function WP_Business_slide_button_attachment_fields_to_edit( $form_fields, $post ) {
    $form_fields["WP_Business_slider_button_title"]["label"] = __( "Button Title", "WP_Business" );
    $form_fields["WP_Business_slider_button_title"]["input"] = "text";
    $form_fields["WP_Business_slider_button_title"]["value"] = get_post_meta( $post->ID, "_WP_Business_slider_button_title", true );
    $form_fields["WP_Business_slider_button_title"]["helps"] = "Slideshow button title";
    return $form_fields;
}
add_filter( "attachment_fields_to_edit", "WP_Business_slide_button_attachment_fields_to_edit", null, 2 );


function WP_Business_slide_button_image_attachment_fields_to_save( $post, $attachment ) {
    if( isset( $attachment['WP_Business_slider_button_title'] ) ) {
        update_post_meta( $post['ID'], '_WP_Business_slider_button_title', $attachment['WP_Business_slider_button_title'] );
    }
    return $post;
}
add_filter("attachment_fields_to_save", "WP_Business_slide_button_image_attachment_fields_to_save", null, 2);

/**
 * Check if Sell Media is active plugin in options array
 *
 * @since WP_Business 1.0
 */
function WP_Business_sell_media_check(){
    $plugins = get_option( 'active_plugins' );
    if ( in_array ( 'sell-media/sell-media.php', $plugins ) )
        return true;
}

/**
 * Get theme version number from WP_Theme object (cached)
 *
 * @since WP_Business 1.0
*/
function WP_Business_get_theme_version() {
        $theme_file = get_template_directory() . '/style.css';
        $theme = new WP_Theme( basename( dirname( $theme_file ) ), dirname( dirname( $theme_file ) ) );
        return $theme->get( 'Version' );
}