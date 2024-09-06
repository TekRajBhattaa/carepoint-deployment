<?php

function vdplug_fivestar_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/fivestar'
    );
}
add_action('init', 'vdplug_fivestar_init');
