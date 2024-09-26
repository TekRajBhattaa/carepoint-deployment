<?php

function vdplug_about_banner_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/about-banner'
    );
}
add_action('init', 'vdplug_about_banner_init');
