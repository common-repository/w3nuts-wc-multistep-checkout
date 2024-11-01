<?php
/**
 * Template allow back-end options to change colors on front.
 */
if ( is_checkout() || defined('ICL_LANGUAGE_CODE') ) {
	$style = sanitize_text_field( get_option( 'w3nmscheckout_steps_style' ) );
	$bgactive = get_option('w3nmscheckout_color_active') ? sanitize_hex_color( get_option('w3nmscheckout_color_active') ) : sanitize_hex_color( '#2BA813' );
	$bgdisabled = get_option('w3nmscheckout_color_inactive') ? sanitize_hex_color( get_option('w3nmscheckout_color_inactive') ) : sanitize_hex_color( '#777777' ); 
	$bgdone = get_option('w3nmscheckout_color_completed') ? sanitize_hex_color( get_option('w3nmscheckout_color_completed') ) : sanitize_hex_color( '#2BA813' );
	$fontcolor = get_option('w3nmscheckout_color_font') ? sanitize_hex_color( get_option('w3nmscheckout_color_font') ) : sanitize_hex_color( '#2BA813' );
	$btncolor = get_option('w3nmscheckout_color_buttons') ? sanitize_hex_color( get_option('w3nmscheckout_color_buttons') ) : sanitize_hex_color( '#2BA813' );
	$btnfontcolor = get_option('w3nmscheckout_color_buttons_font') ? sanitize_hex_color( get_option('w3nmscheckout_color_buttons_font') ) : sanitize_hex_color( '#fff' );

	if ( 'style6' ==  $style ) { // w3nstep6
		?>
		<style>
			#w3nSteps .steps ul li.disabled .number { color:#ffffff; background:#ABABAB;}
			#w3nSteps .steps ul li.disabled a { color:<?php echo $fontcolor; ?>;}
			#w3nSteps .steps ul li.disabled:after,
			#w3nSteps .steps ul li.disabled:before { display:none;}
			#w3nSteps .steps ul li.current .number { color:#ffffff; background:<?php echo $bgactive; ?>;}
			#w3nSteps .steps ul li.current a { color:<?php echo $fontcolor; ?>; }
			#w3nSteps .steps ul li.current:after { display:none;}
			#w3nSteps .steps ul li.current:before { background:<?php echo $bgactive; ?>;}
			#w3nSteps .steps ul li.done .number { color:#ffffff; background:<?php echo $bgdone; ?>; font-size:0;}
			#w3nSteps .steps ul li.done a { color:<?php echo $fontcolor; ?>;}
			#w3nSteps .steps ul li.done .number img { display:block;}
			#w3nSteps .steps ul li.done:after { background:<?php echo $bgdone; ?>;}
			#w3nSteps .steps ul li.done:before { background:<?php echo $bgdone; ?>;}
			@media(max-width: 767px){
			    #w3nSteps .steps ul{display: inline-block;}
			    #w3nSteps > .steps > ul > li, .wizard.five-steps > .steps > ul > li{float: none;font-size: 14px;margin-left: 0;width: 100%;}
			    #w3nSteps > .steps .actions.clearfix ul li{float: right;}
			    #w3nSteps > .steps .actions.clearfix ul li:first-child{float: left;}
			    #w3nSteps > .steps a,
			    #w3nSteps > .steps a:hover,
			    #w3nSteps > .steps a:active{text-align: left;}
			    #w3nSteps .steps ul li a span.namebox{display: block;width: 100%;text-align: center;}
			    #w3nSteps .steps ul li:before {display: none;}
			    #w3nSteps .steps ul li:after{display: none;}
			    #w3nSteps .steps ul li .number{margin:10px auto 0;}
			    #w3nSteps.vertical > .steps,
			    #w3nSteps.vertical > .content{width: 100%;margin: 0;padding: 0;clear:both;}
			    #w3nSteps.vertical > .content{float:left;margin-bottom: 10px;}
			    #w3nSteps.vertical .steps ul li .number{display: block;}
			}
		</style>
		<?php
	} elseif ( 'style5' == $style ) { // w3nstep5
		?>
		<style>
			#w3nSteps .steps ul li.disabled .number { color:#ffffff; background:#ABABAB;}
			#w3nSteps .steps ul li.disabled a { color:<?php echo $fontcolor; ?>;}
			#w3nSteps .steps ul li.disabled:before { display:none;}
			#w3nSteps .steps ul li.current .number { color:#ffffff; background:<?php echo $bgactive; ?>;}
			#w3nSteps .steps ul li.current a { color:<?php echo $fontcolor; ?>; }
			#w3nSteps .steps ul li.current:before { display:block; background:<?php echo $bgactive; ?>; right:50%;}
			#w3nSteps .steps ul li.done .number { color:#ffffff; background:<?php echo $bgdone; ?>; font-size:0;}
			#w3nSteps .steps ul li.done a { color:<?php echo $fontcolor; ?>;}
			#w3nSteps .steps ul li.done .imagebox{ display:block;}
			#w3nSteps .steps ul li.done:before { display:block; background:<?php echo $bgdone; ?>;}
			@media(max-width: 767px){
			    #w3nSteps .steps ul{display: block;}
			    #w3nSteps > .steps > ul > li, .wizard.five-steps > .steps > ul > li{float: none;font-size: 14px;margin-left: 0;width: 100%;}
			    #w3nSteps > .steps .actions.clearfix ul li{float: right;}
			    #w3nSteps > .steps .actions.clearfix ul li:first-child{float: left;}
			    #w3nSteps > .steps a,
			    #w3nSteps > .steps a:hover,
			    #w3nSteps > .steps a:active{text-align: left;}
			    #w3nSteps .steps ul li a span.namebox{display: block;width: 100%;text-align: center;}
			    #w3nSteps .steps ul li .number:before {display: none;}
			    #w3nSteps .steps ul li .number:after{display: none;}
			    #w3nSteps.vertical > .steps,
			    #w3nSteps.vertical > .content{width: 100%;margin: 0;padding: 0 20px 20px;clear:both;}
			    #w3nSteps.vertical > .content{float:left;margin-bottom: 10px;}
			}
		</style>
		<?php
	} elseif ( 'progress' == $style ) { // w3nstep4
		$bgdisabled = get_option('w3nmscheckout_color_inactive') ? sanitize_hex_color( get_option('w3nmscheckout_color_inactive') ) : sanitize_hex_color( '#ABABAB' );
		?>
		<style>
			#w3nSteps .steps ul li.disabled .number { color:#ffffff; background:<?php echo $bgdisabled; ?>;}
			#w3nSteps .steps ul li.disabled a { color:<?php echo $fontcolor; ?>;}
			#w3nSteps .steps ul li.disabled .number:after,
			#w3nSteps .steps ul li.disabled .number:before { display:none;}
			#w3nSteps .steps ul li.current .number { color:#ffffff; background:<?php echo $bgactive; ?>;}
			#w3nSteps .steps ul li.current a { color:<?php echo $fontcolor; ?>; }
			#w3nSteps .steps ul li.current .number:after { display:none;}
			#w3nSteps .steps ul li.current .number:before { background:<?php echo $bgactive; ?>;}
			#w3nSteps .steps ul li.done .number { color:#ffffff; background:<?php echo $bgdone; ?>; font-size:0;}
			#w3nSteps .steps ul li.done a { color:<?php echo $fontcolor; ?>;}
			#w3nSteps .steps ul li.done .number img { display:block;}
			#w3nSteps .steps ul li.done .number:after { background:<?php echo $bgdone; ?>;}
			#w3nSteps .steps ul li.done .number:before { background:<?php echo $bgdone; ?>;}
			@media(max-width: 767px){
			    #w3nSteps .steps ul{display: block;}
			    #w3nSteps > .steps > ul > li, .wizard.five-steps > .steps > ul > li{float: none;font-size: 14px;margin-left: 0;width: 100%;}
			    #w3nSteps > .steps .actions.clearfix ul li{float: right;}
			    #w3nSteps > .steps .actions.clearfix ul li:first-child{float: left;}
			    #w3nSteps > .steps a,
			    #w3nSteps > .steps a:hover,
			    #w3nSteps > .steps a:active{text-align: left;}
			    #w3nSteps .steps ul li a span.namebox{display: block;width: 100%;text-align: center;}
			    #w3nSteps .steps ul li .number:before {display: none;}
			    #w3nSteps .steps ul li .number:after{display: none !important;}
			    #w3nSteps.vertical > .steps,
			    #w3nSteps.vertical > .content{width: 100%;margin: 0;padding: 0;clear:both;}
			    #w3nSteps.vertical > .content{float:left;margin-bottom: 10px;}
			    #w3nSteps.vertical .steps ul li .number{display: block;}
			}
		</style>
		<?php
	} elseif ( 'arrow' == $style ) { // w3nstep3
		$bgdisabled = get_option('w3nmscheckout_color_inactive') ? sanitize_hex_color( get_option('w3nmscheckout_color_inactive') ) : sanitize_hex_color( '#ABABAB' );
		$fontdis = get_option('w3nmscheckout_color_font') ? sanitize_hex_color( get_option('w3nmscheckout_color_font') ) : sanitize_hex_color( '#777777' );
		?>
		<style>
			#w3nSteps .steps ul li.disabled .number { color:#ffffff; background:<?php echo $bgdisabled; ?>;}
            #w3nSteps .steps ul li.disabled a { color:<?php echo $fontdis; ?>;}
            #w3nSteps .steps ul li.current .number { color:#ffffff; background:<?php echo $bgactive; ?>;}
            #w3nSteps .steps ul li.current a { color:<?php echo $fontcolor; ?>; }
            #w3nSteps .steps ul li.done .number { color:#ffffff; background:<?php echo $bgdone; ?>; font-size:0;}
            #w3nSteps .steps ul li.done a { color:<?php echo $fontcolor; ?>; }
			@media(max-width: 991px){
			    #w3nSteps .steps ul li a { height:90px;}
			}
			@media(max-width: 767px){
			    #w3nSteps .steps ul{display: block;}
			    #w3nSteps > .steps > ul > li, .wizard.five-steps > .steps > ul > li{float: none;font-size: 14px;margin-left: 0;width: 100%;}
			    #w3nSteps > .steps .actions.clearfix ul li{float: right;}
			    #w3nSteps > .steps .actions.clearfix ul li:first-child{float: left;}
			    #w3nSteps > .steps a,
			    #w3nSteps > .steps a:hover,
			    #w3nSteps > .steps a:active{text-align: left;}
			    #w3nSteps .steps ul li a span.namebox{display: block;width: 100%;text-align: left;margin-left: 20px;}
			    #w3nSteps .steps ul li .number { margin:0px auto;}
			#w3nSteps .steps ul li a { height:60px;display:flex;padding: 10px;text-align: left;}
			    #w3nSteps.vertical > .steps,
			    #w3nSteps.vertical > .content{width: 100%;margin: 0;padding: 0;clear:both;}
			    #w3nSteps.vertical > .content{float:left;margin-bottom: 10px;}
			    #w3nSteps.vertical .steps ul li .number {margin: 0px 10px 5px auto;}
			    #w3nSteps.vertical .steps ul li a:before {display: none;}
			    #w3nSteps.vertical .steps ul li a span.namebox{display: inline;}
			}
		</style>
		<?php
	} elseif ( 'seperateboxes' == $style ) { // w3nstep2
		$bgdisabled = get_option('w3nmscheckout_color_inactive') ? sanitize_hex_color( get_option('w3nmscheckout_color_inactive') ) : sanitize_hex_color( '#999999' );
		$fontcolor = get_option('w3nmscheckout_color_font') ? sanitize_hex_color( get_option('w3nmscheckout_color_font') ) : sanitize_hex_color( '#ffffff' );
		$fontdis = get_option('w3nmscheckout_color_font') ? sanitize_hex_color( get_option('w3nmscheckout_color_font') ) : sanitize_hex_color( '#777777' );
		$bgnum = get_option('w3nmscheckout_color_number') ? sanitize_hex_color( get_option('w3nmscheckout_color_number') ) : sanitize_hex_color( '#1E7E0B' );
		?>
		<style>
			#w3nSteps .steps ul li.disabled .number { color:#ffffff; background:<?php echo $bgnum; ?>;}
			#w3nSteps .steps ul li.disabled a { color:<?php echo $fontdis; ?>; background:<?php echo $bgdisabled;?>;}
			#w3nSteps .steps ul li.disabled a:before { border-color:transparent transparent transparent #fff;}
			#w3nSteps .steps ul li.disabled a:after { border-color: transparent transparent transparent <?php echo $bgdisabled;?>;}
			#w3nSteps .steps ul li.current .number { color:#ffffff; background:<?php echo $bgnum; ?>;}
			#w3nSteps .steps ul li.current a { color:<?php echo $fontcolor; ?>; background:<?php echo $bgactive; ?>;}
			#w3nSteps .steps ul li.current a:before { border-color:transparent transparent transparent #fff;}
			#w3nSteps .steps ul li.current a:after { border-color: transparent transparent transparent <?php echo $bgactive; ?>;}
			#w3nSteps .steps ul li.done .number { color:#ffffff; background:<?php echo $bgnum; ?>;}
			#w3nSteps .steps ul li.done a { color:<?php echo $fontcolor; ?>; background:<?php echo $bgdone; ?>;}
			#w3nSteps .steps ul li.done a:before { border-color:transparent transparent transparent #fff;}
			#w3nSteps .steps ul li.done a:after { border-color: transparent transparent transparent <?php echo $bgdone; ?>;}
			@media(max-width: 767px){
			    #w3nSteps .steps ul{display: block;}
			    #w3nSteps > .steps > ul > li, .wizard.five-steps > .steps > ul > li{float: none;font-size: 14px;margin-left: 0;width: 100%;}
			    #w3nSteps > .steps .actions.clearfix ul li{float: right;}
			    #w3nSteps > .steps .actions.clearfix ul li:first-child{float: left;}
			    #w3nSteps > .steps a,
			    #w3nSteps > .steps a:hover,
			    #w3nSteps > .steps a:active{text-align: left;}
			    #w3nSteps .steps ul li a span.namebox{display: block;width: 100%;}
			    #w3nSteps .steps ul li a:before{display:none;}
			    #w3nSteps .steps ul li.first a, #w3nSteps .steps ul li:first-child a{padding-left:20px;}
			    #w3nSteps.vertical > .steps,
			    #w3nSteps.vertical > .content{width: 100%;margin: 0;padding: 0;clear:both;}
			    #w3nSteps.vertical > .content{float:left;margin-bottom: 10px;}
			    #w3nSteps.vertical .steps ul li.first a:before,
				#w3nSteps.vertical .steps ul li:first-child a:before { display:none;}
		</style>
		<?php
	} else { // w3nstep1
		?>
		<style>
			#w3nSteps .steps ul li.disabled .number { color:#ffffff; background:<?php echo $bgdisabled;?>;}
			#w3nSteps .steps ul li.disabled a { color:<?php echo $fontcolor; ?>; } 
			#w3nSteps .steps ul li.disabled a:before { background:#777777;}
			#w3nSteps .steps ul li.current .number { color:#ffffff; background:<?php echo $bgactive; ?>;}
			#w3nSteps .steps ul li.current a { color:<?php echo $fontcolor; ?>;}
			#w3nSteps .steps ul li.current a:before { background:<?php echo $bgactive; ?>;}
			#w3nSteps .steps ul li.done .number { color:#ffffff; background:<?php echo $bgdone; ?>;}
			#w3nSteps .steps ul li.done a { color:<?php echo $fontcolor; ?>;}
			#w3nSteps .steps ul li.done a:before { background:<?php echo $bgdone; ?>;}
			@media(max-width: 767px){
			    #w3nSteps > .steps > ul > li, .wizard.five-steps > .steps > ul > li{float: none;font-size: 14px;margin-left: 0;width: 100%;}
			    #w3nSteps > .steps .actions.clearfix ul li{float: right;}
			    #w3nSteps > .steps .actions.clearfix ul li:first-child{float: left;}
			    #w3nSteps > .steps a,
			    #w3nSteps > .steps a:hover,
			    #w3nSteps > .steps a:active{text-align: left;}
			    #w3nSteps .steps ul li a span.namebox{display: block;width: 100%;text-align: center;}
			    #w3nSteps.vertical > .steps,
			    #w3nSteps.vertical > .content{width: 100%;margin: 0;padding: 0;clear:both;}
			    #w3nSteps.vertical > .content{float:left;margin-bottom: 10px;}
			    #w3nSteps.vertical .steps ul li .number {margin: 0px 10px 5px auto;}
			    #w3nSteps.vertical .steps ul li a:before {display: none;}
			    #w3nSteps.vertical .steps ul li a span.namebox{display: inline;}
			}
		</style>
		<?php
	}
	?>
<!-- Button color common to all style -->
<style>
	#w3nSteps > .actions a, #w3nSteps > .actions a:hover, #w3nSteps > .actions a:active, 
	#w3nSteps form.login input.button, #w3nSteps form.register input.button { background: <?php echo $btncolor; ?>; color: <?php echo $btnfontcolor; ?>; }
	button#w3n-register, button#w3n-login { background: <?php echo $btncolor; ?>; color: <?php echo $btnfontcolor; ?>; }
</style>
<?php
}