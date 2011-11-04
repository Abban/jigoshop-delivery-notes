<?php

/**
 * Base class
 */
if (!class_exists('Jigoshop_Delivery_Notes')) {
class Jigoshop_Delivery_Notes {

	public $prefix;
	public $plugin_url;
	public $plugin_path;

	/**
	 * Constructor
	 */
	public function Jigoshop_Delivery_Notes() {
		$this->prefix = 'jdn_';
		$this->plugin_url = plugin_dir_url(__FILE__);
		$this->plugin_path = plugin_dir_path(__FILE__);
	}
}
}

/**
 * Admin class
 */
if (!class_exists('Jigoshop_Delivery_Notes_Admin')) {
class Jigoshop_Delivery_Notes_Admin extends Jigoshop_Delivery_Notes
{

	/**
	 * Constructor
	 */
	public function Jigoshop_Delivery_Notes_Admin() {
		parent::Jigoshop_Delivery_Notes();

		// Load the plugin when Jigoshop is enabled
		if ( in_array( 'jigoshop/jigoshop.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			add_action('init', array($this, 'load_all_hooks'));
		}
	}

	/**
	 * Load the hooks
	 */
	public function load_all_hooks() {	
		load_plugin_textdomain('jigoshop-delivery-notes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		add_action( 'admin_print_styles', array( $this, 'add_styles' ) );
		add_action( 'admin_print_scripts', array( $this, 'add_scripts' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_box' ) );
		add_action('admin_menu', array( $this, 'add_menu'));
	}

	/**
	 * Add the styles
	 */
	public function add_styles() {
		wp_enqueue_style('thickbox');
	}

	/**
	 * Add the scripts
	 */
	public function add_scripts() {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
	}

	/**
	 * Add the box
	 */
	public function add_box() {
		add_meta_box( 'jigoshop-delivery-notes-box', __( 'Delivery Notes', 'jigoshop-delivery-notes' ), array( $this, 'create_box_content' ), 'shop_order', 'side', 'default');
	}

	/**
	 * Create the box content
	 */
	public function create_box_content() {
		global $post_id;

		?><table class="form-table">
		<tr>
			<td><a href="<?php echo $this->plugin_url; ?>jigoshop-delivery-notes-print.php?order=<?php echo $post_id; ?>" id="print_delivery_note" class="button button-primary" target="_blank"><?php _e('View &amp; Print Delivery Note', 'jigoshop-delivery-notes'); ?></a></td>
		</tr>
	</table><?php
	}

	/**
	 * Add the menu
	 */
	public function add_menu() {
		add_submenu_page('edit.php?post_type=shop_order', __('Delivery Notes Settings', 'jigoshop-delivery-notes'), __('Delivery Notes Settings', 'jigoshop-delivery-notes'), 'manage_options', 'jigoshop_delivery_notes_settings', array($this, 'create_menu_content') );
	}

	/**
	 * Create the menu content
	 */
	public function create_menu_content() {
		// Check the user capabilities
		if (!current_user_can('manage_options')) {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}

		// Save the field values
		$fields_submitted = $this->prefix . 'fields_submitted';
		if ( isset($_POST[ $fields_submitted ]) && $_POST[ $fields_submitted ] == 'submitted' ) {
			foreach ($_POST as $key => $value) {
				if ( get_option( $key ) != $value ) {
					update_option( $key, $value );
				}
				else {
					add_option( $key, $value, '', 'no' );
				}
			}

			?><div id="setting-error-settings_updated" class="updated settings-error">
			<p><strong><?php _e('Settings saved.'); ?></strong></p>
		</div><?php
		}

		// Show the fields
		?><div class="wrap">
		<h2><?php _e('Delivery Notes Settings', 'jigoshop-delivery-notes'); ?></h2>
		<form method="post" action="">
			<input type="hidden" name="<?php echo $fields_submitted; ?>" value="submitted">

			<table class="form-table">
				<tbody>
					<tr>
						<th>
							<label for="<?php echo $this->prefix; ?>address"><?php _e('Address:', 'jigoshop-delivery-notes'); ?></label>
						</th>
						<td>
							<textarea name="<?php echo $this->prefix; ?>address" rows="6" class="large-text"><?php echo get_option($this->prefix . 'address'); ?></textarea>
							<span class="description"><?php _e('The postal address of the company, maybe add some other contact information like the telephone and email.', 'jigoshop-delivery-notes'); ?></span>
						</td>
					</tr>
					<tr>
						<th>
							<label for="<?php echo $this->prefix; ?>returns"><?php _e('Returns Policy:', 'jigoshop-delivery-notes'); ?></label>
						</th>
						<td>
							<textarea name="<?php echo $this->prefix; ?>returns" rows="6" class="large-text"><?php echo get_option($this->prefix . 'returns'); ?></textarea>
							<span class="description"><?php _e('The returns policy in case the client would like to send back some goods.', 'jigoshop-delivery-notes'); ?></span>
						</td>
					</tr>
				</tbody>
			</table>

			<p class="submit">
				<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
			</p>
		</form>
	</div><?php
	}
}
}

/**
 * Print class
 */
if (!class_exists('Jigoshop_Delivery_Notes_Print')) {
class Jigoshop_Delivery_Notes_Print extends Jigoshop_Delivery_Notes
{
	public $template_name;
	public $template_dir_name;
	public $template_dir_url;
	public $template_dir_path;

	private $order;

	/**
	 * Constructor
	 */
	public function Jigoshop_Delivery_Notes_Print() {
		parent::Jigoshop_Delivery_Notes();

		$this->template_name = 'template.php';
		$this->template_dir_name = 'delivery-note/';
		$this->template_dir_url = $this->plugin_url . $this->template_dir_name;
		$this->template_dir_path = $this->plugin_path . $this->template_dir_name;
	}

	/**
	 * Read the template file
	 */
	public function get_template_content() {
		// Check for a custom template folder in the theme
		$is_custom_html = @file_exists( trailingslashit(get_template_directory()) . 'jigoshop/' . $this->template_dir_name . $this->template_name);
		if ($is_custom_html) {
			$this->template_dir_url = trailingslashit(get_template_directory_uri()) . 'jigoshop/' . $this->template_dir_name;
			$this->template_dir_path = trailingslashit(get_template_directory()) . 'jigoshop/' . $this->template_dir_name;
		}

		// Read the file
		ob_start();
		require_once $this->template_dir_path . $this->template_name;
		$content = ob_get_clean();

		return $content;
	}

	/**
	 * Get the current order
	 */
	public function get_order($order_id) {
		if (!isset($this->order) && $order_id) {
			$this->order = new jigoshop_order( $order_id );
		}
		return $this->order;
	}

	/**
	 * Get the current order items
	 */
	public function get_order_items($order_id) {
		$items = $this->get_order($order_id)->items;
		$data_list = array();

		foreach ($items as $item) {
			$data = array();
			$data['name'] = $item['name'];
			$data['variation'] = null;
			$data['quantity'] = $item['qty'];
			$data['price'] = jigoshop_price($item['cost'] * $item['qty'], array('ex_tax_label' => 1));
			$data['taxrate'] = $item['taxrate'];

			if (isset($item['variation_id']) && $item['variation_id'] > 0) {
				$product = new jigoshop_product_variation( $item['variation_id'] );
				$data['variation'] = jigoshop_get_formatted_variation($product->get_variation_attributes(), true);
			}

			$data_list[] = $data;
		}

		return $data_list;
	}

	/**
	 * Get the content for an option
	 */
	public function get_setting($name) {
		return get_option($this->prefix . $name);
	}
}
}
?>