<?php
function myorderdesk_load_scripts($hook) {
	$mod_host = parse_url(get_option('mod_address', 'https://www.MyOrderDesk.com'), PHP_URL_HOST);
	$mod_listener = get_option('mod_listener', '/w2p');
	
	if (!wp_script_is ('mod_SkinService')) {
		wp_enqueue_script( 'mod_iframeresizer', MODWOP_IFRAME_URL . 'iframeresizer.min.js', array(), '3.2.4', true ); //Resize code
		wp_enqueue_script( 'mod_SkinService', 'https://' . $mod_host . '/Scripts/MODSkinService/MODSkinService.js', array(), '3.2.4', true ); //MOD skin code

		/*$inline  = '<script src="//www.myorderdesk.com/scripts/davidjbradshaw-iframe-resizer-a22ff52/js/iframeResizer.min.js" type="text/javascript"></script>' . PHP_EOL;*/
		/*$inline  = '<script src="//www.myorderdesk.com/Scripts/MODSkinService/MODSkinService.js" type="text/javascript"></script>' . PHP_EOL;*/
		
		$inline  = 'iFrameResize({scrolling:false, checkOrigin: false}, "#mainFrame");' . PHP_EOL;
		$inline .= 'addEventListener("load", function(){ MODSkinService("mainFrame", null, "' . sanitize_text_field($mod_listener) . '", "' . sanitize_text_field($mod_host) . '"); });'. PHP_EOL;

		wp_add_inline_script( 'mod_SkinService', $inline);
	}
}

function myorderdesk_settingsmenu() {
	add_menu_page( 'MyOrderDesk Settings', 'MyOrderDesk', 'manage_options', 'mod', 'myorderdesk_options' );
}

function myorderdesk_show_savemessage($message, $isError) {
	echo '<div class="' . ($isError ? 'error' : 'updated') . '">';
	echo 	'<p>';
	echo 		'<strong>' . $message . '</strong>';
	echo 	'</p>';
	echo '</div>';
}

