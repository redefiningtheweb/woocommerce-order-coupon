<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://redefiningtheweb.com
 * @since      1.0.0
 *
 * @package    Rtwwoc_WooCommerce_Order_Coupon
 * @subpackage Rtwwoc_WooCommerce_Order_Coupon/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Rtwwoc_WooCommerce_Order_Coupon
 * @subpackage Rtwwoc_WooCommerce_Order_Coupon/includes
 * @author     RedefiningTheWeb <developer@redefiningtheweb.com>
 */
class Rtwwoc_WooCommerce_Order_Coupon_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'rtwwoc-woocommerce-order-coupon',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
