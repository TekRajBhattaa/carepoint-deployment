<?php

/**
 * Register global taxonomy used across all post types
 */
function vdplug_register_global_taxonomy()
{
    $cpt_types = ['page', 'post', 'vd_job', 'vd_location', 'vd_news'];

    $labels = array(
        'name' => _x('Page categories', 'taxonomy general name'),
        'singular_name' =>_x('Page category', 'taxonomy singular name'),
        'search_items' =>__('Search Page categories'),
        'all_items' =>__('All Page categories'),
        'parent_item' =>__('Parent Page category'),
        'parent_item_colon' =>__('Parent Page category:'),
        'edit_item' =>__('Edit Page category'),
        'update_item' =>__('Update Page category'),
        'add_new_item' =>__('Add New Page category'),
        'new_item_name' =>__('New Page category Name'),
        'menu_name' =>__('Page categories'),
    );

    // Now register the page taxonomy
    register_taxonomy('page_category', $cpt_types, array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'show_in_rest' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true
    ));
}
add_action('init', 'vdplug_register_global_taxonomy');
