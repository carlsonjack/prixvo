// jQuery('form .uwa_auction_proxy').trigger("change");

jQuery(document).ready(function($){
	$( document.body ).on( 'wcfm_products_manage_form_validate', function( event, validating_form ) {
		if( validating_form ) {
			$form = $(validating_form);
			if(!upDownCheck()){
				$('#' + $form.attr('id') + ' .wcfm-message').html( '<span class="wcicon-status-cancelled"></span>'+uwa_wcfm_params_add_js.invalid_reserve_msg).addClass('wcfm-error').slideDown();
				product_form_is_valid = false;
			}
		}
	});
	// jQuery('input#uwa_auction_proxy').trigger('change');
	// jQuery('input#uwa_auction_silent').trigger('change');
	/* Start Date */
	jQuery('#woo_ua_auction_start_date').datetimepicker({
		defaultDate: "",
		timeFormat: "HH:mm:ss", 
		dateFormat: "yy-mm-dd",
		minDate: 0 ,
		numberOfMonths: 1,		
		showMillisec : 0,
	}); 


	/* End Date */
	jQuery('#woo_ua_auction_end_date').datetimepicker({
		defaultDate: "",
		timeFormat: "HH:mm:ss", 
		dateFormat: "yy-mm-dd",
		minDate: 0 ,
		numberOfMonths: 1,		
		showMillisec : 0,
		/*beforeShow: function(){
			$("#woo_ua_auction_end_date").datetimepicker("option", {
				minDate: $("#woo_ua_auction_start_date").datetimepicker('getDate')
			});
		}*/
	});
	checkAuctionType();
	checkBidVariableType();
	function upDownCheck(){
	    jQuery('input#woo_ua_lowest_price').removeClass("wcfm_validation_failed");
		var is_has_reserve = jQuery("#uwa_auction_has_reserve").is(":checked");
       console.log(is_has_reserve);		
		if (is_has_reserve === true) {
			if(parseFloat($('input#woo_ua_lowest_price').val()) < parseFloat($('input#woo_ua_opening_price').val())){
				$('#wcfm_products_manage_form .wcfm-message').html( '<span class="wcicon-status-cancelled"></span>'+uwa_wcfm_params_add_js.invalid_reserve_msg).addClass('wcfm-error').slideDown();
				jQuery('input#woo_ua_lowest_price').addClass("wcfm_validation_failed");
				jQuery('#woo_ua_lowest_price').focus();
				return false;
			}
		}
		else{
			$('#wcfm_products_manage_form .wcfm-message').html("").removeClass('wcfm-error');
		}
		return true;
		
	}
	jQuery('input#woo_ua_opening_price').on('change', function () {		
		upDownCheck()
		jQuery('input#woo_ua_lowest_price').attr("min",$(this).val());
	});
	jQuery('input#woo_ua_lowest_price').on('change', function () {		
		upDownCheck()
	});
	jQuery('#uwa_auction_has_reserve').on('change', function () {
		if(this.checked) {
			jQuery('#woo_ua_lowest_price').attr("required", true);
			jQuery('#woo_ua_lowest_price').removeAttr("required");
			jQuery('input#woo_ua_lowest_price').css("display", "inline-block"); 
			jQuery('p.woo_ua_lowest_price  ').css("display", "inline-block");
			// jQuery('input#woo_ua_lowest_price').addClass("wcfm_validation_failed"); 
			jQuery('input#woo_ua_lowest_price').attr("data-required", "1"); 
			jQuery('input#woo_ua_lowest_price').attr("data-required_message", "Lowest Price to Accept: This field is required."); 
		}else{
			jQuery('#woo_ua_lowest_price').attr("required", false);
			jQuery('input#woo_ua_lowest_price').css("display", "none"); 
			jQuery('p.woo_ua_lowest_price  ').css("display", "none");
			jQuery('input#woo_ua_lowest_price  ').prop('checked', "");
			jQuery('input#woo_ua_lowest_price').removeClass("wcfm_validation_failed"); 
			jQuery('input#woo_ua_lowest_price').removeAttr("data-required"); 
			jQuery('input#woo_ua_lowest_price').removeAttr("data-required_message"); 
		}
	});
	jQuery('#uwa_auction_has_reserve').trigger("change");
	jQuery('input#uwa_auction_proxy').on('change', function(){
		if(this.checked) {
			jQuery('input#uwa_auction_silent').css("display", "none"); 
			jQuery('p.uwa_auction_silent  ').css("display", "none");
			jQuery('input#uwa_auction_silent  ').prop('checked', ""); 
		} else {
			jQuery('input#uwa_auction_silent  ').css("display", "inline-block");
			jQuery('p.uwa_auction_silent  ').css("display", "inline-block");
		}	
	});
	jQuery('input#uwa_auction_silent').on('change', function(){ 

		if(this.checked) {
			jQuery('input#uwa_auction_proxy').css("display", "none"); 
			jQuery('p.uwa_auction_proxy').css("display", "none");
			jQuery('input#uwa_auction_proxy  ').prop('checked', ""); 

		} else {
			jQuery('input#uwa_auction_proxy').css("display", "inline-block");
			jQuery('p.uwa_auction_proxy').css("display", "inline-block");
		}
	});
 
   jQuery('#uwa_auction_variable_bid_increment').on('change', function(){	
		if(this.checked) {			
			jQuery('.uwa_custom_field_onwards_main').css("display", "block");			
			jQuery('.woo_ua_bid_increment').css("display", "none");
			jQuery('#woo_ua_bid_increment').css("display", "none");
			jQuery('.uwa_auction_variable_bid_increment_type_').css("display", "block");
			jQuery('#woo_ua_bid_increment').val("");			
			
		} else {
			jQuery('p.uwa_variable_bid_increment_main').css("display", "none");
			jQuery('.uwa_custom_field_onwards_main').css("display", "none");
			jQuery('.woo_ua_bid_increment').css("display", "inline-block");
			jQuery('.uwa_auction_variable_bid_increment_type_').css("display", "none");
			jQuery('#woo_ua_bid_increment').css("display", "inline-block");
		}	
	});
	jQuery('input#uwa_auction_variable_bid_increment_type_global').on('change', function(){
		if(this.checked) {
			jQuery('input#uwa_auction_variable_bid_increment_type_custom').css("display", "none"); 
			jQuery('p.uwa_auction_variable_bid_increment_type_custom').css("display", "none");
			jQuery('input#uwa_auction_variable_bid_increment_type_custom').prop('checked', ""); 
			jQuery('p.uwa_variable_bid_increment_main').css("display", "none");
		} else {
			jQuery('input#uwa_auction_variable_bid_increment_type_custom').css("display", "inline-block");
			jQuery('p.uwa_auction_variable_bid_increment_type_custom').css("display", "inline-block");
		}	
	});
	jQuery('input#uwa_auction_variable_bid_increment_type_custom').on('change', function(){ 

		if(this.checked) {
			jQuery('input#uwa_auction_variable_bid_increment_type_global').css("display", "none"); 
			jQuery('p.uwa_auction_variable_bid_increment_type_global').css("display", "none");
			jQuery('input#uwa_auction_variable_bid_increment_type_global').prop('checked', ""); 			

		} else {
			jQuery('input#uwa_auction_variable_bid_increment_type_global').css("display", "inline-block");
			jQuery('p.uwa_auction_variable_bid_increment_type_global').css("display", "inline-block");
		}
	});	


	jQuery('#uwa_auction_variable_bid_increment_type_custom').on('change', function(){	
		if(this.checked) {			
			jQuery('p.uwa_variable_bid_increment_main').css("display", "block"); 
			jQuery('.uwa_custom_field_onwards_main').css("display", "block");			
		} else {
			jQuery('p.uwa_variable_bid_increment_main').css("display", "none");
			jQuery('.uwa_custom_field_onwards_main').css("display", "none");
		}	
	}); 
	
	jQuery('#uat_locationP_address_same_as_store').on('change', function () {
		if(this.checked) {	
			jQuery('input#pac-input').css("display", "none"); 
			jQuery('.uat-ctm-gmap').css("display", "none");
			jQuery('.enter_m_lctn').css("display", "none");
						
		}else{			
			jQuery('input#pac-input').css("display", "inline-block"); 
			//jQuery('.uat-ctm-gmap').css("display", "block"); 
			jQuery('.enter_m_lctn').css("display", "inline-block"); 
			jQuery(".uat-ctm-gmap").show()
		
		}
	});
	var UatWcfmMap = document.getElementById('UatWcfmMap');
	if(UatWcfmMap)
	{
		initMap();
	}

});

