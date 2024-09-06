<?php
defined('ABSPATH') || exit;

require_once(VDPLUG_DIR . 'src/rest/multiple-cpt-rest.php');

function vdplug_rest_multiple_post_type_endpoint()
{
    $controller = new WP_REST_MultiplePostType_Controller();
    $controller->register_routes();
}
add_action('rest_api_init', 'vdplug_rest_multiple_post_type_endpoint');
