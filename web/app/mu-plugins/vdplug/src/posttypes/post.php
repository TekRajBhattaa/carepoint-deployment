<?php

function vdplug_init_post()
{
    $post_type_object = get_post_type_object('post');
    $post_type_object->template = array(
        array('core/cover', array(
                "className" => "hero",
                "backgroundColor" => "gray",
                "dimRatio" => "0",
                "url" => "/app/mu-plugins/vdplug/static/example-1920.jpg",
                "align" => "full"
            ),
            array(
                array('core/post-title', array('textAlign' => 'center')),
                array('verdure/bloginfo')
            )
        ),
        array('yoast-seo/breadcrumbs', array()),
        array('verdure/section', array(), array(
            array('core/paragraph')
        ))
    );
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'vdplug_init_post');

// Store optional video url with postmeta
register_post_meta(
    'post',
    'vd_video_url',
    array(
        'show_in_rest' => true,
        'single'       => true,
        'type'         => 'string',
    )
);
