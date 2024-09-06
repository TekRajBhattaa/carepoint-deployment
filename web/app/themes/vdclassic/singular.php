<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package vdclassic
 */

get_header();
?>

<main id="primary" class="main">
    <?php
    while (have_posts()) :
        the_post();

        get_template_part('parts/content', 'page');
    endwhile;
    ?>
    <?php get_template_part('parts/related-teaser'); ?>
</main>

<?php
get_footer();
