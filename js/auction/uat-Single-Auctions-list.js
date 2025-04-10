var popupAuctionId = "";
var pupupUpdateInterval = "";

jQuery(document).ready(function($){

	UAT_Ajax_Url = AuctionsLIST.ajaxurl;

	/* --------------------------------------------------------
	Grid /List view
	----------------------------------------------------------- */
	jQuery('.item i').on('click', function(){
     // jQuery(this).toggleClass('fa-plus fa-minus').next().slideToggle()
    })
    /* list or grid item*/
    jQuery(".view i").click(function(){

      jQuery('.prod').removeClass('grid-view list-view').addClass($(this).data('view'));

    })
    jQuery(".view i").click(function(){

      jQuery(this).addClass('selected').siblings().removeClass('selected');

    })



	/* --------------------------------------------------------
	Load Products on Single Product List without Events
	----------------------------------------------------------- */
	if (jQuery('.SProductsSearch-results').length > 0) {

		jQuery( ".ajax_search_btn" ).on('click', function() {
			load_Single_Products_serach_result(1);
		});
		jQuery( ".p_cats" ).change(function() {
			load_Single_Products_serach_result(1);
		});
		jQuery( ".SPCountries" ).change(function() {
			load_Single_Products_serach_result(1);
		});
		jQuery( ".SPStates" ).change(function() {
			load_Single_Products_serach_result(1);
		});

		jQuery( ".SPCities" ).change(function() {
			load_Single_Products_serach_result(1);
		});

		jQuery('.sortbyenddate').on('click', function(){
			load_Single_Products_serach_result(1);
		});

	jQuery(document).on('click','.RemoveSPFilter',function(evt){
		evt.preventDefault();
		var taxonomy = jQuery(this).data('taxonomy');
		var ID = jQuery(this).data('value');

		if(taxonomy=="uat-event-SPCountries"){
		var SPCountries = jQuery(this).data('value');
			SPCountries = SPCountries.replace(/\s/g,'');
			if(taxonomy=="uat-event-SPCountries"){
				jQuery('#SPCountries_'+SPCountries).prop('checked', false); // Unchecks it
				jQuery('#SPCountriesM_'+SPCountries).prop('checked', false); // Unchecks it
			}
		}

		if(taxonomy=="uat-event-SPStates"){
		var SPStates = jQuery(this).data('value');
			SPStates = SPStates.replace(/\s/g,'');
			if(taxonomy=="uat-event-SPStates"){
				jQuery('#SPStates_'+SPStates).prop('checked', false); // Unchecks it
				jQuery('#SPStatesMobileM_'+SPStates).prop('checked', false); // Unchecks it
			}
		}
		if(taxonomy=="uat-event-SPCities"){
		var SPCities = jQuery(this).data('value');
			SPCities = SPCities.replace(/\s/g,'');
			if(taxonomy=="uat-event-SPCities"){
				jQuery('#SPCities_'+SPCities).prop('checked', false); // Unchecks it
				jQuery('#SPCitiesMobileM_'+SPCities).prop('checked', false); // Unchecks it
			}
		}

		if(taxonomy=="uat-event-cat") {
			jQuery('#cat_'+ID).prop('checked', false); // Unchecks it
			jQuery('#catM_'+ID).prop('checked', false); // Unchecks it
		}
		if(taxonomy=="date-range-filtered") {
			jQuery(".from_date").val("");
			jQuery(".to_date").val("");
		}

		load_Single_Products_serach_result(1);
		return false;
	});

	//see all Location list in filter hide show
		size_li = jQuery(".SPCountriesList li").size();
		x=5;
		jQuery('.SPCountriesList li:lt('+x+')').show();
		if(x >= size_li){
			jQuery('.see_all_SPCountries_div').hide();
		}
		jQuery('.see_all_SPCountries_btn').click(function () {
			//x= (x+5 <= size_li) ? x+5 : size_li;
			x= size_li;
			jQuery('.SPCountriesList li:lt('+x+')').show();
			jQuery('.see_all_SPCountries_div').hide();
		});

		//see all category list in filter hide show
		size_li = jQuery(".eCategoryList li").size();
		x=5;
		jQuery('.eCategoryList li:lt('+x+')').show();
		if(x >= size_li){
			jQuery('.see_all_cats_div').hide();
		}
		jQuery('.see_all_cats_btn').click(function () {
			//x= (x+5 <= size_li) ? x+5 : size_li;
			x= size_li;
			jQuery('.eCategoryList li:lt('+x+')').show();
			jQuery('.see_all_cats_div').hide();
		});

	jQuery(document).on('click','.all',function(evt){
		evt.preventDefault();
		jQuery(".from_date").val("");
		jQuery(".to_date").val("");
		jQuery(".ajax_search_str").val("");
		jQuery('.SPCountries').prop('checked', false); // Unchecks it
		jQuery('.SPStates').prop('checked', false); // Unchecks it
		jQuery('.SPCities').prop('checked', false); // Unchecks it
		jQuery('.p_cats').prop('checked', false); // Unchecks it
		jQuery("#pricerange_bid_from").val("");
		jQuery("#pricerange_bid_to").val("");
		jQuery("#pricerange_estiamte_price_from").val("");
		jQuery("#pricerange_estiamte_price_to").val("");
		jQuery(".ajax_products_search_str").val("");
		load_Single_Products_serach_result(1);
	});

	jQuery(document).on('click','.clear-SPfilter',function(evt){
		evt.preventDefault();
		jQuery(".from_date").val("");
		jQuery(".to_date").val("");
		jQuery(".ajax_search_str").val("");
		jQuery('.SPCountries').prop('checked', false); // Unchecks it
		jQuery('.SPStates').prop('checked', false); // Unchecks it
		jQuery('.SPCities').prop('checked', false); // Unchecks it
		jQuery('.p_cats').prop('checked', false); // Unchecks it
		jQuery(".no-result-found").hide();
		jQuery(".ajax_products_search_str").val("");		
		jQuery("#pricerange_estiamte_price_from").val("");
		jQuery("#pricerange_estiamte_price_to").val("");		
		jQuery("#pricerange_bid_from").val("");
		jQuery("#pricerange_bid_to").val("");
		load_Single_Products_serach_result(1);
	});

	load_Single_Products_serach_result(1);

	 jQuery(".Uat_Expand").click(function (e) {
      var showElementDescription = jQuery(this).parents(".expandableCollapsibleDiv").find("ul.estateUL");

      if (jQuery(showElementDescription).is(":visible")) {
        showElementDescription.hide("fast", "swing");
		jQuery(this).removeClass('fa-minus');
		jQuery(this).addClass('fa-plus');
      } else {
        showElementDescription.show("fast", "swing");
         jQuery(this).addClass('fa-minus');
		 jQuery(this).removeClass('fa-plus');
      }
    });

	  jQuery(".Uat_Expand_city").click(function (e) {
      var showElementDescription = jQuery(this).parents(".expandableCollapsibleDivCity").find("ul");

      if (jQuery(showElementDescription).is(":visible")) {
        showElementDescription.hide("fast", "swing");
		jQuery(this).removeClass('fa-minus');
		jQuery(this).addClass('fa-plus');
      } else {
        showElementDescription.show("fast", "swing");
        jQuery(this).addClass('fa-minus');
		jQuery(this).removeClass('fa-plus');
      }
    });

	Pricerange_Bid_Slider();
	Pricerange_Estiamte_Slider();
	}

	
	jQuery(document).on("click",".bid-popup",function(e){
		e.preventDefault();
	
		popupAuctionId = $(this).attr("data-auction-id");
		 
		showPopUpProduct(auctionId);
		jQuery(".bidplacebox").click();
		// jQuery.fancybox.open(jQuery(".bidplacebox").html());
	});
	
}); /* end of document ready */



