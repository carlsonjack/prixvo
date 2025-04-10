jQuery(document).ready(function ($) {
   
	// Perform AJAX login/register on form submit
	$('form#uat-user-login-form, form#uat-user-register-form').on('submit', function (e) {
		
        if (!$(this).valid()) return false;
		action = 'uat_theme_ajaxlogin';
		username = 	$('form#uat-user-login-form #username').val();
		password = $('form#uat-user-login-form #password').val();
		email = '';
		security = $('form#uat-user-login-form #security').val();		
		 
		if(isCardForm=='off'){
			if ($(this).attr('id') == 'uat-user-register-form') {
				$('p.status-reg', this).show().html(ajax_auth_object.loadingmessage);
				action = 'uat_theme_ajaxregister';
				//username = $('#signonname').val();
				password = $('#signonpassword').val();
				/*email = $('form#uat-user-register-form #email').val();	
				//var username = email.replace(/@.*$/,"");
				var username = email.replace(/@.*$/,"").replace(/[^a-zA-Z0-9]+/g, '-');
				//var fullName = $('#signonname').val();*/
				
				var email = $('form#uat-user-register-form #email').val();	
				
				var username_main = $('form#uat-user-register-form #username').val();
				
				if (username_main !== '') {
					var username = username_main;
				}else{
					var username = email.replace(/[^a-zA-Z0-9]+/g, '-');
				}
				
				

				var firstName = $('form#uat-user-register-form #reg_billing_first_name').val();
				var lastName = $('form#uat-user-register-form #reg_billing_last_name').val();
				
				var fullName = firstName+' '+lastName;
				
				if (firstName === undefined && lastName === undefined) {
					firstName = username;
				}
				var switchPlan = jQuery("input[name='switchPlan']:checked").val();
				if (switchPlan === undefined) {
					switchPlan = 'Buyer';
				}

				/*var firstName = fullName.split(' ').slice(0, -1).join(' ');
				var lastName = fullName.split(' ').slice(-1).join(' ');*/
				
				
				billing_country = $('#billing_country').val();
				billing_address_1 = $('#billing_address_1').val();
				billing_address_2 = $('#billing_address_2').val();
				billing_city = $('#billing_city').val();
				billing_state = $('#billing_state').val();
				billing_postcode = $('#billing_postcode').val(); 
				billing_phone = $('#billing_phone').val();       
				security = $('#signonsecurity').val();
					ctrl = $(this);
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: ajax_auth_object.ajaxurl,
						data: {
							'action': action,
							'username': username,
							'password': password,						
							'email': email,
							'firstName': firstName,
							'lastName': lastName,
							'billing_country': billing_country,
							'billing_address_1': billing_address_1,
							'billing_address_2': billing_address_2,
							'billing_city': billing_city,
							'billing_state': billing_state,
							'billing_postcode': billing_postcode,
							'billing_phone': billing_phone,
							'switchPlan': switchPlan,
							'security': security
						},
						success: function (data) {
							console.log(data);
							e.preventDefault();	
							$('p.status-reg', ctrl).html(data.message);
							if (data.loggedin == true) {
								//jQuery.fancybox.open({href: "#uat-login-form-success"});
								//document.location.href = ajax_auth_object.redirecturl;
								jQuery('#uat-register-form').hide();
								jQuery('#my-acc-btn').hide();
								jQuery('#uat-login-form-success').show();
								//window.location.reload(true)
							}
						}
					});	
					e.preventDefault();		
			} 
		}
		if ($(this).attr('id') == 'uat-user-login-form') {
			 $('p.status', this).show().html(ajax_auth_object.loadingmessage);        
			ctrl = $(this);
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: ajax_auth_object.ajaxurl,
						data: {
							'action': action,
							'username': username,
							'password': password,							
							'email': email,
							'security': security
						},
						success: function (data) {
							//console.log(data);
							$('p.status', ctrl).html(data.message);
							if (data.loggedin == true) {
								document.location.href = ajax_auth_object.redirecturl;
								window.location.reload(true)
							}
						}
					});
		}	
		
		
		
		
        e.preventDefault();
    });
		
    if (jQuery("#uat-user-register-form").length) 
		jQuery("#uat-user-register-form").validate(
		{ 
			rules:{			
			billing_address_1: "required",
			billing_city: "required",
			billing_postcode: "required",
			billing_phone: "required",
			billing_country: "required",
			uat_term_condition: "required",
		}}
		);
    else if (jQuery("#uat-user-login-form").length) 
		jQuery("#uat-user-login-form").validate();
	
	
	jQuery.extend(jQuery.validator.messages, {
    required: ajax_auth_object.requiredmessage,    
    email: ajax_auth_object.requiredmessageemail,
	});
	
});