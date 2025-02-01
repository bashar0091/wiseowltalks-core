<?php

if (file_exists(dirname(__FILE__) . '/cmb2/init.php')) {
	require_once dirname(__FILE__) . '/cmb2/init.php';
} elseif (file_exists(dirname(__FILE__) . '/CMB2/init.php')) {
	require_once dirname(__FILE__) . '/CMB2/init.php';
}

/**
 * Currecny Option
 */
add_action('cmb2_admin_init', 'wiser_currency_setting_option');
function wiser_currency_setting_option()
{
	$cmb_options = new_cmb2_box(array(
		'id' => 'wise_currency_options_page',
		'title' => '<h3>Add Currency</h3>',
		'object_types' => array('options-page'),
		'option_key' => 'currency-switch',
		'menu_title' => 'Currency',
		'parent_slug' => 'options-general.php',
	));
	$currency_repeater = $cmb_options->add_field(array(
		'id'          => 'wise_currency_items',
		'type'        => 'group',
		'options'     => array(
			'group_title'    => esc_html__('Currecy {#}', 'cmb2'),
			'add_button'     => esc_html__('Add', 'cmb2'),
			'remove_button'  => esc_html__('Delete', 'cmb2'),
			'sortable'       => true,
			'closed'      	 => true,
		),
	));
	$cmb_options->add_group_field($currency_repeater, array(
		'name'       => esc_html__('Country Name', 'cmb2'),
		'id'         => 'country_name',
		'type'       => 'text',
	));
	$cmb_options->add_group_field($currency_repeater, array(
		'name'       => esc_html__('Country Slug', 'cmb2'),
		'id'         => 'country_slug',
		'type'       => 'text',
	));
	$cmb_options->add_group_field($currency_repeater, array(
		'name'       => esc_html__('Country Code', 'cmb2'),
		'id'         => 'country_code',
		'type'       => 'text',
	));
	$cmb_options->add_group_field($currency_repeater, array(
		'name'       => esc_html__('Currency Symbol', 'cmb2'),
		'id'         => 'currency_symbol',
		'type'       => 'text',
	));
	$cmb_options->add_group_field($currency_repeater, array(
		'name'       => esc_html__('Country Flag', 'cmb2'),
		'id'         => 'country_flag',
		'type'       => 'file',
	));
}
