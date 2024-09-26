<?php

function vdplug_about_first_section_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/about-first-section'
    );
}
add_action('init', 'vdplug_about_first_section_init');
