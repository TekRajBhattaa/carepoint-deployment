<?php

function vdplug_image_section_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/image-section'
    );
}
add_action('init', 'vdplug_image_section_init');
