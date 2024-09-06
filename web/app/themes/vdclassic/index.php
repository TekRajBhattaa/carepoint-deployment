<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vdclassic
 */

get_header();
$paged = max(1, get_query_var('paged'));
?>

<main id="primary" class="main">
    <!-- TEMPLATE: Post Archive List Template -->
    <?php
    $page_data = get_page_by_path('blog');
    echo $page_data->post_content;
    ?>

    <section class="section alignwide">
        <div class="section__inner">
            <?php
            get_template_part('parts/category', 'archive--index', array(
                'layout' => 'list'
            ));
            ?>
        </div>
    </section>

    <?php get_template_part('parts/random-teaser'); ?>
</main>

<?php
get_footer();
