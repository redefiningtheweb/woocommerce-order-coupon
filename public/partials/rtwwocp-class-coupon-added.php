<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'RTWWOCP_COUPON_ADDED' ) ) {

    class RTWWOC_COUPON_ADDED extends WC_Email {

        public $rtwwocp_order_id;
        public $rtwwocp_coupon_code;
        public $rtwwocp_coupon_amount = '';
       
        public function __construct() {
            $this->id             = 'rtwwocp_coupon_added_email';
            $this->title          = esc_html__( 'Coupon Applied on Order', 'rtwwoc-woocommerce-order-coupon' );
            $this->description    = esc_html__( 'customer have applied a coupon on order on your site.', 'rtwwoc-woocommerce-order-coupon' );
            $this->recipient      = get_option('admin_email');
            $this->template_html  = 'emails/rtwwoc-coupon-added.php';
            $this->template_plain = 'emails/plain/rtwwoc-coupon-added.php';
            $this->template_base  = plugin_dir_path( dirname( __FILE__ ) ).'/partials/' ;
            $this->placeholders   = array(
                '{site_title}'       => $this->get_blogname(),
            );

            // Call parent constructor
            parent::__construct();
        }

        /**
         * Get email subject.
         *
         * @since  3.1.0
         * @return string
         */
        public function get_default_subject() {
            return esc_html__( 'Customer is applied a coupon on order in site {site_title}.', 'rtwwoc-woocommerce-order-coupon' );
        }

        /**
         * Get email heading.
         *
         * @since  3.1.0
         * @return string
         */
        public function get_default_heading() {
            return esc_html__( 'Customer Applied a Coupon on Your Site', 'rtwwoc-woocommerce-order-coupon' );
        }

        /**
         * Trigger the sending of this email.
         *
         * @param int $transaction_id.
         */
        public function trigger( $rtwwocp_order_id, $rtwwocp_coupon_code ) {
            
            if ( $rtwwocp_order_id > 0 && $rtwwocp_coupon_code != '') {
                $this->setup_locale();
                
                $rtwwocp_coupon_post_obj = get_page_by_title($rtwwocp_coupon_code, OBJECT, 'shop_coupon');
                $rtwwocp_coupon_id = $rtwwocp_coupon_post_obj->ID;
                $rtwwocp_coupon_amount = 0;
                $rtwwocp_coupons_obj = new WC_Coupon($rtwwocp_coupon_id);
                if($rtwwocp_coupons_obj->get_discount_type() == 'percent'){
                    $rtwwocp_coupon_amount = $rtwwocp_coupons_obj->get_amount().'%';
                }else{
                    $rtwwocp_coupon_amount = get_woocommerce_currency_symbol().$rtwwocp_coupons_obj->get_amount();
                }
                
                $this->rtwwocp_order_id = $rtwwocp_order_id;
                $this->rtwwocp_coupon_code = $rtwwocp_coupon_code;
                $this->rtwwocp_coupon_amount = $rtwwocp_coupon_amount;
                $this->recipient = get_option('admin_email');

                if ( $this->is_enabled() && $this->get_recipient() ) {
                    $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());
                }
                $this->restore_locale();
            }
            
        }

        /**
         * Get content html.
         *
         * @access public
         * @return string
         */
        public function get_content_html() {
            return wc_get_template_html( $this->template_html, array(
                'rtwwocp_order_id'      => $this->rtwwocp_order_id,
                'rtwwocp_coupon_code'   => $this->rtwwocp_coupon_code,
                'rtwwocp_coupon_amount' => $this->rtwwocp_coupon_amount,
                'email_heading' => $this->get_heading(),
                'sent_to_admin' => false,
                'plain_text'    => false,
                'email'         => $this ), 'rtwwoc-woocommerce-order-coupon', $this->template_base );
        }

        /**
         * Get content plain.
         *
         * @access public
         * @return string
         */
        public function get_content_plain() {
            return wc_get_template_html( $this->template_plain, array(
                'rtwwocp_order_id'      => $this->rtwwocp_order_id,
                'rtwwocp_coupon_code'   => $this->rtwwocp_coupon_code,
                'rtwwocp_coupon_amount' => $this->rtwwocp_coupon_amount,
                'email_heading' => $this->get_heading(),
                'sent_to_admin' => false,
                'plain_text'    => true,
                'email'         => $this ), 'rtwwoc-woocommerce-order-coupon', $this->template_base );
        }

        /**
         * Initialise settings form fields.
         */
        public function init_form_fields() {
            $this->form_fields = array(
                'enabled' => array(
                    'title'   => esc_html__( 'Enable/Disable', 'rtwwoc-woocommerce-order-coupon' ),
                    'type'    => 'checkbox',
                    'label'   => esc_html__( 'Enable this email notification', 'rtwwoc-woocommerce-order-coupon' ),
                    'default' => 'yes',
                ),
                'subject' => array(
                    'title'       => esc_html__( 'Subject', 'rtwwoc-woocommerce-order-coupon' ),
                    'type'        => 'text',
                    'desc_tip'    => true,
                    /* translators: %s: list of placeholders */
                    'description' => sprintf( esc_html__( 'Available placeholders: %s', 'rtwwoc-woocommerce-order-coupon' ), '<code>{site_title}</code>' ),
                    'placeholder' => $this->get_default_subject(),
                    'default'     => '',
                ),
                'heading' => array(
                    'title'       => esc_html__( 'Email heading', 'rtwwoc-woocommerce-order-coupon' ),
                    'type'        => 'text',
                    'desc_tip'    => true,
                    /* translators: %s: list of placeholders */
                    'description' => sprintf( esc_html__( 'Available placeholders: %s', 'rtwwoc-woocommerce-order-coupon' ), '<code>{site_title}</code>' ),
                    'placeholder' => $this->get_default_heading(),
                    'default'     => '',
                ),
                'email_type' => array(
                    'title'       => esc_html__( 'Email type', 'rtwwoc-woocommerce-order-coupon' ),
                    'type'        => 'select',
                    'description' => esc_html__( 'Choose which format of email to send.', 'rtwwoc-woocommerce-order-coupon' ),
                    'default'     => 'html',
                    'class'       => 'email_type wc-enhanced-select',
                    'options'     => $this->get_email_type_options(),
                    'desc_tip'    => true,
                ),
            );
        }

    }

}

return new RTWWOC_COUPON_ADDED();
