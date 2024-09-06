<?php

defined('ABSPATH') || exit;

/**
 * Featured-Teaser Init
 */
function vdplug_related_init()
{
    register_block_type(
        VDPLUG_DIR . 'build/blocks/related'
    );
}
add_action('init', 'vdplug_related_init');
