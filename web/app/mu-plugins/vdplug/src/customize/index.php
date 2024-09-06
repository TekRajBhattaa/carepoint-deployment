<?php
/**
 * === Custom Settings ===
 */
require_once VDPLUG_DIR . 'src/customize/custom-login.php';
require_once VDPLUG_DIR . 'src/customize/custom-admin-menu.php';
require_once VDPLUG_DIR . 'src/customize/custom-youtube.php';
// require_once VDPLUG_DIR . 'src/customize/custom-smtp-settings.php';

/**
 * === Disable features ===
 */
require_once VDPLUG_DIR . 'src/customize/disable-xml-rpc.php';
require_once VDPLUG_DIR . 'src/customize/disable-remote-requests.php';
require_once VDPLUG_DIR . 'src/customize/disable-customizer.php';
require_once VDPLUG_DIR . 'src/customize/disable-comments.php';
require_once VDPLUG_DIR . 'src/customize/disable-rss.php';
require_once VDPLUG_DIR . 'src/customize/disable-emoji.php';
require_once VDPLUG_DIR . 'src/customize/disable-gravatar.php';
// require_once VDPLUG_DIR . 'src/customize/disable-category.php';
// require_once VDPLUG_DIR . 'src/customize/disable-rest-endpoints.php';

/**
 * === Enable features ===
 */
require_once VDPLUG_DIR . 'src/customize/enable-column-thumbnail.php';
require_once VDPLUG_DIR . 'src/customize/enable-remove-wp-version.php';
require_once VDPLUG_DIR . 'src/customize/enable-equalBlockApiVersion.php';
require_once VDPLUG_DIR . 'src/customize/enable-manifest-json.php';
require_once VDPLUG_DIR . 'src/customize/enable-docusign.php';
