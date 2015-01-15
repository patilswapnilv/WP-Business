<?php

/**
 * Create the meta box section, title and assign a callback function
 */
function WP_Business_project_meta_box( $post_type ) {
    add_meta_box(
                'product_meta_box',
                __( 'Project Details','WP_Business' ),
                'WP_Business_project_meta_box_html',
                'portfolio'
            );
}
add_action( 'add_meta_boxes', 'WP_Business_project_meta_box' );

/**
 * Show our Project Details meta section
 */
function WP_Business_project_meta_box_html( $fields=null ) {
    global $post; ?>
        <table>
            <tr>
                <td><label><?php _e( 'Year','WP_Business' ); ?></label></td>
                <td><input type="text" name="_WP_Business_portfolio_year" class="regular-text" id="_WP_Business_portfolio_year" value="<?php echo esc_attr( get_post_meta( $post->ID, '_WP_Business_portfolio_year', true ) ); ?>" /></p></td>
            </tr>
            <tr>
                <td><label><?php _e( 'Client','WP_Business' ); ?></label></td>
                <td><input type="text" name="_WP_Business_portfolio_client" class="regular-text" id="_WP_Business_portfolio_client" value="<?php echo esc_attr( get_post_meta( $post->ID, '_WP_Business_portfolio_client', true ) ); ?>" /></p></td>
            </tr>
            <tr>
                <td><label><?php _e( 'Technology','WP_Business' ); ?></label></td>
                <td><input type="text" name="_WP_Business_portfolio_technology" class="regular-text" id="_WP_Business_portfolio_technology" value="<?php echo esc_attr( get_post_meta( $post->ID, '_WP_Business_portfolio_technology', true ) ); ?>" /></p></td>
            </tr>
            <tr>
                <td><label><?php _e( 'URL','WP_Business' ); ?></label></td>
                <td><input type="text" name="_WP_Business_portfolio_url" class="regular-text" id="_WP_Business_portfolio_url" value="<?php echo esc_attr( get_post_meta( $post->ID, '_WP_Business_portfolio_url', true ) ); ?>" /></p></td>
            </tr>
        </table>
    <?php
}

/**
 * Save meta fields when post is updated
 */
function WP_Business_save_portfolio_custom_meta( $post_id ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
        return $post_id;
    }

    $fields = array(
        // Portfolio posts meta
        '_WP_Business_portfolio_year',
        '_WP_Business_portfolio_client',
        '_WP_Business_portfolio_technology',
        '_WP_Business_portfolio_url',

        // Team posts meta
        '_WP_Business_team_position',
        '_WP_Business_team_facebook',
        '_WP_Business_team_twitter',
        '_WP_Business_team_github',
        );

    foreach( $fields as $field ){
        if ( isset( $_POST[ $field ] ) ){
            // For URLs we esc_url them, other wise we use esc_html
            if ( $field == '_WP_Business_portfolio_url' ){
                update_post_meta( $post_id, '_WP_Business_portfolio_url', esc_url( $_POST['_WP_Business_portfolio_url'] ) );
            } else {
                update_post_meta( $post_id, $field, esc_html( $_POST[ $field ] ) );
            }
        }
    }
}
add_action( 'save_post', 'WP_Business_save_portfolio_custom_meta' );

function WP_Business_team_meta_box( $post_type ) {
    add_meta_box(
                'team_meta_box',
                __( 'Team Details','WP_Business' ),
                'WP_Business_team_meta_box_html',
                'post'
            );
}
add_action( 'add_meta_boxes', 'WP_Business_team_meta_box' );

/**
 * Show our Project Details meta section
 */
function WP_Business_team_meta_box_html( $fields=null ) {
    global $post; ?>
        <table>
            <tr>
                <td><label><?php _e( 'Position','WP_Business' ); ?></label></td>
                <td><input type="text" name="_WP_Business_team_position" class="regular-text" id="_WP_Business_team_position" value="<?php echo esc_attr( get_post_meta( $post->ID, '_WP_Business_team_position', true ) ); ?>" /></p></td>
            </tr>
            <tr>
                <td><label><?php _e( 'Facebook','WP_Business' ); ?></label></td>
                <td><input type="text" name="_WP_Business_team_facebook" class="regular-text" id="_WP_Business_team_facebook" value="<?php echo esc_attr( get_post_meta( $post->ID, '_WP_Business_team_facebook', true ) ); ?>" /></p></td>
            </tr>
            <tr>
                <td><label><?php _e( 'Twitter','WP_Business' ); ?></label></td>
                <td><input type="text" name="_WP_Business_team_twitter" class="regular-text" id="_WP_Business_team_twitter" value="<?php echo esc_attr( get_post_meta( $post->ID, '_WP_Business_team_twitter', true ) ); ?>" /></p></td>
            </tr>
            <tr>
                <td><label><?php _e( 'GitHub','WP_Business' ); ?></label></td>
                <td><input type="text" name="_WP_Business_team_github" class="regular-text" id="_WP_Business_team_github" value="<?php echo esc_attr( get_post_meta( $post->ID, '_WP_Business_team_github', true ) ); ?>" /></p></td>
            </tr>
        </table>
    <?php
}