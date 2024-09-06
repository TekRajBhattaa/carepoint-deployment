<?php
if (! defined('WPINC')) {
    die;
}

/**
 * Disable XML-RPC
 * TODO: Disable XML-RPC and some WP-JSON Rest-Endpoints for anonymous users
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Disable Users Rest-Endpoint for anonymous users
 */
function vdplug_restapi_only_for_admin_users()
{
    $current_user = wp_get_current_user();
    if (str_contains($_SERVER['REQUEST_URI'], 'wp-json/wp/v2/users')) {
        if (in_array('administrator', $current_user->roles)) {
            return;
        } else {
            wp_die('Sorry you are not allowed to access this data', 'API REST Forbidden', 403);
        }
    }
}
add_filter('rest_api_init', 'vdplug_restapi_only_for_admin_users', 99);
