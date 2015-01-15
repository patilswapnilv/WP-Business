<?php
/**
 * The Footer containing the home widget areas.
 *
 * @package WP_Business
 */
?>
</div>
<?php if (  is_active_sidebar( 'bottom' ) ) : ?>
    <section id="bottom-widget-area">
        <div class="container">
            <?php if ( ! dynamic_sidebar( 'bottom' ) ) : ?>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>
<?php if (  is_active_sidebar( 'footer-1' ) ||  is_active_sidebar( 'footer-2' ) ||  is_active_sidebar( 'footer-3' ) ) : ?>
<section id="footer">
    <div class="container">
        <footer>
            <div id="secondary" class="widget-area" role="complementary">
                <?php if ( ! dynamic_sidebar( 'footer-1' ) ) : ?>
                <?php endif; ?>
                <?php if ( ! dynamic_sidebar( 'footer-2' ) ) : ?>
                <?php endif; ?>
                <?php if ( ! dynamic_sidebar( 'footer-3' ) ) : ?>
                <?php endif; ?>
            </div><!-- #secondary -->
        </footer>
    </div>
</section>
<?php endif; ?>

<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WP_Business
 */
?>

    </div><!-- #content -->


    <footer id="colophon" class="site-footer" role="contentinfo">
        <section>
            <div class="container">
                <div class="column two-thirds">
                    <div class="site-info">
                                           
                        <p>
                            <?php printf( __('&copy; %d %s. All rights reserved.', 'corporatewp' ), date( 'Y' ), get_bloginfo( 'name' ) ); ?> Powered by <a href="http://wordpress.org/" title="WordPress">WordPress</a>


                        </p> 
                      </div><!-- .site-info -->
                </div>
                <?php if ( has_nav_menu( 'footer' ) ) : ?>
                <div class="column one-third end">
                    <nav class="footer-navigation" role="navigation">
                        <?php wp_nav_menu( array( 'theme_location' => 'footer', 'fallback_cb' => false, 'depth' => 1 ) ); ?>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </section>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>