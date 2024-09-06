<?php

function vdplug_bloginfo_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/bloginfo'
    );
}
add_action('init', 'vdplug_bloginfo_init');
