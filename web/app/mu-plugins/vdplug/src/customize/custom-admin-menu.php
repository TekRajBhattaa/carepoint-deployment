<?php
if (! defined('WPINC')) {
    die;
}

/**
 * Change Position of "Menu" Link for editors
 */
function vdplug_admin_menu()
{
    $current_user = wp_get_current_user();

    if ($current_user->has_cap('editor')) {
        // Hide core Update
        remove_submenu_page('index.php', 'update-core.php');

        // Remove Design->Menu and move to Top-Level
        remove_menu_page('themes.php');
        add_menu_page(
            __('Menu'),
            __('Menu'),
            'level_7',
            'nav-menus.php',
            '',
            '',
            34
        );
    }
}
add_action('admin_menu', 'vdplug_admin_menu');