function checkAuctionType(){
	var checked = jQuery('input#uwa_auction_silent').attr("checked");
	var checked_ = jQuery('input#uwa_auction_proxy').attr("checked");
	if(checked == 'checked'){
		jQuery('input#uwa_auction_proxy').css("display", "none"); 
		jQuery('p.uwa_auction_proxy').css("display", "none");
	}
	if(checked_ == 'checked'){
		jQuery('input#uwa_auction_silent').css("display", "none"); 
		jQuery('p.uwa_auction_silent  ').css("display", "none");
	}
}

function checkBidVariableType(){
	var checked = jQuery('input#uwa_auction_variable_bid_increment').attr("checked");
	var checked_global = jQuery('input#uwa_auction_variable_bid_increment_type_global').attr("checked");
	var checked_custom = jQuery('input#uwa_auction_variable_bid_increment_type_custom').attr("checked");

	if(checked){
		jQuery('.uwa_auction_variable_bid_increment_type_').css("display", "block"); 
		jQuery('.woo_ua_bid_increment').css("display", "none");
		jQuery('#woo_ua_bid_increment').css("display", "none");
		if(checked_custom){
			jQuery('p.uwa_variable_bid_increment_main').css("display", "block"); 
			
		}else{
			jQuery('p.uwa_variable_bid_increment_main').css("display", "none"); 
		}
	}else{
		jQuery('.woo_ua_bid_increment').css("display", "inline-block");
		jQuery('#woo_ua_bid_increment').css("display", "inline-block");
		jQuery('.uwa_auction_variable_bid_increment_type_').css("display", "none"); 

	}
}

