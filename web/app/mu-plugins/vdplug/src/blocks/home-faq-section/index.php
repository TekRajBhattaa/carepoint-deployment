<?php

function vdplug_home_faq_section_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/home-faq-section'
    );
}
add_action('init', 'vdplug_home_faq_section_init');
