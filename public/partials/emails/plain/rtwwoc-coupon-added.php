<?php
/**
 * Admin new order email (plain text)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/plain/admin-new-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails/Plain
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo '= ' . ( $email_heading ) . " =\n\n";

/* translators: %s: Customer billing full name */
echo esc_html__( 'Customer has been applied a coupon on order..', 'rtwwocp-order-coupon-pro' ). "\n\n";

echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo esc_html__('Customer has been applied a coupon on order #','rtwwocp-order-coupon-pro').$rtwwocp_order_id.esc_html__(' and coupon code is "','rtwwocp-order-coupon-pro').esc_html($rtwwocp_coupon_code).esc_html__('" that amount is ','rtwwocp-order-coupon-pro').esc_html($rtwwocp_coupon_amount);

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo esc_html( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
