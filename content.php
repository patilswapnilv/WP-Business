<?php
/**
 * @package WP_Business
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'one-third column' ); ?>>

    <?php if ( is_search() ) : // Only display Excerpts for Search ?>
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div><!-- .entry-summary -->
    <?php else : ?>
        <div class="entry-image">
            <?php  if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'WP_Business' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'medium' ); ?></a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <header class="entry-header">
        <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
    </header><!-- .entry-header -->

    <footer class="entry-meta">
        <?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
            <?php
                /* translators: used between list items, there is a space after the comma */
                $categories_list = get_the_category_list( __( ', ', 'WP_Business' ) );
                if ( $categories_list && WP_Business_categorized_blog() ) :
            ?>
            <span class="cat-links">
                <?php echo $categories_list; ?>
            </span>
            <?php endif; // End if categories ?>

            <?php if ( ! is_archive() ) : ?>
                <?php /* translators: used between list items, there is a space after the comma */
                    $tags_list = get_the_tag_list( '', __( ', ', 'WP_Business' ) );
                    if ( $tags_list ) :
                ?>
                <span class="tags-links">
                    <?php printf( __( 'Tagged %1$s', 'WP_Business' ), $tags_list ); ?>
                </span>
                <?php endif; // End if $tags_list ?>
            <?php endif; ?>
        <?php endif; // End if 'post' == get_post_type() ?>

    </footer><!-- .entry-meta -->
</article><!-- #post-## -->
