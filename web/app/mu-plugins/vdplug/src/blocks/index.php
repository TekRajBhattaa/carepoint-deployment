<?php

/**
 * Add custom block category
 */
function vdblog_block_categories($categories)
{
    return array_merge(
        $categories,
        [
            [
                    'slug' => 'vdplug',
                    'title' => 'Hornet Blocks',
                    'icon'  => null,
            ]
        ]
    );
}
add_filter('block_categories_all', 'vdblog_block_categories', 10, 2);

/**
 * Custom Block Types
 * IMPORTANT: Build step required!
 * Wondering PHP changes do not work? - Start `npm run start`
 */
require_once VDPLUG_DIR . 'build/blocks/accordion/index.php';
require_once VDPLUG_DIR . 'build/blocks/box/index.php';
require_once VDPLUG_DIR . 'build/blocks/related/index.php';
require_once VDPLUG_DIR . 'build/blocks/gridcols/index.php';
require_once VDPLUG_DIR . 'build/blocks/pageteaser/index.php';
require_once VDPLUG_DIR . 'build/blocks/section/index.php';
require_once VDPLUG_DIR . 'build/blocks/vdslider/index.php';
require_once VDPLUG_DIR . 'build/blocks/fivestar/index.php';
require_once VDPLUG_DIR . 'build/blocks/featured/index.php';
require_once VDPLUG_DIR . 'build/blocks/counter/index.php';
require_once VDPLUG_DIR . 'build/blocks/bloginfo/index.php';
require_once VDPLUG_DIR . 'build/blocks/toggle-block/index.php';

/**
 * All new gutenberg blocks (from plugins or selfmade)
 * must be added to whitelist below.
 */
function vdplug_allowed_block_types($allowed_blocks, $editor_context)
{
    $allowed_blocks = array(
        'core/button',
        'core/buttons',
        'core/block',
        'core/group',
        'core/template',
        'core/cover',
        'core/image',
        'core/gallery',
        'core/video',
        'core/audio',
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/list-item',
        'core/subhead',
        'core/quote',
        'core/table',
        'core/columns',
        'core/text-columns',
        'core/media-text',
        'core/more',
        'core/post-author',
        'core/post-date',
        'core/post-title',
        'core/post-terms',
        'core/spacer',
        'core/separator',
        'core/file',
        'core/embed',
        'core/shortcode',
        'core/pattern',
        'core/legacy-widget',
        /* plugins */
        'gravityforms/form',
        'lottiefiles/block-lottiefiles',
        'safe-svg/svg-icon',
        'yoast/faq-block',
        'yoast/how-to-block',
        'yoast-seo/breadcrumbs',
        /* custom */
        'verdure/box',
        'verdure/related',
        'verdure/section',
        'verdure/accordion',
        'verdure/pageteaser',
        'verdure/category-teaser',
        'verdure/vdslider',
        'verdure/vdslider-item',
        'verdure/fivestar',
        'verdure/counter',
        'verdure/gridcols',
        'verdure/featured',
        'verdure/bloginfo',
        'verdure/toggle-block',
        /* spectra */
        "uagb/container",
        "uagb/advanced-heading",
        // "uagb/buttons",
        // "uagb/buttons-child",
        // "uagb/info-box",
        // "uagb/call-to-action",
        // "uagb/icon",
        // "uagb/countdown",
        // "uagb/content-timeline-child",
        // "uagb/faq-child",
        // "uagb/forms-name",
        // "uagb/forms-email",
        // "uagb/forms-hidden",
        // "uagb/forms-phone",
        // "uagb/forms-textarea",
        // "uagb/forms-checkbox",
        // "uagb/forms-radio",
        // "uagb/forms-url",
        // "uagb/forms-select",
        // "uagb/forms-toggle",
        // "uagb/forms-date",
        // "uagb/icon-list-child",
        // "uagb/post-title",
        // "uagb/post-image",
        // "uagb/post-taxonomy",
        // "uagb/post-button",
        // "uagb/post-excerpt",
        // "uagb/post-meta",
        // "uagb/restaurant-menu-child",
        // "uagb/slider-child",
        // "uagb/social-share-child",
        "uagb/tabs",
        "uagb/tabs-child",
        // "uagb/column",
    );

    return $allowed_blocks;
}
add_filter('allowed_block_types_all', 'vdplug_allowed_block_types', 10, 2);
