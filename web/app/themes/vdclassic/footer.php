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
    <div class="container">
        <div class="footer__meta">
            <div class="footer__navs">
                <?php if (has_nav_menu('nav-footer')) : ?>
                    <?php
                        wp_nav_menu(
                            array(
                                'container'      => false,
                                'depth'          => 2,
                                'items_wrap'     => '%3$s',
                                'theme_location' => 'nav-footer',
                                'walker' => new VdFooterNavWalker()
                            )
                        );
                    ?>
                <?php endif; ?><!-- ./footer-nav -->
            </div>

            <?php if (is_active_sidebar('footer-1')) : ?>
                <div class="footer__info">
                    <?php dynamic_sidebar('footer-1'); ?>

                    <div class="footer__socialshare footer__socialshare--large">
                        <a aria-label="Facebook" href="https://www.facebook.com/antispameurope/" target="_blank" rel="noreferrer noopener">
                            <svg aria-hidden="true" class="icon"><use href="/ico.svg#facebook"></use></svg>
                        </a>
                        <a aria-label="X" href="https://twitter.com/Hornetsecurity" target="_blank" rel="noreferrer noopener">
                            <svg style="width:16px;height:16px;" aria-hidden="true" class="icon"><use href="/ico.svg#x"></use></svg>
                        </a>
                        <a aria-label="Linkedin" href="https://www.linkedin.com/company/hornetsecurity" target="_blank" rel="noreferrer noopener">
                            <svg aria-hidden="true" class="icon"><use href="/ico.svg#linkedin"></use></svg>
                        </a>
                        <a aria-label="youtube" href="http://www.youtube.com/@hornetsecurity" target="_blank" rel="noreferrer noopener">
                            <svg aria-hidden="false" class="icon"><use href="/ico.svg#youtube"></use></svg>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer__bottom">
        <div class="container">
            <div class="site-info">
                <?php
                /* translators: %s: CMS name, i.e. WordPress. */
                printf(esc_html__('© %s %s All rights reserved', 'vdclassic'), date('Y'), 'Hornetsecurity GmbH.');
                ?>
            </div><!-- .site-info -->

            <nav class="footer__subnav">
                <?php wp_nav_menu(
                    array(
                        'container'      => false,
                        'menu_id'        => '',
                        'menu_class'     => '',
                        'depth'          => 2,
                        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'theme_location' => 'nav-footer-sub'
                    )
                ); ?>
            </nav>
        </div>
    </div>
</footer><!-- .footer -->

</div><!-- .page -->

<?php wp_footer(); ?>

<a href="#primary" class="scrolltotop">
    <svg class="icon"><use href="/ico.svg#arrow-up"></use></svg>
</a>

</body>
</html>
