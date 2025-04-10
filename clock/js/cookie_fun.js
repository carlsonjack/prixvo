function setCookie(name, value, days) {
  var expires = "";
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + (value || "") + expires + "; path=/";
}
function getCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
  }
  return null;
}

function jquery_get_new_time(auctionid){
	
	if(timer_type!='timer_jquery'){
		return;
	}
	var grtdate="";
	
	jQuery.ajax({
		url: ajaxurl,
		type: "post",
		dataType: "json",
		data: {
			action: "jquery_get_new_time",
			auctionid: auctionid,
		},
		success: function (data) {
			grtdate = data;	 
			
				var curenttimer = jQuery( ".uwa_auction_product_countdown:eq( 0 )" );
			
			var curenttimer = jQuery( ".uwa_auction_product_countdown:eq( 0 )" );
																				
		 
			var auction_newtime = grtdate;																	
			 			
				/* set newtime */				 														
				/* change time in timer */
				var time1 = auction_newtime;
				curenttimer.WooUacountdown('destroy');
				curenttimer.WooUacountdown({format: 'DHMS',layout: WooUa.jQuery_timer_layout,until:   jQuery.WooUacountdown.UTCDate(-(new Date().getTimezoneOffset()), new Date(time1*1000))});												
			 
		},
		error: function () {
			console.log('failure!');
		}

	});
	return grtdate;
}