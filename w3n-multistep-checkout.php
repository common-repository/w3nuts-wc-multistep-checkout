<?php
/** 
 * Plugin Name:  WooCommerce Multistep Checkout by BoostPlugins
 * Plugin URI:   https://woocheckoutplugin.com/
 * Description:  The plugin allows you to easily set your checkout page to increase 				sale and best user experience in a few minutes. Fully customized and 				 allow you to set it best fit with your theme.
 * Version:      1.0.2
 * Author:       BoostPlugins
 * Author URI:   https://woocheckoutplugin.com/
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  w3nWCMS
 * Domain Path:  /languages/
 */

if ( ! defined( 'ABSPATH' ) ){
    die();
}

define("W3NWCMS_VER", "1.0.2");

/**
 * Check if WC is installed and activated or not.
 */
register_activation_hook( __FILE__, 'w3nmscheckout_is_woocommerce_active' );

function w3nmscheckout_is_woocommerce_active() {
	if ( in_array('woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {		
		add_option('w3nmscheckout_code_location', 'header');
        add_option('w3nmscheckout_login_form', 'false');
        add_option('w3nmscheckout_coupon_form', 'false');
        add_option('w3nmscheckout_billing_shipping', 'no');
        add_option('w3nmscheckout_order_detail', 'true');
        add_option('w3nmscheckout_review_order', 'true');
        add_option('w3nmscheckout_order_payment_tabs', 'no');
        add_option('w3nmscheckout_registration_form', 'false');
        add_option('w3nmscheckout_show_thumbnail', 'false');
        add_option('w3nmscheckout_animation', 'fade');
        add_option('w3nmscheckout_orientation', 'horizontal');
        add_option('w3nmscheckout_pagination', 'no');
        add_option('w3nmscheckout_number_hide_show', 'no');
        add_option('w3nmscheckout_postcode_validation', 'no');
        add_option('w3nmscheckout_additional_details','false');
        add_option( 'w3nmscheckout_coupon_placement', 'default' );
        add_option( 'w3nmscheckout_steps_style', 'boxes' );
    } else {
    	// If WC is not activated, deactivate this plugins.
    	deactivate_plugins( plugin_basename( __FILE__ ) );

        exit( 'To activate <strong>WooCommerce Multistep Checkout</strong> requires <a target="_blank" href="http://wordpress.org/plugins/woocommerce/">WooCommerce</a> plugin installed and activated.' );
    }
}

/**
 * Multilanguage support for WPML
 */
load_plugin_textdomain('w3nWCMS', false, dirname(plugin_basename(__FILE__)) . '/languages/');

/*
 * Add setting link on plugins page
 */
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'w3nmscheckout_setting_on_plugin');

function w3nmscheckout_setting_on_plugin($links) {
    if ( class_exists( 'WooCommerce' ) ) {
        return array_merge(array('settings' => '<a href="' . admin_url('admin.php?page=w3nmscheckout') . '">' . __('Settings', 'domain') . '</a>'), $links);
    } else {
        return $links;
    }
}

/**
 * Alter template load location
 */
add_filter( 'woocommerce_locate_template', 'w3nmscheckout_wc_locate_template', 999999, 3 );

function w3nmscheckout_wc_locate_template($template, $template_name, $template_path) {

    $child_path = untrailingslashit( get_stylesheet_directory() . '/w3nuts-wc-multistep-checkout/' . $template_path . $template_name );
    $theme_path = untrailingslashit( get_template_directory() . '/w3nuts-wc-multistep-checkout/' . $template_path . $template_name );
    $plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) . $template_path . $template_name );
    if ( file_exists( $child_path ) ) {
        return $child_path;
    } elseif ( file_exists( $theme_path ) ) {
        return $theme_path;
    } elseif ( file_exists( $plugin_path ) ) {
        return $plugin_path;
    } else {
        return $template;
    }
}

/* 
 * Plugins option Page as a submenu of WooCommerce menu
 */
add_action( 'admin_menu', 'w3nmscheckout_menu_page' );

function w3nmscheckout_menu_page() {
    add_submenu_page( 'woocommerce', 'WooCommerce Multistep Checkout', 'WooCommerce Multistep Checkout', 'manage_options', 'w3nmscheckout', 'w3nmscheckout_options' );
}

