<?php
/**
 * The template for Career pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vdclassic
 *
 * Template Name: Career Page
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
</main>

<?php
get_footer();
