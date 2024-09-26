<?php

function vdplug_home_did_you_know_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/home-did-you-know'
    );
}
add_action('init', 'vdplug_home_did_you_know_init');
