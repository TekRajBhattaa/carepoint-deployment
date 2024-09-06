<?php

$output .= '<article class="teaser">';

// POST THUMBNAIL
if ($attributes['displayFeaturedImage'] && has_post_thumbnail()) {
    $featured_image = get_the_post_thumbnail(
        null,
        $attributes['featuredImageSizeSlug']
    );
    $output .= '<figure class="wp-block-image">';
    $output .= '<a href="' . get_the_permalink() . '">' . $featured_image . '</a>';
    $output .= '</figure>';
}

$output .= '<div class="teaser__inner">';

// PAGE CATEGORY
if (is_array($page_cat_name)) {
    $output .= '<div class="teaser__info">' . join(', ', $page_cat_name) . '</div>';
}

// TITLE
$output .= sprintf('<h4 class="teaser__title"><a href="%s">%s</a></h4>', get_the_permalink(), $linked_title);

// EXCERPT or CONTENT
$output .= '<div class="teaser__excerpt">' . get_the_excerpt() . '</div>';

// READMORE
$output .= '<p class="readmore"><a href="' . get_the_permalink() . '">' . __('Read more') . '</a></p>';

$output .= '</div>';
$output .= '</article>';
