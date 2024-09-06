<?php

/**
 * Remove WordPress Version Number from Script and Style Files
 * use global constant (taken from .env) instead wordpress version
 *
 * @param string $src   Source File
 * @return string $src   Source File
 */
function vdplug_remove_wp_version_from_assets($src)
{
    if (strpos($src, '?ver=')) {
        $src = add_query_arg('ver', ASSETS_VERSION, $src);
    }
    return $src;
}
add_filter('style_loader_src', 'vdplug_remove_wp_version_from_assets', 9999);
add_filter('script_loader_src', 'vdplug_remove_wp_version_from_assets', 9999);
