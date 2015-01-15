<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WP_Business
 */

get_header(); ?>

<?php global $post; ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', 'portfolio' ); ?>
    <?php endwhile; // end of the loop. ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>