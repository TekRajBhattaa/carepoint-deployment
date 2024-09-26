<?php

function vdplug_home_qc_solutions_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/home-qc-solutions'
    );
}
add_action('init', 'vdplug_home_qc_solutions_init');
