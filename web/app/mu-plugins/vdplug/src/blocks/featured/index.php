<?php

function vdplug_featured_init()
{
    register_block_type(VDPLUG_DIR . '/build/blocks/featured');
}
add_action('init', 'vdplug_featured_init');
