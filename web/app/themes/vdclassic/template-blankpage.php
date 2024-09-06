<?php
/**
 * The template for Career pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vdclassic
 *
 * Template Name: Blank Page [empty header and footer]
 */

get_header('blank');
?>

<main id="primary" class="main" style="margin:0px; padding:0px">
    <?php
    while (have_posts()) :
        the_post();

        get_template_part('parts/content', 'page');
    endwhile;
    ?>
</main>

<?php
get_footer('blank');
