<?php

/**
 * Remove any IDs from menu
 */
add_filter('nav_menu_item_id', '__return_false');

/**
 * Add underline animation to nav-top
 */
function vdclassic_menu_link_attributes($atts, $item, $args)
{
    if ($args->theme_location == 'nav-top') {
        $atts['class'] = 'underline-gradient';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'vdclassic_menu_link_attributes', 10, 3);
