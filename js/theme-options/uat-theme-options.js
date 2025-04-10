jQuery('.opt_import_cls').click(function(){
      import_demo_data()
 });
 
 function import_demo_data(){
	 jQuery.ajax({
		url:ajaxurl ,
		type: "post",
		data: {
			action: 'fun_import_demo_data_ajax',
			setp: '1',
		 },
		beforeSend: function() {
			jQuery('#data_result').html('Loading...');
		},
		success: function(data){
			jQuery("#data_result").html(data);
		 },
		error:function(){
			 console.log('failure!');
		}
	 });
}
(function($) {
    $.QueryString_optionpage = (function(a) {
        if (a == "") return {};
        var b = {};
        for (var i = 0; i < a.length; ++i)
        {
            var p=a[i].split('=');
            if (p.length != 2) continue;
            b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }
        return b;
    })(window.location.search.substr(1).split('&'))
})(jQuery);
 
// Usage
var optionpage = jQuery.QueryString_optionpage["page"];		
if(optionpage=='ua-auctions-theme-options'){
	(function($){
		acf.addAction('load', function(){
		var cururl = window.location.pathname;
		var curpage = cururl.substr(cururl.lastIndexOf('/') + 1);
		var optionpage = jQuery.QueryString_optionpage["page"];		
		if(optionpage=='ua-auctions-theme-options'){
			var hash = window.location.hash.substr(1);			
				if(hash=="")
				{}
				else
				{
					$(".acf-tab-group li").each(function()
					{
						$(this).removeClass("active");
					});
					
					if(hash != "") {	
						$('a[data-key="'+hash+'"]').click()
						window.location.hash="";
					}
				}				
		}
		});
	})(jQuery);
}

jQuery(document).ready(function($){
	UAT_Options_Ajax_Url = UAT_Options.ajaxurl;
	//alert(UAT_Options_Ajax_Url);
	jQuery( ".reset-layout-section" ).on('click', reset_layout_section);
	function reset_layout_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_reset_layout_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///Menu Section
	jQuery( ".reset-menu-section" ).on('click', reset_menu_section);
	function reset_menu_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_reset_menu_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///Logo Section
	jQuery( ".reset-logo-options" ).on('click', reset_menu_section);
	function reset_menu_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_reset_logo_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///Login & Registration
	jQuery( ".reset-login-registration-section" ).on('click', reset_login_registration_section);
	function reset_login_registration_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_reset_login_registration_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///Footer Section
	jQuery( ".reset-footer-section" ).on('click', reset_footer_section);
	function reset_footer_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_reset_footer_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///CROn Section
	jQuery( ".reset-cron-section" ).on('click', reset_cron_section);
	function reset_cron_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_reset_cron_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///Payment Section
	jQuery( ".reset-payment-section" ).on('click', reset_payment_section);
	function reset_payment_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_reset_payment_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///Soft-Close/Bid Sniping Section
	jQuery( ".reset-uat-anti_snipping-section" ).on('click', reset_anti_snipping_section);
	function reset_anti_snipping_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_reset_uat_anti_snipping_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///Bid Increment Section
	jQuery( ".reset-uat-bid-increment-section" ).on('click', reset_bid_increment_section);
	function reset_bid_increment_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_reset_uat_bid_increment_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///Logs Section
	jQuery( ".reset-log-activity-section" ).on('click', reset_log_activity_section);
	function reset_log_activity_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_reset_log_activity_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///page auction general setting Section
	jQuery( ".reset-uat-page-auction-general-setting-section" ).on('click', reset_uat_page_auction_general_setting_section);
	function reset_uat_page_auction_general_setting_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_page_auction_general_setting_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///page auction details setting Section
	jQuery( ".reset-uat-page-auction-detail-setting-section" ).on('click', reset_uat_page_auction_detail_setting_section);
	function reset_uat_page_auction_detail_setting_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_page_auction_detail_setting_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}

	///page simple auction setting Section
	jQuery( ".reset-uat-page-simple-auction-setting-section" ).on('click', reset_uat_page_simple_auction_setting_section);
	function reset_uat_page_simple_auction_setting_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_page_simple_auction_setting_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///page auction details setting Section
	jQuery( ".reset-uat-page-proxy-auction-setting-section" ).on('click', reset_uat_page_proxy_auction_setting_section);
	function reset_uat_page_proxy_auction_setting_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_page_proxy_auction_setting_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///page auction details setting Section
	jQuery( ".reset-uat-page-silent-auction-setting-section" ).on('click', reset_uat_page_silent_auction_setting_section);
	function reset_uat_page_silent_auction_setting_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_page_silent_auction_setting_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///page auction details setting Section
	jQuery( ".reset-uat-page-event-general-section" ).on('click', reset_uat_page_event_general_section);
	function reset_uat_page_event_general_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_page_event_general_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///page auction details setting Section
	jQuery( ".reset-uat-page-event-list-section" ).on('click', reset_uat_page_event_list_section);
	function reset_uat_page_event_list_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_page_event_list_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///page auction details setting Section
	jQuery( ".reset-uat-page-event-detail-section" ).on('click', reset_uat_page_event_detail_section);
	function reset_uat_page_event_detail_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_page_event_detail_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///Woocommerce Section
	jQuery( ".reset-uat-woocommerce-section" ).on('click', reset_uat_woocommerce_section);
	function reset_uat_woocommerce_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'uat_woocommerce_section',
							},
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
			} else {
			   //nothing to do here
		   }
	}
	///Woocommerce Section
	jQuery( ".reset-uat-all-theme-options" ).on('click', reset_uat_all_theme_options_section);
	function reset_uat_all_theme_options_section( event ) {
		 var r=confirm("Are you sure?")
		   if (r==true)
		   {
				jQuery.ajax({
							type: 'POST',
							url: UAT_Options_Ajax_Url,
							data: {
							action: 'reset_uat_all_theme_options',
							},
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
			} else {
			   //nothing to do here
		   }
	}
}); /* end of document ready */