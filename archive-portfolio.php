<?php
/**
 * The template for displaying Portfolio Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Business
 */

get_header(); ?>

<section id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php if ( have_posts() ) : ?>

            <header class="page-header">
                <h1 class="page-title archive-title"><?php _e( 'Portfolio', 'WP_Business' ); ?></h1>
            </header><!-- .page-header -->

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

                if ( empty( $terms ) )
                    return;

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
                                    <h1 class="entry-title"><a href="<?php echo get_term_link( $term->slug, $taxonomy ); ?>"><?php echo $term->name; ?></a></h1>
                                    <div class="portfolio-cat-details">
                                        <span class="items-count">
                                            <?php echo '<span class="count">' . $post_count . '</span>' .  __( ' items in ', 'WP_Business' ) . '<span class="category">' . $term->name . '</span>' . __( ' category', 'WP_Business' ); ?>
                                        </span>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                            </article>
                        <?php endif; ?>
                    <?php endforeach; ?>


            </div>

        <?php else : ?>

            <?php get_template_part( 'content', 'none' ); ?>

        <?php endif; ?>

            </main><!-- #main -->
        </div><!-- #primary -->

<?php get_footer(); ?>