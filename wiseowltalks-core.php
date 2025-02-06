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
require_once plugin_dir_path(__FILE__) . 'shortcodes/dynamic-gridv1.php';
require_once plugin_dir_path(__FILE__) . 'shortcodes/episode-search.php';

/**
 * Membership required File
 */
require_once plugin_dir_path(__FILE__) . 'login/login-form.php';
require_once plugin_dir_path(__FILE__) . 'login/login-form-handler.php';


/**
 * youtube-video required File
 */
require_once plugin_dir_path(__FILE__) . 'youtube-video/dropdown-filter-shortcode.php';
require_once plugin_dir_path(__FILE__) . 'youtube-video/search-filter-shortcode.php';
require_once plugin_dir_path(__FILE__) . 'youtube-video/youtube-video-shortcode.php';
require_once plugin_dir_path(__FILE__) . 'youtube-video/ajax.php';

/**
 * currency required File
 */
require_once plugin_dir_path(__FILE__) . 'currency/product-currency.php';
require_once plugin_dir_path(__FILE__) . 'currency/currency-shortocde.php';
require_once plugin_dir_path(__FILE__) . 'currency/ajax.php';
require_once plugin_dir_path(__FILE__) . 'includes/meta-box.php';


/**
 * CSS and JS added
 */
function wiseowltalkscore_enqueue_scripts()
{
    // CSS file 
    wp_enqueue_style('customize-style', plugin_dir_url(__FILE__) . 'assets/css/style.css', false, time(), '');

    // JS file 
    wp_enqueue_script('customize-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), time(), true);

    // dynamic data to js 
    wp_localize_script('customize-script', 'dataAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'wiseowltalkscore_enqueue_scripts');


/**
 * rss feed title get
 */
function rss_feed_title($rssfeed_url = '', $render = 'title')
{
    $xml_content = !empty($rssfeed_url) ? file_get_contents($rssfeed_url) : '';
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


/**
 * add verified column in user table
 */
function add_user_status_column($columns)
{
    $columns['user_status'] = __('Status', 'wiseowltalks-core');
    return $columns;
}
add_filter('manage_users_columns', 'add_user_status_column');
function show_user_status_column_content($value, $column_name, $user_id)
{
    if ('user_status' === $column_name) {
        // Get the user status from user meta
        $user_status = get_user_meta($user_id, 'user_status', true);

        // Set default status if not found
        if (!$user_status) {
            $user_status = 'not_verified';
        }

        // Conditional logic for coloring
        if ($user_status === 'verified') {
            return '<span style="color: green; font-weight: bold;">Verified</span>';
        } else {
            return '<span style="color: red; font-weight: bold;">Not Verified</span>';
        }
    }
    return $value;
}
add_filter('manage_users_custom_column', 'show_user_status_column_content', 10, 3);


/**
 * redirect_logged_in_users_to_dashboard
 */
function redirect_logged_in_users_to_dashboard()
{
    // Check if the user is logged in and is on the "Become a Member" page
    if (is_user_logged_in() && is_page('become-a-member')) {
        // Redirect to the dashboard page
        wp_redirect(home_url('/dashboard'));
        exit;
    }
}

// Hook into 'template_redirect' action to perform the redirect
add_action('template_redirect', 'redirect_logged_in_users_to_dashboard');


/**
 * redirect_logged_out_users_to_login
 */
function redirect_logged_out_users_to_login()
{
    // Check if the user is logged in and is on the "Become a Member" page
    if (!is_user_logged_in() && is_page('dashboard')) {
        // Redirect to the dashboard page
        wp_redirect(home_url('/become-a-member/?login=true'));
        exit;
    }
}

// Hook into 'template_redirect' action to perform the redirect
add_action('template_redirect', 'redirect_logged_out_users_to_login');
