jQuery(document).ready( function()
{
	var notes_submit = jQuery("#rb_print_delivery_note");
	notes_submit.bind('click', function()
	{
		// -- Get The Order ID
		var order_id = getParameterByName('post');
		// -- Got The Order ID Now Lets Open A Modal
		var baseURL = jQuery(this).attr("rel");
		//window.open(baseURL + "note-template.php?oid=" + order_id);
		window.open(baseURL + "template-render.php?oid=" + order_id);
		
		return false;
	})
	
	function getParameterByName(name)
	{
	  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	  var regexS = "[\\?&]" + name + "=([^&#]*)";
	  var regex = new RegExp(regexS);
	  var results = regex.exec(window.location.href);
	  if(results == null)
		return "";
	  else
		return decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	


})