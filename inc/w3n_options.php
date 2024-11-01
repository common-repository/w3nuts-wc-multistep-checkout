<?php
/**
 * Page is adding options to WP back end.
 */
if ( !current_user_can( 'manage_options' ) ) {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

$current    = 'general';
$tab        = filter_input(INPUT_GET, 'tab');
$tabs       = array ('general', 'steps', 'styles');
if ( ! empty( $tab ) && in_array( $tab, $tabs ) ) {
    $current = $tab;
}
if ( isset( $_POST['posted_data'] ) && wp_verify_nonce( $_POST['posted_data'], 'w3n_push_setting') ) {
    $do_not_save = array('posted_data', 'submit', 'w3nmsc_restore_default');
    $posts = wp_unslash( $_POST );
    foreach ( $posts as $option_name => $option_value ) {
        if ( in_array( sanitize_text_field( $option_name ), $do_not_save ) )
            continue;
        // Save the posted value in the database
        update_option( sanitize_text_field( $option_name ), $option_value );
    }
    // If restore to default
    if ( isset( $_POST['w3nmsc_restore_default'] ) && wp_verify_nonce( $_POST['w3nmsc_restore_default'], 'w3n_yes') ) {
        $do_not_save = array('w3nmscheckout_order_payment_tabs', 'w3nmscheckout_postcode_validation', 'w3nmscheckout_email_error', 'w3nmscheckout_phone_error', 'w3nmscheckout_required_error', 'w3nmscheckout_coupon_form', 'w3nmscheckout_registration_form');
        $posts = wp_unslash( $_POST );
        foreach ( $posts as $option_name => $option_value ) {
            if (in_array( sanitize_text_field( $option_name ), $do_not_save ) )
                continue;
            delete_option( sanitize_text_field( $option_name ) );
        }

        update_option( 'w3nmscheckout_code_location', 'header' );
        update_option( 'w3nmscheckout_login_form', 'false' );
        update_option( 'w3nmscheckout_coupon_form', 'false' );
        update_option( 'w3nmscheckout_billing_shipping', 'no' );
        update_option( 'w3nmscheckout_order_detail', 'true' );
        update_option( 'w3nmscheckout_review_order', 'true' );
        update_option( 'w3nmscheckout_order_payment_tabs', 'no' );
        update_option( 'w3nmscheckout_registration_form', 'true' );
        update_option( 'w3nmscheckout_show_thumbnail', 'false' );
        update_option( 'w3nmscheckout_animation', 'fade' );
        update_option( 'w3nmscheckout_orientation', 'horizontal' );
        update_option( 'w3nmscheckout_pagination', 'no' );
        update_option( 'w3nmscheckout_number_hide_show', 'no' );
        update_option( 'w3nmscheckout_postcode_validation', 'no' );
        update_option( 'w3nmscheckout_additional_details','false' );
        update_option( 'w3nmscheckout_coupon_placement', 'default' );
        update_option( 'w3nmscheckout_steps_style', 'boxes' );        
    }
    ?>
    <div class="updated"><p><strong><?php _e('settings saved.', 'woocommerce-multistep-checkout'); ?></strong></p></div>
    <?php
}
?>
<div class="wrapper w3nmscheckout">
    <!-- Main w3n left start -->
    <div class="w3nleftmain">
        <div class="maincheckrow">
            <div class="leftnavbox">
                <div class="logobox"><img src="<?php echo plugins_url('w3nuts-wc-multistep-checkout/images/w3n_logo.svg' ); ?>" alt=""></div>
                <div class="nav-tab-wrapper w3nWCMS-tab-wrapper">
                    <a href="?page=w3nmscheckout&tab=general" class="nav-tab <?php echo $current == 'general' ? ' nav-tab-active' : ''; ?>"><?php _e('General Settings', 'w3nWCMS'); ?></a>
                    <a href="?page=w3nmscheckout&tab=steps" class="nav-tab <?php echo $current == 'steps' ? ' nav-tab-active' : ''; ?>"><?php _e('Step Options', 'w3nWCMS'); ?></a>
                    <a href="?page=w3nmscheckout&tab=styles" class="nav-tab <?php echo $current == 'styles' ? ' nav-tab-active' : ''; ?>"><?php _e('Step Styles', 'w3nWCMS'); ?></a>
                </div>
            </div>
            <div class="rightpartbox">
                <div class="titlebox"><h2><?php _e('WooCommerce Multistep Checkout', 'w3nWCMS') ?></h2></div>
                    <div class="formbox">
                        <form name="w3nmsc_options" method="post" id="options_form" action="">
                            <input type="hidden" name="posted_data" value="<?php echo wp_create_nonce('w3n_push_setting'); ?>">
                            <?php
                            if ( 'general' == $current ) { 
                            ?>
                            <table class="form-table">
                                <tr>
                                    <td colspan="2"><h3><?php _e('Buttons Text', 'w3nWCMS') ?></h3></td>
                                </tr>
                                <tr>
                                    <td><?php _e('Skip Login button label', 'w3nWCMS') ?></td>
                                    <td>
                                        <input class="input_text" type="text" name="w3nmscheckout_skip_login_label" value="<?php echo get_option('w3nmscheckout_skip_login_label') ? esc_attr_e(get_option('w3nmscheckout_skip_login_label')) : "Skip Login" ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Next Button label', 'w3nWCMS') ?></td>
                                    <td>
                                        <input class="input_text" type="text" name="w3nmscheckout_next_button_lable" value="<?php echo get_option('w3nmscheckout_next_button_lable') ? esc_attr_e(get_option('w3nmscheckout_next_button_lable')) : "Next" ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Previous Button label', 'w3nWCMS') ?></td>
                                    <td>
                                        <input class="input_text" type="text" name="w3nmscheckout_prev_button_lable" value="<?php echo get_option('w3nmscheckout_prev_button_lable') ? esc_attr_e(get_option('w3nmscheckout_prev_button_lable')) : "Previous" ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Place Order Button label', 'w3nWCMS') ?></td>
                                    <td>
                                        <input class="input_text" type="text" name="w3nmscheckout_place_order" value="<?php echo get_option('w3nmscheckout_place_order') ? esc_attr_e(get_option('w3nmscheckout_place_order')) : "Place Order" ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><h3><?php _e('Validation Error Messages', 'w3nWCMS') ?></h3></td>
                                </tr>
                                <tr>
                                    <td><?php _e('Required Field', 'w3nWCMS') ?></td>
                                    <td>
                                        <input class="input_text" type="text" name="w3nmscheckout_required_error" value="<?php echo get_option('w3nmscheckout_required_error') ? esc_attr_e(get_option('w3nmscheckout_required_error')) : "This field is required" ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Invalid Email', 'w3nWCMS') ?></td>
                                    <td>
                                        <input class="input_text" type="text" name="w3nmscheckout_email_error" value="<?php echo get_option('w3nmscheckout_email_error') ? esc_attr_e(get_option('w3nmscheckout_email_error')) : "Invalid Email address" ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Invalid Phone', 'w3nWCMS') ?></td>
                                    <td>
                                        <input class="input_text" type="text" name="w3nmscheckout_phone_error" value="<?php echo get_option('w3nmscheckout_phone_error') ? esc_attr_e(get_option('w3nmscheckout_phone_error')) : "Invalild phone number" ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Invalid Postcode', 'w3nWCMS') ?></td>
                                    <td>
                                        <input class="input_text" type="text" name="w3nmscheckout_postcode_error" value="<?php echo get_option('w3nmscheckout_postcode_error') ? esc_attr_e(get_option('w3nmscheckout_postcode_error')) : "Invalid zip/pincode" ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Terms and condition', 'w3nWCMS') ?></td>
                                    <td>
                                        <input class="input_text" type="text" name="w3nmscheckout_tnc_error" value="<?php echo get_option('w3nmscheckout_tnc_error') ? esc_attr_e(get_option('w3nmscheckout_tnc_error')) : "Please check Terms and Condition." ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><h3><?php _e('Code Location', 'w3nWCMS') ?></h3></td>
                                </tr>
                                <tr>
                                    <td><?php _e('Steps code location to theme', 'w3nWCMS') ?></td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="header" class="input-radio-button" type="radio" name="w3nmscheckout_code_location" value="header" <?php checked(sanitize_text_field(get_option('w3nmscheckout_code_location')), 'header', true); ?> >
                                            <label class="input-label-button label-button-left" for="header">
                                                <span class="label-button-text"><?php _e('Header', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="footer" class="input-radio-button" type="radio" name="w3nmscheckout_code_location" value="footer" <?php checked(sanitize_text_field(get_option('w3nmscheckout_code_location')), 'footer', true); ?> >
                                            <label class="input-label-button label-button-right" for="footer">
                                                <span class="label-button-text"><?php _e('Footer', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <?php
                            } else if ( 'steps' == $current ) {
                            ?>  
                            <table class="form-table form-table1">
                                <tr>
                                    <td colspan="4"><h3><?php _e('Steps customization options', 'w3nWCMS') ?></h3>
                                        <span class="description"><?php _e( 'Various options for your checkout steps.','w3nWCMS' ) ?></span>
                                    </td>
                                </tr>
                                <tr class="titlerow">
                                    <td><h4><?php _e('Step Titles', 'w3nWCMS') ?></h4></td>
                                    <td><h4><?php _e('Page Title', 'w3nWCMS') ?></h4></td>
                                    <td><h4><?php _e('Page Text', 'w3nWCMS') ?></h4></td>
                                    <td><h4><?php _e('Step Option', 'w3nWCMS') ?></h4></td>
                                </tr>
                                <!-- Login/Registration -->
                                <tr>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_login_label" value="<?php echo get_option('w3nmscheckout_login_label') ? esc_attr_e(get_option('w3nmscheckout_login_label')) : "Login" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_login_page_title" value="<?php echo get_option('w3nmscheckout_login_page_title') ? esc_attr_e(get_option('w3nmscheckout_login_page_title')) : "I have an account" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_login_page_text" value="<?php echo get_option('w3nmscheckout_login_page_text') ? esc_attr_e(get_option('w3nmscheckout_login_page_text')) : "" ?>" />
                                    </td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="show-login" class="input-radio-button" type="radio" name="w3nmscheckout_login_form" value="true" <?php checked(sanitize_text_field(get_option('w3nmscheckout_login_form')), 'true', true); ?> >
                                            <label class="input-label-button label-button-left" for="show-login">
                                                <span class="label-button-text"><?php _e('Show', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="hide-login" class="input-radio-button" type="radio" name="w3nmscheckout_login_form" value="false" <?php checked(sanitize_text_field(get_option('w3nmscheckout_login_form')), 'false', true); ?>>
                                            <label class="input-label-button label-button-right" for="hide-login">
                                                <span class="label-button-text"><?php _e('Hide', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_coupon_label" value="<?php echo get_option('w3nmscheckout_coupon_label') ? esc_attr_e(get_option('w3nmscheckout_coupon_label')) : "Coupon" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_coupon_page_title" value="<?php echo get_option('w3nmscheckout_coupon_page_title') ? esc_attr_e(get_option('w3nmscheckout_coupon_page_title')) : "Promo Code" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_coupon_page_text" value="<?php echo get_option('w3nmscheckout_coupon_page_text') ? esc_attr_e(get_option('w3nmscheckout_coupon_page_text')) : "" ?>" />
                                    </td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="show-coupon" class="input-radio-button" type="radio" name="w3nmscheckout_coupon_form" value="true" <?php checked(sanitize_text_field(get_option('w3nmscheckout_coupon_form')), 'true', true); ?> >
                                            <label class="input-label-button label-button-left" for="show-coupon">
                                                <span class="label-button-text"><?php _e('Show', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="hide-coupon" class="input-radio-button" type="radio" name="w3nmscheckout_coupon_form" value="false" <?php checked(sanitize_text_field(get_option('w3nmscheckout_coupon_form')), 'false', true); ?>>
                                            <label class="input-label-button label-button-right" for="hide-coupon">
                                                <span class="label-button-text"><?php _e('Hide', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_billing_label" value="<?php echo get_option('w3nmscheckout_billing_label') ? esc_attr_e(get_option('w3nmscheckout_billing_label')) : "Billing" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_billing_page_title" value="<?php echo get_option('w3nmscheckout_billing_page_title') ? esc_attr_e(get_option('w3nmscheckout_billing_page_title')) : "Billing" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_billing_page_text" value="<?php echo get_option('w3nmscheckout_billing_page_text') ? esc_attr_e(get_option('w3nmscheckout_billing_page_text')) : "" ?>" />
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_shipping_label" value="<?php echo get_option('w3nmscheckout_shipping_label') ? esc_attr_e(get_option('w3nmscheckout_shipping_label')) : "Shipping" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_shipping_page_title" value="<?php echo get_option('w3nmscheckout_shipping_page_title') ? esc_attr_e(get_option('w3nmscheckout_shipping_page_title')) : "Shipping" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_shipping_page_text" value="<?php echo get_option('w3nmscheckout_shipping_page_text') ? esc_attr_e(get_option('w3nmscheckout_billing_page_text')) : "" ?>" />
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_billing_shipping_label" value="<?php echo get_option('w3nmscheckout_billing_shipping_label') ? esc_attr_e(get_option('w3nmscheckout_billing_shipping_label')) : "Billing & Shipping" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_billing_shipping_page_title" value="<?php echo get_option('w3nmscheckout_billing_shipping_page_title') ? esc_attr_e(get_option('w3nmscheckout_billing_shipping_page_title')) : "Billing and Shipping" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_billing_shipping_page_text" value="<?php echo get_option('w3nmscheckout_billing_shipping_page_text') ? esc_attr_e(get_option('w3nmscheckout_billing_shipping_page_text')) : "" ?>" />
                                    </td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="combine-bs-y" class="input-radio-button" type="radio" name="w3nmscheckout_billing_shipping" value="yes" <?php checked(sanitize_text_field(get_option('w3nmscheckout_billing_shipping')), 'yes', true); ?> >
                                            <label class="input-label-button label-button-left" for="combine-bs-y">
                                                <span class="label-button-text"><?php _e('Yes', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="combine-bs-n" class="input-radio-button" type="radio" name="w3nmscheckout_billing_shipping" value="no" <?php checked(sanitize_text_field(get_option('w3nmscheckout_billing_shipping')), 'no', true); ?> >
                                            <label class="input-label-button label-button-right" for="combine-bs-n">
                                                <span class="label-button-text"><?php _e('No', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <span class="description"><?php _e('If you want to combine Billing & Shipping?', 'w3nWCMS') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_order_label" value="<?php echo get_option('w3nmscheckout_order_label') ? esc_attr_e(get_option('w3nmscheckout_order_label')) : "Order Details" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_order_details_page_title" value="<?php echo get_option('w3nmscheckout_order_details_page_title') ? esc_attr_e(get_option('w3nmscheckout_order_details_page_title')) : "Order Details" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_order_details_page_text" value="<?php echo get_option('w3nmscheckout_order_details_page_text') ? esc_attr_e(get_option('w3nmscheckout_order_details_page_text')) : "" ?>" />
                                    </td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="show-order" class="input-radio-button" type="radio" name="w3nmscheckout_order_detail" value="true" <?php checked(sanitize_text_field(get_option('w3nmscheckout_order_detail')), 'true', true); ?> >
                                            <label class="input-label-button label-button-left" for="show-order">
                                                <span class="label-button-text"><?php _e('Show', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="hide-order" class="input-radio-button" type="radio" name="w3nmscheckout_order_detail" value="false" <?php checked(sanitize_text_field(get_option('w3nmscheckout_order_detail')), 'false', true); ?>>
                                            <label class="input-label-button label-button-right" for="hide-order">
                                                <span class="label-button-text"><?php _e('Hide', 'w3nWCMS'); ?></span>
                                            </label> 
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_payment_label" value="<?php echo get_option('w3nmscheckout_payment_label') ? esc_attr_e(get_option('w3nmscheckout_payment_label')) : "Payment" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_payment_page_title" value="<?php echo get_option('w3nmscheckout_payment_page_title') ? esc_attr_e(get_option('w3nmscheckout_payment_page_title')) : "Payment" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_payment_page_text" value="<?php echo get_option('w3nmscheckout_payment_page_text') ? esc_attr_e(get_option('w3nmscheckout_payment_page_text')) : "" ?>" />
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_order_payment_label" value="<?php echo get_option('w3nmscheckout_order_payment_label') ? esc_attr_e(get_option('w3nmscheckout_order_payment_label')) : "Order & Payment" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_order_payment_page_title" value="<?php echo get_option('w3nmscheckout_order_payment_page_title') ? esc_attr_e(get_option('w3nmscheckout_order_payment_page_title')) : "" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_order_payment_page_text" value="<?php echo get_option('w3nmscheckout_order_payment_page_text') ? esc_attr_e(get_option('w3nmscheckout_order_payment_page_text')) : "" ?>" />
                                    </td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="combine-op-y" class="input-radio-button" type="radio" name="w3nmscheckout_order_payment_tabs" value="yes" <?php checked(sanitize_text_field(get_option('w3nmscheckout_order_payment_tabs')), 'yes', true); ?> >
                                            <label class="input-label-button label-button-left" for="combine-op-y">
                                                <span class="label-button-text"><?php _e('Yes', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="combine-op-n" class="input-radio-button" type="radio" name="w3nmscheckout_order_payment_tabs" value="no" <?php checked(sanitize_text_field(get_option('w3nmscheckout_order_payment_tabs')), 'no', true); ?> >
                                            <label class="input-label-button label-button-right" for="combine-op-n">
                                                <span class="label-button-text"><?php _e('No', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <span class="description"><?php _e('If you want to combine Order & Payment?', 'w3nWCMS') ?></span> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_review_order_label" value="<?php echo get_option('w3nmscheckout_review_order_label') ? esc_attr_e(get_option('w3nmscheckout_review_order_label')) : "Review order" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_order_review_page_title" value="<?php echo get_option('w3nmscheckout_order_review_page_title') ? esc_attr_e(get_option('w3nmscheckout_order_review_page_title')) : "" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_order_review_page_text" value="<?php echo get_option('w3nmscheckout_order_review_page_text') ? esc_attr_e(get_option('w3nmscheckout_order_review_page_text')) : "" ?>" />
                                    </td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="show-review" class="input-radio-button" type="radio" name="w3nmscheckout_review_order" value="true" <?php checked(sanitize_text_field(get_option('w3nmscheckout_review_order')), 'true', true); ?> >
                                            <label class="input-label-button label-button-left" for="show-review">
                                                <span class="label-button-text"><?php _e('Show', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="hide-review" class="input-radio-button" type="radio" name="w3nmscheckout_review_order" value="false" <?php checked(sanitize_text_field(get_option('w3nmscheckout_review_order')), 'false', true); ?>>
                                            <label class="input-label-button label-button-right" for="hide-review">
                                                <span class="label-button-text"><?php _e('Hide', 'w3nWCMS'); ?></span>
                                            </label> 
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Show/Hide Registration in steps', 'w3nWCMS') ?><br />
                                        <span class="description"><?php _e('Enable customer registration on the "My account" page from WooCommerce Settings.', 'w3nWCMS') ?></span>
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_register_page_title" value="<?php echo get_option('w3nmscheckout_register_page_title') ? esc_attr_e(get_option('w3nmscheckout_register_page_title')) : "I am new to store" ?>" />
                                    </td>
                                    <td>
                                        <input class="input_text1" type="text" name="w3nmscheckout_register_page_text" value="<?php echo get_option('w3nmscheckout_register_page_text') ? esc_attr_e(get_option('w3nmscheckout_register_page_text')) : "" ?>" />
                                    </td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="show-registraion" class="input-radio-button" type="radio" name="w3nmscheckout_registration_form" value="true" <?php checked(sanitize_text_field(get_option('w3nmscheckout_registration_form')), 'true', true); ?> >
                                            <label class="input-label-button label-button-left" for="show-registraion">
                                                <span class="label-button-text"><?php _e('Show', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="hide-registraion" class="input-radio-button" type="radio" name="w3nmscheckout_registration_form" value="false" <?php checked(sanitize_text_field(get_option('w3nmscheckout_registration_form')), 'false', true); ?>> 
                                            <label class="input-label-button label-button-right" for="hide-registraion">
                                                <span class="label-button-text"><?php _e('Hide', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <span class="description"><?php _e('Works only if Login step is shown.', 'w3nWCMS') ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Change coupon form placement', 'w3nWCMS') ?></td>
                                    <td colspan="3">
                                        <div class="radiogroup">
                                            <input id="before-order-review-table" class="input-radio-button" type="radio" name="w3nmscheckout_coupon_placement" value="before-order-review-table" <?php checked(sanitize_text_field(get_option('w3nmscheckout_coupon_placement')), 'before-order-review-table', true); ?> >
                                            <label class="input-label-button label-button-left" for="before-order-review-table">
                                                <span class="label-button-text"><?php _e('Before order details Table', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="after-order-review-table" class="input-radio-button" type="radio" name="w3nmscheckout_coupon_placement" value="after-order-review-table" <?php checked(sanitize_text_field(get_option('w3nmscheckout_coupon_placement')), 'after-order-review-table', true); ?>>
                                            <label class="input-label-button label-button-right" for="after-order-review-table">
                                                <span class="label-button-text"><?php _e('After order details Table', 'w3nWCMS'); ?></span>
                                            </label> 
                                        </div>
                                        <div class="radiogroup">
                                            <input id="review-order-page" class="input-radio-button" type="radio" name="w3nmscheckout_coupon_placement" value="review-order-page" <?php checked(sanitize_text_field(get_option('w3nmscheckout_coupon_placement')), 'review-order-page', true); ?>>
                                            <label class="input-label-button label-button-right" for="review-order-page">
                                                <span class="label-button-text"><?php _e('Review Order Page', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div><br />
                                        <div class="radiogroup">
                                            <input id="default" class="input-radio-button" type="radio" name="w3nmscheckout_coupon_placement" value="default" <?php checked(sanitize_text_field(get_option('w3nmscheckout_coupon_placement')), 'default', true); ?>>  
                                            <label class="input-label-button label-button-right" for="default">
                                                <span class="label-button-text"><?php _e('None (Hide Coupon form from every step.)', 'w3nWCMS'); ?></span>
                                            </label>   
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Show/Hide Product Thumbnail', 'w3nWCMS') ?></td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="show-thumbnail" class="input-radio-button" type="radio" name="w3nmscheckout_show_thumbnail" value="true" <?php checked(sanitize_text_field(get_option('w3nmscheckout_show_thumbnail')), 'true', true); ?> >
                                            <label class="input-label-button label-button-left" for="show-thumbnail">
                                                <span class="label-button-text"><?php _e('Show', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="hide-thumbnail" class="input-radio-button" type="radio" name="w3nmscheckout_show_thumbnail" value="false" <?php checked(sanitize_text_field(get_option('w3nmscheckout_show_thumbnail')), 'false', true); ?>>
                                            <label class="input-label-button label-button-right" for="hide-thumbnail">
                                                <span class="label-button-text"><?php _e('Hide', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><?php _e('Show/Hide Additional Details', 'w3nWCMS') ?></td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="show-additional" class="input-radio-button" type="radio" name="w3nmscheckout_additional_details" value="true" <?php checked(sanitize_text_field(get_option('w3nmscheckout_additional_details')), 'true', true); ?> >
                                            <label class="input-label-button label-button-left" for="show-additional">
                                                <span class="label-button-text"><?php _e('Show', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="hide-additional" class="input-radio-button" type="radio" name="w3nmscheckout_additional_details" value="false" <?php checked(sanitize_text_field(get_option('w3nmscheckout_additional_details')), 'false', true); ?>>
                                            <label class="input-label-button label-button-right" for="hide-additional">
                                                <span class="label-button-text"><?php _e('Hide', 'w3nWCMS'); ?></span>
                                            </label>  
                                        </div>
                                        <td></td>
                                        <td></td>  
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Animation', 'w3nWCMS') ?></td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="fade" class="input-radio-button" type="radio" name="w3nmscheckout_animation" value="fade" <?php checked(sanitize_text_field(get_option('w3nmscheckout_animation')), 'fade', true); ?> >
                                            <label class="input-label-button label-button-left" for="fade">
                                                <span class="label-button-text"><?php _e('Fade', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="slide" class="input-radio-button" type="radio" name="w3nmscheckout_animation" value="slide" <?php checked(sanitize_text_field(get_option('w3nmscheckout_animation')), 'slide', true); ?> >
                                            <label class="input-label-button label-button-right" for="slide">
                                                <span class="label-button-text"><?php _e('Slide', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><?php _e('Steps orientation', 'w3nWCMS') ?></td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="horizontal" class="input-radio-button" type="radio" name="w3nmscheckout_orientation" value="horizontal" <?php checked(sanitize_text_field(get_option('w3nmscheckout_orientation')), 'horizontal', true); ?> >
                                            <label class="input-label-button label-button-left" for="horizontal">
                                                <span class="label-button-text"><?php _e('Horizontal', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="vertical" class="input-radio-button" type="radio" name="w3nmscheckout_orientation" value="vertical" <?php checked(sanitize_text_field(get_option('w3nmscheckout_orientation')), 'vertical', true); ?> >
                                            <label class="input-label-button label-button-right" for="vertical">
                                                <span class="label-button-text"><?php _e('Vertical', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><?php _e('Step pagination', 'w3nWCMS') ?></td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="pagination-yes" class="input-radio-button" type="radio" name="w3nmscheckout_pagination" value="yes" <?php checked(sanitize_text_field(get_option('w3nmscheckout_pagination')), 'yes', true); ?> >
                                            <label class="input-label-button label-button-left" for="pagination-yes">
                                                <span class="label-button-text"><?php _e('Yes', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="pagination-no" class="input-radio-button" type="radio" name="w3nmscheckout_pagination" value="no" <?php checked(sanitize_text_field(get_option('w3nmscheckout_pagination')), 'no', true); ?> >
                                            <label class="input-label-button label-button-right" for="pagination-no">
                                                <span class="label-button-text"><?php _e('No', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><?php _e('Remove Numbers', 'w3nWCMS') ?></td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="number-show" class="input-radio-button" type="radio" name="w3nmscheckout_number_hide_show" value="yes" <?php checked(sanitize_text_field(get_option('w3nmscheckout_number_hide_show')), 'yes', true); ?> >
                                            <label class="input-label-button label-button-left" for="number-show">
                                                <span class="label-button-text"><?php _e('Yes', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="number-hide" class="input-radio-button" type="radio" name="w3nmscheckout_number_hide_show" value="no" <?php checked(sanitize_text_field(get_option('w3nmscheckout_number_hide_show')), 'no', true); ?> >
                                            <label class="input-label-button label-button-right" for="number-hide">
                                                <span class="label-button-text"><?php _e('No', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <td></td>
                                        <td></td>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Zip/Postcode Validation', 'w3nWCMS') ?></td>
                                    <td>
                                        <div class="radiogroup">
                                            <input id="postcode-yes" class="input-radio-button" type="radio" name="w3nmscheckout_postcode_validation" value="yes" <?php checked(sanitize_text_field(get_option('w3nmscheckout_postcode_validation')), 'yes', true); ?> >
                                            <label class="input-label-button label-button-left" for="postcode-yes">
                                                <span class="label-button-text"><?php _e('Yes', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                        <div class="radiogroup">
                                            <input id="postcode-no" class="input-radio-button" type="radio" name="w3nmscheckout_postcode_validation" value="no" <?php checked(sanitize_text_field(get_option('w3nmscheckout_postcode_validation')), 'no', true); ?> >
                                            <label class="input-label-button label-button-right" for="postcode-no">
                                                <span class="label-button-text"><?php _e('No', 'w3nWCMS'); ?></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                            <?php
                            } else if ( 'styles' == $current ) {
                            ?>
                            <table class="form-table">
                                <input type="hidden" name="orientation" value="<?php echo esc_attr_e( get_option('w3nmscheckout_orientation') ) ?>" />
                                <tr>

                                    <td><?php _e('Steps Layout', 'w3nWCMS') ?><br /><span class="description"><?php _e('Select the step layouts', 'w3nWCMS') ?></span></td>
                                    <td>
                                        <input id="layout-boxes" class="input-radio-button" type="radio" name="w3nmscheckout_steps_style" value="boxes" <?php checked(sanitize_text_field(get_option('w3nmscheckout_steps_style')), 'boxes', true); ?> >
                                        <label class="input-label-button label-button-right" for="layout-boxes">
                                            <img src="<?php echo plugins_url('w3nuts-wc-multistep-checkout/images/style1.png' ); ?>">
                                        </label><br />
                                        <input id="layout-seperateboxes" class="input-radio-button" type="radio" name="w3nmscheckout_steps_style" value="seperateboxes" <?php checked(sanitize_text_field(get_option('w3nmscheckout_steps_style')), 'seperateboxes', true); ?> >
                                        <label class="input-label-button label-button-right" for="layout-seperateboxes">
                                            <img src="<?php echo plugins_url('w3nuts-wc-multistep-checkout/images/style2.png' ); ?>">
                                        </label><br />
                                        <input id="layout-arrow" class="input-radio-button" type="radio" name="w3nmscheckout_steps_style" value="arrow" <?php checked(sanitize_text_field(get_option('w3nmscheckout_steps_style')), 'arrow', true); ?> >
                                        <label class="input-label-button label-button-right" for="layout-arrow">
                                            <img src="<?php echo plugins_url('w3nuts-wc-multistep-checkout/images/style3.png' ); ?>">
                                        </label><br />
                                        <input id="layout-progress" class="input-radio-button" type="radio" name="w3nmscheckout_steps_style" value="progress" <?php checked(sanitize_text_field(get_option('w3nmscheckout_steps_style')), 'progress', true); ?> >
                                        <label class="input-label-button label-button-right" for="layout-progress">
                                            <img src="<?php echo plugins_url('w3nuts-wc-multistep-checkout/images/style4.png' ); ?>">
                                        </label><br />
                                        <input id="layout-style5" class="input-radio-button" type="radio" name="w3nmscheckout_steps_style" value="style5" <?php checked(sanitize_text_field(get_option('w3nmscheckout_steps_style')), 'style5', true); ?> >
                                    <label class="input-label-button label-button-right" for="layout-style5">
                                        <img src="<?php echo plugins_url('w3nuts-wc-multistep-checkout/images/style5.png' ); ?>">
                                    </label><br />
                                    <input id="layout-style6" class="input-radio-button" type="radio" name="w3nmscheckout_steps_style" value="style6" <?php checked(sanitize_text_field(get_option('w3nmscheckout_steps_style')), 'style6', true); ?> >
                                    <label class="input-label-button label-button-right" for="layout-style6">
                                        <img src="<?php echo plugins_url('w3nuts-wc-multistep-checkout/images/style6.png' ); ?>">
                                    </label><br />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="200"><?php _e('Background color for active steps', 'w3nWCMS') ?></td>
                                    <td><input name="w3nmscheckout_color_active" id="w3nmscheckout_color_active" type="text" value="<?php echo esc_attr_e(get_option('w3nmscheckout_color_active')) ?>" class="regular-text" />
                                    </td>
                                </tr>
                                <tr id="number-bgcolor">
                                    <td><?php _e('Number Background color for steps', 'w3nWCMS') ?></td>
                                    <td><input name="w3nmscheckout_color_number" id="w3nmscheckout_color_number" type="text" value="<?php echo esc_attr_e(get_option('w3nmscheckout_color_number')) ?>" class="regular-text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Background color for inactive steps', 'w3nWCMS') ?></td>
                                    <td><input name="w3nmscheckout_color_inactive" id="w3nmscheckout_color_inactive" type="text" value="<?php echo esc_attr_e(get_option('w3nmscheckout_color_inactive')) ?>" class="regular-text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Background color for completed steps', 'w3nWCMS') ?></td>
                                    <td><input name="w3nmscheckout_color_completed" id="w3nmscheckout_color_completed" type="text" value="<?php echo esc_attr_e(get_option('w3nmscheckout_color_completed')) ?>" class="regular-text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Step font color', 'w3nWCMS') ?></td>
                                    <td><input name="w3nmscheckout_color_font" id="w3nmscheckout_color_font" type="text" value="<?php echo esc_attr_e(get_option('w3nmscheckout_color_font')) ?>" class="regular-text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Buttons Color', 'w3nWCMS') ?></td>
                                    <td><input name="w3nmscheckout_color_buttons" id="w3nmscheckout_color_buttons" type="text" value="<?php echo esc_attr_e(get_option('w3nmscheckout_color_buttons')) ?>" class="regular-text" />
                                </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Buttons Font color', 'w3nWCMS') ?></td>
                                    <td><input name="w3nmscheckout_color_buttons_font" id="w3nmscheckout_color_buttons_font" type="text" value="<?php echo esc_attr_e(get_option('w3nmscheckout_color_buttons_font')) ?>" class="regular-text" />
                                    </td>
                                </tr>                                
                            </table>                            
                            <div class="preview-window" >
                                <!-- <p>Preview Changes</p> -->
                                <iframe class="b-iframe" scrolling="yes" src="<?php echo esc_url( home_url('/index.php?plugin=w3nuts-wc-multistep-checkout&action=') ) . wp_create_nonce('preview'); ?>"></iframe>
                            </div>
                            <?php
                            }
                        ?>
                            <table class="form-table">
                                <tr>
                                    <td><?php _e('Restore Plugin Defaults', 'w3nWCMS') ?></td>
                                    <td>
                                        <div class="checkboxgroup">
                                            <input type="checkbox" name="w3nmsc_restore_default" value="<?php echo wp_create_nonce('w3n_yes'); ?>" id="rpd_check" />
                                            <label for="rpd_check" class="input-label-button label-button-left">
                                                <span class="label-button-text"></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        <p class="submit w3nsubmit">
                            <input type="submit" name="submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
                        </p>
                    </form>
                </div>
            </div>
        </div> 
    </div>
</div>