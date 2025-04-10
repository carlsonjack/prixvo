jQuery(document).ready(function ($) {
	UAT_Ajax_Url = UATEVENT.ajaxurl;
	/* --------------------------------------------------------
	 Events Watchlist
	----------------------------------------------------------- */
	jQuery(".uat-watchlist-action").on('click', event_watchlist);
	function event_watchlist(event) {
		var event_id = jQuery(this).data('event-id');
		var currentelement = jQuery(this);
		jQuery.ajax({
			type: 'POST',
			url: UAT_Ajax_Url,
			data: {
				action: 'uat_event_watchlist_action',
				ajax_ICL_LANGUAGE_CODE: wpml_lang_code,
				event_id: event_id,
			},
			success: function (response) {
				currentelement.parent().replaceWith(response);
				jQuery(".uat-watchlist-action").on('click', event_watchlist);
				jQuery(document.body).trigger('uat-watchlist-action', [response, event_id]);
			}
		});
	}
	/* --------------------------------------------------------
	Grid /List view
	----------------------------------------------------------- */
	jQuery('.item i').on('click', function () {
		/*// jQuery(this).toggleClass('fa-plus fa-minus').next().slideToggle()*/
	})
	/* list or grid item*/
	jQuery(".view a").click(function (e) {
		e.preventDefault();
		jQuery('.prod').removeClass('grid-view list-view').addClass($(this).data('view'));
	})
	jQuery(".view a").click(function (e) {
		e.preventDefault();
		jQuery(this).addClass('selected').siblings().removeClass('selected');
	})
	/* --------------------------------------------------------
	Loading Events on Event List Pages
	----------------------------------------------------------- */
	if (jQuery('.EventSearch-results').length > 0) {
		jQuery(".ajax_search_btn").on('click', function () {
			load_events_serach_result(1);
		});
		jQuery(".p_cats").change(function () {
			load_events_serach_result(1);
		});
		jQuery(".eCountries").change(function () {
			load_events_serach_result(1);
		});
		jQuery(".eStates").change(function () {
			load_events_serach_result(1);
		});
		jQuery(".eCities").change(function () {
			load_events_serach_result(1);
		});
		jQuery('.sortbyenddate').on('click', function () {
			load_events_serach_result(1);
		});
		jQuery(document).on('click', '.RemoveFilter', function (evt) {
			evt.preventDefault();
			var taxonomy = jQuery(this).data('taxonomy');
			var ID = jQuery(this).data('value');
			if (taxonomy == "uat-event-eCountries") {
				var eCountries = jQuery(this).data('value');
				eCountries = eCountries.replace(/\s/g, '');
				if (taxonomy == "uat-event-eCountries") {
					jQuery('#eCountries_' + eCountries).prop('checked', false);
					jQuery('#eCountriesM_' + eCountries).prop('checked', false);
				}
			}
			if (taxonomy == "uat-event-eStates") {
				var eStates = jQuery(this).data('value');
				eStates = eStates.replace(/\s/g, '');
				if (taxonomy == "uat-event-eStates") {
					jQuery('#eStates_' + eStates).prop('checked', false);
					jQuery('#eStatesM_' + eCountries).prop('checked', false);
				}
			}
			if (taxonomy == "uat-event-eCities") {
				var eCities = jQuery(this).data('value');
				eCities = eCities.replace(/\s/g, '');
				if (taxonomy == "uat-event-eCities") {
					jQuery('#eCities_' + eCities).prop('checked', false);
					jQuery('#eCitiesM_' + eCountries).prop('checked', false);
				}
			}
			if (taxonomy == "uat-event-cat") {
				jQuery('#cat_' + ID).prop('checked', false);
				jQuery('#catM_' + ID).prop('checked', false);
			}
			if (taxonomy == "date-range-filtered") {
				jQuery(".from_date").val("");
				jQuery(".to_date").val("");
			}
			load_events_serach_result(1);
			return false;
		});
		/*see all Location list in filter hide show*/
		size_li_c = jQuery(".eCountriesList li").size();
		x_country = 10;
		jQuery('.eCountriesList li:lt(' + x_country + ')').show();
		if (x_country >= size_li_c) {
			jQuery('.see_all_eCountries_div').hide();
		}
		jQuery('.see_all_eCountries_btn').click(function () {

			x_country = size_li_c;
			jQuery('.eCountriesList li:lt(' + x_country + ')').show();
			jQuery('.see_all_eCountries_div').hide();
		});
		/*//see all category list in filter hide show*/
		size_li = jQuery(".eCategoryList li").size();
		x = 5;
		jQuery('.eCategoryList li:lt(' + x + ')').show();
		if (x >= size_li) {
			jQuery('.see_all_cats_div').hide();
		}
		jQuery('.see_all_cats_btn').click(function () {

			x = size_li;
			jQuery('.eCategoryList li:lt(' + x + ')').show();
			jQuery('.see_all_cats_div').hide();
		});
		jQuery(document).on('click', '.RemoveFilterall', function (evt) {
			evt.preventDefault();
			var pagename = jQuery("#pagename").val();
			jQuery(".from_date").val("");
			jQuery(".to_date").val("");
			jQuery(".ajax_search_str").val("");
			jQuery('.eCountries').prop('checked', false);
			jQuery('.eStates').prop('checked', false);
			jQuery('.eCities').prop('checked', false);
			if (jQuery(".page_category").length == 0) {
				jQuery('.p_cats').prop('checked', false);
			}
			load_events_serach_result(1);
		});
		jQuery(document).on('click', '.clear-efilter', function (evt) {
			evt.preventDefault();
			var pagename = jQuery("#pagename").val();
			jQuery(".from_date").val("");
			jQuery(".to_date").val("");
			jQuery(".ajax_search_str").val("");
			jQuery('.eCountries').prop('checked', false);
			jQuery('.eStates').prop('checked', false);
			jQuery('.eCities').prop('checked', false);
			if (jQuery(".page_category").length == 0) {
				jQuery('.p_cats').prop('checked', false);
			}
			jQuery(".no-result-found").hide();
			load_events_serach_result(1);
		});
		load_events_serach_result(1);
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
	}
	/* --------------------------------------------------------
	Loading Events Products on event detail Pages
	----------------------------------------------------------- */
	if (jQuery('.Event-ProductsSearch-Results').length > 0) {
		/*//Search Button click*/
		jQuery(".ajax_products_search_btn").on('click', function () {
			load_events_products_serach_result(1);
		});
		/*//Sort By Order By*/
		jQuery('.event_sortby_by').on('change', function () {
			load_events_products_serach_result(1);
		});
		/*// Event Details Tabs*/
		jQuery('#tabs-nav li:first-child').addClass('active');
		jQuery('.tab-content').hide();
		jQuery('.tab-content:first').show();

		jQuery('#tabs-nav li').click(function () {
			jQuery('#tabs-nav li').removeClass('active');
			jQuery(this).addClass('active');
			jQuery('.tab-content').hide();
			var activeTab = jQuery(this).find('a').attr('href');
			jQuery(activeTab).fadeIn();
			return false;
		});
		Pricerange_Bid_Slider_Event();
		Pricerange_Estiamte_Slider_Event();
		/*//Click on clear Filter Button when result not found*/
		jQuery(document).on('click', '.clear-pfilter', function (evt) {
			window.location.reload();
			// evt.preventDefault();
			// jQuery(".no-result-found").hide();
			// var low_bid = jQuery("input#pricerange_bid_low").val();
			// var high_bid = jQuery("input#pricerange_bid_high").val();
			// jQuery("#pricerange-bid-slider-range").slider("values", [parseFloat(low_bid), parseFloat(high_bid)]);
			// jQuery("#min-price").html(low_bid);
			// suffix = '';
			// if (parseFloat(high_bid) >= parseFloat(high_bid)) {
			// 	suffix = ' +';
			// }
			// jQuery("#max-price").html(high_bid + suffix);
			// var low_bid = jQuery("input#pricerange_estiamte_low").val();
			// var high_bid = jQuery("input#pricerange_estiamte_high").val();
			// jQuery("#pricerange-slider-range").slider("values", [parseFloat(low_bid), parseFloat(high_bid)]);
			// jQuery("#min-price-estimate").html(low_bid);
			// suffix = '';
			// if (parseFloat(high_bid) >= parseFloat(high_bid)) {
			// 	suffix = ' +';
			// }
			// jQuery("#max-price-estimate").html(high_bid + suffix);
			// jQuery("#pricerange_bid_from_event").val("");
			// jQuery("#pricerange_bid_to_event").val("");
			// jQuery("#pricerange_estiamte_price_from").val("");
			// jQuery("#pricerange_estiamte_price_to").val("");
			// jQuery(".ajax_products_search_str").val("");
			// load_events_products_serach_result(1);
		});
		jQuery(document).on('click', '.RemovePFilterall', function (evt) {
			window.location.reload();
			// evt.preventDefault();
			// jQuery(".no-result-found").hide();
			// var low_bid = jQuery("input#pricerange_bid_low").val();
			// var high_bid = jQuery("input#pricerange_bid_high").val();
			// jQuery("#pricerange-bid-slider-range").slider("values", [parseFloat(low_bid), parseFloat(high_bid)]);
			// jQuery("#min-price").html(low_bid);
			// suffix = '';
			// if (parseFloat(high_bid) >= parseFloat(high_bid)) {
			// 	suffix = ' +';
			// }
			// jQuery("#max-price").html(high_bid + suffix);
			// var low_bid = jQuery("input#pricerange_estiamte_low").val();
			// var high_bid = jQuery("input#pricerange_estiamte_high").val();
			// jQuery("#pricerange-slider-range").slider("values", [parseFloat(low_bid), parseFloat(high_bid)]);
			// jQuery("#min-price-estimate").html(low_bid);
			// suffix = '';
			// if (parseFloat(high_bid) >= parseFloat(high_bid)) {
			// 	suffix = ' +';
			// }
			// jQuery("#max-price-estimate").html(high_bid + suffix);
			// jQuery("#max-price-estimate").html(high_bid + suffix);
			// jQuery(".ajax_products_search_str").val("");
			// jQuery("#pricerange_estiamte_price_from").val("");
			// jQuery("#pricerange_estiamte_price_to").val("");
			// jQuery("#pricerange_bid_from_event").val("");
			// jQuery("#pricerange_bid_to_event").val("");
			// load_events_products_serach_result(1);
		});
		load_events_products_serach_result(1);
	}
	//Pagination Scroll Type for Event Detail pages
	jQuery(document).on('scroll', function () {
		if (jQuery('.Event-ProductsSearch-Results').length < 1) {
			return false;
		} else {
			var products_pagination_type = uat_event_data.products_pagination_type;
			//alert(products_pagination_type);
			if (products_pagination_type == "infinite-scroll") {
				var max_page = jQuery('#max_page').val();
				var loading_stat = jQuery("#ajax_loading_stat").val();
				if (jQuery(this).scrollTop() >= jQuery('.show-more-link').position().top - 400 && max_page != "hide" && loading_stat != "loading_ajax") {
					load_events_products_serach_result(setpage);
				}
			}
		}
	});
	//Pagination Scroll Type for Event list pages
	jQuery(document).on('scroll', function () {

		if (jQuery('.EventSearch-results').length < 1) {
			return false;
		} else {
			var pagination_type = jQuery("#event_tmp_p_type").val();
			if (pagination_type == "infinite-scroll") {
				var max_page = jQuery('#max_page').val();
				var loading_stat = jQuery("#ajax_loading_stat").val();
				if (jQuery(this).scrollTop() >= jQuery('.show-more-link').position().top - 400 && max_page != "hide" && loading_stat != "loading_ajax") {
					load_events_serach_result(setpage);
				}
			}
		}
	});
}); /* end of document ready */
function Pricerange_Estiamte_Slider_Event() {
	/*Estiamte Price range*/
	var low_price_estiamte = jQuery("#pricerange_estiamte_low").val();
	var high_price_estimate = jQuery("#pricerange_estiamte_high").val();
	var currency_symbol = jQuery('.ctm_currency_symbol').val();
	jQuery("#pricerange-slider-range").slider({
		range: true,
		min: parseFloat(low_price_estiamte),
		max: parseFloat(high_price_estimate),
		//step: 50,
		values: [parseFloat(low_price_estiamte), parseFloat(high_price_estimate)],
		slide: function (event, ui) {
			jQuery("#min-price-estimate").html(ui.values[0]);
			suffix = '';
			if (parseFloat(ui.values[1]) >= parseFloat(high_price_estimate)) {
				suffix = ' +';
			}
			jQuery("#max-price-estimate").html(ui.values[1] + suffix);

		},
		change: function (event, ui) {
			jQuery("#pricerange_estiamte_price_from_event").val(ui.values[0]);
			jQuery("#pricerange_estiamte_price_to_event").val(ui.values[1]);
			load_events_products_serach_result(1);
		}

	})
}
function Pricerange_Bid_Slider_Event() {
	/*Bid Price range*/
	var low_bid = jQuery("#pricerange_bid_low").val();
	var high_bid = jQuery("#pricerange_bid_high").val();
	jQuery("#pricerange-bid-slider-range").slider({
		range: true,
		min: parseFloat(low_bid),
		max: parseFloat(high_bid),
		//step: 50,
		values: [parseFloat(low_bid), parseFloat(high_bid)],
		slide: function (event, ui) {
			jQuery("#min-price").html(ui.values[0]);
			suffix = '';
			if (parseFloat(ui.values[1]) >= parseFloat(high_bid)) {
				suffix = ' +';
			}
			jQuery("#max-price").html(ui.values[1] + suffix);

		},
		change: function (event, ui) {
			jQuery("#pricerange_bid_from_event").val(ui.values[0]);
			jQuery("#pricerange_bid_to_event").val(ui.values[1]);
			load_events_products_serach_result(1);
		}

	})
}
/*
--------------------------------------------------------
Events Load Function
-----------------------------------------------------------
*/
var setpage = 1;
var perpage = jQuery("#event_tmp_perpage").val();
var maxsetpage = jQuery("#max_page").val();