function showPopUpProduct(auctionId = ""){
	clearInterval(pupupUpdateInterval);

	if(popupAuctionId){
		var auctionId = popupAuctionId;
		var userId = jQuery("#uat-bid-box-inner").attr('data-user-id')
		var data = {
			action : 'uat_single_product_get_ajax',
			userId : userId,
			p_id : auctionId
		}

		  jQuery.ajax({
			type: 'POST',
			url: UAT_Ajax_Url,
			data: data,
			success: function(response) {

				if(response.product_data){
					product_id = auctionId;
					var auction_type = response.product_data.auction_type;
					var current_bid = response.product_data.current_bid;
					var increase_bid_value = response.product_data.increase_bid_value;
					if(current_bid == ''){
						current_bid = response.product_data.starting_bid;
					}
					jQuery("#uat-bid-box .proxy-bid").hide()
					if(auction_type == 'proxy'){
						jQuery("#uat-bid-box .proxy-bid").show();
						jQuery(".bid_directly_input").attr('data-current-bid',response.product_data.max_bid);
						 
					}
					if(response.product_data.thumb_image!=""){
						var img = '<img src="'+response.product_data.thumb_image+'" width="300">';			 
						jQuery("#pop_img").html(img);
					}
					 
					if(response.product_data.lot_closes!=""){					 		 
						jQuery("#lot_closes").html(response.product_data.lot_closes);
					}
					if(response.product_data.starting_bid_dis!=""){					 		 
						jQuery("#starting_bid_dis").html(response.product_data.starting_bid_display);
					}
					
					
					if(response.product_data.bid_count_msg_dis!=""){					 		 
						jQuery("#bid_count_msg_dis").html(response.product_data.bid_count_msg_dis);
					}
					
					var next_bid="";
					if(auction_type == 'proxy'){
						next_bid=parseInt(response.product_data.max_bid)+parseInt(increase_bid_value);
						 
					}else{
						 next_bid=parseInt(current_bid)+parseInt(increase_bid_value);						
					}
					
					if(next_bid!=""){					 		 
						jQuery("#starting_bid").html(next_bid);
					}
					
					if(response.product_data.next_minimum_bid!=""){
						jQuery("#next_minimum_bid").html(response.product_data.next_minimum_bid_display);						
					}
					
					if(response.product_data.set_your_max_bid_dis!=""){
						jQuery("#set_your_max_bid_dis").html(response.product_data.set_your_max_bid_dis);
					}
					
					
					if(auction_type!="proxy"){						
						jQuery("#max_bid_dis").hide();
						jQuery("#automatic_bid_dis").hide();
					}else{
						jQuery("#max_bid_dis").show();
						jQuery("#automatic_bid_dis").show();
					}
					
					
					
					
					jQuery("#pop_product_title").html(response.product_data.name)
					jQuery("#uat-bid-box .product-current-bid .current-bid").html(response.product_data.current_bid_display)
					jQuery("#uat-bid-box .product-current-bid .increments-value").html(response.product_data.currency_symbol+increase_bid_value)

					var bid_directly_input = jQuery("#uat-bid-box #pop_bid_directly_input").attr('data-auction-id',auctionId);
					bid_directly_input.val("");
					if(auction_type == 'silent'){
						bid_directly_input.attr('step',"");
						bid_directly_input.attr('data-current-bid',"");
						bid_directly_input.attr('min',"");
					}else{
						bid_directly_input.attr('step',increase_bid_value);
						bid_directly_input.attr('data-current-bid',parseFloat(current_bid)+parseFloat(increase_bid_value));
						bid_directly_input.attr('min',next_bid);
					}
					
					

				if(auction_type=="proxy"){
					var max_bid_directly_input = jQuery("#uat-bid-box #pop_max_bid_directly_input").attr('step',increase_bid_value)
					.attr('data-auction-id',auctionId);
					max_bid_directly_input.val("");

					max_bid_directly_input.attr('data-current-bid',parseFloat(current_bid)+parseFloat(increase_bid_value));
					max_bid_directly_input.attr('min',next_bid);
					 
					max_bid_directly_input.attr('data-max-bid',parseFloat(response.product_data.max_bid)+parseFloat(increase_bid_value));
					
				}
					updatePopUpProduct(product_id);
				}
				
				 
			},
				error:function(){

			}
	});
	}
}
function updatePopUpProduct(auctionId = ""){
	pupupUpdateInterval = setInterval(function(){
		getLatestPopUpProduct(auctionId)
	}, 5000);
}
function getLatestPopUpProduct(auctionId = ""){
	if(jQuery(".fancybox-is-open").length == 0){
		clearInterval(pupupUpdateInterval);
		popupAuctionId = "";
		return;
	}

	if(auctionId){
		var userId = jQuery("#uat-bid-box-inner").attr('data-user-id')
		var data = {
			action : 'uat_single_product_get_ajax',
			userId : userId,
			p_id : auctionId
		}

		  jQuery.ajax({
			type: 'POST',
			url: UAT_Ajax_Url,
			data: data,
			success: function(response) {

				if(response.product_data){
					product_id = auctionId;
					var auction_type = response.product_data.auction_type;
					var current_bid = response.product_data.current_bid;
					var increase_bid_value = response.product_data.increase_bid_value;
					if(current_bid == ''){
						current_bid = response.product_data.starting_bid;
					}
					jQuery("#uat-bid-box .proxy-bid").hide()
					if(auction_type == 'proxy'){
						jQuery("#uat-bid-box .proxy-bid").show();
						jQuery(".bid_directly_input").attr('data-current-bid',response.product_data.max_bid);
						 
					}
					if(response.product_data.thumb_image!=""){
						var img = '<img src="'+response.product_data.thumb_image+'" width="300">';			 
						jQuery("#pop_img").html(img);
					}
					 
					if(response.product_data.lot_closes!=""){					 		 
						jQuery("#lot_closes").html(response.product_data.lot_closes);
					}
					if(response.product_data.starting_bid_dis!=""){					 		 
						jQuery("#starting_bid_dis").html(response.product_data.starting_bid_display);
					}
					
					
					if(response.product_data.bid_count_msg_dis!=""){					 		 
						jQuery("#bid_count_msg_dis").html(response.product_data.bid_count_msg_dis);
					}
					
					var next_bid="";
					if(auction_type == 'proxy'){
						next_bid=parseInt(response.product_data.max_bid)+parseInt(increase_bid_value);
						 
					}else{
						 next_bid=parseInt(current_bid)+parseInt(increase_bid_value);						
					}
					
					if(next_bid!=""){					 		 
						jQuery("#starting_bid").html(next_bid);
					}
					
					if(response.product_data.next_minimum_bid!=""){
						jQuery("#next_minimum_bid").html(response.product_data.next_minimum_bid_display);						
					}
					
					if(response.product_data.set_your_max_bid_dis!=""){
						jQuery("#set_your_max_bid_dis").html(response.product_data.set_your_max_bid_dis);
					}
					
					
					if(auction_type!="proxy"){						
						jQuery("#max_bid_dis").hide();
						jQuery("#automatic_bid_dis").hide();
					}else{
						jQuery("#max_bid_dis").show();
						jQuery("#automatic_bid_dis").show();
					}
					
					
					jQuery("#pop_product_title").html(response.product_data.name)
					jQuery("#uat-bid-box .product-current-bid .current-bid").html(response.product_data.current_bid_display)
					jQuery("#uat-bid-box .product-current-bid .increments-value").html(response.product_data.currency_symbol+increase_bid_value)

					var bid_directly_input = jQuery("#uat-bid-box #pop_bid_directly_input").attr('data-auction-id',auctionId);
					 
					if(auction_type == 'silent'){
						bid_directly_input.attr('step',"");
						bid_directly_input.attr('data-current-bid',"");
						bid_directly_input.attr('min',"");
					}else{
						bid_directly_input.attr('step',increase_bid_value);
						bid_directly_input.attr('data-current-bid',parseFloat(current_bid)+parseFloat(increase_bid_value));
						bid_directly_input.attr('min',next_bid);
					}
					
					

				if(auction_type=="proxy"){
					var max_bid_directly_input = jQuery("#uat-bid-box #pop_max_bid_directly_input").attr('step',increase_bid_value)
					.attr('data-auction-id',auctionId);
					 

					max_bid_directly_input.attr('data-current-bid',parseFloat(current_bid)+parseFloat(increase_bid_value));
					max_bid_directly_input.attr('min',next_bid);
					 
					max_bid_directly_input.attr('data-max-bid',parseFloat(response.product_data.max_bid)+parseFloat(increase_bid_value));
					
				}
					 
				}
				
				 
			},
				error:function(){

			}
	});
	}
}

