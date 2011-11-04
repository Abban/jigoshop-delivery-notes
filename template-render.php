<?php
require('../../../wp-load.php'); 
// We Must Check If User is logged in as we are making an external call

if ( current_user_can('manage_options'))
{

	/* Template Rendering */
	$oid = $_GET['oid'];
	$order = new jigoshop_order( $oid );
	if($order)
	{
		// -- Get the paths to the relative folders	
		$is_custom_tpl = file_exists(TEMPLATEPATH . '/jigoshop/delivery-note/default.php');
		$path = (!$is_custom_tpl) ? WP_PLUGIN_DIR . '/jigoshop-delivery-notes/delivery-note/' : TEMPLATEPATH . '/jigoshop/delivery-note/';
		$css_url = ($is_custom_tpl) ? get_bloginfo('template_directory') . '/jigoshop/delivery-note/' : WP_PLUGIN_URL . '/jigoshop-delivery-notes/delivery-note/';	
		// -- Load The Template In		
		$handle = fopen($path . "default.php", "r");
		$contents = fread($handle, filesize($path . "default.php"));
		fclose($handle);
				
		// --- Build And Replace My Friends, Build And Replace
		replace("css_url", $css_url);
		
		// -- Order Number
		replace("order_id", $oid);
		
		// -- Delivery Date ( Care of mjnet - :-) cheers)
		replace("note_date", date("d.m.Y"));
		
		// --- Company Name
		replace("company_name", get_bloginfo('name'));
		
		// --- Build The Logo Field
		$replacement = (get_option($prefix . "logo") != "") ? "<img src=\"" . get_option($prefix . "logo") . "\" alt=\"\" />" : "";
		replace("company_logo", $replacement);
		
		// --- Build The Adress Field
		$replacement = (get_option($prefix . "address") != "") ? get_option($prefix . "address") : "";
		replace("company_address", $replacement);
		
		// --- Build The Company Detals
		if(get_option($prefix . "tel") != "")
		{
			$address .= __("Telephone:", "jigoshop") . " " . get_option($prefix . "tel") . "<br/>";
		}
		
		if(get_option($prefix . "fax") != "")
		{
			$address .= __("Fax:", "jigoshop") . " " . get_option($prefix . "fax") . "<br/>";
		}
		
		if(get_option($prefix . "email") != "")
		{
			$address .= __("Email:", "jigoshop") . " " . get_option($prefix . "email") . "<br/>";
		}
		
		$address = "<p>" . $address . __("Website:", "jigoshop") . " " . get_bloginfo('home') . "</p>";
		replace("company_details", $address);
		
		// --- Build The Shop Table 
		
		$cartHTML = '		
		<table class="shop_table" cellpadding="5" border="1" cellspacing="0">
			<thead>
				<tr>
					<th>' . __('Product', 'jigoshop-delivery-notes') . '</th>
					<th>' . __('Quantity', 'jigoshop-delivery-notes') . '</th>
					<th>' . __('Totals', 'jigoshop-delivery-notes') . '</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="2"><strong>' . __('Subtotal', 'jigoshop-delivery-notes') . '</strong></td>
					<td><strong>' .  $order->get_subtotal_to_display() . '</strong></td>
				</tr>';
				
			if ($order->order_shipping>0) {
				$cartHTML .= '<tr>
					<td colspan="2">' . __('Shipping', 'jigoshop-delivery-notes') . '</td>
					<td>' . $order->get_shipping_to_display() . '</td>
				</tr>';
			}
			
			if ($order->get_total_tax()>0) {
				$cartHTML .='<tr>
					<td colspan="2">' . __('Tax', 'jigoshop-delivery-notes') . '</td>
					<td>' . jigoshop_price($order->get_total_tax()) . '</td>
				</tr>';
			}
			
			if ($order->order_discount>0) {
				
				$cartHTML .= '<tr class="discount">
					<td colspan="2">' . __('Discount', 'jigoshop-delivery-notes') . '</td>
					<td>-' . jigoshop_price($order->order_discount) . '</td>
				</tr>';
			}
			
			$cartHTML .= '<tr>
					<td colspan="2"><strong>' . __('Grand Total', 'jigoshop-delivery-notes') . '</strong></td>
					<td><strong>' . jigoshop_price($order->order_total). '</strong></td>
				</tr>
			</tfoot>
			<tbody>';

				if (sizeof($order->items)>0) {

					foreach($order->items as $item) {

						if (isset($item['variation_id']) && $item['variation_id'] > 0){
							$_product = new jigoshop_product_variation( $item['variation_id'] );
						
							if(is_array($item['variation'])) {
								$cartHTML .= $_product->set_variation_attributes($item['variation']);
							}
						} else {
							$_product = new jigoshop_product( $item['id'] );
						}

						$cartHTML .= '
							<tr>
								<td class="product-name"><h4>'.$item['name'].'</h4>';

						if (isset($_product->variation_data)) {	$cartHTML .= jigoshop_get_formatted_variation( $_product->variation_data );	}

						$cartHTML .= '	</td>
								<td>'.$item['qty'].'</td>
								<td>'.jigoshop_price( $item['cost']*$item['qty'], array('ex_tax_label' => 1) ).'</td>
							</tr>';
					}
				}

			$cartHTML .= '</tbody></table>';
			replace("order_summary", $cartHTML);
		
		// -- Customer notes
		$replace = ($order->customer_note) ? wpautop(wptexturize($order->customer_note)) : __('None', 'jigoshop-delivery-notes');
		replace("customer_notes", $replace);
	
		// -- Deliveree
		$delivery_name = $order->shipping_first_name . " " . $order->shipping_last_name;
		$ordered_by = $billing_first_name . " " . $billing_last_name;
		$replace = ($delivery_name) ? $delivery_name : $ordered_by;
		replace("shipping_name", $replace);
		replace("billing_name", $replace);
		
		// -- Shipping Address Full (Preformatted)
		$ship_address = (!$order->formatted_shipping_address) ? "N/A" : $order->formatted_shipping_address;
		replace("shipping_address", $ship_address);
		
		// -- shipping Address Components
		$replace = ($order->shipping_company) ?$order->shipping_company : "";
		replace("shipping_company", $replace);
		$replace = ($order->shipping_address_1) ? $order->shipping_address_1 : "";
		replace("shipping_address_1", $replace);
		$replace = ($order->shipping_address_2) ? $order->shipping_address_2 : "";
		replace("shipping_address_2", $replace);
		$replace = ($order->shipping_city) ? $order->shipping_city : "";
		replace("shipping_city", $replace);
		$replace = ($order->shipping_postcode) ? $order->shipping_postcode : "";
		replace("shipping_postcode", $replace);
		$replace = ($order->shipping_country) ? $order->shipping_country : "";
		replace("shipping_country", $replace);
		$replace = ($order->shipping_state) ? $order->shipping_state : "";
		replace("shipping_state", $replace);
		
		// -- Billing Details
		$ship_address = (!$order->formatted_billing_address) ? "N/A" : $order->formatted_billing_address;
		replace("billing_address", $ship_address);
		$replace = ($order->billing_email) ? $order->billing_email : ""; 
		replace("billing_email", $replace);
		$replace = ($order->billing_phone) ? $order->billing_phone : ""; 
		replace("billing_phone", $replace);
		
		// -- Billing Address Components
		$replace = ($order->billing_company) ?$order->billing_company : "";
		replace("billing_company", $replace);
		$replace = ($order->billing_address_1) ? $order->billing_address_1 : "A";
		replace("billing_address_1", $replace);
		$replace = ($order->billing_address_2) ? $order->billing_address_2 : "";
		replace("billing_address_2", $replace);
		$replace = ($order->billing_city) ? $order->billing_city : "";
		replace("billing_city", $replace);
		$replace = ($order->billing_postcode) ? $order->billing_postcode : "";
		replace("billing_postcode", $replace);
		$replace = ($order->billing_country) ? $order->billing_country : "";
		replace("billing_country", $replace);
		$replace = ($order->billing_state) ? $order->billing_state : "";
		replace("billing_state", $replace);
		
		// -- Other Info
		$otherinfo = "";
		// -- Returns Policy
		$returns = get_option($prefix . "returns");
		if($returns)
		{
		  $otherinfo .= '<table id="other" cellpadding="5" border="1" cellspacing="0">
				<tr>
					<th>' . __('Returns', 'jigoshop-delivery-notes') . '</th>
				</tr>
				<tr>
					<td class="note" style="text-align: left;">' . $returns . '</td>
				</tr>
			</table>';	
		}
		replace("other_info", $otherinfo);
		
		
		echo $contents;
	
	} else {
		wp_die(__('Something has gone wrong!', 'jigoshop-delivery-notes'));
	}
}


function replace($tag, $content)
{
	global $contents;
	$contents = str_replace("{" . $tag . "}", $content, $contents);
}






?>