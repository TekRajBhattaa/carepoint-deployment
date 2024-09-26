<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package vdclassic
 */

?>

<footer class="footer">




    <div class="footer__bottom footer_section">
        <div class="container">
            <div class="left">

                <div>
                    <h2>Sign Up for Our Newsletter.</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.
                    <form action="">
                        <input type="email" placeholder=" Enter your email">
                        <button>Subscribe Now</button>
                    </form>
                    </p>
                </div>
                <!-- 

                <div class="footer-logo">
                    <a href="<//? // php echo esc_url(home_url('/')); ?>" title="< //? //php bloginfo('name'); ?>" rel="home">
                        <img width="128" height="62"
                            src="<//? //php echo get_stylesheet_directory_uri() ?>/footer-logo.png"
                            loading="lazy"
                            alt="Hornetsecurity GmbH">
                    </a>
                </div> -->

            </div><!-- .site-info -->
            <div class="right">
                <div class="inner-section">


               
                <nav class="footer__subnav">


                    <nav class="primenav footer-nav">
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

                    <nav class="primenav footer-nav">
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

                    <div class="social">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/facebook.png" alt="">

                        <img src="<?php echo get_stylesheet_directory_uri() ?>/linked.png" alt="">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/twitter.png" alt="">
                    </div>

                </nav>
                <p class="copyright-text">© 2024 CarePoint Solutions Inc. All Rights Reserved.</p>
                </div>



            </div>

        </div>
    </div>
</footer><!-- .footer -->

</div><!-- .page -->

<?php wp_footer(); ?>

<a href="#primary" class="scrolltotop">
    <svg class="icon">
        <use href="/ico.svg#arrow-up"></use>
    </svg>
</a>

</body>

</html>