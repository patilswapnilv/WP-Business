<?php
/**
 * The template used for displaying the "team callout" in home.php
 *
 * @package WP_Business
 */
?>
<?php
$category_id = get_cat_ID( tm_get_options()->team_category );

if ( $category_id  ) : ?>
    <?php
    $args = array(
        'posts_per_page' => 4,
        'category' => $category_id
        );
    $my_posts = get_posts( $args );
    if ( ! empty( $my_posts ) ) : ?>
        <section id="team">
            <h2 class="section-title"><?php $cat = get_category( $category_id ); echo $cat->name; ?></h2>
            <div class="container">
                <?php foreach ( $my_posts as $post ) : setup_postdata( $post ); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'one-fourth column' ); ?>>
                        <?php  if ( has_post_thumbnail() ) : ?>
                            <div class="entry-image">
                                <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'WP_Business' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'WP_Business_team' ); ?></a>
                            </div>
                        <?php endif; ?>
                        <div class="entry-title">
                            <h1><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'WP_Business' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                        </div>
                    </article><!-- #post-## -->
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
<?php endif; ?>
