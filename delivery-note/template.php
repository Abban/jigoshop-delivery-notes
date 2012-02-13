<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php _e('Delivery Note', 'jigoshop-delivery-notes'); ?></title>
	<link rel="stylesheet" href="<?php echo jdn_template_url(); ?>style.css" type="text/css" media="screen,print" charset="utf-8"/>
	<script type="text/javascript">
		function openPrintWindow() {
		    window.print();
		}
	</script>
</head>

<body>
	<div id="container">
		<div id="header">
			<div class="options">
				<a href="#print" onclick="javascript:openPrintWindow();return false;"><?php _e('Print'); ?></a>
			</div>
		</div>

		<div id="content">			
			<div id="page">
				<div id="letterhead">
					<div id="kind"><?php _e('Delivery Note', 'jigoshop-delivery-notes'); ?></div>
					<div id="company-name"><?php echo jdn_company_name(); ?></div>
					<div id="company-info"><?php echo jdn_company_info(); ?></div>
				</div>
				
				<div id="info">
					<div id="recipient-info">
						<?php if(jdn_shipping_company()) : ?><?php echo jdn_shipping_company(); ?><br/><?php endif; ?>
						<?php echo jdn_shipping_name(); ?><br/>
						<?php echo jdn_shipping_address_1(); ?><br/>
						<?php if(jdn_shipping_address_2()) : ?><?php echo jdn_shipping_address_2(); ?><br/><?php endif; ?>
						<?php echo jdn_shipping_city(); ?>, <?php echo jdn_shipping_state(); ?>, <?php echo jdn_shipping_postcode(); ?>
						<?php if(jdn_shipping_country()) : ?><br/><?php echo jdn_shipping_country(); ?><?php endif; ?>
					</div>
					
					<table id="order-info">
						<tbody>
							<tr>
								<th id="order-number-label"><?php _e('Order', 'jigoshop'); ?></th>
								<td id="order-number"><?php echo jdn_order_number(); ?></td>
							</tr>
							<tr>
								<th id="order-date-label"><?php _e('Date', 'jigoshop'); ?></th>
								<td id="order-date"><?php echo jdn_order_date(); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div id="items">
					<table>
						<thead>
							<tr>
								<th class="description" id="description-label"><?php _e('Name', 'jigoshop'); ?></th>
								<th class="quantity" id="quantity-label"><?php _e('Quantity', 'jigoshop'); ?></th>
								<th class="price" id="price-label"><?php _e('Price', 'jigoshop'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php $items = jdn_get_order_items(); foreach($items as $item) : ?><tr>
								<td class="description"><?php echo $item['name']; ?><?php if($item['variation']) : ?> <span class="variation"><?php echo $item['variation']; ?></span><?php endif; ?></td>
								<td class="quantity"><?php echo $item['quantity']; ?></td>
								<td class="price"><?php echo $item['price'] ?></td>
							<tr><?php endforeach; ?>
						</tbody>
					</table>
				</div>
				
				<div id="summary">
					<table>
						<tbody>
							<tr>
								<th class="description" id="subtotal-label"><?php _e('Subtotal', 'jigoshop'); ?></th>
								<td class="price" id="subtotal-number"><?php echo jdn_order_subtotal(); ?></td>
							</tr>
							<?php if(jdn_has_shipping()) : ?>
							<tr>
								<th class="description" id="tax-label"><?php _e('Shipping', 'jigoshop'); ?></th>
								<td class="price" id="tax-number"><?php echo jdn_order_shipping(); ?></td>
							</tr>
							<?php endif; ?>
							<?php if(jdn_has_tax()) : ?>
							<tr>
								<th class="description" id="tax-label"><?php _e('Tax', 'jigoshop'); ?></th>
								<td class="price" id="tax-number"><?php echo jdn_order_tax(); ?></td>
							</tr>
							<?php endif; ?>
							<?php if(jdn_has_discount()) : ?>
							<tr>
								<th class="description" id="tax-label"><?php _e('Discount', 'jigoshop'); ?></th>
								<td class="price" id="tax-number"><?php echo jdn_order_discount(); ?></td>
							</tr>
							<?php endif; ?>
							<tr>
								<th class="description" id="total-label"><?php _e('Grand Total', 'jigoshop'); ?></th>
								<td class="price" id="total-number"><?php echo jdn_order_total(); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
	
				<div id="notes">
					<div id="personal"><?php echo jdn_personal_notes(); ?></div>
				</div>
				
				<div id="letterfoot">
					<div class="note"><?php echo jdn_refunds(); ?></div>
					<div class="note"><?php echo jdn_terms_and_conditions(); ?></div>
					<div class="note last"><?php echo jdn_shipping_notes(); ?></div>
				</div>
			</div>
		</div>
		
		<div id="footer">
			<div class="options">
				<a href="#print" onclick="javascript:openPrintWindow();return false;"><?php _e('Print'); ?></a>
			</div>
		</div>
	</div>
</body>
</html>