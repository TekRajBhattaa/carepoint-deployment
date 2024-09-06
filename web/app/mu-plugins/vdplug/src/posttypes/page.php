<?php

function vdplug_init_page()
{
    $post_type_object = get_post_type_object('page');
    $post_type_object->template = VDPLUG_TPL;
}
add_action('init', 'vdplug_init_page');
