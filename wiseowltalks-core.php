<?php

/**
 * Plugin Name: Wiseowltalks Core
 * Description: 
 * Version:     1.0.0
 * Author:      Atiqul Islam
 * Author URI:  
 * Text Domain: wiseowltalks-core
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;


/**
 * Admin Required PHP File
 */
require_once plugin_dir_path(__FILE__) . 'admin/menu/menu.php';

/**
 * Frontend Required PHP File
 */
require_once plugin_dir_path(__FILE__) . 'shortcodes/episodes-playlist.php';
require_once plugin_dir_path(__FILE__) . 'shortcodes/episodes-playlist-single.php';


/**
 * CSS and JS added
 */
function wiseowltalkscore_enqueue_scripts()
{
    // CSS file 
    wp_enqueue_style('customize-style', plugin_dir_url(__FILE__) . 'assets/css/style.css', false, '1.0.0', '');

    // JS file 
    wp_enqueue_script('customize-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'wiseowltalkscore_enqueue_scripts');


/**
 * rss feed title get
 */
function rss_feed_title($rssfeed_url = '', $render = 'title')
{
    $xml_content = file_get_contents($rssfeed_url);
    if ($xml_content !== false) {
        $xml = simplexml_load_string($xml_content, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($xml) {
            $namespaces = $xml->getNamespaces(true);

            $xml->registerXPathNamespace('default', $namespaces['']);

            if ($render == 'title') {
                $title = $xml->xpath('//default:title');
                if (!empty($title)) {
                    return (string)$title[0];
                }
            } else if ($render == 'channel') {
                $author_name = $xml->xpath('//default:author/default:name');
                if (!empty($author_name)) {
                    return (string)$author_name[0];
                }
            } else if ($render == 'channel_url') {
                $author_uri = $xml->xpath('//default:author/default:uri');
                if (!empty($author_uri)) {
                    return (string)$author_uri[0];
                }
            }
        }
    }
    return null;
}
