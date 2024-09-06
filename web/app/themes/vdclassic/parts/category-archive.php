<?php
global $wp_query;

if (have_posts()) {
    // Show blog archive
    if ($args['layout'] == 'list') {
        echo '<div class="grid-list">';
    } else {
        echo '<div class="grid-columns grid-columns--max3">';
    }

    /* Start the Loop */
    while (have_posts()) :
        the_post();

        get_template_part('parts/content', 'teaser--post');
    endwhile;

    echo '</div>';

    wp_reset_postdata();
} else {
    get_template_part('parts/content', 'none');
}