function Pricerange_Estiamte_Slider() {
	//Estiamte Price range
	var low_price_estiamte = jQuery( "#pricerange_estiamte_low" ).val();
	var high_price_estimate = jQuery( "#pricerange_estiamte_high" ).val();
	var currency_symbol = jQuery('.ctm_currency_symbol').val();		
	jQuery("#pricerange-slider-range").slider({		
	  range: true, 
	  min: parseFloat(low_price_estiamte),
	  max: parseFloat(high_price_estimate),
	  //step: 50,
	  values: [ parseFloat(low_price_estiamte),parseFloat(high_price_estimate) ],
	  slide: function( event, ui ) {
		jQuery( "#min-price-estimate").html(ui.values[ 0 ]);
		suffix = '';			
		if (parseFloat(ui.values[ 1 ]) >= parseFloat(high_price_estimate)){			  
		   suffix = ' +';
		}
		jQuery( "#max-price-estimate").html(ui.values[ 1 ] + suffix); 
		
	  },
	change: function( event, ui ) {
		jQuery( "#pricerange_estiamte_price_from" ).val(ui.values[ 0 ]);
		jQuery( "#pricerange_estiamte_price_to" ).val(ui.values[ 1 ] );
		load_Single_Products_serach_result(1);
	} 
	  
	})


}
function Pricerange_Bid_Slider() {
	
		var low_bid = jQuery( "#pricerange_bid_low" ).val();
		var high_bid = jQuery( "#pricerange_bid_high" ).val();		
		jQuery( "#pricerange-bid-slider-range" ).slider({		
		  range: true, 
		  min: parseFloat(low_bid),
		  max: parseFloat(high_bid),
		  //step: 50,
		  values: [ parseFloat(low_bid),parseFloat(high_bid) ],
		  slide: function( event, ui ) {
			jQuery( "#min-price").html(ui.values[ 0 ]);
			suffix = '';			
			if (parseFloat(ui.values[ 1 ]) >= parseFloat(high_bid)){			  
			   suffix = ' +';
			}
			jQuery( "#max-price").html(ui.values[ 1 ] + suffix); 
			
		  },
		change: function( event, ui ) {
			jQuery( "#pricerange_bid_from" ).val(ui.values[ 0 ]);
			jQuery( "#pricerange_bid_to" ).val(ui.values[ 1 ] );
			load_Single_Products_serach_result(1);
		} 
		  
		})
	
}


