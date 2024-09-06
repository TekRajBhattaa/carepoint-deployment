<?php
/*

TEMPLATE FOR Block "verdure/bloginfo"

https://make.wordpress.org/core/2022/10/12/block-api-changes-in-wordpress-6-1/
The following variables are available inside the template:

$attributes     (array): The block attributes.
$content        (string): The block default content.
$block          (WP_Block): The block instance.

*/
global $authordata;

$post_terms = get_the_term_list($post->ID, 'category', '', ', ', '');
if (get_post_type() == 'vd_release-note') {
    $terms = wp_get_post_terms(get_the_ID(), 'vd_release_category');
    foreach ($terms as $term) {
        $post_terms .= "<a href=".get_category_link($term->term_id).">".$term->name."</a>";
        if (next($terms)) {
            $post_terms .= ",";
        }
    }
}

$post_author = get_the_author_meta('nickname');
$post_author_url = get_author_posts_url($authordata->ID, $authordata->user_nicename);
$post_date = get_the_date('d.m.Y');
$block_classes = get_block_wrapper_attributes(array('class' => 'bloginfo'));
$post_author_html = '';

if ($attributes['showAuthor']) {
    $post_author_html = __('Written by', 'vdplug') . " <a class=\"bloginfo__author\" href=\"$post_author_url\">$post_author</a> / ";
}

echo <<<HTML
<div $block_classes>
$post_author_html
<span class="bloginfo__date">$post_date</span>
/ <span class="bloginfo__category">$post_terms</span>
</div>
HTML;
