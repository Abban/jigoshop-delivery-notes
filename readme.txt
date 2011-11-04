=== Delivery Notes ===

== Description ==
A simple plugin which adds a new side panel on the order page to allow shop administrators to print out delivery notes.

== Installation ==

= Install =

1. Unzip the `jigoshop-delivery-notes.zip` file. 
1. Upload the the `jigoshop-delivery-notes` folder (not just the files in it!) to your `wp-contents/plugins` folder.

= Activate =

1. In your WordPress administration, go to the Plugins page
2. Activate the Jigoshop - Delivery Notes plugin and a Delivery Note Settings menu will appear
   in your Orders menu.

== Documentation ==

-- Base Usage

Once installed you will see a Delivery Note Settings menu appear under the Orders section of the WP admin navigation. The settings are pretty basic allowing you to add a few fields that are applied to the template.

Click on any order in the Orders menu to see a Delivery Notes box appear on the right hand side of the page with a button saying View & Print Delivery Note. Click on it to open a new page with the default delivery note template. Then use the Print button to print the delivery note from your browser.

-- Custom Templates

If you want to use your own template then all you need to do is copy the `/wp-content/plugins/jigoshop-delivery-notes/delivery-note` folder and paste it
inside your `/wp-content/themes/yourthemename/jigoshop` folder. The folder comes with the default template and the basic CSS file. You can modifiy this until your heart is content.

-- Template functions

Arbitrary php code and all Wordpress functions are available in the template. Besides that there are many Delivery Notes specific template functions. Open the `jigoshop-delivery-notes-print.php` file to see all available functions.