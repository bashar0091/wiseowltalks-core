<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;


/**
 * Shortcodes for Episodes Playlist Loop item from rss feed url
 */
function episodes_playlist_shortcode()
{
    ob_start();
    return ob_get_clean();
}
add_shortcode('episodes_playlist', 'episodes_playlist_shortcode');
