<?php

/**
 * Show related posts of current post categories
 */

$post_id = get_the_ID();
$post_categories = wp_get_post_categories($post_id);

$related_posts = new WP_Query(array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'category__in' => $post_categories,
));

if ($related_posts->have_posts()) : ?>
    <section class="section alignwide">
        <div class="section__inner">
            <h2 class="hl--2"><?php _e('Dies könnte Sie auch interessieren', 'vdclassic') ?></h2>

            <div class="grid-columns grid-columns--max3">
            <?php
            while ($related_posts->have_posts()) :
                $related_posts->the_post();
                get_template_part('parts/content', 'teaser');
            endwhile;
            ?>
            </div>
        </div>
    </section>
    <?php
endif;

wp_reset_postdata();
