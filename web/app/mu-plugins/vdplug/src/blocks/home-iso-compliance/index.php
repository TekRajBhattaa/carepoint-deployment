<?php

function vdplug_home_iso_compliance_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/home-iso-compliance'
    );
}
add_action('init', 'vdplug_home_iso_compliance_init');