function load_events_serach_result(setpage2) {
	UAT_Ajax_Url = UATEVENT.ajaxurl;
	var perpage = jQuery("#event_tmp_perpage").val();
	var APPLIED_filtered = reset_filtered_html();
	if (APPLIED_filtered.length > 0) {
		jQuery(".APPLIED_filter").show();
		jQuery(".APPLIED_filtered").html(APPLIED_filtered);
	} else {
		jQuery(".APPLIED_filter").hide();
	}
	if (setpage2 != "") {
		setpage = setpage2;
	}
	else {
		setpage = setpage;
	}
	jQuery("#loader_ajax").show();
	jQuery("#ajax_loading_stat").val("loading_ajax");
	if (setpage == 1) {

		jQuery(".show-more").hide();
	}
	if (jQuery('.EventSearch-results').length < 1) {
		return false;
	} else {
		var eCountries_list = jQuery("input:checkbox.eCountries:checked").serialize();
		var eCountries_list = decodeURI(eCountries_list);
		var eStates_list = jQuery("input:checkbox.eStates:checked").serialize();
		var eStates_list = decodeURI(eStates_list);
		var eCities_list = jQuery("input:checkbox.eCities:checked").serialize();
		var eCities_list = decodeURI(eCities_list);
		var event_page_id = jQuery("#event_page_id").val();
		jQuery.ajax({
			type: 'POST',
			url: UAT_Ajax_Url,
			data: {
				action: 'uat_EventSearch_Results_ajax',
				event_page_id: event_page_id,
				perpage: perpage,
				setpage: setpage,
				ajax_search_str: jQuery(".ajax_search_str").val(),
				eCountries: eCountries_list,
				eStates: eStates_list,
				eCities: eCities_list,
				p_cat_ids: jQuery("input:checkbox.p_cats:checked").serialize(),
				end_date_by: jQuery("input[name='sort-by-enddate']:checked").val(),
				date_from: jQuery(".from_date").val(),
				date_to: jQuery(".to_date").val(),
				ajax_ICL_LANGUAGE_CODE: wpml_lang_code,
			},
			success: function (response) {
				if (setpage == 1) {
					jQuery("#EventSearch-results").html(response);
					jQuery("#EventSearch-results").show();
					if (jQuery('#EventSearch-results').length > 0) {
						jQuery('body,html').animate({ scrollTop: jQuery('#EventSearch-results').offset().top - 140 });
					}
				} else {
					jQuery("#EventSearch-results").append(response);
				}
				jQuery("#loader_ajax").hide();
				jQuery("#ajax_loading_stat").val("");
				setpage++;
				if (timer_type != 'timer_jquery') {
					intclock_event();
				} else {
					jquery_clock_rebind();
				}
			},
			error: function () {
				jQuery("#loader_ajax").hide();
				// alert("failure");
			}
		});
	}
}
function get_filtered_eCountries_list() {
	var eCountries = [];
	jQuery("input:checkbox.eCountries:checked").map(function () {
		var obj = {};
		obj['name'] = jQuery(this).data('lname');
		eCountries.push(obj);
	});
	return eCountries;
}
function get_filtered_eStates_list() {
	var eStates = [];
	jQuery("input:checkbox.eStates:checked").map(function () {
		var obj = {};
		obj['name'] = jQuery(this).data('lname');
		eStates.push(obj);
	});
	return eStates;
}
function get_filtered_eCities_list() {
	var eCities = [];
	jQuery("input:checkbox.eCities:checked").map(function () {
		var obj = {};
		obj['name'] = jQuery(this).data('lname');
		eCities.push(obj);
	});
	return eCities;
}
function get_filtered_categories_list() {
	var categories = [];
	jQuery("input:checkbox.p_cats:checked").map(function () {
		var obj = {};
		obj['name'] = jQuery(this).data('lname');
		obj['id'] = jQuery(this).val();
		categories.push(obj);
	});
	return categories;
}