/**
 * Add back-end options page
 */
function w3nmscheckout_options() {
    require_once( untrailingslashit( plugin_dir_path(__FILE__) . '/inc/w3n_options.php' ) );
}

/**
 * Add necessary scripts and style sheet
 */
add_action('wp_enqueue_scripts', 'w3nmscheckout_enqueue_scripts');
function w3nmscheckout_enqueue_scripts() {
    $steps_type = get_option( 'w3nmscheckout_steps_style' );
    wp_register_script('jquery-validate', plugins_url('/js/jquery.validate.min.js', __FILE__), array('jquery'), W3NWCMS_VER);
    wp_register_script('jquery-steps', plugins_url('/js/jquery.steps.min.js', __FILE__), array('jquery', 'jquery-validate'), W3NWCMS_VER);

    if ( 'style6' == $steps_type ) {
        wp_register_style('jquery-steps', plugins_url('/css/w3nstep6.css', __FILE__), null, W3NWCMS_VER);
    } elseif ( 'style5' == $steps_type ) {
        wp_register_style('jquery-steps', plugins_url('/css/w3nstep5.css', __FILE__), null, W3NWCMS_VER);
    } elseif ( 'progress' == $steps_type ) {
        wp_register_style('jquery-steps', plugins_url('/css/w3nstep4.css', __FILE__), null, W3NWCMS_VER);
    } elseif ( 'arrow' == $steps_type ) {
        wp_register_style('jquery-steps', plugins_url('/css/w3nstep3.css', __FILE__), null, W3NWCMS_VER);
    } elseif ( 'seperateboxes' == $steps_type ) {
        wp_register_style('jquery-steps', plugins_url('/css/w3nstep2.css', __FILE__), null, W3NWCMS_VER);
    } else { // register style of boxes
        wp_register_style('jquery-steps', plugins_url('/css/w3nstep1.css', __FILE__), null, W3NWCMS_VER);
    }
    wp_register_style('jquery-steps-main', plugins_url('/css/main.css', __FILE__), null, W3NWCMS_VER);

    /** 
     * Only add on WooCommerce checkout page 
     */
    if (is_checkout()) {
        wp_enqueue_script('jquery-steps');
        wp_enqueue_script('jquery-validate');
        wp_enqueue_style('jquery-steps');
        wp_enqueue_style('jquery-steps-main');
    }
}

/**
 * Load the scripts
 */
