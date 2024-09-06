<?php
/**
 * Template Name: Post Archive Grid Template
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage vdclassic
 */

get_header();
?>

<main id="primary" class="main">
    <!-- TEMPLATE: Post Archive Grid Template -->
    <?php
    if (have_posts()) {
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
        wp_reset_postdata();
    }
    ?>

    <section class="section alignwide">
        <div class="section__inner">
            <?php
            get_template_part('parts/category', 'archive--index', array(
                'layout' => 'grid'
            ));
            ?>
        </div>
    </section>

    <?php get_template_part('parts/random-teaser'); ?>
</main>

<?php
get_footer();
