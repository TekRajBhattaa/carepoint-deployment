<?php

function vdplug_new_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/new'
    );
}
add_action('init', 'vdplug_new_init');
