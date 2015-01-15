<?php
/**
 * The template used for displaying portfolio content in single.php
 *
 * @package WP_Business
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header full-width">
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header><!-- .entry-header -->

    <div class="column two-thirds">
        <div class="entry-content">
            <?php echo apply_filters( 'the_content', preg_replace( '/\[gallery [^\]]+\]/', '',  get_the_content() ) ); ?>
        </div><!-- .entry-content -->
        <?php edit_post_link( __( 'Edit', 'WP_Business' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
    </div>

    <aside class="column one-third end entry-meta">
        <h2 class="entry-subtitle"><?php _e( 'Project Details', 'WP_Business' ); ?></h2>
        <ul>
            <?php
            $client = get_post_meta( $post->ID, '_WP_Business_portfolio_client', true );
            if ( $client ) : ?>
                <li class="client"><em><?php _e( 'Client','WP_Business' ); ?>:</em> <?php echo $client; ?></li>
            <?php endif; ?>

            <?php
            $year = get_post_meta( $post->ID, '_WP_Business_portfolio_year', true );
            if ( $year ) : ?>
                <li class="year"><em><?php _e( 'Year', 'WP_Business' ); ?>:</em> <?php echo $year; ?>
            <?php endif; ?>

            <?php $categories_list = get_the_category_list( __( ', ', 'WP_Business' ) );
            if ( $categories_list && WP_Business_categorized_blog() ) : ?>
                <li class="categories"><em><?php _e( 'Categories','WP_Business' ); ?>:</em> <?php echo $categories_list; ?></li>
            <?php endif; ?>

            <?php
            $tech = get_post_meta( $post->ID, '_WP_Business_portfolio_technology', true );
            if ( $tech ) : ?>
                <li class="technology"><em><?php _e( 'Technology', 'WP_Business' ); ?>:</em> <?php echo $tech; ?>
            <?php endif; ?>

            <?php
            $url = get_post_meta( $post->ID, '_WP_Business_portfolio_url', true );
            if ( $url ) : ?>
                <li class="url"><em><?php _e( 'URl', 'WP_Business' ); ?>:</em> <?php echo $url; ?>
            <?php endif; ?>
        </ul>
    </aside>

</article><!-- #post-## -->
