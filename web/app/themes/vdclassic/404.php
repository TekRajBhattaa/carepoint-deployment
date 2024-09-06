<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package vdclassic
 */

get_header();

// Error Page with fixed slug
?>
    <main id="primary" class="main">
        <?php
        // Get 404 page
        $page404 = get_page_by_path('error-404');
        if ($page404) {
            // Get the translated version of 404 page
            $page404_id = apply_filters('wpml_object_id', $page404->ID, 'page', true);
            $page404_translated = new WP_Query(array('page_id' => $page404_id));

            // Output content from translated 404
            if ($page404_translated->have_posts()) {
                while ($page404_translated->have_posts()) {
                    $page404_translated->the_post();
                    the_content();
                }
            }
            wp_reset_postdata();
        } else {
            ?>
            <h1><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'vdclassic'); ?></h1>
            <?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'vdclassic'); ?></p>
            <?php
        }
        ?>
    </main><!-- ./main -->
<?php

get_footer();