/*
--------------------------------------------------------
Products Load Function
-----------------------------------------------------------
*/
 var setpage =1;
  var perpage = uat_event_data.perpage;
  var maxsetpage=jQuery("#max_page").val();

function load_Single_Products_serach_result(setpage2){
    var perpage=jQuery("#s_tmp_perpage").val();

	var APPLIED_filtered = reset_filtered_html();
	  if(APPLIED_filtered.length > 0){
		jQuery(".APPLIED_filter").show();
		jQuery(".APPLIED_filtered").html(APPLIED_filtered);
	  } else {
		jQuery(".APPLIED_filter").hide();
	  }

		if(setpage2!=""){
			 setpage=setpage2;
		 }
		 else{
			 setpage=setpage;
		 }

		  jQuery("#loader_ajax").show();
		  jQuery("#ajax_loading_stat").val("loading_ajax");
		  if(setpage==1){
		    // jQuery("#SProductsSearch-results").hide();
			jQuery(".show-more").hide();
		  }

		if (jQuery('.SProductsSearch-results').length < 1) {
		  return false;
		} else {
			    var SPCountries_list = jQuery("input:checkbox.SPCountries:checked").serialize();
				var SPCountries_list = decodeURI(SPCountries_list);

				var SPStates_list = jQuery("input:checkbox.SPStates:checked").serialize();
				var SPStates_list = decodeURI(SPStates_list);

				var SPCities_list = jQuery("input:checkbox.SPCities:checked").serialize();
				var SPCities_list = decodeURI(SPCities_list);
				var product_page_id = jQuery("#product_page_id").val();
 
				jQuery.ajax({
							type: 'POST',
							url: ajaxurl,
							data: {
							action : 'uat_SProductsSearch_Results_ajax',
							perpage : perpage,
							product_page_id : product_page_id,
							setpage : setpage,
							ajax_search_str : jQuery(".ajax_search_str").val(),
							SPCountries : SPCountries_list,
							SPStates :SPStates_list,
							SPCities : SPCities_list,
							p_cat_ids : jQuery("input:checkbox.p_cats:checked").serialize(),
							end_date_by :jQuery("input[name='sort-by-enddate']:checked").val(),
							date_from : jQuery(".from_date").val(),
							date_to : jQuery(".to_date").val(),
							estiamte_price_from: jQuery("#pricerange_estiamte_price_from").val(),
							estiamte_price_to: jQuery("#pricerange_estiamte_price_to").val(),
							bid_price_from: jQuery("#pricerange_bid_from").val(),
							bid_price_to: jQuery("#pricerange_bid_to").val(),
							},
							success: function(response) {
								if(setpage==1){
									jQuery("#SProductsSearch-results").html(response);
									jQuery("#SProductsSearch-results").show();
									 jQuery('body,html').animate({ scrollTop: jQuery('#SProductsSearch-results').offset().top - 140 });
								}else{
									jQuery("#SProductsSearch-results").append(response);
								 }


								jQuery("#loader_ajax").hide();
								jQuery("#ajax_loading_stat").val("");
								
								setpage++;
								 
								
								if(timer_type!='timer_jquery'){
									intclock();
								}else{
									jquery_clock_rebind();
								}
								 
							},
								error:function(){
									jQuery("#loader_ajax").hide();
									// alert("failure");
							}
					});
			}

}


