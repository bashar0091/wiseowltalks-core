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
// Start session if not already started
if (!session_id()) {
    session_start();
}

// Ensure session is available during AJAX requests
add_action('init', 'wise_start_session', 1);
function wise_start_session() {
    if (!session_id()) {
        session_start();
    }
}

// Change the product price based on the custom currency
add_filter('woocommerce_product_get_price', 'wise_price_change', 10, 2);
add_filter('woocommerce_product_variation_get_price', 'wise_price_change', 10, 2);
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

// Change the currency symbol based on the custom currency
add_filter('woocommerce_currency_symbol', 'wise_change_currency_symbol', 10, 2);
function wise_change_currency_symbol($currency_symbol, $currency)
{
    $currency_switch = $_SESSION['currency_switch'] ?? '';
    if (!is_admin() && !empty($currency_switch)) {
        $symbol = $_SESSION['symbol'] ?? '';

        if (!empty($symbol)) {
            return $symbol;
        }
    }
    return $currency_symbol;
}

// Change the currency code based on the custom currency
add_filter('woocommerce_currency', 'wise_change_currency_code');
function wise_change_currency_code($currency)
{
    $currency_switch = $_SESSION['currency_switch'] ?? '';
    if (!is_admin() && !empty($currency_switch)) {
        $countrycode = $_SESSION['countrycode'] ?? '';

        if (!empty($countrycode)) {
            return $countrycode;
        }
    }
    return $currency;
}

// Ensure the custom price is used during checkout and AJAX calls
add_filter('woocommerce_cart_item_price', 'wise_cart_item_price', 10, 3);
function wise_cart_item_price($price, $cart_item, $cart_item_key)
{
    $product = $cart_item['data'];
    $currency_switch = $_SESSION['currency_switch'] ?? '';
    $slug = $_SESSION['slug'] ?? '';

    if (!is_admin() && !empty($currency_switch)) {
        $currency_price = get_post_meta($product->get_id(), '_price_' . $slug, true);
        if (!empty($currency_price)) {
            return wc_price($currency_price);
        }
    }
    return $price;
}

// Ensure the custom price is used during checkout for subtotal
add_filter('woocommerce_cart_subtotal', 'wise_cart_subtotal', 10, 3);
function wise_cart_subtotal($subtotal, $compound, $cart)
{
    $currency_switch = $_SESSION['currency_switch'] ?? '';
    $slug = $_SESSION['slug'] ?? '';

    if (!is_admin() && !empty($currency_switch)) {
        $total = 0;
        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            $product = $cart_item['data'];
            $currency_price = get_post_meta($product->get_id(), '_price_' . $slug, true);
            if (!empty($currency_price)) {
                $total += $currency_price * $cart_item['quantity'];
            } else {
                $total += $product->get_price() * $cart_item['quantity'];
            }
        }
        return wc_price($total);
    }
    return $subtotal;
}

// Ensure custom prices are used during AJAX calls on the checkout page
add_filter('woocommerce_cart_get_total', 'wise_cart_get_total', 10, 1);
function wise_cart_get_total($total)
{
    $currency_switch = $_SESSION['currency_switch'] ?? '';
    $slug = $_SESSION['slug'] ?? '';

    if (!is_admin() && !empty($currency_switch)) {
        $cart = WC()->cart;
        $total = 0;
        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            $product = $cart_item['data'];
            $currency_price = get_post_meta($product->get_id(), '_price_' . $slug, true);
            if (!empty($currency_price)) {
                $total += $currency_price * $cart_item['quantity'];
            } else {
                $total += $product->get_price() * $cart_item['quantity'];
            }
        }
        return $total;
    }
    return $total;
}

// Ensure custom prices are used for order totals
add_filter('woocommerce_cart_totals_order_total_html', 'wise_cart_totals_order_total_html', 10, 1);
function wise_cart_totals_order_total_html($total_html)
{
    $currency_switch = $_SESSION['currency_switch'] ?? '';
    $slug = $_SESSION['slug'] ?? '';

    if (!is_admin() && !empty($currency_switch)) {
        $cart = WC()->cart;
        $total = 0;
        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            $product = $cart_item['data'];
            $currency_price = get_post_meta($product->get_id(), '_price_' . $slug, true);
            if (!empty($currency_price)) {
                $total += $currency_price * $cart_item['quantity'];
            } else {
                $total += $product->get_price() * $cart_item['quantity'];
            }
        }
        return wc_price($total);
    }
    return $total_html;
}