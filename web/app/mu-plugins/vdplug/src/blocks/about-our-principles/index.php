<?php

function vdplug_about_our_principles_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/about-our-principles'
    );
}
add_action('init', 'vdplug_about_our_principles_init');
