/**
 * WooCommerce Mustistep Checkout by BoostPlugins
 */
jQuery(document).ready(function ($) {
    $(".w3nmsc-loading-img").block({
        message: null,
        overlayCSS: {
            background: '#fff',
            opacity: 0.6
        }
    });
    jQuery('form.checkout').show();
    jQuery("form.checkout .validate-required :input").attr("required", "required");
    jQuery("form.checkout .validate-email .input-text").addClass("email");

    if (w3nmsc_steps.isAuthorizedUser == false && w3nmsc_steps.include_login != "false" && w3nmsc_steps.woo_include_login != "no") {
        var nextButtonTitle = w3nmsc_steps.no_account_btn
    } else {
        var nextButtonTitle = w3nmsc_steps.next
    }
    var nextButtonTitle

    if (w3nmsc_steps.remove_numbers == 'yes') {
        jQuery("#w3nSteps").steps({
            transitionEffect: w3nmsc_steps.transitionEffect,
            stepsOrientation: w3nmsc_steps.stepsOrientation,
            enableAllSteps: false,
            enablePagination: w3nmsc_steps.enablePagination,
            titleTemplate: '#title#',
            labels: {
                next: nextButtonTitle,
                previous: w3nmsc_steps.previous,
                finish: w3nmsc_steps.finish
            },
            onInit: function (event, current) {
                $(".w3nmsc-loading-img").hide();
                $('.actions > ul > li:first-child').attr('style', 'display:none');
            },
            onStepChanging: function (event, currentIndex, newIndex) {
                /* Your custom event handler here. Useful for form valiation */
                if (!orderReviewStepHasTable){
                    drawReviewTable();
                }
                setCustomerDetailsReview();                
                $(this).trigger("onStepChanging", [a = event, b = currentIndex, c = newIndex]);

                if ((currentIndex == 0 && w3nmsc_steps.isAuthorizedUser == false && w3nmsc_steps.include_login != "false" && w3nmsc_steps.woo_include_login != "no") || currentIndex > newIndex || isCouponForm()) {
                    return true
                } else {
                    return validate_checkoutform();
                }
            },
            onStepChanged: function (event, currentIndex, priorIndex) {
                //Add your custom event handler                
                $(this).trigger("onStepChanged", [a = event, b = currentIndex, c = priorIndex]);

                if (currentIndex > 0) {
                    $('.actions > ul > li:first-child').attr('style', '');
                } else {
                    $('.actions > ul > li:first-child').attr('style', 'display:none');
                }
                if (currentIndex == 0 && w3nmsc_steps.isAuthorizedUser == false && w3nmsc_steps.include_login != "false" && w3nmsc_steps.woo_include_login != "no") {
                    jQuery('form.checkout a[href="#next"]').html(w3nmsc_steps.no_account_btn);
                    jQuery('form.checkout a[href="#previous"]').hide();
                } else {
                    jQuery('form.checkout a[href="#next"]').html(w3nmsc_steps.next);
                    jQuery('form.checkout a[href="#previous"]').show();
                }
            },
            onFinishing: function (event, currentIndex) {
                $(this).trigger('onFinishing');
            }
        });
    } else {
        jQuery("#w3nSteps").steps({
            transitionEffect: w3nmsc_steps.transitionEffect,
            stepsOrientation: w3nmsc_steps.stepsOrientation,
            enableAllSteps: false,
            enablePagination: w3nmsc_steps.enablePagination,
            titleTemplate: '<span class="number">#index#.</span><span class="namebox">#title#</span>',
            labels: {
                next: nextButtonTitle,
                previous: w3nmsc_steps.previous,
                finish: w3nmsc_steps.finish
            },
            onInit: function (event, current) {
                $(".w3nmsc-loading-img").hide();
                $('.actions > ul > li:first-child').attr('style', 'display:none');
            },
            onStepChanging: function (event, currentIndex, newIndex) {
                /* Your custom event handler here. Useful for form valiation */
                if (!orderReviewStepHasTable){
                    drawReviewTable();
                }
                setCustomerDetailsReview();

                $(this).trigger("onStepChanging", [a = event, b = currentIndex, c = newIndex]);
                if ((currentIndex == 0 && w3nmsc_steps.isAuthorizedUser == false && w3nmsc_steps.include_login != "false" && w3nmsc_steps.woo_include_login != "no") || currentIndex > newIndex || isCouponForm()) {
                    return true
                } else {
                    return validate_checkoutform();
                }
            },
            onStepChanged: function (event, currentIndex, priorIndex) {
                /* Add your customer event Handler */
                $(this).trigger("onStepChanged", [a = currentIndex, b = currentIndex, c = priorIndex]);

                if (currentIndex > 0) {
                    $('.actions > ul > li:first-child').attr('style', '');
                } else {
                    $('.actions > ul > li:first-child').attr('style', 'display:none');
                }
                if (currentIndex == 0 && w3nmsc_steps.isAuthorizedUser == false && w3nmsc_steps.include_login != "false" && w3nmsc_steps.woo_include_login != "no") {
                    jQuery('form.checkout a[href="#next"]').html(w3nmsc_steps.no_account_btn);
                    jQuery('form.checkout a[href="#previous"]').hide();
                } else {
                    jQuery('form.checkout a[href="#next"]').html(w3nmsc_steps.next);
                    jQuery('form.checkout a[href="#previous"]').show();
                }
            },
            onFinishing: function (event, currentIndex) {
                $(this).trigger('onFinishing');
            }
        });
    }

    var orderReviewStepHasTable = jQuery('.w3nmsc-order-review-step').find('.woocommerce-checkout-review-order-table').length;
    function drawReviewTable() {
        var argmcOrderTable = jQuery('.woocommerce-checkout-review-order-table').first().clone();
        jQuery(argmcOrderTable).removeClass('woocommerce-checkout-review-order-table').addClass('review-table');  
        //find selected shipping method and add it to the order review table
        var argmcShippingMethod = '';
        if (jQuery(argmcOrderTable).find('td[data-title="Shipping"]').length) { 
            if (jQuery(argmcOrderTable).find("#shipping_method").length) {
                argmcShippingMethod = jQuery(argmcOrderTable).find('.shipping_method:checked').siblings('label').text();
            } else {
                argmcShippingMethod = jQuery(argmcOrderTable).find('td[data-title="Shipping"]').text();
            }                        
            jQuery(argmcOrderTable).find('td[data-title="Shipping"]').empty().text(argmcShippingMethod);
        }
        jQuery('.w3nmsc-review-order-details').html(argmcOrderTable);
    }
    function setCustomerDetailsReview() {
        
        //Set billing details object
        var w3nmscBillingDetails = {
            firstName: jQuery("#billing_first_name").length ? jQuery("#billing_first_name").val() : '',
            lastName: jQuery("#billing_last_name").length ? jQuery("#billing_last_name").val() : '',
            company : jQuery("#billing_company").length ? jQuery("#billing_company").val() : '',
            email: jQuery("#billing_email").length ? jQuery("#billing_email").val() : '',
            phone: jQuery("#billing_phone").length ? jQuery("#billing_phone").val() : '',
            country: jQuery("#billing_country").length ? jQuery("#billing_country option:selected").text() : '',
            state: jQuery("#billing_state").length ? (jQuery("#billing_state").is("select") ? jQuery("#billing_state option:selected").text() : jQuery("#billing_state").val()) : '',
            city: jQuery("#billing_city").length ? jQuery("#billing_city").val() : '',
            firstAddress: jQuery("#billing_address_1").length ? jQuery("#billing_address_1").val() : '',
            secondAddress: jQuery("#billing_address_2").length ? jQuery("#billing_address_2").val() : '',
            zipcode: jQuery("#billing_postcode").length ? jQuery("#billing_postcode").val() : ''
        };
        var w3nmscBillingAddress = '';
        
        //First Name & Last Name
        if ((w3nmscBillingDetails.firstName != '') || (w3nmscBillingDetails.lastName != '')) {
            w3nmscBillingAddress = w3nmscBillingDetails.firstName + ' ' + w3nmscBillingDetails.lastName + '<br>';
        }
            
        // Company   
        if (w3nmscBillingDetails.company != '') {
            w3nmscBillingAddress += w3nmscBillingDetails.company + '<br>';
        }

        // First Address
        if (w3nmscBillingDetails.firstAddress != '') {
            w3nmscBillingAddress += w3nmscBillingDetails.firstAddress + '<br>';
        }
        
        // Second Address
        if (w3nmscBillingDetails.secondAddress != '') {
            w3nmscBillingAddress += w3nmscBillingDetails.secondAddress + '<br>';
        }
        
        // City
        if (w3nmscBillingDetails.city != '') {
            w3nmscBillingAddress += w3nmscBillingDetails.city + ', ';
        }
        
        // State
        if (w3nmscBillingDetails.state != '') {
            w3nmscBillingAddress += w3nmscBillingDetails.state + ' ';
        }
        
        // Zipcode
        if (w3nmscBillingDetails.zipcode != '') {
            w3nmscBillingAddress += w3nmscBillingDetails.zipcode;
        }
        
        // Country
        if (w3nmscBillingDetails.country != '') {
            w3nmscBillingAddress += '<br>' + w3nmscBillingDetails.country;
        }
        
        //Billing Address                         
        jQuery('.w3nmsc-billing-address').html(w3nmscBillingAddress);
        
        //Email
        jQuery('.w3nmsc-customer-email').html(w3nmscBillingDetails.email);
        
        //Phone
        jQuery('.w3nmsc-customer-phone').html(w3nmscBillingDetails.phone);
        
        //If Email is Unset
        if (!jQuery("#billing_email").length) {
            jQuery('.w3nmsc-customer-details li').first().remove();
        }
        
        //If Phone is Unset
        if (!jQuery("#billing_phone").length) {
            jQuery('.w3nmsc-customer-details li').last().remove();
        }
        
        //If Email and Phone are Unset
        if (!jQuery("#billing_email").length && !jQuery("#billing_phone").length) {
            jQuery('.w3nmsc-customer-details').remove();
        }
        
        //Set shipping details object
        if (jQuery("#ship-to-different-address-checkbox").is(":checked")) {
            
            //shipping details
            var w3nmscSpippingDetails = {
                firstName: jQuery("#shipping_first_name").length ? jQuery("#shipping_first_name").val() : '',
                lastName: jQuery("#shipping_last_name").length ? jQuery("#shipping_last_name").val() : '',
                company : jQuery("#shipping_company").length ? jQuery("#shipping_company").val() : '',
                country: jQuery("#shipping_country").length ? jQuery("#shipping_country option:selected").text() : '',
                state: jQuery("#shipping_state").length ? (jQuery("#shipping_state").is("select") ? jQuery("#shipping_state option:selected").text() : jQuery("#shipping_state").val()) : '',
                city: jQuery("#shipping_city").length ? jQuery("#shipping_city").val() : '',
                firstAddress: jQuery("#shipping_address_1").length ? jQuery("#shipping_address_1").val() : '',
                secondAddress: jQuery("#shipping_address_2").length ? jQuery("#shipping_address_2").val() : '',
                zipcode: jQuery("#shipping_postcode").length ? jQuery("#shipping_postcode").val() : ''
            };          
            
            var w3nmscShippingAddress = '';
                    
            //First Name & Last Name
            if ((w3nmscSpippingDetails.firstName != '') || (w3nmscSpippingDetails.lastName != '')) {
                w3nmscShippingAddress = w3nmscSpippingDetails.firstName + ' ' + w3nmscSpippingDetails.lastName + '<br>';
            }
                
            // Company   
            if (w3nmscSpippingDetails.company != '') {
                w3nmscShippingAddress += w3nmscSpippingDetails.company + '<br>';
            }
    
            // First Address
            if (w3nmscSpippingDetails.firstAddress != '') {
                w3nmscShippingAddress += w3nmscSpippingDetails.firstAddress + '<br>';
            }
            
            // Second Address
            if (w3nmscSpippingDetails.secondAddress != '') {
                w3nmscShippingAddress += w3nmscSpippingDetails.secondAddress + '<br>';
            }
            
            // City
            if (w3nmscSpippingDetails.city != '') {
                w3nmscShippingAddress += w3nmscSpippingDetails.city + ', ';
            }
            
            // State
            if (w3nmscSpippingDetails.state != '') {
                w3nmscShippingAddress += w3nmscSpippingDetails.state + ' ';
            }
            
            // Zipcode
            if (w3nmscSpippingDetails.zipcode != '') {
                w3nmscShippingAddress += w3nmscSpippingDetails.zipcode;
            }
            
            // Country
            if (w3nmscSpippingDetails.country != '') {
                w3nmscShippingAddress += '<br>' + w3nmscSpippingDetails.country;
            }
            
                
            //Shipping Address
            jQuery('.w3nmsc-shipping-address').html(w3nmscShippingAddress);            
                   
        } else {
            //Shipping Address
            jQuery(".w3nmsc-shipping-address").html(w3nmscBillingAddress);
        }
    }

    jQuery.extend(jQuery.validator.messages, {
        required: w3nmsc_steps.error_msg,
        email: w3nmsc_steps.email_error_msg
    });

    jQuery(".actions > ul li:last a").addClass("finish-btn");

    /**
     * Place an order
     */
    jQuery(".finish-btn").click(function () {
        jQuery("#place_order").trigger("click");
    });

    //add class based on step
    var total_steps = jQuery("#w3nSteps ul[role='tablist'] > li").length;
    if (total_steps == 5) {
        jQuery("#w3nSteps").addClass("five-steps");
    }

    if (total_steps == 3) {
        jQuery("#w3nSteps").addClass("three-steps");
    }

    /*** Adjustments of Tab Width **/
    if (w3nmsc_steps.stepsOrientation != "vertical") {
        var total_steps = jQuery("#w3nSteps ul[role='tablist'] > li").length;
        var step_width = 100 / total_steps;
        $("#w3nSteps .steps ul li").css("width", step_width + "%");
    }

    if (w3nmsc_steps.zipcode_validation == 'yes') {
        jQuery('body').on('change', '#billing_country', function () {
            if (jQuery("#billing_country").is(":visible")) {
                checkPostCode('billing');
            }
        });

        jQuery('body').on('blur', '#billing_postcode', function ()
        {
            if (jQuery("#billing_postcode").is(":visible")) {
                checkPostCode('billing');
            }
        });

        jQuery('body').on('change', '#shipping_country', function ()
        {
            if (jQuery("#shipping_country").is(":visible")) {
                checkPostCode('shipping');
            }
        });

        jQuery('body').on('blur', '#shipping_postcode', function ()
        {
            if (jQuery("#shipping_postcode").is(":visible")) {
                checkPostCode('shipping');
            }
        });
    }

    function checkPostCode(type) {

        result = jQuery(".form-row#" + type + "_postcode_field").length > 0 && jQuery("#" + type + "_postcode").val() != false
                && jQuery("#" + type + "_country").length > 0 && jQuery("#" + type + "_country").val() != false;

        if (result) {

            var data = {
                action: 'zip_validation',
                country: jQuery("#" + type + "_country").val(),
                postCode: jQuery("#" + type + "_postcode").val()
            };

            $("#w3nSteps").block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });

            jQuery.post(w3nmsc_steps.ajaxurl, data, function (response) {
                $("#w3nSteps").unblock();
                if (response == false) {
                    jQuery("#" + type + "_postcode").parent().removeClass("woocommerce-validated").addClass("woocommerce-invalid woocommerce-invalid-required-field");
                    jQuery("#" + type + "_postcode").append('<label class="error-class">' + w3nmsc_steps.zipcode_error_msg + '</label>');
                    return false;
                } else {
                    jQuery("#" + type + "_postcode").find('label.error-class').remove();
                    return true;
                }
            });
        }
    }

    //validate checkout form
    function validate_checkoutform() {
        //       
        var form_valid = false;
        //jQuery("#w3nSteps").validate().settings.ignore = ":disabled,:hidden";

        if (jQuery('form.checkout').valid()) {
            form_valid = true;
        }

        if (w3nmsc_steps.isAuthorizedUser == false) {
            if ($("#shipping_state_field").is(":visible")) {
                if ($("#shipping_state").is(['required'])) {
                    if (!$("#shipping_state_field").hasClass("woocommerce-validated")) {
                        if (!$('#shipping_state_field').has('label.error-class').length) {
                            $("#s2id_shipping_state").addClass("invalid-state");
                            $('#shipping_state_field').append('<label class="error-class">' + w3nmsc_steps.error_msg + '</label>');
                        }
                        form_valid = false
                    } else {
                        $('#shipping_state_field').find('label.error-class').remove();
                        $("#s2id_shipping_state").removeClass("invalid-state");
                    }
                }

            }

            if ($("#billing_state_field").is(":visible")) {
                if ($("#billing_state").is(['required'])) {
                    if (!$("#billing_state_field").hasClass("woocommerce-validated")) {
                        if (!$('#billing_state_field').has('label.error-class').length) {
                            $("#s2id_billing_state").addClass("invalid-state");
                            $('#billing_state_field').append('<label class="error-class">' + w3nmsc_steps.error_msg + '</label>');
                        }
                        form_valid = false
                    } else {
                        $('#billing_state_field').find('label.error-class').remove();
                        $("#s2id_billing_state").removeClass("invalid-state");
                    }
                }

            }
        }

        if (w3nmsc_steps.isAuthorizedUser) {
            if ($("#billing_state_field").is(":visible")) {
                if ($("#billing_state").is(['required'])) {
                    if ($.trim($("#billing_state").val()) == "") {
                        $("#s2id_billing_state").addClass("invalid-state");
                        if (!$("#billing_state_field").has(".error-class").length) {
                            if (!$("#billing_state_field").has("label.error").length && !$("#billing_state_field label.error").is(":visible")) {
                                $('#billing_state_field').append('<label class="error-class">' + w3nmsc_steps.error_msg + '</label>');
                            }
                        }
                        form_valid = false
                    } else {
                        $('#billing_state_field').find('label.error-class').remove();
                        $("#s2id_billing_state").removeClass("invalid-state");
                    }
                }

            }

            if ($("#shipping_state_field").is(":visible")) {
                if ($("#shipping_state").is(['required'])) {
                    if ($.trim($("#shipping_state").val()) == "") {
                        $("#s2id_shipping_state").addClass("invalid-state");
                        if (!$("#shipping_state_field").has("label.error").length && !$("#shipping_state_field label.error").is(":visible")) {
                            $('#shipping_state_field').append('<label class="error-class">' + w3nmsc_steps.error_msg + '</label>');
                        }
                        form_valid = false
                    }
                } else {
                    $('#shipping_state_field').find('label.error-class').remove();
                    $("#s2id_shipping_state").removeClass("invalid-state");
                }
            }
        }

        if (w3nmsc_steps.zipcode_validation == 'yes') {
            if (jQuery("#billing_postcode").closest("#billing_postcode_field").hasClass("woocommerce-invalid")) {

                form_valid = false;
            }
        }

        if (w3nmsc_steps.zipcode_validation == 'yes') {
            if (jQuery("#ship-to-different-address-checkbox").is(":checked") && jQuery("#ship-to-different-address-checkbox").is(":visible")) {
                if (!jQuery("#shipping_postcode").closest("#shipping_postcode_field").hasClass("woocommerce-validated")) {

                    form_valid = false;
                }
            }
        }
        //Valite terms and conditions
        if (!validate_terms()) {
            form_valid = false;
        }
        ;
        return form_valid;
    }

    /*** 
     * When Login form is submitted
     */
    jQuery(document).on('click', '#w3nSteps form.login .button, #w3nSteps .woocommerce-form-login .button', function (evt)
    {
        if (w3nmsc_steps.include_login != "false") {
            evt.preventDefault();
            var form = 'form.login';
            var error = false;

            if (jQuery(form + ' input#username').val() == false) {
                error = true;
                addRequiredClasses('username');
            }

            if (jQuery(form + ' input#password').val() == false) {
                error = true;
                addRequiredClasses('password');
            }

            if (error == true) {
                jQuery('form.login').prepend('<p class="error-msg">Required username/password.</p>');
                return false;
            }

            var formSelector = this;

            if (jQuery(form + ' input#rememberme').is(':checked') == false) {
                rememberme = false;
            } else {
                rememberme = true;
            }

            $("#w3nSteps").block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });

            var data = {
                action: 'w3nmscheckout_login',
                username: jQuery(form + ' input#username').val(),
                password: jQuery(form + ' input#password').val(),
                rememberme: rememberme,
                _ajax_nonce: w3nmsc_steps.login_nonce
            };

            jQuery.post(w3nmsc_steps.ajaxurl, data, function (response) {
                jQuery("#w3nSteps").unblock();
                if (response == 'successfully') {
                    location.reload();
                } else {
                    if (!jQuery("form.login > .error-msg").length) {
                        jQuery('form.login').prepend(response);
                    }
                }
            })
        }
    });

    /***
     * User Registeration On Checkout
     */
    jQuery(document).on('click', '#w3nSteps form.register .button', function (evt) {
        evt.preventDefault();

        $("#w3nSteps").block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });

        var data = {
            action: 'w3nmscheckout_registration',
            username: jQuery.trim(jQuery("#reg_username").val()),
            email: jQuery.trim(jQuery("#reg_email").val()),
            password: jQuery.trim(jQuery("#reg_password").val()),
            _ajax_nonce: w3nmsc_steps.register_nonce
        };

        jQuery.post(w3nmsc_steps.ajaxurl, data, function (response) {
            $("#w3nSteps").unblock();
            if (response == 'success') {
                location.reload();
            } else {
                jQuery(".register_form_error").remove();
                jQuery("form.register").prepend(response);
            }
        })
    });

    function addRequiredClasses(selector) {
        jQuery('form.login input#' + selector).parent().removeClass("woocommerce-validated");
        jQuery('form.login input#' + selector).parent().addClass("woocommerce-invalid woocommerce-invalid-required-field");
        jQuery('form.login input#' + selector).parent().addClass("validate-required");
    }  

    jQuery("#billing_phone").on('blur input change', function () {
        if (jQuery("#billing_phone").length) {
            if (jQuery(this).prop('required')) {
                var phone = jQuery('#billing_phone').val();
                phone = phone.replace(/[\s\#0-9_\-\+\(\)]/g, '');
                phone = jQuery.trim(phone);

                if (jQuery(this).val() != "") {
                    jQuery("#billing_phone").next("label.error").remove();
                }
                if (phone.length > 0) {
                    jQuery("#billing_phone_field").removeClass("woocommerce-validated").addClass("woocommerce-invalid woocommerce-invalid-required-field");
                    if (!jQuery('#billing_phone_field').has('label.error-class').length) {
                        jQuery('#billing_phone_field').append('<label class="error-class">' + w3nmsc_steps.phone_error_msg + '</label>');
                    }
                } else {

                    if (jQuery('#billing_phone_field').has('label.error-class').length) {
                        jQuery('#billing_phone').next().remove();
                    }
                }
            }
        }
    });
    // Email validation
    jQuery("#billing_email").on('blur input change', function () {
        if (jQuery("#billing_email").length) {
            if (jQuery(this).val() != "") {
                jQuery("#billing_email").next("label.error").remove();
            }
            if ( jQuery("#billing_email_field").hasClass("woocommerce-invalid-email") ) {
                jQuery('#billing_email_field').append('<label id="billing_email-error" class="error" for="billing_email">' + w3nmsc_steps.email_error_msg + '</label>');
            } else {
                if (jQuery('#billing_email_field').has('label.error-class').length) {
                    jQuery('#billing_email').next().remove();
                }
            }
        }
    });

    jQuery(document).ajaxComplete(function(event,xhr,settings) {
        var str = settings.url.split("=");
        if( str[1] == "update_order_review" && !orderReviewStepHasTable ) {
            drawReviewTable();
        }
    });

    function isCouponForm() {
        validate = false;
        if (jQuery("#w3nSteps div.current").find("form.checkout_coupon").length) {
            validate = true;
        }
        return validate;
    }

    /**Disable form submission through Keyboard enter **/
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $("form.checkout").submit(function (evt) {
        if (jQuery(".terms-error").is(":visible")) {
            evt.preventDefault();
            evt.stopImmediatePropagation();
        }

    });

    /**
     * Manipulate couopon form for Validatation purposes. Just because we don't need nested forms
     * @returns 
     */
    function manipulate_coupon_form() {
        if (jQuery(".coupon-step").hasClass("current")) {
            if (w3nmsc_steps.transitionEffect === 'fade') {
                jQuery("form.checkout_coupon").appendTo('.coupon-step').fadeIn(100);
            } else {
                jQuery("form.checkout_coupon").appendTo('.coupon-step').slideDown(100);
            }
        }
    }

    /**
     * Manipulate login form for Validatation purposes. Just because we don't need nested forms
     * @returns 
     */

    function manipulate_login_form() {
        //if register form is included
        if (jQuery(w3nmsc_steps.include_register_form == 'true')) {
            target_form = "#customer_login";
        } else {
            target_form = "form.woocommerce-form-login";
        }

        if (jQuery(".login-step").hasClass("current")) {
            if (w3nmsc_steps.transitionEffect == 'fade') {
                jQuery(target_form).appendTo('.login-step').fadeIn(100);
            } else {
                jQuery(target_form).appendTo('.login-step').slideDown(100);
            }

        } else {
            //Move login form to temp location....Just for validation
            if (jQuery(".login-step").length) {
                jQuery(target_form).hide().appendTo('.container-coupon-login-form');
            }
        }
    }

    function validate_terms() {
        var validate_form = true;
        if (jQuery('input[name="legal"]').length && jQuery('input[name="legal"]').is(":visible")) {
            if (jQuery('input[name="legal"]').is(":checked")) {
                jQuery('input[name="legal"]').parent().removeAttr("style");
                jQuery(".terms-error").remove();
                validate_form = true;
            } else {
                jQuery('input[name="legal"]').attr("required", "required");
                jQuery('.terms').css('border', '1px solid #8a1f11');
                if (!$(".terms-error").length) {
                    jQuery('<p class="terms-error">' + w3nmsc_steps.terms_error + '</p>').insertAfter(".wc-terms-and-conditions");
                }
                validate_form = false;
            }
        }
        if (jQuery('input[name="terms"]').length && jQuery('input[name="terms"]').is(":visible")) {
            if (jQuery('input[name="terms"]').is(":checked")) {
                jQuery('input[name="terms"]').parent().removeAttr("style");
                jQuery(".terms-error").remove();
                validate_form = true;
            } else {
                jQuery('input[name="terms"]').attr("required", "required");
                jQuery('input[name="terms"]').parent().css('border', '1px solid #8a1f11');
                if (!$(".terms-error").length) {
                    jQuery('<p class="terms-error">' + w3nmsc_steps.terms_error + '</p>').insertAfter(".wc-terms-and-conditions");
                }
                validate_form = false;
            }
        }
        return validate_form;
    }

    /*** Manipulation of Coupon and login form, just becuase validaiton don't work on nested forms**/
    jQuery("#w3nSteps").on('onStepChanged', function (event, currentIndex, priorIndex) {
        manipulate_coupon_form();
        manipulate_login_form();
    });

    /***
     * Handling terms and contions on the final step
     */
    jQuery("#w3nSteps").on('onFinishing', function () {
        validate_terms();
    });


    /**
     * Register and Login hide / show 
     */    
    jQuery(document).ready(function(){
        jQuery("#hide-register").hide();
        jQuery("#w3n-login").hide();
        var delay = 500;
        jQuery("#w3n-register").click(function(){
            jQuery("#w3n-register").hide();
            jQuery("#hide-register").slideDown(delay);
            jQuery("#hide-login").slideUp(delay);
            setTimeout(function(){
                jQuery("#w3n-login").show()
            },delay+1);            
        });
        jQuery("#w3n-login").click(function(){            
            jQuery("#w3n-login").hide();            
            jQuery("#hide-login").slideDown(delay);
            jQuery("#hide-register").slideUp(delay);
            setTimeout(function(){
                jQuery("#w3n-register").show()
            },delay+1);            
        });
    });
});