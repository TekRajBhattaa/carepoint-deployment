<?php
/**
 * Remove category from archive links
 */
function vdplug_remove_category($string, $type)
{
    if ($type != 'single' && $type == 'category' && (strpos($string, 'category') !== false)) {
        $url_without_category = str_replace("/category/", "/", $string);
        return trailingslashit($url_without_category);
    }

    return $string;
}
add_filter('user_trailingslashit', 'vdplug_remove_category', 100, 2);

/**
 * Pagination broken with WPML & removed category
 */
function vdplug_archive_pagination_rewrite()
{
    add_rewrite_rule('blog/(.+?)/page/?([0-9]{1,})/?$', 'index.php?name=$matches[1]&page=$matches[2]', 'top');
}
add_action('init', 'vdplug_archive_pagination_rewrite');
