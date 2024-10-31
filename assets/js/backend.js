jQuery(document).ready(function($) {

	jQuery("input,select").change(function (){
		generate_shortcode();	
	});
	generate_shortcode();	
	jQuery("#my_shortcode").focusout(function (){
		generate_shortcode();	
	});
	
	$('input[type="number"]').keydown(function(event) {
		//alert(event.keyCode);
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            ((event.keyCode == 65 || event.keyCode == 67 || event.keyCode == 86 ) && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	
	function generate_shortcode()
	{
		var post_length = (jQuery("#sunrise-plugin-field-post_length").val()>1) ? jQuery("#sunrise-plugin-field-post_length").val() : '20';
		var cat_length = (jQuery("#sunrise-plugin-field-cat_length").val()>1) ? jQuery("#sunrise-plugin-field-cat_length").val() : '20';
		var posts = (jQuery("#sunrise-plugin-field-posts").val() > 0) ? jQuery("#sunrise-plugin-field-posts").val() : '2';
		var columns = (jQuery("#sunrise-plugin-field-columns").val()>0) ? jQuery("#sunrise-plugin-field-columns").val() : '3';
		var excerpt_length = (jQuery("#sunrise-plugin-field-excerpt_length").val()>1) ? jQuery("#sunrise-plugin-field-excerpt_length").val() : '20';
		var read_more = (jQuery("#sunrise-plugin-field-read_more").val().length > 2) ? jQuery("#sunrise-plugin-field-read_more").val() : 'Read More...';
		var exclude_cat = (jQuery("#sunrise-plugin-field-exclude_cat").val().length > 0) ? jQuery("#sunrise-plugin-field-exclude_cat").val() : '';
		var include_cat = (jQuery("#sunrise-plugin-field-include_cat").val().length > 0) ? jQuery("#sunrise-plugin-field-include_cat").val() : '';
		var thumbnail = (jQuery("#sunrise-plugin-field-thumbnail:checked").length > 0) ? 'yes' : 'no';
		var new_window = (jQuery("#sunrise-plugin-field-new_window:checked").length > 0) ? 'yes' : 'no';
		var child_cats = (jQuery("#sunrise-plugin-field-child_cats:checked").length > 0) ? 'yes' : 'no';
		var title_only = (jQuery("#sunrise-plugin-field-title_only:checked").length > 0) ? 'yes' : 'no';
		var order_by = jQuery("#sunrise-plugin-field-order_by").val();
		var order_by_type = jQuery("#sunrise-plugin-field-order_by_type").val();
		var limit = (jQuery("#sunrise-plugin-field-limit").val()>0) ? jQuery("#sunrise-plugin-field-limit").val() : '0';
		
		var my_shortcode = "[mycatlist cat_length='" + cat_length + "' post_length='" + post_length + "' excerpt_length='" + excerpt_length + "' title_only='" + title_only + "' thumbnail='" + thumbnail + "' read_more='" + read_more + "' new_window='" + new_window + "' posts='" + posts + "' order_by='" + order_by + "' exclude_cat='" + exclude_cat + "' include_cat='" + include_cat + "' child_cats='" + child_cats + "' columns='" + columns + "' limit='" + limit + "' order_by_type='" + order_by_type + "']";
		
		console.log(my_shortcode);
		jQuery("#my_shortcode").val(my_shortcode);
	}
	
	
	jQuery("#instant_support").click(function (){
		var data = {
		action: 'instant_support',
		name: jQuery("#sunrise-plugin-field-support_name").val(),
		email: jQuery("#sunrise-plugin-field-support_email").val(),
		message: jQuery("#sunrise-plugin-field-support_request").val(),
		};
		jQuery(".auto_hide_this").hide(300);
		jQuery("#sunrise-plugin-options-form").prepend("<div class='updated auto_hide_this'><p>Please wait..<a href='#' style='float:right;text-decoration:underline;' class='ahid'>hide</a></p></div>");
		$.post(ajaxurl, data, function(response) {
			jQuery(".auto_hide_this").hide(300);
			//console.log(response);
			jQuery("#sunrise-plugin-options-form").prepend(response);
			jQuery(".ahid").click(function (){
				jQuery(".auto_hide_this").hide(300);
			});
		});
	
	});

});