function get_filtered_SPCountries_list(){

	var SPCountries = [];
	  jQuery("input:checkbox.SPCountries:checked").map(function(){
		var obj = {};
		obj['name'] = jQuery(this).data('lname');
		SPCountries.push(obj);
	  });

	return SPCountries;
}
function get_filtered_SPStates_list(){

	var SPStates = [];
	  jQuery("input:checkbox.SPStates:checked").map(function(){
		var obj = {};
		obj['name'] = jQuery(this).data('lname');
		SPStates.push(obj);
	  });

	return SPStates;
}
function get_filtered_SPCities_list(){

	var SPCities = [];
	  jQuery("input:checkbox.SPCities:checked").map(function(){
		var obj = {};
		obj['name'] = jQuery(this).data('lname');
		SPCities.push(obj);
	  });

	return SPCities;
}

function get_filtered_categories_list(){

	var categories = [];
	  jQuery("input:checkbox.p_cats:checked").map(function(){
		var obj = {};
		obj['name'] = jQuery(this).data('lname');
		obj['id'] = jQuery(this).val();
		categories.push(obj);
	  });
	return categories;
}

function get_SPCountries_list_html(){
	var html = '';
	var SPCountries = get_filtered_SPCountries_list();
		if(SPCountries.length > 0){
			var html2 = '<div class="uat-event-SPCountries">';
				html2 += '<ul class="ua-input-group">';
				var html2_elements = '';
				 jQuery.each(SPCountries, function(i, val) {
					var SPCountries_name = val.name;
					SPCountries_name.replace(/\s/g,'');
					html2_elements +=  '<li><a href="javascript:;" class="RemoveSPFilter" data-taxonomy="uat-event-SPCountries" data-value="'+ SPCountries_name +'">'+ val.name +'<i class="fa fa-times"></i></a></li>';

				 });

			html2 += html2_elements;
			html2 += '</ul></div>';
			html +=html2;
		}
	 //console.log(html);
	return html;
}
function get_SPStates_list_html(){
	var html = '';
	var SPStates = get_filtered_SPStates_list();
		if(SPStates.length > 0){
			var html2 = '<div class="uat-event-SPStates">';
				html2 += '<ul class="ua-input-group">';
				var html2_elements = '';
				 jQuery.each(SPStates, function(i, val) {
					var SPStates_name = val.name;
					SPStates_name.replace(/\s/g,'');
					html2_elements +=  '<li><a href="javascript:;" class="RemoveSPFilter" data-taxonomy="uat-event-SPStates" data-value="'+ SPStates_name +'">'+ val.name +'<i class="fa fa-times"></i></a></li>';

				 });

			html2 += html2_elements;
			html2 += '</ul></div>';
			html +=html2;
		}
	 //console.log(html);
	return html;
}
function get_SPCities_list_html(){
	var html = '';
	var SPCities = get_filtered_SPCities_list();
		if(SPCities.length > 0){
			var html2 = '<div class="uat-event-SPCities">';
				html2 += '<ul class="ua-input-group">';
				var html2_elements = '';
				 jQuery.each(SPCities, function(i, val) {
					var SPCities_name = val.name;
					SPCities_name.replace(/\s/g,'');
					html2_elements +=  '<li><a href="javascript:;" class="RemoveSPFilter" data-taxonomy="uat-event-SPCities" data-value="'+ SPCities_name +'">'+ val.name +'<i class="fa fa-times"></i></a></li>';

				 });

			html2 += html2_elements;
			html2 += '</ul></div>';
			html +=html2;
		}
	 //console.log(html);
	return html;
}

