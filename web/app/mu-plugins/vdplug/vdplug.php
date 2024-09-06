<?php
/*
Plugin Name: VDplug
Description: Wordress Plugin for Custom Post Types, Blocks.
*/

use function Env\env;

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

$upload_dir = wp_upload_dir();
// Define constants for plugin path and url
define('ASSETS_VERSION', env('ASSETS_VERSION'));
define('VDPLUG_URL', WP_HOME . '/app/mu-plugins/vdplug/');
define('VDPLUG_DIR', trailingslashit(plugin_dir_path(__FILE__)));
define('VDPLUG_UPLOAD_URL', trailingslashit($upload_dir['baseurl']));
define('VDPLUG_DEFAULT_IMG', '<div class="noimage"><div class="dashicons dashicons-format-image"></div>' .
'<div class="noimage__title">No Image</div></div>');

// This are the default blocks for new post types
define('VDPLUG_TPL', array(
    array('core/cover', array(
        "className" => "hero",
        "backgroundColor" => "gray",
        "dimRatio" => 0,
        "url" => "/app/mu-plugins/vdplug/static/example-1920.jpg",
        "align" => "full"
    ),
    array(
        array('core/columns', array(), array(
            array('core/column', array(), array(
                array('core/heading', array(
                    "content" => "Title",
                    "level" => 1
                )),
                array('core/paragraph', array(
                    "content" => "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa."
                )),
            )),
            array('core/column', array(), array(
                array('core/image', array(
                    "id" => 15,
                    "sizeSlug" => "large",
                    "linkDestination" => "none"
                ))
            ))
        ))
    )),
    array('verdure/section', array(), array(
        array('core/paragraph')
    ))
));

// Utility functions
// require_once VDPLUG_DIR . 'src/lib/utils.php';

// Post types
require_once VDPLUG_DIR . 'src/posttypes/index.php';

// Custom settings
require_once VDPLUG_DIR . 'src/customize/index.php';

// Rest APIs
require_once VDPLUG_DIR . 'src/rest/index.php';

// Custom blocks
require_once VDPLUG_DIR . 'src/blocks/index.php';

// Custom blocks-mods
require_once VDPLUG_DIR . 'src/blocks-mod/index.php';

// Load required wp-cli extensions
if (defined('WP_CLI') && WP_CLI) {
    include_once VDPLUG_DIR . 'src/wp-cli/index.php';
}

/**
 * MU plugins inside directories are not returned in `get_mu_plugins`.
 * This filter modifies the array obtained from Wordpress when Loco grabs it.
 *
 * Note that this filter only runs once per script execution, because the value is cached.
 * Define the function *before* Loco Translate plugin is even included by WP.
 */
function vdplug_unregistered_plugins_to_loco(array $plugins)
{
    // we know the plugin by this handle, even if WordPress doesn't
    $handle = 'vdplug/vdplug.php';

    // fetch the plugin's meta data from the would-be plugin file
    $data = get_plugin_data(trailingslashit(WP_CONTENT_DIR . '/mu-plugins').$handle);

    // extra requirement of Loco - $handle must be resolvable to full path
    $data['basedir'] = WP_CONTENT_DIR . '/mu-plugins';

    // add to array and return back to Loco Translate
    $plugins[$handle] = $data;
    return $plugins;
}
add_filter('loco_plugins_data', 'vdplug_unregistered_plugins_to_loco', 10, 1);

/**
 * Enqueue ADMIN BACKEND scripts and styles.
 * CSS is loaded on non-gutenberg admin pages
 */
function vdplug_enqueue_admin_assets()
{
    wp_enqueue_style(
        'vdplug-admin-css',
        VDPLUG_URL . 'admin.css',
        array(),
        ASSETS_VERSION
    );
}
add_action('admin_enqueue_scripts', 'vdplug_enqueue_admin_assets');

/**
 * Enqueue Block scripts and styles.
 */
function vdplug_enqueue_block_assets()
{
    // Enqueue EDITOR BLOCK scripts and styles.
    if (is_admin()) {
        global $pagenow;
        $editor_asset = require(VDPLUG_DIR . 'build/editor.asset.php');

        wp_register_script(
            'vdplug-editor-js',
            VDPLUG_URL . 'build/editor.js',
            $editor_asset['dependencies'],
            ASSETS_VERSION,
            array('strategy' => 'defer')
        );
        wp_enqueue_script('vdplug-editor-js');

        // THIS FILE is for workarounds
        // Add the deps to editor.js didn't work?! :/
        $deps = array('wp-blocks', 'wp-dom-ready');
        if ('widgets.php' === $pagenow) {
            // If we're on the Widgets admin page, add wp-edit-widgets to the dependencies.
            $deps[] = 'wp-edit-widgets';
        } elseif ('site-editor.php' === $pagenow) {
            // If we're on the Site Editor admin page, add wp-edit-site to the dependencies.
            $deps[] = 'wp-edit-site';
        } else {
            // If we're on the post/Page/CPT editing screen (e.g. at wp-admin/post.php), add
            // wp-edit-post to the dependencies.
            $deps[] = 'wp-edit-post';
        }
        wp_enqueue_script(
            'vdplug-workarounds-js',
            VDPLUG_URL . 'static/workarounds.js',
            $deps,
            ASSETS_VERSION
        );

        wp_enqueue_style(
            'vdplug-editor-css',
            VDPLUG_URL . 'build/editor.css',
            array(),
            ASSETS_VERSION
        );
    }
}
add_action('enqueue_block_assets', 'vdplug_enqueue_block_assets');

/**
 * Load plugin textdomain.
 * Bedrock only loads translation in languages/pluginname folder :(
 * https://github.com/roots/bedrock/issues/117
 */
function vdplug_init()
{
    // LOAD TRANSLATIONS MANUAL
    // https://wordpress.stackexchange.com/questions/407346/using-wp-set-script-translations-without-manually-registering-the-script

    load_muplugin_textdomain('vdplug', 'vdplug/languages');

    // Add excerpt for pages
    add_post_type_support('page', 'excerpt');
}
add_action('init', 'vdplug_init');
