/**
 * Add color picker in back end options
 */
var main_url=jQuery("iframe.b-iframe").attr("src");jQuery("#number-bgcolor").hide(),jQuery(document).ready(function(){jQuery("#layout-seperateboxes").is(":checked")&&jQuery("#number-bgcolor").show(),jQuery("#w3nmscheckout_color_active, #w3nmscheckout_color_inactive, #w3nmscheckout_color_completed, #w3nmscheckout_color_font, #w3nmscheckout_color_buttons, #w3nmscheckout_color_buttons_font, #w3nmscheckout_color_number").wpColorPicker(),url=main_url+"&"+jQuery("#options_form").serialize(),jQuery("iframe.b-iframe").attr("src",url)}),jQuery('input[name="w3nmscheckout_steps_style"]').change(function(){jQuery("#layout-seperateboxes").is(":checked")?jQuery("#number-bgcolor").show():jQuery("#number-bgcolor").hide(),url=main_url+"&"+jQuery("#options_form").serialize(),jQuery("iframe.b-iframe").attr("src",url)});var myOptions={change:function(r,e){url=main_url+"&"+jQuery("#options_form").serialize(),jQuery("iframe.b-iframe").attr("src",url)},clear:function(r){url=main_url+"&"+jQuery("#options_form").serialize(),jQuery("iframe.b-iframe").attr("src",url)}};jQuery("#w3nmscheckout_color_active, #w3nmscheckout_color_inactive, #w3nmscheckout_color_completed, #w3nmscheckout_color_font, #w3nmscheckout_color_buttons, #w3nmscheckout_color_buttons_font, #w3nmscheckout_color_number").wpColorPicker(myOptions);