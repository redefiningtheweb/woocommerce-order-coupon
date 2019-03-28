<?php
/**
 * Admin new order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-new-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails/HTML
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p>
	<?php esc_html_e('Customer has applied a coupon on order for getting discount in order.','rtwwocp-order-coupon-pro') ?>
</p>
<p>
	<?php echo esc_html__('customer has applied a coupon on order #','rtwwocp-order-coupon-pro').$rtwwocp_order_id.esc_html__(' and coupon code is "','rtwwocp-order-coupon-pro').esc_html($rtwwocp_coupon_code).esc_html__('" that amount is ','rtwwocp-order-coupon-pro').esc_html($rtwwocp_coupon_amount); ?>
</p>


<?php 
/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
