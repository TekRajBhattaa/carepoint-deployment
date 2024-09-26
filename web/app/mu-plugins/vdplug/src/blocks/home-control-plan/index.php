<?php

function vdplug_home_control_plan_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/home-control-plan'
    );
}
add_action('init', 'vdplug_home_control_plan_init');
