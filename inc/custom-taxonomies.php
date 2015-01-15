<?php

/**
 * Register new custom taxonomies
 * @package WP_Business
 * @since WP_Business 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Register taxonomy for new post type */
/*-----------------------------------------------------------------------------------*/

add_action( 'init', 'WP_Business_ps_portfolio_taxonomy', 0 );

function WP_Business_ps_portfolio_taxonomy() {
    // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Categories', 'taxonomy general name', 'WP_Business' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name', 'WP_Business' ),
    'search_items' =>  __( 'Search Categories', 'WP_Business' ),
    'all_items' => __( 'All Categories', 'WP_Business' ),
    'parent_item' => __( 'Parent Category', 'WP_Business' ),
    'parent_item_colon' => __( 'Parent Category:', 'WP_Business' ),
    'edit_item' => __( 'Edit Category', 'WP_Business' ),
    'update_item' => __( 'Update Category', 'WP_Business' ),
    'add_new_item' => __( 'Add New Category', 'WP_Business' ),
    'new_item_name' => __( 'New Category Name', 'WP_Business' ),
    'menu_name' => __( 'Categories', 'WP_Business' )
  );
    register_taxonomy( 'pcategory','portfolio',array(
                'hierarchical' => true,
                'labels' => $labels,
                'query_var' => true,
                'rewrite' => array( 'slug' => 'pcategory' ),
                'show_admin_column' => true
    ) );
}

add_action( 'init', 'WP_Business_ps_portfolio_tags', 1 );

function WP_Business_ps_portfolio_tags() {
    register_taxonomy( 'ptag', 'portfolio', array(
                'hierarchical' => false,
                'update_count_callback' => '_update_post_term_count',
                'label' => __( 'Tags', 'WP_Business' ),
                'query_var' => true,
                'rewrite' => array( 'slug' => 'ptags' ),
                'show_admin_column' => true
    )) ;
}

/**
 * Flush your rewrite rules for custom post type and taxonomies added in theme
 * @package WP_Business
 * @since WP_Business 1.0
 */
function WP_Business_flush_rewrite_rules() {
    global $pagenow, $wp_rewrite;

    if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
        $wp_rewrite->flush_rules();
}
add_action( 'load-themes.php', 'WP_Business_flush_rewrite_rules' );