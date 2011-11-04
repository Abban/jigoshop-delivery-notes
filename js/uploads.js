jQuery(document).ready(function($) 
{
	var uploadBtns = $('.upload-button').bind('click', function()
	{
		var ref = $(this)
		ref.tabIndex = ref.attr("id");
		window.send_to_editor = function(html) 
		{
			imgurl = jQuery('img',html).attr('src');
			$("."+ref.tabIndex).val(imgurl)
			 tb_remove();
		}
		tb_show('', 'media-upload.php?post_id=1&amp;type=image&amp;TB_iframe=true');
		return false;
	})
	
});

