<?php
defined('ABSPATH') || exit;

/**
 * Init and register Custom Post Type Location
 * @return void
 */
function vdplug_create_location_posttype()
{
    /*
     * Taxonomy Location Office
     */
    register_taxonomy('vd_location_office', ['vd_location'], [
        'label' => __('Location Office', 'vdplug'),
        'hierarchical' => false,
        'rewrite' => [
            'slug' => 'location-office',
            'with_front' => false
        ],
        'show_admin_column' => true,
        'show_in_rest' => true,
        'labels' => [
            'singular_name' => __('Location Office', 'vdplug'),
            'all_items' => __('All Location Offices', 'vdplug'),
            'edit_item' => __('Edit Location Office', 'vdplug'),
            'view_item' => __('View Location Office', 'vdplug'),
            'update_item' => __('Update Location Office', 'vdplug'),
            'add_new_item' => __('Add New Location Office', 'vdplug'),
            'new_item_name' => __('New Location Office Name', 'vdplug'),
            'search_items' => __('Search Location Offices', 'vdplug'),
            'parent_item' => __('Parent Location Office', 'vdplug'),
            'parent_item_colon' => __('Parent Location Office:', 'vdplug'),
            'not_found' => __('No Location Offices found', 'vdplug'),
        ]
    ]);

    /*
     * Custom Post Type Location
     */
    register_post_type('vd_location', array(
        'labels' => array(
            'name' => __('Locations', 'vdplug'),
            'singular_name' => _x('Location', 'post type singular name', 'vdplug'),
            'add_new' => __('Add New Location', 'vdplug'),
            'add_new_item' => __('Add New Location', 'vdplug'),
            'edit_item' => __('Edit Location', 'vdplug'),
            'new_item' => __('New Location', 'vdplug'),
            'view_item' => __('View Location', 'vdplug'),
            'search_items' => __('Search Location', 'vdplug'),
            'not_found' =>  __('Nothing found', 'vdplug'),
            'not_found_in_trash' => __('Nothing found in Trash', 'vdplug'),
            'parent_item_colon' => ''
        ),
        'public' => false,
        'show_ui' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-businessperson',
        'hierarchical' => false,
        'show_in_rest' => true, // required for Gutenberg!
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite' => array(
            'slug' => 'location',
            'with_front' => false
        ),
        'template' => VDPLUG_TPL,
        'taxonomies' => array('vd_location_office'),
    ));

    /**
     * Register custom post meta field.
     */
    register_post_meta(
        'vd_location',
        'vd_location_latitude',
        array(
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
        )
    );

    register_post_meta(
        'vd_location',
        'vd_location_longitude',
        array(
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
        )
    );

    register_post_meta(
        'vd_location',
        'vd_location_phone',
        array(
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
        )
    );

    register_post_meta(
        'vd_location',
        'vd_location_email',
        array(
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
        )
    );
}
add_action('init', 'vdplug_create_location_posttype');
