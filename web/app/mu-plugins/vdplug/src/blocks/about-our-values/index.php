<?php

function vdplug_about_our_values_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/about-our-values'
    );
}
add_action('init', 'vdplug_about_our_values_init');