function get_eCountries_list_html() {
	var html = '';
	var eCountries = get_filtered_eCountries_list();
	if (eCountries.length > 0) {
		var html2 = '<div class="uat-event-eCountries">';
		html2 += '<ul class="ua-input-group">';
		var html2_elements = '';
		jQuery.each(eCountries, function (i, val) {
			var eCountries_name = val.name;
			eCountries_name.replace(/\s/g, '');
			html2_elements += '<li><a href="javascript:;" class="RemoveFilter" data-taxonomy="uat-event-eCountries" data-value="' + eCountries_name + '">' + val.name + '<i class="fa fa-times"></i></a></li>';
		});
		html2 += html2_elements;
		html2 += '</ul></div>';
		html += html2;
	}

	return html;
}
function get_eStates_list_html() {
	var html = '';
	var eStates = get_filtered_eStates_list();
	if (eStates.length > 0) {
		var html2 = '<div class="uat-event-eStates">';
		html2 += '<ul class="ua-input-group">';
		var html2_elements = '';
		jQuery.each(eStates, function (i, val) {
			var eStates_name = val.name;
			eStates_name.replace(/\s/g, '');
			html2_elements += '<li><a href="javascript:;" class="RemoveFilter" data-taxonomy="uat-event-eStates" data-value="' + eStates_name + '">' + val.name + '<i class="fa fa-times"></i></a></li>';
		});
		html2 += html2_elements;
		html2 += '</ul></div>';
		html += html2;
	}

	return html;
}
function get_eCities_list_html() {
	var html = '';
	var eCities = get_filtered_eCities_list();
	if (eCities.length > 0) {
		var html2 = '<div class="uat-event-eCities">';
		html2 += '<ul class="ua-input-group">';
		var html2_elements = '';
		jQuery.each(eCities, function (i, val) {
			var eCities_name = val.name;
			eCities_name.replace(/\s/g, '');
			html2_elements += '<li><a href="javascript:;" class="RemoveFilter" data-taxonomy="uat-event-eCities" data-value="' + eCities_name + '">' + val.name + '<i class="fa fa-times"></i></a></li>';
		});
		html2 += html2_elements;
		html2 += '</ul></div>';
		html += html2;
	}

	return html;
}
function get_categories_list_html() {
	var html = '';
	var categories = get_filtered_categories_list();
	if (categories.length > 0) {
		var html2 = '<div class="uat-event-cat">';
		html2 += '<ul class="ua-input-group">';
		var html2_elements = '';
		jQuery.each(categories, function (i, val) {
			html2_elements += '<li><a href="javascript:;" class="RemoveFilter" data-taxonomy="uat-event-cat" data-value="' + val.id + '">' + val.name + '<i class="fa fa-times"></i></a></li>';
		});
		html2 += html2_elements;
		html2 += '</ul></div>';
		html += html2;
	}
	return html;
}
function get_date_range_filtered_html() {
	var html = '';
	var sdate = jQuery(".from_date").val();
	var edate = jQuery(".to_date").val();
	if (sdate != "" && edate != "") {
		var html2 = '<div class="uat-event-cat">';
		html2 += '<ul class="ua-input-group">';
		var html2_elements = '';
		html2_elements += '<li><a href="javascript:;" class="RemoveFilter" data-taxonomy="date-range-filtered">' + sdate + ' - ' + edate + '<i class="fa fa-times"></i></a></li>';
		html2 += html2_elements;
		html2 += '</ul></div>';
		html += html2;
	}
	return html;
}
function reset_filtered_html() {
	var event_page_name = "";
	var event_page_name = jQuery("#event-page-name").val();

	var html = '';
	if (event_page_name != "event-location-page") {
		var eCountries_list = get_eCountries_list_html();
		if (eCountries_list.length > 0) {
			html += eCountries_list;
		}
	}
	if (event_page_name != "event-location-page") {
		var eStates_list = get_eStates_list_html();
		if (eStates_list.length > 0) {
			html += eStates_list;
		}
	}
	if (event_page_name != "event-location-page") {
		var eCities_list = get_eCities_list_html();
		if (eCities_list.length > 0) {
			html += eCities_list;
		}
	}
	if (event_page_name != "event-category-page") {
		var cat_list = get_categories_list_html();
		if (cat_list.length > 0) {
			html += cat_list;
		}
	}
	var date_range = get_date_range_filtered_html();
	if (date_range.length > 0) {
		html += date_range;
	}
	return html;
}
/*
--------------------------------------------------------
Event Detail Lots /prosuct /Items Load Function
-----------------------------------------------------------
*/
var setpage = 1;
var products_perpage = uat_event_data.event_products_perpage;
var maxsetpage = jQuery("#max_page").val();
function load_events_products_serach_result(setpage2) {
	if(jQuery("#loader_ajax").css("display") != 'none'){
		return false;
	}
	var clearFilerBtnText = 'clear-pfilter';
	var estiamte_price_from = jQuery("#pricerange_estiamte_price_from_event").val();
	var estiamte_price_to = jQuery("#pricerange_estiamte_price_to_event").val();
	var bid_price_from = jQuery("#pricerange_bid_from_event").val();
	var bid_price_to = jQuery("#pricerange_bid_to_event").val();
	if (estiamte_price_from != "" || estiamte_price_to != "" || bid_price_from != "" || bid_price_to != "") {
		jQuery("#APPLIED_Pfilter").show();
	} else {
		jQuery("#APPLIED_Pfilter").hide();
	}
	if (jQuery('.Event-ProductsSearch-Results').length < 1) {
		return false;
	} else {
		let ajaxData = {
			action: 'uat_Event_ProductsSearch_Results_ajax',
			perpage: products_perpage,
			setpage: setpage,
			ajax_search_str: jQuery(".ajax_products_search_str").val(),
			event_id: jQuery("#event_id").val(),
			cat_id: jQuery("#cat_id").val(),
			estiamte_price_from: jQuery("#pricerange_estiamte_price_from_event").val(),
			estiamte_price_to: jQuery("#pricerange_estiamte_price_to_event").val(),
			bid_price_from: jQuery("#pricerange_bid_from_event").val(),
			bid_price_to: jQuery("#pricerange_bid_to_event").val(),
			event_sortby_by: jQuery(".event_sortby_by").val(),
			// event_sortby_by: jQuery(".event_sortby_by").find(":selected").val(),
			ajax_ICL_LANGUAGE_CODE: wpml_lang_code,
		}
		if (setpage2 != "") {
			setpage = setpage2;
		} else {
			setpage = setpage;
		}
		
		jQuery("#loader_ajax").show();
		jQuery("#ajax_loading_stat").val("loading_ajax");
		jQuery.ajax({
			type: 'POST',
			url: UAT_Ajax_Url,
			data: ajaxData,
			beforeSend: function() {
				if (setpage == 1) {
					jQuery("#Event-ProductsSearch-Results").html("");
				}
				jQuery("#loader_ajax").show();
				jQuery("#ajax_loading_stat").val("");
			},
			success: function (response) {
				var oldHtml = jQuery("#Event-ProductsSearch-Results").html();
				if (response.includes(clearFilerBtnText)) {
					setpage = 1;
				}
				if (setpage == 1) {
					jQuery("#Event-ProductsSearch-Results").html(response);
					jQuery("#Event-ProductsSearch-Results").show();
				} else {
					jQuery("#Event-ProductsSearch-Results").append(response);
				}
				jQuery("#loader_ajax").hide();
				jQuery("#ajax_loading_stat").val("");

				setpage++;
				if (timer_type != 'timer_jquery') {
					intclock();
				} else {
					jquery_clock_rebind();
				}
			},
			error: function () {
				// alert("failure");
			}
		});
	}
}

