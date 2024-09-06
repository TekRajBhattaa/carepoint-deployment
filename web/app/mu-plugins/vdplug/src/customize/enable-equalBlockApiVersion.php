<?php

/**
 * Enforce block api version <= 3
 */
function vdplug_filter_metadata_registration($settings, $metadata)
{
    $settings['api_version'] = 3;
    return $settings;
};
add_filter('block_type_metadata_settings', 'vdplug_filter_metadata_registration', 10, 2);
