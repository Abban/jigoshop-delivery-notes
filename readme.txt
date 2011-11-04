=== Delivery Notes ===

== Description ==
A simple plugin which adds a new side panel on the order page to allow shop administrators to print out delivery notes.

== Contributors ==
Steve Clark 
Baum (Cheers for the work bud)

== Installation ==

= Install =

1. Unzip the `jigoshop-delivery-notes.zip` file. 
1. Upload the the `jigoshop-delivery-notes` folder (not just the files in it!) to your `wp-contents/plugins` folder.

= Activate =

1. In your WordPress administration, go to the Plugins page
2. Activate the Delivery Notes for JigoShop plugin and a subpage for the plugin will appear
   in your Manage menu.

== Documentation ==

-- Base Usage

Once installed you will see a Delivery Note Settings link appear under the orders section of the WP admin navigation.
The settings are pretty basic allowing you to add a few fields that are applied to the template.

If you click on Orders then click on any order you will see a delivery note box appear on the right hand side of the page with 
a button saying "View & Print Delivery Note". If you click on this you will get the default template you then click File and print in your browser
and you will have a delivery note.

-- Custom Templates

If you want to use your own template then all you need to do is copy the /wp-content/plugins/jigoshop-delivery-notes/delivery-note folder and paste it
inside your themes/jigoshop folder. The folder comes with the default template and the basic CSS file (print.css). You can modifiy this until your heart is
content.

-- Tagging Syntax

The plugin  supports the following tags at present.

{company_logo}				- This is a value which is set within the Delivery Notes Settings page
{company_name}				- This value is the Wordpress Site Name (Set in settings > general)
{company_address}			- This is a value which is set within the Delivery Notes Settings page
{company_details}			- This is a value which is set within the Delivery Notes Settings page and includes (Telelphone, email) The website is automatic
{shipping_name}				- Value is passed from JigoShop ( Who its being delivered to )
{shipping_address}			- Value is passed from JigoShop
{order_id}					- Value is passed from JigoShop	
{billing_name}				- Value is passed from JigoShop { Who paid for it )
{billing_email}				- Value is passed from JigoShop
{billing_phone}				- Value is passed from JigoShop
{billing_address}			- Value is passed from JigoShop
{order_summary}				- Value is passed from JigoShop 
{customer_notes}			- Value is passed from JigoShop
{other_info}				- This is a value which is set within the Delivery Notes Settings page (Returns Policy)

== Billing Address Components
{billing_company} 			- Value is passed from JigoShop	
{billing_address_1} 		- Value is passed from JigoShop	
{billing_address_2} 		- Value is passed from JigoShop	
{billing_city}  			- Value is passed from JigoShop	
{billing_postcode}			- Value is passed from JigoShop	
{billing_country} 			- Value is passed from JigoShop	
{billing_state} 			- Value is passed from JigoShop	

== Shipping Address Components
{shipping_company} 			- Value is passed from JigoShop	
{shipping_address_1} 		- Value is passed from JigoShop	
{shipping_address_2} 		- Value is passed from JigoShop	
{shipping_city}  			- Value is passed from JigoShop	
{shipping_postcode}			- Value is passed from JigoShop	
{shipping_country} 			- Value is passed from JigoShop	
{shipping_state} 			- Value is passed from JigoShop	

== Author Comments ==

Im no Wordrpess Guru and this was written as a quick fix for a client of mine because they wanted the abillity to have a button to print a delivery note.
I hope it works for you guys. Free to use under the terms of the MIT license.