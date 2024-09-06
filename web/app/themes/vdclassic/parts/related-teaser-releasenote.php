<?php

/**
 * Show related posts of current post categories
 */

$post_id = get_the_ID();
$post_categories = array_column(wp_get_post_terms($post_id, 'vd_release_category'), 'slug');

$related_posts = new WP_Query(array(
    'post_type' => 'vd_release-note',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'tax_query' => array(
        array(
            'taxonomy' => 'vd_release_category',
            'field'    => 'slug',
            'terms'    => $post_categories,
            'operator' => 'IN'
        )
    )
));

if ($related_posts->have_posts()) : ?>
    <section class="section alignwide">
        <div class="section__inner">
            <h2 class="hl--2"><?php _e('Check other releases', 'vdclassic') ?></h2>

            <div class="grid-columns grid-columns--max3">
            <?php
            while ($related_posts->have_posts()) :
                $related_posts->the_post();
                get_template_part('parts/content', 'teaser--vd_release-note-related');
            endwhile;
            ?>
            </div>
        </div>
    </section>
    <?php
endif;

wp_reset_postdata();
