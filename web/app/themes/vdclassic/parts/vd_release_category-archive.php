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

        get_template_part('parts/content', 'teaser--vd_release-note');
    endwhile;

    echo '</div>';

    the_posts_pagination(array(
        'mid_size'  => 2,
        'before' => '<div class="pagination">',
        'after' => '</div>',
        'show_all'     => false,
        'prev_text'    => sprintf('<svg title="%1$s" class="icon rotate-90"><use href="/ico.svg#arrow-down"></use></svg>', __('Previous', 'jdclassic')),
        'next_text'    => sprintf('<svg title="%1$s" class="icon rotate-270"><use href="/ico.svg#arrow-down"></use></svg>', __('Next', 'jdclassic')),
    ));

    wp_reset_postdata();
} else {
    get_template_part('parts/content', 'none');
}
