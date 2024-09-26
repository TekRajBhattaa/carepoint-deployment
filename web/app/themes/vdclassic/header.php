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
    

    <?php  wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'vdclassic'); ?></a>

    <header class="header headroom headroom--top">
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
                        alt="Carepoint">
                    </a>
                </div>

                <nav class="header__topnav">
                    <!-- WPML Language Selector -->
                    <div class="header__lang">
                        <?php echo vdclassic_language_switcher(); ?>
                    </div>

                    <!-- Top Navigation -->
                    <?php wp_nav_menu(
                        array(
                            'container'      => false,
                            'menu_id'        => '',
                            'menu_class'     => 'topnav',
                            'depth'          => 2,
                            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                            'theme_location' => 'nav-top'
                        )
                    ); ?>
                </nav><!-- .header__topnav -->

                <!-- Mobile toggle -->
                <button class="header__toggle header__toggle--menu hamburger"
                    aria-labelledby="Navigation anzeigen"
                    aria-controls="primary-menu" aria-expanded="false" title="Primäres Menü">
                    <div class="hamburger__inner">
                        <span class="line line1"></span>
                        <span class="line line2"></span>
                        <span class="line line3"></span>
                    </div>
                </button>
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

                <!-- Primary Navigation -->
                <div class="header__menus">
                    <div class="styled-scrollbars primenav__wrapper primenav__wrapper--1">
                        <div class="header__primenav">
                            <div class="primenav__subwrapper">
                                <nav class="primenav">
                                    <?php wp_nav_menu(
                                        array(
                                            'theme_location' => 'nav-primary',
                                            'menu_id'        => '',
                                            'depth'          => 3,
                                            'container'      => false,
                                            'walker' => new VdPrimaryNavWalker()
                                        )
                                    ); ?>
                                </nav>
                                <button class="login-btn"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="22" viewBox="0 0 23 22" fill="none">
<path d="M14.9376 5.5C14.9376 6.41168 14.5754 7.28602 13.9307 7.93068C13.2861 8.57534 12.4117 8.9375 11.5001 8.9375C10.5884 8.9375 9.71404 8.57534 9.06938 7.93068C8.42472 7.28602 8.06256 6.41168 8.06256 5.5C8.06256 4.58832 8.42472 3.71398 9.06938 3.06932C9.71404 2.42466 10.5884 2.0625 11.5001 2.0625C12.4117 2.0625 13.2861 2.42466 13.9307 3.06932C14.5754 3.71398 14.9376 4.58832 14.9376 5.5ZM4.62598 18.4415C4.65543 16.6378 5.39262 14.918 6.67856 13.6529C7.96449 12.3878 9.69614 11.6788 11.5001 11.6788C13.304 11.6788 15.0356 12.3878 16.3216 13.6529C17.6075 14.918 18.3447 16.6378 18.3741 18.4415C16.2176 19.4304 13.8725 19.9407 11.5001 19.9375C9.04706 19.9375 6.71873 19.4022 4.62598 18.4415Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg><a href="/login">Login</a></button>
                            </div>
                        </div>

                        <?php /* SPECIAL!!! Hornet Partner Login ONLY for mobile! */ ?>
                        <!-- <div class="header__partner--mobile partner">
                            <a href="https://external-potal.de">
                                Partner Login
                            </a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </header><!-- .header -->
