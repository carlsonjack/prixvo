jQuery(document).ready(function($){	
	
	jQuery('.uat_force_end_now_events').on('click', function(event){
		var event_id = $(this).data('event_id');
	
			jQuery.ajax({
				type : "post",
				url : UATE_Events.ajaxurl,
				data : {action: "uat_admin_force_end_now_event", postid:event_id, ua_nonce : UATE_Events.uat_events_nonce },
				success: function(response) {
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
		event.preventDefault();
	});	
	/* Force make it Live */
	jQuery('.uat_force_make_live_events').on('click', function(event){
		var event_id = $(this).data('event_id');
			jQuery.ajax({
				type : "post",
				url : UATE_Events.ajaxurl,
				data : {action: "uat_admin_force_make_live_now_event", postid:event_id, ua_nonce : UATE_Events.uat_events_nonce },
				success: function(response) {
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
		event.preventDefault();
	});	
	
}); /* end of document ready */