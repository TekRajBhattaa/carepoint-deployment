<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
</main>

<?php
get_footer();
