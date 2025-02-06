<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;


/**
 * Shortcodes for Youtube Video Post Type
 */
function youtube_video_shortcode()
{
    ob_start();
?>
    
    <?php
    return ob_get_clean();
}
add_shortcode('youtube_video', 'youtube_video_shortcode');
