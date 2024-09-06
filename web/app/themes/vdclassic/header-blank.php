<?php
/**
 * The header for vdclassic theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package vdclassic
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'vdclassic'); ?></a>

    <header class="header headroom headroom--top" style="display:none;">
        <a class="skip-link screen-reader-text" href="#primary">
            <?php esc_html_e('Skip to content', 'vdclassic'); ?>
        </a>

        <!-- Header Top -->
        <div class="header-top">
            <div class="header-top__inner">

                <div class="header__logo header__logo--mobile">
                    <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>" rel="home">
                        <img width="100" height="48"
                        src="<?php echo get_stylesheet_directory_uri() ?>/logo.png"
                        loading="lazy"
                        alt="Hornetsecurity GmbH">
                    </a>
                </div>
            </div>
        </div>

        <!-- Header Main -->
        <div class="header-main">
            <div class="header-main__inner">
                <!-- Logo Desktop -->
                <div class="header__logo header__logo--desktop">
                    <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>" rel="home">
                        <img width="128" height="62"
                        src="<?php echo get_stylesheet_directory_uri() ?>/logo.png"
                        loading="lazy"
                        alt="Hornetsecurity GmbH">
                    </a>
                </div>
            </div>
        </div>
    </header><!-- .header -->
