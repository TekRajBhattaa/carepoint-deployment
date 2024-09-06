<?php

defined('ABSPATH') || exit;

/**
 * Grid-Cols Init
 */
function vdplug_gridcols_init()
{
    register_block_type(
        VDPLUG_DIR . 'build/blocks/gridcols'
    );
}
add_action('init', 'vdplug_gridcols_init');
