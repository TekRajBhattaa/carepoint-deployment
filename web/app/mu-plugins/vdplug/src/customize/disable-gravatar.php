<?php

/**
 * Returning a non-null value will effectively short-circuit get_avatar(),
 * passing the value through the ‘get_avatar’ filter and returning early.
 */
add_filter('pre_get_avatar', '__return_empty_string');
