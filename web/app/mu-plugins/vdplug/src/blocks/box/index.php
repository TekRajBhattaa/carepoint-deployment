<?php

function vdplug_box_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/box'
    );
}
add_action('init', 'vdplug_box_init');
