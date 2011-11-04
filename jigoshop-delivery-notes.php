<?php
/*
Plugin Name: Delivery Notes for JigoShop
Plugin URI: http://jigoshop.com
Description: Very Basic Jigoshop Delivery Note System
Version: 1.0
Author: Steve Clark
Author URI: http://www.clark-studios.co.uk
*/

include('constants.php');

/**
 * Check if Jigoshop is active
 **/
if ( in_array( 'jigoshop/jigoshop.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
/**************
* Meta Box Code
***************/

	// --- Push New Meta Box On Stack
	add_action( 'add_meta_boxes', 'delivery_notes_add_box' );

	// --- Add meta box To Wordpress
	function delivery_notes_add_box() {
		add_meta_box('jigshop-delivery-note', 'Delivery Note', 'jigoshop_show_box', 'shop_order', 'side', 'default');
	}

	// --- Draw the meta box on orders screen
	function jigoshop_show_box() {
	 echo '<table class="form-table">';
		  echo '<tr>';
			  echo '<td><a href="#" rel="' . WP_PLUGIN_URL . '/jigoshop-delivery-notes/" id="rb_print_delivery_note" class="button button-primary">View &amp; Print Delivery Note</a></td>';
		  echo '</tr>';
	 echo '</table>';
	}

	// -- Adds the javascript that opens a new browser window with the invoice in
	function add_notes_js()
	{
		if(is_admin())
		{
			load_plugin_textdomain( 'jigoshop-delivery-notes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_style( 'thickbox' );
			wp_register_script('my-upload', WP_PLUGIN_URL . '/jigoshop-delivery-notes/js/uploads.js', array('jquery','media-upload','thickbox'));
			wp_enqueue_script('my-upload');
			wp_register_script('note-js', WP_PLUGIN_URL . '/jigoshop-delivery-notes/js/notes.js', array('jquery'));
			wp_enqueue_script('note-js');
		}
	}

	// -- Action that adds notes.js to the admin backend
	add_action('init', 'add_notes_js');
	

/**************
* Plugin Settings
***************/	
	
	// --- Display Menu
	function add_delivery_note_link()
	{
		add_submenu_page('edit.php?post_type=shop_order', 'Delivery Notes Settings', 'Delivery Notes Settings', 'manage_options', 'delivery_settings_page', 'delivery_settings_page' ); 
	}
	
	// --- Register Menu
	add_action('admin_menu', 'add_delivery_note_link');	
	
	// --- Display The Options
	function delivery_settings_page()
	{
		global $prefix;
		//must check that the user has the required capability 
		if (!current_user_can('manage_options'))
		{
		  wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		
		// variables for the field and option names 
		$hidden_field_name = 'xx_submit_hidden';

		// Read in existing option value from database
		$opt_val = get_option( $opt_name );
		
		// If they did, this hidden field will be set to 'Y'
		if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' )
		{
			foreach($_POST as $o => $v)
			{
				if($v != "") update_option( $o, $v );
			}
			// Put an settings updated message on the screen
			echo'<div class="updated"><p><strong>Settings Saved</strong></p></div>';
		}	
			// Now display the settings editing screen
			echo '<div class="wrap">';
			echo "<h2>Delivery Notes Settings</h2>";
			// settings form
		
		?>

		<form name="form1" method="post" action="" style="width:75%; float:left;">
			<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
			
			<table width="100%">
				
				<tr>
					<td width="30%" valign="top">
						<p><strong>Business Email:</strong><br/>
						<small>Please enter your business email</small></p>
					</td>
					<td width="50%" align="left" valign="middle">
						<input type="text" style="width:80%" name="<?php echo $prefix; ?>email" value="<?php echo @getVal($prefix . 'email'); ?>" size="80">
					</td>
				</tr>
				
				<tr>
					<td width="30%" valign="top">
						<p><strong>Business Telephone Number:</strong><br/>
						<small>Please Enter your Business Telephone Number</small></p>
					</td>
					<td width="50%" align="left" valign="middle">
						<input type="text" style="width:80%" name="<?php echo $prefix; ?>tel" value="<?php echo @getVal($prefix . 'tel'); ?>" size="20">
					</td>
				</tr>
				
				<tr>
					<td width="30%" valign="top">
						<p><strong>Business Address:</strong><br/>
						<small>Please Enter your company address</small></p>
					</td>
					<td width="50%" align="left" valign="middle">
						<textarea style="width:80%" type="text" cols="20" rows="5" name="<?php echo $prefix; ?>address"><?php echo @getVal($prefix . 'address'); ?></textarea>
					</td>
				</tr>	
				
				<tr>
					<td width="30%" valign="top">
						<p><strong>Returns Policy:</strong><br/>
						<small>Please Enter your company returns policy</small></p>
					</td>
					<td width="50%" align="left" valign="middle">
						<textarea style="width:80%" type="text" cols="20" rows="5" name="<?php echo $prefix; ?>returns"><?php echo @getVal($prefix . 'returns'); ?></textarea>
					</td>
				</tr>	
				
				<tr>
					<td width="30%" valign="top">
						<p><strong>Logo:</strong><br/>
						<small>Please select an image from your computer</small></p>
					</td>
					<td width="50%" align="left" valign="middle">
						<input type="text" style="width:60%" name="<?php echo $prefix; ?>logo" class="<?php echo $prefix; ?>logo" value="<?php echo getVal( $prefix . "logo"); ?>" size="20">
						<input type="submit" name="Submit"  id="<?php echo $prefix; ?>logo" class="upload button-primary upload-button"  value="Upload A Logo" />
					</td>
				</tr>	
	
			</table>

			<p class="submit">
				<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
			</p>
			
			
		</form>
		
		<!-- Cheeky I Know But Hey Why Not! -->
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="border:2px double #333; background:#eee; padding:15px; width:20%; float:right;">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="VAX9GTEKJ9WSA">
			<h2>Do you like this? Then buy me a beer?</h2>
			<p>If you like this plugin and use it then why not buy me a beer in support of it - I would really appreciate</p>
			<input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
		</form>

	</div>

	<?php
	}	
	
	/*  Get The Value by Post Or Option */	
	function getVal($val, $fallback = "")
	{
		if('save' == $_REQUEST['action'])
		{
			$val = $_POST[$val];
		} else {
			if(is_string(get_option($val)))
			{
				$val = stripslashes(get_option($val));
			} else {
				$val = get_option($val);
			}
		}
		if($val=="" && $fallback != "")
		{
			$val = $fallback;
		}
		return $val;
	} 
	
} // - END JIGO SHOP INSTALL CONDITONAL

?>