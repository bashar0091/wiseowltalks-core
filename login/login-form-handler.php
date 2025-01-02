<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;


/**
 * Shortcodes For Membership Login Form 
 */
add_action('wp_ajax_memebership_handler', 'memebership_handler');
add_action('wp_ajax_nopriv_memebership_handler', 'memebership_handler');

function memebership_handler()
{
    echo 'hello';
    wp_die();
}
