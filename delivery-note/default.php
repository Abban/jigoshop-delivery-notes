<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="{css_url}print.css" type="text/css" />
	<script type="text/javascript">
		function openPrintWindow() {
		    window.print();
		}
	</script>
</head>
<body>
<div id="container">
	<div id="header">
		<div class="left-col">
			{company_logo}
			<address>
					<strong>{company_name}</strong>
					{company_address}
			</address>
		</div>
		
		<div class="details">
			{company_details}
		</div>
	</div>

	<div id="address">
		<h2>Delivery Note | Order Number:#{order_id}</h2>
		<div class="col-1">
			<h3>Shipping Address</h3>
			<address>
				<p>
					<b>{shipping_name}</b>, {shipping_address}
				</p>
			</address>
			<dl>
				<dt>Email</dt>
				<dd>{billing_email}</dd>
				<dt>Telephone</dt>
				<dd>{billing_phone}</dd>
			</dl>
		</div><!-- /.col-1 -->

		<div class="col-2">
			<h3>Billing Address</h3>
			<address>
				<b>{billing_name}</b>, {billing_address}
			</address>
		</div><!-- /.col-2 -->
	</div>
	
	
	<div id="items">
		<h2>Items</h2>
		{order_summary}
		<!-- Customer Notes -->
		<table id="notes" cellpadding="5" border="1" cellspacing="0">
			<tr>
				<th>Customer Notes</th>
			</tr>
			<tr>
				<td class="note" style="text-align: left;">{customer_notes}</td>
			</tr>
		</table>
		
		<!-- Returns Poliy -->
		{other_info}	
	</div>
	
	<input type="button" id="printbutton" value="Print Delivery Note" onclick="javascript:openPrintWindow()">
</div>
</body>