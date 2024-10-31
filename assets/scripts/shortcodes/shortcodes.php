<?php
//      FUNCTION AND SHORTCODE ASSEMBLY       //

function build_iframe_element($path)
{
	$mod_address = get_option('mod_address', 'https://www.myorderdesk.com');
	return '<div><iframe id="mainFrame" name="mainFrame" src="' . $mod_address . $path . '" sandbox="' . MODWOP_IFRAME_SANDBOX . '" scrolling="no" allowtransparency="true" allow="fullscreen" style="border:0px solid gray; background-color:transparent; width:100%; height:1600px" onload="window.parent.parent.scrollTo(0,0)"></iframe></div>';
}

// Oldskool way to check if attribute exists
function is_flag( $flag, $atts ) {
	foreach ( $atts as $key => $value )
		if ( $value === $flag && is_int( $key ) ) return true;
	return false;
}

// Newer way to normalize the attribites
// https://www.sitepoint.com/unleash-the-power-of-the-wordpress-shortcode-api/
function normalize_attributes($atts) {
    foreach ($atts as $key => $value) {
    	if (is_int($key)) {
            $atts[$value] = true;
            unset($atts[$key]);
    	}
	}
	
	return $atts;
}

//Builds the My Account frame & shortcode
function mod_myaccount_frame( $atts ) {
	$mod_number = get_option( 'mod_number' );
	
	$atts = shortcode_atts(array('site' => $mod_number), $atts);
	
	return build_iframe_element('/Settings.asp?Provider_ID=' . $atts['site']);
}
//shortcode
add_shortcode( 'mod-myaccount', 'mod_myaccount_frame' );

//Builds the Sign out frame & shortcode
function mod_signout_frame( $atts ) {
	$mod_number = get_option( 'mod_number' );
	
	$atts = shortcode_atts(array('site' => $mod_number), $atts);
	
	return build_iframe_element('/SignOut/?Provider_ID=' . $atts['site']);
}
//shortcode
add_shortcode( 'mod-signout', 'mod_signout_frame' );

//Builds the Sign in frame & shortcode
function mod_signin_frame( $atts ) {
	$mod_number = get_option( 'mod_number' );
	
	$atts = shortcode_atts(array('site' => $mod_number), $atts);
	
	return build_iframe_element('/SignIn/?Provider_ID=' . $atts['site']);
}
//shortcode
add_shortcode( 'mod-signin', 'mod_signin_frame' );

//Builds the Main order page & shortcode
function mod_order_frame( $atts ) {
	$mod_number = get_option( 'mod_number' );

	$atts = shortcode_atts(array('site' => $mod_number), $atts);
	
	is_flag( 'force', $atts ) ? $forceval = "&force=1" : $forceval = "";
	
	return build_iframe_element('/JobSubmit.asp?Provider_ID=' . $atts['site'] . $forceval);
}
//shortcode
add_shortcode( 'mod-order', 'mod_order_frame' );

//Builds the Job history page & shortcode
function mod_history_frame( $atts ) {
	$mod_number = get_option( 'mod_number' );
	
	$atts = shortcode_atts(array('site' => $mod_number), $atts);
	
	return build_iframe_element('/Jobs.asp?Provider_ID=' . $atts['site']);
}
//shortcode
add_shortcode( 'mod-history', 'mod_history_frame' );

//Builds the Shopping cart page & shortcode
function mod_cart_frame( $atts ) {
	$mod_number = get_option( 'mod_number' );
	
	$atts = shortcode_atts(array('site' => $mod_number), $atts);
	
	return build_iframe_element('/Carts.asp?Provider_ID=' . $atts['site']);
}
//shortcode
add_shortcode( 'mod-cart', 'mod_cart_frame' );


//      MANUAL ORDER FORM / CATALOG ENTRY       //

//Builds the Order Form page & shortcode
function mod_orderform_frame( $atts ) {
	$mod_number = get_option( 'mod_number' );
	
	$atts = shortcode_atts(array('form' => 0, 'site' => $mod_number), $atts);
	
	return build_iframe_element('/JobSubmit.asp?Provider_ID=' . $atts['site'] . '&OrderFormID=' . sanitize_text_field($atts['form']));
}
//shortcode
add_shortcode( 'mod-orderform', 'mod_orderform_frame' );

//Builds the Catalog page & shortcode
function mod_catalog_frame( $atts ) {
	$mod_number = get_option( 'mod_number' );
	
	$atts = shortcode_atts(array('catalog' => 0, 'site' => $mod_number), $atts);
	
	return build_iframe_element('/Catalog/?Provider_ID=' . $atts['site'] . '&CatalogID=' . sanitize_text_field($atts['catalog']));
}
//shortcode
add_shortcode( 'mod-catalog', 'mod_catalog_frame' );

//Builds the w2p frame & shortcode
function mod_w2p_frame( $atts ) {
	setcookie("wordpress_mod_w2p", "1");
	
	$mod_number = get_option( 'mod_number' );
	
	$atts = shortcode_atts(array('site' => $mod_number), $atts);
	
	//return build_iframe_element('/Settings.asp?Provider_ID=' . $atts['site']);
	return build_iframe_element('about:blank');
}
//shortcode
add_shortcode( 'mod-w2p', 'mod_w2p_frame' );
?>