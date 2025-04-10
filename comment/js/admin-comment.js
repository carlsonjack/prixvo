jQuery(document).ready(function($){	
	Comment_Ajaxurl = UAT_Comment.ajaxurl;	
	jQuery( 'span.uat-comments-report-moderate a' ).on( 'click', function( a_element ) {
		var comment_id = jQuery( this ).attr('data-uat-comment-id'); 
		//alert(comment_id);
		if(comment_id){
			jQuery.ajax({
				type: "post",			
				url: Comment_Ajaxurl,
				data: {
					comment_id: comment_id,
					action: "uat_moderate_comment"
				},
				success: function( response ) {
					var data = $.parseJSON( response ); 				
						if( data.status == 1 ) {
							alert(data.success_message);
							window.location.reload();
						} else {
							alert(data.error_message);
							window.location.reload();
						}
				}
			});
		}
		event.preventDefault();
     });
	
}); /* end of document ready */	
