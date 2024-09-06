<?php

/**
 * Inject CSS on Login page
 */
function vdplug_login_logo()
{
    ?>
    <style type="text/css">
        body.login {
            color: #fff;
            background: #092231 url('<?php echo get_stylesheet_directory_uri(); ?>/static/wp_login-jpg.webp');
            background-size: cover;
        }
        .login .message,
        .login .notice,
        .login .success {
            color: #092231;
            border-radius: 5px;
        }
        #login h1 a, .login h1 a {
            background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/logo.png');
            width: 318px;
            height: 175px;
            background-size: 100% auto;
            background-repeat: no-repeat;
            margin: 0 auto 10px;
        }
        .login form {
            margin-top: 0 !important;
            border: 2px solid #094462 !important;
            border-radius: 4px;
            background-color: #003952 !important;
        }
        
        .login #wfls-prompt-overlay {
            background: #0f3952;
        }
        
    </style>
<?php }
add_action('login_enqueue_scripts', 'vdplug_login_logo');

/**
 * Click on Logo point to website
 */
function vdplug_login_logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'vdplug_login_logo_url');

/**
 * Change Login Text (hidden)
 */
function vdplug_login_logo_url_title()
{
    return 'Your Site Name and Info';
}
add_filter('login_headertext', 'vdplug_login_logo_url_title');
