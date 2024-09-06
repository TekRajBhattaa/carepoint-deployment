<?php
defined('ABSPATH') || exit;

/**
 * Init and register Custom Post Type Location
 * @return void
 */
function vdplug_create_release_note_posttype()
{
    /*
     * Custom Post Type Release Note
     * NOTE: Hornet PM want the singular name to be "Release Notes" instead "Release Note" !!
     */

     // Register custom taxonomy for vd_job
    register_taxonomy('vd_release_category', 'vd_release-note', [
        'label' => __('Categories', 'vdplug'),
        'rewrite' => [
            'slug' => 'release-notes',
            'with_front' => true
        ],
        'show_admin_column' => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'labels' => [
            'singular_name' => __('Category', 'vdplug'),
            'all_items' => __('All Categoris', 'vdplug'),
            'edit_item' => __('Edit Category', 'vdplug'),
            'view_item' => __('View Category', 'vdplug'),
            'update_item' => __('Update Category', 'vdplug'),
            'add_new_item' => __('Add New Category', 'vdplug'),
            'new_item_name' => __('New Category Name', 'vdplug'),
            'search_items' => __('Search Categoris', 'vdplug'),
            'parent_item' => __('Parent Category', 'vdplug'),
            'parent_item_colon' => __('Parent Category:', 'vdplug'),
            'not_found' => __('No Categoris found', 'vdplug'),
        ]
    ]);

    register_post_type('vd_release-note', array(
        'labels' => array(
            'name' => __('Release Notes', 'vdplug'),
            'singular_name' => _x('Release Notes', 'post type singular name', 'vdplug'),
            'add_new' => _x('Add New', 'Release Notes', 'vdplug'),
            'add_new_item' => __('Add New Release Notes', 'vdplug'),
            'edit_item' => __('Edit Release Notes', 'vdplug'),
            'new_item' => __('New Release Notes', 'vdplug'),
            'view_item' => __('View Release Notes', 'vdplug'),
            'search_items' => __('Search Release Notes', 'vdplug'),
            'not_found' =>  __('Nothing found', 'vdplug'),
            'not_found_in_trash' => __('Nothing found in Trash', 'vdplug'),
            'parent_item_colon' => ''
        ),
        'public' => true,
        'show_ui' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-info-outline',
        'hierarchical' => false,
        'show_in_rest' => true, // required for Gutenberg!
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite' => array(
            'slug' => 'release-notes',
            'with_front' => false
        ),
        'template' => array(

            array('core/cover', array(
                "className" => "hero",
                "backgroundColor" => "gray",
                "dimRatio" => 50,
                "url" => "/app/uploads/2024/01/background-release-notes-jpg.webp",
            ),
            array(

                array('core/post-title', array(
                    'textAlign' => 'center'
                )),
                array('verdure/bloginfo', array(
                        'textAlign' => 'center',
                ))
            )),
            array('verdure/section', array(
                "className" => "section",
                ),
                array(
                    array('core/paragraph', array(
                        'content' => 'Please enter your release notes here...',
                    )),
                ))
        ),
    ));
}
add_action('init', 'vdplug_create_release_note_posttype');

function vdplug_term_image_taxonomy($taxonomy)
{
    // use for tags and categories
    return array( 'vd_release_category', 'category' );
}
add_filter('taxonomy-term-image-taxonomy', 'vdplug_term_image_taxonomy');
