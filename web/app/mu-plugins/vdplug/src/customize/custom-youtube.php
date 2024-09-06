<?php
/**
 * Add custom youtube parameter
 * @param string $cached_html cached html
 */
function vdplug_youtube_oembed($cached_html)
{
    if (strstr($cached_html, 'youtube.com')) {
        // Add credentialless
        $cached_html = str_replace('></iframe>', ' credentialless></iframe>', $cached_html);
        // Add player parameters: https://developers.google.com/youtube/player_parameters
        $cached_html = preg_replace_callback("/src=\"(.*?)\"/i", fn($m) => 'src="' . $m[1] . '&enablejsapi=1&rel=0&showinfo=0"', $cached_html);
    }

    return $cached_html;
}
add_filter('embed_oembed_html', 'vdplug_youtube_oembed');
