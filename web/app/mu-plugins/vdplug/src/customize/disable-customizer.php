<?php

/**
 * Callback customizer permission
 */
function vdplug_remove_customize_capability(
    $caps = [],
    $cap = ''
) {
    if ($cap == 'customize') {
        return ['nope'];
    }

    return $caps;
}

/**
 * Disable customizer on frontend
 */
function vdplug_remove_customize_init()
{
    add_filter(
        'map_meta_cap',
        'vdplug_remove_customize_capability',
        10,
        4
    );
}
add_action('init', 'vdplug_remove_customize_init', 10);

/**
 * Disable customizer on backend
 */
function vdplug_remove_customize_admin_init()
{
    remove_action('plugins_loaded', '_wp_customize_include', 10);
    remove_action(
        'admin_enqueue_scripts',
        '_wp_customize_loader_settings',
        11
    );

    add_action('load-customize.php', function () {
        wp_die(
            __('The Customizer is currently disabled.', 'vdplug')
        );
    });
}
add_action('admin_init', 'vdplug_remove_customize_admin_init', 10);
