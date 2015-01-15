<?php

/**
 * Template Name: Team
 */

?>

<?php get_header(); ?>

<main id="main" class="site-main" role="main">

    <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'content', 'team' ); ?>

    <?php endwhile; // end of the loop. ?>


        <?php

        /**
         * Team section
         */
        $category_id = get_cat_ID( tm_get_options()->team_category );

        if ( $category_id  ) : ?>
            <?php
            $args = array(
                'posts_per_page' => 4,
                'category' => $category_id
                );
            $my_posts = get_posts( $args );
            if ( ! empty( $my_posts ) ) : ?>

                <div class="entry-team">
                    <?php foreach ( $my_posts as $post ) : setup_postdata( $post ); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'one-third column' ); ?>>
                            <div class="author-info author-wrap">
                                <?php  if ( has_post_thumbnail() ) : ?>
                                    <div class="author-image">
                                        <?php the_post_thumbnail( 'WP_Business_team' ); ?>
                                    </div>
                                <?php endif; ?>
                                <h3 class='author-info-name'><?php the_title(); ?></h3>

                                <?php
                                $position = get_post_meta( $post->ID, '_WP_Business_team_position', true );
                                $facebook = get_post_meta( $post->ID, '_WP_Business_team_facebook', true );
                                $twitter = get_post_meta( $post->ID, '_WP_Business_team_twitter', true );
                                $github = get_post_meta( $post->ID, '_WP_Business_team_github', true );
                                ?>

                                <?php if ( ! empty( $position ) ) : ?>
                                    <div class="author-info-position">Web Engineer</div>
                                <?php endif; ?>

                                <?php if ( ! empty( $facebook ) || ! empty( $twitter ) || ! empty( $github ) ) : ?>
                                <ul class="author-details">
                                    <?php if ( ! empty( $facebook ) ) : ?><li class="author-social"><a href="<?php echo $facebook; ?>" target="_blank"><div class="genericon genericon-small genericon-facebook"></div></a></li><?php endif; ?>
                                    <?php if ( ! empty( $twitter ) ) : ?><li class="author-social"><a href="<?php echo $twitter; ?>" target="_blank"><div class="genericon genericon-small genericon-twitter"></div></a></li><?php endif; ?>
                                    <?php if ( ! empty( $github ) ) : ?><li class="author-social"><a href="<?php echo $github; ?>" target="_blank"><div class="genericon genericon-small genericon-github"></div></a></li><?php endif; ?>
                                </ul>
                                <?php endif; ?>
                                <div class="author-info-bio"><?php the_content(); ?></div>
                            </div>
                        </article><!-- #post-## -->
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

</main><!-- #main -->

<?php get_footer(); ?>