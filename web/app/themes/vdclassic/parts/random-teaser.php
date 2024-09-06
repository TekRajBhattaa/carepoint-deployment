<?php

/**
 * Show 3 random teaser
 */

$random_posts = new WP_Query(array(
    'post_type' => get_post_type(),
    'posts_per_page' => 3,
    'orderby' => 'rand',
));

if ($random_posts->have_posts()) : ?>
    <section class="section alignwide ">
        <div class="section__inner">
            <h2 class="hl--2"><?php _e('Dies könnte Sie auch interessieren', 'vdclassic') ?></h2>

            <div class="grid-columns grid-columns--max3">
            <?php
            while ($random_posts->have_posts()) :
                $random_posts->the_post();
                get_template_part('parts/content', 'teaser');
            endwhile;
            ?>
            </div>
        </div>
    </section>
    <?php
endif;

wp_reset_postdata();
