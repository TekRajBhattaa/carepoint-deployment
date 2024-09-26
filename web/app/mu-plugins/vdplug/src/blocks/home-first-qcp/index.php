<?php

function vdplug_home_first_qcp_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/home-first-qcp'
    );
}
add_action('init', 'vdplug_home_first_qcp_init');
