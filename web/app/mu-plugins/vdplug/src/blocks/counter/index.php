<?php
defined('ABSPATH') || exit;

require_once(VDPLUG_DIR . '/build/blocks/counter/counter-item/index.php');

/**
 * Init counter
 * @return void
 */
function vdplug_counter_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/counter'
    );
}
add_action('init', 'vdplug_counter_init');
