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
?>

<main id="primary" class="main">
    <div class="post-layout__hero">
        <?php get_template_part('parts/category', 'header'); ?>
    </div>

    <section class="wp-block-verdure-section alignwide section">

        <div class="section__inner">
            <?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>
            <h2><?php echo sprintf(esc_html__('Posts by %s', 'vdclassic'), $curauth->display_name); ?></h2>

            <div class="post-layout__content-wrap">
                <?php // === CONTENT === ?>
                <div class="post-layout__content">
                    <?php get_template_part('parts/category', 'archive', array(
                        'layout' => 'list'
                    )); ?>
                </div>

                <?php // === SIDEBAR === ?>
                <aside class="post-layout__sidebar">
                    <h3><?php _e('Categories', 'vdclassic'); ?></h3>

                    <?php
                    // Show categories navigation
                    echo '<nav><ul class="list">';
                    vd_list_categories(array(
                        'show_option_all' => __('Alle', 'vdclassic'),
                        'title_li' => '',
                        'hide_empty' => 1,
                        'show_option_none' => 0
                    ));
                    echo '</ul></nav>';
                    ?>
                </aside>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
