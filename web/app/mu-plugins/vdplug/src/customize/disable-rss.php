<?php

function vdplug_disable_feed()
{
    wp_die(__('No feed available, please visit the <a href="'. esc_url(home_url('/')) .'">homepage</a>!'));
}

add_action('do_feed', 'vdplug_disable_feed', 1);
add_action('do_feed_rdf', 'vdplug_disable_feed', 1);
add_action('do_feed_rss', 'vdplug_disable_feed', 1);
add_action('do_feed_rss2', 'vdplug_disable_feed', 1);
add_action('do_feed_atom', 'vdplug_disable_feed', 1);
add_action('do_feed_rss2_comments', 'vdplug_disable_feed', 1);
add_action('do_feed_atom_comments', 'vdplug_disable_feed', 1);
