<?php

defined('ABSPATH') || exit;

/**
 * Sub-Teaser Init
 */
function vdplug_pageteaser_init()
{
    register_block_type(
        VDPLUG_DIR . 'build/blocks/pageteaser'
    );
}
add_action('init', 'vdplug_pageteaser_init');
