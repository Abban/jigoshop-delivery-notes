<?php

// Load Wordpress to use its functions
if ( !defined('ABSPATH') ) {
	require_once '../../../wp-load.php';
}

// Check the user capabilities
if (!current_user_can('manage_options') || !$_GET['order']) {
	wp_die( __('You do not have sufficient permissions to access this page.') );
}

// Load classes
require_once 'jigoshop-delivery-notes-classes.php';

// Create instance
$jdn_print = new Jigoshop_Delivery_Notes_Print();


/**
 * Return template url
 */
if (!function_exists('jdn_template_url')) {
	function jdn_template_url() {
		global $jdn_print;
		return $jdn_print->template_dir_url;
	}
}

/**
 * Return title
 */
if (!function_exists('jdn_company_name')) {
	function jdn_company_name() {
		return get_bloginfo('name');
	}
}

/**
 * Return info
 */
if (!function_exists('jdn_company_info')) {
	function jdn_company_info() {
		global $jdn_print;
		return wpautop(wptexturize($jdn_print->get_setting('address')));
	}
}

/**
 * Return shipping name
 */
if (!function_exists('jdn_shipping_name')) {
	function jdn_shipping_name() {
		global $jdn_print;
		return $jdn_print->get_order($_GET['order'])->shipping_first_name . ' ' . $jdn_print->get_order($_GET['order'])->shipping_last_name;
	}
}

/**
 * Return shipping company
 */
if (!function_exists('jdn_shipping_company')) {
	function jdn_shipping_company() {
		global $jdn_print;
		return $jdn_print->get_order($_GET['order'])->shipping_company;
	}
}

/**
 * Return shipping address 1
 */
if (!function_exists('jdn_shipping_address_1')) {
	function jdn_shipping_address_1() {
		global $jdn_print;
		return $jdn_print->get_order($_GET['order'])->shipping_address_1;
	}
}

/**
 * Return shipping address 2
 */
if (!function_exists('jdn_shipping_address_2')) {
	function jdn_shipping_address_2() {
		global $jdn_print;
		return $jdn_print->get_order($_GET['order'])->shipping_address_2;
	}
}

/**
 * Return shipping city
 */
if (!function_exists('jdn_shipping_city')) {
	function jdn_shipping_city() {
		global $jdn_print;
		return $jdn_print->get_order($_GET['order'])->shipping_city;
	}
}

/**
 * Return shipping state
 */
if (!function_exists('jdn_shipping_state')) {
	function jdn_shipping_state() {
		global $jdn_print;
		return $jdn_print->get_order($_GET['order'])->shipping_state;
	}
}

/**
 * Return shipping postcode
 */
if (!function_exists('jdn_shipping_postcode')) {
	function jdn_shipping_postcode() {
		global $jdn_print;
		return $jdn_print->get_order($_GET['order'])->shipping_postcode;
	}
}

/**
 * Return shipping country
 */
if (!function_exists('jdn_shipping_country')) {
	function jdn_shipping_country() {
		global $jdn_print;
		$order = $jdn_print->get_order($_GET['order']);
		return $order->shipping_country ? __(jigoshop_countries::$countries[$order->shipping_country], 'jigoshop') : null;
	}
}

/**
 * Return shipping notes
 */
if (!function_exists('jdn_shipping_notes')) {
	function jdn_shipping_notes() {
		global $jdn_print;
		return wpautop(wptexturize($jdn_print->get_order($_GET['order'])->customer_note));
	}
}

/**
 * Return order id
 */
if (!function_exists('jdn_order_number')) {
	function jdn_order_number() {
		return $_GET['order'];
	}
}

/**
 * Return order date
 */
if (!function_exists('jdn_order_date')) {
	function jdn_order_date() {
		global $jdn_print;
		$order = $jdn_print->get_order($_GET['order']);
		return date(get_option('date_format'), strtotime($order->order_date));
	}
}

/**
 * Return the order items
 */
if (!function_exists('jdn_get_order_items')) {
	function jdn_get_order_items() {
		global $jdn_print;
		return $jdn_print->get_order_items($_GET['order']);
	}
}

/**
 * Return the order items price
 */
if (!function_exists('jdn_format_price')) {
	function jdn_format_price($price, $tax_rate = 0) {
		$tax_included = ($tax_rate > 0) ? 0 : 1;
		return jigoshop_price((($price / 100) * $tax_rate) + $price, array('ex_tax_label' => $tax_included));
	}
}

/**
 * Return the order subtotal
 */
if (!function_exists('jdn_order_subtotal')) {
	function jdn_order_subtotal() {
		global $jdn_print;
		return $jdn_print->get_order($_GET['order'])->get_subtotal_to_display();
	}
}

/**
 * Return the order tax
 */
if (!function_exists('jdn_order_tax')) {
	function jdn_order_tax() {
		global $jdn_print;
		return jigoshop_price($jdn_print->get_order($_GET['order'])->get_total_tax());
	}
}

/**
 * Return the order shipping
 */
if (!function_exists('jdn_order_shipping')) {
	function jdn_order_shipping() {
		global $jdn_print;
		return $jdn_print->get_order($_GET['order'])->get_shipping_to_display();
	}
}

/**
 * Return the order discount
 */
if (!function_exists('jdn_order_discount')) {
	function jdn_order_discount() {
		global $jdn_print;
		return jigoshop_price($jdn_print->get_order($_GET['order'])->order_discount);
	}
}

/**
 * Return the order grand total
 */
if (!function_exists('jdn_order_total')) {
	function jdn_order_total() {
		global $jdn_print;
		return jigoshop_price($jdn_print->get_order($_GET['order'])->order_total);
	}
}

/**
 * Return if the order has a shipping
 */
if (!function_exists('jdn_has_shipping')) {
	function jdn_has_shipping() {
		global $jdn_print;
		return ($jdn_print->get_order($_GET['order'])->order_shipping > 0) ? true : false;
	}
}

/**
 * Return if the order has a tax
 */
if (!function_exists('jdn_has_tax')) {
	function jdn_has_tax() {
		global $jdn_print;
		return ($jdn_print->get_order($_GET['order'])->get_total_tax() > 0) ? true : false;
	}
}

/**
 * Return if the order has a discount
 */
if (!function_exists('jdn_has_discount')) {
	function jdn_has_discount() {
		global $jdn_print;
		return ($jdn_print->get_order($_GET['order'])->order_discount > 0) ? true : false;
	}
}

/**
 * Return policy for returns
 */
if (!function_exists('jdn_returns_policy')) {
	function jdn_returns_policy() {
		global $jdn_print;
		return wpautop(wptexturize($jdn_print->get_setting('returns')));
	}
}

/*
 * Output the template
 */
echo $jdn_print->get_template_content();

?>