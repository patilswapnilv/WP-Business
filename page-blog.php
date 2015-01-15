<?php

/**
 * Template Name: Blog
 */

get_header();
$wp_query = WP_Business_blog_query_obj();

?>

<main id="main" class="site-main two-thirds column" role="main">
    <?php if ( have_posts() ) : ?>
        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <div class="entry-content">
                    <header class="entry-header">
                        <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                        <div class="entry-meta">
                            <?php WP_Business_posted_on(); ?>
                        </div><!-- .entry-meta -->
                    </header><!-- .entry-header -->

                    <?php the_content(); ?>

                    <footer class="entry-meta">
                        <?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
                            <?php
                            /* translators: used between list items, there is a space after the comma */
                            $categories_list = get_the_category_list( __( ', ', 'WP_Business' ) );
                            if ( $categories_list && WP_Business_categorized_blog() ) :
                            ?>
                                <span class="cat-links"><?php printf( __( 'Posted in %1$s', 'WP_Business' ), $categories_list ); ?></span>
                            <?php endif; // End if categories ?>

                            <?php
                            /* translators: used between list items, there is a space after the comma */
                            $tags_list = get_the_tag_list( '', __( ', ', 'WP_Business' ) );
                            if ( $tags_list ) :
                            ?>  <span class="sep"> | </span>
                                <span class="tags-links"><?php printf( __( 'Tagged %1$s', 'WP_Business' ), $tags_list ); ?></span>
                            <?php endif; // End if $tags_list ?>
                        <?php endif; // End if 'post' == get_post_type() ?>

                        <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
                            <span class="comments-link"> | <?php comments_popup_link( __( 'Leave a comment', 'WP_Business' ), __( '1 Comment', 'WP_Business' ), __( '% Comments', 'WP_Business' ) ); ?></span>
                        <?php endif; ?>

                        <?php edit_post_link( __( 'Edit', 'WP_Business' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
                    </footer><!-- .entry-meta -->
                </div>
            </article><!-- #post-## -->
        <?php endwhile; WP_Business_paging_nav(); wp_reset_query(); ?>
    <?php endif; ?>
</main><!-- #main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>