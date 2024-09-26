<?php

function vdplug_home_qa_software_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/home-qa-software'
    );
}
add_action('init', 'vdplug_home_qa_software_init');
