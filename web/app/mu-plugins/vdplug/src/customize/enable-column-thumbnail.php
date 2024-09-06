<?php

/**
 * Add a custom column for post list
 */
function vdplug_AddThumbColumn($cols)
{
    $cols['thumbnail'] = __('Thumbnail');
    return $cols;
}

function vdplug_AddThumbValue($column_name, $post_id)
{
    if ('thumbnail' !== $column_name) {
        return;
    }

    $width = (int) 100;
    $height = $width / 4 * 3;
    $thumbnail_id = get_post_meta($post_id, '_thumbnail_id', true);
    // image from gallery
    $attachments = get_children(array(
        'post_parent' => $post_id,
        'post_type' => 'attachment',
        'post_mime_type' => 'image'
    ));
    if ($thumbnail_id) {
        $thumb = wp_get_attachment_image($thumbnail_id, array($width, $height), true);
    } elseif ($attachments) {
        foreach ($attachments as $attachment_id => $attachment) {
            $thumb = wp_get_attachment_image($attachment_id, array($width, $height), true);
        }
    }
    if (isset($thumb) && $thumb) {
        echo $thumb;
    } else {
        echo VDPLUG_DEFAULT_IMG;
    }
}

// Add the column to posts
add_filter('manage_posts_columns', 'vdplug_AddThumbColumn');
add_action('manage_posts_custom_column', 'vdplug_AddThumbValue', 10, 2);

// Add the column to pages
add_filter('manage_pages_columns', 'vdplug_AddThumbColumn');
add_action('manage_pages_custom_column', 'vdplug_AddThumbValue', 10, 2);

// Add the column to vd_news
add_filter('manage_vd_news_columns', 'vdplug_AddThumbColumn');
add_action('manage_vd_news_custom_column', 'vdplug_AddThumbValue', 10, 2);
