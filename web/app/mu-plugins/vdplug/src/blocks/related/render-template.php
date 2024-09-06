<?php

/*

TEMPLATE FOR Block "verdure/related"

https://make.wordpress.org/core/2022/10/12/block-api-changes-in-wordpress-6-1/
The following variables are available inside the template:

$attributes     (array): The block attributes.
$content        (string): The block default content.
$block          (WP_Block): The block instance.

*/

$post_id = get_the_ID();
$wquery = array(
    'post_type' => ["page", "post", "vd_job"],
    'post_status' => 'publish',
    'posts_per_page' => $attributes['postsToShow'],
    'order' => $attributes['order'],
    'orderby' => $attributes['orderBy'],
    'post__not_in' => array($post_id),
    'ignore_sticky_posts' => true,
    'no_found_rows' => true,
);

if ($attributes['byPageCategories']) {
    // Show related posts of current post categories
    $post_categories = wp_get_post_terms($post_id, 'page_category');
    $term_ids = array_column($post_categories, 'term_id');
    $wquery['tax_query'] = array(
        array(
            'taxonomy' => 'page_category',
            'field' => 'id',
            'terms' => $term_ids,
        )
    );
} elseif (isset($attributes['categories'])) {
    // Show related posts based on selected categories
    $wquery['tax_query'] = array(
        array(
            'taxonomy' => 'page_category',
            'field' => 'id',
            'terms' => array_column($attributes['categories'], 'id'),
        )
    );
}

$page_teaser = new WP_Query($wquery);

if ($page_teaser->have_posts()) :
    $classes = [];
    array_push($classes, 'grid-columns', 'grid-columns--max' . $attributes['columns']);

    $output = '<div ' . get_block_wrapper_attributes(array(
        'class' => join(' ', ['related', 'is-layout-flow', 'wp-block-group']),
    )) . '>';

    $output .= '<div class="related__columns ' . join(' ', $classes) . '">';

    while ($page_teaser->have_posts()) :
        $page_teaser->the_post();
        $linked_title = get_the_title();

        // Get first page_category
        $page_cat_list = get_the_terms(get_the_ID(), 'page_category');
        $page_cat_list = wp_list_pluck($page_cat_list, 'name');
        $page_cat_name = $page_cat_list ? $page_cat_list : '';

        if (in_array('Webinar', $page_cat_list)) {
            include('templates/webinar.php');
        } else {
            include('templates/default.php');
        }
    endwhile;
    $output .= '</div></div><!-- ' . $page_teaser->found_posts . ' -->';

    /* Restore original Post Data */
    wp_reset_postdata();
else :
    $output = '<!-- There is no related content. Please delete this block or change settings. -->';
endif;

echo $output;
