<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;


/**
 * Admin Menu Item Hook
 */
add_action('admin_menu', 'register_wise_owl_menu');

function register_wise_owl_menu()
{
    /**
     * Parent Menu Item
     */
    add_menu_page(
        'Wise Owl',
        'Wise Owl',
        'manage_options',
        'wise_owl',
        '__return_null', // No callback for parent menu
        'dashicons-microphone',
        20
    );

    /**
     * Child Menu Items
     */
    add_submenu_page(
        'wise_owl',
        'Members',
        'Members',
        'manage_options',
        'wise_owl_members',
        'wise_owl_members_page'
    );

    add_submenu_page(
        'wise_owl',
        'Promo Codes',
        'Promo Codes',
        'manage_options',
        'wise_owl_promo_codes',
        'wise_owl_promo_codes_page'
    );

    add_submenu_page(
        'wise_owl',
        'Settings',
        'Settings',
        'manage_options',
        'wise_owl_settings',
        'wise_owl_settings_page'
    );
}

add_action('admin_menu', 'hide_wise_owl_parent_in_submenu', 999);
function hide_wise_owl_parent_in_submenu()
{
    // Remove the parent menu item from the submenu list
    remove_submenu_page('wise_owl', 'wise_owl');
}

// Callback functions for child menu pages
function wise_owl_members_page()
{
    echo '<h1>Wise Owl - Members</h1>';
    echo '<p>Content for Members page.</p>';
}

function wise_owl_promo_codes_page()
{
    echo '<h1>Wise Owl - Promo Codes</h1>';
    echo '<p>Content for Promo Codes page.</p>';
}

function wise_owl_settings_page()
{
    echo '<h1>Wise Owl - Settings</h1>';
    echo '<p>Content for Settings page.</p>';
}
