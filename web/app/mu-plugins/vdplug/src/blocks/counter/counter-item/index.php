<?php
defined('ABSPATH') || exit;

/**
 * Init counter item
 * @return void
 */
function vdplug_counter_item_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/counter/counter-item'
    );
}
add_action('init', 'vdplug_counter_item_init');
