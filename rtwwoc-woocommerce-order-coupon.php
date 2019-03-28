<?php

/**
 * The plugin main file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://redefiningtheweb.com
 * @since             1.0.0
 * @package           Rtwwoc_WooCommerce_Order_Coupon
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Order Coupon
 * Plugin URI:        https://redefiningtheweb.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.1
 * Author:            RedefiningTheWeb
 * Author URI:        https://redefiningtheweb.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rtwwoc-woocommerce-order-coupon
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Make sure WooCommerce is active

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	return;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RTWWOC_VERSION', '1.0.1' );

/**
 * The function is return settings link in action links of plugin.
 * 
 * @since    1.0.0
 */
function rtwwoc_plugin_action_links_callback($actions, $plugin_file){
	$rtwwoc_plugin_file_path = plugin_basename ( __FILE__ );

	if ( in_array( 'woocommerce-order-coupon-pro/rtwwocp-woocommerce-order-coupon-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

		if ($rtwwoc_plugin_file_path == $plugin_file) {
			$settings = array (
					'settings' => '<a href="' . esc_url( admin_url ( '/admin.php?page=rtwwocp-coupons' ) ) . '">' . esc_html__( 'Settings', 'rtwwoc-woocommerce-order-coupon' ) . '</a>',
			);
			$actions = array_merge ( $settings, $actions );
		}

	}else{
		if ($rtwwoc_plugin_file_path == $plugin_file) {
			$settings = array (
					'settings' => '<a href="' . admin_url ( 'admin.php?page=wc-settings&tab=rtwwoc' ) . '">' . __ ( 'Settings', 'rtwwoc-woocommerce-order-coupon' ) . '</a>',
			);
			$actions = array_merge ( $settings, $actions );
		}
	}
	return $actions;
}

add_filter( 'plugin_action_links', 'rtwwoc_plugin_action_links_callback', 10, 5);

// Make sure WooCommerce is active

if ( in_array( 'woocommerce-order-coupon-pro/rtwwocp-woocommerce-order-coupon-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	return;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/rtwwoc-class-woocommerce-order-coupon.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function rtwwoc_run_woocommerce_order_coupon() {

	$plugin = new Rtwwoc_WooCommerce_Order_Coupon();
	$plugin->rtwwoc_run();

}
rtwwoc_run_woocommerce_order_coupon();
