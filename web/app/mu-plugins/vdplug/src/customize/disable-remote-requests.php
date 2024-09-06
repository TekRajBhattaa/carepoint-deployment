<?php

/**
 * SPEED UP Wordpress, Stop Wordpress calling home.
 */

/**
 * Disable News Widget on Dashboard because remote connections aren't allowed
 */
function vdplug_remove_dashboard_widgets()
{
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');
}
add_action('wp_dashboard_setup', 'vdplug_remove_dashboard_widgets');

/**
 * Block external WordPress API request
 */
function vdplug_api_block_request($pre, $args, $url)
{
    if (strpos($url, 'wordpress.org')) {
        return true;
    } else {
        return $pre;
    }
}
add_filter('pre_http_request', 'vdplug_api_block_request', 10, 3);