if ( 'footer' == get_option( 'w3nmscheckout_code_location' ) ) {
    add_action( 'wp_enqueue_scripts', 'w3nmscheckout_load_scripts', 100 );
} else {
    add_action( 'wp_enqueue_scripts', 'w3nmscheckout_load_scripts', 1 );
}
function w3nmscheckout_load_scripts()
{
    $vars = array(
        'transitionEffect' => get_option( 'w3nmscheckout_animation' ) ? get_option( 'w3nmscheckout_animation' ) : 'fade',
        'stepsOrientation' => get_option( 'w3nmscheckout_orientation' ) ? get_option( 'w3nmscheckout_orientation' ) : 'horizontal',
        'enablePagination' => get_option( 'w3nmscheckout_pagination' ) ? get_option( 'w3nmscheckout_pagination' ) : 'yes',
        'next' => get_option( 'w3nmscheckout_next_button_lable' ) ? __( get_option( 'w3nmscheckout_next_button_lable' ), 'w3nWCMS' ) : __('Next', 'w3nWCMS'),
        'previous' => get_option( 'w3nmscheckout_prev_button_lable' ) ? __( get_option('w3nmscheckout_prev_button_lable' ), 'w3nWCMS' ) : __( 'Previous', 'w3nWCMS' ),
        'finish' => get_option( 'w3nmscheckout_place_order' ) ? __(get_option( 'w3nmscheckout_place_order' ), 'w3nWCMS' ) : __( 'Place Order', 'w3nWCMS' ),
        'error_msg' => get_option( 'w3nmscheckout_required_error' ) ? __( get_option( 'w3nmscheckout_required_error' ), 'w3nWCMS' ) : __( 'This field is required', 'w3nWCMS' ),
        'email_error_msg' => get_option( 'w3nmscheckout_email_error' ),
        'phone_error_msg' => get_option( 'w3nmscheckout_phone_error' ),
        'terms_error' => get_option( 'w3nmscheckout_tnc_error' ),
        'remove_numbers' => get_option( 'w3nmscheckout_number_hide_show' ),
        'zipcode_validation' => get_option( 'w3nmscheckout_postcode_validation' ),
        'zipcode_error_msg' => get_option( 'w3nmscheckout_postcode_error' ),
        'isAuthorizedUser' => get_current_user_id(),
        'loading_img' => plugins_url( '/images/animatedEllipse.gif', __FILE__ ),
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'include_login' => get_option( 'w3nmscheckout_login_form' ),
        'include_register_form' => get_option( 'w3nmscheckout_registration_form' ),
        'include_coupon_form' => get_option( 'w3nmscheckout_coupon_form' ),
        'woo_include_login' => get_option( 'woocommerce_enable_checkout_login_reminder' ),
        'no_account_btn' => get_option( 'w3nmscheckout_skip_login_label' ) ? __( stripslashes( get_option( 'w3nmscheckout_skip_login_label' ) ), 'w3nWCMS' ) : __( "Skip Login", 'w3nWCMS' ),
        'login_nonce' => wp_create_nonce( 'w3nmsc-login-nonce' ),
        'register_nonce' => wp_create_nonce( 'w3nmsc-register-nonce' ),
    );
    if ( is_checkout() ) {
        if ( 'true' == get_option( 'w3nmscheckout_code_location' ) ) {
            wp_register_script( 'w3nmsc-steps', plugins_url( '/js/steps.js', __FILE__ ), array( 'jquery-steps', 'jquery-validate' ), W3NWCMS_VER, true );
        } else {
            wp_register_script( 'w3nmsc-steps', plugins_url( '/js/steps.js', __FILE__ ), array( 'jquery-steps', 'jquery-validate' ), W3NWCMS_VER, false );
        }
        wp_enqueue_script( 'w3nmsc-steps' );
        wp_localize_script( 'w3nmsc-steps', 'w3nmsc_steps', $vars );
    }
}

/**
 * Add Color Picker
 */
add_action('admin_enqueue_scripts', 'w3nmscheckout_enqueue_color_picker');

function w3nmscheckout_enqueue_color_picker() {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker-script', plugins_url('js/admin/script.js', __FILE__), array('wp-color-picker'), false, true);
    
    wp_register_style('wp-backend-styles', plugins_url('/css/back-styles.css', __FILE__), null, W3NWCMS_VER);
    wp_enqueue_style( 'wp-backend-styles');
}

/**
 * add dynamic styles
 */
add_action('wp_head', 'w3nmscheckout_dynamic_style_options');
function w3nmscheckout_dynamic_style_options()
{
    require_once( untrailingslashit ( plugin_dir_path(__FILE__) . '/inc/w3n_dynamic_style.php' ) );
}

/**
 * Add Login, Registeration and Coupon to Step
 */
// Login to w3nSteps
$is_login_form = get_option( 'w3nmscheckout_login_form' );
$is_registration_form = get_option( 'w3nmscheckout_registration_form' );

if ( 'true' == $is_login_form && 'false' == $is_registration_form ) {
    add_action('after_setup_theme', 'w3nmscheckout_checkout_login_form');
    function w3nmscheckout_checkout_login_form() {
        if ( ! has_action('woocommerce_before_checkout_form' ) ) {
            add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
        }
    }

    add_action( 'w3nmscheckout_multistep_checkout_before', 'w3nmscheckout_login_step' );
    function w3nmscheckout_login_step() {
        if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
            return;
        }
        ?>
        <script>
            jQuery(function () {
                jQuery( ".woocommerce-info a.showlogin" ).parent().detach();
                jQuery( "form.woocommerce-form-login" ).appendTo('.login-step');
                jQuery( ".login-step form.woocommerce-form-login" ).show();
            });
        </script>    
        <h1 class="title-login-w3nSteps"><?php get_option('w3nmscheckout_login_label') ? _e( get_option('w3nmscheckout_login_label') ) : _e( 'Login', 'woocommerce' ); ?></h1>
        <div class="login-step"></div>
        <?php
    }
}

