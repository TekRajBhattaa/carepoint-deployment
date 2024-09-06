<?php

defined('ABSPATH') || exit;

function vdplug_section_init()
{
    register_block_type(
        VDPLUG_DIR . '/build/blocks/section'
    );
}
add_action('init', 'vdplug_section_init');

/**
 * Render Block only if blockVisibility attribute is true
 */
function vdplug_section_render_block($block_content, $block)
{
    if ($block['blockName'] === 'verdure/section') {
        if (isset($block['attrs']['blockAuth']) && !empty($block['attrs']['blockAuth'])) {
            $user = wp_get_current_user();
            $isLogged = $user->exists();

            if ($isLogged && $block['attrs']['blockAuth'] === 'is-unlogged') {
                return '';
            }

            // is-logged user required
            if (!$isLogged && $block['attrs']['blockAuth'] === 'is-logged') {
                return '';
            }

            // At this point users are logged, check for optional user role
            // if (!empty($block['attrs']['blockRole'])) {
            //     if (!in_array($block['attrs']['blockRole'], (array) $user->roles)) {
            //         // The user has NOT the required role
            //         return '';
            //     }
            // }
        }
    }

    return $block_content;
}
add_filter('render_block', 'vdplug_section_render_block', 10, 2);
