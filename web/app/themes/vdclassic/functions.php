<?php
use function Env\env;

require_once get_theme_file_path('inc/template-func.php');
require_once get_theme_file_path('src/components/header/index.php');
require_once get_theme_file_path('src/components/primenav/index.php');
require_once get_theme_file_path('src/components/footer/index.php');
require_once get_theme_file_path('src/components/jobs/index.php');

/**
 * Init Theme VDclassic
 */
function vdclassic_setup_theme()
{
    /**
     * Support translations
     */
    load_theme_textdomain('vdclassic', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('block-templates');
    add_theme_support('block-template-parts');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');       // Add support for block styles.
    add_theme_support('align-wide');
    add_theme_support('dark-editor-style');
    add_theme_support('dark-theme');
    // -- Disable Custom Colors
    add_theme_support('disable-custom-colors');
    add_theme_support('disable-custom-font-sizes');
    add_theme_support('disable-custom-gradients');
    add_theme_support('admin-bar', array('callback' => '__return_false'));

    /* TODO: Image size */
    add_image_size('header_42_15', 420, 150); // 42:15
    add_image_size('teaser_16_9', 768, 432); // 16:9
    add_image_size('teaser_3_4', 345, 460); // 3:4
    add_image_size('thumbnail', 320, 200, array('center', 'top')); // 3:2
    add_image_size('square_icon', 48, 48); // 1:1
    add_image_size('square_thumb', 320, 320); // 3:2
    add_image_size('medium', 402, 226); // 16:9
    add_image_size('large', 768, 432);  // 16:9
    add_image_size('full', 1920, 1080);  // 16:9

    // This theme uses wp_nav_menu().
    register_nav_menus(
        array(
            'nav-top' => esc_html__('Top Navigation', 'vdclassic'),
            'nav-primary' => esc_html__('Primary Navigation', 'vdclassic'),
            'nav-footer' => esc_html__('Footer Navigation', 'vdclassic'),
            'nav-footer-sub' => esc_html__('Footer Sub-Navigation', 'vdclassic')
        )
    );

    // Remove Wordpress SVG Filters
    remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
    // Remove Default Wordpress Patterns
    remove_theme_support('core-block-patterns');
    // Remove generator meta tag
    remove_action('wp_head', 'wp_generator');
}
add_action('after_setup_theme', 'vdclassic_setup_theme');

/**
 * Now we register the size so it appears as an option within the editor
 */
function vdclassic_images_sizes($sizes)
{
    return array_merge($sizes, array(
        'teaser_16_9' => __('Teaser 16:9'),
        'teaser_3_4' => __('Teaser 3:4'),
        'square_icon' => __('Square Icon'),
        'square_thumb' => __('Square Thumbnail'),
        'xlarge' => __('XLarge (1920x1080)'),
        'full' => __('Full Image'),
    ));
}
add_filter('image_size_names_choose', 'vdclassic_images_sizes');

/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
add_filter('excerpt_length', function ($length) {
    return 24;
}, 999);

/**
 * Filter the "read more" excerpt string link to the post.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */

add_filter('excerpt_more', function ($more) {
    if (! is_single()) {
        $more = sprintf(
            '<a class="read-more" href="%1$s">%2$s</a>',
            get_permalink(get_the_ID()),
            __('Read More', 'vdclassic')
        );
    }

    return $more;
});

/**
 * Preload webfonts
 */
function vdclassic_head_markup()
{
    $directory = get_stylesheet_directory() . '/build/fonts/';
    $files = array_diff(scandir($directory), array('..', '.'));

    foreach ($files as $file) {
        echo '<link rel="preload" href="' . get_stylesheet_directory_uri() . '/build/fonts/' . $file . '" as="font" type="font/woff2" crossorigin>' . "\n";
    }
}
add_action('wp_head', 'vdclassic_head_markup');

/**
 * Add defer attribute to scripts with the following handles
 */
function vdclassic_async_styles($tag, $handle, $src)
{
    // The handles of the enqueued scripts we want to defer
    $defer_styles = [
        'vdclassic',
        'verdure',
        'vdplug',
        'wp-block-library' // block library
    ];

    // Find styles in array and preload
    foreach ($defer_styles as &$handleName) {
        if (str_starts_with($handle, $handleName)) {
            $tag = str_replace(
                "rel='stylesheet'",
                "rel='preload stylesheet' as='style' crossorigin",
                $tag
            );

            return $tag;
        }
    }

    return $tag;
}
add_filter('style_loader_tag', 'vdclassic_async_styles', 10, 3);

/**
 * Very basic meta description
 */
function vdclassic_meta_description()
{
    if (is_single()) {
        single_post_title('', true);
    } else {
        bloginfo('name');
        echo " - ";
        bloginfo('description');
    };
}

/**
 * Enqueue BLOCK EDITOR scripts and styles.
 */
function vdclassic_enqueue_block_assets()
{
    // ========== ENQUEUE EDITOR ASSETS ==========
    if (is_admin()) {
        wp_enqueue_style(
            'vdclassic-editor-css',
            get_stylesheet_directory_uri() . '/build/vdclassic.css',
            array(),
            env('ASSETS_VERSION')
        );
        wp_enqueue_style(
            'vdclassic-editor-index-css',
            get_stylesheet_directory_uri() . '/build/style-vdclassic.css',
            array(),
            env('ASSETS_VERSION')
        );
        // $editor_asset = require(get_stylesheet_directory() . '/build/editor.asset.php');
        // wp_enqueue_script(
        //     'vdclassic-editor-js',
        //     get_stylesheet_directory_uri() . '/build/editor.js',
        //     $editor_asset['dependencies'],
        //     env('ASSETS_VERSION'),
        //     true
        // );
    }

    if (is_page_template('template-career.php') || get_post_type() == 'vd_job') {
        wp_enqueue_style(
            'vdclassic-vdjobs-css',
            get_stylesheet_directory_uri() . '/build/style-vdjobs.css',
            array(),
            env('ASSETS_VERSION')
        );
    }
}
add_action('enqueue_block_assets', 'vdclassic_enqueue_block_assets');

/**
 * Enqueue FRONTEND scripts and styles (not loaded inside block editor).
 */
function vdclassic_enqueue_assets()
{
    // Dequeue Gravity Forms Script
    // wp_deregister_style('gforms_css');
    // wp_deregister_style('gforms_reset_css');
    // wp_deregister_style('gform_basic');
    // wp_deregister_style('gforms_datepicker_css');
    // wp_deregister_style('gforms_formsmain_css');
    // wp_deregister_style('gforms_ready_class_css');
    // wp_deregister_style('gforms_browsers_css');
    // wp_deregister_style('gform_theme_components');
    // wp_deregister_style('gform_theme_ie11');
    // wp_deregister_style('gform_theme');

    // Remove unnessacary assets on frontend
    if (!is_user_logged_in()) {
        // Remove JQuery on frontend, actually breaks Borlabs Cookie!!
        // wp_deregister_script('jquery');
        wp_deregister_style('dashicons');
    }

    $vdclassic_asset = require(get_stylesheet_directory() . '/build/vdclassic.asset.php');
    wp_register_script(
        'vdclassic-main',
        get_stylesheet_directory_uri() . '/build/vdclassic.js',
        $vdclassic_asset['dependencies'],
        env('ASSETS_VERSION'),
        array('strategy' => 'defer')
    );

    wp_enqueue_script(
        'vdclassic-jobs',
        get_stylesheet_directory_uri() . '/build/vdjobs.js',
        $vdclassic_asset['dependencies'],
        env('ASSETS_VERSION'),
        array('strategy' => 'defer')
    );
    wp_enqueue_script('vdclassic-main');
    wp_enqueue_style('vdclassic-style', get_stylesheet_directory_uri() . '/build/vdclassic.css', array(), env('ASSETS_VERSION'));
    wp_enqueue_style('vdclassic-style-index', get_stylesheet_directory_uri() . '/build/style-vdclassic.css', array(), env('ASSETS_VERSION'));
}
add_action('wp_enqueue_scripts', 'vdclassic_enqueue_assets');

/**
 * Equeue gravityforms custom assets
 */
function vdclassic_enqueue_gf_assets()
{
    wp_deregister_style('gforms_css');
    wp_deregister_style('gforms_reset_css');
    // wp_deregister_style('gform_basic');
    wp_deregister_style('gforms_datepicker_css');
    // wp_deregister_style('gforms_formsmain_css');
    wp_deregister_style('gforms_ready_class_css');
    wp_deregister_style('gforms_browsers_css');
    wp_deregister_style('gform_theme_components');
    wp_deregister_style('gform_theme_ie11');
    wp_deregister_style('gform_theme');

    wp_enqueue_style(
        'gravity_extend',
        get_stylesheet_directory_uri() . '/build/gforms_extend.css',
        array('gravity_forms_orbital_theme'),
        ASSETS_VERSION
    );
}
add_action('gform_enqueue_scripts', 'vdclassic_enqueue_gf_assets', 100);

/**
 * Remove Print Styles
 */
function vdclassic_print_assets()
{
    wp_dequeue_style('gforms_css');
    wp_dequeue_style('gforms_reset_css');
    wp_dequeue_style('gform_basic');
    wp_dequeue_style('gforms_datepicker_css');
    wp_dequeue_style('gforms_formsmain_css');
    wp_dequeue_style('gforms_ready_class_css');
    wp_dequeue_style('gforms_browsers_css');
    wp_dequeue_style('gform_theme_components');
    wp_dequeue_style('gform_theme_ie11');
    wp_dequeue_style('gform_theme');
}
add_action('wp_print_styles', 'vdclassic_print_assets');

add_filter( 'rest_endpoints', function( $endpoints ){
    if ( isset( $endpoints['/wp/v2/users'] ) ) {
        unset( $endpoints['/wp/v2/users'] );
    }    return $endpoints;
});

function vdclassic_author_page_redirect() {
    global $wp_query;
    if ( is_author() ) {
        $wp_query->set_404();
        status_header(404);
    }
}
add_action( 'template_redirect', 'vdclassic_author_page_redirect' );
