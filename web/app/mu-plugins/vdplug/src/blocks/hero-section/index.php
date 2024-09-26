<?php

function vdplug_hero_section_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/hero-section'
    );
}
add_action('init', 'vdplug_hero_section_init');
