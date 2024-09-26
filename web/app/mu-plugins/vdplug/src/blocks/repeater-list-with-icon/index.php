<?php

function vdplug_repeater_list_with_icon_block_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/repeater-list-with-icon'
    );
}
add_action('init', 'vdplug_repeater_list_with_icon_block_init');
