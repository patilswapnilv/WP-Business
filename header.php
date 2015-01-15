<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package WP_Business
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?php wp_title( '|', true, 'right' ); ?></title>

<?php $options = get_option( tm_get_current_theme_id() . '_options' ); ?>
<?php if ( isset ( $options[ 'favicon' ] ) && '' != $options[ 'favicon' ] ) : ?>
    <link rel="shortcut icon" href="<?php echo esc_url( $options[ 'favicon' ] ); ?>" />
<?php endif; ?>


<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="preloader"><div id="spinner"></div></div>
<div id="page" class="hfeed site">
    <?php do_action( 'before' ); ?>

    <header id="masthead" class="site-header" role="banner">
        <div class="container">
            <div class="site-branding">
                <?php if ( ! empty( $options['logo'] ) ) : ?>
                    <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                        <img class="site-title" src="<?php echo esc_url( $options['logo'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
                    </a>
                <?php else : ?>
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_attr( bloginfo( 'name' ) ); ?></a></h1>
                <?php endif; ?>
                <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
            </div>

            <nav id="site-navigation" class="main-navigation" role="navigation">
                <h1 class="menu-toggle genericon genericon-menu"></h1>
                <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'WP_Business' ); ?></a>
                <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
            </nav><!-- #site-navigation -->
        </div>
    </header><!-- #masthead -->

    <div id="content" class="site-content">

    <?php get_template_part( 'portfolio','slider' ); ?>
    <div class="container">