// Registration Form to w3nSteps
if ( 'true' == $is_login_form && 'true' == $is_registration_form ) {
    add_action( 'w3nmscheckout_multistep_checkout_before', 'w3nmscheckout_checkout_login_register_form' );

    function w3nmscheckout_checkout_login_register_form() {
        if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
            return;
        }
    	?>
        <h1 class="title-login-w3nSteps"><?php get_option('w3nmscheckout_login_label') ? _e( get_option('w3nmscheckout_login_label') ) : _e( 'Login', 'woocommerce' ); ?></h1>
        <div class="login-step">
            <?php 
                if ( 'yes' == get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
                    <script>
                        jQuery(function () {
                            jQuery( ".woocommerce-info a.showlogin" ).parent().detach();
                            jQuery( "#customer_login" ).appendTo( '.login-step' );
                        });
                    </script>  
                <?php else : ?>
                    <script>
                        jQuery(function () {
                            jQuery( ".woocommerce-info a.showlogin" ).parent().detach();
                            jQuery( "form.woocommerce-form-login" ).appendTo('.login-step');
                            jQuery( ".login-step form.woocommerce-form-login" ).show();
                        });
                    </script>
                <?php endif; ?>
               
        </div>
    	<?php
    }
}

// Coupon to w3nSteps 
$coupon_form = get_option( 'w3nmscheckout_coupon_form' );
$coupon_place = get_option( 'w3nmscheckout_coupon_placement' );
if ( 'true' == $coupon_form ) {    
    if ( 'yes' != get_option( 'woocommerce_enable_coupons' ) ) {
        return;
    }
    add_action( 'w3nmscheckout_multistep_checkout_before', 'w3nmscheckout_coupon_form_step', 20 );
    function w3nmscheckout_coupon_form_step() {
		?>
        <script>
            jQuery(function () {
                jQuery( ".woocommerce-info a.showcoupon" ).parent().detach();
                jQuery( "form.checkout_coupon" ).appendTo( '.coupon-step' );
                jQuery( ".coupon-step form.checkout_coupon" ).show();
            });
        </script>

        <h1 class="title-coupon-w3nSteps"><?php echo get_option( 'w3nmscheckout_coupon_label' ) ? __( get_option( 'w3nmscheckout_coupon_label' ), 'w3nWCMS' ) : __( 'Coupon', 'w3nWCMS' ); ?></h1>
        <div class="coupon-step">
            <?php if ( get_option( 'w3nmscheckout_coupon_page_title' ) ) { 
                ?>
                <h2><?php _e( get_option( 'w3nmscheckout_coupon_page_title' ), 'woocommerce' ); ?></h2>
                <hr />
                <?php
            } else { 
                ?>
                <h2><?php _e('Coupon', 'woocommerce'); ?></h2>
                <hr />
                <?php
            }
            if ( get_option('w3nmscheckout_coupon_page_text') ) {
                ?>
                <p><?php _e( get_option('w3nmscheckout_coupon_page_text'), 'woocommerce' ); ?></p>
                <?php
            } ?>
        </div>
    	<?php
    }
} elseif( 'false' == $coupon_form && 'default' == $coupon_place ) {
    // hide coupon field on checkout page
    add_filter( 'woocommerce_coupons_enabled', 'w3nmscheckout_hide_coupon_form_on_checkout' );
    function w3nmscheckout_hide_coupon_form_on_checkout( $enabled ) {
        if ( is_checkout() ) {
            $enabled = false;
        }
        return $enabled;
    }    
} else {
    add_action( 'w3nmscheckout_multistep_checkout_before', 'w3nmscheckout_coupon_form_step', 20 );
    function w3nmscheckout_coupon_form_step() {
        ?>
        <script>
            jQuery(function () {
                jQuery( ".woocommerce-info a.showcoupon" ).parent().detach();
                jQuery( "form.checkout_coupon" ).appendTo( '.coupon-step' );
                jQuery( ".coupon-step form.checkout_coupon" ).show();
            });
        </script>
        <?php 
    }
}
/**
 * Avada theme
 */
add_action( 'after_setup_theme', 'w3nmscheckout_avada' );

