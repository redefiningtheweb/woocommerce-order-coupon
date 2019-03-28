<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://redefiningtheweb.com
 * @since      1.0.0
 *
 * @package    Rtwwoc_WooCommerce_Order_Coupon
 * @subpackage Rtwwoc_WooCommerce_Order_Coupon/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rtwwoc_WooCommerce_Order_Coupon
 * @subpackage Rtwwoc_WooCommerce_Order_Coupon/public
 * @author     RedefiningTheWeb <developer@redefiningtheweb.com>
 */
class Rtwwoc_WooCommerce_Order_Coupon_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rtwwoc_WooCommerce_Order_Coupon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rtwwoc_WooCommerce_Order_Coupon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rtwwoc-woocommerce-order-coupon-public.js', array( 'jquery' ), $this->version, false );
		$rtwwoc_ajax_nonce = wp_create_nonce( "rtwwoc-ajax-seurity" );
		$params = array(
			'ajax_url'                      => admin_url( 'admin-ajax.php' ),
			'order_item_nonce'              => wp_create_nonce( 'order-item' ),
			'rtwwoc_nonce'					=> $rtwwoc_ajax_nonce
		);
		wp_localize_script( $this->plugin_name, 'rtwwoc_js_param', $params );
		wp_enqueue_script($this->plugin_name);
	}

	/**
	 * listing all apllyed coupons and apply coupon box.
	 *
	 * @since    1.0.0
	 */
	public function rtwwoc_order_details_before_order_table($order){
		$order_id = $order->get_id();
		if(get_option('rtwwocp_enable','')){
			$all_coupons = $order->get_used_coupons();
			if(is_array($all_coupons) && !empty($all_coupons)){
				?>
				<div class="rtwwoc_used_coupon_list_wrapper">
					<h2><?php _e('All applyed coupons list','rtwwoc-woocommerce-order-coupon'); ?></h2>
					<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
						<thead>
							<tr>
								<td><?php _e('Coupon Code','rtwwoc-woocommerce-order-coupon'); ?></td>
								<td><?php _e('Amount','rtwwoc-woocommerce-order-coupon'); ?></td>
							</tr>
						</thead>
						<tbody><?php
						foreach ($all_coupons as $coupon_code) { ?>
							
							<tr>
								<td><?php echo $coupon_code; ?></td>
								<td><?php 
								$coupon_post_obj = get_page_by_title($coupon_code, OBJECT, 'shop_coupon');
								$coupon_id = $coupon_post_obj->ID;
								$coupons_obj = new WC_Coupon($coupon_id);
								if($coupons_obj->get_discount_type() == 'percent'){
									echo $coupons_obj->get_amount().'% of order total.';
								}else{
									echo get_woocommerce_currency_symbol().$coupons_obj->get_amount().__(' flat discount.','rtwwoc-woocommerce-order-coupon');
								}
								?></td>
							</tr>
						<?php }	?>
					</tbody>
				</table>
				</div><?php
			}
			$rtwwoc_max_coupon_count = get_option( 'rtwwocp_max_coupon_count', 0 );
			if(count($all_coupons) < $rtwwoc_max_coupon_count){
				$rtwwoc_allowed_users = get_option('rtwwocp_allowed_users','login');
				if((is_user_logged_in() && $rtwwoc_allowed_users != 'guest') || (!is_user_logged_in() && $rtwwoc_allowed_users === 'guest')){
					$rtwwoc_selected_order_status = get_option('rtwwocp_selected_order_status', array() );
					if(in_array('wc-'.$order->get_status(), $rtwwoc_selected_order_status)){
						$order_date = date_i18n( 'F j, Y', strtotime( $order->get_date_created()  ) );
						$today_date = date_i18n( 'F j, Y' );
						$order_date = strtotime($order_date);
						$today_date = strtotime($today_date);
						$days = $today_date - $order_date;
						$day_diff = floor($days/(60*60*24));
						$rtwwoc_max_order_days = get_option('rtwwocp_max_order_days',0);
						if($rtwwoc_max_order_days >= $day_diff && $rtwwoc_max_order_days != 0)
						{
							
							?>
							<div class="coupon rtwwoc_apply_coupon_row">
								<h2><?php _e('Apply Coupon','rtwwoc-woocommerce-order-coupon'); ?></h2>
								<label for="coupon_code rtwwoc_apply_coupon_label">Coupon :</label> 
								<input type="text" name="rtwwoc_coupon_code" class="input-text" id="rtwwoc_coupon_code" value="" placeholder="Coupon code"> 
								<button type="button" class="button rtwwoc_apply_coupon" name="rtwwoc_apply_coupon" value="Apply coupon" data-order_id="<?php echo $order_id ?>"><?php _e('Apply coupon','rtwwoc-woocommerce-order-coupon'); ?></button>
							</div><br>
							<?php
							
						}
					}		
				}
			}
		}
	}

	/**
	 * Sending notification email to admin about coupon applyed on order.
	 *
	 * @since    1.0.0
	 */
	public function rtwwoc_coupon_added_callback(){

		$rtwwoc_security_check = check_ajax_referer( 'rtwwoc-ajax-seurity', 'security_check' );
		if( $rtwwoc_security_check ){
			$rtwwoc_order_id = isset($_POST['order_id']) ? sanitize_post( $_POST['order_id'] ) : 0 ;
			$rtwwoc_coupon_code = isset($_POST['coupon']) ? sanitize_post( $_POST['coupon'] ) : '' ;

			if($rtwwoc_order_id > 0 && $rtwwoc_coupon_code != ''){
				$rtwwoc_email = WC()->mailer()->emails['RTWWOC_COUPON_ADDED'];
				$rtwwoc_email->trigger( $rtwwoc_order_id, $rtwwoc_coupon_code );
			}
		}
		die();
	}
}
