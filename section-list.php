<?php
/**
 * The template used for displaying the "list callout" in home.php
 *
 * @package WP_Business
 */
?>
<?php
$category_id = get_cat_ID( tm_get_options()->list_category );

if ( $category_id  ) : ?>
    <?php
    $args = array(
        'posts_per_page' => 3,
        'category' => $category_id
        );
    $my_posts = get_posts( $args );
    if ( ! empty( $my_posts ) ) : ?>
        <section id="list">
            <h2 class="section-title"><?php $cat = get_category( $category_id ); echo $cat->name; ?></h2>
            <div class="container">
                <?php foreach ( $my_posts as $post ) : setup_postdata( $post ); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php  if ( has_post_thumbnail() ) : ?>
                            <div class="entry-image">
                                <?php the_post_thumbnail( 'WP_Business_medium' ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="entry-content">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <div class="entry-excerpt"><?php the_content(); ?></div>
                        </div>
                    </article><!-- #post-## -->
            <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>
