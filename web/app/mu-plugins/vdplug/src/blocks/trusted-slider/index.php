<?php
defined('ABSPATH') || exit;

require_once VDPLUG_DIR . 'build/blocks/trusted-slider/vdslider-item/index.php';

add_action('init', function () {
    register_block_type(VDPLUG_DIR . 'build/blocks/trusted-slider');
});
