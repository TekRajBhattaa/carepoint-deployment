<?php

function vdplug_home_zero_risk_offer_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/home-zero-risk-offer'
    );
}
add_action('init', 'vdplug_home_zero_risk_offer_init');
