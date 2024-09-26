<?php

function vdplug_new2_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/new2'
    );
}
add_action('init', 'vdplug_new2_init');