function initMap() {
	var location_lat = document.getElementById("location_lat");
	var location_lng = document.getElementById("location_lng");
	var lat_val = 22.3038945;
	var lat_val = uwa_wcfm_params_add_js.default_lat;
	var lng_val = 70.80215989999999;
	var lng_val = uwa_wcfm_params_add_js.default_lng;
	if(location_lat && location_lat.value != "")
	{
		lat_val = location_lat.value;
	}
	if(location_lng && location_lng.value != "")
	{
		lng_val = location_lng.value;
	}

	var location_zoom = document.getElementById("location_zoom");
	var zoom = 14;
	if(location_zoom && location_zoom.value != "")
	{
		zoom = parseInt(location_zoom.value);
	}
	var centerCoordinates = new google.maps.LatLng(lat_val, lng_val);
	var map = new google.maps.Map(document.getElementById('UatWcfmMap'), {
	center: centerCoordinates,
	zoom: zoom
	});
	var card = document.getElementById('pac-card');
	var input = document.getElementById('pac-input');
	var infowindowContent = document.getElementById('infowindow-content');
	
	map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

	var autocomplete = new google.maps.places.Autocomplete(input);
	
	var marker = new google.maps.Marker({
	  map: map,
	  position: centerCoordinates,
	  
	});

	autocomplete.addListener('place_changed', function() {
		 document.getElementById("location-error").style.display = 'none';
		marker.setVisible(false);
			var place = autocomplete.getPlace();
			if (!place.geometry) {
				  document.getElementById("location-error").style.display = 'inline-block';
				  document.getElementById("location-error").innerHTML = "Cannot Locate '" + input.value + "' on map";
				return;
			}

			let locationArr = formateResult(place);
			let location = document.getElementById("location");
			location.value = JSON.stringify(locationArr);

			map.fitBounds(place.geometry.viewport);
			marker.setPosition(place.geometry.location);
			marker.setVisible(true);
	});
}

function formateResult(obj) {
	var result = {
	  address: obj.formatted_address,
	  lat: obj.geometry.location.lat(),
	  lng: obj.geometry.location.lng(),
	};
	result.zoom = 14;
	if (obj.place_id) {
	  result.place_id = obj.place_id;
	}
	if (obj.name) {
	  result.name = obj.name;
	}
	var map = {
	  street_number: ["street_number"],
	  street_name: ["street_address", "route"],
	  city: ["locality", "postal_town"],
	  state: [
		"administrative_area_level_1",
		"administrative_area_level_2",
		"administrative_area_level_3",
		"administrative_area_level_4",
		"administrative_area_level_5",
	  ],
	  post_code: ["postal_code"],
	  country: ["country"],
	};
	for (var k in map) {
	  var keywords = map[k];
	  for (var i = 0; i < obj.address_components.length; i++) {
		var component = obj.address_components[i];
		var component_type = component.types[0];
		if (keywords.indexOf(component_type) !== -1) {
		  result[k] = component.long_name;
		  if (component.long_name !== component.short_name) {
			result[k + "_short"] = component.short_name;
		  }
		}
	  }
	}
	return result;
  }