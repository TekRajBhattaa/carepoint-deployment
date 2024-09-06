<?php
/*

TEMPLATE FOR Block "verdure/pageteaser"

https://make.wordpress.org/core/2022/10/12/block-api-changes-in-wordpress-6-1/
The following variables are available inside the template:

$attributes     (array): The block attributes.
$content        (string): The block default content.
$block          (WP_Block): The block instance.

*/

// $attributes['showSubpages'],
$parent_page_id = get_the_ID();
$endpoint = rest_get_route_for_post_type_items(get_post_type());
$wquery = array(
    'post_type' => ["page", "post", "vd_job"],
    'order' => $attributes['order'],
    'orderby' => $attributes['orderBy'],
    'posts_per_page' => $attributes['postsToShow']
);

if ($attributes['showSubpages']) {
    // Filter by parent page
    $wquery['post_parent'] = $parent_page_id;
    $wquery['post_type'] = get_post_type();
} else {
    // Filter by page categories
    $wquery['post_type'] = ["page", "post", "vd_job", "vd_location"];

    if (isset($attributes['categories'])) {
        $wquery['tax_query'] = array(
            array(
                'taxonomy' => 'page_category',
                'field' => 'id',
                'terms' => array_column($attributes['categories'], 'id'),
            )
        );
    }
}
$page_teaser = new WP_Query($wquery);

if ($page_teaser->have_posts()) :
    $classes = [];
    if ($attributes['postLayout'] === 'grid') {
        array_push($classes, 'grid-columns', 'grid-columns--max' . $attributes['columns']);
    } elseif ($attributes['postLayout'] === 'list') {
        array_push($classes, 'grid-list');
    }

    $output = '<div ' . get_block_wrapper_attributes(array(
        'class' => join(' ', ['pageteaser', 'is-layout-flow', 'wp-block-group']),
    )) . '>';
    $output .= '<div class="pageteaser__columns ' . join(' ', $classes) . '">';

    while ($page_teaser->have_posts()) :
        $page_teaser->the_post();
        $linked_title = get_the_title();

        // Get first page_category
        $page_cat_list = get_the_terms(get_the_ID(), 'page_category');
        $page_cat_list = wp_list_pluck($page_cat_list, 'name');
        $page_cat_name = $page_cat_list ? $page_cat_list : '';

        // HANDLE DIFFERENT TEASER TYPES :-((
        if (in_array('Webinar', $page_cat_list)) {
            // +++ Webinar (category) +++
            include('templates/webinar.php');
        } elseif (get_post_type() === 'vd_location') {
            // +++ Location (posttype) +++
            include('templates/location.php');
        } elseif (get_post_type() === 'post') {
            // +++ Post (posttype) +++
            include('templates/post.php');
        } else {
            // +++ Default (fallback) +++
            include('templates/default.php');
        }
    endwhile;
    $output .= '</div><!-- ' . $page_teaser->found_posts . ' -->';

    // Load more
    if ($attributes['displayLoadmore'] && $page_teaser->found_posts > 2) :
        $output .= '<div class="pageteaser__footer">';
        $output .= '<button class="loadmore wp-block-button__link wp-element-button" type="button" ';
        if ($attributes['showSubpages']) {
            $output .= 'data-next-page="2" data-query="' . $endpoint . '?parent='.$parent_page_id.'&per_page='.$attributes['columns'].'&status=publish&_fields=id,link,title,excerpt,featured_media,_links.wp:featuredmedia,_embedded,_embedded&_embed=wp:featuredmedia">Load more</button>';
        } else {
            $output .= 'data-next-page="2" data-query="' . $endpoint . '?per_page='.$attributes['columns'].'&status=publish&_fields=id,link,title,excerpt,featured_media,_links.wp:featuredmedia,_embedded,_embedded&_embed=wp:featuredmedia">Load more</button>';
        }
        $output .= '</div>';
    endif;

    /* Restore original Post Data */
    wp_reset_postdata();
else :
    $output = '<div>There are no child pages to show here. Please delete this block or add some child pages.</div>';
endif;

echo $output;