function w3nmscheckout_avada() {
    if ( function_exists( 'avada_woocommerce_checkout_after_customer_details' ) ) {
        remove_action( 'woocommerce_checkout_after_customer_details', 'avada_woocommerce_checkout_after_customer_details' );
    }

    if ( function_exists( 'avada_woocommerce_checkout_before_customer_details' ) ) {
        remove_action( 'woocommerce_checkout_before_customer_details', 'avada_woocommerce_checkout_before_customer_details' );
    }

    if ( class_exists( 'Avada_Woocommerce' ) ) {
        global $avada_woocommerce;
        remove_action( 'woocommerce_checkout_before_customer_details', array( $avada_woocommerce, 'checkout_before_customer_details' ) );
        remove_action( 'woocommerce_checkout_after_customer_details', array( $avada_woocommerce, 'checkout_after_customer_details' ) );
        remove_action( 'woocommerce_before_checkout_form', array( $avada_woocommerce, 'before_checkout_form' ) );
        remove_action( 'woocommerce_after_checkout_form', array( $avada_woocommerce, 'after_checkout_form' ) );
    }
}

/**
 * Stripe Apple Pay button
 */
add_action( 'init', 'w3nmscheckout_apple_pay_btn', 20 );
function w3nmscheckout_apple_pay_btn() {
    if ( class_exists( 'WC_Stripe_Apple_Pay' ) ) {
        remove_action( 'woocommerce_checkout_before_customer_details', array( WC_Stripe_Apple_Pay::instance(), 'display_apple_pay_button' ), 1 );
        remove_action( 'woocommerce_checkout_before_customer_details', array( WC_Stripe_Apple_Pay::instance(), 'display_apple_pay_separator_html' ), 1 );

        add_action( 'woocommerce_before_checkout_form', array( WC_Stripe_Apple_Pay::instance(), 'display_apple_pay_button' ), 1 );
        add_action( 'woocommerce_before_checkout_form', array( WC_Stripe_Apple_Pay::instance(), 'display_apple_pay_separator_html' ), 1 );
    }
}

/**
 * User registeration
 */
add_action( 'wp_ajax_w3nmscheckout_registration', 'w3nmscheckout_registration' );
add_action( 'wp_ajax_nopriv_w3nmscheckout_registration', 'w3nmscheckout_registration' );
function w3nmscheckout_registration() {

    check_ajax_referer('w3nmsc-register-nonce');
    $username = sanitize_user( $_POST['username'] );
    $password = trim( $_POST['password'] );
    $email = sanitize_email( $_POST['email'] );

    $form_errors = array();
    if ( empty( $email ) || ! is_email( $email ) ) {
        $form_errors[] = 'Please provide a valid email address.';
    }

    if ( email_exists( $email ) ) {
        $form_errors[] = 'The email is already registered. Please login or try another email.';
    }

    if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) || ! empty( $username ) ) {
        if ( empty( $username ) || ! validate_username( $username ) ) {
            $form_errors[] = 'Please enter a valid username or email address.';
        }

        if ( username_exists( $username ) ) {
            $form_errors[] = 'The username is already registered. Please login or choose another.';
        }
    }

    if ( empty( $password ) ) {
        $form_errors[] = 'Please enter a password.';
    }

    if ( $form_errors ) {
        echo '<ul class="register_form_error" style="color:red">';
        foreach ( $form_errors as $error ) {
            echo '<li style="margin:0 0 0 10px;list-style:disc !important"> ' . $error . '</li>';
        }
        echo '</ul>';
        exit();
    } else {
        wc_create_new_customer( $email, $username, $password );
        $creds = array();

        $creds['user_login'] = $username;
        $creds['user_password'] = $password;
        $creds['remember'] = true;
        $secure_cookie = is_ssl() ? true : false;
        
        wp_signon( apply_filters( 'woocommerce_login_credentials', $creds ), $secure_cookie );
        echo 'success';
        exit();
    }
}

/**
 * Redirect page after registration
 */
add_action( 'woocommerce_registration_redirect', 'w3nmscheckout_registration_redirect', 2 );
function w3nmscheckout_registration_redirect() {
    global $woocommerce;
    $checkout_url = $woocommerce->cart->get_checkout_url();
    $get_reffer = wp_get_raw_referer();

    if ( preg_match( '#' . $get_reffer . '#', $checkout_url ) ) {
        wp_safe_redirect( $checkout_url );
        exit();
    } else {
        wp_safe_redirect( wp_get_referer() ? wp_get_referer() : wc_get_page_permalink( 'myaccount' ) );
    }
}

