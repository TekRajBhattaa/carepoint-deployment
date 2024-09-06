<?php
defined('ABSPATH') || exit;

add_action('init', function () {
    register_block_type(VDPLUG_DIR . '/build/blocks/accordion');
});
