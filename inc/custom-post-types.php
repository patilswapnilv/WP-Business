<?php

/**
 * Register new custom post types
 * @package WP_Business
 * @since WP_Business 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Register new post type */
/*-----------------------------------------------------------------------------------*/

add_action( 'init', 'WP_Business_ps_portfolio_create_type' );

function WP_Business_ps_portfolio_create_type() {


    register_post_type( 'portfolio',
        array(
            'labels' => array(
                'name'                      => __( 'Portfolios','WP_Business' ),
                'singular_name'             => __( 'Portfolio','WP_Business' ),
                'add_new'                   => __( 'Add New', 'WP_Business' ),
                'add_new_item'              => __( 'Add Portfolio', 'WP_Business' ),
                'new_item'                  => __( 'Add Portfolio', 'WP_Business' ),
                'view_item'                 => __( 'View Portfolio', 'WP_Business' ),
                'search_items'              => __( 'Search Portfolios', 'WP_Business' ),
                'edit_item'                 => __( 'Edit Portfolio', 'WP_Business' ),
                'all_items'                 => __( 'All Portfolios', 'WP_Business' ),
                'not_found'                 => __( 'No Portfolio found', 'WP_Business' ),
                'not_found_in_trash'        => __( 'No Portfolio found in Trash', 'WP_Business' )
            ),
            'taxonomies'    => array( 'pcategory', 'ptag' ),
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array( 'slug' => 'portfolio', 'with_front' => false ),
            'query_var' => true,
            'supports' => array( 'title','revisions','thumbnail','author','editor' ),
            'menu_position' => 5,
            'menu_icon' => 'dashicons-portfolio',
            'has_archive' => true
        )
    );
}