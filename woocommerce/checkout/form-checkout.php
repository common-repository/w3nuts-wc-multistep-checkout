<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>
<div class="container-coupon-login-form"></div>
<div class="w3nmsc-loading-img"></div>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	<!-- Steps Main div -->
	<div id="w3nSteps">
		<?php do_action( 'w3nmscheckout_multistep_checkout_before' ); ?>

		<?php if ( $checkout->get_checkout_fields() ) { ?>

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() || 'yes' == get_option( 'w3nmscheckout_billing_shipping' ) ) { 
				?>
                <h1 class="title-billing-shipping"><?php echo get_option( 'w3nmscheckout_billing_shipping_label' ) ? __( get_option('w3nmscheckout_billing_shipping_label' ), 'w3nWCMS' ) : __( 'Billing &amp; Shipping', 'w3nWCMS' ); ?></h1>
        	<?php } else { ?>
                <h1><?php echo get_option( 'w3nmscheckout_billing_label' ) ? __( get_option( 'w3nmscheckout_billing_label' ), 'w3nWCMS' ) : __( 'Billing', 'w3nWCMS' ); ?></h1>
            <?php } ?>
            <!-- Billing & Shipping -->
            <?php            
            	if ( 'yes' == get_option( 'w3nmscheckout_billing_shipping' ) ) {
            	?>                
                <div class="billing-tab-contents">
                    <?php if ( get_option( 'w3nmscheckout_billing_shipping_page_title' ) ) { 
                        ?>
                        <h2><?php _e( get_option( 'w3nmscheckout_billing_shipping_page_title' ), 'woocommerce' ); ?></h2>
                        <hr />
                        <?php
                    } else { 
                        ?>
                        <h2><?php _e('Billing n Shipping', 'woocommerce'); ?></h2>
                        <hr />
                        <?php
                    } ?>
                    <?php if ( get_option('w3nmscheckout_billing_shipping_page_text') ) {
                        ?>
                        <p><?php _e( get_option('w3nmscheckout_billing_shipping_page_text'), 'woocommerce' ); ?></p>
                        <?php
                    } ?>

                    <?php
                    do_action( 'woocommerce_checkout_billing' );
                    do_action( 'woocommerce_checkout_shipping' );
                    do_action( 'woocommerce_checkout_after_customer_details' );
                    ?>
                </div>
            <?php } else { ?>
                <div class="billing-tab-contents">
                    <?php if ( get_option( 'w3nmscheckout_billing_page_title' ) ) { 
                        ?>
                        <h2><?php _e( get_option( 'w3nmscheckout_billing_page_title' ), 'woocommerce' ); ?></h2><hr />
                        <?php
                    } else { 
                        ?>
                        <h2><?php _e('Billing', 'woocommerce'); ?></h2>
                        <hr />
                        <?php
                    } ?>
                    <?php if ( get_option('w3nmscheckout_billing_page_text') ) {
                        ?>
                        <p><?php _e( get_option('w3nmscheckout_billing_page_text'), 'woocommerce' ); ?></p>                        
                        <?php
                    } ?>
                    <?php
                    do_action( 'woocommerce_checkout_billing' );

                    //If cart don't needs shipping
                    if ( ! WC()->cart->needs_shipping_address() ) {
                        do_action( 'woocommerce_checkout_after_customer_details' );
                        do_action( 'woocommerce_before_order_notes', $checkout );

                        if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) {

                            if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) {
                    		?>
                    			<h3><?php _e( 'Additional Information', 'woocommerce' ); ?></h3>

                    		<?php } ?>

                    		<?php foreach ( $checkout->checkout_fields['order'] as $key => $field ) {
                    			woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); 
                    		}
                        } 
                        do_action( 'woocommerce_after_order_notes', $checkout ); 
                    } ?>
                </div>

                <?php if ( ! wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) { 
                    do_action('w3nmscheckout_before_shipping', $checkout); 
                ?>
                    <h1 class="title-shipping"><?php echo get_option( 'w3nmscheckout_shipping_label' ) ? __( get_option( 'w3nmscheckout_shipping_label' ), 'w3nWCMS' ) : __( 'Shipping', 'w3nWCMS' ); ?></h1>
                    <div class="shipping-tab-contents">
                    <?php if ( get_option( 'w3nmscheckout_shipping_page_title' ) ) { 
                        ?>
                        <h2><?php _e( get_option( 'w3nmscheckout_shipping_page_title' ), 'woocommerce' ); ?></h2>
                        <hr />
                        <?php
                    } else { 
                        ?>
                        <h2><?php _e('Shipping', 'woocommerce'); ?></h2>
                        <hr />
                        <?php
                    } ?>
                    <?php if ( get_option('w3nmscheckout_shipping_page_text') ) {
                        ?>
                        <p><?php _e( get_option('w3nmscheckout_shipping_page_text'), 'woocommerce' ); ?></p>
                        <?php
                    } ?>
                    <?php 
                    	do_action( 'woocommerce_checkout_shipping' );
                    	do_action( 'woocommerce_checkout_after_customer_details' ); 
                    ?>
                    </div>
                    <?php do_action( 'w3nmscheckout_after_shipping', $checkout);
                }
            } 
		} 
		?>

		<?php do_action('w3nmscheckout_before_order_info', $checkout); ?>  
        <!-- If order details and Payment tabs are not combined -->
        <?php if ( 'no' == get_option( 'w3nmscheckout_order_payment_tabs' ) ) { ?>
            <!-- Order Details Tab -->
            <h1 class="title-order-info"><?php echo get_option( 'w3nmscheckout_order_label' ) ? __( get_option( 'w3nmscheckout_order_label' ), 'w3nWCMS' ) : __( 'Order Details', 'w3nWCMS' ); ?></h1>
            <div class="shipping-tab">
            
                <?php 
                if ( 'true' != get_option( 'w3nmscheckout_coupon_form' ) && 'default' != get_option( 'w3nmscheckout_coupon_placement' ) && 'before-order-review-table' == get_option( 'w3nmscheckout_coupon_placement' ) ) { 
                    ?>
                    <div class="coupon-step"></div>                                       
                    <?php
                }
                ?>
            
                <?php if ( get_option( 'w3nmscheckout_order_details_page_title' ) ) { 
                        ?>
                        <h2><?php _e( get_option( 'w3nmscheckout_order_details_page_title' ), 'woocommerce' ); ?></h2>
                        <hr />
                        <?php
                    } else { 
                        ?>
                        <h2><?php _e('Order Details', 'woocommerce'); ?></h2>
                        <hr />
                        <?php
                    } ?>
                    <?php if ( get_option('w3nmscheckout_order_details_page_text') ) {
                        ?>
                        <p><?php _e( get_option('w3nmscheckout_order_details_page_text'), 'woocommerce' ); ?></p>
                        <?php
                    } ?>
                <?php do_action( 'w3nmscheckout_before_order_contents', $checkout ); ?>
                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                <div id="orders_review" class="woocommerce-checkout-review-order">
                    <?php remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20); ?>
                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>
                <?php 
                    if ( 'after-order-review-table' == get_option( 'w3nmscheckout_coupon_placement' ) && 'true' != get_option( 'w3nmscheckout_coupon_form' ) ) { 
                        ?>                    
                        <div class="coupon-step"></div>
                    <?php
                    }
                ?>
                <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
                        
            </div>
            <?php do_action( 'w3nmscheckout_after_order_info', $checkout ); ?>
            <?php do_action( 'w3nmscheckout_before_payment', $checkout ); ?>
            <!-- Payment Tab (Only Payment options) -->
            <h1 class="title-payment"><?php echo get_option( 'w3nmscheckout_payment_label' ) ? __( get_option( 'w3nmscheckout_payment_label' ), 'w3nWCMS' ) : __( 'Payment', 'w3nWCMS' ); ?></h1>

            <div class="payment-tab-contents"> 
                
                <?php if ( get_option( 'w3nmscheckout_payment_page_title' ) ) { 
                        ?>
                        <h2><?php _e( get_option( 'w3nmscheckout_payment_page_title' ), 'woocommerce' ); ?></h2>
                        <hr />
                        <?php
                    } else { 
                        ?>
                        <h2><?php _e('Payment', 'woocommerce'); ?></h2>
                        <hr />
                        <?php
                    } ?>
                    <?php if ( get_option('w3nmscheckout_payment_page_text') ) {
                        ?>
                        <p><?php _e( get_option('w3nmscheckout_payment_page_text'), 'woocommerce' ); ?></p>
                        <?php
                    } ?>
                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
                    <?php add_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20); ?>

                    <?php remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10); ?>
                    
                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>
            </div>

        <?php } else { ?> 
        <!-- If Payment & order review are combained or Order review hide -->
        <!-- </div> -->
        <?php do_action( 'w3nmscheckout_after_order_info', $checkout ); ?>
        <?php do_action( 'w3nmscheckout_before_payment', $checkout ); ?>
        <?php if ( 'yes' == get_option( 'w3nmscheckout_order_payment_tabs' ) ) { ?>
        <h1 class="title-payment"><?php echo get_option( 'w3nmscheckout_order_payment_label' ) ? __( get_option( 'w3nmscheckout_order_payment_label' ), 'w3nWCMS' ) : __( 'Order & Payment', 'w3nWCMS' ); ?></h1>
        <?php } else { ?>
        <h1 class="title-payment"><?php echo get_option( 'w3nmscheckout_payment_label' ) ? __( get_option( 'w3nmscheckout_payment_label' ), 'w3nWCMS' ) : __( 'Payment', 'w3nWCMS' ); ?></h1>
        <?php } ?>        
        <div class="payment-tab-contents">
            <?php 
                if ( 'true' != get_option( 'w3nmscheckout_coupon_form' ) && 'default' != get_option( 'w3nmscheckout_coupon_placement' ) && 'before-order-review-table' == get_option( 'w3nmscheckout_coupon_placement' ) ) { 
                    ?>                    
                    <div class="coupon-step"></div>
                <?php
                }
            ?>
            <?php if ( get_option( 'w3nmscheckout_order_payment_page_title' ) ) { 
                ?>
                <h2><?php _e( get_option( 'w3nmscheckout_order_payment_page_title' ), 'woocommerce' ); ?></h2>
                <hr />
                <?php
            } else { 
                ?>
                <h2><?php _e('Order n Payment', 'woocommerce'); ?></h2>
                <hr />
                <?php
            } ?>
            <?php if ( get_option('w3nmscheckout_order_payment_page_text') ) {
                ?>
                <p><?php _e( get_option('w3nmscheckout_order_payment_page_text'), 'woocommerce' ); ?></p>
                <?php
            } ?>
            <div id="order_review" class="woocommerce-checkout-review-order">
            <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
            <?php 
                if ( 'true' != get_option( 'w3nmscheckout_coupon_form' ) && 'default' != get_option( 'w3nmscheckout_coupon_placement' ) && 'after-order-review-table' == get_option( 'w3nmscheckout_coupon_placement' ) ) { 
                    ?>                    
                    
                    <?php 
                    remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
                    do_action( 'woocommerce_checkout_order_review' ); 
                    ?>
                    <div class="coupon-step"></div>
                    <?php
                    add_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20); 

                    remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10); 
                    
                    do_action( 'woocommerce_checkout_order_review' );
                } else {
                    do_action( 'woocommerce_checkout_order_review' );
                } 
                ?>
            </div>
        </div>

        <?php } ?>
        <?php if ( 'true' == get_option( 'w3nmscheckout_review_order' ) ) { ?>
            <h1 class="title-review-order"><?php echo get_option( 'w3nmscheckout_review_order_label' ) ? __( get_option( 'w3nmscheckout_review_order_label' ), 'w3nWCMS' ) : __( 'Review order', 'w3nWCMS' ); ?></h1>
        
        <div class="w3nmsc-review-order-wrapper">
            <?php if ( get_option( 'w3nmscheckout_order_review_page_title' ) ) { 
                ?>
                <h2><?php _e( get_option( 'w3nmscheckout_order_review_page_title' ), 'woocommerce' ); ?></h2>
                <hr />
                <?php
            } else { 
                ?>
                <h2><?php _e('Review Order', 'woocommerce'); ?></h2>
                <hr />
                <?php
            } ?>
            <?php if ( get_option('w3nmscheckout_order_review_page_text') ) {
                ?>
                <p><?php _e( get_option('w3nmscheckout_order_review_page_text'), 'woocommerce' ); ?></p>
                <?php
            } ?>
            <?php if ( 'true' != get_option( 'w3nmscheckout_coupon_form' ) && 'default' != get_option('w3nmscheckout_coupon_placement') && 'review-order-page' == get_option('w3nmscheckout_coupon_placement') ) {
                ?>
                <div class="coupon-step" id="coupon-on-review"></div>
                <?php
            }
            ?>
            <div class="w3nmsc-review-order-details"></div>
            <?php do_action( 'w3nmscheckout_order_customer_review' ); ?>

        </div>
        <?php } ?>
        <?php do_action( 'w3nmscheckout_after', $checkout ); ?>
    </div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>