<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;


/**
 * Shortcode for currency dropdown
 */
function currency_dropdown_shortcode()
{
    ob_start();
    session_start();
    $currency_switch = get_option('currency-switch');
    $wise_currency_items = $currency_switch['wise_currency_items'];
    $usd_icon = plugin_dir_url(__FILE__) . '../assets/images/US.png';
    $show_icon = $usd_icon;
    $show_name = 'USD';
    $currency_switch = isset($_SESSION['currency_switch']) ? $_SESSION['currency_switch'] : '';
    $flag = isset($_SESSION['flag']) ? $_SESSION['flag'] : '';
    $countrycode = isset($_SESSION['countrycode']) ? $_SESSION['countrycode'] : '';
    if ($currency_switch) {
        $show_icon = $flag;
        $show_name = $countrycode;
    }
?>
    <div>
        <label class="parent_flag_dropdown">
            <div class="wise_flex">
                <span>
                    <?php if (!empty($show_icon)): ?>
                        <img class="flag_icon" src="<?php echo esc_url($show_icon); ?>">
                    <?php endif; ?>
                </span>
                <span><?php echo wp_kses_post($show_name); ?></span>
            </div>

            <?php if (!empty($wise_currency_items)): ?>
                <div class="wise_dropdown">
                    <label class="currency_switch_click wise_flex" data-flag="<?php echo esc_url($usd_icon); ?>" data-slug="usa" data-countrycode="USD" data-symbol="$">
                        <span>
                            <img class="flag_icon" src="<?php echo esc_url($usd_icon); ?>">
                        </span>
                        <span>
                            USD ($)
                        </span>
                    </label>
                    <?php
                    foreach ($wise_currency_items as $key => $item):
                        $country_name = $item['country_name'];
                        $currency_symbol = $item['currency_symbol'];
                        $country_slug = $item['country_slug'];
                        $country_flag = isset($item['country_flag']) ? $item['country_flag'] : '';
                        $country_code = isset($item['country_code']) ? $item['country_code'] : '';
                    ?>
                        <label class="currency_switch_click wise_flex" data-flag="<?php echo esc_url($country_flag); ?>" data-slug="<?php echo esc_attr($country_slug); ?>" data-countrycode="<?php echo esc_attr($country_code); ?>" data-symbol="<?php echo esc_attr($currency_symbol); ?>">
                            <span>
                                <?php if (!empty($country_flag)): ?>
                                    <img class="flag_icon" src="<?php echo esc_url($country_flag); ?>">
                                <?php endif; ?>
                            </span>
                            <span>
                                <?php echo wp_kses_post($country_name . ' (' . $currency_symbol . ')'); ?>
                            </span>
                        </label>
                    <?php endforeach ?>
                </div>
            <?php endif; ?>
        </label>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('currency_dropdown', 'currency_dropdown_shortcode');
