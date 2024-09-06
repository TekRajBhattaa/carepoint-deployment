<?php

/**
 * These files are loaded directly with PHP to extend core blocks.
 * The CSS is only loaded when a block is used on the page.
 *
 * https://developer.wordpress.org/reference/functions/wp_enqueue_block_style/
 */
function vdplug_blocks_mod_init()
{
    $styled_blocks = ['button', 'heading', 'cover', 'seperator', 'paragraph', 'media-text', 'list', 'quote', 'image'];
    foreach ($styled_blocks as $block_name) {
        $args = array(
            'handle' => "vdplug-$block_name",
            'src'    => VDPLUG_URL . "build/blocks-mod/style-$block_name.css",
        );
        wp_enqueue_block_style("core/$block_name", $args);
    }

    $styles_uagb = ['tabs'];
    foreach ($styles_uagb as $block_name) {
        $args = array(
            'handle' => "vdplug-$block_name",
            'src'    => VDPLUG_URL . "build/blocks-mod/style-$block_name.css",
        );
        wp_enqueue_block_style("uagb/$block_name", $args);
    }
}
add_action('init', 'vdplug_blocks_mod_init');
