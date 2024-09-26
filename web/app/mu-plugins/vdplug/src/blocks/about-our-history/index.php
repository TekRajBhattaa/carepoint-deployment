<?php

function vdplug_about_our_history_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/about-our-history'
    );
}
add_action('init', 'vdplug_about_our_history_init');