function myorderdesk_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	wp_enqueue_style( 'mod_stylesheet', MODWOP_CSS_URL . 'stylesheet.css' );
	
	// variables for the field and option names 
    $hidden_field_name = 'mt_submit_hidden';
    $mod_number = get_option('mod_number', '0');
	$mod_address = get_option('mod_address', 'https://www.myorderdesk.com');
	$mod_listener = get_option('mod_listener', '/w2p');
	
	$newestversion = file_get_contents( MODWOP_SVN_VERSION_URL ); // get the contents, and echo it out.
	$mod_modlogo = MODWOP_IMAGES_URL . 'm3.png';
	
	
	//Get list of Locations 
	global $wpdb;
	$query = "SELECT ID, post_title, guid FROM ".$wpdb->posts." WHERE (post_content LIKE '%[mod-%' OR post_content LIKE '%W21vZC1%') AND post_status = 'publish'";
	$results = $wpdb->get_results ($query);

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
	if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' && wp_verify_nonce($_POST['mod_nonce'], 'mod-nonce')) {
        // Save the posted value in the database
		$mod_number = $_POST['mod_number'];
		$mod_address = $_POST['mod_address'];
		$mod_listener = $_POST['mod_listener'];
		
		if (!filter_var($mod_address . $mod_listener, FILTER_VALIDATE_URL)) {
			myorderdesk_show_savemessage(__('Invalid Landing Page. Must be formatted as /PageName.'), 'menu-test', true);
		}
		else {
        	update_option( 'mod_number', $mod_number );
        	update_option( 'mod_address', $mod_address );
        	update_option( 'mod_listener', $mod_listener );
			
			myorderdesk_show_savemessage(__('Settings Saved', 'menu-test'), false);
		}
    } elseif (isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' && wp_verify_nonce($_POST['mod_nonce'], 'mod-nonce') == false) {
		myorderdesk_show_savemessage(__('Something went wrong. Please report this to Print Reach if you see this message. Error code NCE', 'menu-test'), true);
    }

	do_action( 'admin_print_styles' );
	?>
	<div class="wrap">
	<form name="form1" method="post" action="">
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y" />
	<input type="hidden" name="mod_nonce" value="<?php echo wp_create_nonce('mod-nonce'); ?>"/>

	<!-- Start web code-->
		<h2></h2>
		<div>
			<img src="<?php echo $mod_modlogo ?>" alt="MyOrderDesk Logo" width="400" height="76" />
		</div>
		<h2>Thanks for installing the MyOrderDesk plugin!</h2>
		<p>
			For instructions on how to use this plugin, you can find them on this page:
			<a href="https://wordpress.org/plugins/myorderdesk/#faq" target="_blank">https://wordpress.org/plugins/myorderdesk/#faq/</a>
		</p>
		<?php
		if ( $newestversion > MODWOP_PLUGIN_VERSION ) {
			echo '<p><font color="red" size="4">';
			echo 'There is a new version of the plugin available! Update here: <a href="/wp-admin/plugins.php">/wp-admin/plugins.php</a>';	
			echo '</font></p>';
		}
		?>
		<hr>
		<settingsbody>
			<h2>Configuration</h2>
			<div>
				<label style="display:inline-block;width:35ch"><?php _e("Your MyOrderDesk Provider ID:", 'menu-test' ); ?></label>
				<input type="number" min="1000" max="2147483647" name="mod_number" value="<?php echo $mod_number; ?>" size="20"/>
			</div>  
			<br/>
			<div>
				<label style="display:inline-block;width:35ch"><?php _e("Your MyOrderDesk Hosted Address:", 'menu-test' ); ?></label>
				<input type="url" maxlength="255" name="mod_address" value="<?php echo sanitize_text_field($mod_address); ?>" size="50" pattern="https://.*" />
			</div>
			<br/>
			<div>
				<label style="display:inline-block;width:35ch"><?php _e("Landing Page:", 'menu-test' ); ?></label>
				<input type="text" maxlength="255" name="mod_listener" value="<?php echo sanitize_text_field($mod_listener); ?>" size="50" pattern="^\/[/.a-zA-Z0-9-]+$" />
			</div>			
			<br/>
			<div>
				<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" style="margin-left: 15px;" />
			</div>  
			<br><br>
			<h2>Shortcodes</h2>
			<hr>
			<br>
			<table class="table1">
				<tr>
					<td>Display the My Account page:</td>
					<td><input type="text" value="[mod-myaccount]" class="field left" readonly style="margin-right: 10px"><a href="<?php echo $mod_address . "/settings.asp?Provider_ID=" . $mod_number; ?>" target="_blank">Preview</a></td>
				</tr>
				<tr>
					<td>Sign the user in:</td>
					<td><input type="text" value="[mod-signin]" class="field left" readonly style="margin-right: 10px"><a href="<?php echo $mod_address . "/SignIn/?Provider_ID=" . $mod_number; ?>&force=1" target="_blank">Preview</a></td>
				</tr>
				<tr>
					<td>Sign the user out:</td>
					<td><input type="text" value="[mod-signout]" class="field left" readonly style="margin-right: 10px"><a href="<?php echo $mod_address . "/SignOut/?Provider_ID=" . $mod_number; ?>" target="_blank">Preview</a></td>
				</tr>
				<tr>
					<td>Display the main order page:</td>
					<td><input type="text" value="[mod-order]" class="field left" readonly style="margin-right: 10px"><a href="<?php echo $mod_address . "/JobSubmit.asp?Provider_ID=" . $mod_number; ?>&force=1" target="_blank">Preview</a></td>
				</tr>
				<tr>
					<td>Display the user's Job history:</td>
					<td><input type="text" value="[mod-history]" class="field left" readonly style="margin-right: 10px"><a href="<?php echo $mod_address . "/Jobs.asp?Provider_ID=" . $mod_number; ?>" target="_blank">Preview</a></td>
				</tr>
				<tr>
					<td>Display the user's carts:</td>
					<td><input type="text" value="[mod-cart]" class="field left" readonly style="margin-right: 10px"><a href="<?php echo $mod_address . "/Carts.asp?Provider_ID=" . $mod_number; ?>" target="_blank">Preview</a></td>
				</tr>
			</table>
			<br>
			<br>
			<h2>Custom Shortcodes</h2>
			<hr>
			<table class="table1">
				<tr>
					<td>Display a specific order form:</td>
					<td><input type="text" value='[mod-orderform form="######"]' class="field left" style="width: 225px;" readonly></td>
				</tr>
				<tr>
					<td>Display a specific catalog:</td>
					<td><input type="text" value='[mod-catalog catalog="######"]' class="field left" style="width: 225px;" readonly></td>
				</tr>
			</table>
			<br>
			<br>
			<h2>W2P Landing Page (Email Notifications)</h2>
			<hr>
			<p>You must setup a page on your Wordpress site that can be used when you or your users click on email links.</p>
			<p>In your Wordpress website, create a new page and name it: w2p</p>
			<p>Paste the code below into that page and save the page. When the MyOrderDesk staff makes your site live they will setup the configuration within your MyOrderDesk website.</p>
			<input type="text" value="[mod-w2p]" class="field left" readonly>
			<br>
			<br>
			<h2>Locations</h2>
			<hr/>
			<p>A URL list of all the places you are using shortcode:</p>
			<?php
			foreach ( $results as $results ) {
			?>
				<p>
					<a href="/?page_id=<?php echo $results->ID;?>">
						<?php echo $results->post_title;?>
					</a>
					<br>
				</p>
			<?php
			}
			?>
			<br>
			<br>
			<h2>About</h2>
			<hr>
			<br>
			Version: <?php echo MODWOP_PLUGIN_VERSION?>
		</settingsbody>

	</form>
	</div>
	<?php
}
?>