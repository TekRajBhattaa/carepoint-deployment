<?php

function vdplug_toggle_block_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/toggle-block'
    );
}
add_action('init', 'vdplug_toggle_block_init');
