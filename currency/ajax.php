<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;

/**
 * currency_switch_handler
 */
add_action('wp_ajax_currency_switch_handler', 'currency_switch_handler');
add_action('wp_ajax_nopriv_currency_switch_handler', 'currency_switch_handler');
function currency_switch_handler()
{
    session_start();
    $flag = isset($_POST['flag']) ? $_POST['flag'] : '';
    $slug = isset($_POST['slug']) ? $_POST['slug'] : '';
    $symbol = isset($_POST['symbol']) ? $_POST['symbol'] : '';
    $countrycode = isset($_POST['countrycode']) ? $_POST['countrycode'] : '';
    $_SESSION['currency_switch'] = true;
    $_SESSION['flag'] = $flag;
    $_SESSION['slug'] = $slug;
    $_SESSION['countrycode'] = $countrycode;
    $_SESSION['symbol'] = $symbol;
    wp_send_json_success(['success' => true]);
    wp_die();
}

/**
 * currency_switch_handler
 */
add_filter('woocommerce_product_get_price', 'wise_price_change', 10, 2);
function wise_price_change($price, $product)
{
    if (!is_admin() && isset($_SESSION)) {
        $currency_switch = $_SESSION['currency_switch'] ?? '';
        $slug = $_SESSION['slug'] ?? '';

        if (!empty($currency_switch)) {
            $currency_price = get_post_meta($product->get_id(), '_price_' . $slug, true);
            if (!empty($currency_price)) {
                return $currency_price;
            }
        }
    }
    return $price;
}
add_filter('woocommerce_currency_symbol', 'wise_change_currency_symbol', 10, 2);
function wise_change_currency_symbol($currency_symbol, $currency)
{
    if (!is_admin() && isset($_SESSION)) {
        $currency_switch = $_SESSION['currency_switch'] ?? '';
        $symbol = $_SESSION['symbol'] ?? '';

        if (!empty($currency_switch)) {
            return $symbol;
        }
    }
}
add_filter('woocommerce_currency', 'wise_change_currency_code');
function wise_change_currency_code($currency)
{
    if (!is_admin() && isset($_SESSION)) {
        $currency_switch = $_SESSION['currency_switch'] ?? '';
        $countrycode = $_SESSION['countrycode'] ?? '';

        if (!empty($currency_switch)) {
            return $countrycode;
        }
    }
}
