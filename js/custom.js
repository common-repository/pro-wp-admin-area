jQuery(document).ready(function($) {
		// Upload function goes here
		jQuery('.upload_image').click(function() {
		formField = jQuery(this).attr('rel');
		tb_show('UPLOAD IMAGE', 'media-upload.php?type=image&TB_iframe=true');
		return false;
		});
		window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
		jQuery('#'+formField).val(imgurl);
		tb_remove();
		}
	var formfield=null;
	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor = function(html){
		if (formfield) {
			var fileurl = jQuery('img',html).attr('src');
			formfield.val(fileurl);
			tb_remove();
		} else {
			window.original_send_to_editor(html);
		}
		formfield=null;
	};
	jQuery('.lu_upload_button').click(function() {
 		formfield = jQuery(this).parent().parent().find(".text_input");
 		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		jQuery('#TB_overlay,#TB_closeWindowButton').bind("click",function(){formfield=null;});
		return false;
	});
	jQuery(document).keyup(function(e) {
  		if (e.keyCode == 27) formfield=null;
	});
});