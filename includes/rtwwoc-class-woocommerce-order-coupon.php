<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://redefiningtheweb.com
 * @since      1.0.0
 *
 * @package    Rtwwoc_WooCommerce_Order_Coupon
 * @subpackage Rtwwoc_WooCommerce_Order_Coupon/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Rtwwoc_WooCommerce_Order_Coupon
 * @subpackage Rtwwoc_WooCommerce_Order_Coupon/includes
 * @author     RedefiningTheWeb <developer@redefiningtheweb.com>
 */
class Rtwwoc_WooCommerce_Order_Coupon {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Rtwwoc_WooCommerce_Order_Coupon_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $rtwwoc_loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $rtwwoc_plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $rtwwoc_version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'RTWWOC_VERSION' ) ) {
			$this->rtwwoc_version = RTWWOC_VERSION;
		} else {
			$this->version = '1.0.1';
		}
		$this->rtwwoc_plugin_name = 'woocommerce-order-coupon';

		$this->rtwwoc_load_dependencies();
		$this->rtwwoc_set_locale();
		$this->rtwwoc_define_admin_hooks();
		$this->rtwwoc_define_public_hooks();

		add_filter( 'woocommerce_email_classes', array( $this, 'rtwwoc_wc_email_classes_callback' ) );
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Rtwwoc_WooCommerce_Order_Coupon_Loader. Orchestrates the hooks of the plugin.
	 * - Rtwwoc_WooCommerce_Order_Coupon_i18n. Defines internationalization functionality.
	 * - Rtwwoc_WooCommerce_Order_Coupon_Admin. Defines all hooks for the admin area.
	 * - Rtwwoc_WooCommerce_Order_Coupon_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function rtwwoc_load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/rtwwoc-class-woocommerce-order-coupon-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/rtwwoc-class-woocommerce-order-coupon-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/rtwwoc-class-woocommerce-order-coupon-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/rtwwoc-class-woocommerce-order-coupon-public.php';

		$this->rtwwoc_loader = new Rtwwoc_WooCommerce_Order_Coupon_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Rtwwoc_WooCommerce_Order_Coupon_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function rtwwoc_set_locale() {

		$rtwwoc_plugin_i18n = new Rtwwoc_WooCommerce_Order_Coupon_i18n();

		$this->rtwwoc_loader->rtwwoc_add_action( 'plugins_loaded', $rtwwoc_plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function rtwwoc_define_admin_hooks() {

		$rtwwoc_plugin_admin = new Rtwwoc_WooCommerce_Order_Coupon_Admin( $this->rtwwoc_get_plugin_name(), $this->rtwwoc_get_version() );

		$this->rtwwoc_loader->rtwwoc_add_filter( 'woocommerce_settings_tabs_array', $rtwwoc_plugin_admin, 'rtwwoc_wc_settings_tabs_array', 50 );
		$this->rtwwoc_loader->rtwwoc_add_action( 'woocommerce_settings_tabs_rtwwoc', $rtwwoc_plugin_admin, 'rtwwoc_settings_tabs_callback' );
		$this->rtwwoc_loader->rtwwoc_add_action( 'woocommerce_settings_save_rtwwoc', $rtwwoc_plugin_admin, 'rtwwoc_save_settings_callback' );
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function rtwwoc_define_public_hooks() {

		$rtwwoc_plugin_public = new Rtwwoc_WooCommerce_Order_Coupon_Public( $this->rtwwoc_get_plugin_name(), $this->rtwwoc_get_version() );

		$this->rtwwoc_loader->rtwwoc_add_action( 'wp_enqueue_scripts', $rtwwoc_plugin_public, 'enqueue_scripts' );
		$this->rtwwoc_loader->rtwwoc_add_action( 'woocommerce_order_details_after_order_table', $rtwwoc_plugin_public, 'rtwwoc_order_details_before_order_table' );
		$this->rtwwoc_loader->rtwwoc_add_action( 'wp_ajax_rtwwoc_coupon_added', $rtwwoc_plugin_public, 'rtwwoc_coupon_added_callback' );
		$this->rtwwoc_loader->rtwwoc_add_action( 'wp_ajax_nopriv_rtwwoc_coupon_added', $rtwwoc_plugin_public, 'rtwwoc_coupon_added_callback' );
	}

	public function rtwwoc_wc_email_classes_callback($rtwwoc_email_classes){
		$rtwwoc_email_classes['RTWWOC_COUPON_ADDED'] = include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/rtwwocp-class-coupon-added.php';
		return $rtwwoc_email_classes;
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function rtwwoc_run() {
		$this->rtwwoc_loader->rtwwoc_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function rtwwoc_get_plugin_name() {
		return $this->rtwwoc_plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Rtwwoc_WooCommerce_Order_Coupon_Loader    Orchestrates the hooks of the plugin.
	 */
	public function rtwwoc_get_loader() {
		return $this->rtwwoc_loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function rtwwoc_get_version() {
		return $this->rtwwoc_version;
	}

}
