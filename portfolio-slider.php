<?php

/**
 * Either derive the images for the gallery from the home page
 * slide show in theme options or from the gallery.
 *
 */
global $post;

if ( is_home() ){
    $tmp_slider_ids = tm_get_options()->homepage_slideshow;
    $slider_ids = empty( $tmp_slider_ids ) ? false : explode(',', $tmp_slider_ids );
} elseif (
    'portfolio' == get_post_type() && is_single() && has_shortcode( get_post_field( 'post_content', $post->ID ), 'gallery') ) {
    $gallery = get_post_gallery( $post->ID, false );
    $slider_ids = explode( ',', $gallery['ids'] );
} else {
    $slider_ids = false;
}

if ( ! empty( $slider_ids ) && count( $slider_ids ) >= 1 ) : ?>
    <div class="flexslider">
        <ul class="slides">
            <?php foreach( $slider_ids as $slider_id ) : ?>
            <li>
                <?php
                $image = wp_get_attachment_image_src( $slider_id, array(1200,660) );
                $callout = array(
                    'title' => get_post_meta( $slider_id, '_WP_Business_slider_button_title', true ),
                    'url' => get_post_meta( $slider_id, '_tm_custom_url', true )
                    );
                ?>
                <div class="entry-content">
                    <?php if ( ! is_single() && ! empty( $callout['title'] ) ) {
                        $link = $callout['url'];
                    } else {
                        $link = get_permalink( $slider_id );
                    }
                    ?>
                    <h2 class="entry-title"><?php echo get_post_field( 'post_title', $slider_id ); ?></h2>
                    <div class="entry-excerpt">
                        <?php echo get_post_field( 'post_excerpt', $slider_id ); ?>
                    </div>
                    <?php if ( ! is_single() && ! empty( $callout['title'] ) ) : ?>
                        <a href="<?php echo $callout['url'] ?>" title="<?php echo esc_attr( $callout['title'] ); ?>" rel="bookmark" class="call-to-action"><?php echo $callout['title']; ?></a>
                    <?php endif; ?>
                </div>
                <div class="entry-image">
                    <img src="<?php echo $image[0]; ?>" />
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
        <ul id="slider-navigation">
            <span id="toggle-navigation" class="genericon genericon-draggable"></span>
            <?php foreach( $slider_ids as $slider_id ) : ?>
                <?php $image = wp_get_attachment_image_src( $slider_id, 'thumbnail' ); ?>
                <li>
                    <img src="<?php echo $image[0]; ?>" />
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>