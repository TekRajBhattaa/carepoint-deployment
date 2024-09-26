<?php

function vdplug_team_section_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/team-section'
    );
}
add_action('init', 'vdplug_team_section_init');
