<?php
$paged = max(1, get_query_var('paged'));
$posts_query = new WP_Query(array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => get_option('posts_per_page') ?? 9,
    'paged' => $paged
));

if ($posts_query->have_posts()) {
    echo '<div class="post-layout__content-wrap">';

    // === CONTENT ===
    echo '<div class="post-layout__content">';

    // Show blog archive
    if ($args['layout'] == 'list') {
        echo '<div class="grid-list">';
    } else {
        echo '<div class="grid-columns grid-columns--max3">';
    }

    /* Start the Loop */
    while ($posts_query->have_posts()) :
        $posts_query->the_post();

        /*
        * Include the Post-Type-specific template for the content.
        * If you want to override this in a child theme, then include a file
        * called content-___.php (where ___ is the Post Type name) and that will be used instead.
        */
        get_template_part('parts/content', 'teaser--post');
    endwhile;

    echo '</div>';

    $total_pages = $posts_query->max_num_pages;
    if ($total_pages > 1) :
        ?>
        <div class="pagination">
            <?php
                echo paginate_links(array(
                    'current'      => $paged,
                    'format'       => '?paged=%#%',
                    'total'        => $total_pages,
                    'show_all'     => false,
                    'prev_next'    => true,
                    'prev_text'    => sprintf('<svg title="%1$s" class="icon rotate-90"><use href="/ico.svg#arrow-down"></use></svg>', __('Previous', 'jdclassic')),
                    'next_text'    => sprintf('<svg title="%1$s" class="icon rotate-270"><use href="/ico.svg#arrow-down"></use></svg>', __('Next', 'jdclassic')),
                ));
            ?>
        </div>
        <?php
    endif;
    ?>
    </div>

    <?php
    // === SIDEBAR ===
    ?>
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
    <?php
    wp_reset_postdata();
} else {
    get_template_part('parts/content', 'none');
}
?>