function get_categories_list_html(){
	var html = '';
	var categories = get_filtered_categories_list();
		if(categories.length > 0){
			var html2 = '<div class="uat-event-cat">';
				html2 += '<ul class="ua-input-group">';
				var html2_elements = '';
				 jQuery.each(categories, function(i, val) {
					html2_elements +=  '<li><a href="javascript:;" class="RemoveSPFilter" data-taxonomy="uat-event-cat" data-value="'+ val.id +'">'+ val.name +'<i class="fa fa-times"></i></a></li>';
				 });

			html2 += html2_elements;
			html2 += '</ul></div>';
			html +=html2;
		}
	return html;
}
function get_date_range_filtered_html(){
	var html = '';
	var sdate = jQuery(".from_date").val();
	var edate = jQuery(".to_date").val();
	if(sdate!="" && edate!="" ){
		var html2 = '<div class="uat-event-cat">';
		html2 += '<ul class="ua-input-group">';
		var html2_elements = '';
		html2_elements +=  '<li><a href="javascript:;" class="RemoveSPFilter" data-taxonomy="date-range-filtered">'+ sdate +' - '+ edate +'<i class="fa fa-times"></i></a></li>';
		html2 += html2_elements;
		html2 += '</ul></div>';
		html +=html2;
	}

	return html;
}


