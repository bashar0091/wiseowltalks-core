<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;


/**
 * Product Currecny Show
 */
function wise_product_currency_field()
{
    $currency_switch = get_option('currency-switch');
    $wise_currency_items = $currency_switch['wise_currency_items'];
    if (!empty($wise_currency_items)) {
        foreach ($wise_currency_items as $key => $item) {
            $country_name = $item['country_name'];
            $currency_symbol = $item['currency_symbol'];
            $country_slug = $item['country_slug'];
            woocommerce_wp_text_input(array(
                'id' => '_price_' . $country_slug,
                'label' => __($country_name . ' Price' . ' (' . $currency_symbol . ')', 'woocommerce'),
                'placeholder' => __($country_name . ' Price' . ' (' . $currency_symbol . ')', 'woocommerce'),
                'type' => 'number',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0'
                )
            ));
        }
    }
}
add_action('woocommerce_product_options_general_product_data', 'wise_product_currency_field');
function wise_product_currency_field_save($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $currency_switch = get_option('currency-switch');
    $wise_currency_items = $currency_switch['wise_currency_items'];
    if (!empty($wise_currency_items)) {
        foreach ($wise_currency_items as $key => $item) {
            $country_slug = $item['country_slug'];
            $key = '_price_' . $country_slug;
            $field_price = isset($_POST[$key]) ? sanitize_text_field($_POST[$key]) : '';
            update_post_meta($post_id, $key, $field_price);
        }
    }
}
add_action('woocommerce_process_product_meta', 'wise_product_currency_field_save');
