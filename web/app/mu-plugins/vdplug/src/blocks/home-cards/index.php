<?php

function vdplug_home_cards_block_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/home-cards'
    );
}
add_action('init', 'vdplug_home_cards_block_init');
