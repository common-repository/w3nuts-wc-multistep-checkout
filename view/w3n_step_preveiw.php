<?php
/**
 * Preview Template
 */
$orientation = sanitize_text_field ( $_REQUEST['orientation'] );
$style = $_REQUEST['w3nmscheckout_steps_style'] ;
$bgactive = $_REQUEST['w3nmscheckout_color_active'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_active'] ) : sanitize_hex_color ( '#2BA813' );
$bgdisabled = $_REQUEST['w3nmscheckout_color_inactive'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_inactive'] ) : sanitize_hex_color ( '#777777' );
$bgdone = $_REQUEST['w3nmscheckout_color_completed'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_completed'] ) : sanitize_hex_color ( '#2BA813' );
$fontcolor = $_REQUEST['w3nmscheckout_color_font'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_font'] ) : sanitize_hex_color ( '#2BA813' );
$btncolor = $_REQUEST['w3nmscheckout_color_buttons'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_buttons'] ) : sanitize_hex_color ( '#2BA813' );
$btnfontcolor = $_REQUEST['w3nmscheckout_color_buttons_font'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_buttons_font'] ) : sanitize_hex_color ( '#fff' );
$css = 'w3nstep1.css';
if( 'style6' == $style ) {
    $css = 'w3nstep6.css';
} elseif( 'style5' == $style ) {
    $css = 'w3nstep5.css';
} elseif( 'progress' == $style ) {
    $css = 'w3nstep4.css';
} elseif( 'arrow' == $style ) {
    $css = 'w3nstep3.css';
} elseif( 'seperateboxes' == $style ) {
    $css = 'w3nstep2.css';
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Preview Changes</title><link href="<?php echo plugins_url( 'w3nuts-wc-multistep-checkout/css/' . $css ) ?>" rel="stylesheet" type="text/css"></head><body>
    <?php 
    if ( 'style6' ==  $style ) { // w3nstep6
        $bgdisabled = $_REQUEST['w3nmscheckout_color_inactive'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_inactive'] ) : sanitize_hex_color ( '#ABABAB' ); 
        ?>
        <style>
            #w3nSteps .steps ul li.disabled .number{color:#ffffff; background:<?php echo $bgdisabled; ?>;}#w3nSteps .steps ul li.disabled a{color:<?php echo $fontcolor; ?>;}#w3nSteps .steps ul li.disabled:after,#w3nSteps .steps ul li.disabled:before{display:none;}#w3nSteps .steps ul li.current .number{color:#ffffff; background:<?php echo $bgactive; ?>;}#w3nSteps .steps ul li.current a{color:<?php echo $fontcolor; ?>;}#w3nSteps .steps ul li.current:after{display:none;}#w3nSteps .steps ul li.current:before{background:<?php echo $bgactive; ?>;}#w3nSteps .steps ul li.done .number{color:#ffffff; background:<?php echo $bgdone; ?>; font-size:0;}#w3nSteps .steps ul li.done a{color:<?php echo $fontcolor; ?>;}#w3nSteps .steps ul li.done .number img{display:block;}#w3nSteps .steps ul li.done:after{background:<?php echo $bgdone; ?>;}#w3nSteps .steps ul li.done:before{background:<?php echo $bgdone; ?>;}#w3nSteps > .steps > ul > li {width: 30%;}#w3nSteps.vertical  .steps{margin-top:0px;padding:0px;width:100%}#w3nSteps.vertical > .actions > ul > li{margin: 0 0 0 0.2em;}
        </style>
        <?php
    } elseif ( 'style5' == $style ) { // w3nstep5
        $bgdisabled = $_REQUEST['w3nmscheckout_color_inactive'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_inactive'] ) : sanitize_hex_color ( '#ABABAB' ); 
            ?>
        <style>
            #w3nSteps .steps ul li.disabled .number{color:#ffffff; background:<?php echo $bgdisabled; ?>;}#w3nSteps .steps ul li.disabled a{color:<?php echo $fontcolor; ?>;}#w3nSteps .steps ul li.disabled:before{display:none;}#w3nSteps .steps ul li.current .number{color:#ffffff; background:<?php echo $bgactive; ?>;}#w3nSteps .steps ul li.current a{color:<?php echo $fontcolor; ?>;}#w3nSteps .steps ul li.current:before{display:block; background:<?php echo $bgactive; ?>; right:50%;}#w3nSteps .steps ul li.done .number{color:#ffffff; background:<?php echo $bgdone; ?>; font-size:0;}#w3nSteps .steps ul li.done a{color:<?php echo $fontcolor; ?>;}#w3nSteps .steps ul li.done .imagebox{display:block;}#w3nSteps .steps ul li.done:before{display:block; background:<?php echo $bgdone; ?>;}#w3nSteps > .steps > ul > li{width: 30%;}#w3nSteps .steps{margin:0px;}#w3nSteps.vertical .steps{width:80%}#w3nSteps.vertical > .actions > ul > li{margin: 0 0 0 0.2em;}
        </style>
        <?php
    } elseif ( 'progress' == $style ) { // w3nstep4
        $bgdisabled = $_REQUEST['w3nmscheckout_color_inactive'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_inactive'] ) : sanitize_hex_color ( '#ABABAB' );
        ?>
        <style>
            #w3nSteps .steps ul li.disabled .number{color:#ffffff; background:<?php echo $bgdisabled; ?>;}#w3nSteps .steps ul li.disabled a{color:<?php echo $fontcolor; ?>;}#w3nSteps .steps ul li.disabled .number:after,#w3nSteps .steps ul li.disabled .number:before{display:none;}#w3nSteps .steps ul li.current .number{color:#ffffff; background:<?php echo $bgactive; ?>;}#w3nSteps .steps ul li.current a{color:<?php echo $fontcolor; ?>;}#w3nSteps .steps ul li.current .number:after{display:none;}#w3nSteps .steps ul li.current .number:before{background:<?php echo $bgactive; ?>;}#w3nSteps .steps ul li.done .number{color:#ffffff; background:<?php echo $bgdone; ?>; font-size:0;}#w3nSteps .steps ul li.done a{color:<?php echo $fontcolor; ?>;}#w3nSteps .steps ul li.done .number img{display:block;}#w3nSteps .steps ul li.done .number:after{background:<?php echo $bgdone; ?>;}#w3nSteps .steps ul li.done .number:before{background:<?php echo $bgdone; ?>;}#w3nSteps > .steps > ul > li{width: 30%;}#w3nSteps.vertical  .steps{float:none;width:100%}#w3nSteps.vertical > .actions > ul > li{margin: 0 0 0 0.2em;}
        </style>
        <?php
    } elseif ( 'arrow' == $style ) { // w3nstep3
        $bgdisabled = $_REQUEST['w3nmscheckout_color_inactive'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_inactive'] ) : sanitize_hex_color ( '#ABABAB' ); 
            $fontdis = $_REQUEST['w3nmscheckout_color_font'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_font'] ) : sanitize_hex_color ( '#777777' );
        ?>
        <style>
            #w3nSteps .steps ul li.disabled .number{color:#ffffff; background:<?php echo $bgdisabled; ?>;}#w3nSteps .steps ul li.disabled a{color:<?php echo $fontdis; ?>;}#w3nSteps .steps ul li.current .number{color:#ffffff; background:<?php echo $bgactive; ?>;}#w3nSteps .steps ul li.current a{color:<?php echo $fontcolor; ?>; }#w3nSteps .steps ul li.done .number{color:#ffffff; background:<?php echo $bgdone; ?>; font-size:0;}#w3nSteps .steps ul li.done a{color:<?php echo $fontcolor; ?>;}#w3nSteps > .steps > ul > li{width: 30%;}#w3nSteps.vertical  .steps{float:none;width:100%;}#w3nSteps .steps ul li a{width:95%;}#w3nSteps.vertical > .actions > ul > li{margin: 0 0 0 0.2em;}
        </style>
        <?php
    } elseif ( 'seperateboxes' == $style ) { // w3nstep2
        $bgdisabled = $_REQUEST['w3nmscheckout_color_inactive'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_inactive'] ) : sanitize_hex_color ( '#999999' ); 
        $fontcolor = $_REQUEST['w3nmscheckout_color_font'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_font'] ) : sanitize_hex_color ( '#ffffff' );
        $fontdis = $_REQUEST['w3nmscheckout_color_font'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_font'] ) : sanitize_hex_color ( '#777777' );
        $bgnum = $_REQUEST['w3nmscheckout_color_number'] ? sanitize_hex_color ( $_REQUEST['w3nmscheckout_color_number'] ) : sanitize_hex_color ( '#1E7E0B' );
        ?>
        <style>
            #w3nSteps .steps ul li.disabled .number{color:#ffffff; background:<?php echo $bgnum; ?>;}#w3nSteps .steps ul li.disabled a{color:<?php echo $fontdis; ?>; background:<?php echo $bgdisabled;?>;}#w3nSteps .steps ul li.disabled a:before{border-color:transparent transparent transparent #fff;}#w3nSteps .steps ul li.disabled a:after{border-color: transparent transparent transparent <?php echo $bgdisabled;?>;}#w3nSteps .steps ul li.current .number{color:#ffffff; background:<?php echo $bgnum; ?>;}#w3nSteps .steps ul li.current a{color:<?php echo $fontcolor; ?>; background:<?php echo $bgactive; ?>;}#w3nSteps .steps ul li.current a:before{border-color:transparent transparent transparent #fff;}#w3nSteps .steps ul li.current a:after{border-color: transparent transparent transparent <?php echo $bgactive; ?>;}#w3nSteps .steps ul li.done .number{color:#ffffff; background:<?php echo $bgnum; ?>;}#w3nSteps .steps ul li.done a{color:<?php echo $fontcolor; ?>; background:<?php echo $bgdone; ?>;}#w3nSteps .steps ul li.done a:before{border-color:transparent transparent transparent #fff;}#w3nSteps .steps ul li.done a:after{border-color: transparent transparent transparent <?php echo $bgdone; ?>;}#w3nSteps > .steps > ul > li{width: 37% !important;}#w3nSteps.vertical .steps ul li a{width: 84% !important; padding-left: 34px;}#w3nSteps.vertical .steps ul li:first-child a{padding-left: 34px;}#w3nSteps.vertical  .steps{float:none;width:100%;}#w3nSteps.vertical .steps > ul > li{width: 37% !important;}#w3nSteps.vertical .steps ul li a:after{left: 126%;}#w3nSteps.vertical > .actions > ul > li{margin: 0 0 0 0.2em;}
        </style>
        <?php
    } else { // w3nstep1
        ?>
        <style>
            #w3nSteps .steps ul li.disabled .number {color:#ffffff; background:<?php echo $bgdisabled;?>;}#w3nSteps .steps ul li.disabled a{color:<?php echo $fontcolor; ?>;}#w3nSteps .steps ul li.disabled a:before{background:#777777;}#w3nSteps .steps ul li.current .number{color:#ffffff; background:<?php echo $bgactive; ?>;}#w3nSteps .steps ul li.current a{color:<?php echo $fontcolor; ?>;}#w3nSteps .steps ul li.current a:before{background:<?php echo $bgactive; ?>;}#w3nSteps .steps ul li.done .number{color:#ffffff; background:<?php echo $bgdone; ?>;}#w3nSteps .steps ul li.done a {color:<?php echo $fontcolor; ?>;}#w3nSteps .steps ul li.done a:before {background:<?php echo $bgdone; ?>;}#w3nSteps > .steps > ul > li {width: 30%;}#w3nSteps.vertical  .steps { float:none;width:100%;}#w3nSteps.vertical > .actions > ul > li{margin: 0 0 0 0.2em;}
        </style>
        <?php
    }
    ?>
    <!-- Button color common to all style -->
    <style>
        #w3nSteps > .actions a, #w3nSteps > .actions a:hover, #w3nSteps > .actions a:active, #w3nSteps form.login input.button, #w3nSteps form.register input.button{ background: <?php echo $btncolor; ?>; color: <?php echo $btnfontcolor; ?>;}button#w3n-register, button#w3n-login{background: <?php echo $btncolor; ?>; color: <?php echo $btnfontcolor; ?>;}#w3nSteps > .actions a, #w3nSteps > .actions a:hover, #w3nSteps > .actions a:active {padding: 0.5em 0.5em !important;} .number{font-size: 12px !important;} .namebox{ font-size: 9px !important;}
    </style>
    <div>
    <div id="w3nSteps" <?php if($orientation == 'vertical') { ?> class="vertical" <?php } ?> >
<div class="steps" style="margin-bottom: 3%;"><ul><li class="first done"><a href="javascript:void(0)"><span class="number">1</span><span class="namebox">Login</span></a></li><li class="current"><a href="javascript:void(0)"><span class="number">2</span><span class="namebox">Coupon</span></a></li><li class="disabled"><a href="javascript:void(0)"><span class="number">3</span><span class="namebox">Billing</span></a></li></ul></div><div class="content"></div><div class="actions" style="width: 100%"><ul role="menu" aria-label="Pagination"><li><a href="#previous" role="menuitem">Previous</a></li><li><a href="#next" role="menuitem">Skip Login</a></li><li><a href="#finish" role="menuitem">Place Order</a></li></ul></div></div></div></body></html>