/**
 * Login
 */
add_action('wp_ajax_w3nmscheckout_login', 'w3nmscheckout_user_login');
add_action('wp_ajax_nopriv_w3nmscheckout_login', 'w3nmscheckout_user_login');

function w3nmscheckout_user_login() {
    check_ajax_referer( 'w3nmsc-login-nonce' );
    if ( is_email( sanitize_user( $_POST['username'] ) ) && apply_filters( 'woocommerce_get_username_from_email', true ) ) {
        $user = get_user_by( 'email', sanitize_email( $_POST['username'] ) );

        if ( isset( $user->user_login ) ) {
            $creds['user_login'] = $user->user_login;
        }
    } else {
        $creds['user_login'] = $_POST['username'];
    }

    $creds['user_password'] = trim( $_POST['password'] );
    $creds['remember'] = $_POST['rememberme'];
    $secure_cookie = is_ssl() ? true : false;
    $user = wp_signon( apply_filters( 'woocommerce_login_credentials', $creds ), $secure_cookie );

    if ( is_wp_error( $user ) ) {
        echo '<p class="error-msg">' . __( 'Incorrect username/password.', 'w3nmscheckout' ) . ' </p>';
    } else {
        echo 'successfully';
    }
    exit();
}

/**
 * Zip/Post code validation
 */
add_action('wp_ajax_zip_validation', 'w3nmscheckout_zip_validation');
add_action('wp_ajax_nopriv_zip_validation', 'w3nmscheckout_zip_validation');
function w3nmscheckout_zip_validation()
{
    $country = trim( $_POST['country'] );
    $postCode = strtoupper( str_replace( ' ', '', trim( $_POST['postCode'] ) ) );
    echo WC_Validation::is_postcode( $postCode, $country );
    exit();
}

/**
 * Hide / Show Additional details
 */
if ( 'false' == get_option('w3nmscheckout_additional_details') ) {
    add_filter('woocommerce_enable_order_notes_field', '__return_false');
}

/**
 * Order review & Customer reivew
 */
add_action( 'w3nmscheckout_order_customer_review', 'w3nmscheckout_order_customer_review' );
function w3nmscheckout_order_customer_review() {
    ?>
    <div class="w3nmsc-order-review-step">
        <div class="w3nmsc-customer-review">
            <div class="w3nmsc-customer-details">
                <h3><?php _e('Customer Details', 'w3nWCMS'); ?></h3>
                <ul class="w3nmsc-customer-list">
                    <li>
                        <div class="w3nmsc-customer-detail"><?php _e('Email:', 'w3nWCMS'); ?></div>
                        <div class="w3nmsc-customer-email"></div>
                    </li>
                    <li>
                        <div class="w3nmsc-customer-detail"><?php _e('Phone:', 'w3nWCMS'); ?></div>
                        <div class="w3nmsc-customer-phone"></div>
                    </li>
                </ul>
            </div>
            
            <div class="w3nmsc-customer-addresses">
                <div class = "w3nmsc-billing-details">
                    <h3><?php _e('Billing Address', 'w3nWCMS'); ?></h3>
                    <div class="w3nmsc-billing-address"></div>
                </div>
                
                <div class = "w3nmsc-shipping-details">
                    <h3><?php _e('Shipping Address', 'w3nWCMS'); ?></h3>
                    <div class="w3nmsc-shipping-address"></div>
                </div>
            </div>
        </div>
    </div>
    <?php 
}

// add_action('init', 'w3nmscheckout_parse_request');
add_action('parse_request', 'w3nmscheckout_parse_request');
function w3nmscheckout_parse_request() {	    
    if( isset( $_REQUEST['action'] ) && wp_verify_nonce( $_REQUEST['action'], 'preview' ) ){
        @header("Content-Type: text/html; charset=utf-8");
        @header("Cache-Control: no-cache, must-revalidate, max-age=0");
        require( untrailingslashit( WP_PLUGIN_DIR . '/w3nuts-wc-multistep-checkout/view/w3n_step_preveiw.php' ) );
        exit;	    
    }
}