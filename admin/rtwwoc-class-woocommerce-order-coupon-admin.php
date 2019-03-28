<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://redefiningtheweb.com
 * @since      1.0.0
 *
 * @package    Rtwwoc_WooCommerce_Order_Coupon
 * @subpackage Rtwwoc_WooCommerce_Order_Coupon/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rtwwoc_WooCommerce_Order_Coupon
 * @subpackage Rtwwoc_WooCommerce_Order_Coupon/admin
 * @author     RedefiningTheWeb <developer@redefiningtheweb.com>
 */
class Rtwwoc_WooCommerce_Order_Coupon_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $rtwwoc_plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $rtwwoc_version;

	public $rtwwoc_aplly_coupon_request = NULL;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $rtwwoc_plugin_name, $rtwwoc_version ) {

		$this->rtwwoc_plugin_name = $rtwwoc_plugin_name;
		$this->rtwwoc_version = $rtwwoc_version;

	}

	/**
	 * Add setting tab in woocommerce settings section. 
	 *
	 * @since    1.0.0
	 */
	public function rtwwoc_wc_settings_tabs_array($rtwwoc_settings_tabs){

		$rtwwoc_settings_tabs['rtwwoc'] = __( 'WooCommerce Order Coupon', 'rtwwoc-woocommerce-order-coupon' );
		return $rtwwoc_settings_tabs;

	}

	/**
	 * setting tab content callback plugin admin settings. 
	 *
	 * @since    1.0.0
	 */
	public function rtwwoc_settings_tabs_callback(){

		woocommerce_admin_fields( $this->rtwwoc_get_settings() );
	}

	/**
	 * Setting creation of plugin. 
	 *
	 * @since    1.0.0
	 */
	public function rtwwoc_get_settings(){
		$settings = array(
			'section_title' => array(
				'name'     => __( 'WooCommerce Order Coupon Settings', 'rtwwoc-woocommerce-order-coupon' ),
				'type'     => 'title',
				'desc'     => '',
				'id'       => 'rtwwocp_wc_settings_tab_section_title'
			),

			array(
				'name' 		=> __( 'Enable', 'rtwwoc-woocommerce-order-coupon' ),
				'type' 		=> 'checkbox',
				'desc' 		=> __( 'Enable to activate plugin.', 'rtwwoc-woocommerce-order-coupon' ),
				'id'   		=> 'rtwwocp_enable',
				'default'	=> 'no'
			),

			array(
				'title'    => __( 'Select the orderstatus in which Coupon will apply on order', 'rtwwoc-woocommerce-order-coupon' ),
				'desc'     => __( 'Select Order status on which you want to allow customer to apply coupon on order.', 'rtwwoc-woocommerce-order-coupon' ),
				'class'    => 'wc-enhanced-select ',
				'css'      => 'min-width:300px;',
				'default'  => '',
				'type'     => 'multiselect',
				'options'  => wc_get_order_statuses(),
				'desc_tip' =>  true,
				'id' 		=> 'rtwwocp_selected_order_status'
			),

			array(
				'name' 		=> __( 'Maximum Allowed Days', 'rtwwoc-woocommerce-order-coupon' ),
				'type' 		=> 'number',
				'desc' 		=> __( 'Enter maximum allowed days that needed to apply coupon', 'rtwwoc-woocommerce-order-coupon' ),
				'id'   		=> 'rtwwocp_max_order_days',
				'default'	=> '0'
			),

			array(
				'name' 		=> __( 'Minimum Order Amount', 'rtwwoc-woocommerce-order-coupon' ),
				'type' 		=> 'number',
				'desc' 		=> __( 'Enter minimum order amount that needed to apply coupon', 'rtwwoc-woocommerce-order-coupon' ),
				'id'   		=> 'rtwwocp_min_order_amount',
				'default'	=> '0'
			),

			array(
				'name' 		=> __( 'Maximum Coupons Count', 'rtwwoc-woocommerce-order-coupon' ),
				'type' 		=> 'number',
				'desc' 		=> __( 'Enter maximum allowed count of coupon that will apply', 'rtwwoc-woocommerce-order-coupon' ),
				'id'   		=> 'rtwwocp_max_coupon_count',
				'default'	=> '0'
			),
			array(
				'id'          => 'rtwwocp_allowed_users',
				'option_key'  => 'rtwwocp_allowed_users',
				'name'       => esc_html__( 'Allowed Users', 'rtwwoc-woocommerce-order-coupon' ),
				'description' => esc_html__( 'Select users type that will allow to apply coupon.', 'rtwwoc-woocommerce-order-coupon' ),
				'default'     => '',
				'type'        => 'select',
				'options'     => array(
					'login'   => esc_html__( 'Login Users', 'rtwwoc-woocommerce-order-coupon' ),
					'guest'  => esc_html__( 'Guest Users', 'rtwwoc-woocommerce-order-coupon' ),
					'both'  => esc_html__( 'Both Login & Guest Users', 'rtwwoc-woocommerce-order-coupon' ),
				),
				'desc_tip' =>  true,
			),

			'section_end' => array(
				'type' => 'sectionend',
				'id' => 'wc_settings_tab_demo_section_end'
			)
		);

		return apply_filters( 'rtwwoc_settings_tab_array', $settings );
	}

	/**
	 * Saving plugin setting tab settings in option table. 
	 *
	 * @since    1.0.0
	 */
	public function rtwwoc_save_settings_callback(){

		woocommerce_update_options( $this->rtwwoc_get_settings() );
	}

}
