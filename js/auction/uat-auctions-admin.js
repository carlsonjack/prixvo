jQuery(document).ready(function ($) {
	
    jQuery('#wpbody-content .woocommerce-progress-form-wrapper .button-primary').on('click', function(){			
						jQuery('#wpbody-content .woocommerce-progress-form-wrapper').addClass('product-dark-background');
	});

	var statusGatway = jQuery(".disabled-gateway").data("status");
	if(statusGatway == true){
		jQuery("input[name='acf[uat_payment_gateway]']").prop("disabled",true);
	}else{
		// console.log(jQuery("input[name='acf[uat_payment_gateway]']").prop("disabled"))
	}
	var closeDiv = jQuery("input[name='acf[uat_payment_gateway]']").closest(".acf-button-group")
	closeDiv.on("click", function(e){
		if(jQuery("input[name='acf[uat_payment_gateway]']").prop("disabled")){

			e.preventDefault();
			alert(UAT_Auction.gateway_error_msg);
		}	
	})
	
	jQuery(".log_check_all").change(function() {
		var checkAll = "";
		if(this.checked) {
			checkAll = "all";
			jQuery(".log_check_one").prop('checked', true);
			jQuery(".post_ids_h").val(checkAll);
		}else{
			checkAll = "";
			jQuery(".log_check_one").prop('checked', false);
			jQuery(".post_ids_h").val(checkAll);
		}
		var linkText = jQuery(".export-link").attr("href");
		var url = new URL(linkText);
		var search_params = url.searchParams;
		search_params.set('post_ids', checkAll);
		url.search = search_params.toString();
		var new_url = url.toString();
		jQuery(".export-link").attr("href", new_url)
	});
	jQuery(".log_check_one").change(function() {
		jQuery(".log_check_all").prop('checked', false);
		jQuery(".post_ids_h").val("");
		var lidsArr = "";
		var lids = jQuery(".post_ids_h").val();
		var oneid =	jQuery(this).data('id');

		var checkedIds = jQuery(".log_check_one:checked");
		var allcheckIds = jQuery(".log_check_one");
		if(allcheckIds.length == checkedIds.length){
			lids = "all";
			jQuery(".log_check_all").prop('checked', true);
			jQuery(".post_ids_h").val(lids);
		}else{
			var checkedIdsArr = [];
			checkedIds.each(function(){
				checkedIdsArr.push(jQuery(this).attr("data-id"));
			});
			lids = checkedIdsArr.join(",")
		}
			var linkText = jQuery(".export-link").attr("href");
			var url = new URL(linkText);
			var search_params = url.searchParams;
			search_params.set('post_ids', lids);
			url.search = search_params.toString();
			var new_url = url.toString();
			jQuery(".export-link").attr("href", new_url)
	});
	/* Start Date */
	jQuery('#woo_ua_auction_start_date').datetimepicker({
		defaultDate: "",
		timeFormat: "HH:mm:ss",
		dateFormat: "yy-mm-dd",
		minDate: 0,
		numberOfMonths: 1,
		showButtonPanel: true,
		showOn: "button",
		buttonImage: UAT_Auction.calendar_image,
		buttonText: 'Select a time',
		buttonImageOnly: true,
		showMillisec: 0,
	});
	jQuery('#woo_ua_auction_end_date').datetimepicker({
		defaultDate: "",
		timeFormat: "HH:mm:ss",
		dateFormat: "yy-mm-dd",
		minDate: 0,
		numberOfMonths: 1,
		showButtonPanel: true,
		showOn: "button",
		buttonImage: UAT_Auction.calendar_image,
		buttonText: 'Select a time',
		buttonImageOnly: true,
		showMillisec: 0,
		beforeShow: function () {
			$("#woo_ua_auction_end_date").datetimepicker("option", {
				minDate: $("#woo_ua_auction_start_date").datetimepicker('getDate')
			});
		}
	});
	/* Start Date */
	jQuery('#uwa_relist_start_date').datetimepicker({
		defaultDate: "",
		timeFormat: "HH:mm:ss",
		dateFormat: "yy-mm-dd",
		minDate: 0,
		numberOfMonths: 1,
		showButtonPanel: true,
		showOn: "button",
		buttonImage: UAT_Auction.calendar_image,
		buttonText: 'Select a time',
		buttonImageOnly: true,
		showMillisec: 0,
	});
	/* Set regular price for other product type */
	jQuery('#general_product_data #_regular_price').on('keyup', function () {
		jQuery('#auction_options #_regular_price').val(jQuery(this).val());
	});
	jQuery("#woo_ua_auction_end_date").keypress(function (event) {
		event.preventDefault();
	});
	/* If Auction product Selected */
	var productType = jQuery('#product-type').val();
	if (productType == 'auction') {
		jQuery('.show_if_simple').show();
		jQuery('.inventory_options').show();
		jQuery('.general_options').show();
		jQuery('#inventory_product_data ._manage_stock_field').addClass('hide_if_auction').hide();
		jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('hide_if_auction').hide();
		jQuery('#inventory_product_data ._sold_individually_field').addClass('hide_if_auction').hide();
		jQuery('#inventory_product_data ._stock_field ').addClass('hide_if_auction').hide();
		jQuery('#inventory_product_data ._backorders_field ').parent().addClass('hide_if_auction').hide();
		jQuery('#inventory_product_data ._stock_status_field ').addClass('hide_if_auction').hide();
		jQuery('.options_group.pricing ').addClass('hide_if_auction').hide();
		jQuery('#uwa-auction-log.postbox').show();
		jQuery('#acf-uat_locationp_address').show();
		//alert("1");
	} else {
		// alert("2");
		jQuery('#acf-uat_locationp_address').hide();
		jQuery('#uwa-auction-log.postbox').hide();
	}
	/* hide inventory_product_data */
	jQuery('select#product-type').on('change', function () {
		var value = jQuery(this).val();
		if (value == 'auction') {
			jQuery('.show_if_simple').show();
			jQuery('.general_options').show();
			jQuery('#inventory_product_data ._manage_stock_field').addClass('hide_if_auction').hide();
			jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('hide_if_auction').hide();
			jQuery('#inventory_product_data ._sold_individually_field').addClass('hide_if_auction').hide();
			jQuery('#inventory_product_data ._backorders_field ').parent().addClass('hide_if_auction').hide();
			jQuery('.options_group.pricing ').addClass('hide_if_auction').hide();
			jQuery('#uwa-auction-log.postbox').show();
			jQuery('#acf-uat_locationp_address').show();
		} else {
			jQuery('#acf-uat_locationp_address').hide();
			jQuery('#uwa-auction-log.postbox').hide();
		}
	});
	/* show virtual and downloadable option for auction product */
	jQuery('label[for="_virtual"]').addClass('show_if_auction');
	jQuery('label[for="_downloadable"]').addClass('show_if_auction');
	/* End Bid Now */
	jQuery('.uwa_force_end_now').on('click', function (event) {
		var auction_id = $(this).data('auction_id');
		jQuery.ajax({
			type: "post",
			url: UAT_Auction.ajaxurl,
			data: { action: "uwa_admin_force_end_now", postid: auction_id, ua_nonce: UAT_Auction.uwa_nonce },
			success: function (response) {
				var data = $.parseJSON(response);
				if (data.status == 1) {
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
	jQuery('.uwa_force_make_live').on('click', function (event) {
		var auction_id = $(this).data('auction_id');
		jQuery.ajax({
			type: "post",
			url: UAT_Auction.ajaxurl,
			data: { action: "uwa_admin_force_make_live_now", auction_id: auction_id, ua_nonce: UAT_Auction.uwa_nonce },
			success: function (response) {
				var data = $.parseJSON(response);
				if (data.status == 1) {
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
	/* Cancel Last bid */
	jQuery('.uwa-admin-table .bid_action a:not(.disabled)').on('click', function (event) {
		var logid = $(this).data('id');
		var postid = $(this).data('postid');
		var curent = $(this);
		jQuery.ajax({
			type: "post",
			url: UAT_Auction.ajaxurl,
			data: { action: "admin_cancel_bid", logid: logid, postid: postid, ua_nonce: UAT_Auction.uwa_nonce },
			success: function (response) {
				var data = $.parseJSON(response);
				if (data.status == 1) {
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
	/* Force Delete  BID */
	jQuery('.uwa_force_delete_bid').on('click', function (event) {
		var logid = $(this).data('id');
		var postid = $(this).data('postid');
		var curent = $(this);
		jQuery.ajax({
			type: "post",
			url: UAT_Auction.ajaxurl,
			data: { action: "admin_cancel_bid", logid: logid, postid: postid, ua_nonce: UAT_Auction.uwa_nonce },
			success: function (response) {
				var data = $.parseJSON(response);
				if (data.status == 1) {
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
	jQuery('#uwa_auction_proxy').on('change', function () {
		if (this.checked) {
			$('#uwa_auction_silent').prop('checked', false);
			$('.form-field.uwa_auction_silent_field  ').css("display", "none");
		} else {
			$('.form-field.uwa_auction_silent_field  ').css("display", "block");
		}
	});
	jQuery('#uwa_auction_silent').on('change', function () {
		if (this.checked) {
			$('#uwa_auction_proxy').prop('checked', false);
			$('.form-field.uwa_auction_proxy_field').css("display", "none");
		} else {
			$('.form-field.uwa_auction_proxy_field').css("display", "block");
		}
	});
	var product_type = jQuery("#product-type").val();
	if (product_type == "auction") {
		var woo_ua_auction_form_type = jQuery("#woo_ua_auction_form_type").val();
		if (woo_ua_auction_form_type == "edit_product") {
			/* make fields disabled when auction is live/expired */
			var woo_ua_auction_status_type = jQuery("#woo_ua_auction_status_type").val();
			if (woo_ua_auction_status_type == "live") {
				jQuery("#woo_ua_auction_start_date").attr("disabled", "disabled");
				/*jQuery("#woo_ua_auction_start_date").datepicker( "option", "disabled", true);*/
			}
			if (woo_ua_auction_status_type == "expired") {
				jQuery("#woo_ua_auction_start_date").attr("disabled", "disabled");
				jQuery("#woo_ua_auction_end_date").attr("disabled", "disabled");
			}
			/* =========  new start  =====   */
			var is_selling_type_auction = jQuery("#uwa_auction_selling_type_auction").is(":checked");
			var is_selling_type_buynow = jQuery("#uwa_auction_selling_type_buyitnow").is(":checked");
			jQuery("div.selling_type_auction").hide();
			jQuery("div.selling_type_buyitnow").hide();
			if (is_selling_type_auction == true) {
				jQuery("div.selling_type_auction").show();
			}
			if (is_selling_type_buynow == true) {
				jQuery("div.selling_type_buyitnow").show();
			}
			/* =========  new end  ======   */
		}
	} /* end of if - producttype */
	/* ======================== new start  ============================ */
	jQuery('#uwa_auction_selling_type_auction').on('click', function () {
		/*jQuery("div.selling_type_auction").toggle();*/
		if (jQuery(this).is(":checked")) {
			jQuery("div.selling_type_auction").slideDown();
		} else {
			jQuery("div.selling_type_auction").slideUp();
		}
	});
	jQuery('#uwa_auction_selling_type_buyitnow').on('click', function () {
		if (jQuery(this).is(":checked")) {
			jQuery("div.selling_type_buyitnow").slideDown();
		} else {
			jQuery("div.selling_type_buyitnow").slideUp();
		}
	});
	/* VALIDATIONS FOR PRO 1.1.1 */
	jQuery('#publish').on('click', function (event) {


		var get_opening_price = jQuery('#woo_ua_opening_price').val();

		var get_bn_price = jQuery('#auction_options #_regular_price').val();

		if (parseInt(get_bn_price) <= parseInt(get_opening_price)) {
			alert("Please Enter Buy Now Price Bigger Than Open Price");
			jQuery('#auction_options #_regular_price').focus();
			event.preventDefault();
		}



		var pro_type = jQuery('#product-type').val();
		if (pro_type == 'auction') {
			var is_selling_type_auction = jQuery("#uwa_auction_selling_type_auction").is(":checked");
			var is_selling_type_buynow = jQuery("#uwa_auction_selling_type_buyitnow").is(":checked");
			//alert(is_selling_type_auction);
			//alert(is_selling_type_buynow);
			jQuery('#woo_ua_opening_price').removeAttr("required");
			jQuery('#woo_ua_lowest_price').removeAttr("required");
			jQuery('#woo_ua_bid_increment').removeAttr("required");
			/* jQuery('#_regular_price').removeAttr("required"); */
			/* first check for selling type only */
			if (is_selling_type_auction == false && is_selling_type_buynow == false) {
				alert("Please select auction selling type");
				jQuery('#uwa_auction_selling_type_auction').focus();
				event.preventDefault();
			}
			else {
				jQuery('#woo_ua_auction_start_date').attr("required", "required");
				jQuery('#woo_ua_auction_end_date').attr("required", "required");
				var op_val = jQuery('#woo_ua_opening_price').val();
				var lp_val = jQuery('#woo_ua_lowest_price').val();
				var buynow_val = jQuery('#_regular_price').val();
				var enddate_val = jQuery('#woo_ua_auction_end_date').val();
				var startdate_val = jQuery('#woo_ua_auction_start_date').val();
				var relist_enddate_val = jQuery('#uwa_relist_end_date').val();
				var relist_startdate_val = jQuery('#uwa_relist_start_date').val();
				var hold_on = jQuery("input[name='sp_automatically_debit']:checked").val();
				if (hold_on == "yes") {
					var sp_type_automatically_debit_hold_type = jQuery("input[name='sp_type_automatically_debit_hold_type']:checked").val();
					if (sp_type_automatically_debit_hold_type == "stripe_charge_hold_fix_amount") {
						var charge_hold_fix_amount = jQuery("input[name='charge_hold_fix_amount']").val();
						if(charge_hold_fix_amount < 0)
						{
							alert(UAT_Auction.fixamount_error_msg);
							jQuery('input[name="charge_hold_fix_amount"]').focus();
							event.preventDefault();
						}

					}
				}
				/* check for - both selling type  */
				if (is_selling_type_auction == true && is_selling_type_buynow == true) {
					jQuery('#woo_ua_opening_price').attr("required", "required");
					jQuery('#woo_ua_lowest_price').attr("required", "required");
					jQuery('#uwa_number_of_next_bids').attr("required", "required");
					/*if (op_val <= 0 ) { /*|| buynow_val <= 0){
						alert(UAT_Auction.invalid_auction_selling_type_msg);
						jQuery('#woo_ua_opening_price').focus();
						event.preventDefault();
					}*/

					var reserve_cheked = document.getElementById('uwa_auction_has_reserve').checked;
					if (reserve_cheked && lp_val <= 0) { 
						alert(UAT_Auction.invalid_reserve_msg);
						jQuery('#woo_ua_lowest_price').focus();
						event.preventDefault();
					}
				}
				/* check for - auction selling type  */
				else if (is_selling_type_auction == true) {
					jQuery('#woo_ua_opening_price').attr("required", "required");
					jQuery('#woo_ua_lowest_price').attr("required", "required");
					jQuery('#uwa_number_of_next_bids').attr("required", "required");
					/*if(op_val == ""  || lp_val == "" || bid_val == ""){*/
					/*if (op_val <= 0 ) {
						alert(UAT_Auction.invalid_auction_data_msg);
						jQuery('#woo_ua_opening_price').focus();
						event.preventDefault();
					}*/
					var reserve_cheked = document.getElementById('uwa_auction_has_reserve').checked;
					if (reserve_cheked && lp_val <= 0) {
						alert(UAT_Auction.invalid_reserve_msg);
						jQuery('#woo_ua_lowest_price').focus();
						event.preventDefault();
					}
				}
				/* check for - buyitnow selling type -- recheck */
				else if (is_selling_type_buynow == true) {
				}
				/*  -------  common fields to check  -------- */
				if (enddate_val == "" || startdate_val == "") {
					alert(UAT_Auction.invalid_auction_date_invalid_msg);
					event.preventDefault();
				}
				else if (startdate_val != "" && enddate_val != "") {
					sd_obj = new Date(startdate_val);
					ed_obj = new Date(enddate_val);
					sd_time = sd_obj.getTime();
					ed_time = ed_obj.getTime();
					if (sd_time > ed_time || sd_time == ed_time) {
						alert(UAT_Auction.invalid_auction_date_less_msg);
						jQuery('#woo_ua_auction_end_date').focus();
						event.preventDefault();
					}
				}
				
			} /* end of else */
		} /* end of if pro_type */
		else if (pro_type != 'auction') {
			jQuery('#woo_ua_opening_price').removeAttr("required");
			jQuery('#woo_ua_lowest_price').removeAttr("required");
			jQuery('#woo_ua_auction_end_date').removeAttr("required");
			jQuery('#woo_ua_auction_start_date').removeAttr("required");
		}
	}); /* end of validations */
	
	jQuery('#uwa_auction_has_reserve').on('change', function () {
		if(this.checked) {
			jQuery('#woo_ua_lowest_price').attr("required", true);
			jQuery("p.woo_ua_lowest_price_field").show()
		}else{
			jQuery('#woo_ua_lowest_price').removeAttr("required");
			jQuery("p.woo_ua_lowest_price_field").hide()
		}
	});
	jQuery('#uwa_auction_has_reserve').trigger("change");
	jQuery('#uwa_auction_variable_bid_increment').on('change', function () {
		if (this.checked) {
			jQuery('p.uwa_variable_bid_increment_main').css("display", "block");
			jQuery('.uwa_custom_field_onwards_main').css("display", "block");
			jQuery('.form-field.woo_ua_bid_increment_field').css("display", "none");
			jQuery('#woo_ua_bid_increment').val("");
			jQuery('fieldset.uwa_auction_variable_bid_increment_type_field').css("display", "block");
		} else {
			jQuery('p.uwa_variable_bid_increment_main').css("display", "none");
			jQuery('.uwa_custom_field_onwards_main').css("display", "none");
			jQuery('.form-field.woo_ua_bid_increment_field').css("display", "block");
			jQuery('fieldset.uwa_auction_variable_bid_increment_type_field').css("display", "none");
		}
		setVariableIncBox();
	});

	function setVariableIncBox(){
		if(jQuery('input[name="uwa_auction_variable_bid_increment"]').prop("checked")){
			jQuery('fieldset.uwa_auction_variable_bid_increment_type_field').css("display", "block");

			if (jQuery('input[name="uwa_auction_variable_bid_increment_type"]:checked').val() == 'custom') {
				jQuery('.uwa_variable_bid_increment_main').css("display", "block");
				jQuery('.uwa_custom_field_onwards_main').css("display", "block");
			} else {
				jQuery('.uwa_variable_bid_increment_main').css("display", "none");
				jQuery('.uwa_custom_field_onwards_main').css("display", "none");
				jQuery('#').css("display", "none");
			}
		}else{
			jQuery('fieldset.uwa_auction_variable_bid_increment_type_field').css("display", "none");
		}
		if(jQuery('input[name="uwa_event_auction"]').prop("checked")){
			jQuery('fieldset.uwa_auction_variable_bid_increment_type_field').css("display", "none");
		}
	}
	jQuery('input[name="uwa_auction_variable_bid_increment_type"]').on('change', function () {
		setVariableIncBox();
	});
	setVariableIncBox();
	if (jQuery('input[name="uwa_auction_variable_bid_increment_type"]').val() != 'custom'){
		jQuery('.uwa_custom_field_onwards_main').css("display", "none");
	}
	/* ======================== new end  ============================ */
	// Events in Auction Form
	jQuery('#uwa_event_auction').on('change', function () {
		if (this.checked) {
			// alert("123");
			jQuery('.hide_for_uat_event').css("display", "none");
			jQuery('.show_for_uat_event').css("display", "block");
			jQuery('#acf-uat_locationp_address').hide();
			jQuery(".selling_type_buyitnow").css("display", "none");

			jQuery("#bn_main").hide();
			jQuery("#uwa_auction_selling_type_buyitnow").prop('checked', false);;
			jQuery('fieldset.uwa_auction_variable_bid_increment_type_field').css("display", "none");

		} else {
			jQuery('.hide_for_uat_event').css("display", "block");
			jQuery('.show_for_uat_event').css("display", "none");
			jQuery('#acf-uat_locationp_address').show();
			jQuery(".selling_type_buyitnow").css("display", "block");
			jQuery("#bn_main").show();
			jQuery('fieldset.uwa_auction_variable_bid_increment_type_field').css("display", "block");
		}
		setVariableIncBox();
	});
	if (jQuery('#uwa_event_auction').is(':checked')) {
		jQuery('.hide_for_uat_event').css("display", "none");
		jQuery(".selling_type_buyitnow").css("display", "none");
		jQuery('.show_for_uat_event').css("display", "block");
		jQuery('#acf-uat_locationp_address').hide();
	} else {
		var productType = jQuery('#product-type').val();
		if (productType == 'auction') {	
			jQuery('#acf-uat_locationp_address').show();
			jQuery('.hide_for_uat_event').css("display", "block");
			jQuery(".selling_type_buyitnow").css("display", "block");
			jQuery('.show_for_uat_event').css("display", "none");
		}
	}
}); /* end of document ready */