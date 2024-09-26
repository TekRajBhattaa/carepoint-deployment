<?php

/**
 * Generate a manifest json
 * https://w3c.github.io/manifest/
 */
function vdplug_manifest_json($wp)
{
    // Check if the request is a manifest
    if (!in_array($_SERVER['REQUEST_URI'], ['/manifest.webmanifest', '/browserconfig.xml'])) {
        return;
    }

    $themeColor = "#336699";
    $logoUrl = get_bloginfo('template_url') . '/static/touchicons';

    if ($_SERVER['REQUEST_URI'] === '/manifest.webmanifest') {
        // Array version of the JSON data.
        $data = [
            "name" => get_bloginfo('name'),
            "short_name" => get_bloginfo('name'),
            "description" => get_bloginfo('description'),
            "scope" => "/",
            "start_url" => get_bloginfo('url'),
            "categories" => [
                // https://github.com/w3c/manifest/wiki/Categories
                "magazines",
                "business"
            ],
            "icons" => [
                [
                    "src" => "$logoUrl/android-chrome-192x192.png",
                    "sizes"=> "192x192",
                    "type" => "image/png",
                    "purpose"=> "any maskable"
                ],
                [
                    "src" => "$logoUrl/android-chrome-512x512.png",
                    "sizes" => "512x512",
                    "type" => "image/png",
                    "purpose"=> "any"
                ]
            ],
            "theme_color" => $themeColor,
            "background_color" => "#ffffff",
            "display" => "minimal-ui",
            "orientation" => "portrait",
        ];

        // Send headers.
        status_header(200);
        nocache_headers();
        header('Content-Type: application/manifest+json');

        // And serve the JSON data.
        echo wp_json_encode($data);
        exit;
    } elseif ($_SERVER['REQUEST_URI'] === '/browserconfig.xml') {
        $data = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <browserconfig>
            <msapplication>
                <tile>
                    <square150x150logo src="$logoUrl/mstile-150x150.png"/>
                    <TileColor>$themeColor</TileColor>
                </tile>
            </msapplication>
        </browserconfig>
        XML;

        // Send headers.
        status_header(200);
        nocache_headers();
        header('Content-Type: application/xml');

        // And serve the JSON data.
        echo $data;
        exit;
    }
}
add_action('parse_request', 'vdplug_manifest_json', 0);


function vdplug_manifest_link()
{
    $logoUrl = get_bloginfo('template_url') . '/static/touchicons';
    $assetVer = ASSETS_VERSION;

    echo <<<HTML
    <link rel="manifest" href="/manifest.webmanifest"  crossorigin="use-credentials">
    <link rel="apple-touch-icon" sizes="180x180" href="$logoUrl/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="$logoUrl/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="$logoUrl/favicon-32x32.ico">
    <link rel="mask-icon" href="$logoUrl/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#336699">
    <script>if ('serviceWorker' in navigator) navigator.serviceWorker.register('/service-worker.js?$assetVer')</script>
    HTML;
}
add_action('wp_head', 'vdplug_manifest_link');
