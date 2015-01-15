<?php

/**
 * Template Name: Full width page
 */

get_header(); ?>
<main id="main" class="site-main content-area" role="main">
    <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', 'page' ); ?>
    <?php endwhile; // end of the loop. ?>
</main><!-- #main -->
<?php get_footer(); ?>