function reset_filtered_html(){
	var event_page_name ="";
	var event_page_name = jQuery("#event-page-name").val();
	//alert(event_page_name);
	var html = '';
	if(event_page_name !="event-location-page"){
		var SPCountries_list = get_SPCountries_list_html();
			 if(SPCountries_list.length > 0){
				html += SPCountries_list;
			}
	}

	if(event_page_name !="event-location-page"){
		var SPStates_list = get_SPStates_list_html();
			 if(SPStates_list.length > 0){
				html += SPStates_list;
			}
	}
	if(event_page_name !="event-location-page"){
		var SPCities_list = get_SPCities_list_html();
			 if(SPCities_list.length > 0){
				html += SPCities_list;
			}
	}

	if(event_page_name !="event-category-page"){
		var cat_list = get_categories_list_html();
			if(cat_list.length > 0) {
				html += cat_list;
			}
	}

	var date_range = get_date_range_filtered_html();
		if(date_range.length > 0) {
			html += date_range;
		}
	return html;
}

//Pagination Scroll Type for Event list pages
jQuery(document).on('scroll', function() {
	if (jQuery('.SProductsSearch-results').length < 1) {
	  return false;
	} else {
		var products_pagination_type = jQuery("#s_tmp_p_type").val();;
		if(products_pagination_type=="infinite-scroll"){
			var max_page=jQuery('#max_page').val();
			var loading_stat=jQuery("#ajax_loading_stat").val();
			if(jQuery(this).scrollTop()>=jQuery('.show-more-link').position().top-500 && max_page!="hide" && loading_stat!="loading_ajax" ){
			  load_Single_Products_serach_result(setpage);
			}
		}
	}
});