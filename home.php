<?php get_header(); ?>

<?php foreach ( explode( ",", tm_get_options()->section_order ) as $order ) { ?>
    <?php if ( $order == 1 ) { ?>
        <?php
        /**
        * Description section
        */
        if ( tm_get_options()->callout_text ) : ?>
            <section id="description">
                <div class="container">
                    <div class="content">
                        <?php echo tm_get_options()->callout_text; ?>
                    </div>
                    <?php if ( tm_get_options()->callout_link ) : ?>
                        <a href="<?php echo tm_get_options()->callout_link; ?>" class="call-to-action"><?php echo tm_get_options()->callout_link_text; ?></a>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>
<?php } ?>

    <?php if ( $order == 2 ) { ?>
        <?php
        /**
        * Featured section
        */
        get_template_part( 'section','featured' ); ?>
    <?php } ?>

    <?php if ( $order == 3 ) { ?>
        <?php
        /**
        * list section
        */
        get_template_part( 'section','list' ); ?>
    <?php } ?>

    <?php if ( $order == 4 ) { ?>

        <?php
        /**
        * Portfolio section
        */
        get_template_part( 'section','portfolio-grid' ); ?>
    <?php } ?>

    <?php if ( $order == 5 ) { ?>
        <?php
        /**
        * Team section
        */
        get_template_part( 'section','team' ); ?>
    <?php } ?>

    <?php if ( $order == 6 ) { ?>
        <?php
        /**
        * Clients section
        */
        get_template_part( 'section','clients' ); ?>
    <?php } ?>

<?php } ?>

<?php get_footer(); ?>