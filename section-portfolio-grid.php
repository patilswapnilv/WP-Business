<?php
/**
 * The template used for displaying the "portfolio grid callout" in home.php
 *
 * @package WP_Business
 */
?>

<section id="portfolio">
    <h2 class="section-title"><?php _e( 'Portfolio', 'WP_Business' ); ?></h2>
    <div class="container">
        <div class="gallery clearfix">

            <?php
            $taxonomy = 'pcategory';
            $term_ids = array();

            $args = array(
                'orderby' => 'name',
                'hide_empty' => true,
                'parent' => 0
            );

            $terms = get_terms( $taxonomy, $args );

            if ( ! empty( $terms ) ) :
                $count = count( $terms );

                foreach( $terms as $term ) :
                    $args = array(
                            'post_status' => 'publish',
                            'taxonomy' => 'pcategory',
                            'field' => 'slug',
                            'term' => $term->slug,
                            'tax_query' => array(
                                array(
                    'taxonomy' => 'pcategory',
                    'field' => 'id',
                    'terms' => $term_ids,
                    'operator' => 'NOT IN'
                    )
                                )
                            );
                    $posts = New WP_Query( $args );
                    $post_count = $posts->found_posts;

                    if ( $post_count != 0 ) : ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'one-third column' ); ?>>
                            <?php
                            $args = array(
                                    'posts_per_page' => 1,
                                    'taxonomy' => 'pcategory',
                                    'field' => 'slug',
                                    'term' => $term->slug
                                    );

                            $posts = New WP_Query( $args );
                            ?>

                            <?php foreach( $posts->posts as $post ) : ?>

                                <?php $term_id = $term->term_id; ?>

                                <?php global $post; ?>
                                <?php
                                //Get Post Attachment ID
                                $attachment_id = get_post_thumbnail_id( $post->ID );
                                ?>

                                <div class="entry-image">
                                    <?php  if ( has_post_thumbnail() ) : ?>
                                        <a href="<?php echo get_term_link( $term->slug, $taxonomy ); ?>" title="<?php echo $term->name; ?>" rel="bookmark">
                                            <?php the_post_thumbnail( 'WP_Business_medium' ); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <div class="item-overlay">
                                    <h2 class="entry-title"><a href="<?php echo get_term_link( $term->slug, $taxonomy ); ?>"><?php echo $term->name; ?></a></h2>
                                </div>
                            <?php endforeach; ?>
                        </article>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
