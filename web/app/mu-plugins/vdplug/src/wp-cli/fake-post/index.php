<?php
namespace WP_CLI\DummyContent;

require_once(__DIR__ . '/lorem.php');
use RandomContent;

function genFakePost($args)
{

    $content = '<!-- wp:verdure/hero -->';
    $content .= '<div class="hero"><!-- wp:cover {"useFeaturedImage":true,"overlayColor":"rgba(0,0,0,0)","gradient":"hero-1","isDark":false,"allowedBlocks":[["core/heading","core/paragraph","core/buttons","core/button"]],"align":"full"} -->';
    $content .= '<div class="wp-block-cover alignfull is-light"><span aria-hidden="true" class="wp-block-cover__background has-rgba-0-0-0-0-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"lock":{"move":true,"remove":false},"className":"is-style-subheading"} -->';
    $content .= '<p class="is-style-subheading">Sub heading</p>';
    $content .= '<!-- /wp:paragraph -->';

    $content .= '<!-- wp:heading {"level":1,"lock":{"move":false,"remove":true}} -->';
    $content .= '<h1>' . RandomContent\Lorem::sentence() . '</h1>';
    $content .= '<!-- /wp:heading -->';

    $content .= '<!-- wp:buttons -->';
    $content .= '<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-fill"} -->';
    $content .= '<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button">Mehr lesen</a></div>';
    $content .= '<!-- /wp:button --></div>';
    $content .= '<!-- /wp:buttons --></div></div>';
    $content .= '<!-- /wp:cover --></div>';
    $content .= '<!-- /wp:verdure/hero -->';

    for ($i = 0; $i < $args['sections']; $i++) {
        $content .= '<!-- wp:verdure/section -->';
        $content .= '<section class="wp-block-verdure-section section"><div class="section__inner">';
        $content .= '<!-- wp:heading -->';
        $content .= '<h2>' . RandomContent\Lorem::sentence() . '</h2>';
        $content .= '<!-- /wp:heading --><!-- wp:paragraph -->';
        $content .= '<p>' . RandomContent\Lorem::ipsum($args['paragraphs']) . '</p>';
        $content .= '<!-- /wp:paragraph --></div></section>';
        $content .= '<!-- /wp:verdure/section -->';
    }

    return $content;
}

function insertFakePost($args)
{
    $page_title = RandomContent\Lorem::sentence();
    $page_content = genFakePost($args);
    $page_type = $args["type"];
    $cpt_types = ['page', 'vd_job', 'vd_location', 'vd_news'];

    $new_page = array(
        'post_type'     => $page_type,          // Post Type Slug eg: 'page', 'post'
        'post_title'    => $page_title,         // Title of the Content
        'post_content'  => $page_content,       // Content
        'post_status'   => 'publish',           // Post Status
        'post_author'   => 1,                   // Post Author ID
    );

    $post_id = wp_insert_post($new_page);

    if (!is_wp_error($post_id)) {
        // the post is valid
        $random_image = get_posts(
            array(
                'post_type'      => 'attachment',
                'orderby'        => 'rand',
                'post_mime_type' => 'image',
                'post_status'    => 'inherit',
                'posts_per_page' => 1,
                'fields'         => 'ids',
            )
        );

        // Add a random featured post-thumbnail if there are images any in media library
        if (count($random_image) == 1) {
            set_post_thumbnail($post_id, $random_image[0]);
        }

        // Get a random taxonomy from "page_category" and set it for the post
        if (in_array($page_type, $cpt_types)) {
            $pageTerms = get_terms(array(
                'taxonomy'   => 'page_category',
                'hide_empty' => false,
            ));
            shuffle($pageTerms); // Randomize Term Array
            if (count($pageTerms) > 0) {
                $pageCategory = $pageTerms[0];
                wp_set_object_terms($post_id, $pageCategory->name, 'page_category');
            }
        }
    } else {
        //there was an error in the post insertion,
        echo $post_id->get_error_message();
    }
}
